<?php

function fng_get_request_box( $post_id ) {
	global $user_ID;

	if ( ! $user_ID )
		return false;

	$isAdmin		 = rcl_is_user_role( $user_ID, array( 'administrator' ) );
	$viewRequests	 = rcl_get_option( 'fng-view-requests', 0 );

	$post = get_post( $post_id );

	$content = '<div class="fng-request-box">';

	if ( $viewRequests && $post->post_author == $user_ID || $isAdmin )
		$content .= '<h3>' . __( 'Added applications' ) . '</h3>';

	$args = array(
		'task_id'		 => $post_id,
		'request_status' => 1,
		'number'		 => -1,
		'order'			 => 'ASC'
	);

	if ( ! $viewRequests && $post->post_author != $user_ID && ! $isAdmin ) {
		$args['author_id'] = $user_ID;
	}

	require_once 'classes/class-fng-requests-list.php';

	$Walker = new FNG_Requests_List( $args );

	$content .= '<div class="fng-request-list">';

	if ( isset( $args['author_id'] ) && $Walker->requests ) {
		$content .= '<h3>' . __( 'Your request for the task' ) . '</h3>';
	}

	if ( ! $Walker->requests ) {
		if ( $post->post_author == $user_ID || $isAdmin )
			$content .= '<p>' . __( 'No applications have been added yet..' ) . '</p>';
	}else {

		$content .= $Walker->get_list();
	}

	$content .= '</div>';

	if ( $post->post_author != $user_ID ) {

		if ( ! $Walker->get_user_request( $user_ID ) ) {
			$content .= fng_get_request_form( $post_id );
		}
	}

	$content .= '</div>';

	return $content;
}

function fng_get_request_form( $post_id ) {

	$content = '<div class="fng-request-form">';

	$content .= '<h3>' . __( 'Application form for the task' ) . '</h3>';

	$content .= rcl_get_form( apply_filters( 'fng_request_form_args', array(
		'fields'	 => array(
			array(
				'slug'		 => 'request-price',
				'type'		 => 'number',
				'title'		 => __( 'Desired order value' ),
				'notice'	 => __( 'indicate the cost of the order, which would suit you as an executor, may be changed later' ),
				'required'	 => 1
			),
			array(
				'slug'		 => 'request-content',
				'type'		 => 'textarea',
				//'tinymce' => 1,
				//'quicktags' => 'strong,em,link,close,block,del',
				'title'		 => __( 'Application text' ),
				'request'	 => __( 'Your application will be visible only to the author of the task' ),
				'required'	 => 1
			),
			array(
				'slug'	 => 'request-task',
				'type'	 => 'hidden',
				'value'	 => $post_id
			)
		),
		'submit'	 => __( 'Add request' ),
		'onclick'	 => 'rcl_send_form_data("fng_ajax_add_request",this);return false;'
			), $post_id )
	);

	$content .= '</div>';

	return $content;
}
