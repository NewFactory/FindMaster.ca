<?php

add_shortcode('fng-search-form', 'fng_get_search_form');
function fng_get_search_form($atts = false){
    global $wpdb;

    extract(shortcode_atts(array(
        'type'=> 'vertical'
    ),
    $atts));

    $maxPrice = $wpdb->get_var("SELECT MAX(cast(postmeta.meta_value as unsigned)) FROM $wpdb->postmeta AS postmeta "
                    . "INNER JOIN $wpdb->posts AS posts ON postmeta.post_id=posts.ID "
                    . "WHERE posts.post_type = 'task' "
                    . "AND posts.post_status='publish' "
                    . "AND postmeta.meta_key='fng-price'");

    $terms = get_terms( array(
        'taxonomy' => 'task-subject',
        'hide_empty' => false,
        'parent' => 0
    ) );

    $category = array( '' => __('Все категории') );
    foreach($terms as $term){
        $category[$term->term_id] = $term->name;
    }

    $fields = array(
        array(
            'type' => 'text',
            'slug' => 'fs',
            'default' => isset($_GET['fs'])? $_GET['fs']: '',
            'title' => __('Поиск по слову'),
            'placeholder' => __('Поиск...')
        ),
        array(
            'type' => 'select',
            'slug' => 'fstatus',
            'title' => __('Статус'),
            'values' => array(
                0 => __('Все задания'),
                1 => __('Подбор исполнителя'),
                2 => __('В работе'),
                5 => __('Завершено')
            ),
            'default' => isset($_GET['fstatus'])? $_GET['fstatus']: 0,
        ),
        array(
            'type' => 'select',
            'slug' => 'fsubject',
            'title' => __('Категория'),
            'default' => isset($_GET['fsubject'])? $_GET['fsubject']: '',
            'values' => $category
        ),
        array(
            'type' => 'range',
            'slug' => 'fprice',
            'title' => __('Стоимость'),
            'value_max' => ($maxPrice && $maxPrice > 5000)? $maxPrice: 5000,
            'value_step' => 100,
            'default' => isset($_GET['fprice'])? $_GET['fprice']: '',
        ),
        array(
            'type' => 'radio',
            'slug' => 'forderby',
            'title' => __('Сортировка по'),
            'values' => array(
                'date' => __('дате'),
                'price' => __('стоимости')
            ),
            'default' => isset($_GET['forderby'])? $_GET['forderby']: 'date',
        ),
        array(
            'type' => 'radio',
            'slug' => 'forder',
            'title' => __('Вывод по'),
            'values' => array(
                'DESC' => __('убыванию'),
                'ASC' => __('возрастанию')
            ),
            'default' => isset($_GET['forder'])? $_GET['forder']: 'DESC',
        ),
        array(
            'type' => 'hidden',
            'slug' => 'post_type',
            'value' => 'task'
        )
    );

    $fields = apply_filters('fng_search_fields', $fields);

    $content = '<div class="fng-search-form type-'.$type.'">';

    $content .= rcl_get_form(array(
        'fields' => $fields,
        'method' => 'get',
        'action' => get_post_type_archive_link('task'),
        'submit' => __('Найти задание')
    ));

    $content .= '</div>';

    return $content;

}

