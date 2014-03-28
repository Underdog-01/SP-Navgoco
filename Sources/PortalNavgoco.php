<?php
/**********************************************************************************
* PortalNavgoco.php                                                               *
***********************************************************************************
* Navgoco Menus ~ Simple Portal jQuery Plugin                                 	  *
* Copyright 2014 ~ Underdog @ http://webdevelop.comli.com		          *
* This software package is distributed under the terms of its CC BY 4.0 License   *
* http://creativecommons.org/licenses/by/4.0/					  *
* @version 1.2									  *
**********************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');

// Navgoco Menus Simple Portal jQuery Plugin Functions
function navgoco_admin()
{
	global $txt;
	loadLanguage('SPortalAdminNavgoco');
}

// Filter Navgoco $_POST data
function navgoco_filter($post)
{
	global $sourcedir;
	require_once($sourcedir . '/Subs-PortalNavgoco.php');

	$parameterVariables = array('board_color', 'child_color', 'current_color', 'board_hover', 'child_hover', 'toggle_color', 'expand', 'collapse');

	foreach ($parameterVariables as $variable)
	{
		if (!empty($post['parameters'][$variable]) && $variable === 'expand')
			$post['parameters'][$variable] = navgocoCheckImage(array('expand' => $post['parameters'][$variable]));
		elseif (!empty($post['parameters'][$variable]) && $variable === 'collapse')
			$post['parameters'][$variable] = navgocoCheckImage(array('collapse' => $post['parameters'][$variable]));
		elseif (!empty($post['parameters'][$variable]))
			$post['parameters'][$variable] = navgocoColorFilter($post['parameters'][$variable]);
	}

	return $post;
}

// Navgoco Admin Settings
function sp_navgoco($parameters, $id, $return_parameters = false)
{
	global $txt, $scripturl, $settings, $context, $color_profile, $helptxt;

	$block_parameters = array(
		'boards' => 'boards',
		'board_color' => 'text',
		'child_color' => 'text',
		'current_color' => 'text',
		'board_hover' => 'text',
		'child_hover' => 'text',
		'toggle_color' => 'text',
		'expand' => 'text',
		'collapse' => 'text',
		'direction' => 'select',
		'display' => 'select',
		'accordian' => 'check',
		'default' => 'check',
	);

	if ($return_parameters)
	{
		// Display default values for a new Navgoco block
		if (empty($_REQUEST['block_id']))
		{
			$parameterVariables = array(
				'board_color' => '#5f9ea0',
				'child_color' => '#808080',
				'current_color' => '#40e0d0',
				'board_hover' => '#Bc5bc9',
				'child_hover' => '#f9d26d',
				'toggle_color' => '#4169e1',
				'expand' => 'expand.gif',
				'collapse' => 'collapse.gif',
				'accordian' => 1,
			);

			$content = '
	<script type="text/javascript"><!-- // --><![CDATA[
		window.onload = function()
		{';
			foreach ($parameterVariables as $variable => $default)
			{
				$content .= '
			document.getElementById("' . $variable . '").value="' . $default . '";';
			}

			$content .= '
			navgocoToggleSetting();
			document.getElementById("default").onclick = function(){return navgoco_preview();};
		}
	// ]]></script>';
			$context['html_headers'] .= $content;
		}
		else
		{
			$content = '
	<script type="text/javascript"><!-- // --><![CDATA[
		window.onload = function()
		{
			navgocoToggleSetting();
			document.getElementById("default").onclick = function(){return navgoco_preview();};
		}
	// ]]></script>';
			$context['html_headers'] .= $content;
		}

		$moreContent = '
	<script type="text/javascript"><!-- // --><![CDATA[
		function navgocoToggleSetting()
		{
			var navgoco_param = document.getElementById("default");
			var navgoco_labels = document.getElementsByTagName("label");
			if (navgoco_param.checked == true)
			{
				for (i=0; i<navgoco_labels.length; i++)
				{
					if (navgoco_labels[i].htmlFor === "expand" || navgoco_labels[i].htmlFor === "collapse")
						navgoco_labels[i].parentNode.style.display = "none";
				}

				document.getElementById("expand").parentNode.style.display = "none";
				document.getElementById("collapse").parentNode.style.display = "none";
			}
			else
			{
				for (i=0; i<navgoco_labels.length; i++)
				{
					if (navgoco_labels[i].htmlFor === "toggle_color")
						navgoco_labels[i].parentNode.style.display = "none";
				}

				document.getElementById("toggle_color").parentNode.style. display ="none";
			}
		}
		function navgoco_preview()
		{
			document.getElementsByName("preview_block")[0].click(true);
		}
	// ]]></script>';

		$context['html_headers'] .= $moreContent;
		return $block_parameters;
	}

	$boards = !empty($parameters['boards']) ? explode('|', $parameters['boards']) : null;
	$display = empty($parameters['display']) ? 'full' : 'compact';

	navgoco_menu($parameters, $boards, $display, 18, 'echo');

}

// Navgoco Menus Simple Portal jQuery Plugin
function navgoco_menu($parameters, $view_boards, $display, $compactChars, $show='echo')
{
	global $cat_tree, $boards, $boardList, $scripturl, $sourcedir, $smcFunc, $settings, $txt;

	$css = navgocoStyleFile();
	$catchId = array();
	$class = !empty($parameters['class']) ? ' ' . $parameters['class'] : '';
	$direction = (!empty($parameters['direction'])) && (int)$parameters['direction'] == 1 ? 'right' : 'left';
	$currentBoard = !empty($_REQUEST['board']) ? (int)$_REQUEST['board'] : 0;
	$defaultIcons = !empty($parameters['default']) ? true : false;
	$defaultColor = !empty($parameters['toggle_color']) ? 'color:' . $parameters['toggle_color'] . ';' : '';

	if ($css === 'success')
		$cssFile = $settings['theme_url'] . '/css/jquery.navgoco.css';
	elseif ($css === 'default')
		$cssFile = $settings['default_theme_url'] . '/css/jquery.navgoco.css';
	else
		fatal_error($css, false);

	$content = '
<script type="text/javascript"><!-- // --><![CDATA[
	var link = document.createElement("link");
	link.href = "' . $cssFile . '";
	link.rel = "stylesheet";
	link.type = "text/css";
	link.media = "screen";
	document.getElementsByTagName("head")[0].appendChild(link);
// ]]></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/jquery.navgoco.cookie.js"></script>
<script type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/jquery.navgoco.js"></script>';

	require_once($sourcedir . '/Subs-Boards.php');

	getBoardTree();

	$temp_boards = $boards;

	$request = $smcFunc['db_query']('', '
		SELECT b.id_board
		FROM {db_prefix}boards AS b
		WHERE !({query_see_board})');

	while ($row = $smcFunc['db_fetch_assoc']($request))
		unset($temp_boards[$row['id_board']]);

	$smcFunc['db_free_result']($request);

	foreach ($boards as $key => $view)
		if ((!empty($view_boards)) && !in_array($key, $view_boards))
		    unset($temp_boards[$key]);

	if (empty($cat_tree))
	{
		echo $txt['error_no_boards_selected'];
		return false;
	}

	if (!empty($cat_tree))
		$content .= '
<ul id="mynavgoco_menu" class="nav" style="text-align:' . $direction . ';">';

	foreach ($cat_tree as $catid => $tree)
	{
		$content .= '
	<li>
		<a onmouseover="changeNavgocoBg(\'navgoco' . $catid . '\')" onmouseout="changeNavgocoNoBg(\'navgoco' . $catid . '\')" class="navgoco_xlinks' . $class . '" id="navgoco' . $catid . '" href="' . $scripturl . '?action=forum#c' . $tree['node']['id'] . '"><strong ' . (!empty($parameters['board_color']) ? 'style="display:inline-block;color:' . $parameters['board_color'] . ';" ' : '') . '>' . ($display === 'full' ? $tree['node']['name'] : substr($tree['node']['name'], 0, (int)$compactChars) . (strlen($tree['node']['name']) > (int)$compactChars ? '...' : '')) . '</strong></a>';

		if (!empty($boardList[$catid]))
		{
			$content .= '
		<ul>';

			foreach ($boardList[$catid] as $key => $boardid)
			{
				if (empty($temp_boards[$boardid]))
					continue;

				$catchId[] = array('id' => 'navgoco' . $catid);
				$current_level = $boards[$boardid]['level'];
				$next_level = isset($boardList[$catid][$key + 1]) ? $boards[$boardList[$catid][$key + 1]]['level'] : -1;
				$boardColor = (!empty($currentBoard) && !empty($parameters['current_color'])) && $currentBoard == $boardid ? 'style="color:' . $parameters['current_color'] . ';" ' : '';

				$content .= '
			<li>
				<a ' . $boardColor . 'id="b_navgoco' . $boardid . '" onmouseover="changeNavgocoBg(\'b_navgoco' . $boardid . '\')" onmouseout="changeNavgocoNoBg(\'b_navgoco' . $boardid . '\')" ' . (!empty($parameters['child_color']) ? 'style="color:' . $parameters['child_color'] . ';" ' : '') . 'href="' . $scripturl . '?board=' . $boards[$boardid]['id'] . '">' . ($display === 'full' ? $boards[$boardid]['name'] : substr($boards[$boardid]['name'], 0, (int)$compactChars) . (strlen($boards[$boardid]['name']) > (int)$compactChars ? '...' : '')) . '</a>';

				if ($next_level > $current_level)
					$content .= '
				<ul>';
				else
					$content .= '
			</li>';

				if ($next_level < $current_level && $current_level != 0)
					$content .= '
				</ul>
			</li>';
				elseif ($next_level > $current_level)
					$content .= '
			</li>';
			}

			$content .= '
		</ul>';
		}

		$content .= '
	</li>';
	}

	if (!empty($cat_tree))
		$content .= '
</ul>';

	$content .= '
<script type="text/javascript"><!-- // --><![CDATA[
	$(document).ready(function() {
	$("#mynavgoco_menu").navgoco({' . (empty($parameters['accordian']) ? 'accordion: true' : 'accordion: false') . '});
	});
	function changeNavgocoBg(el)
	{
		var changeBg = document.getElementById(el);
		if (el.substring(0,2) === "b_")
			color = "' . (!empty($parameters['child_hover']) ? $parameters['child_hover'] : '') . '";
		else
			color = "' . (!empty($parameters['board_hover']) ? $parameters['board_hover'] : '') . '";

		changeBg.style.backgroundColor = color;

	}
	function changeNavgocoNoBg(el)
	{
		var changeBg = document.getElementById(el);
		changeBg.style.backgroundColor = "";
	}
// ]]></script>';

	$content .= navgocoCustomOptions($parameters['expand'], $parameters['collapse'], $direction, $catchId, $defaultIcons, $defaultColor);

	if ($show === 'echo')
		echo $content;

	return $content;
}

// Onclick custom images
function navgocoCustomOptions($expand = 'expand.gif', $collapse = 'collapse.gif', $direction, $catchId, $defaultIcons, $defaultColor)
{
	global $settings;

	$float = $direction === 'left' ? 'right' : 'left';
	$content = '
<script type="text/javascript"><!-- // --><![CDATA[
	var img_array = ' . json_encode($catchId) . ';
	$(document).ready(function() {';


	foreach ($catchId as $id)
	{
		if (!$defaultIcons)
			$content .= '
		var $new_span = $("#' . $id['id'] . ' span");
		var imgx = "imgs_' . $id['id'] . '";
		$new_span.attr("id", "span_' . $id['id'] . '");
		$new_span.attr("style", "float:' . $float. ';");
		$new_span.html(\'<img alt="" style="position:relative;" id="imgs_' . $id['id'] . '" onclick="changeNavgocoToggle(event.currentTarget.id, img_array);" src="' . $settings['theme_url'] . '/images/' . $expand . '" />\');
		';
		else
			$content .= '
		var $new_span = $("#' . $id['id'] . ' span");
		$new_span.attr("id", "span_' . $id['id'] . '");
		$new_span.attr("style", "float:' . $float. ';' . $defaultColor . '");
		$new_span.attr("class", "navgoco_def");
		';
	}

	$content .= '
	});

	function changeNavgocoToggle(myid, imgArray)
	{
		var el = document.getElementById(myid);
		if (el.src === "' . $settings['theme_url'] . '/images/' . $expand . '")
			el.src = "' . $settings['theme_url'] . '/images/' . $collapse . '";
		else
			el.src = "' . $settings['theme_url'] . '/images/' . $expand . '";

		for (nava=1; nava<imgArray.length; nava++)
		{
			var back = "imgs_navgoco" + nava;
			if (myid !== back)
				document.getElementById(back).src = "' . $settings['theme_url'] . '/images/' . $expand . '";
		}
	}
// ]]></script>';

	return $content;
}

// CSS file must be available within the custom/default theme css directory
function navgocoStyleFile()
{
	global $settings, $txt;

	if (@file_exists($settings['theme_dir'] . '/css/jquery.navgoco.css'))
		return 'success';

	if (!@file_exists($settings['default_theme_dir'] . '/css/jquery.navgoco.css'))
		return str_replace('%1$s', 'jquery.navgoco.css', $txt['admin_file_not_found']);

	if (@copy($settings['default_theme_dir'] . '/css/jquery.navgoco.css', $settings['theme_dir'] . '/css/jquery.navgoco.css'))
		return 'success';

	return 'default';

}
?>