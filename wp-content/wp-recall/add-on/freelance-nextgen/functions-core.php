<?php

function fng_task_expired($post_id){
    
    update_post_meta($post_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($post_id, 'fng-status', -4);
    
    fng_add_service_message($post_id, __('Время отведенное на выполнение задания закончилось. '
            . 'Автор задания может продлить время выполнения или отказаться от исполнителя.'));
    
    do_action('fng_task_expired', $post_id);
    
}

function fng_task_complete($post_id){
    
    if(rcl_get_option('fng-reserve')){
    
        $performer = get_post_meta($post_id, 'fng-performer', 1);
        $price = get_post_meta($post_id, 'fng-price', 1);

        $balance = rcl_get_user_balance($performer);

        $balance += $price;

        rcl_update_user_balance($balance, $performer, __('Оплата за выполнение задания'));

        if(rcl_get_option('fng-service-percent')){
            $balance -= rcl_get_option('fng-service-percent') * $price / 100;
            rcl_update_user_balance($balance, $performer, __('Комиссия сервиса при получении оплаты за задание').' ('.rcl_get_option('fng-service-percent').'%)');
        }
    
    }

    update_post_meta($post_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($post_id, 'fng-status', 5);
    delete_post_meta($post_id, 'fng-first-price');
    delete_post_meta($post_id, 'fng-work-start');
    
    fng_add_service_message($post_id, __('Выполнение условий задания было подтверждено. Задание завершено.'));
    
    do_action('fng_task_complete', $post_id);
    
}

function fng_task_claim($post_id, $user_id, $text_claim){
    
    $task = get_post($post_id);
    
    if($user_id == get_post_meta($post_id, 'fng-performer', 1)){
        fng_add_service_message($post_id, __('Исполнитель задания подал жалобу в арбитраж'). ': '. $text_claim);
    }
    
    if($user_id == $task->post_author){
        fng_add_service_message($post_id, __('Автор задания подал жалобу в арбитраж'). ': '. $text_claim);
    }
    
    fng_add_service_message($post_id, __('Статус задания был изменен. Ожидается решение администрации.'));
    
    update_post_meta($post_id, 'fng-status', -3);

    do_action('fng_task_claim', $post_id, $user_id, $text_claim);
    
    return true;
}

function fng_performer_fail($post_id){
    
    $task = get_post($post_id);

    if(rcl_get_option('fng-reserve')){
        
        $price = get_post_meta($post_id, 'fng-price', 1);

        $balance = rcl_get_user_balance($task->post_author);

        $balance += $price;

        rcl_update_user_balance($balance, $task->post_author, __('Возврат с резерва в связи с отказом исполнителя'));
    
    }
    
    if($firstPrice = get_post_meta($post_id, 'fng-first-price', 1)){
        update_post_meta($post_id, 'fng-price', $firstPrice);
        delete_post_meta($post_id, 'fng-first-price');
    }

    update_post_meta($post_id, 'fng-status', 1);
    delete_post_meta($post_id, 'fng-performer');
    delete_post_meta($post_id, 'fng-work-start');
    
    $chat = rcl_get_chat_by_room('fng-task:'.$post_id);
    
    rcl_delete_chat($chat->chat_id);
    
    do_action('fng_performer_fail', $post_id);
    
}

function fng_performer_fired($post_id){
    
    $task = get_post($post_id);

    if(rcl_get_option('fng-reserve')){
        
        $price = get_post_meta($post_id, 'fng-price', 1);

        $balance = rcl_get_user_balance($task->post_author);

        $balance += $price;

        rcl_update_user_balance($balance, $task->post_author, __('Возврат с резерва в связи с отказом от исполнителя'));
    
    }
    
    if($firstPrice = get_post_meta($post_id, 'fng-first-price', 1)){
        update_post_meta($post_id, 'fng-price', $firstPrice);
        delete_post_meta($post_id, 'fng-first-price');
    }

    update_post_meta($post_id, 'fng-status', 1);
    delete_post_meta($post_id, 'fng-performer');
    delete_post_meta($post_id, 'fng-work-start');
    
    $chat = rcl_get_chat_by_room('fng-task:'.$post_id);
    
    rcl_delete_chat($chat->chat_id);
    
    do_action('fng_performer_fired', $post_id);
    
}