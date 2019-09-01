<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */



function rul_add_button($out, $chat){
    if ( !is_user_logged_in() ) return false;

    if($chat['chat_status'] != 'general') return false;

    $arg = [
        'icon'=>'fa-info',
        'text'=>'Правила',
        'command'=>'rules',
        'exclude_db'=> 1,
        'callback'=>'rul_get_rules',
    ];
    $out .= autobot_add_button($arg);

    return $out;
}
add_filter('rcl_chat_before_form', 'rul_add_button', 18, 2);


function rul_get_rules(){
    rcl_verify_ajax_nonce();

    $mess = 'Правила чата<br>читать...<br>И исполнять!<br>p.s. на этом месте будут ваши правила';
    $message = apply_filters('br_rules_text', $mess);

    $res['content'] = autobot_chat_wrapper($message);

    wp_send_json($res);
}
rcl_ajax_action('rul_get_rules');

