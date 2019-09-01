<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/* отображаемое имя */
function uit_display_name( $user_lk ) {
    $name = get_the_author_meta( 'display_name', $user_lk );

    echo '<div class="uit_name">' . $name . '</div>';
}

// сообщение автору кабинета - линк на редактирование профиля
function uit_user_message( $user_lk, $title, $fa_icon ) {
    global $user_ID;

    if ( rcl_is_office( $user_ID ) ) {
        // сформируем массив к ajax обработчику
        $datapost = array(
            'tab_id'    => 'profile',
            'master_id' => $user_lk
        );

        $icon = '<i class="rcli ' . $fa_icon . '"></i>';
        $link = '<a class="rcl-ajax" data-post="' . rcl_encode_post( $datapost ) . '" href="?tab=profile">' . $title . '</a>';

        echo '<div class="uit_user_message"><div class="uit_user_title">' . $icon . $link . '</div></div>';
    }
}

// Возраст и др
function uit_birth( $arg, $user_lk, $title ) {
    // нужен доп Birthday in Profile https://codeseller.ru/?p=13377
    if ( ! rcl_exist_addon( 'birthday-in-profile' ) )
        return false;

    // функция с верси 3.0 Birthday in Profile
    if ( ! function_exists( 'bip_privacy' ) )
        return false;

    $out = '';
    // надо вывести возраст
    if ( $arg == 'age' ) {
        // не показывать дату рождения (и возраст)
        if ( bip_privacy( $user_lk ) != 1 )
            return false;

        $age = bip_get_age( $user_lk );
        if ( $age ) {
            $out = '<div class="uit_blk uit_birth uit_age">';
            $out .= '<div class="uit_title">' . $title . '</div>';
            $out .= '<div class="uit_content">' . $age . '</div>';  // возраст
            $out .= '</div>';
        }
    }

    // надо вывести дату рождения
    if ( $arg == 'dob' ) {
        $dob       = bip_get_dob( $user_lk, $no_filter = false );
        if ( $dob ) {
            $out = '<div class="uit_blk uit_birth uit_dob">';
            $out .= '<div class="uit_title">' . $title . '</div>';
            $out .= '<div class="uit_content">' . $dob . '</div>';  // дата рождения
            $out .= '</div>';
        }
    }

    echo $out;
}

// города и страны
function uit_country( $user_lk, $title, $fa_icon ) {
    // нужен доп Сountry & city in profile https://codeseller.ru/?p=10541
    if ( ! rcl_exist_addon( 'country-and-city-in-profile' ) )
        return false;

    $val = ucc_get_value( $user_lk );
    if ( ! $val )
        return false;

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_title = '<div class="uit_title">' . $title . '</div>';
    $out_val   = '<div class="uit_content">' . $val . '</div>';

    echo '<div class="uit_blk uit_country">' . $icon . $out_title . $out_val . '</div>';
}

// баланс пользователя
function uit_get_balance( $user_lk, $title, $fa_icon ) {
    // если не активирован доп
    if ( ! rcl_exist_addon( 'user-balance' ) )
        return false;

    global $user_ID;

    if ( rcl_is_office( $user_ID ) || current_user_can( 'manage_options' ) ) { // покажем автору кабинета и администратору
        $money = rcl_get_user_balance( $user_lk );
        if ( ! $money )
            return false; // баланс нулевой

        $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

        $out_title = '<span class="uit_title">' . $title . '</span>';
        $out_money = '<span class="uit_content">' . $money . rcl_get_primary_currency( 1 ) . '</span>';

        echo '<div class="uit_blk uit_balance">' . $icon . $out_title . $out_money . '</div>';
    }
}

// все произвольные поля пользователя
function uit_all_custom_field( $user_lk, $title, $fa_icon ) {
    if ( function_exists( 'rcl_show_custom_fields_profile' ) ) { // если активирован доп User Profile
        $val = rcl_show_custom_fields_profile( $user_lk );
        if ( ! $val )
            return false;

        $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

        $out_title = '<div class="uit_title">' . $title . '</div>';
        $out_val   = '<div class="uit_content">' . $val . '</div>';

        echo '<div class="uit_blk uit_all_custom_field">' . $icon . $out_title . $out_val . '</div>';
    }
}

// сайт пользователя
function uit_user_site( $user_lk, $title, $fa_icon ) {
    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_title = '<span class="uit_title">' . $title . '</span>';
    $out_site  = '<span class="uit_content">' . get_the_author_meta( 'url', $user_lk ) . '</span>';

    echo '<div class="uit_blk uit_site">' . $icon . $out_title . $out_site . '</div>';
}

// последняя активность
function uit_last_page( $user_lk, $title, $fa_icon ) {
    // нужен доп LastPage https://codeseller.ru/?p=8190
    if ( ! rcl_exist_addon( 'lastpage' ) )
        return false;

    $lp = get_last_page_rcl( $user_lk );
    if ( ! $lp )
        return false;

    $lp_title = $lp->page_title;
    if ( ! $lp_title )
        $lp_title = 'На этой странице';

    $last_action = rcl_get_useraction();

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_title = '<div class="uit_title">' . $title . '</div>';

    if ( ! $last_action ) {
        $action = '<div class="uit_content"><span class="uit_inner">Сейчас смотрит: </span><a href="//' . $lp->page_url . '">' . $lp_title . '</a></div>';
    } else {
        $time   = '(' . $last_action . ' назад)';
        $action = '<div class="uit_content"><span class="uit_inner">Последняя активность: </span><a href="//' . $lp->page_url . '">' . $lp_title . '</a> ' . $time . '</div>';
    }

    echo '<div class="uit_blk uit_last_page">' . $icon . $out_title . $action . '</div>';
}

// description пользователя
function uit_description( $user_lk, $title, $fa_icon ) {
    $desc = get_user_meta( $user_lk, 'description', true );
    if ( ! $desc )
        return false;

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_title       = '<div class="uit_title">' . $title . '</div>';
    $out_description = '<div class="uit_content">' . nl2br( esc_html( $desc ) ) . '</div>';

    echo '<div class="uit_blk uit_description">' . $icon . $out_title . $out_description . '</div>';
}

// соцкнопки пользователя
function uit_social( $user_lk, $title, $fa_icon ) {
    // нужен доп Social Recall https://codeseller.ru/?p=4637
    if ( ! rcl_exist_addon( 'social' ) )
        return false;

    $val = get_slink_rcl( $user_lk );
    if ( ! $val )
        return false;

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_title = '<div class="uit_title">' . $title . '</div>';
    $out_val   = '<div class="uit_content">' . $val . '</div>';

    echo '<div class="uit_blk uit_social">' . $icon . $out_title . $out_val . '</div>';
}

// дата регистрации
function uit_registration_date( $user_lk, $title, $fa_icon ) {
    $date  = get_the_author_meta( 'user_registered', $user_lk );
    $d_m_y = mysql2date( 'd-m-Y', $date );
    //$date_format = uit_days($d_m_y); // дата вида 28 ноября 2011. Отключил т.к. рвет ширину блока

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_date  = '<div class="uit_cnt">' . $d_m_y . '</div>';
    $out_title = '<div class="uit_cnt_title">' . $title . '</div>';

    echo '<div class="uit_stat_blk uit_registration_date">' . $icon . $out_date . $out_title . '</div>';
}

// день после регистрации: На сайте, дней
function uit_day_after_registration( $user_lk, $title, $fa_icon ) {
    $t_day = get_date_from_gmt( date( 'Y-m-d H:i:s' ), 'Y-m-d' ); // сегодня - настройки локали вп (вида 2016-12-21)
    $date  = get_the_author_meta( 'user_registered', $user_lk );
    $d_m_y = mysql2date( 'Y-m-d', $date );

    // вычисляем разницу дат
    $d_register = date_create( $d_m_y );
    $d_current  = date_create( $t_day );
    $interval   = date_diff( $d_register, $d_current );

    /* $interval вернет:
      DateInterval Object
      (
      [y] => 5
      [m] => 3
      [d] => 12
      [h] => 0
      [i] => 0
      [s] => 0
      [weekday] => 0
      [weekday_behavior] => 0
      [first_last_day_of] => 0
      [invert] => 0
      [days] => 1930
      [special_type] => 0
      [special_amount] => 0
      [have_weekday_relative] => 0
      [have_special_relative] => 0
      ) */

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_days  = '<div class="uit_cnt">' . $interval->days . '</div>';
    $out_title = '<div class="uit_cnt_title">' . $title . '</div>';

    echo '<div class="uit_stat_blk uit_day_after_registration">' . $icon . $out_days . $out_title . '</div>';
}

// считаем комментарии пользователя
function uit_comments_count( $user_lk, $title, $fa_icon ) {
    global $wpdb;
    $lca_count = $wpdb->get_var( "SELECT COUNT(comment_ID) FROM " . $wpdb->comments . " WHERE user_id = " . $user_lk . " AND comment_approved = 1" );

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_count = '<div class="uit_cnt">' . $lca_count . '</div>';
    $out_title = '<div class="uit_cnt_title">' . $title . '</div>';

    echo '<div class="uit_stat_blk uit_comments_count">' . $icon . $out_count . $out_title . '</div>';
}

//  одним запросом считаем все известные типы записей
function uit_count_type_post( $user_lk, $type, $title, $fa_icon ) {
    global $uit_user_posttype_cnt;

    if ( ! isset( $uit_user_posttype_cnt[$type] ) )
        return false;

    $cnt = $uit_user_posttype_cnt[$type]->cnt;
    if ( ! $cnt )
        return false;

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_cnt   = '<div class="uit_cnt">' . $cnt . '</div>';
    $out_title = '<div class="uit_cnt_title">' . $title . '</div>';

    echo '<div class="uit_stat_blk uit_stata uit_' . $type . '">' . $icon . $out_cnt . $out_title . '</div>';
}

// статистика asgaros forum
function uit_asgaros_stat( $user_lk, $type, $title, $fa_icon ) {
    // если не включен asgaros forum
    if ( ! class_exists( 'AsgarosForumStatistics' ) )
        return false;

    global $wpdb, $uit_asf_cnt;

    // единожды заполнив глобальную переменную - последующие варианты запроса функций не долбят БД
    if ( ! $uit_asf_cnt ) {
        $uit_asf_cnt = $wpdb->get_results( ""
            . "SELECT "
            . "COUNT(parent_id) as total_posts, "
            . "count(DISTINCT parent_id) AS forum_start "
            . "FROM " . $wpdb->prefix . "forum_posts "
            . "WHERE author_id = " . $user_lk . " "
            . "GROUP BY author_id "
            . "", ARRAY_A );

        // если запрос не вернул ничего - пишем 'none' - чтобы последующие запросы в холостую не гонять
        if ( ! $uit_asf_cnt ) {
            $uit_asf_cnt[0] = array( 'none' );
        }
    }

    if ( $type == 'asf_issues' ) {
        $cnt = $uit_asf_cnt[0]['forum_start'];
    }

    // общее кол-во сообщений
    if ( $type == 'asf_reply' ) {
        $cnt = $uit_asf_cnt[0]['total_posts'];
    }

    if ( ! $cnt )
        return false;

    $icon = ( $fa_icon ) ? '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>' : '';

    $out_cnt   = '<div class="uit_cnt">' . $cnt . '</div>';
    $out_title = '<div class="uit_cnt_title">' . $title . '</div>';

    echo '<div class="uit_stat_blk uit_asf_stat uit_' . $type . '">' . $icon . $out_cnt . $out_title . '</div>';
}

// получим данные сессии
function uit_get_session_data( $user_lk, $title, $fa_icon, $notice ) {
    global $user_ID;

    if ( rcl_is_office( $user_ID ) || current_user_can( 'manage_options' ) ) { // покажем автору кабинета и администратору
        $datas = get_user_meta( $user_lk, 'session_tokens', false );

        $i = 0;

        if ( $fa_icon )
            $out = '<div class="uit_icon"><i class="rcli ' . $fa_icon . '"></i></div>';
        $out .= '<div class="uit_title">' . $title . '</div>';
        foreach ( $datas as $data ) {
            foreach ( $data as $key => $ar ) {
                $i ++;
                $out .= '<div class="uit_session uit_session_' . $i . '">';
                $out .= '<div class="uit_nmbr">' . $i . '</div>';
                $out .= '<div class="uit_login_in"><span>Вошел на сайт (логин)</span>' . get_date_from_gmt( date( 'Y-m-d G:i:s', $ar['login'] ), 'Y-m-d G:i:s' ) . '</div>';
                $out .= '<div class="uit_login_out"><span>Авторизация истекает</span>' . get_date_from_gmt( date( 'Y-m-d G:i:s', $ar['expiration'] ), 'Y-m-d G:i:s' ) . '</div>';
                $out .= '<div class="uit_ip"><span>IP</span>' . $ar['ip'] . '</div>';
                $out .= '<div class="uit_user_agent"><span>User Agent</span>' . $ar['ua'] . '</div>';
                $out .= '</div>';
            }
        }
        $out .= '<div class="uit_notice">' . $notice . '</div>';

        $fin_out = '<div class="uit_blk uit_session_data uit_total_sesions_' . $i . '">' . $out . '</div>';

        if ( $i == 0 )
            $fin_out = ''; // если сессий нет - убираем блок

        echo $fin_out;
    }
}

// блок аватара пользователя и кнопки под ним
function uit_user_avatar( $user_lk ) {
    global $user_ID;

    $link = '';
    // В своем кабинете
    if ( rcl_is_office( $user_ID ) ) {
        $link       = '<a class="rcl-ajax uit_change_profile" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'profile' ) . '" href="?tab=profile"><span class="tc_button_change">Редактировать профиль</span></a>';
    } else {
        if ( rcl_exist_addon( 'rcl-chat' ) ) {
            $link       = '<a class="rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'chat' ) . '" href="?tab=chat"><span class="tc_button_change">Написать</span></a>';
        }
    }

    $out = '<div id="rcl-avatar" class="uit_avatar">';
    $out .= '<div class="avatar-image">';
    uit_zoom_ava();
    $out .= get_avatar( $user_lk, 300 );
    // В своем кабинете
    if ( rcl_is_office( $user_ID ) ) {
        $out .= '<div class="tc_line tc_ava">';
        $out .= '<a class="tc_ava_upload" title="Загрузка аватара" url="#"><i class="rcli fa-download"></i><span>Загрузить аватарку</span><input id="userpicupload" accept="image/*" name="userpicupload" type="file"></a>';
        $out .= '</div>';
    }
    $out .= '</div>';
    $out .= $link;
    $out .= '</div>';

    echo $out;
}

// подписки/подписчики
function uit_feed_data( $user_lk, $type ) {
    if ( ! rcl_exist_addon( 'feed' ) )
        return false;

    global $user_ID;

    $feed_count = uit_feed_subs( $user_lk, $type );
    $cnt        = uit_count_feed( $user_lk );

    $f_count = '';

    if ( $type == 'subscriptions' && $cnt[0] > 0 ) {
        $txt = '<span class="uit_ajax_txt">Подписки</span><span class="uit_ajax_sum">' . $cnt[0] . '</span>';
        if ( rcl_is_office( $user_ID ) ) {
            $f_count    = '<span class="uit_ajax_link"><a class="rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'subscriptions' ) . '" href="?tab=subscriptions">';
            $f_count    .= $txt;
            $f_count    .= '</a></span>';
        } else {
            $f_count .= '<span class="uit_ajax_link">' . $txt . '</span>';
        }
    } else if ( $type == 'followers' && $cnt[1] > 0 ) {
        $f_count    = '<span class="uit_ajax_link"><a class="rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'followers' ) . '" href="?tab=followers">';
        $f_count    .= '<span class="uit_ajax_txt">Подписчики</span><span class="uit_ajax_sum">' . $cnt[1] . '</span>';
        $f_count    .= '</a></span>';
    }

    echo '<div class="uit_follow ' . $type . '">' . $f_count . $feed_count . '</div>';
}

// 4-ре картинки
function uit_gallery( $user_lk ) {
    if ( ! rcl_exist_addon( 'gallery-recall' ) )
        return false;

    global $uit_user_posttype_cnt;

    $cnt = '';
    if ( isset( $uit_user_posttype_cnt['attachment'] ) ) {
        $cnt = $uit_user_posttype_cnt['attachment']->cnt;
    }

    // счетчик посчитал что 0 - прерываем работу
    if ( ! $cnt || $cnt == 0 )
        return false;

    rcl_sortable_scripts();
    rcl_enqueue_script( 'rcl-gallery', WP_CONTENT_URL . '/wp-recall/add-on/gallery-recall/js/scripts.js' );

    $args = array(
        'numberposts' => 4,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'author'      => $user_lk,
        'post_type'   => 'attachment',
        'post_status' => 'publish',
    );

    $img = '';

    $posts = get_posts( $args );
    foreach ( $posts as $post ) {
        setup_postdata( $post );
        $img  .= get_image_list_rcl( $post, $size = false );
    }

    $out = '<span class="uit_link"><a href="' . rcl_format_url( get_author_posts_url( $user_lk ), 'galrcl' ) . '">';
    $out .= '<span class="uit_ajax_txt">Фото</span><span class="uit_ajax_sum">' . $cnt . '</span>';
    $out .= '</a></span>';

    $out .= '<div class="uit_p_gallery"><ul class="gallery-attachments" id="files">' . $img . '</ul></div>';

    wp_reset_postdata();

    echo $out;
}

// последние видео
function uit_video_gallery( $user_lk ) {
    if ( ! rcl_exist_addon( 'video-gallery' ) )
        return false;

    global $uit_user_posttype_cnt;

    $cnt = '';
    if ( isset( $uit_user_posttype_cnt['video'] ) ) {
        $cnt = $uit_user_posttype_cnt['video']->cnt;
    }

    // счетчик посчитал что 0 - прерываем работу
    if ( ! $cnt || $cnt == 0 )
        return false;

    rcl_video_scripts();

    $args = array(
        'numberposts' => 2,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'author'      => $user_lk,
        'post_type'   => 'video',
        'post_status' => 'publish',
    );

    $video = '';

    $posts = get_posts( $args );
    foreach ( $posts as $post ) {
        setup_postdata( $post );
        $video .= rcl_get_video_list_rcl( $post, $size  = false, $title = true );
    }

    $bttn = '<span class="uit_link"><a href="' . rcl_format_url( get_author_posts_url( $user_lk ), 'videorcl' ) . '">';
    $bttn .= '<span class="uit_ajax_txt">Видео</span><span class="uit_ajax_sum">' . $cnt . '</span>';
    $bttn .= '</a></span>';

    $out = '<div class="uit_v_gallery"><ul id="videos">' . $bttn . $video . '</ul></div>';

    wp_reset_postdata();

    echo $out;
}

// последние заметки
function uit_last_notes( $user_lk ) {
    if ( ! rcl_exist_addon( 'notes-frontage' ) )
        return false;

    global $uit_user_posttype_cnt;

    $cnt = '';
    if ( isset( $uit_user_posttype_cnt['notes'] ) ) {
        $cnt = $uit_user_posttype_cnt['notes']->cnt;
    }

    // счетчик посчитал что 0 - прерываем работу
    if ( ! $cnt || $cnt == 0 )
        return false;

    $bttn = '<span class="uit_link"><a href="?tab=notes">';
    $bttn .= '<span class="uit_ajax_txt">Заметки</span><span class="uit_ajax_sum">' . $cnt . '</span>';
    $bttn .= '</a></span>';

    $atts = array(
        'num'      => 5,
        'template' => 'author',
        'name'     => '',
        'column'   => 1,
        'author'   => $user_lk
    );

    $out = ntf_notes_out( $atts );

    echo $bttn . $out;
}

// подарки
function uit_presents( $user_lk ) {
    if ( ! rcl_exist_addon( 'presents' ) )
        return false;

    $all_gifts = get_user_meta( $user_lk, 'presents', 1 );

    // нет подарков
    if ( ! $all_gifts )
        return false;

    $cnt = count( $all_gifts );

    $bttn       = '<span class="uit_ajax_link"><a class="rcl-ajax" data-post="' . uit_ajax_data( $user_lk, $uit_tab_id = 'gifts' ) . '" href="?tab=gifts">';
    $bttn       .= '<span class="uit_ajax_txt">Подарки</span><span class="uit_ajax_sum">' . $cnt . '</span>';
    $bttn       .= '</a></span>';

    $all_gifts_reverse = array_reverse( $all_gifts ); // перевернем чтоб получать от последнего

    $gift = '';
    $i    = 0;
    foreach ( $all_gifts_reverse as $one_present ) {
        $i ++;
        if ( $i == 6 )
            break; // 5 итерации. На 6-й стоп
        $num = $cnt - $i;

        $gift .= '<div id="pr-' . $num . '" class="uit_one_gift">';
        $gift .= '<a class="show-present" onclick="return rcl_show_present_details(this); return false;" data-present="' . $num . '" href="#">';
        $gift .= '<img title="Подарок от ' . get_the_author_meta( 'display_name', $one_present['author'] ) . '" src="' . $one_present['url'] . '">';
        $gift .= '</a>';
        $gift .= '</div>';
    }

    $out = '<div class="uit_presents">' . $bttn . $gift . '</div>';

    echo $out;
}
