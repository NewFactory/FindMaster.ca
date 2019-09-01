<?php

require_once 'functions-ajax.php';

add_action( 'admin_init', 'fng_admin_scripts', 10 );
function fng_admin_scripts() {
	wp_enqueue_style( 'fng-styles', rcl_addon_url( 'admin/assets/style.css', __FILE__ ) );
	wp_enqueue_script( 'fng-scripts', rcl_addon_url( 'admin/assets/scripts.js', __FILE__ ) );
}

add_action( 'admin_menu', 'fng_options_activate', 100 );
function fng_options_activate() {
	add_submenu_page( 'manage-wprecall', 'Активация Freelance', 'Активация Freelance', 'edit_plugins', 'fng-manage', 'fng_activate_page' );
}

function fng_activate_page() {
	echo reg_form_wpp( 'fng' );
}

add_filter( 'admin_options_wprecall', 'fng_options' );
function fng_options( $content ) {

	$opt = new Rcl_Options( __FILE__ );

	$optionsFields = apply_filters( 'fng_options_fields', array(
		array(
			'type'	 => 'number',
			'slug'	 => 'fng-service-percent',
			'title'	 => __( 'Комиссия сервиса (%)' ),
			'notice' => __( 'Комиссия удерживаемая сервисом при начислении средств исполнителю по завершении задания' ),
		),
		array(
			'type'	 => 'number',
			'slug'	 => 'fng-bot',
			'title'	 => __( 'ID Бота' ),
			'notice' => __( 'укажите идентификатор пользователя от имени '
				. 'которого в рабочую область задания будут добавляться сервисные сообщения. '
				. 'Если ничего не указано, то сервисные сообщения добавляться не будут.' ),
		),
		array(
			'type'	 => 'radio',
			'slug'	 => 'fng-comments',
			'title'	 => __( 'Комментирование заявки' ),
			'values' => array(
				__( 'Отключено' ),
				__( 'Включено' )
			),
			'notice' => __( 'возможность комментирования заявки претендента автором задания и самим претендентом' ),
		),
		array(
			'type'	 => 'radio',
			'slug'	 => 'fng-reserve',
			'title'	 => __( 'Резервирование средств' ),
			'values' => array(
				__( 'Отключено' ),
				__( 'Включено' )
			),
			'notice' => __( 'если включено, то при назначении исполнителя автору задания '
				. 'придется зарезервировать средства для оплаты его услуг по завершении задания' ),
		),
		array(
			'type'	 => 'radio',
			'slug'	 => 'fng-close-noview',
			'title'	 => __( 'Скрытие завершенных заданий' ),
			'values' => array(
				__( 'Отключено' ),
				__( 'Включено' )
			),
			'notice' => __( 'если включено, то завершенные задания будут скрываться на странице архива заданий' ),
		),
		array(
			'type'	 => 'radio',
			'slug'	 => 'fng-view-requests',
			'title'	 => __( 'Порядок вывода всех заявок к заданию' ),
			'values' => array(
				__( 'Только автору' ),
				__( 'Всем' )
			)
		),
		array(
			'type'	 => 'radio',
			'slug'	 => 'fng-view-performer',
			'title'	 => __( 'Показывать исполнителя задания' ),
			'values' => array(
				__( 'Нет' ),
				__( 'Да' )
			)
		)
		) );

	$content .= $opt->options(
		__( 'Настройки Freelance NG', 'wp-recall' ), $opt->options_box(
			__( 'Freelance NextGen', 'wp-recall' ), $optionsFields
		)
	);

	return $content;
}

add_action( 'admin_init', 'fng_status_manager_init', 1 );
function fng_status_manager_init() {

	$chat = rcl_get_addon( 'rcl-chat' );

	wp_enqueue_style( 'rcl-chat', rcl_addon_url( 'style.css', $chat['path'] ) );
	wp_enqueue_script( 'rcl-chat-sounds', rcl_addon_url( 'js/ion.sound.min.js', $chat['path'] ), array( 'rcl-core-scripts' ) );
	wp_enqueue_script( 'rcl-chat', rcl_addon_url( 'js/scripts.js', $chat['path'] ), array( 'rcl-core-scripts' ) );

	add_meta_box( 'fng_status_manager', __( 'Менеджер задания' ), 'fng_status_manager_metabox', 'task', 'normal', 'high' );
}

function fng_status_manager_metabox( $post ) {

	$taskStatus = get_post_meta( $post->ID, 'fng-status', 1 );

	$metaBox = '<div id="fng-task-metabox">';

	$metaBox .= '<p>' . __( 'Текущий статус задания' ) . ': ' . fng_get_status_name( $taskStatus ) . '</p>';

	$metaBox .= fng_admin_task_manager( $post->ID );

	$metaBox .= '</div>';

	echo $metaBox;
}

function fng_admin_task_manager( $post_id ) {

	$taskStatus = get_post_meta( $post_id, 'fng-status', 1 );

	$items = array();

	if ( $taskStatus == 1 ) { //подбор исполнителя
		$items[] = array(
			'id'		 => 'fng-take-performer',
			'label'		 => __( 'Назначить исполнителя' ),
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_admin_get_form_take_performer',
				'task_id'	 => $post_id
			) ) . ',this);return false;'
		);
	}

	if ( in_array( $taskStatus, array( 2, -3 ) ) ) { //в работе, арбитраж
		$items[] = array(
			'id'		 => 'fng-task-complete',
			'label'		 => __( 'Завершить задание' ),
			'icon'		 => 'fa-pencil-square',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_task_complete',
				'task_id'	 => $post_id,
				'confirm'	 => __( 'Вы уверены?' )
			) ) . ',this);return false;'
		);

		$items[] = array(
			'id'		 => 'fng-performer-fired',
			'label'		 => __( 'Отказаться от исполнителя' ),
			'icon'		 => 'fa-pencil-square',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_performer_fired',
				'task_id'	 => $post_id,
				'confirm'	 => __( 'Вы уверены?' )
			) ) . ',this);return false;'
		);

		$items[] = array(
			'id'		 => 'fng-status-in-work',
			'label'		 => __( 'Сменить исполнителя' ),
			'icon'		 => 'fa-pencil-square',
			'onclick'	 => 'fng_ajax(' . json_encode( array(
				'action'	 => 'fng_ajax_admin_get_form_update_performer',
				'task_id'	 => $post_id
			) ) . ',this);return false;'
		);
	}

	if ( $status == -3 ) { //арбитраж
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

	$items[] = array(
		'id'		 => 'fng-get-work-area',
		'label'		 => __( 'Смотреть рабочую область' ),
		'icon'		 => 'fa-pencil-square',
		'onclick'	 => 'fng_ajax(' . json_encode( array(
			'action'	 => 'fng_ajax_get_work_area',
			'task_id'	 => $post_id
		) ) . ',this);return false;'
	);

	if ( !$items )
		return false;

	$content = '<p>' . __( 'Вам доступны следующие операции' ) . ':</p>';

	$content .= fng_get_manager( $items );

	return $content;
}

add_filter( 'manage_edit-task_columns', 'fng_add_custom_tasks_column', 10, 1 );
function fng_add_custom_tasks_column( $columns ) {

	$out = array();

	foreach ( ( array ) $columns as $col => $name ) {
		if ( ++$i == 3 ) {
			$out['status'] = 'Статус';
		}

		$out[$col] = $name;
	}

	return $out;
}

add_filter( 'manage_task_posts_custom_column', 'fng_add_content_custom_tasks_column', 5, 2 );
function fng_add_content_custom_tasks_column( $column_name, $post_id ) {

	if ( $column_name == 'status' ) {

		$statusId = get_post_meta( $post_id, 'fng-status', 1 );

		$content = fng_get_status_name( $statusId );

		if ( $statusId == '-3' ) {
			$content = '<span style="color:red;">' . $content . '</span>';
		}

		echo $content;
	}
}
