<?php

require_once 'classes/class-rcl-reviews.php';

require_once 'functions-database.php';
require_once 'functions-core.php';
require_once 'functions-ajax.php';

if (!is_admin()):
    add_action('rcl_enqueue_scripts','rcl_scripts_init',10);
endif;

function rcl_scripts_init(){
    rcl_enqueue_style('rvs-style',rcl_addon_url('assets/style.css', __FILE__));
    rcl_enqueue_script('rvs-scripts', rcl_addon_url('assets/scripts.js', __FILE__));
}

add_action('rcl_reviews_init', 'rcl_init_default_types', 10);
function rcl_init_default_types(){

    rcl_init_reviews_type(array(
            'rating_type' => 'review-profile',
            'type_name' => __('Profile Reviews'),
            'style' => true,
            'add_form' => true,
            'init_tab' => true
        )
    );

}

add_action('init','rcl_reviews_init', 90);
function rcl_reviews_init(){
    global $rcl_rating_types, $rcl_office;

    do_action('rcl_reviews_init');

    if(!$rcl_rating_types) return false;

    $tabsData = array();

    foreach($rcl_rating_types as $type => $data){

        if(!isset($data['review-type']) || !isset($data['init_tab']) || !rcl_get_option('rating_' . $type)) continue;

        $tabsData[] = array(
            'id' => $data['rating_type'],
            'name' => $data['type_name'],
            'icon' => (isset($data['icon']))? $data['icon']: 'fa-list-ul',
            'callback' => array(
                'name' => 'rcl_get_reviews_tab',
                'args' => array(
                    array(
                        'object_author' => $rcl_office,
                        'rating_type' => $type,
                        'add_form' => isset($data['add_form'])? $data['add_form']: false
                    )
                )
            )
        );

    }

    if(!$tabsData) return false;

    rcl_tab(
        array(
            'id'=>'reviews',
            'name'=>__('Reviews'),
            'supports'=>array('ajax'),
            'public'=>1,
            'icon'=>'fa-comment',
            'content'=> $tabsData
        )
    );



}

function rcl_get_reviews_tab($args){
    global $user_ID;

    $master_id = $args['object_author'];
    $rating_type = $args['rating_type'];
    $add_form = $args['add_form'];

    $content = '';

    if($add_form && $user_ID != $master_id){

        $userRvwId = rcl_get_review_by_args(array(
            'object_id' => $master_id,
            'rating_type' => $rating_type,
            'user_id' => $user_ID,
            'fields' => array('review_id')
        ));

        if(!$userRvwId){

            $content = rcl_get_review_form(array(
                'object_id' => $master_id,
                'rating_type' => $rating_type,
                'object_author' => $master_id,
                'user_id' => $user_ID
            ));

        }

    }

    $reviewsList = rcl_get_reviews_list(array(
        'object_author' => $master_id,
        'rating_type' => $rating_type
    ));

    if(!$reviewsList) return $content . '<p>'.__('No reviews have been left yet.').'</p>';

    $content .= $reviewsList;

    return $content;

}

add_action('rcl_pre_edit_rating_post','rcl_add_rating_data_review_form');
function rcl_add_rating_data_review_form($data){
    global $rcl_rating_types;

    $reviewTypes = array();

    foreach($rcl_rating_types as $type => $dataRating){
        if(!isset($dataRating['review-type'])) continue;
        $reviewTypes[] = $type;
    }

    if(!in_array($data['rating_type'], $reviewTypes)) return false;

    wp_send_json(array_merge($data, array('rcl-review'=>1)));

}

add_action('rcl_include_template_before', 'rcl_add_review_manager', 10);
function rcl_add_review_manager($template_name){
    global $review;

    if($template_name != 'rvs-review.php') return false;

    echo rcl_get_review_manager();

}

add_action('rcl_pre_delete_review', 'rcl_delete_rating_review', 10, 2);
function rcl_delete_rating_review($review_id, $review){

    rcl_delete_rating(array(
        'object_author' => $review->object_author,
        'object_id' => $review->object_id,
        'rating_type' => $review->rating_type,
        'user_id' => $review->user_id,
    ));

}

add_action('delete_user','rcl_delete_user_reviews', 10);
function rcl_delete_user_reviews($user_id){

    $reviews = rcl_get_reviews(array(
        'user_id' => $user_id,
        'number' => -1
    ));

    if(!$reviews) return false;

    foreach($reviews as $review){
        rcl_delete_review($review->review_id);
    }

}