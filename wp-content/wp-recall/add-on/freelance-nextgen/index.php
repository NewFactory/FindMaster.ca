<?php

require_once 'classes/class-fng-requests.php';
require_once 'classes/class-fng-comments.php';

require_once 'functions-db.php';
require_once 'functions-core.php';
require_once 'functions-init.php';
require_once 'functions-ajax.php';
require_once 'functions-profile.php';
require_once 'functions-post-task.php';
require_once 'functions-content-task.php';
require_once 'functions-request.php';
require_once 'functions-manager.php';
require_once 'functions-actions.php';
require_once 'functions-email.php';
require_once 'functions-reviews.php';
require_once 'functions-cron.php';
require_once 'shortcodes.php';

if (is_admin())
    require_once 'admin/index.php';

if (!is_admin()):
    add_action('rcl_enqueue_scripts', 'fng_init_scripts', 10);
endif;

function fng_init_scripts(){
    
    rcl_dialog_scripts();
    
    rcl_enqueue_style('fng-styles', rcl_addon_url('assets/style.css', __FILE__));
    rcl_enqueue_script('fng-scripts', rcl_addon_url('assets/scripts.js', __FILE__));
    
}

function fng_get_statuses(){
    
    $statuses = array(
        -4 => __('Просрочен'),
        -3 => __('Арбитраж'),
        //-2 => __('Отклонен'),
        //-1 => __('Отменен'),
        0 => __('Неопределен'),
        1 => __('Подбор исполнителя'),
        2 => __('В работе'),
        //3 => __('Выполнен, но не подтвержден'),
        //4 => __('Выполнение подтверждено'),
        5 => __('Завершен')
    );
    
    return apply_filters('fng_status_array', $statuses);
    
}

function fng_get_status_name($statusId){
    
    $status = fng_get_statuses();
    
    return $status[$statusId];
    
}

function fng_is_status($status_id, $post_id){
    
    return $status_id == get_post_meta($post_id, 'fng-status', 1);
    
}

function fng_is_task_time_end($taskId){

    if(get_post_meta($taskId,'fng-status',1) != 2) return false;

    $startWork = strtotime(get_post_meta($taskId,'fng-work-start',1));
    
    $timeNow = strtotime(current_time('mysql'));
    
    $taskDays = get_post_meta($taskId,'fng-days',1);
    
    $timeEnd = $startWork + ( $taskDays * 3600 *24 );
    
    return (($timeEnd - strtotime(current_time('mysql'))) > 0)? false: true;
    
}

function fng_diff_days($dateTime){
    
    $dateTime = strtotime($dateTime);
    
    $dateNow = strtotime(current_time('mysql'));
    
    $diffDays = ($dateNow - $dateTime) / ( 3600 * 24 );
    
    return $diffDays;
    
}

add_filter('rcl_chat_hidden_fields', 'fng_add_chat_task_field');
function fng_add_chat_task_field($hiddens){
    global $post;
    
    if(!$post || $post->post_type != 'task') return $hiddens;
    
    $hiddens['fng-task'] = $post->ID;
    
    return $hiddens;
}

function fng_add_service_message($task_id, $message){
    
    $addon = rcl_get_addon('rcl-chat');
    
    if(!$addon || !rcl_get_option('fng-bot')) return false;
    
    require_once $addon['path'].'/class-rcl-chat.php';
    
    $chat = new Rcl_Chat(array(
        'chat_room' => 'fng-task:'.$task_id,
        'user_id' => rcl_get_option('fng-bot')
    ));
    
    $chat->add_message($message);

}
