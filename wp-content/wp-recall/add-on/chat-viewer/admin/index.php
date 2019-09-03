<?php

add_action( 'admin_menu', 'chvr_admin_page_init', 100 );
function chvr_admin_page_init() {
	add_submenu_page( 'manage-wprecall', 'Chat Viewer', 'Chat Viewer', 'edit_plugins', 'chat-viewer', 'chvr_admin_page' );
}

function chvr_admin_page() {

	$chat = rcl_get_addon( 'rcl-chat' );

	wp_enqueue_style( 'rcl-chat', rcl_addon_url( 'style.css', $chat['path'] ) );
	wp_enqueue_script( 'rcl-chat-sounds', rcl_addon_url( 'js/ion.sound.min.js', $chat['path'] ), array( 'rcl-core-scripts' ) );
	wp_enqueue_script( 'rcl-chat', rcl_addon_url( 'js/scripts.js', $chat['path'] ), array( 'rcl-core-scripts' ) );
	wp_enqueue_script( 'rcl-chat-viewer', rcl_addon_url( 'admin/assets/scripts.js', __FILE__ ) );

	require_once $chat['path'] . '/class-rcl-chat.php';
	require_once 'classes/class-rcl-chat-viewer.php';

	rcl_inline_styles();
	rcl_font_awesome_style();
	rcl_dialog_scripts();

	$chat = new Rcl_Chat_Viewer( array(
		'chat_room' => 'chat-viewer'
		) );

	echo '<h2>' . __( "Chat Viewer" ) . '</h2>';

	echo '<div style="width: 700px;margin:0 auto;">' . $chat->get_chat() . '</div>';
}

rcl_ajax_action( 'rcl_get_ajax_chat_viewer_window' );
function rcl_get_ajax_chat_viewer_window() {
	global $user_ID;

	rcl_verify_ajax_nonce();

	$chat_id = intval( $_POST['chat_id'] );

	$chat = rcl_get_addon( 'rcl-chat' );

	require_once $chat['path'] . '/class-rcl-chat.php';
	require_once 'classes/class-rcl-chat-viewer.php';

	$chat = new Rcl_Chat_Viewer(
		array(
		'chat_id' => $chat_id
		)
	);

	wp_send_json( array(
		'dialog' => array(
			'content'		 => $chat->get_chat(),
			'title'			 => __( 'Chat' ),
			'class'			 => 'rcl-chat-window',
			'size'			 => 'small',
			'buttonClose'	 => false,
			'onClose'		 => array( 'rcl_chat_clear_beat', array( $chat->token ) )
		)
	) );
}

rcl_ajax_action( 'rcl_get_chat_viewer_page', true );
function rcl_get_chat_viewer_page() {

	rcl_verify_ajax_nonce();

	$chat_page	 = intval( $_POST['page'] );
	$in_page	 = intval( $_POST['in_page'] );
	$important	 = intval( $_POST['important'] );
	$chat_token	 = $_POST['token'];
	$chat_room	 = rcl_chat_token_decode( $chat_token );

	$addon = rcl_get_addon( 'rcl-chat' );

	require_once $addon['path'] . '/class-rcl-chat.php';
	require_once 'classes/class-rcl-chat-viewer.php';

	$chat_id = 'admin';
	if ( 'chat-viewer' != $chat_room ) {
		$chat	 = rcl_get_chat_by_room( $chat_room );
		//print_r( array( $chat, $chat_room, $chat_token ) );
		$chat_id = $chat->chat_id;

		$chat = new Rcl_Chat_Viewer(
			array(
			'chat_id'	 => $chat_id,
			'paged'		 => $chat_page
			)
		);
	} else {
		$chat = new Rcl_Chat_Viewer(
			array(
			'chat_room'	 => 'chat-viewer',
			'paged'		 => $chat_page,
			'important'	 => $important,
			'in_page'	 => $in_page
			)
		);
	}





	$res['content'] = $chat->get_messages_box();

	wp_send_json( $res );
}

function rcl_chat_viewer_get_new_messages( $post ) {
	global $user_ID;

	$content = '';

	$chat = rcl_get_addon( 'rcl-chat' );

	require_once $chat['path'] . '/class-rcl-chat.php';
	require_once 'classes/class-rcl-chat-viewer.php';

	$chat = new Rcl_Chat_Viewer( array(
		'chat_room' => 'chat-viewer'
		) );

	$chat->query['where'][] = "message_time > '" . date( 'Y-m-d H:i:s', current_time( 'timestamp' ) - 10 ) . "'";

	$messages = $chat->get_messages();

	if ( $messages ) {

		krsort( $messages );

		foreach ( $messages as $k => $message ) {
			$content .= $chat->get_message_box( $message );
		}
	}

	$res['content'] = $content;


	$res['success']		 = true;
	$res['token']		 = $post->token;
	$res['current_time'] = current_time( 'mysql' );

	return $res;
}
