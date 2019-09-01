<?php

function fng_get_task_default_fields(){

    $fields = array(
        array(
            'slug' => 'fng-price',
            'type' => 'number',
            'title' => __('Job cost ('.rcl_get_primary_currency(1).')'),
            'notice' => __('indicate the cost of the job as an integer, it can be changed when approving the contractor'),
            'required' => 1,
            'value_min' => 0
        ),
        array(
            'slug' => 'fng-days',
            'type' => 'number',
            'title' => __('Deadline (in days)'),
            'notice' => __('indicate the deadline for completing the task after which the question arises of changing the contractor or extending the deadline'),
            'required' => 1,
            'default' => 1,
            'value_min' => 1
        )
    );

    return $fields;

}

add_filter('rcl_public_form_fields', 'fng_add_task_default_fields', 10, 2);
function fng_add_task_default_fields($fields, $form){

    if(!in_array($form->post_type, array('task'))) return $fields;

    if($fields){
        $fields = array_merge($fields, fng_get_task_default_fields());
    }else{
        $fields = fng_get_task_default_fields();
    }

    return $fields;

}

add_action('update_post_rcl','fng_update_task_meta',10,3);
function fng_update_task_meta($post_id, $postdata, $update){

    if($postdata['post_type'] != 'task') return false;

    update_post_meta($post_id, 'fng-price', $_POST['fng-price']);
    update_post_meta($post_id, 'fng-days', $_POST['fng-days']);

    if(!$update)
        update_post_meta($post_id, 'fng-status', 1);

}

add_action('save_post', 'fng_update_custom_fields_with_save_task', 0);
function fng_update_custom_fields_with_save_task( $post_id ){

    if(!isset($_POST['custom_fields_nonce_rcl']) || $_POST['post_type'] != 'task') return false;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
    if ( !current_user_can('edit_post', $post_id) ) return false;

    if(isset($_POST['fng-status']))
        update_post_meta($post_id, 'fng-status', $_POST['fng-status']);

    update_post_meta($post_id, 'fng-price', $_POST['fng-price']);
    update_post_meta($post_id, 'fng-days', $_POST['fng-days']);

}