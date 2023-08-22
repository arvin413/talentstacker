<?php
/*
Plugin Name: MTJ Quiz
Description: This is a custom plugin I'm creating.
Version: 1.0
Author: Arvin PB Digital
*/


// define constants
if (!defined('PBD_SA_PATH_CLASS')) {
	define('PBD_SA_PATH_CLASS', dirname(__FILE__) . '/class');
}
if (!defined('PBD_SA_PATH')) {
	define('PBD_SA_PATH', dirname(__FILE__));
}

if ( ! defined( 'PBD_SA_PATH_INCLUDES' ) ) {
	define( 'PBD_SA_PATH_INCLUDES', dirname( __FILE__ ) . '/includes' );
}
if ( ! defined( 'PBD_SA_FOLDER' ) ) {
	define( 'PBD_SA_FOLDER', basename( PBD_SA_PATH ) );

}
if (!defined('PBD_SA_URL')) {
	define('PBD_SA_URL', plugins_url() . '/' . PBD_SA_FOLDER);
}

include_once(PBD_SA_PATH_CLASS . '/pbd-settings.class.php');
include_once(PBD_SA_PATH_CLASS . '/pbd-shortcode.class.php');
// if (is_plugin_active('advanced-custom-fields/acf.php')) {
// 	include_once(PBD_SA_PATH_INCLUDES . '/acf-settings.php');
// }