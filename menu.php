<?php
/**
     * Menu
*/

//add menu in admin panel 
add_menu_page('PureVision','PureVision','manage_options','PureVision','add_lens_form','dashicons-visibility','10');

//add submenus
add_submenu_page('null','Add Lens Type','Add Lens Type','manage_options','PureVision','add_lens_form');

add_submenu_page('PureVision','Lens Type','Lens Type','manage_options','lens_types','lens_type');

add_submenu_page('null','Add lens Finish','Add lens Finish','manage_options','Add_lens_finish','add_lens_finish');

add_submenu_page('PureVision','Lens Finish','Lens Finish','manage_options','List_lens_option','lens_option');

add_submenu_page('null','Add Lens Material','Add Lens Material','manage_options','lens_material','add_lens_thickness_form');

add_submenu_page('PureVision','Lens Material','Lens Material','manage_options','lens_material_type','lens_thickness_list');

add_submenu_page('null','Add Lens Choose','Add Lens Choose','manage_options','add_lens_Choose','add_lens_Choose');

add_submenu_page('PureVision','Lens Choose','Lens Choose','manage_options','lens_choose','list_choose_lens');

// add_submenu_page('null','Add Lens Choose','Add Lens Choose','manage_options','add_lens_profile','add_lens_profile');

// add_submenu_page('PureVision','Lens Profile','Lens Profile','manage_options','lens_profile','list_lens_profile');

add_submenu_page('null','Add Lens Tint','Add Lens Tint','manage_options','add_lens_tint','add_lens_tint');

add_submenu_page('PureVision','Tint Color','Tint Color','manage_options','lens_tint','list_lens_tint');
add_submenu_page('null','Add Tint Density','Add Tint Density','manage_options','add_tint_density','add_tint_density');
add_submenu_page('PureVision','Tint Density','Tint Density','manage_options','tint_density','tint_density');

?>