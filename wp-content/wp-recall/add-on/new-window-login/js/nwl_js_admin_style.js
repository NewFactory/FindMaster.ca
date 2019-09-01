//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	js/nwl_js_admin_style.js																//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

(function( $ ) {
    $(function() {
		
//None tempelate	
	$( 'input[name="global[nwl_style_none_tempelate_border_color]"]' ).wpColorPicker({
		defaultColor: '#CCCCCC'
	});
	
	$( 'input[name="global[nwl_style_none_tempelate_background_form]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});	

	$( 'input[name="global[nwl_style_none_tempelate_color_text]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});

	$( 'input[name="global[nwl_style_none_tempelate_color_button]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});	

	$( 'input[name="global[nwl_style_none_tempelate_color_button_hover]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});

	$( 'input[name="global[nwl_style_none_tempelate_color_button_text]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});

	$( 'input[name="global[nwl_style_none_tempelate_color_uri]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});	

	$( 'input[name="global[nwl_style_none_tempelate_color_uri_hover]"]' ).wpColorPicker({
		defaultColor: '#0000'
	});

	$( 'input[name="global[nwl_style_none_tempelate_background_site]"]' ).wpColorPicker({
		defaultColor: '#1E384B'
	});
	
//Full Pop		
	$( 'input[name="global[nwl_style_full_pop_background_form]"]' ).wpColorPicker({
		defaultColor: '#3B8DBD'
	});
		
	$( 'input[name="global[nwl_style_full_pop_color_text]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});
	
	$( 'input[name="global[nwl_style_full_pop_color_uri]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});
		
	$( 'input[name="global[nwl_style_full_pop_color_uri_hover]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});
	
//Hueman		
	$( 'input[name="global[nwl_style_hueman_background_form]"]' ).wpColorPicker({
		defaultColor: '#F1F1F1'
	});
	
	$( 'input[name="global[nwl_style_hueman_border_color]"]' ).wpColorPicker({
		defaultColor: '#DDDDDD'
	});
	
	$( 'input[name="global[nwl_style_hueman_color_text]"]' ).wpColorPicker({
		defaultColor: '#777777'
	});
	
	$( 'input[name="global[nwl_style_hueman_color_button]"]' ).wpColorPicker({
		defaultColor: '#3B8DBD'
	});
	
	$( 'input[name="global[nwl_style_hueman_color_button_hover]"]' ).wpColorPicker({
		defaultColor: '#444444'
	});

	$( 'input[name="global[nwl_style_hueman_color_button_text]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});
		
	$( 'input[name="global[nwl_style_hueman_color_uri]"]' ).wpColorPicker({
		defaultColor: '#777777'
	});
	
	$( 'input[name="global[nwl_style_hueman_color_uri_hover]"]' ).wpColorPicker({
		defaultColor: '#444444'
	});

	
//Sparkling
	$( 'input[name="global[nwl_style_sparkling_background_form]"]' ).wpColorPicker({
		defaultColor: '#F8F8F8'
	});
	
	$( 'input[name="global[nwl_style_sparkling_color_title]"]' ).wpColorPicker({
		defaultColor: '#FE4253'
	});
	
	$( 'input[name="global[nwl_style_sparkling_color_text]"]' ).wpColorPicker({
		defaultColor: '#6B6B6B'
	});
	
	$( 'input[name="global[nwl_style_sparkling_color_button]"]' ).wpColorPicker({
		defaultColor: '#DA4453'
	});
		
	$( 'input[name="global[nwl_style_sparkling_color_button_hover]"]' ).wpColorPicker({
		defaultColor: '#333333'
	});
		
	$( 'input[name="global[nwl_style_sparkling_color_button_text]"]' ).wpColorPicker({
		defaultColor: '#FFFFFF'
	});
	
	$( 'input[name="global[nwl_style_sparkling_color_uri]"]' ).wpColorPicker({
		defaultColor: '#DA4453'
	});

	$( 'input[name="global[nwl_style_sparkling_color_uri_hover]"]' ).wpColorPicker({
		defaultColor: '#B9B9B9'
	});
		
    });
})( jQuery );
