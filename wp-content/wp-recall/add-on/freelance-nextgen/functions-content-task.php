<?php

add_filter( 'the_excerpt', 'fng_add_task_excerpt', 50 );
function fng_add_task_excerpt( $content ) {
	global $post;

	if ( $post->post_type != 'task' )
		return $content;

	return fng_get_task_meta_box( $post->ID ) . $content;
}

add_filter( 'the_content', 'fng_add_task_meta', 50 );
function fng_add_task_meta( $content = '' ) {
	global $post;

	if ( $post->post_type != 'task' || doing_filter( 'get_the_excerpt' ) )
		return $content;

	$taskMeta = fng_get_task_meta_box( $post->ID );

	$taskMeta .= fng_get_task_gallery( $post->ID );

	return $taskMeta . $content;
}

function fng_get_task_meta_box( $post_id ) {

	$content = '<div class="fng-task-metas">
                <div class="task-meta task-price">' . get_post_meta( $post_id, 'fng-price', 1 ) . ' ' . rcl_get_primary_currency( 1 ) . '</div>
                ' . fng_get_post_terms( $post_id ) . '
                <div class="task-meta">
                    <i class="rcli fa-clock-o far fa-clock rcl-icon"></i>' . __( 'Period of execution' ) . ': ' . get_post_meta( $post_id, 'fng-days', 1 ) . ' days
                </div>
                <div class="task-meta task-status">
                    <i class="rcli fa-refresh fa-sync rcl-icon"></i>' . __( 'Status' ) . ': <span class="task-status-' . get_post_meta( $post_id, 'fng-status', 1 ) . '">' . fng_get_status_name( get_post_meta( $post_id, 'fng-status', 1 ) ) . '</span>
                </div>'
		. (rcl_get_option( 'fng-view-performer', 0 ) && get_post_meta( $post_id, 'fng-performer', 1 ) ? '<div class="task-meta task-performer">
                    <i class="rcli fa-user rcl-icon"></i>' . __( 'Job performer' ) . ': <a href="' . get_author_posts_url( get_post_meta( $post_id, 'fng-performer', 1 ) ) . '" target="_blank">' . get_the_author_meta( 'display_name', get_post_meta( $post_id, 'fng-performer', 1 ) ) . '</a>
                </div>' : '')
		. '</div>';

	return $content;
}

function fng_get_post_terms( $post_id ) {

	$content = fng_get_post_term_list( $post_id, 'task-subject', __( 'Category' ), 'folder-open' );

	if ( !$content )
		return false;

	return $content;
}

function fng_get_post_term_list( $post_id, $taxonomy, $name, $icon ) {

	$start	 = '<div class="task-meta">'
		. '<i class="rcli fa-%s rcl-icon"></i>'
		. '%s: ';
	$end	 = '</div>';

	$terms = get_the_term_list( $post_id, $taxonomy, sprintf( $start, $icon, $name ), ', ', $end );

	if ( !$terms )
		return false;

	return $terms;
}

add_filter( 'the_content', 'fng_add_task_box', 100 );
function fng_add_task_box( $content ) {
	global $post, $user_ID;

	if ( $post->post_type != 'task' || doing_filter( 'get_the_excerpt' ) )
		return $content;

	$status_id = get_post_meta( $post->ID, 'fng-status', 1 );

	$content .= fng_get_task_manager( $post->ID );

	if ( $status_id == 1 )
		$content .= fng_get_request_box( $post->ID );

	if ( in_array( $status_id, array( 2, 3, 4, 5, -3, -4 ) ) ) {

		$performer = get_post_meta( $post->ID, 'fng-performer', 1 );

		if ( in_array( $user_ID, array( $post->post_author, $performer ) ) || rcl_is_user_role( $user_ID, array( 'administrator', 'editor' ) ) ) {

			$chatArgs = array(
				'userslist'		 => 1,
				'chat_room'		 => 'fng-task:' . $post->ID,
				'file_upload'	 => 1
			);

			if ( $status_id == 5 ) {
				$chatArgs['userslist']	 = false;
				$chatArgs['beat']		 = false;
				$chatArgs['form']		 = false;
			}

			$content .= '<h3>' . __( 'Workspace' ) . '</h3>';

			$content .= rcl_chat_shortcode( $chatArgs );
		}
	}

	return $content;
}

add_action( 'wp', 'fng_init_remove_filters', 10 );
function fng_init_remove_filters() {

	if ( is_singular( 'task' ) ) {
		remove_filter( 'the_content', 'rcl_post_gallery', 10 );
	}
}

function fng_get_task_gallery( $post_id ) {
	global $post;

	if ( get_post_meta( $post_id, 'recall_slider', 1 ) != 1 )
		return false;

	$args = array(
		'post_parent'	 => $post_id,
		'post_type'		 => 'attachment',
		'numberposts'	 => -1,
		'post_status'	 => 'any',
		'post_mime_type' => 'image'
	);

	$childrens = get_children( $args );

	if ( !$childrens )
		return false;

	$attach_ids = array();
	foreach ( ( array ) $childrens as $children ) {
		$attach_ids[] = $children->ID;
	}

	$galArgs = array(
		'id'		 => 'fng-task-gallery-' . $post_id,
		'attach_ids' => $attach_ids,
		'width'		 => (count( $attach_ids ) < 7) ? count( $attach_ids ) * 73 : 500,
		'height'	 => 70,
		'slides'	 => array(
			'slide'	 => array( 70, 70 ),
			'full'	 => 'large'
		),
		'options'	 => array(
			'$SlideWidth'	 => 70,
			'$SlideSpacing'	 => 3
		)
	);

	if ( count( $attach_ids ) >= 7 ) {
		$galArgs['navigator'] = array(
			'arrows' => true
		);
	}

	$content = rcl_get_image_gallery( $galArgs );

	return $content;
}
