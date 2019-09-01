<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/

// user country & city
// https://www.gosquared.com/resources/flag-icons/ Лицензия MIT (GPL-совместимая), разрешает использование иконок в коммерческих проектах.
// https://ru.wikipedia.org/wiki/ISO_3166-1 стандарт именования стран и их список


if (!defined('ABSPATH')) exit;


// формируем блок с данными и добавляем в настройки профиля
function ucc_add_settings($profile_block, $userdata){
    require_once 'incl/countries.php';

    $country_list = ucc_list_of_countries(); // получаем массив с странами
    $pattern = '^([А-Яа-яЁёa-zA-ZäÄöÖüÜß]+(\s)([А-Яа-яЁёa-zA-ZäÄöÖüÜß]))*([А-Яа-яЁёa-zA-ZäÄöÖüÜß]+(|-|)([А-Яа-яЁёa-zA-ZäÄöÖüÜß]))*[А-Яа-яЁёa-zA-ZäÄöÖüÜß]*$';
    $placeholder = 'Ваш город. До 50 символов.';
    $title = 'Город: латиницей или кириллицей';

    $profile_block .= '<h3 class="ucc_title">Место проживания:</h3>';
    $profile_block .= '<table class="ucc_locations rcl-form rcl-field-input">';

        $profile_block .= '<tr class="form-block-rcl">';
            $profile_block .= '<td style="min-width:100px;"><label for="ucc_country">Страна:</label></td>';
            $profile_block .= '<td><select name="ucc_country">';
            $profile_block .= '<option value="">' . "Выберите страну" . '</option>';
            foreach ($country_list as $country) { // функция selected определяет выбранное ранее значение
                $profile_block .= '<option value="' . $country . '" ' . selected($country, $userdata->ucc_country, false) . '>' . $country . '</option>';
            }
            $profile_block .= '</select></td>';
        $profile_block .= '</tr>';

        $profile_block .= '<tr class="form-block-rcl">';
            $profile_block .= '<td style="min-width:100px;"><label for="ucc_sity">Город:</label></td>';
            $profile_block .= '<td class="rcl-field-input">';
                $profile_block .= '<input type="text" autocomplete="off" name="ucc_sity" pattern="'.$pattern.'" placeholder="'.$placeholder.'" title="'.$title.'" id="ucc_sity" value="'.$userdata->ucc_sity.'" maxlength="50"/>';
                $profile_block .= '<span class="rcl-field-notice"><i class="rcli fa-info" aria-hidden="true"></i>Например: Санкт-Петербург, Ростов-на-Дону, Нижний Новгород, Москва</span>';
            $profile_block .= '</td>';
        $profile_block .= '</tr>';

    $profile_block .= '</table>';

    return $profile_block;
}
add_filter('profile_options_rcl', 'ucc_add_settings', 10, 2);



//Сохраняем в бд
function ucc_save_settings($user_id){
    if ( !isset( $_POST['ucc_country'] ) || !isset( $_POST['ucc_sity'] ) ) return;

    $new_country = sanitize_text_field( $_POST['ucc_country'] );
    $new_sity = sanitize_text_field( $_POST['ucc_sity'] );

    update_user_meta($user_id, 'ucc_country', $new_country);
    update_user_meta($user_id, 'ucc_sity', $new_sity);
}
add_action('personal_options_update', 'ucc_save_settings');
add_action('edit_user_profile_update', 'ucc_save_settings');



 // получаем из бд и формируем для дальнейшего вывода
function ucc_get_value($user_id){
    $ucc_country = get_user_meta($user_id, 'ucc_country', true);
    $ucc_sity = get_user_meta($user_id, 'ucc_sity', true);

    if (!$ucc_country && !$ucc_sity) return;                    // чтобы не выводился пустой див проверяем

    global $rcl_options;

    require_once 'incl/countries.php';

    $flags = ucc_list_of_countries();                           // получаем массив с странами

    $search = array_values($flags);                             // выбираем значения
    $replace = array_keys($flags);                              // ключи
    $flag_code = str_replace($search, $replace, $ucc_country);  // получаем код флага

    $content = '<div class="ucc_cou_sit" style="font-size:14px;">';
        if ($ucc_country){
            $content .= '<img style="margin:0 5px 4px 0;vertical-align:middle;height:36px;width:36px;" alt="flag" src="'.rcl_addon_url('flags/', __FILE__).$flag_code.'.png" title="'.$ucc_country.'">';
            $content .= '<span class="name_country">'.$ucc_country.'. </span>';
        }
        if ($ucc_sity){
            if (isset($rcl_options['users_page_rcl']) && $rcl_options['users_page_rcl']) { // если в настройках указана страница с userlist
                $content .= '<span class="name_sity">Город:&nbsp;<a href="'.get_permalink($rcl_options['users_page_rcl']).'?usergroup=ucc_sity:'.$ucc_sity.'">'.$ucc_sity.'</a></span>';
            } else {
                $content .= '<span class="name_sity">Город:&nbsp;'.$ucc_sity.'</span>'; // &nbsp; для того чтоб на мобилках "Город:" переносился вместе с значением
            }
        }
    $content .= '</div>';

    return $content;
}



// добавляем к блоку автора
function ucc_add_description($content, $user_lk){
    $content .= ucc_get_value($user_lk);

    return $content;
}
add_filter('rcl_description_user', 'ucc_add_description', 10, 2);



// выводим данные в блок пользователя (в details область)
function ucc_print_value(){
    if( is_admin() && !defined( 'DOING_AJAX' ) ) return;

    rcl_block( 'details', 'ucc_get_value', array('class' => 'ucc_exit', 'order' => 5) );
}
add_action('init', 'ucc_print_value');


function ucc_add_settings_admin(){
    $chr_page = get_current_screen();

    if($chr_page->base != 'wp-recall_page_rcl-options') return;
    if( isset($_COOKIE['otfmi_1']) && isset($_COOKIE['otfmi_2']) && isset($_COOKIE['otfmi_3']) )  return;

    require_once 'admin/for-settings.php';
}
add_action('admin_footer', 'ucc_add_settings_admin');


/**
 *
 * @todo рудимент. Доп больше не поддерживается автором
 */
// поддержка аддона Profile Search
function ucc_search_profile_fields($data){
    $data[] = array('slug' => 'ucc_country', 'title' => 'Страна', 'type' => 'text');
    $data[] = array('slug' => 'ucc_sity', 'title' => 'Город', 'type' => 'text');

    return $data;
}
add_filter('rcl_search_profile_fields', 'ucc_search_profile_fields');
