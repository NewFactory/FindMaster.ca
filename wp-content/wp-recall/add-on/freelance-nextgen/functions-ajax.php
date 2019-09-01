<?php

rcl_ajax_action('fng_ajax_add_request');
function fng_ajax_add_request(){
    global $user_ID;
    
    $price = intval($_POST['request-price']);
    $content = $_POST['request-content'];
    $task_id = $_POST['request-task'];
    
    if(!$content){
        wp_send_json(array(
            'error' => __('The application text must not be empty!')
        ));
    }
    
    if(!$price){
        wp_send_json(array(
            'error' => __('Incorrect value of the desired value, specify a number!')
        ));
    }

    $result = fng_insert_request(array(
        'author_id' => $user_ID,
        'task_id' => $task_id,
        'request_content' => $content,
        'request_price' => $price
    ));

    if(!$result) 
        wp_send_json(array(
            'error' => __('Failed to add application to the task!')
        ));

    wp_send_json(array(
        'success' => __('Application successfully added!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_edit_request');
function fng_ajax_edit_request(){
    global $user_ID;
    
    $price = intval($_POST['request-price']);
    $content = $_POST['request-content'];
    $request_id = $_POST['request-id'];
    
    if(!$content){
        wp_send_json(array(
            'error' => __('The application text must not be empty!')
        ));
    }
    
    if(!$price){
        wp_send_json(array(
            'error' => __('Incorrect value of the desired value, specify a number!')
        ));
    }

    fng_update_request($request_id, array(
        'request_content' => $content,
        'request_price' => $price
    ));

    wp_send_json(array(
        'success' => __('Application successfully changed!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_answer_form');
function fng_ajax_get_answer_form(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);
    
    $request = fng_get_request($request_id);
    
    $post = get_post($request->task_id);
    
    $placeholder = __('Your answer will be visible only to the author of the application');
    
    if($request->author_id == $user_ID){
        $placeholder = __('Your answer will be visible only to the author of the task');
    }
    
    $content = rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'answer',
                'type' => 'textarea',
                'placeholder' => $placeholder,
                'required' => 1
            ),
            array(
                'slug' => 'request_id',
                'type' => 'hidden',
                'value' => $request_id
            )
        ),
        'submit' => __('Submit'),
        'onclick' => 'fng_ajax_add_answer(this);return false;'
    ));

    wp_send_json(array(
        'form' => $content
    ));
    
}

rcl_ajax_action('fng_ajax_add_answer');
function fng_ajax_add_answer(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);
    $answer = $_POST['answer'];
    
    if(!$answer){
        wp_send_json(array(
            'error' => __('The text of the answer should not be empty!')
        ));
    }

    $comment_id = fng_insert_comment(array(
        'author_id' => $user_ID,
        'comment_content' => $answer,
        'request_id' => $request_id
    ));

    if(!$comment_id) 
        wp_send_json(array(
            'error' => __('Failed to add response.')
        ));

    wp_send_json(array(
        'answer' => rcl_get_include_template('fng-comment.php', __FILE__, array(
            'fng_comment' => fng_get_comment($comment_id)
        ))
    ));
    
}

rcl_ajax_action('fng_ajax_request_reject');
function fng_ajax_request_reject(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);

    if(!$request_id){
        wp_send_json(array(
            'error' => __('Application ID was not received!')
        ));
    }

    fng_update_request($request_id, array(
        'request_status' => 0
    ));
    
    do_action('fng_request_reject', $request_id);

    wp_send_json(array(
        'success' => __('Application rejected!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_request_edit_form');
function fng_ajax_get_request_edit_form(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);

    if(!$request_id){
        wp_send_json(array(
            'error' => __('Application ID was not received!')
        ));
    }
    
    $request = fng_get_request($request_id);
    
    $content = rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'request-price',
                'type' => 'number',
                'title' => __('Desired order value'),
                'default' => $request->request_price,
                'required' => 1
            ),
            array(
                'slug' => 'request-content',
                'type' => 'editor',
                //'tinymce' => 1,
                'quicktags' => 'strong,em,link,close,block,del',
                'title' => __('Application text'),
                'default' => $request->request_content,
                'required' => 1
            ),
            array(
                'slug' => 'request-id',
                'type' => 'hidden',
                'value' => $request_id
            )
        ),
        'submit' => __('Change application'),
        'onclick' => 'rcl_send_form_data("fng_ajax_edit_request",this);return false;'
    ));

    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Changing the application for the task'),
            'size' => 'medium',
            'class' => 'fng-dialog'
        )
    ));
    
}

rcl_ajax_action('fng_ajax_get_request_payment_form');
function fng_ajax_get_request_payment_form(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);
    
    if(!rcl_get_option('fng-reserve')){
        
        fng_request_take($request_id);
        
        wp_send_json(array(
            'success' => __('Contractor successfully appointed'),
            'reload' => true
        ));
        
    }
    
    $request = fng_get_request($request_id);
    
    $content = '<p>'.__('User approval as an executor to '
            . 'his assignment is possible only after reserving funds to pay for his services.').'</p>';
    
    $content .= '<p>'.__('The contractor will receive the reserved funds only after you confirm the completion of the order.').'.</p>';

    $content .= '<p>'.__('Reservation required for current job').' '.$request->request_price.' '.  rcl_get_primary_currency(1).'</p>';
    
    $payArgs = array(
        'baggage_data' => array(
            'request_id' => $request_id
        ),
        'pay_type' => 'fng-payment',
        'pay_systems_not_in' => array('yandexdengi'),
        'user_id' => $user_ID,
        'pay_summ' => $request->request_price,
        'description' => __('Reservation of funds to pay for the services of the contractor'),
        'merchant_icon' => 1
    );
    
    $balance = rcl_get_user_balance($user_ID);
    
    if($balance < $request->request_price){
        
        $payArgs['payment_system_not_in'][] = 'user_balance';
        
        $content .= '<p>'.__('You cannot pay from the internal balance - not enough funds.').'</p>';
        
    }else{
        $content .= '<p>'.__('There are enough funds on your internal balance, you can make a payment from it.').'</p>';
    }
    
    $result = array(
        'dialog' => array(
            'content' => $content . rcl_get_pay_form($payArgs),
            'title' => __('Reservation of funds for payment'),
            'size' => 'small',
            'class' => 'fng-dialog'
        )
    );
    
    wp_send_json($result);
}

rcl_ajax_action('fng_ajax_add_time_form');
function fng_ajax_add_time_form(){
    
    rcl_verify_ajax_nonce();
    
    $task_id = intval($_POST['task_id']);
    
    $days = get_post_meta($task_id, 'fng-days', 1);
    
    $result = array(
        'dialog' => array(
            'content' => rcl_get_form(array(
                'fields' => array(
                    array(
                        'slug' => 'fng-days',
                        'type' => 'runner',
                        'title' => __('Number of days to finalize'),
                        'value_min' => 1,
                        'value_max' => ceil($days/2) + 10
                    ),
                    array(
                        'slug' => 'task_id',
                        'type' => 'hidden',
                        'value' => $task_id
                    )
                ),
                'onclick' => 'rcl_send_form_data("fng_ajax_task_add_time",this);return false;',
                'submit' => __('Add execution time')
            )),
            'title' => __('Longer lead time'),
            'size' => 'auto',
            'class' => 'fng-dialog'
        )
    );
    
    wp_send_json($result);
}

rcl_ajax_action('fng_ajax_task_add_time');
function fng_ajax_task_add_time(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The job ID was not received!')
        ));
    }
    
    $addDays = $_POST['fng-days'];

    $days = get_post_meta($task_id, 'fng-days', 1) + $addDays;
    
    update_post_meta($task_id, 'fng-days', $days);
    update_post_meta($task_id, 'fng-status', 2);
    
    fng_add_service_message($task_id, __('Increased task execution time by ').$addDays.' '.__('days.'));
    
    do_action('fng_task_add_time', $task_id, $addDays);

    wp_send_json(array(
        'success' => __('Time added!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_request_remove');
function fng_ajax_request_remove(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);

    if(!$request_id){
        wp_send_json(array(
            'error' => __('Application ID was not received!')
        ));
    }

    fng_delete_request($request_id);

    wp_send_json(array(
        'success' => __('Application deleted!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_performer_fail');
function fng_ajax_performer_fail(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);
    
    if($user_ID != get_post_meta($task_id, 'fng-performer', 1)){
        wp_send_json(array(
            'error' => __('You cannot refuse to complete an order!')
        ));
    }

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The order ID was not received!')
        ));
    }

    fng_performer_fail($task_id);

    wp_send_json(array(
        'success' => __('You refused to perform!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_performer_fired');
function fng_ajax_performer_fired(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The order ID was not received!')
        ));
    }

    fng_performer_fired($task_id);

    wp_send_json(array(
        'success' => __('You have refused the artist!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_task_complete');
function fng_ajax_task_complete(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The order ID was not received!')
        ));
    }

    fng_task_complete($task_id);

    wp_send_json(array(
        'success' => __('The task is completed!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_claim_form');
function fng_ajax_get_claim_form(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The order ID was not received!')
        ));
    }
    
    $content = '<p>'.__('You are about to file a complaint with the arbitration.<br>'
            . 'Please note that after considering a complaint, the administration can only make two decisions:<br>'
            . '1. The task will be completed, the contractor will receive payment<br>'
            . '2. The contractor will be recalled, the funds will be returned to the author of the task<br>'
            . 'Enter the details of your complaint in the form below and click "Submit"').'</p>';
    
    $content .= rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'claim_text',
                'type' => 'textarea',
                'title' => __('Complaint text'),
                'required' => 1
            ),
            array(
                'slug' => 'task_id',
                'type' => 'hidden',
                'value' => $task_id
            )
        ),
        'submit' => __('Submit'),
        'onclick' => 'rcl_send_form_data("fng_ajax_add_claim",this);return false;'
    ));

    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Arbitration complaint'),
            'size' => 'medium',
            'class' => 'fng-dialog'
        )
    ));
    
}

rcl_ajax_action('fng_ajax_add_claim');
function fng_ajax_add_claim(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);
    $claim_text = $_POST['claim_text'];

    if(!$task_id){
        wp_send_json(array(
            'error' => __('The order ID was not received!')
        ));
    }
    
    if(!$claim_text){
        wp_send_json(array(
            'error' => __('The complaint text cannot be empty!')
        ));
    }

    $result = fng_task_claim($task_id, $user_ID, $claim_text);
    
    if(!$result){
        wp_send_json(array(
            'error' => __('Failed to file a complaint. Try again.')
        ));
    }

    wp_send_json(array(
        'success' => __('Complaint successfully added!'),
        'reload' => true
    ));
    
}