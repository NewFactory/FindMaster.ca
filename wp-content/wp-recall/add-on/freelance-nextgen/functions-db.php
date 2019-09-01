<?php

function fng_get_requests( $args ) {
	$query = new FNG_Requests();
	return $query->get_results( $args );
}

function fng_count_requests( $args ) {
	$query = new FNG_Requests();
	return $query->count( $args );
}

function fng_get_request( $request_id ) {
	$query = new FNG_Requests();
	return $query->get_row( array(
			'request_id' => $request_id
		) );
}

function fng_insert_request( $args ) {
	global $wpdb;

	$args['request_date']	 = current_time( 'mysql' );
	$args['request_status']	 = 1;

	if ( !isset( $args['parent_id'] ) ) {
		$args['parent_id'] = 0;
	}

	if ( !$wpdb->insert( WP_PREFIX . 'fng_requests', $args ) )
		return false;

	$request_id = $wpdb->insert_id;

	do_action( 'fng_insert_request', $request_id );

	return $request_id;
}

function fng_update_request( $request_id, $update ) {
	global $wpdb;

	$wpdb->update( WP_PREFIX . 'fng_requests', $update, array(
		'request_id' => $request_id
	) );

	do_action( 'fng_update_request', $request_id );
}

function fng_delete_request( $request_id ) {
	global $wpdb;

	do_action( 'fng_pre_delete_request', $request_id );

	$result = $wpdb->query( "DELETE FROM " . WP_PREFIX . "fng_requests WHERE request_id='$request_id'" );

	if ( $result ) {

		do_action( 'fng_delete_request', $request_id );
	}

	return $result;
}

function fng_get_comments( $args ) {
	$query = new FNG_Comments();
	return $query->get_results( $args );
}

function fng_get_comment( $request_id ) {
	$query = new FNG_Comments();
	return $query->get_row( array(
			'comment_id' => $request_id
		) );
}

function fng_insert_comment( $args ) {
	global $wpdb;

	$args['comment_date'] = current_time( 'mysql' );

	if ( !$wpdb->insert( WP_PREFIX . 'fng_comments', $args ) )
		return false;

	$comment_id = $wpdb->insert_id;

	do_action( 'fng_insert_comment', $comment_id );

	return $comment_id;
}

function fng_update_comment( $comment_id, $update ) {
	global $wpdb;

	$wpdb->update( WP_PREFIX . 'fng_comments', $update, array(
		'comment_id' => $comment_id
	) );

	do_action( 'fng_update_comment', $comment_id );
}

function fng_delete_comment( $comment_id ) {
	global $wpdb;

	do_action( 'fng_pre_delete_comment', $comment_id );

	$result = $wpdb->query( "DELETE FROM " . WP_PREFIX . "fng_comments WHERE comment_id='$comment_id'" );

	if ( $result ) {

		do_action( 'fng_delete_comment', $comment_id );
	}

	return $result;
}
