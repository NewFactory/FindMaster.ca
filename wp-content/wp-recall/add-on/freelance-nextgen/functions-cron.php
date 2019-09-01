<?php

add_action('rcl_cron_hourly', 'fng_hourly_heartbeat');
function fng_hourly_heartbeat(){
    global $wpdb;
    
    $tasks = $wpdb->get_results("SELECT "
            . "posts.*, "
            . "meta.meta_value AS task_status "
            . "FROM $wpdb->posts AS posts "
            . "INNER JOIN $wpdb->postmeta AS meta ON posts.ID = meta.post_id "
            . "WHERE posts.post_type = 'task' "
            . "AND posts.post_status = 'publish' "
            . "AND meta.meta_key = 'fng-status' "
            . "AND meta.meta_value IN (2)");
    
    if(!$tasks) return false;

    foreach($tasks as $task){

        $workDays = fng_diff_days(get_post_meta($task->ID, 'fng-work-start', 1));
        
        switch($task->task_status){

            case 2: //в работе, время работы + 24 часа, заказ просрочен

                if($workDays >= get_post_meta($task->ID, 'fng-days', 1) + 1){
                    
                    fng_task_expired($task->ID);
                    
                }
                
            break;
            
        }
        
    }
    
}

