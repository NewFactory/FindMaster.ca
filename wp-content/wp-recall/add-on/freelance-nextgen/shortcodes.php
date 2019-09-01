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

    $category = array( '' => __('All categories') );
    foreach($terms as $term){
        $category[$term->term_id] = $term->name;
    }

    $fields = array(
        array(
            'type' => 'text',
            'slug' => 'fs',
            'default' => isset($_GET['fs'])? $_GET['fs']: '',
            'title' => __('Search by word'),
            'placeholder' => __('Search...')
        ),
        array(
            'type' => 'select',
            'slug' => 'fstatus',
            'title' => __('Status'),
            'values' => array(
                0 => __('All tasks'),
                1 => __('Artist selection'),
                2 => __('In work'),
                5 => __('Completed')
            ),
            'default' => isset($_GET['fstatus'])? $_GET['fstatus']: 0,
        ),
        array(
            'type' => 'select',
            'slug' => 'fsubject',
            'title' => __('Category'),
            'default' => isset($_GET['fsubject'])? $_GET['fsubject']: '',
            'values' => $category
        ),
        array(
            'type' => 'range',
            'slug' => 'fprice',
            'title' => __('Cost'),
            'value_max' => ($maxPrice && $maxPrice > 5000)? $maxPrice: 5000,
            'value_step' => 100,
            'default' => isset($_GET['fprice'])? $_GET['fprice']: '',
        ),
        array(
            'type' => 'radio',
            'slug' => 'forderby',
            'title' => __('Sort by'),
            'values' => array(
                'date' => __('the date'),
                'price' => __('cost')
            ),
            'default' => isset($_GET['forderby'])? $_GET['forderby']: 'date',
        ),
        array(
            'type' => 'radio',
            'slug' => 'forder',
            'title' => __('Conclusion on'),
            'values' => array(
                'DESC' => __('descending'),
                'ASC' => __('ascending')
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
        'submit' => __('Find a task')
    ));

    $content .= '</div>';

    return $content;

}

