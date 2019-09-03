<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/

if (!defined('ABSPATH')) exit;

// подключаем стили
function wprs_style(){
    rcl_enqueue_style( 'wprs_style', rcl_addon_url('wpr-spoiler.css', __FILE__) );
}
if(!is_admin()){
    add_action('rcl_enqueue_scripts', 'wprs_style', 10);
}


function wprs_style_admin(){
    global $current_screen;

    if( $current_screen->base === 'post' && $current_screen->parent_base === 'edit' ){ // мы на странице редактирования поста
        if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;

        if ( get_user_option('rich_editing') == 'true' ){
            $style = '.mce-btn button i.wpr_spoiler {
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAE80lEQVRYhe2XXUhbdxjG//twHdPV9cLlYmW2EobrMSfmnJyYWBuNRpN2/VBjEhOjycmXxvqV5CR+1mqMH1HTD3dX2MUYjkmhrLsco1ejMFpZlY2NMejN2EVh9L9BRlcozy7SdrX1Y7VCGd0Dv6vz57wP533P+5xDyAuvvYWFh2vM5mVPIJBx+33U4/dTMRCgYiD4CAEqBgLU4/fTNp+PurwibfF4aKsoZqrrTMv5Mtn+bRso1ZanvO0BzJ9JITU7jbl0Cukzs0ifnUP63DzS5+aQPjuH+TMpzM7PYCY1hcmZJCYmE5icTsLt80LBa+q3beA9hVCk4PlEqaBdKhW0i6WaDRCeRClolxieT8hYNnfbBv4TOsDyZSWc4GLVasfjKHje+bSUqNSt73OclmGY17YsXqxQ6Zxu953UXArJ6SSS00lMTCaRmJzA+MQ4TifGMDo2ipHREQwODyE+NIBYfwwRKYLeSB+6ersR6upEMNQOX9APj0+E2+tGrdl8p4TXdJMbNmL4ykLYDQ2oVLpGm+1OT7gXoa5OhLpC6OjsQDAURKAjAH+7H96gD6LfC4/PA7foRqunDS1uF5ytLXC4HLA7m2Fz2GCxW9FotaDRZoGhtjZr4FsxZ3G1t+DPlROv+DduAVt2gONcjErlWIt6a3je+ThrWrDSsfv87cth/HaxEyti3sWrVvLONkdle1oNvbVAP+8Cvu5B5soQfhpR/HLdTqwPrstYNlcplCW0esOSVl+5uC4VWTQV+iwH9YtCliWlIGz+mq6G9izc/qIH9y4dwr1LBuD7C7iZqsSPzWSEEEL2KcpOBEIdOP/hWcynZzGXzi6k1Nw0ZlJTmJpOIjk1jsTEGE6Pn8LI6DAGhwcQH5DQPxiD1dG8+aJaDe1ZuH25G7jiwL2rQ7j1sRM3/G9+8kMz2UcIIa/ny/br9JXLpqMfZIyHzdRoNlOj2USNJhOtMdXR6ro6Wl1XS6tra2mV0UirjEZaaTTSypoaqjcaM0J5xearejW0e+GPL4fx1zfz+DnB/3rNRhzrHMthGCZPxrK5TwPDMHmEkJxNZ2DF98aFmzM6fHfy7cvXreTdDY7lFDBMnkzG5q7hX5goYJi8oiI+v4jn8wkhrz5x52t2Elt1kvAYIS+vVzlfJttfbTItt4lixul200dxtLVRR5uL2l0uanM6qdXhoFZ7M7XYbLTBaqUnLE30eKOFHq2v//3IseMZta78o/VqvLTZE1LwmvoWtxvDpwYRH5Cy9EcRi0cQjYURkfoQjvSgN9yN7p6TONkVQqgziGCHH76AF16/CNHngejz4JDBcEsul+/etCWPS8ayuYyKTyh5YYnlhUWWFxYVT43mU1YtfMaqNOvN13OWXC7fpVCpdCVqdauC1zg3hBNaijnuWEF2sndOrCBI9U1Nd/uiYfRG+tAXDSMsRRCRIojEolmkCKKxKPztQSg5LrXDBsqk2iOH71psFjQ0NaDB2ogGayMa16GhyQIlp95ZA3K5fFexSqUr4TjXZqmm4LiWYo47xux0C5673lMoipSCkNBU6JcepJn2IQ+STv9P0q1NvK3TbispNdqU3elE/2AcUiyCWL+E+EDsPvH7xBDvlxCLRyHFo4hKYYSjfZDiEVib7c/2Wb63sPCwWle+fNBgyJRXVdKHVD5C1focNBgyal35suxZfkz+1wuvvwE978HMwrMkeQAAAABJRU5ErkJggg==);
    background-size: cover;
    width: 26px;
}';
            echo '<style>'.$style.'</style>';
        }
    }
}
add_action('admin_footer', 'wprs_style_admin', 10);


function wprs_page_settings(){
    $chr_page = get_current_screen();

    if($chr_page->base != 'wp-recall_page_rcl-options') return;
    if( isset($_COOKIE['otfmi_1']) && isset($_COOKIE['otfmi_2']) && isset($_COOKIE['otfmi_3']) )  return;

    require_once 'admin/for-settings.php';
}
add_action('admin_footer', 'wprs_page_settings');


// добавим стили для просмотра в окне редактирования визуального редактора
function wprs_tiny_mce_css($mce_css) {
	if ( !empty($mce_css) ){
        $mce_css .= ',';
    }

	$mce_css .= rcl_addon_url('wpr-spoiler.css', __FILE__);

	return $mce_css;
}
add_filter('mce_css', 'wprs_tiny_mce_css');


// кнопка в quicktag
function wprs_quicktag_spoiler() {
    if ( !wp_script_is('quicktags') ) return;

    $out = '
function wprs_spoiler(){
    return QTags.addButton("wpr-spoiler", "SpoileR", "<div class=\"otfm_spoiler\"><details><summary>Спойлер</summary>\nКонтент\n</details></div>\n", "", "", "WP-Recall Spoiler", 201);
}
rcl_add_action("rcl_footer", "wprs_spoiler");
rcl_add_action("rcl_pre_init_ajax_editor", "wprs_spoiler");
';

    echo '<script>' . $out . '</script>';
}
add_action('admin_print_footer_scripts', 'wprs_quicktag_spoiler');
if(!is_admin()){
    add_action('wp_print_footer_scripts', 'wprs_quicktag_spoiler');
}


// кнопка в tinyMce
// great tutorial https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
function wprs_tiny_spoiler(){
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;

    if ( get_user_option('rich_editing') == 'true' ) {
        add_filter('mce_external_plugins', 'wprs_tiny_script');
        add_filter('mce_buttons', 'wprs_register_tiny_button');
    }
}
add_action('admin_head', 'wprs_tiny_spoiler');
add_action('wp_head', 'wprs_tiny_spoiler');


// great packer http://dean.edwards.name/packer/
function wprs_tiny_script($plugin_array) {
    $plugin_array['wprs_spoiler'] = rcl_addon_url('scripts/wpr-spoiler-min.js', __FILE__);

    return $plugin_array;
}
function wprs_register_tiny_button($buttons) {
   array_push($buttons, 'wprs_spoiler');

   return $buttons;
}



// prime forum allowed tags
/*
like:
    <details><summary>Спойлер</summary>
    Контент
    </details>
and:
    <details open=""><summary>Спойлер</summary>
    Контент
    </details>

*/
function wprs_filter_spoiler($content){

    $content = str_replace(
        array(
            '&lt;details&gt;',
            '&lt;/details&gt;',
            '&lt;details open=&quot;&quot;&gt;',
            '&lt;summary&gt;',
            '&lt;/summary&gt;',
        ),
        array(
            '<details>',
            '</details>',
            '<details open="">',
            '<summary>',
            '</summary>',
        ), $content);

    return $content;

}
add_filter('pfm_filter_content_without_pretags', 'wprs_filter_spoiler', 10);


// скрипт-полифил для edge и ie
// https://github.com/rstacruz/details-polyfill
// закоментил стили ::before добавляющие треугольник. У  меня свои иконки
// upd: выкинул вообще все стили
// upd: нет ; у окончания строк. из-за этого в edge были ошибки. Исправил
// пакую этим пакером http://dean.edwards.name/packer/
function iess_support(){
    global $is_edge, $is_IE;

    if($is_edge || $is_IE){
        wp_enqueue_script( 'wprs_scr', rcl_addon_url('scripts/wpr-spoiler-ie-min.js', __FILE__) );
    }
}
add_action('wp_enqueue_scripts', 'iess_support');

