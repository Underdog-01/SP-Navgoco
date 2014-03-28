<?php
/**********************************************************************************
* Subs-PortalNavgoco.php                                                          *
***********************************************************************************
* Navgoco Menus ~ Simple Portal jQuery Plugin                                 	  *
* Copyright 2014 ~ Underdog @ http://webdevelop.comli.com		          *
* This software package is distributed under the terms of its CC BY 4.0 License   *
* http://creativecommons.org/licenses/by/4.0/					  *
* @version 1.2									  *
**********************************************************************************/
// Navgoco Menus Simple Portal jQuery Plugin Sub-Functions

if (!defined('SMF'))
	die('Hacking attempt...');

// Filter input for hex colors
function navgocoHexColorFilter($color)
{
	if ($color[0] == '#')
		$color = substr($color, 1);

	if (strlen($color) == 6)
		list($r, $g, $b) = array(
			$color[0].$color[1],
			$color[2].$color[3],
			$color[4].$color[5]
		);
	elseif (strlen($color) == 3)
		list($r, $g, $b) = array(
			$color[0].$color[0],
			$color[1].$color[1],
			$color[2].$color[2]
		);
	else
		return false;

	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);
	if (is_array($r) && sizeof($r) == 3)
		list($r, $g, $b) = $r;

	$r = intval($r);
	$g = intval($g);
	$b = intval($b);

	$r = dechex($r<0?0:($r>255?255:$r));
	$g = dechex($g<0?0:($g>255?255:$g));
	$b = dechex($b<0?0:($b>255?255:$b));

	$color = (strlen($r) < 2?'0':'') . $r;
	$color .= (strlen($g) < 2?'0':'') . $g;
	$color .= (strlen($b) < 2?'0':'') . $b;
	return $color;
}

// Filter input for named colors
function navgocoColorFilter($color)
{
	// standard 147 HTML color names
	$colors = array(
		'aliceblue'=>'f0f8ff',
	        'antiquewhite'=>'faebd7',
	        'aqua'=>'00ffff',
	        'aquamarine'=>'7fffd4',
	        'azure'=>'f0ffff',
	        'beige'=>'f5f5dc',
	        'bisque'=>'ffe4c4',
	        'black'=>'000000',
	        'blanchedalmond '=>'ffebcd',
	        'blue'=>'0000ff',
	        'blueviolet'=>'8a2be2',
	        'brown'=>'a52a2a',
	        'burlywood'=>'deb887',
	        'cadetblue'=>'5f9ea0',
	        'chartreuse'=>'7fff00',
	        'chocolate'=>'d2691e',
	        'coral'=>'ff7f50',
	        'cornflowerblue'=>'6495ed',
	        'cornsilk'=>'fff8dc',
	        'crimson'=>'dc143c',
	        'cyan'=>'00ffff',
	        'darkblue'=>'00008b',
	        'darkcyan'=>'008b8b',
	        'darkgoldenrod'=>'b8860b',
	        'darkgray'=>'a9a9a9',
	        'darkgreen'=>'006400',
	        'darkgrey'=>'a9a9a9',
	        'darkkhaki'=>'bdb76b',
	        'darkmagenta'=>'8b008b',
	        'darkolivegreen'=>'556b2f',
	        'darkorange'=>'ff8c00',
	        'darkorchid'=>'9932cc',
	        'darkred'=>'8b0000',
	        'darksalmon'=>'e9967a',
	        'darkseagreen'=>'8fbc8f',
	        'darkslateblue'=>'483d8b',
	        'darkslategray'=>'2f4f4f',
	        'darkslategrey'=>'2f4f4f',
	        'darkturquoise'=>'00ced1',
	        'darkviolet'=>'9400d3',
	        'deeppink'=>'ff1493',
	        'deepskyblue'=>'00bfff',
	        'dimgray'=>'696969',
	        'dimgrey'=>'696969',
	        'dodgerblue'=>'1e90ff',
	        'firebrick'=>'b22222',
	        'floralwhite'=>'fffaf0',
	        'forestgreen'=>'228b22',
	        'fuchsia'=>'ff00ff',
	        'gainsboro'=>'dcdcdc',
	        'ghostwhite'=>'f8f8ff',
	        'gold'=>'ffd700',
	        'goldenrod'=>'daa520',
	        'gray'=>'808080',
	        'green'=>'008000',
	        'greenyellow'=>'adff2f',
	        'grey'=>'808080',
	        'honeydew'=>'f0fff0',
	        'hotpink'=>'ff69b4',
	        'indianred'=>'cd5c5c',
	        'indigo'=>'4b0082',
	        'ivory'=>'fffff0',
	        'khaki'=>'f0e68c',
	        'lavender'=>'e6e6fa',
	        'lavenderblush'=>'fff0f5',
	        'lawngreen'=>'7cfc00',
	        'lemonchiffon'=>'fffacd',
	        'lightblue'=>'add8e6',
	        'lightcoral'=>'f08080',
	        'lightcyan'=>'e0ffff',
	        'lightgoldenrodyellow'=>'fafad2',
	        'lightgray'=>'d3d3d3',
	        'lightgreen'=>'90ee90',
	        'lightgrey'=>'d3d3d3',
	        'lightpink'=>'ffb6c1',
	        'lightsalmon'=>'ffa07a',
	        'lightseagreen'=>'20b2aa',
	        'lightskyblue'=>'87cefa',
	        'lightslategray'=>'778899',
	        'lightslategrey'=>'778899',
	        'lightsteelblue'=>'b0c4de',
	        'lightyellow'=>'ffffe0',
	        'lime'=>'00ff00',
	        'limegreen'=>'32cd32',
	        'linen'=>'faf0e6',
	        'magenta'=>'ff00ff',
	        'maroon'=>'800000',
	        'mediumaquamarine'=>'66cdaa',
	        'mediumblue'=>'0000cd',
	        'mediumorchid'=>'ba55d3',
	        'mediumpurple'=>'9370d0',
	        'mediumseagreen'=>'3cb371',
	        'mediumslateblue'=>'7b68ee',
	        'mediumspringgreen'=>'00fa9a',
	        'mediumturquoise'=>'48d1cc',
	        'mediumvioletred'=>'c71585',
	        'midnightblue'=>'191970',
	        'mintcream'=>'f5fffa',
	        'mistyrose'=>'ffe4e1',
	        'moccasin'=>'ffe4b5',
	        'navajowhite'=>'ffdead',
	        'navy'=>'000080',
	        'oldlace'=>'fdf5e6',
	        'olive'=>'808000',
	        'olivedrab'=>'6b8e23',
	        'orange'=>'ffa500',
	        'orangered'=>'ff4500',
	        'orchid'=>'da70d6',
	        'palegoldenrod'=>'eee8aa',
	        'palegreen'=>'98fb98',
	        'paleturquoise'=>'afeeee',
	        'palevioletred'=>'db7093',
	        'papayawhip'=>'ffefd5',
	        'peachpuff'=>'ffdab9',
	        'peru'=>'cd853f',
	        'pink'=>'ffc0cb',
	        'plum'=>'dda0dd',
	        'powderblue'=>'b0e0e6',
	        'purple'=>'800080',
	        'red'=>'ff0000',
	        'rosybrown'=>'bc8f8f',
	        'royalblue'=>'4169e1',
	        'saddlebrown'=>'8b4513',
	        'salmon'=>'fa8072',
	        'sandybrown'=>'f4a460',
	        'seagreen'=>'2e8b57',
	        'seashell'=>'fff5ee',
	        'sienna'=>'a0522d',
	        'silver'=>'c0c0c0',
	        'skyblue'=>'87ceeb',
	        'slateblue'=>'6a5acd',
	        'slategray'=>'708090',
	        'slategrey'=>'708090',
	        'snow'=>'fffafa',
	        'springgreen'=>'00ff7f',
	        'steelblue'=>'4682b4',
	        'tan'=>'d2b48c',
	        'teal'=>'008080',
	        'thistle'=>'d8bfd8',
	        'tomato'=>'ff6347',
	        'turquoise'=>'40e0d0',
	        'violet'=>'ee82ee',
	        'wheat'=>'f5deb3',
	        'white'=>'ffffff',
	        'whitesmoke'=>'f5f5f5',
	        'yellow'=>'ffff00',
	        'yellowgreen'=>'9acd32'
	);

	$color = strtolower($color);
	if (!empty($colors[$color]))
		return ('#' . $colors[$color]);
	elseif ($returnColor = navgocoHexColorFilter($color))
		return '#' . $returnColor;

	return '';
}

// Check for valid image files
function navgocoCheckImage($image = array('expand' => 'expand.gif'))
{
	global $settings;

	$key = key($image);
	$file = navgocoSanitizeFileName($image[$key]);

	if (navgocoFileTypes($file) && @file_exists($settings['theme_dir'] . '/images/' . $file))
		return $file;

	return $key . '.gif';
}

// Check for valid file types
function navgocoFileTypes($file = '')
{
	foreach (array('.gif', '.jpg', '.jpeg', '.png') as $filetype)
	{
		if (strripos($file, $filetype) !== false)
			return true;
	}

	return false;
}

// Sanitize file names
function navgocoSanitizeFileName($filename)
{
        $filename_raw = $filename;
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
        $filename = str_replace($special_chars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');

        $parts = explode('.', $filename);

        if (count($parts) <= 2)
		return $filename;

        $filename = array_shift($parts);
        $extension = array_pop($parts);
        $mimes = array('jpg', 'gif', 'png', 'jpeg');

	foreach ((array)$parts as $part)
	{
		$filename .= '.' . $part;

		if (preg_match("/^[a-zA-Z]{2,5}\d?$/", $part))
		{
			$allowed = false;
		        foreach ($mimes as $ext_preg => $mime_match)
			{
				$ext_preg = '!^(' . $ext_preg . ')$!i';
				if (preg_match($ext_preg, $part))
				{
					$allowed = true;
					break;
				}
			}
			if (!$allowed)
				$filename .= '_';
		}
	}

	$filename .= '.' . $extension;

	return $filename;
}
?>