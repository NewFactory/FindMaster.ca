<?php

if ( is_admin() )
	require_once 'admin/index.php';

if ( ! is_admin() ):
//add_action('rcl_enqueue_scripts','chvr_scripts',10);
endif;

function chvr_scripts() {
	rcl_enqueue_style( 'chat-viewer', rcl_addon_url( 'style.css', __FILE__ ) );
}
