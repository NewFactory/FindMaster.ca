<?php

class Rcl_Chat_Viewer extends Rcl_Chat {
	function __construct( $args = array() ) {

		add_filter( 'rcl_chat_query', array( $this, 'edit_query' ), 10 );
		add_filter( 'rcl_page_link_attributes', array( $this, 'pagenavi_attributes' ), 10 );

		parent::__construct( $args );

		$this->form = 0;
	}

	function edit_query( $query ) {
		$query['where'] = array();

		if ( $this->chat_id != 'admin' ) {

			$this->chat_room	 = $this->chat['chat_room'];
			$this->chat_token	 = rcl_chat_token_encode( $this->chat['chat_room'] );

			$query['where'][] = "rcl_chat_messages.chat_id = '$this->chat_id'";
		}

		return $query;
	}

	function pagenavi_attributes( $attrs ) {

		$attrs['onclick']		 = 'rcl_chat_viewer_navi(this); return false;';
		$attrs['class']			 = 'rcl-chat-page-link';
		$attrs['href']			 = '#';
		$attrs['data']['post']	 = false;

		return $attrs;
	}

	function get_chat_data( $chat_room ) {

		global $wpdb;

		if ( $this->chat_id != 'admin' ) {
			return $wpdb->get_row( "SELECT * FROM " . RCL_PREF . "chats WHERE chat_id = '$this->chat_id'", ARRAY_A );
		}

		return array(
			'chat_id' => 'admin'
		);
	}

	function read_chat( $chat_id ) {

	}

	function set_activity() {

	}

	function get_chat() {
		global $rcl_chat;

		$rcl_chat = $this;

		$content = '<div class="rcl-chat chat-' . $this->chat_status . ' chat-room-' . $this->chat_room . '" data-token="' . $this->chat_token . '" data-in_page="' . $this->query['number'] . '">';

		$content .= $this->get_messages_box();

		if ( $this->form ) {
			$content .= '<div class="chat-form">' . $this->get_form() . '</div>';
		}

		$content .= '</div>';

		if ( $this->beat ) {

			$content .= '<script>rcl_chat_scroll_bottom("' . $this->chat_token . '");'
				. 'jQuery(window).on("load", function() {'
				. 'rcl_add_beat( "rcl_chat_viewer_beat_core", 5 ,{'
				. 'token:"' . $this->chat_token . '",'
				. 'file_upload:' . $this->file_upload . ','
				. 'max_words:' . $this->max_words . ','
				. 'delay:' . $this->delay . ','
				. 'open_chat:"' . current_time( 'mysql' ) . '",'
				. 'timeout:' . $this->timeout
				. '});'
				. 'rcl_beat();'
				. '});'
				. '</script>';
		}

		$rcl_chat = false;

		return $content;
	}

	function get_messages_box() {

		$navi = false;

		$amount_messages = $this->count_messages();

		$content = '<div class="chat-content">';

		if ( $this->userslist )
			$content .= $this->userslist();

		$content .= '<div class="chat-messages-box">';

		$content .= '<div class="chat-messages">';

		if ( $amount_messages ) {

			$pagenavi = new Rcl_PageNavi( 'rcl-chat', $amount_messages, array( 'in_page' => $this->query['number'], 'ajax' => true, 'current_page' => $this->paged ) );

			$this->query['offset'] = $pagenavi->offset;

			$messages = $this->get_messages();

			krsort( $messages );

			foreach ( $messages as $k => $message ) {
				$content .= $this->get_message_box( $message );
			}

			$navi = $pagenavi->pagenavi();
		} else {
			if ( $this->important )
				$notice	 = __( 'No important messages in this chat', 'wp-recall' );
			else
				$notice	 = __( 'Chat history will be displayed here', 'wp-recall' );

			$content .= sprintf( '<span class="anons-message">%s</span>', $notice );
		}

		$content .= '</div>';

		$content .= '<div class="chat-meta">';

		$content .= '<div class="chat-status"><span>......<i class="rcli fa-pencil" aria-hidden="true"></i></span></div>';

		if ( $navi ) {
			$content .= $navi;
		}

		$content .= '</div>';

		$content .= '</div>';

		$content .= '</div>';

		return $content;
	}

	function get_message_box( $message ) {

		$class = ($message['user_id'] == $this->user_id) ? 'nth' : '';

		$content = '<div class="chat-message ' . $class . '" data-message="' . $message['message_id'] . '">'
			. '<span class="user-avatar">';

		if ( $message['user_id'] != $this->user_id )
			$content .= '<a href="' . rcl_get_tab_permalink( $message['user_id'], 'chat' ) . '">';

		$content .= get_avatar( $message['user_id'], $this->avatar_size );

		if ( $message['user_id'] != $this->user_id )
			$content .= '</a>';

		$content .= '</span>';

		if ( $this->user_id )
			$content .= $this->message_manager( $message );

		$content .= '<div class="message-wrapper">'
			. '<div class="message-box" style="cursor:pointer;" onclick="rcl_get_chat_viewer_window(' . $message['chat_id'] . '); return false;">'
			. '<span class="author-name">' . get_the_author_meta( 'display_name', $message['user_id'] ) . '</span>'
			. '<div class="message-text">';

		$content .= $this->the_content( $message['message_content'] );

		if ( isset( $message['attachment'] ) && $message['attachment'] )
			$content .= $this->the_attachment( $message['attachment'] );

		$content .= '</div>'
			. '</div>'
			. '<span class="message-time"><i class="rcli fa-clock-o" aria-hidden="true"></i> ' . $message['message_time'] . '</span>'
			. '</div>'
			. '</div>';

		return $content;
	}

	function message_manager( $message ) {

		$class = array( 'message-important' );

		$content = '<div class="message-manager">';

		$content .= '<span class="message-delete">'
			. '<a href="#" onclick="rcl_chat_delete_message(' . $message['message_id'] . '); return false;">'
			. '<i class="rcli fa-trash" aria-hidden="true"></i>'
			. '</a>'
			. '</span>';


		$content .= '</div>';

		return $content;
	}

}
