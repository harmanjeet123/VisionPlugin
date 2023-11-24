<?php
/*
Plugin Name: Purevision
Description: Wordpress EYE Glasses and Lenses Prescription Woocommerce Plugin builds your Eye Glasses and Lenses Website quickly and easily. It features popular Prescription, Select Lenses and their Addons.
Version: 1.0
Author: Softprodigy
Author URI: https://softprodigy.com/
*/

register_activation_hook( __FILE__, 'my_plugin_activation' );

/*
	Activation
*/
function my_plugin_activation() {
  require(dirname(__FILE__). '/activation.php');
}

/*
	admin sidebar menu
*/
add_action('admin_menu', 'gp_create_menu');
function gp_create_menu() {
	require(dirname(__FILE__). '/menu.php');
    
}

$dire = scandir(dirname(__FILE__).'/pages');

foreach ($dire as $key => $files) {
	if ($files != '.' && $files != '..') {
		require(dirname(__FILE__). '/pages/'.$files);
	}

}
/*
image Uploader
*/
require(dirname(__FILE__). '/img_uploader.php');

require(dirname(__FILE__). '/front_layout.php');

/*
create new tab in product data
*/
require(dirname(__FILE__). '/Product_tab.php');

/*
Defining Plugin Folder name 
*/
function Plugin_folder_name(){

	$folder_name = "Purevision";
	
	return $folder_name;
}

/*
Defining Ajax path 
*/
add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
/* admin css */
add_action( 'admin_enqueue_scripts', 'my_admin_style');
function my_admin_style() {
  wp_enqueue_style( 'admin-style',plugins_url( '/style/adminStyle.css' , __FILE__ ) );
}

function debug($arg){
	echo "<pre>";
	print_r($arg);
	echo "</pre>";
}