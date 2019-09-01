<?php

function fng_get_manager( $items ) {

	if ( ! $items )
		return false;

	rcl_dialog_scripts();

	$content = '<div class="fng-manager preloader-box">';

	foreach ( $items as $item ) {

		$class				 = (isset( $item['class'] )) ? $item['class'] : '';
		$link				 = (isset( $item['url'] )) ? $item['url'] : '#';
		$attrs['title']		 = (isset( $item['title'] )) ? $item['title'] : $item['label'];
		$attrs['onclick']	 = (isset( $item['onclick'] )) ? $item['onclick'] : false;
		$datas				 = array();
		$attributs			 = array();

		if ( isset( $item['data'] ) ) {

			foreach ( $item['data'] as $k => $value ) {
				if ( ! $value )
					continue;
				$datas[] = 'data-' . $k . '="' . $value . '"';
			}
		}

		foreach ( $attrs as $attr => $value ) {
			if ( ! $value )
				continue;
			$attributs[] = $attr . '=\'' . $value . '\'';
		}

		$content .= '<div id="' . $item['id'] . '-item" class="manager-item ' . $class . '">';

		$content .= '<a href="' . $link . '" class="recall-button" ' . implode( ' ', $attributs ) . ' ' . implode( ' ', $datas ) . '>';

		if ( isset( $item['icon'] ) ):
			$content .= '<i class="rcli ' . $item['icon'] . '" aria-hidden="true"></i>';
		endif;

		if ( isset( $item['label'] ) ):
			$content .= '<span class="item-label">' . $item['label'] . '</span>';
		endif;

		if ( isset( $item['counter'] ) ):
			$content .= '<span class="item-counter">' . $item['counter'] . '</span>';
		endif;

		$content .= '</a>';

		$content .= '</div>';
	}

	$content .= '</div>';

	return $content;
}

function fng_get_request_manager( $request_id ) {
	global $user_ID, $fng_request, $post;

	if ( is_object( $fng_request ) ) {
		$request = $fng_request;
	} else {
		$request = fng_get_request( $request_id );
	}

	$items = array();

	if ( $request->author_id == $user_ID ) {

		$items[] = array(
			'id'		 => 'fng-request-remove',
			'label'		 => __( 'Удалить' ),
			'icon'		 => 'fa-remove',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_request_remove',
				'request_id' => $request_id,
				'confirm'	 => __( 'Вы уверены?' )
			) ) . ',this);return false;'
		);

		$items[] = array(
			'id'		 => 'fng-request-edit',
			'label'		 => __( 'Изменить' ),
			'icon'		 => 'fa-pencil-square-o',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_get_request_edit_form',
				'request_id' => $request_id
			) ) . ',this);return false;'
		);
	} else if ( $post->post_author == $user_ID ) {

		$items[] = array(
			'id'		 => 'fng-request-reject',
			'label'		 => __( 'Отказать' ),
			'icon'		 => 'fa-remove',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_request_reject',
				'request_id' => $request_id,
				'confirm'	 => __( 'Вы уверены?' )
			) ) . ',this);return false;'
		);

		$items[] = array(
			'id'		 => 'fng-request-take',
			'label'		 => __( 'Выбрать исполнителем' ),
			'icon'		 => 'fa-handshake-o',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_get_request_payment_form',
				'request_id' => $request_id,
				'confirm'	 => __( 'Вы уверены?' )
			) ) . ',this);return false;'
		);
	}

	$items = apply_filters( 'fng_manager_request_items', $items, $request_id );

	return fng_get_manager( $items );
}

function fng_get_task_manager( $task_id ) {
	global $user_ID, $post;

	if ( ! is_object( $post ) ) {
		$post = get_post( $task_id );
	}

	$status_id = get_post_meta( $task_id, 'fng-status', 1 );

	$performer = get_post_meta( $task_id, 'fng-performer', 1 );

	$items = array();

	if ( $post->post_author == $user_ID ) {

		if ( in_array( $status_id, array( -4 ) ) ) {

			$items[] = array(
				'id'		 => 'fng-performer-fired',
				'label'		 => __( 'Отказаться от исполнителя' ),
				'icon'		 => 'fa-frown-o',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_performer_fired',
					'task_id'	 => $task_id,
					'confirm'	 => __( 'Вы уверены?' )
				) ) . ',this);return false;'
			);

			$items[] = array(
				'id'		 => 'fng-add-time',
				'label'		 => __( 'Продлить время' ),
				'icon'		 => 'fa-clock-o fa-clock',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_add_time_form',
					'task_id'	 => $task_id,
					//'confirm' => __('Вы уверены?')
				) ) . ',this);return false;'
			);
		}

		if ( ! in_array( $status_id, array( 1, 5, -3 ) ) ) {

			$items[] = array(
				'id'		 => 'fng-task-claim',
				'label'		 => __( 'Арбитраж' ),
				'icon'		 => 'fa-gavel',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_get_claim_form',
					'task_id'	 => $task_id,
					'confirm'	 => __( 'Вы уверены?' )
				) ) . ',this);return false;'
			);

			$items[] = array(
				'id'		 => 'fng-task-success',
				'label'		 => __( 'Подтвердить выполнение' ),
				'icon'		 => 'fa-check-square-o',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_task_complete',
					'task_id'	 => $task_id,
					'confirm'	 => __( 'Вы уверены?' )
				) ) . ',this);return false;'
			);
		}
	}

	if ( $performer == $user_ID ) {

		if ( in_array( $status_id, array( 2, -4 ) ) ) {

			$items[] = array(
				'id'		 => 'fng-task-claim',
				'label'		 => __( 'Арбитраж' ),
				'icon'		 => 'fa-gavel',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_get_claim_form',
					'task_id'	 => $task_id,
					'confirm'	 => __( 'Вы уверены?' )
				) ) . ',this);return false;'
			);

			$items[] = array(
				'id'		 => 'fng-performer-fail',
				'label'		 => __( 'Отказаться от выполнения' ),
				'icon'		 => 'fa-remove',
				'onclick'	 => 'fng_ajax(' . json_encode( array(
					'action'	 => 'fng_ajax_performer_fail',
					'task_id'	 => $task_id,
					'confirm'	 => __( 'Вы уверены?' )
				) ) . ',this);return false;'
			);
		}
	}

	$items = apply_filters( 'fng_manager_task_items', $items, $post );

	return fng_get_manager( $items );
}
