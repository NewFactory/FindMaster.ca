<?php

add_action('rcl_reviews_init', 'fng_init_types', 10);
function fng_init_types(){

    rcl_init_reviews_type(array(
            'rating_type' => 'fng-performer',
            'type_name' => __('Отзывы от заказчиков'),
            'init_tab' => true,
            'style' => true
        )
    );

    rcl_init_reviews_type(array(
            'rating_type' => 'fng-customer',
            'type_name' => __('Отзывы от исполнителей'),
            'init_tab' => true,
            'style' => true
        )
    );

}

add_filter('fng_manager_task_items', 'fng_add_review_item', 10, 2);
function fng_add_review_item($items, $task){
    global $user_ID;

    if(!function_exists('rcl_get_reviews')) return $items;

    $status_id = get_post_meta($task->ID, 'fng-status', 1);

    if($status_id != 5) return $items;

    $performer = get_post_meta($task->ID, 'fng-performer', 1);

    if($task->post_author == $user_ID && rcl_get_option('rating_fng-performer')){

        if(rcl_get_review_by_args(array(
            'object_id' => $performer,
            'object_author' => $performer,
            'rating_type' => 'fng-performer',
            'user_id' => $user_ID,
            'fields' => array('review_id')
        ))) return $items;

        $items[] = array(
            'id' => 'fng-add-review',
            'label' => __('Оставить отзыв исполнителю'),
            'icon' => 'fa-thumbs-o-up',
            'onclick' => 'fng_ajax('.json_encode(array(
                'action' => 'fng_ajax_get_review_form',
                'task_id' => $task->ID
            )).',this);return false;'
        );

    }

    if($performer == $user_ID && rcl_get_option('rating_fng-customer')){

        if(rcl_get_review_by_args(array(
            'object_id' => $task->post_author,
            'object_author' => $task->post_author,
            'rating_type' => 'fng-customer',
            'user_id' => $user_ID,
            'fields' => array('review_id')
        ))) return $items;

        $items[] = array(
            'id' => 'fng-add-review',
            'label' => __('Оставить отзыв заказчику'),
            'icon' => 'fa-thumbs-o-up',
            'onclick' => 'fng_ajax('.json_encode(array(
                'action' => 'fng_ajax_get_review_form',
                'task_id' => $task->ID
            )).',this);return false;'
        );

    }

    return $items;

}

rcl_ajax_action('fng_ajax_get_review_form');
function fng_ajax_get_review_form(){
    global $user_ID;

    if(!function_exists('rcl_get_reviews')) return false;

    $task_id = $_POST['task_id'];

    $task = get_post($task_id);

    $performer = get_post_meta($task->ID, 'fng-performer', 1);

    if($task->post_author == $user_ID){
        $args = array(
            'object_id' => $performer,
            'object_author' => $performer,
            'rating_type' => 'fng-performer',
            'user_id' => $user_ID
        );
    }

    if($performer == $user_ID){
        $args = array(
            'object_id' => $task->post_author,
            'object_author' => $task->post_author,
            'rating_type' => 'fng-customer',
            'user_id' => $user_ID
        );
    }

    wp_send_json(array(
        'dialog' => array(
            'content' => rcl_get_review_form($args),
            'title' => __('Публикация отзыва'),
            'size' => 'auto',
            'class' => 'fng-dialog'
        )
    ));

}