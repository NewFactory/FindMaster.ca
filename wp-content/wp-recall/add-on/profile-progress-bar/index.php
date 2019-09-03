<?php
if (!defined('ABSPATH')) exit;

require_once("settings/settings.php");
require_once("includes/function.php");
//require_once("includes/subtab.php");

if (!is_admin()):
    add_action('rcl_enqueue_scripts','profile_progress__scripts',10);
endif;
function profile_progress__scripts(){
   rcl_enqueue_style('profile-progress-bar',rcl_addon_url('css/style.css', __FILE__));

}

add_action( 'admin_enqueue_scripts', 'add_color_picker_progress' );
function add_color_picker_progress( $hook ) {
	if( is_admin() ) { 
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( 'profile_progress_bar', rcl_addon_url( 'js/profile-progress-bar.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	}
}