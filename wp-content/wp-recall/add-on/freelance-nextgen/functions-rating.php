<?php

add_action('init','fng_register_rating_type');
function fng_register_rating_type(){
    
    if(!function_exists('rcl_register_rating_type')) 
        return false;
    
    rcl_register_rating_type(array(
        'post_type' => 'task',
        'type_name' => __('Services'),
        'style' => true
        )
    );
    
    rcl_register_rating_type(array(
        'post_type' => 'task-task',
        'type_name' => __('Service Orders'),
        'style' => true
        )
    );
    
}

add_action('rcl_pre_edit_rating_post','fng_add_rating_data_review_form');
function fng_add_rating_data_review_form($data){
    global $user_ID;
    
    if(!in_array($data['rating_type'], array(
        'task',
        'task-task'
    ))) return false;

    wp_send_json(array(
        'fng-rating-value' => $data['rating_value']
    ));
}

add_filter('rcl_rating_user_can', 'fng_edit_rating_user_can', 10, 2);
function fng_edit_rating_user_can($user_can, $ratingData){
    
    if(!in_array($ratingData['rating_type'], array(
        'task',
        'task-task'
    ))) return $user_can;
    
    $user_can = array(
        'view_history' => false,
        'vote' => false
    );
    
    return $user_can;
    
}


