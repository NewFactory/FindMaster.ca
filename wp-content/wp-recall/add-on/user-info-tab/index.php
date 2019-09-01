<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ http://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */

/*

  great packer's
  https://cssminifier.com/
  http://dean.edwards.name/packer/

 */

// функции шаблона
require_once 'inc/functions-template.php';


// подключаем стили
if ( ! is_admin() ) {
    add_action( 'rcl_enqueue_scripts', 'uit_style', 10 );
}
function uit_style() {
    // стили нужны нам только в кабинете
    if ( rcl_is_office() ) {
        // скрипт нужен в Theme Control
        if ( rcl_exist_addon( 'theme-control' ) ) {
            rcl_enqueue_script( 'uit_script', rcl_addon_url( 'assets/scripts.min.js', __FILE__ ), false, true );
        }
        rcl_enqueue_style( 'uit_style', rcl_addon_url( 'assets/style.min.css', __FILE__ ) );
    }
}

// отменим стандартный вывод кнопки "Подробная информация" - "Информация о пользователе"
add_action( 'init', 'uit_del_userinfo_button' );
function uit_del_userinfo_button() {
    remove_filter( 'rcl_avatar_icons', 'rcl_add_user_info_button', 10 );
}

// увеличение авы, т.к. функционал модальной подробной инфы убрали
add_action( 'rcl_avatar', 'uit_zoom_ava', 10 );
function uit_zoom_ava() {
    if ( ! rcl_is_office() )
        return false;

    global $active_addons;

    $across_ocean_pro = isset( $active_addons['across-ocean-pro'] ) ? $active_addons['across-ocean-pro'] : '';
    $theme_line       = isset( $active_addons['theme-line'] ) ? $active_addons['theme-line'] : '';
    $theme_clear_sky  = isset( $active_addons['theme-clear-sky'] ) ? $active_addons['theme-clear-sky'] : '';
    $theme_simple     = isset( $active_addons['theme-simple'] ) ? $active_addons['theme-simple'] : '';

    // аву выводим у всех шаблонов личных кабинетов кроме этих
    if ( ! $across_ocean_pro && ! $theme_line && ! $theme_clear_sky && ! $theme_simple ) {
        global $user_LK;

        $avatar = get_user_meta( $user_LK, 'rcl_avatar', 1 );
        // если ава в бд есть от плагина реколл - выводим зум.
        if ( $avatar ) {
            $zoom = '<a title="Увеличить аватар" data-zoom="' . $avatar . '" onclick="rcl_zoom_avatar(this);return false;" class="uit_zoom_ava" href="#"><i class="rcli fa-search-plus"></i></a>';
            echo $zoom;
        }
    }
}

// выводим вкладку
add_action( 'init', 'uit_add_tab_userinfo' );
function uit_add_tab_userinfo() {
    global $user_ID;

    $uit_cache = 'cache';
    // если это владелец ЛК или админ - вкладку не кешируем
    // отключение кеширования нужно только для функции сессий
    if ( rcl_is_office( $user_ID ) || current_user_can( 'manage_options' ) ) {
        $uit_cache = '';
    }

    $tab_data = array(
        'id'       => 'user-info',
        'name'     => 'Инфо',
        'supports' => array( $uit_cache, 'ajax' ),
        'public'   => 1,
        'icon'     => 'fa-id-card-o',
        'output'   => 'menu',
        'content'  => array(
            array(
                'callback' => array(
                    'name' => 'uit_userinfo_content',
                )
            )
        )
    );

    rcl_tab( $tab_data );
}

// callback вкладки
function uit_userinfo_content( $user_lk ) {
    global $rcl_blocks;

    if ( ! class_exists( 'Rcl_Blocks' ) ) {
        include_once RCL_PATH . 'classes/class-rcl-blocks.php';
    }

    if ( $rcl_blocks && (isset( $rcl_blocks['details'] )) ) {
        $details = $rcl_blocks['details'];

        //print_var($details);
        // известные нам массивы и их функции в области details
        // [callback] => rcl_show_custom_fields_profile - поля профиля
        // [callback] => bip_add_userinfo               - дни рождения
        // [callback] => get_slink_rcl                  - социал реколл
        // [callback] => ucc_get_value                  - страны и города
        // [callback] => user_lastpage_rcl              - посл активность на странице
        // удаляем из массива - мы их будем вызывать вручную вставляя в нужное нам место
        // а так как область details может быть задействована другими дополнениями - то неизвестные нам пойдут в самый низ инфы юзера

        foreach ( $details as $a => $detail ) {
            if (
                $details[$a]['callback'] == 'rcl_show_custom_fields_profile'    // поля профиля
                || $details[$a]['callback'] == 'bip_add_userinfo'               // дни рождения
                || $details[$a]['callback'] == 'get_slink_rcl'                  // социал реколл
                || $details[$a]['callback'] == 'ucc_get_value'                  // страны и города
                || $details[$a]['callback'] == 'user_lastpage_rcl'              // посл активность на странице
            )
                unset( $details[$a] );
        }

        $content = '';
        foreach ( $details as $block ) {
            $Rcl_Blocks = new Rcl_Blocks( $block );
            $content    .= $Rcl_Blocks->get_block( $user_lk );
        }
    }

    // подключаем шаблон если тема у нас theme control
    if ( rcl_exist_addon( 'theme-control' ) ) {
        $out = rcl_get_include_template( 'user-info-control.php', __FILE__ );
    } else {
        $out = rcl_get_include_template( 'user-info-card.php', __FILE__ );
    }

    return '<div id="user_info_blk">' . $out . $content . '</div>';
}

// и приводим дату вида 2011-04-11 17:45:33 к человечному виду: 28 ноября 2011
function uit_days( $date ) {
    $months = array( '01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля',
        '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
        '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря' );

    $matches = array();
    // разделяем d m Y
    preg_match( '/(\d{2})-(\d{2})-(\d{4})/', $date, $matches );

    // отрезаем у даты ведущий ноль
    $day_not_zero = intval( $matches[1] );

    return $day_not_zero . ' ' . $months[$matches[2]] . ' ' . $matches[3];
}

// посчитаем все типы записей пользователя
add_action( 'uit_top', 'uit_count_all_type' ); // хук инициализации
function uit_count_all_type( $user_lk ) {
    global $wpdb, $uit_user_posttype_cnt;

    // единожды заполнив глобальную переменную - последующие варианты запроса функций не долбят БД
    if ( ! $uit_user_posttype_cnt ) {
        $uit_user_posttype_cnt = $wpdb->get_results( ""
            . "SELECT post_type,"
            . "count(*) AS cnt "
            . "FROM " . $wpdb->posts . " "
            . "WHERE post_author = " . $user_lk . " "
            . "AND post_status = 'publish' "
            . "GROUP BY post_type "
            . "", OBJECT_K );

        // если запрос не вернул ничего - пишем 'none' - чтобы последующие запросы в холостую не гонять
        if ( ! $uit_user_posttype_cnt ) {
            $uit_user_posttype_cnt = array( 'none' );
        }
    }
// глобальная $uit_user_posttype_cnt заполнится так:
    /* Array (
      [attachment] => stdClass Object
      (
      [post_type] => attachment
      [cnt] => 22
      )
      [video] => stdClass Object
      (
      [post_type] => video
      [cnt] => 29
      )
      [forum] => stdClass Object
      (
      [post_type] => forum
      [cnt] => 2
      )
      ) */
// вызывать так: $uit_user_posttype_cnt[$type]->cnt
}

// формируем для ajax строку в data-post атрибут
function uit_ajax_data( $user_lk, $uit_tab_id ) {
    $datapost = array(
        'tab_id'    => $uit_tab_id,
        'master_id' => $user_lk
    );

    return rcl_encode_post( $datapost );
}

// зарегаем область сайдбара в подвале
add_action( 'widgets_init', 'uit_bottom_sidebar' );
function uit_bottom_sidebar() {
    register_sidebar( array(
        'name'          => "UIT: Сайдбар контента подвала User Unfo Tab",
        'id'            => 'uit_bottom_sidebar',
        'description'   => 'Выводится только в личном кабинете. Только во вкладке Info, дополнения User Unfo Tab',
        'before_title'  => '<h3 class="cabinet_sidebar_title">',
        'after_title'   => '</h3>',
        'before_widget' => '<div class="cabinet_sidebar">',
        'after_widget'  => '</div>'
    ) );
}

add_action( 'uit_footer', 'uit_add_sidebar_footer' );
function uit_add_sidebar_footer() {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        dynamic_sidebar( 'uit_bottom_sidebar' );
    }
}

// посчитаем подписки/подписчики
function uit_count_feed( $user_lk ) {
    global $wpdb, $uit_feed_count;
    if ( ! $uit_feed_count ) {
        $uit_feed_count = $wpdb->get_col( "(SELECT COUNT(user_id) AS cnt FROM " . $wpdb->prefix . "rcl_feeds WHERE user_id = " . $user_lk . " AND feed_status = 1)
                            UNION ALL
                            (SELECT COUNT(user_id) AS cnt FROM " . $wpdb->prefix . "rcl_feeds WHERE object_id = " . $user_lk . " AND feed_status = 1)
                        " );
    }

    return $uit_feed_count;
}

// получим пользователей на кого и кто подписаны
function uit_get_sixfeed( $user_lk ) {
    global $wpdb, $uit_feed_data;

    if ( ! $uit_feed_data ) {
        $uit_feed_data = $wpdb->get_results( "(SELECT t_feed.user_id,object_id,user_email,user_nicename,display_name,time_action,meta_value
                                FROM " . $wpdb->prefix . "rcl_feeds AS t_feed
                                LEFT JOIN " . $wpdb->users . " AS t_users
                                ON t_feed.object_id=t_users.ID
                                LEFT JOIN " . $wpdb->prefix . "rcl_user_action AS t_action
                                ON t_feed.object_id=t_action.user
                                LEFT JOIN " . $wpdb->usermeta . " AS t_meta
                                ON t_feed.object_id=t_meta.user_id
                                AND meta_key IN ('rcl_avatar', 'ulogin_photo')
                                WHERE t_feed.user_id = " . $user_lk . "
                                AND feed_status = 1
                                GROUP BY display_name
                                ORDER BY t_feed.user_id,time_action DESC
                                LIMIT 6)

                                UNION

                                (SELECT t_feed.user_id,object_id,user_email,user_nicename,display_name,time_action,meta_value
                                FROM " . $wpdb->prefix . "rcl_feeds AS t_feed
                                LEFT JOIN " . $wpdb->users . " AS t_users
                                ON t_feed.user_id=t_users.ID
                                LEFT JOIN " . $wpdb->prefix . "rcl_user_action AS t_action
                                ON t_feed.user_id=t_action.user
                                LEFT JOIN " . $wpdb->usermeta . " AS t_meta
                                ON t_feed.user_id=t_meta.user_id
                                AND meta_key IN ('rcl_avatar', 'ulogin_photo')
                                WHERE t_feed.object_id = " . $user_lk . "
                                AND feed_status = 1
                                GROUP BY display_name
                                ORDER BY object_id,time_action DESC
                                LIMIT 6)

                            ", ARRAY_A );
    }

    return $uit_feed_data;
}

function uit_feed_subs( $user_lk, $type ) {
    $fds = uit_get_sixfeed( $user_lk );

// цикл разобьет массив так:
    /* Array(
      [user_id] => 1
      [object_id] => 3
      [user_email] => mail@mail.ru
      [user_nicename] => lover_boy
      [display_name] => Путешественник во времени
      [time_action] => 2017-02-17 20:07:35
      [meta_value] => http://наш-сайт/wp-content/uploads/rcl-uploads/avatars/1.jpg
      ) */

    $out = '';

    foreach ( $fds as $fd ) {

        if ( $type == 'subscriptions' ) {
            $f_id = $fd['object_id'];
            if ( $fd['user_id'] != $user_lk )
                continue;  // нам нужны только наши подписки
        }
        if ( $type == 'followers' ) {
            $f_id = $fd['user_id'];
            if ( $fd['object_id'] != $user_lk )
                continue; // или подписчики
        }

        $out .= '<div class="thumb-user">';
        $out .= '<a title="' . $fd['display_name'] . '" href="' . get_author_posts_url( $f_id, $fd['user_nicename'] ) . '">';
        if ( $fd['meta_value'] ) {
            $out  .= '<img class="avatar" src="' . rcl_get_url_avatar( $fd['meta_value'], $f_id, $size = 50 ) . '" alt="" width="50" height="50">';
        } else {
            $out .= get_avatar( $fd['user_email'], 50 );
        }
        $out .= uit_useraction_icon( $fd['time_action'] );
        $out .= '</a>';
        $out .= '</div>';
    }

    return $out;
}

function uit_useraction_icon( $user_action ) {
    $tm = rcl_get_useraction( $user_action );

    $online = ( ! $tm ) ? '<span class="status_user online"><i class="rcli fa-circle"></i></span>' : '';

    return $online;
}
