<?php

function fng_get_task_default_fields(){
    
    $fields = array(
        array(
            'slug' => 'fng-task-price',
            'type' => 'number',
            'title' => __('Cost of service (CA$)'),
            'required' => 1
        ),
        array(
            'slug' => 'fng-days',
            'type' => 'number',
            'title' => __('Deadline (in days)'),
            'required' => 1
        )
    );
    
    return $fields;
    
}

add_filter('rcl_public_form_fields', 'fng_edit_task_form_fields', 10, 2);
function fng_edit_task_form_fields($fields, $form){
    global $user_ID;
    
    if($form->post_type != 'task-task') return $fields;
    
    if(!isset($_GET['rcl-post-edit'])){
        if(!is_admin() && !isset($_GET['fng-master-id']) || $user_ID == $_GET['fng-master-id']){
            
            if(get_user_meta($user_ID, 'fng-account', 1) == 'Executor'){
                add_filter('rcl_public_form_errors', 'fng_add_task_form_performer_error', 10, 2);
            }else{
                add_filter('rcl_public_form_errors', 'fng_add_task_form_error', 10, 2);
            }

            return $fields;
        }
    }
    
    $post = get_post($form->post_id);
    
    if($user_ID == $post->post_author){

        $fields[] = array(
            'slug' => 'fng-address',
            'type' => 'textarea',
            'title' => __('Contact details'),
            'default' => get_user_meta($user_ID, 'fng-address', 1),
            'required' => 1
        );
    
    }

    $fields = array_merge($fields, fng_get_task_default_fields());
    
    $fields[] = array(
        'type' => 'hidden',
        'slug' => 'fng-master-id',
        'value' => $_GET['fng-master-id']
    );

    return $fields;
    
}

function fng_add_task_form_error($errors, $form){
    $errors[] = __('Custom order not available');
    return $errors;
}

function fng_add_task_form_performer_error($errors, $form){
    $errors[] = __('The contractor cannot place individual orders');
    return $errors;
}

add_filter('rcl_custom_fields_post', 'fng_add_task_default_fields', 10, 3);
function fng_add_task_default_fields($fields, $post_id, $post_type){
    
    if($post_type != 'task-task') return $fields;

    $fields = $fields? array_merge($fields, fng_get_task_default_fields()): fng_get_task_default_fields();

    return $fields;
    
}
//изменение прав публикации и редактирования
add_filter('rcl_public_form_user_can', 'fng_can_master_edit_task', 10, 2);
add_filter('rcl_public_update_user_can', 'fng_can_master_edit_task', 10, 2);
function fng_can_master_edit_task($userCan, $form){
    global $user_ID;
    
    if($form->post_type != 'task-task' || !$form->post_id) return $userCan;
    
    if(get_post_meta($form->post_id, 'fng-task-status', 1) != 1)  return $userCan;

    if($user_ID != get_post_meta($form->post_id, 'fng-master-id', 1)) return $userCan;
    
    $userCan['edit'] = true;
    
    return $userCan;
}

//публикация индивидуального заказа
add_action('update_post_rcl','fng_add_custom_task_meta',10,3);
function fng_add_custom_task_meta($taskId, $postdata, $update){
    global $user_ID;
    
    if($postdata['post_type'] != 'task-task') return false;
    
    $post = get_post($taskId);
    
    if($user_ID != $post->post_author) return false;
    
    $data = $_POST;

    $masterId = intval($data['fng-master-id']);
    
    if(!$masterId){
        $task = get_post($taskId);
        $masterId = $task->post_author;
    }

    update_post_meta($taskId, 'fng-task-id', 0);

    update_post_meta($taskId, 'fng-master-id', $masterId);
    update_post_meta($taskId, 'fng-task-price', $data['fng-task-price']);
    update_post_meta($taskId, 'fng-days', $data['fng-days']);
    
    fng_update_task_status($taskId, 1);

    if($user_ID == $post->post_author){
        update_user_meta($user_ID, 'fng-address', $data['fng-address']);
        update_post_meta($taskId, 'fng-task-comment', $data['fng-task-comment']);
    }

    do_action('fng_task_create', $taskId);

}

//изменение заказа исполнителем
add_action('update_post_rcl', 'fng_update_master_task', 10, 3);
function fng_update_master_task($post_id, $postdata, $update){
    global $user_ID;
    
    if(!$update || $postdata['post_type'] != 'task-task') return false;
    
    $post = get_post($post_id);
    
    if($post->post_author != $user_ID){

        if($user_ID != get_post_meta($post_id, 'fng-master-id', 1)) return false;
        
        $data = $_POST;
        
        $task = get_post($post_id);
        
        fng_update_task_status($post_id, 2);
        
        update_post_meta($post_id, 'fng-task-id', $task->ID);
        
        update_post_meta($post_id, 'fng-task-price', $data['fng-task-price']);
        update_post_meta($post_id, 'fng-days', $data['fng-days']);
        
        do_action('fng_task_master_edit', $post_id);
        
    }
    
}
