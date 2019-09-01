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
            'name' => __('Задания'),
            'singular_name' => __('Задание'),
            'add_new' => __('Добавить'),
            'add_new_item' => __('Добавить'),
            'edit_item' => __('Изменить'),
            'new_item' => __('Новая'),
            'view_item' => __('Просмотр'),
            'search_items' => __('Поиск'),
            'not_found' => __('Не найдено'),
            'not_found_in_trash' => __('Не найдено'),
            'parent_item_colon' => __('Родительское задание'),
            'menu_name' => __('Задания'),
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
            'name' => __('Темы заданий'),
            'singular_name' => __('Тема задания'),
            'search_items' => __('Поиск'),
            'popular_items' => __('Популярное'),
            'all_items' => __('Все'),
            'parent_item' => __('Родительская тема'),
            'parent_item_colon' => __('Родительская тема'),
            'edit_item' => __('Изменить'),
            'update_item' => __('Обновить'),
            'add_new_item' => __('Добавить'),
            'new_item_name' => __('Новая'),
            'separate_items_with_commas' => __('Разделять запятой'),
            'add_or_remove_items' => __('Добавить или удалить'),
            'choose_from_most_used' => __('Нажмите для использования','wp-recall'),
            'menu_name' => __('Темы заданий')
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