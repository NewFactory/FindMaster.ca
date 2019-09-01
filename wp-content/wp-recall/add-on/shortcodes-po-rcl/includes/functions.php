<?php
//шорктоды.
if (!is_admin()):
    add_action('rcl_enqueue_scripts','private_office_rcl_scripts',10);
endif;
function private_office_rcl_scripts(){
    rcl_enqueue_style('shortcodes-po-rcl',rcl_addon_url('css/style.css', __FILE__));

}
rcl_block('before','private_office_rcl_before');

function private_office_rcl_before (){
	global $rcl_options;
				
		$private_office_rcl_before .= '<style>.office-rcl{background: rgba('.$rcl_options['background_po_before'].');}</style>
        <div class="'.$rcl_options['on_off_private_office_rcl'].'">'.do_shortcode(''.$rcl_options['shortcodes_po_before'].'').'</div>';
					
		return $private_office_rcl_before;
}
rcl_block('top','private_office_rcl_top');

function private_office_rcl_top (){
	global $rcl_options;
				
		$private_office_rcl_top .= '<style>.office-rcl-top2{background: rgba('.$rcl_options['background_po_top'].');}</style>
        <div class="'.$rcl_options['on_off_private_office_rcl'].'"><div class="office-rcl-top"><div class="office-rcl-top2">'.do_shortcode(''.$rcl_options['shortcodes_po_top'].'').'</div></div></div>';
					
		return $private_office_rcl_top;
}