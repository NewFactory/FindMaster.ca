<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	includes/functions.php																	//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

//подключение css Widget RCL
function register_nwl_styles() {	
	global $rcl_options;
	
$custom_css = ' ';	
		
		if($rcl_options['nwl_options_style']=='none_tempelate'){		
			wp_register_style( 'nwl_style', $custom_css );
			
$width_form = $rcl_options['nwl_style_none_tempelate_width'];
$height_form = $rcl_options['nwl_style_none_tempelate_height'];
$division = '2';
$result_width_form = $width_form / $division ; 
			

if($rcl_options['nwl_style_none_tempelate_border_tab_radius']=='yes'){

$tab_radius = '
.panel_lk_recall .form_head
{
	border-top-left-radius: '.$rcl_options['nwl_style_none_tempelate_border_radius'].'px;
	border-top-right-radius: '.$rcl_options['nwl_style_none_tempelate_border_radius'].'px;
} 	';
	
};

				$custom_css = ' 
				
'.$tab_radius.'

#rcl-overlay{
	background: '.$rcl_options['nwl_style_none_tempelate_background_site'].';
	opacity: '.$rcl_options['nwl_style_none_tempelate_background_site_opacity'].';}	
.floatform{	
	max-width: 100%;
	width: '.$width_form.''.$rcl_options['nwl_style_none_tempelate_width_px'].';}
.panel_lk_recall.floatform{
	margin-left: -'.$result_width_form.''.$rcl_options['nwl_style_none_tempelate_width_px'].';}
.panel_lk_recall .form-tab-rcl{
	background: '.$rcl_options['nwl_style_none_tempelate_background_form'].';
	border: '.$rcl_options['nwl_style_none_tempelate_border_width'].'px solid '.$rcl_options['nwl_style_none_tempelate_border_color'].';
	border-radius: '.$rcl_options['nwl_style_none_tempelate_border_radius'].'px;
	padding: '.$rcl_options['nwl_style_none_tempelate_padding_form'].'px;
	width: '.$width_form.''.$rcl_options['nwl_style_none_tempelate_width_px'].';
	height: '.$height_form.'px;}			
'.$rcl_options['nwl_style_none_tempelate_custom'].' ';
		};
		if($rcl_options['nwl_options_style']=='sparkling'){		
			wp_register_style( 'nwl_style', rcl_addon_url ('css/sparkling-style.css', __FILE__) );			
$custom_css = '
.panel_lk_recall .form-tab-rcl{
	background-color: '.$rcl_options['nwl_style_sparkling_background_form'].';}
.panel_lk_recall .form-tab-rcl .form-title, .form_head H2{
	color: '.$rcl_options['nwl_style_sparkling_color_title'].' !important;}
.panel_lk_recall .form-block-rcl LABEL{
	color: '.$rcl_options['nwl_style_sparkling_color_text'].' !important;}
.panel_lk_recall .nwl-register, .panel_lk_recall .nwl-forgot, .panel_lk_recall .nwl-login{
	color: '.$rcl_options['nwl_style_sparkling_color_uri'].' !important;}
.panel_lk_recall .nwl-register:hover, .panel_lk_recall .nwl-forgot:hover, .panel_lk_recall .nwl-login:hover{
	color: '.$rcl_options['nwl_style_sparkling_color_uri_hover'].' !important;}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]{
	background-color: '.$rcl_options['nwl_style_sparkling_color_button'].';}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]:hover{
	background-color: '.$rcl_options['nwl_style_sparkling_color_button_hover'].' !important;}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]{
	color: '.$rcl_options['nwl_style_sparkling_color_button_text'].';}
'.$rcl_options['nwl_style_sparkling_custom'].' ';
		};
		if($rcl_options['nwl_options_style']=='twenty_sixteen'){		
			wp_register_style( 'nwl_style', rcl_addon_url ('css/twenty-sixteen-style.css', __FILE__) );
		};
		if($rcl_options['nwl_options_style']=='hueman'){		
			wp_register_style( 'nwl_style', rcl_addon_url ('css/hueman-style.css', __FILE__) );
				$custom_css = '
.form_head H2 {	
	color: '.$rcl_options['nwl_style_hueman_color_text'].';}
.panel_lk_recall .form-tab-rcl{
	background-color: '.$rcl_options['nwl_style_hueman_background_form'].';}
.panel_lk_recall .form-block-rcl LABEL, .ulogin_label, .panel_lk_recall .form-tab-rcl .form-title, .close-popup {
	color: '.$rcl_options['nwl_style_hueman_color_text'].';}					
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]{
	background: '.$rcl_options['nwl_style_hueman_color_button'].';}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]:hover{
	background: '.$rcl_options['nwl_style_hueman_color_button_hover'].'!important;}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"] {
	color: '.$rcl_options['nwl_style_hueman_color_button_text'].';}						
.panel_lk_recall .nwl-register, .panel_lk_recall .nwl-forgot, .panel_lk_recall .nwl-login {
	color: '.$rcl_options['nwl_style_hueman_color_uri'].' !important;}
.panel_lk_recall .nwl-register:hover, .panel_lk_recall .nwl-forgot:hover, .panel_lk_recall .nwl-login:hover {
	color: '.$rcl_options['nwl_style_hueman_color_uri_hover'].' !important;}						
.panel_lk_recall .form-tab-rcl{
	border: 2px solid '.$rcl_options['nwl_style_hueman_border_color'].';}
'.$rcl_options['nwl_style_hueman_custom'].' ';
		};
		if($rcl_options['nwl_options_style']=='flat'){		
			wp_register_style( 'nwl_style', rcl_addon_url ('css/flat-style.css', __FILE__) );
			$rcl_add_url = rcl_addon_url('', __FILE__);
				$custom_css = '
@font-face
{
	font-family: Amatic_SC;
	src: url('.$rcl_add_url.'/font/Amatic_SC.ttf);
	font-weight: normal;
} 		
.form_head H2
{
	font-family: "Amatic_SC", Arial, sans-serif !important;
	text-align: center;
	font-size: 50px;
}
';
		};
		if($rcl_options['nwl_options_style']=='full_pop'){
			wp_register_style( 'nwl_style', rcl_addon_url ('css/full-pop-style.css', __FILE__) );
				$custom_css = '
.form_head H2 {	
	color: '.$rcl_options['nwl_style_full_pop_color_text'].';}
.form-block-rcl .rcl-field-notice {
	color: '.$rcl_options['nwl_style_full_pop_color_text'].';}
#rcl-overlay, .panel_lk_recall .form-tab-rcl,.close-popup, .panel_lk_recall .form-tab-rcl INPUT[type="submit"] {
	background-color: '.$rcl_options['nwl_style_full_pop_background_form'].'!important;}					
.panel_lk_recall .form-block-rcl LABEL, .ulogin_label, .panel_lk_recall .form-tab-rcl .form-title, .close-popup, .panel_lk_recall .form-tab-rcl INPUT[type="submit"] {
	color: '.$rcl_options['nwl_style_full_pop_color_text'].'!important;}
/*******
.close-popup:hover {
	color: '.$rcl_options['nwl_style_full_pop_background_form'].' !important;
	background-color: '.$rcl_options['nwl_style_full_pop_color_text'].';}
*******/
.panel_lk_recall FORM INPUT, .panel_lk_recall FORM SELECT, .panel_lk_recall FORM TEXTAREA{
	border-radius: '.$rcl_options['nwl_style_full_pop_border_radius'].'px !important;}
.panel_lk_recall .form-tab-rcl INPUT[type="submit"] {
	border: 2px solid '.$rcl_options['nwl_style_full_pop_color_text'].';}	
.panel_lk_recall .form-tab-rcl INPUT[type="submit"]:hover {
	color: '.$rcl_options['nwl_style_full_pop_background_form'].'!important;
	background-color: '.$rcl_options['nwl_style_full_pop_color_text'].' !important;
	border: 2px solid '.$rcl_options['nwl_style_full_pop_color_text'].';}
.panel_lk_recall .nwl-register, .panel_lk_recall .nwl-forgot, .panel_lk_recall .nwl-login {
	color: '.$rcl_options['nwl_style_full_pop_color_uri'].' !important;}
.panel_lk_recall .nwl-register:hover, .panel_lk_recall .nwl-forgot:hover, .panel_lk_recall .nwl-login:hover {
	color: '.$rcl_options['nwl_style_full_pop_color_uri_hover'].' !important;}
.panel_lk_recall #passwordStrength, .panel_lk_recall #notice-chek-password SPAN{
	border-radius: '.$rcl_options['nwl_style_full_pop_border_radius'].'px;}
'.$rcl_options['nwl_style_full_pop_custom'].' ';
		};
		if($rcl_options['nwl_options_style']=='mdesign'){
			wp_register_style( 'nwl_style', rcl_addon_url ('css/mdesign-style.css', __FILE__) );
			// wp_enqueue_script( 'nwl_js', rcl_addon_url( 'js/j.js', __FILE__ ) ); 	
		};
		wp_enqueue_style( 'nwl_style' );
		wp_add_inline_style( 'nwl_style' , $custom_css);
}
add_action( 'wp_enqueue_scripts', 'register_nwl_styles', 999 );


// wp-admin, закрываем доступ всем кроме admin ошибка 404 //
function blockusers_wp_admin() {
	global $rcl_options;
		if(isset($rcl_options['nwl_off_wp_admin'])){
				$redirect_check = $rcl_options['nwl_redirect_url_wp_admin'];
					if (empty($redirect_check)) {
						$redirect_check='404'; };
			if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
				wp_redirect( ''.$redirect_check.'' );
				exit;
			}
		}
}
add_action( 'init', 'blockusers_wp_admin' );

// wp-login.php, ошибка 404 //
function redirect_wp_login() {  
	global $rcl_options;
		if(isset($rcl_options['nwl_off_wp_login'])){
				$redirect_check = $rcl_options['nwl_redirect_url_wp_login'];
					if (empty($redirect_check)) {
						$redirect_check='404'; };
    $page_viewed = basename($_SERVER['REQUEST_URI']);  
			if( $page_viewed == "wp-login.php" ) {  
				wp_redirect( ''.$redirect_check.'' );  
				exit;  
			} 
		}
}  
add_action('init','redirect_wp_login');

// отключаем страницу регистрации ошибка 404 //
function redirect_wp_register() {  
	global $rcl_options;
		if(isset($rcl_options['nwl_off_wp_register'])){
				$redirect_check = $rcl_options['nwl_redirect_url_wp_register'];
					if (empty($redirect_check)) {
						$redirect_check='404'; };
    $page_viewed = basename($_SERVER['REQUEST_URI']);  
			if( $page_viewed == "wp-login.php?action=register" ) {  
				wp_redirect( ''.$redirect_check.'' );  
				exit;  
			} 
		}
}  
add_action('init','redirect_wp_register');


	global $rcl_options;
		if(isset($rcl_options['nwl_off_wp_register_email'])){
				remove_filter( 'authenticate', 'wp_authenticate_email_password', 20);
		}

// капча
global $rcl_options;
	if($rcl_options['nwl_options_recap']){
// скрипт			
		add_action( 'wp_enqueue_scripts', 'register_nwl_recap' );
			
		function register_nwl_recap() {
			wp_register_script( 'nwl_js_recap', 'https://www.google.com/recaptcha/api.js');
			wp_enqueue_script( 'nwl_js_recap' );
		}   

//код

add_action('register_form','nwl_add_recap_register_form');
function nwl_add_recap_register_form(){
	global $rcl_options;
    $code = '<div class="g-recaptcha" data-sitekey="';
	$code .= $rcl_options['nwl_recap_public_key'];
	$code .= '"></div>';
	echo $code;
}
 
add_filter('registration_errors','nwl_chek_recap_form',10);
function nwl_chek_recap_form($errors){
	global $rcl_options;
    $recaptcha_response = sanitize_text_field($_POST["g-recaptcha-response"]);
    $recaptcha_secret = $rcl_options['nwl_recap_secret_key'];
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$recaptcha_response);
    $response = json_decode($response["body"], true);
    
    if (isset($response['error-codes']) && $response['error-codes']) {
        $errors = new WP_Error();
        $errors->add( 'rcl_register_google_captcha', __('Проверка Google reCAPTCHA не пройдена!') );
    }
    
    return $errors;
}	
}
