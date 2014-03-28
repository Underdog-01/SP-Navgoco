<?php
// Version: 1.2; SPortalAdminNavgoco

/*-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 - Navgoco Menus Simple Portal jQuery Plugin										       -
 - Copyright 2014 ~ Underdog @ http://webdevelop.comli.com								       -
 - This software package is distributed under the terms of its CC BY 4.0 License: http://creativecommons.org/licenses/by/4.0/  -
 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - --*/

 // block selection
$txt['sp_function_sp_navgoco_label'] = 'Navgoco Board Menu';
$txt['sp_function_sp_navgoco_desc'] = 'Displays a Navgoco style list of boards.';

// parameters
$txt['sp_param_sp_navgoco_boards'] = 'Include boards';
$txt['sp_param_sp_navgoco_board_color'] = 'Category Color';
$txt['sp_param_sp_navgoco_child_color'] = 'Board Color';
$txt['sp_param_sp_navgoco_current_color'] = 'Selected Board Color';
$txt['sp_param_sp_navgoco_board_hover'] = 'Category Hover Color';
$txt['sp_param_sp_navgoco_child_hover'] = 'Board Hover Color';
$txt['sp_param_sp_navgoco_toggle_color'] = 'Toggle Icon Color';
$txt['sp_param_sp_navgoco_expand'] = 'Expand File Name';
$txt['sp_param_sp_navgoco_collapse'] = 'Collapse File Name';
$txt['sp_param_sp_navgoco_direction'] = 'Direction';
$txt['sp_param_sp_navgoco_accordian'] = 'Accordian Display';
$txt['sp_param_sp_navgoco_display'] = 'Display';
$txt['sp_param_sp_navgoco_default'] = 'Default Toggle Icons';

// parameter options
$txt['sp_param_sp_navgoco_display_options'] = 'Full|Compact';
$txt['sp_param_sp_navgoco_direction_options'] = 'left|right';

// help text
global $helptxt;
$helptxt['sp_param_sp_navgoco_boards'] = 'The ID\'s of the boards to be displayed. Use the format of ie. 1|2|3 (no spaces). Leave empty to view all visible boards.';
$helptxt['sp_param_sp_navgoco_board_color'] = 'Enter the text color for categories. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_child_color'] = 'Enter the text color for boards. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_current_color'] = 'Enter the text color of the current opted board. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_board_hover'] = 'Enter the background color for hovering over categories. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_child_hover'] = 'Enter the background color for hovering over boards. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_toggle_color'] = 'Enter the color for default toggle icons. Use name or hex color format for this input.';
$helptxt['sp_param_sp_navgoco_expand'] = 'Enter the file name of the image icon for expanding the category. This file must be available in your custom theme\'s images folder.';
$helptxt['sp_param_sp_navgoco_collapse'] = 'Enter the file name of the image icon for collapsing the category.  This file must be available in your custom theme\'s images folder.';
$helptxt['sp_param_sp_navgoco_direction'] = 'Choose which side for which the text will appear.';
$helptxt['sp_param_sp_navgoco_accordian'] = 'Enabling this option will opt an accordian style Navgoco Menu.';
$helptxt['sp_param_sp_navgoco_display'] = 'Choose whether to display the block as full or compact.  Compact is better suited for side blocks.';
$helptxt['sp_param_sp_navgoco_default'] = 'Enabling this option will ignore the opted image files and use the default Navgoco image icons.';
?>