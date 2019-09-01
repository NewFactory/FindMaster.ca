<?php

class FNG_Requests_List extends FNG_Requests {

	public $requests		 = array();
	public $comments		 = array();
	public $task;
	public $template_comment = 'fng-comment.php';
	public $template_request = 'fng-request.php';

	function __construct( $args, $props = false ) {

		if ( $props ) {
			$this->init_properties( $props );
		}

		parent::__construct();

		if ( isset( $args['task_id'] ) )
			$this->task = get_post( $args['task_id'] );

		$this->requests = $this->get_results( $args );

		if ( $this->requests ) {
			$this->comments = fng_get_comments( array(
				'request_id__in' => $this->get_request_ids(),
				'order'			 => 'ASC'
			) );
		}
	}

	function init_properties( $args ) {

		$properties = get_class_vars( get_class( $this ) );

		foreach ( $properties as $name => $val ) {
			if ( isset( $args[$name] ) )
				$this->$name = $args[$name];
		}
	}

	function get_list() {
		global $user_ID;

		if ( ! $this->requests )
			return false;

		$content = '<div id="fng-requests">';

		foreach ( $this->requests as $request ) {

			$content .= '<div class="request">';

			$content .= rcl_get_include_template( $this->template_request, __FILE__, array(
				'fng_request' => $request
			) );

			if ( rcl_get_option( 'fng-comments' ) && get_post_meta( $request->task_id, 'fng-status', 1 ) == 1 ) {

				$comments = $this->get_comments( $request->request_id );

				if ( $request->author_id == $user_ID && $comments || $this->task && $this->task->post_author == $user_ID ) {

					$content .= '<div class="request-comments">';

					$content .= '<div class="comments-list">';

					if ( $comments ) {

						foreach ( $comments as $comment ) {

							$content .= rcl_get_include_template( $this->template_comment, __FILE__, array(
								'fng_comment' => $comment
							) );
						}
					}

					$content .= '</div>';

					$content .= '<div class="answer-box preloader-box">'
						. '<a href="#" onclick="fng_ajax_get_answer_form(' . $request->request_id . ', this); return false;">'
						. __( 'to write an answer' )
						. '</a>'
						. '</div>';

					$content .= '</div>';
				}
			}

			$content .= '</div>';
		}

		$content .= '</div>';

		return $content;
	}

	function get_user_request( $user_id ) {
		if ( ! $this->requests )
			return false;

		foreach ( $this->requests as $request ) {

			if ( $request->author_id == $user_id )
				return $request;
		}

		return false;
	}

	function get_request_ids() {

		if ( ! $this->requests )
			return false;

		$request_ids = array();
		foreach ( $this->requests as $request ) {

			$request_ids[] = $request->request_id;
		}

		return $request_ids;
	}

	function get_comments( $request_id ) {

		if ( ! $this->comments )
			return false;

		$comments = array();
		foreach ( $this->comments as $comment ) {

			if ( $request_id == $comment->request_id ) {
				$comments[] = $comment;
			}
		}

		return $comments;
	}

	function get_authors() {

		if ( ! $this->requests )
			return false;

		$authors = array();
		foreach ( $this->requests as $request ) {

			if ( $request->parent_id )
				continue;

			$authors[] = $request->author_id;
		}

		return $authors;
	}

	function get_parents() {

		if ( ! $this->requests )
			return false;

		$parents = array();
		foreach ( $this->requests as $request ) {

			if ( $request->parent_id )
				continue;

			$parents[] = $request;
		}

		return $parents;
	}

}
