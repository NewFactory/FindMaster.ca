<?php

add_action('fng_insert_request', 'fng_send_email_about_insert_request', 10);
function fng_send_email_about_insert_request($request_id){
    
    $request = fng_get_request($request_id);

    $task = get_post($request->task_id);

    //письмо заказчику
    $email = get_the_author_meta('user_email', $task->post_author);
    $title = __('Новая заявка к заданию!');
    $text = 
        '<p>'.__('К вашему заданию "'.$task->post_title.'" была добавлена новая заявка.').'</p>'
        .'<div style="float:left;margin-right:15px;">'.get_avatar($request->author_id, 60).'</div>'
        .'<p>'.__('Текст заявки:').'</p>'
        .'<p>'.$request->request_content.'</p>'
        .'<p>'.__('Ссылка на задание: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_insert_comment', 'fng_send_email_about_new_comment', 10);
function fng_send_email_about_new_comment($comment_id){
    global $user_ID, $wpdb;

    $comment = fng_get_comment($comment_id);

    $request = fng_get_request($comment->request_id);

    if($comment->author_id == $request->author_id) return false;
    
    $task = get_post($request->task_id);

    //письмо автору заявки
    $email = get_the_author_meta('user_email', $request->author_id);
    $title = __('Новый комментарий к вашей заявке');
    $text = 
        '<p>'.__('К вашей заявке для задания').' "'.$task->post_title.'" '.__(' заказчик добавил комментарий.').'.</p>'
        .'<p>'.__('Ознакомьтесь с текстом комментария на странице задания').'.</p>'
        .'<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_request_reject', 'fng_send_email_about_request_reject', 10);
function fng_send_email_about_request_reject($request_id){
    global $user_ID;

    $request = fng_get_request($request_id);

    $task = get_post($request->task_id);

    //письмо автору заявки
    $email = get_the_author_meta('user_email', $request->author_id);
    $title = __('Заявка отклонена');
    $text = 
        '<p>'.__('Ваша заявка к заданию').' "'.$task->post_title.'" '.__(' была отклонена его автором').'.</p>'
        .'<p>'.__('К сожалению, добавить новую заявку к этому заданию не получится').'.</p>'
        .'<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_request_take', 'fng_send_email_about_request_take', 10, 2);
function fng_send_email_about_request_take($request_id, $request){
    global $user_ID;
    
    $task = get_post($request->task_id);

    //письмо автору заявки
    $email = get_the_author_meta('user_email', $request->author_id);
    $title = __('Вас утвердили исполнителем');
    $text = 
        '<p>'.__('Поздравляем, автор задания').' "'.$task->post_title.'" '.__(' утвердил вас исполнителем').'.</p>';
    
    if(rcl_get_option('fng-reserve')){
        $text .= '<p>'.__('Не волнуйтесь об оплате, автор задания уже зарезервировал средства для оплаты ваших услуг').'.</p>'
        .'<p>'.__('Оплата за вашу работу будет переведена на ваш баланс сразу после подтверждения выполнения задания его автором').'.</p>';
    }

    $text .= '<p>'.__('Помните о соблюдении сроков выполнения задания. Если время выполнения задания будет вами просрочено, '
                . 'то его автор может отказаться от ваших услуг и найти другого исполнителя').'.</p>'
        .'<p>'.__('Желаем Удачи!').'.</p>'
        .'<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_performer_fail', 'fng_send_email_about_performer_fail', 10);
function fng_send_email_about_performer_fail($task_id){
    global $user_ID;

    $task = get_post($task_id);

    //письмо автору задания
    $email = get_the_author_meta('user_email', $task->post_author);
    $title = __('Отказ от выполнения');
    $text = 
        '<p>'.__('Исполнитель, назначенный ранее для выполнения задания').' "'.$task->post_title.'" '.__('отказался от выполнения').'.</p>'
        .'<p>'.__('Задание перешло в статус подбора исполнителя.').'.</p>';
    
    if(rcl_get_option('fng-reserve')){
        $text .= '<p>'.__('Зарезервированные средства были возвращены на ваш баланс').'.</p>';
    }
        
    $text .= '<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_task_expired', 'fng_send_email_about_task_expired', 10);
function fng_send_email_about_task_expired($task_id){

    $task = get_post($task_id);
    
    $performer = get_post_meta($task_id,'fng-performer',1);

    //письмо заказчику
    $email = get_the_author_meta('user_email', $task->post_author);
    $title = __('Задание просрочено');
    $text = 
        '<p>'.__('Времы отведенное вами на выполнение задания "'.$task->post_title.'" закончилось').'.</p>'
        .'<p>'.__('Вы можете продлить время выполнения или отказаться от текущего исполнителя на странице задания').'.</p>'
        .'<p>'.__('Ссылка на задание: <a href="'.get_permalink($task_id).'">'.get_permalink($task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
    //письмо исполнителю
    $email = get_the_author_meta('user_email', $performer);
    $title = __('Задание просрочено');
    $text = 
        '<p>'.__('Времы отведенное автором задания "'.$task->post_title.'" на его выполнение подошло к концу').'.</p>'
        .'<p>'.__('Срочно свяжитесь с автором задания и попросите его продлить время выполнения задания через рабочую область').'.</p>'
        .'<p>'.__('Ссылка на задание: <a href="'.get_permalink($task_id).'">'.get_permalink($task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_performer_fired', 'fng_send_email_about_performer_fired', 10);
function fng_send_email_about_performer_fired($task_id){

    $task = get_post($task_id);
    
    $performer = get_post_meta($task_id,'fng-performer',1);

    //письмо автору исполнителю
    $email = get_the_author_meta('user_email', $performer);
    $title = __('Отказ от исполнителя');
    $text = 
        '<p>'.__('Автор задания').' "'.$task->post_title.'" '.__('отказался от ваших услуг '
                . 'как исполнителя в связи с просроченным временем выполнения').'.</p>'
        .'<p>'.__('Задание перешло в статус подбора исполнителя.').'.</p>'
        .'<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($task_id).'">'.get_permalink($task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('fng_task_complete', 'fng_send_email_about_task_complete', 10);
function fng_send_email_about_task_complete($task_id){
    global $user_ID;
    
    $performer = get_post_meta($task_id, 'performer', 1);

    $task = get_post($task_id);

    //письмо исполнителю
    $email = get_the_author_meta('user_email', $performer);
    $title = __('Задание выполнено');
    $text = 
        '<p>'.__('Автор задания').' "'.$task->post_title.'" '.__('подтвердил его выполнение').'.</p>'
        .'<p>'.__('Задание было успешно завершено').'.</p>';
    
    if(rcl_get_option('fng-reserve')){
        $text .= '<p>'.__('На ваш баланс были начислены средства за выполнение задания').'.</p>';
    }

    $text .= '<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($request->task_id).'">'.get_permalink($request->task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}

add_action('rcl_chat_add_message', 'fng_send_task_chat_message', 10);
function fng_send_task_chat_message($messageData){
    global $user_ID, $wpdb;
    
    if(!isset($_POST['fng-task']) || $user_ID == $messageData['user_id']) return false;
    
    $taskId = $_POST['fng-task'];
    
    $task = get_post($taskId);
    
    $performer = get_post_meta($taskId, 'fng-task', 1);
    
    $users = array($performer, $task->post_author);
    
    $activeUsers = $wpdb->get_col("SELECT user_id FROM ".RCL_PREF."chat_users WHERE chat_id='".$messageData['chat_id']."' AND user_activity >= ('".current_time('mysql')."' - interval 1 minute)");

    foreach($users as $userId){
        
        if($userId == $user_ID || in_array($userId, $activeUsers)) continue;

        $email = get_the_author_meta('user_email', $userId);
        $title = __('Новое сообщение в рабочей области');
        $text = 
                '<p>'.__('В рабочей области задания').' "'.$task->post_title.'" '.__('появилось новое сообщение').'.</p>'
                .'<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($taskId).'">'.get_permalink($taskId).'</a>').'</p>';
    
        rcl_mail($email, $title, $text);
        
    }
    
    return false;
    
}

add_action('fng_task_claim', 'fng_send_email_about_claim', 10, 3);
function fng_send_email_about_claim($task_id, $user_id, $text_claim){

    $task = get_post($task_id);

    //письмо исполнителю
    $email = get_option('admin_email');
    $title = __('Подана жалоба в арбитраж');
    $text = 
        '<p>'.__('В задании').' "'.$task->post_title.'" '.__('одним из участников была подана жалоба').'.</p>'
        .'<p>'.__('Текст жалобы').':<br>'.$text_claim.'</p>';
    $text .= '<p>'.__('Вы можете принять решение, а также просмотреть рабочую область на странице редактирования задания').'</p>';
    $text .= '<p>'.__('Ссылка на страницу задания: <a href="'.get_permalink($task_id).'">'.get_permalink($task_id).'</a>').'</p>';

    rcl_mail($email, $title, $text);
    
}