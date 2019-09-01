<?php

add_action( 'fng_insert_request', 'fng_send_email_about_insert_request', 10 );
function fng_send_email_about_insert_request( $request_id ) {

	$request = fng_get_request( $request_id );

	$task = get_post( $request->task_id );

	//письмо заказчику
	$email	 = get_the_author_meta( 'user_email', $task->post_author );
	$title	 = __( 'New application for the task!' );
	$text	 = '<p>' . __( 'To your assignment "' . $task->post_title . '" a new application has been added.' ) . '</p>'
		. '<div style="float:left;margin-right:15px;">' . get_avatar( $request->author_id, 60 ) . '</div>'
		. '<p>' . __( 'Application text:' ) . '</p>'
		. '<p>' . $request->request_content . '</p>'
		. '<p>' . __( 'Link to the task: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_insert_comment', 'fng_send_email_about_new_comment', 10 );
function fng_send_email_about_new_comment( $comment_id ) {
	global $user_ID, $wpdb;

	$comment = fng_get_comment( $comment_id );

	$request = fng_get_request( $comment->request_id );

	if ( $comment->author_id == $request->author_id )
		return false;

	$task = get_post( $request->task_id );

	//письмо автору заявки
	$email	 = get_the_author_meta( 'user_email', $request->author_id );
	$title	 = __( 'New comment on your application' );
	$text	 = '<p>' . __( 'To your request for assignment' ) . ' "' . $task->post_title . '" ' . __( ' customer added comment.' ) . '.</p>'
		. '<p>' . __( 'Read the comment text on the assignment page' ) . '.</p>'
		. '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_request_reject', 'fng_send_email_about_request_reject', 10 );
function fng_send_email_about_request_reject( $request_id ) {
	global $user_ID;

	$request = fng_get_request( $request_id );

	$task = get_post( $request->task_id );

	//письмо автору заявки
	$email	 = get_the_author_meta( 'user_email', $request->author_id );
	$title	 = __( 'Application rejected' );
	$text	 = '<p>' . __( 'Your request for the task' ) . ' "' . $task->post_title . '" ' . __( ' was rejected by its author' ) . '.</p>'
		. '<p>' . __( 'Unfortunately, adding a new application to this task will fail' ) . '.</p>'
		. '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_request_take', 'fng_send_email_about_request_take', 10, 2 );
function fng_send_email_about_request_take( $request_id, $request ) {
	global $user_ID;

	$task = get_post( $request->task_id );

	//письмо автору заявки
	$email	 = get_the_author_meta( 'user_email', $request->author_id );
	$title	 = __( 'You have been approved as a performer' );
	$text	 = '<p>' . __( 'Congratulations, job author' ) . ' "' . $task->post_title . '" ' . __( ' approved you as an executor.' ) . '.</p>';

	if ( rcl_get_option( 'fng-reserve' ) ) {
		$text .= '<p>' . __( 'Do not worry about payment, the author of the task has already reserved funds to pay for your services' ) . '.</p>'
			. '<p>' . __( 'Payment for your work will be transferred to your balance immediately after the author confirms the completion of the task.' ) . '.</p>';
	}

	$text .= '<p>' . __( 'Remember to comply with the deadlines. If the time for completing the task is overdue, '
			. 'then its author can refuse your services and find another artist' ) . '.</p>'
		. '<p>' . __( 'Good luck!' ) . '.</p>'
		. '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_performer_fail', 'fng_send_email_about_performer_fail', 10 );
function fng_send_email_about_performer_fail( $task_id ) {
	global $user_ID;

	$task = get_post( $task_id );

	//письмо автору задания
	$email	 = get_the_author_meta( 'user_email', $task->post_author );
	$title	 = __( 'Refusal to comply' );
	$text	 = '<p>' . __( 'Contractor previously assigned to complete the assignment' ) . ' "' . $task->post_title . '" ' . __( 'отказался от выполнения' ) . '.</p>'
		. '<p>' . __( 'The task went into the status of the selection of the performer.' ) . '.</p>';

	if ( rcl_get_option( 'fng-reserve' ) ) {
		$text .= '<p>' . __( 'Reserved funds have been returned to your balance.' ) . '.</p>';
	}

	$text .= '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_task_expired', 'fng_send_email_about_task_expired', 10 );
function fng_send_email_about_task_expired( $task_id ) {

	$task = get_post( $task_id );

	$performer = get_post_meta( $task_id, 'fng-performer', 1 );

	//письмо заказчику
	$email	 = get_the_author_meta( 'user_email', $task->post_author );
	$title	 = __( 'Mission expired' );
	$text	 = '<p>' . __( 'The time allotted by you to complete the task "' . $task->post_title . '" ended' ) . '.</p>'
		. '<p>' . __( 'You can extend the lead time or refuse the current artist on the job page.' ) . '.</p>'
		. '<p>' . __( 'Link to the task: <a href="' . get_permalink( $task_id ) . '">' . get_permalink( $task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );

	//письмо исполнителю
	$email	 = get_the_author_meta( 'user_email', $performer );
	$title	 = __( 'Mission expired' );
	$text	 = '<p>' . __( 'Time allotted by the author of the task "' . $task->post_title . '" its implementation has come to an end' ) . '.</p>'
		. '<p>' . __( 'Urgently contact the author of the task and ask him to extend the execution time of the task through the workspace' ) . '.</p>'
		. '<p>' . __( 'Link to the task: <a href="' . get_permalink( $task_id ) . '">' . get_permalink( $task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_performer_fired', 'fng_send_email_about_performer_fired', 10 );
function fng_send_email_about_performer_fired( $task_id ) {

	$task = get_post( $task_id );

	$performer = get_post_meta( $task_id, 'fng-performer', 1 );

	//письмо автору исполнителю
	$email	 = get_the_author_meta( 'user_email', $performer );
	$title	 = __( 'Refusal of the executor' );
	$text	 = '<p>' . __( 'Job Author' ) . ' "' . $task->post_title . '" ' . __( 'refused your services '
			. 'as a contractor due to expired lead times' ) . '.</p>'
		. '<p>' . __( 'The task went into the status of the selection of the performer.' ) . '.</p>'
		. '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $task_id ) . '">' . get_permalink( $task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'fng_task_complete', 'fng_send_email_about_task_complete', 10 );
function fng_send_email_about_task_complete( $task_id ) {
	global $user_ID;

	$performer = get_post_meta( $task_id, 'performer', 1 );

	$task = get_post( $task_id );

	//письмо исполнителю
	$email	 = get_the_author_meta( 'user_email', $performer );
	$title	 = __( 'Task completed' );
	$text	 = '<p>' . __( 'Job Author' ) . ' "' . $task->post_title . '" ' . __( 'confirmed its implementation' ) . '.</p>'
		. '<p>' . __( 'The task was completed successfully.' ) . '.</p>';

	if ( rcl_get_option( 'fng-reserve' ) ) {
		$text .= '<p>' . __( 'Funds for completing the assignment were credited to your balance' ) . '.</p>';
	}

	$text .= '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $request->task_id ) . '">' . get_permalink( $request->task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}

add_action( 'rcl_chat_add_message', 'fng_send_task_chat_message', 10 );
function fng_send_task_chat_message( $messageData ) {
	global $user_ID, $wpdb;

	if ( ! isset( $_POST['fng-task'] ) || $user_ID == $messageData['user_id'] )
		return false;

	$taskId = $_POST['fng-task'];

	$task = get_post( $taskId );

	$performer = get_post_meta( $taskId, 'fng-task', 1 );

	$users = array( $performer, $task->post_author );

	$activeUsers = $wpdb->get_col( "SELECT user_id FROM " . RCL_PREF . "chat_users WHERE chat_id='" . $messageData['chat_id'] . "' AND user_activity >= ('" . current_time( 'mysql' ) . "' - interval 1 minute)" );

	foreach ( $users as $userId ) {

		if ( $userId == $user_ID || in_array( $userId, $activeUsers ) )
			continue;

		$email	 = get_the_author_meta( 'user_email', $userId );
		$title	 = __( 'New workspace message' );
		$text	 = '<p>' . __( 'In the workspace of the job' ) . ' "' . $task->post_title . '" ' . __( 'new message appeared' ) . '.</p>'
			. '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $taskId ) . '">' . get_permalink( $taskId ) . '</a>' ) . '</p>';

		rcl_mail( $email, $title, $text );
	}

	return false;
}

add_action( 'fng_task_claim', 'fng_send_email_about_claim', 10, 3 );
function fng_send_email_about_claim( $task_id, $user_id, $text_claim ) {

	$task = get_post( $task_id );

	//письмо исполнителю
	$email	 = get_option( 'admin_email' );
	$title	 = __( 'Arbitration Filed' );
	$text	 = '<p>' . __( 'In the task' ) . ' "' . $task->post_title . '" ' . __( 'one of the participants complained' ) . '.</p>'
		. '<p>' . __( 'Complaint text' ) . ':<br>' . $text_claim . '</p>';
	$text .= '<p>' . __( 'You can make a decision, as well as view the workspace on the job editing page' ) . '</p>';
	$text .= '<p>' . __( 'Link to the task page: <a href="' . get_permalink( $task_id ) . '">' . get_permalink( $task_id ) . '</a>' ) . '</p>';

	rcl_mail( $email, $title, $text );
}
