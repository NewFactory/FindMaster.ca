<?php

function rcl_get_reviews($args = false){
    $Query = new Rcl_Reviews();
    return $Query->get_results($args);
}

function rcl_count_reviews($args){
    $Query = new Rcl_Reviews();
    return $Query->count($args);
}

function rcl_get_review($review_id){
    $Query = new Rcl_Reviews();
    return $Query->get_row(array(
        'review_id' => $review_id
    ));
}

function rcl_get_review_by_args($args){
    $Query = new Rcl_Reviews();
    return $Query->get_row($args);
}

function rcl_add_review($args){
    global $wpdb;
    
    $args['review_date'] = current_time('mysql');
    $args['review_status'] = 1;
    
    if(!isset($args['review_comment'])){
        $args['review_comment'] = '';
    }
    
    if(!$wpdb->insert(RCL_PREF ."reviews", $args)) return false;
    
    $review_id = $wpdb->insert_id;
    
    do_action('rcl_add_review', $review_id);
    
    return $review_id;
}

function rcl_update_review($review_id, $update){
    global $wpdb;
    
    $wpdb->update(RCL_PREF ."reviews",
        $update,
        array(
            'review_id' => $review_id
        )
    );
    
    do_action('rcl_update_review', $review_id);

}

function rcl_delete_review($review_id){
    global $wpdb;
    
    $review = rcl_get_review($review_id);
    
    if(!$review) return false;
    
    do_action('rcl_pre_delete_review', $review_id, $review);
    
    $wpdb->query("DELETE FROM ".RCL_PREF."reviews WHERE review_id='$review_id'");
    
    do_action('rcl_delete_review', $review_id, $review);
    
    return true;
    
}