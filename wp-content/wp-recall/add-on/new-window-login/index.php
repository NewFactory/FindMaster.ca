<?php
//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	index.php																				//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

//подключение файлов 
require_once("includes/settings.php");
require_once("includes/functions.php");

//подключение стилей и скриптов страницы настроек
function register_nwl_admin_style( $hook ) {
	if( is_admin() ) { 
		wp_enqueue_style( 'nwl_admin_style', rcl_addon_url ('css/nwl-admin-style.css', __FILE__) );
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script( 'nwl_js_admin', rcl_addon_url( 'js/nwl_js_admin_style.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	}
}
add_action( 'admin_enqueue_scripts', 'register_nwl_admin_style' );

