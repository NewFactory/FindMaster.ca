<?php

add_action('wp', 'fng_check_edit_button', 10);
function fng_check_edit_button(){
    global $post, $user_ID, $WAU_Post;
    
    if(!is_singular('task')) return false;
    
    $status = get_post_meta($post->ID, 'fng-status', 1);
    
    if($status != 1){
        remove_action('rcl_post_bar_setup','rcl_setup_edit_post_button',10);
    }
    
    if($status == 5){
        remove_filter('the_content','rcl_concat_post_meta',10);
    }
    
    if($WAU_Post && $WAU_Post->access){
        if($post->post_author == $user_ID){
            remove_filter('the_content', 'wau_filter_content', wau_get_option('filter-priority',10));
        }
    }
}

add_action( 'init', 'fng_init_post_type_task',10 );
function fng_init_post_type_task() {

    $args = array(
        'labels' => array(
            'name' => __('Tasks'),
            'singular_name' => __('The task'),
            'add_new' => __('Add'),
            'add_new_item' => __('Add'),
            'edit_item' => __('Edit'),
            'new_item' => __('New'),
            'view_item' => __('View'),
            'search_items' => __('Search'),
            'not_found' => __('Not found'),
            'not_found_in_trash' => __('Not found'),
            'parent_item_colon' => __('Parent task'),
            'menu_name' => __('Tasks'),
        ),
        'supports' => array( 
            'title',
            'editor',
            'custom-fields', 
            'thumbnail',
            'author',
            //'comments'
        ),
        'taxonomies' => array( 
            'task-subject'
        ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'task', $args );
    
}

add_action( 'init', 'fng_init_taxonomy_task_subject',10 );
function fng_init_taxonomy_task_subject() {

    $args = array(
        'labels' => array(
            'name' => __('Assignment topics'),
            'singular_name' => __('Theme of the task'),
            'search_items' => __('Search'),
            'popular_items' => __('Popular'),
            'all_items' => __('Everything'),
            'parent_item' => __('Parent theme'),
            'parent_item_colon' => __('Parent theme'),
            'edit_item' => __('Edit'),
            'update_item' => __('Refresh'),
            'add_new_item' => __('Add'),
            'new_item_name' => __('New'),
            'separate_items_with_commas' => __('Separate comma'),
            'add_or_remove_items' => __('Add or remove'),
            'choose_from_most_used' => __('Click to use','wp-recall'),
            'menu_name' => __('Assignment Topics')
        ),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'task-subject', array('task'), $args );
    
}