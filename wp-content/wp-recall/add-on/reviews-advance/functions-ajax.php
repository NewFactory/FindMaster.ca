<?php

rcl_ajax_action('rcl_send_review');
function rcl_send_review(){
    global $user_ID;
    
    rcl_verify_ajax_nonce();
    
    $reviewText = $_POST['rvs-review-content'];
    $ratingData = $_POST['rvs-rating-data'];
    $review_id = 0;
    
    if(isset($_POST['review_id'])){
        $review_id = $_POST['review_id'];
    }
    
    if(!$reviewText){
        wp_send_json(array(
            'error' => __('Текст отзыва не должен быть пустым!')
        ));
    }
    
    if(!$ratingData){
        wp_send_json(array(
            'error' => __('Не был указан рейтинг!')
        ));
    }
    
    $args = rcl_decode_data_rating($ratingData);
    
    if(!isset($args['rating_value'])){
        $args['rating_value'] = rcl_get_option('rating_point_' . $args['rating_type'], 1);
    }

    if($review_id){
        
        $review = rcl_get_review($review_id);
        
        rcl_delete_rating(array(
            'user_id' => $review->user_id,
            'object_id' => $review->object_id,
            'object_author' => $review->object_author,
            'rating_type' => $review->rating_type
        ));
        
        $rating_id = rcl_insert_rating($args);
        
        if(!$rating_id){
            wp_send_json(array(
                'error' => __('Не удалось отредактировать отзыв!')
            ));
        }
        
        if($args['rating_status']=='minus') 
            $args['rating_value'] = -1 * $args['rating_value'];
        
        rcl_update_review($review_id, array(
            'rating_value' => $args['rating_value'],
            'review_content' => $reviewText
        ));
        
    }else{
        
        $rating_id = rcl_insert_rating($args);
        
        if($args['rating_status']=='minus') 
            $args['rating_value'] = -1 * $args['rating_value'];
        
        $review_id = rcl_add_review(array(
            'object_id' => $args['object_id'],
            'rating_type' => $args['rating_type'],
            'user_id' => $args['user_id'],
            'object_author' => $args['object_author'],
            'rating_value' => $args['rating_value'],
            'review_content' => $reviewText
        ));
        
    }

    if(!$review_id){
        wp_send_json(array(
            'error' => __('Не удалось оставить отзыв!')
        ));
    }
    
    wp_send_json(array(
        'success' => __('Отзыв успешно опубликован!'),
        'reload' => 1
    ));
}

rcl_ajax_action('rcl_ajax_review_remove');
function rcl_ajax_review_remove(){
    
    rcl_verify_ajax_nonce();
    
    $review_id = $_POST['review_id'];
    
    $result = rcl_delete_review($review_id);
    
    if(!$result){
        wp_send_json(array(
            'error' => __('Не удалось удалить отзыв!')
        ));
    }
    
    wp_send_json(array(
        'success' => __('Отзыв успешно удален!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('rcl_ajax_get_review_edit_form');
function rcl_ajax_get_review_edit_form(){
    
    rcl_verify_ajax_nonce();
    
    $review_id = $_POST['review_id'];
    
    wp_send_json(array(
        'dialog' => array(
            'content' => rcl_get_review_form(array(
                'review_id' => $review_id
            )),
            'title' => __('Изменение отзыва'),
            'size' => 'auto',
            'class' => 'rcl-review-dialog'
        )
    ));
    
}