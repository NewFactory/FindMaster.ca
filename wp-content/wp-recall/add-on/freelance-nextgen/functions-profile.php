<?php

add_action( 'init', 'fng_add_tab', 20 );
function fng_add_tab() {

	rcl_tab(
		array(
			'id'		 => 'freelance',
			'supports'	 => array( 'ajax' ),
			'name'		 => __( 'Transactions and orders' ),
			'public'	 => 0,
			'icon'		 => 'fa-handshake-o',
			'output'	 => 'menu',
			'content'	 => array(
				array(
					'id'		 => 'customer',
					'name'		 => __( 'Tasks: Customer' ),
					'icon'		 => 'fa-handshake-o',
					'callback'	 => array(
						'name' => 'fng_get_customer_tab'
					)
				),
				array(
					'id'		 => 'performer',
					'name'		 => __( 'Assignments: Artist' ),
					'icon'		 => 'fa-handshake-o',
					'callback'	 => array(
						'name' => 'fng_get_performer_tab'
					)
				),
				array(
					'id'		 => 'requests',
					'name'		 => __( 'Abandoned applications' ),
					'icon'		 => 'fa-handshake-o',
					'callback'	 => array(
						'name' => 'fng_get_requests_tab'
					)
				)
			)
		)
	);
}

function fng_get_customer_tab( $master_id ) {
	global $post;

	$args = array(
		'post_type'		 => 'task',
		'author'		 => $master_id,
		'numberposts'	 => -1,
		'fields'		 => 'ids'
	);

	$posts = get_posts( $args );

	if ( !$posts )
		return '<p>' . __( 'Assignments not published yet' ) . '</p>';

	$pagenavi = new Rcl_PageNavi( 'tasks', count( $posts ) );

	unset( $args['fields'] );

	$args['offset']		 = $pagenavi->offset;
	$args['numberposts'] = 30;

	$posts = get_posts( $args );

	$content = '<div class="fng-task-list">';

	$content .= $pagenavi->pagenavi();

	$content .= '<div class="fng-task">
        <div class="task-title task-meta">' . __( 'Name' ) . '</div>
        <div class="task-date task-meta">' . __( 'Publication Date' ) . '</div>
        <div class="task-status task-meta">' . __( 'Status' ) . '</div>
    </div>';

	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$content .= rcl_get_include_template( 'fng-task.php', __FILE__, array(
			'post' => $post
		) );
	}

	$content .= $pagenavi->pagenavi();

	$content .= '</div>';

	wp_reset_postdata();

	return $content;
}

function fng_get_performer_tab( $master_id ) {
	global $post;

	$args = array(
		'post_type'		 => 'task',
		'meta_query'	 => array(
			array(
				'key'	 => 'fng-performer',
				'value'	 => $master_id
			)
		),
		'numberposts'	 => -1,
		'fields'		 => 'ids'
	);

	$posts = get_posts( $args );

	if ( !$posts )
		return '<p>' . __( 'No jobs found' ) . '</p>';

	$pagenavi = new Rcl_PageNavi( 'tasks', count( $posts ) );

	unset( $args['fields'] );

	$args['offset']		 = $pagenavi->offset;
	$args['numberposts'] = 30;

	$posts = get_posts( $args );

	$content = '<div class="fng-task-list">';

	$content .= $pagenavi->pagenavi();

	$content .= '<div class="fng-task">
        <div class="task-title task-meta">' . __( 'Name' ) . '</div>
        <div class="task-date task-meta">' . __( 'Publication Date' ) . '</div>
        <div class="task-status task-meta">' . __( 'Status' ) . '</div>
    </div>';

	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$content .= rcl_get_include_template( 'fng-task.php', __FILE__, array(
			'post' => $post
		) );
	}

	$content .= $pagenavi->pagenavi();

	$content .= '</div>';

	wp_reset_postdata();

	return $content;
}

function fng_get_requests_tab( $master_id ) {

	$args = array(
		'author_id' => $master_id
	);

	$query = new FNG_Requests();

	$count = $query->count( $args );

	if ( !$count )
		return '<p>' . __( 'No job applications found' ) . '</p>';

	$pagenavi = new Rcl_PageNavi( 'reqst', $count );

	$args['offset']	 = $pagenavi->offset;
	$args['number']	 = 30;

	require_once 'classes/class-fng-requests-list.php';

	$list = new FNG_Requests_List( $args, array(
		'template_request' => 'fng-request-history.php'
	) );

	$content .= $pagenavi->pagenavi();

	$content .= '<div class="fng-request-history">';

	$content .= $list->get_list();

	$content .= '</div>';

	$content .= $pagenavi->pagenavi();

	return $content;
}

add_filter( 'rcl_default_profile_fields', 'fng_add_default_profile_fields', 10 );
function fng_add_default_profile_fields( $fields ) {

	$terms = get_terms( array(
		'taxonomy'	 => 'task-subject',
		'hide_empty' => false,
		'parent'	 => 0
	) );

	if ( $terms ) {

		$values = array();
		foreach ( $terms as $term ) {
			$values[$term->term_id] = $term->name;
		}

		$fields[] = array(
			'slug'		 => 'fng-specialization',
			'type'		 => 'custom',
			'title'		 => __( 'Specialization' ),
			'register'	 => 1
		);
	}

	return $fields;
}

add_filter( 'rcl_profile_fields', 'fng_add_specialization_field', 10, 2 );
function fng_add_specialization_field( $fields, $args ) {

	foreach ( $fields as $k => $field ) {

		if ( $field['slug'] != 'fng-specialization' )
			continue;

		$terms = get_terms( array(
			'taxonomy'	 => 'task-subject',
			'hide_empty' => false,
			'parent'	 => 0
			) );

		if ( !$terms )
			break;

		$values = array();
		foreach ( $terms as $term ) {
			$values[$term->term_id] = $term->name;
		}

		$fields[$k]['type']			 = 'select';
		$fields[$k]['values']		 = $values;
		$fields[$k]['value_in_key']	 = false;
	}

	return $fields;
}
