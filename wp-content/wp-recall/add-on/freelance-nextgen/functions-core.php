<?php

function fng_task_expired($post_id){
    
    update_post_meta($post_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($post_id, 'fng-status', -4);
    
    fng_add_service_message($post_id, __('The time allotted for the assignment is over. '
            . 'The author of the task may extend the lead time or refuse the artist.'));
    
    do_action('fng_task_expired', $post_id);
    
}

function fng_task_complete($post_id){
    
    if(rcl_get_option('fng-reserve')){
    
        $performer = get_post_meta($post_id, 'fng-performer', 1);
        $price = get_post_meta($post_id, 'fng-price', 1);

        $balance = rcl_get_user_balance($performer);

        $balance += $price;

        rcl_update_user_balance($balance, $performer, __('Job payment'));

        if(rcl_get_option('fng-service-percent')){
            $balance -= rcl_get_option('fng-service-percent') * $price / 100;
            rcl_update_user_balance($balance, $performer, __('Service commission when receiving payment for a task').' ('.rcl_get_option('fng-service-percent').'%)');
        }
    
    }

    update_post_meta($post_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($post_id, 'fng-status', 5);
    delete_post_meta($post_id, 'fng-first-price');
    delete_post_meta($post_id, 'fng-work-start');
    
    fng_add_service_message($post_id, __('The fulfillment of the terms of the assignment was confirmed. The task is completed.'));
    
    do_action('fng_task_complete', $post_id);
    
}

function fng_task_claim($post_id, $user_id, $text_claim){
    
    $task = get_post($post_id);
    
    if($user_id == get_post_meta($post_id, 'fng-performer', 1)){
        fng_add_service_message($post_id, __('The contractor filed a complaint with the arbitration'). ': '. $text_claim);
    }
    
    if($user_id == $task->post_author){
        fng_add_service_message($post_id, __('The author of the task filed a complaint with the arbitration'). ': '. $text_claim);
    }
    
    fng_add_service_message($post_id, __('The job status has been changed. Administration pending.'));
    
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

        rcl_update_user_balance($balance, $task->post_author, __('Refund from reserve in connection with the refusal of the contractor'));
    
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

        rcl_update_user_balance($balance, $task->post_author, __('Refund from the reserve in connection with the refusal of the contractor'));
    
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