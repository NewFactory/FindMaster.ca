<?php

rcl_ajax_action('fng_ajax_admin_get_form_take_performer');
function fng_ajax_admin_get_form_take_performer(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);
    
    $content = '<p>'.__('При назначении исполнителя к заданию у автора задания '
            . 'также будут зарезервированы средства на оплату услуг исполнителя. '
            . 'Если на балансе автора задания средств недостаточно, то назначить исполнителя не удасться.').'</p>';
    
    $content .= rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'performer_id',
                'type' => 'number',
                'title' => __('Укажите ID пользователя'),
                'notice' => __('укажите идентификатор пользователя, которого желаете назначить исполнителем для задания'),
                'required' => 1
            ),
            array(
                'slug' => 'task_id',
                'type' => 'hidden',
                'value' => $task_id
            )
        ),
        'submit' => __('Назначить исполнителя'),
        'onclick' => 'rcl_send_form_data("fng_ajax_admin_take_performer",this);return false;'
    ));
    
    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Назначение исполнителя для задания'),
            'size' => 'medium',
            'class' => 'fng-dialog'
        )
    ));
    
}

rcl_ajax_action('fng_ajax_admin_take_performer');
function fng_ajax_admin_take_performer(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);
    $performer_id = intval($_POST['performer_id']);
    
    if(!get_user_by('ID', $performer_id)){
        wp_send_json(array(
            'error' => __('Такого пользователя не существует')
        ));
    }

    if(rcl_get_option('fng-reserve')){
        
        $task = get_post($task_id);

        $price = get_post_meta($task_id, 'fng-price', 1);

        $balance = rcl_get_user_balance($task->post_author);

        if($balance < $price){
            wp_send_json(array(
                'error' => __('Недостаточно средств для списания на балансе автора задания')
            ));
        }

        $balance -= $price;

        rcl_update_user_balance($balance, $task->post_author, __('Резервирование средств на оплату услуг исполнителя задания'));
        
        fng_add_service_message($task_id, __('Заказчик зарезервировал средства на сумму '.$price.'.'));

    }
    
    fng_add_service_message($task_id, __('Назначен исполнитель задания'). ' - '.get_the_author_meta('display_name', $performer_id));

    update_post_meta($task_id, 'fng-status', 2);
    update_post_meta($task_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($task_id, 'fng-work-start', current_time('mysql'));
    update_post_meta($task_id, 'fng-performer', $performer_id);
    
    wp_send_json(array(
        'success' => __('Исполнитель успешно назначен'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_admin_get_form_update_performer');
function fng_ajax_admin_get_form_update_performer(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);

    $content .= rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'performer_id',
                'type' => 'number',
                'title' => __('Укажите ID пользователя'),
                'notice' => __('укажите идентификатор пользователя, которого желаете назначить исполнителем для задания'),
                'required' => 1
            ),
            array(
                'slug' => 'task_id',
                'type' => 'hidden',
                'value' => $task_id
            )
        ),
        'submit' => __('Назначить исполнителя'),
        'onclick' => 'rcl_send_form_data("fng_ajax_admin_update_performer",this);return false;'
    ));
    
    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Смена исполнителя задания'),
            'size' => 'medium',
            'class' => 'fng-dialog'
        )
    ));
    
}

rcl_ajax_action('fng_ajax_admin_update_performer');
function fng_ajax_admin_update_performer(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);
    $performer_id = intval($_POST['performer_id']);
    
    if(!get_user_by('ID', $performer_id)){
        wp_send_json(array(
            'error' => __('Такого пользователя не существует')
        ));
    }
    
    $oldPerformer = get_post_meta($task_id, 'fng-performer', 1);
    
    if($oldPerformer == $performer_id){
        wp_send_json(array(
            'error' => __('Этот пользователь уже назначен исполнителем')
        ));
    }
    
    $task = get_post($task_id);
    
    fng_add_service_message($task_id, __('Для выполнения задания назначен новый исполнитель'). ' - '.get_the_author_meta('display_name', $performer_id));
    
    update_post_meta($task_id, 'fng-last-update', current_time('mysql'));
    update_post_meta($task_id, 'fng-work-start', current_time('mysql'));
    update_post_meta($task_id, 'fng-status', 2);
    update_post_meta($task_id, 'fng-performer', $performer_id);
    
    wp_send_json(array(
        'success' => __('Исполнитель успешно назначен'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_work_area');
function fng_ajax_get_work_area(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);
    
    $chat = rcl_get_the_chat_by_room('fng-task:'.$task_id, array('userslist'=>0));

    wp_send_json(array(
        'dialog' => array(
            'content' => $chat['content'],
            'title' => __('Рабочая область'),
            'size' => 'medium',
            'class' => 'fng-dialog'
        )
    ));
    
}