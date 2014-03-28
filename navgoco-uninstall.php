<?php
/*-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 - Navgoco Menus Simple Portal jQuery Plugin										       -
 - Copyright 2014 ~ Underdog @ http://webdevelop.comli.com								       -
 - This software package is distributed under the terms of its CC BY 4.0 License: http://creativecommons.org/licenses/by/4.0/  -
 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - --*/
/*
	<id>underdog:navgoco</id>
	<name>Navgoco Menus</name>
	<version>1.2</version>
	<type>modification</type>
*/
/* This file is for removing Navgoco database entries */
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

global $smcFunc;
$blockIds = array();

// Delete the Navgoco function from Simple Portal
$smcFunc['db_query']('', "
		DELETE FROM {db_prefix}sp_functions
		WHERE name = {string:navgoco}",
		array('navgoco' => 'sp_navgoco')
	);

// Delete all Navgoco related blocks data
$result = $smcFunc['db_query']('', "
		SELECT id_block
		FROM {db_prefix}sp_blocks
		WHERE type = {string:name}",
		array('name' => 'sp_navgoco')
	);

while ($val = $smcFunc['db_fetch_assoc']($result))
{
	$blockIds[] = (int)$val['id_block'];
}
$smcFunc['db_free_result']($result);

foreach ($blockIds as $blockId)
{
	$smcFunc['db_query']('', "
		DELETE FROM {db_prefix}sp_parameters
		WHERE id_block = {int:blockid}",
		array('blockid' => (int)$blockId)
	);

	$smcFunc['db_query']('', "
		DELETE FROM {db_prefix}sp_blocks
		WHERE id_block = {int:blockid}",
		array('blockid' => (int)$blockId)
	);
}

// Remove Navgoco hooks
remove_integration_function('integrate_pre_include', '$sourcedir/PortalNavgoco.php');
remove_integration_function('integrate_pre_load', 'navgoco_admin');
?>