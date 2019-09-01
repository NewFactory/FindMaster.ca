<?php

rcl_ajax_action('fng_ajax_add_request');
function fng_ajax_add_request(){
    global $user_ID;
    
    $price = intval($_POST['request-price']);
    $content = $_POST['request-content'];
    $task_id = $_POST['request-task'];
    
    if(!$content){
        wp_send_json(array(
            'error' => __('Текст заявки не должен быть пустым!')
        ));
    }
    
    if(!$price){
        wp_send_json(array(
            'error' => __('Некорректное значение желаемой стоимости, укажите число!')
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
            'error' => __('Не удалось добавить заявку к заданию!')
        ));

    wp_send_json(array(
        'success' => __('Заявка успешно добавлена!'),
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
            'error' => __('Текст заявки не должен быть пустым!')
        ));
    }
    
    if(!$price){
        wp_send_json(array(
            'error' => __('Некорректное значение желаемой стоимости, укажите число!')
        ));
    }

    fng_update_request($request_id, array(
        'request_content' => $content,
        'request_price' => $price
    ));

    wp_send_json(array(
        'success' => __('Заявка успешно изменена!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_answer_form');
function fng_ajax_get_answer_form(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);
    
    $request = fng_get_request($request_id);
    
    $post = get_post($request->task_id);
    
    $placeholder = __('Ваш ответ будет виден только автору заявки');
    
    if($request->author_id == $user_ID){
        $placeholder = __('Ваш ответ будет виден только автору задания');
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
        'submit' => __('Отправить'),
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
            'error' => __('Текст ответа не должен быть пустым!')
        ));
    }

    $comment_id = fng_insert_comment(array(
        'author_id' => $user_ID,
        'comment_content' => $answer,
        'request_id' => $request_id
    ));

    if(!$comment_id) 
        wp_send_json(array(
            'error' => __('Не удалось добавить ответ')
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
            'error' => __('Не был получен ID заявки!')
        ));
    }

    fng_update_request($request_id, array(
        'request_status' => 0
    ));
    
    do_action('fng_request_reject', $request_id);

    wp_send_json(array(
        'success' => __('Заявка отклонена!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_request_edit_form');
function fng_ajax_get_request_edit_form(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);

    if(!$request_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заявки!')
        ));
    }
    
    $request = fng_get_request($request_id);
    
    $content = rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'request-price',
                'type' => 'number',
                'title' => __('Желаемая стоимость заказа'),
                'default' => $request->request_price,
                'required' => 1
            ),
            array(
                'slug' => 'request-content',
                'type' => 'editor',
                //'tinymce' => 1,
                'quicktags' => 'strong,em,link,close,block,del',
                'title' => __('Текст заявки'),
                'default' => $request->request_content,
                'required' => 1
            ),
            array(
                'slug' => 'request-id',
                'type' => 'hidden',
                'value' => $request_id
            )
        ),
        'submit' => __('Изменить заявку'),
        'onclick' => 'rcl_send_form_data("fng_ajax_edit_request",this);return false;'
    ));

    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Изменение заявки к заданию'),
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
            'success' => __('Исполнитель успешно назначен'),
            'reload' => true
        ));
        
    }
    
    $request = fng_get_request($request_id);
    
    $content = '<p>'.__('Утверждение пользователя в качестве исполнителя к '
            . 'своему заданию возможно только после резервирования средств на оплату его услуг.').'</p>';
    
    $content .= '<p>'.__('Зарезервированные средства исполнитель получит только после того, как вы подтвердите выполнение заказа').'.</p>';

    $content .= '<p>'.__('Для текущего задания требуется зарезервировать').' '.$request->request_price.' '.  rcl_get_primary_currency(1).'</p>';
    
    $payArgs = array(
        'baggage_data' => array(
            'request_id' => $request_id
        ),
        'pay_type' => 'fng-payment',
        'pay_systems_not_in' => array('yandexdengi'),
        'user_id' => $user_ID,
        'pay_summ' => $request->request_price,
        'description' => __('Резервирование средств на оплату услуг исполнителя задания'),
        'merchant_icon' => 1
    );
    
    $balance = rcl_get_user_balance($user_ID);
    
    if($balance < $request->request_price){
        
        $payArgs['payment_system_not_in'][] = 'user_balance';
        
        $content .= '<p>'.__('Вы не можете произвести оплату с внутреннего баланса - недостаточно средств.').'</p>';
        
    }else{
        $content .= '<p>'.__('На вашем внутреннем балансе достаточно средств, можете произвести оплату с него.').'</p>';
    }
    
    $result = array(
        'dialog' => array(
            'content' => $content . rcl_get_pay_form($payArgs),
            'title' => __('Резервирование средств на оплату'),
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
                        'title' => __('Количество дней на доработку'),
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
                'submit' => __('Добавить время на выполнение')
            )),
            'title' => __('Увеличение срока выполнения'),
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
            'error' => __('Не был получен ID задания!')
        ));
    }
    
    $addDays = $_POST['fng-days'];

    $days = get_post_meta($task_id, 'fng-days', 1) + $addDays;
    
    update_post_meta($task_id, 'fng-days', $days);
    update_post_meta($task_id, 'fng-status', 2);
    
    fng_add_service_message($task_id, __('Увеличено время выполнения задания на ').$addDays.' '.__('дней.'));
    
    do_action('fng_task_add_time', $task_id, $addDays);

    wp_send_json(array(
        'success' => __('Время добавлено!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_request_remove');
function fng_ajax_request_remove(){
    global $user_ID;
    
    $request_id = intval($_POST['request_id']);

    if(!$request_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заявки!')
        ));
    }

    fng_delete_request($request_id);

    wp_send_json(array(
        'success' => __('Заявка удалена!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_performer_fail');
function fng_ajax_performer_fail(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);
    
    if($user_ID != get_post_meta($task_id, 'fng-performer', 1)){
        wp_send_json(array(
            'error' => __('Вы не можете отказаться от выполнения заказа!')
        ));
    }

    if(!$task_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заказа!')
        ));
    }

    fng_performer_fail($task_id);

    wp_send_json(array(
        'success' => __('Вы отказались от выполнения!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_performer_fired');
function fng_ajax_performer_fired(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заказа!')
        ));
    }

    fng_performer_fired($task_id);

    wp_send_json(array(
        'success' => __('Вы отказались от исполнителя!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_task_complete');
function fng_ajax_task_complete(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заказа!')
        ));
    }

    fng_task_complete($task_id);

    wp_send_json(array(
        'success' => __('Задание выполнено!'),
        'reload' => true
    ));
    
}

rcl_ajax_action('fng_ajax_get_claim_form');
function fng_ajax_get_claim_form(){
    global $user_ID;
    
    $task_id = intval($_POST['task_id']);

    if(!$task_id){
        wp_send_json(array(
            'error' => __('Не был получен ID заказа!')
        ));
    }
    
    $content = '<p>'.__('Вы собираетесь подать жалобу в арбитраж.<br>'
            . 'Учтите, что после рассмотрения жалобы администрация может вынести только два решения:<br>'
            . '1. Задание будет завершено, исполнитель получит оплату<br>'
            . '2. Исполнитель будет отозван, средства будут возвращены автору задания<br>'
            . 'Укажите детали вашей жалобы в форме ниже и нажмите "Отправить"').'</p>';
    
    $content .= rcl_get_form(array(
        'fields' => array(
            array(
                'slug' => 'claim_text',
                'type' => 'textarea',
                'title' => __('Текст жалобы'),
                'required' => 1
            ),
            array(
                'slug' => 'task_id',
                'type' => 'hidden',
                'value' => $task_id
            )
        ),
        'submit' => __('Отправить'),
        'onclick' => 'rcl_send_form_data("fng_ajax_add_claim",this);return false;'
    ));

    wp_send_json(array(
        'dialog' => array(
            'content' => $content,
            'title' => __('Подача жалобы в арбитраж'),
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
            'error' => __('Не был получен ID заказа!')
        ));
    }
    
    if(!$claim_text){
        wp_send_json(array(
            'error' => __('Текст жалобы не может быть пустым!')
        ));
    }

    $result = fng_task_claim($task_id, $user_ID, $claim_text);
    
    if(!$result){
        wp_send_json(array(
            'error' => __('Не удалось подать жалобу. Попробуйте еще раз.')
        ));
    }

    wp_send_json(array(
        'success' => __('Жалоба успешно добавлена!'),
        'reload' => true
    ));
    
}