
function rcl_get_chat_viewer_window( chat_id ) {

	rcl_ajax( {
		data: {
			action: 'rcl_get_ajax_chat_viewer_window',
			chat_id: chat_id
		}
	} );

}

function rcl_chat_viewer_navi( e ) {

	rcl_chat_inactivity_cancel();

	var token = jQuery( e ).parents( '.rcl-chat' ).data( 'token' );

	rcl_preloader_show( '.rcl-chat .chat-form > form' );

	rcl_ajax( {
		data: {
			action: 'rcl_get_chat_viewer_page',
			token: token,
			page: jQuery( e ).data( 'page' ),
			'pager-id': jQuery( e ).data( 'pager-id' ),
			in_page: jQuery( e ).parents( '.rcl-chat' ).data( 'in_page' ),
			important: rcl_chat_important
		},
		success: function( data ) {

			if ( data['content'] ) {

				jQuery( e ).parents( '.chat-messages-box' ).html( data['content'] ).animateCss( 'fadeIn' );

				rcl_chat_scroll_bottom( token );

			}
		}
	} );

	return false;
}

function rcl_chat_viewer_beat_core( chat ) {

	var chatBox = jQuery( '.rcl-chat[data-token="' + chat.token + '"]' );

	var chat_form = chatBox.find( 'form' );

	var beat = {
		action: 'rcl_chat_viewer_get_new_messages',
		success: 'rcl_chat_beat_success',
		data: {
			last_activity: rcl_chat_last_activity[chat.token],
			token: chat.token,
			update_activity: 1,
			user_write: ( chat_form.find( 'textarea' ).val() ) ? 1 : 0
		}
	};

	return beat;

}

function rcl_beat() {

	var beats = rcl_apply_filters( 'rcl_beats', rcl_beats );

	var DataBeat = rcl_get_actual_beats_data( beats );

	if ( rcl_beats_delay && DataBeat.length ) {

		rcl_do_action( 'rcl_beat' );

		rcl_ajax( {
			data: {
				action: 'rcl_beat',
				databeat: JSON.stringify( DataBeat )
			},
			success: function( data ) {

				data.forEach( function( result, i, data ) {

					rcl_do_action( 'rcl_beat_success_' + result['beat_name'] );

					new ( window[result['success']] )( result['result'] );

				} );

			}
		} );

	}

	rcl_beats_delay++;

	setTimeout( 'rcl_beat()', 1000 );
}

function rcl_get_actual_beats_data( beats ) {

	var beats_actual = new Array();

	if ( beats ) {

		beats.forEach( function( beat, i, beats ) {
			var rest = rcl_beats_delay % beat.delay;
			if ( rest == 0 ) {

				var object = new ( window[beat.beat_name] )( beat.data );

				if ( object.data ) {

					object = rcl_apply_filters( 'rcl_beat_' + beat.beat_name, object );

					object.beat_name = beat.beat_name;

					var k = beats_actual.length;
					beats_actual[k] = object;
				}
			}
		} );

	}

	return beats_actual;

}