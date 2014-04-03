<?php
/*-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 - Navgoco Menus Simple Portal jQuery Plugin										       -
 - Copyright 2014 ~ Underdog @ http://webdevelop.comli.com								       -
 - This software package is distributed under the terms of its CC BY 4.0 License: http://creativecommons.org/licenses/by/4.0/  -
 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - --*/
/*
	<id>underdog:navgoco</id>
	<name>Navgoco Menus</name>
	<version>1.3</version>
	<type>modification</type>
*/
/* This file is for adding necessary database entries */
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

global $smcFunc;
db_extend('packages');

// Find the next function_order and add Navgoco as a Simple Portal function
$result = $smcFunc['db_query']('', "
		SELECT function_order, name
		FROM {db_prefix}sp_functions
		ORDER BY function_order ASC"
	);

while ($val = $smcFunc['db_fetch_assoc']($result))
{
	$value[] = intval($val['function_order']);
	if ($val['name'] === 'sp_navgoco')
		break;

	if (count($value) !== (int)$val['function_order'])
	{
		$last = $value[count($value)-2]+1;
		break;
	}
}
$smcFunc['db_free_result']($result);

if (!empty($last))
	$smcFunc['db_insert']('insert',
		'{db_prefix}sp_functions',
		array(
			'function_order' => 'int', 'name' => 'string',
		),
		array(
			$last, 'sp_navgoco',
		),
		array('id_function')
	);

// Add integration hooks
add_integration_function('integrate_pre_include', '$sourcedir/PortalNavgoco.php');
add_integration_function('integrate_pre_load', 'navgoco_admin');
?>