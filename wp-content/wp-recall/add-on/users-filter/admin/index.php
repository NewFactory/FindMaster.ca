<?php

add_action('admin_menu', 'usf_init_manager',30);
function usf_init_manager(){
    add_submenu_page( 'manage-wprecall', __('Фильтр пользователей'), __('Фильтр пользователей'), 'manage_options', 'usf-manager', 'usf_manager');
}

function usf_manager(){

    rcl_sortable_scripts();

    $Manager = new Usf_Manager('users_filter', array(
        'create-field' => false
    ));

    $content = '<h2>'.__('Менеджер фильтра пользователей').'</h2>';

    $content .= $Manager->active_fields_box();

    $content .= $Manager->inactive_fields_box();

    echo $content;

}


add_filter('rcl_custom_field_constant_options', 'usf_edit_field_constant_options', 10, 3);
function usf_edit_field_constant_options($options, $field, $type){

    if(!isset($field['slug']) || $type != 'users_filter') return $options;

    if(!isset($field['profile-type-field'])){

        $options[] = array(
            'type' => 'hidden',
            'slug' => 'profile-type-field',
            'value' => $field['type']
        );

    }else{

        $options[] = array(
            'type' => 'hidden',
            'slug' => 'profile-type-field',
            'value' => $field['profile-type-field']
        );

    }

    return $options;

}

add_filter('rcl_custom_field_options', 'usf_edit_field_options', 10, 3);
function usf_edit_field_options($options, $field, $type){

    if(!isset($field['slug']) || $type != 'users_filter') return $options;

    if(!isset($field['profile-type-field'])){

        $typeField = $field['type'];

    }else{

        $typeField = $field['profile-type-field'];

    }

    //print_r($options);
    if(in_array($typeField, array(
        'text', 'textarea'
    ))){
        $options[] = array(
            'type' => 'radio',
            'slug' => 'search-values',
            'title' => __('Порядок поиска'),
            'values' => array(
                0 => __('Точное вхождение строки'),
                1 => __('Поиск среди значений')
            )
        );
    }

    if(in_array($field['type'], array(
        'checkbox', 'multiselect', 'dynamic'
    ))){
        $options[] = array(
            'type' => 'radio',
            'slug' => 'search-values',
            'title' => __('Порядок поиска'),
            'values' => array(
                0 => __('Точное вхождение значений'),
                1 => __('Поиск среди значений')
            )
        );
    }




    return $options;

}

add_action('rcl_update_custom_fields','usf_update_filter_settings',10);
function usf_update_filter_settings(){
    rcl_update_option('usf-relation',$_POST['usf-relation']);
}

add_filter('rcl_pre_update_options', 'usf_add_filter_options_value', 10);
function usf_add_filter_options_value($option){
    $option['usf-relation'] = rcl_get_option('usf-relation','AND');
    return $option;
}