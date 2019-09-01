<?php

add_action( 'delete_post', 'fng_delete_task_data', 10 );
function fng_delete_task_data( $post_id ) {

	if ( get_post_type( $post_id ) != 'task' )
		return false;

	$chat = rcl_get_chat_by_room( 'fng-task:' . $post_id );

	rcl_delete_chat( $chat->chat_id );

	$requests = fng_get_requests( array(
		'task_id'	 => $post_id,
		'number'	 => -1,
		'fields'	 => array( 'request_id' )
	) );

	if ( $requests ) {

		foreach ( $requests as $request ) {
			fng_delete_request( $request->request_id );
		}
	}
}

add_action( 'fng_delete_request', 'fng_delete_request_comments', 10 );
function fng_delete_request_comments( $request_id ) {

	$comments = fng_get_comments( array(
		'request_id' => $request_id,
		'number'	 => -1,
		'fields'	 => array( 'comment_id' )
	) );

	if ( $comments ) {

		foreach ( $comments as $comment ) {
			fng_delete_comment( $comment->comment_id );
		}
	}
}

add_action( 'rcl_success_pay', 'fng_request_payment', 10 );
function fng_request_payment( $payData ) {

	if ( $payData->pay_type != 'fng-payment' )
		return false;

	$baggage = $payData->baggage_data;

	$request = fng_get_request( $baggage->request_id );

	if ( $request->request_price != $payData->pay_summ )
		return false;

	do_action( 'fng_request_payment', $baggage->request_id );

	if ( $payData->current_connect == 'user_balance' ) {
		wp_send_json( array(
			'redirect' => get_permalink( $request->task_id )
		) );
	}
}

add_action( 'fng_request_payment', 'fng_request_take', 10 );
function fng_request_take( $request_id ) {

	$request = fng_get_request( $request_id );

	fng_add_service_message( $request->task_id, __( 'Assigned assignee' ) . ' - ' . get_the_author_meta( 'display_name', $request->author_id ) );

	if ( rcl_get_option( 'fng-reserve' ) )
		fng_add_service_message( $request->task_id, __( 'Customer has reserved funds in the amount of ' . $request->request_price . '.' ) );

	$firstPrice = get_post_meta( $request->task_id, 'fng-price', 1 );

	if ( $firstPrice != $request->request_price ) {

		fng_add_service_message( $request->task_id, __( 'Order value changed.' ) );

		update_post_meta( $request->task_id, 'fng-first-price', $firstPrice );
		update_post_meta( $request->task_id, 'fng-price', $request->request_price );
	}

	update_post_meta( $request->task_id, 'fng-status', 2 );
	update_post_meta( $request->task_id, 'fng-last-update', current_time( 'mysql' ) );
	update_post_meta( $request->task_id, 'fng-work-start', current_time( 'mysql' ) );
	update_post_meta( $request->task_id, 'fng-performer', $request->author_id );

	fng_update_request( $request_id, array(
		'request_status' => 2
	) );

	do_action( 'fng_request_take', $request_id, $request );
}

add_action( 'pre_get_posts', 'fng_task_query_filter', 10 );
function fng_task_query_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {

		if ( ! $query->is_post_type_archive( 'task' ) )
			return;

		$meta_query = array();

		if ( isset( $_GET['fs'] ) ) {

			$query->set( 's', $_GET['fs'] );
		}

		if ( $_GET['fsubject'] ) {

			$query->set( 'tax_query', array(
				array(
					'taxonomy'	 => 'task-subject',
					'field'		 => 'id',
					'terms'		 => $_GET['fsubject']
				)
			) );
		}

		if ( isset( $_GET['fstatus'] ) && $_GET['fstatus'] ) {

			$meta_query[] = array(
				array(
					'key'	 => 'fng-status',
					'value'	 => $_GET['fstatus']
				)
			);
		} else if ( rcl_get_option( 'fng-close-noview' ) ) {

			$meta_query[] = array(
				array(
					'key'		 => 'fng-status',
					'value'		 => 5,
					'compare'	 => '!='
				)
			);
		}

		if ( isset( $_GET['fprice'] ) ) {

			$meta_query[] = array(
				array(
					'key'		 => 'fng-price',
					'value'		 => $_GET['fprice'],
					'type'		 => 'numeric',
					'compare'	 => 'BETWEEN'
				)
			);
		}

		if ( isset( $_GET['forderby'] ) ) {

			$sort = $_GET['forderby'];

			if ( $sort == 'date' ) {
				$query->set( 'orderby', $_GET['forderby'] );
			}

			if ( $sort == 'price' ) {
				$query->set( 'orderby', 'meta_value_num' );
				$query->set( 'meta_key', 'fng-price' );
			}
		}

		if ( isset( $_GET['forder'] ) ) {

			$query->set( 'order', $_GET['forder'] );
		}

		if ( $meta_query )
			$query->set( 'meta_query', $meta_query );

		do_action( 'fng_pre_filter_tasks', $query );
	}
}
