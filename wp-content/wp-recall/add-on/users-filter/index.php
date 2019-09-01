<?php

require_once 'classes/class-usf-manager.php';

require_once 'shortcodes.php';

if ( is_admin() )
	require_once 'admin/index.php';

if ( ! is_admin() ):
	add_action( 'rcl_enqueue_scripts', 'usf_scripts', 10 );
endif;
function usf_scripts() {
	rcl_enqueue_style( 'usf-style', rcl_addon_url( 'style.css', __FILE__ ) );
	//rcl_enqueue_script('usf-script',rcl_addon_url('scripts.js', __FILE__));
}

function usf_get_form_fields() {
	return apply_filters( 'usf_form_fields', get_option( 'rcl_fields_users_filter' ) );
}

add_filter( 'rcl_users_query', 'usf_edit_users_query' );
function usf_edit_users_query( $query ) {
	global $wpdb;

	if ( ! isset( $_REQUEST['usf'] ) || ! $_REQUEST['usf'] )
		return $query;

	$fields = usf_get_form_fields();

	if ( ! $fields )
		return $query;

	$usersTable = array(
		'display_name',
		'user_url'
	);

	$relation = rcl_get_option( 'usf-relation', 'AND' );

	//print_r($fields);exit;

	$search_where = array();

	foreach ( $fields as $field ) {

		if ( ! isset( $_REQUEST[$field['slug']] ) || $_REQUEST[$field['slug']] == '' )
			continue;

		if ( $field['type'] == 'dynamic' && count( $_REQUEST[$field['slug']] ) == 1 && ! $_REQUEST[$field['slug']][0] )
			continue;

		$tableAs = 'metas_' . $field['slug'];

		$compareValues = "= '" . $_REQUEST[$field['slug']] . "'";

		if ( in_array( $field['profile-type-field'], array( 'text', 'textarea' ) ) ) {

			if ( $field['search-values'] ) {
				$compareValues = "LIKE '%" . $_REQUEST[$field['slug']] . "%'";
			}
		}

		if ( in_array( $field['slug'], $usersTable ) ) {
			$search_where[] = "wp_users.display_name $compareValues";
			continue;
		}

		if ( in_array( $field['profile-type-field'], array( 'checkbox', 'multiselect', 'dynamic' ) ) ) {

			if ( in_array( $field['type'], array( 'radio', 'select' ) ) ) {

				$compareValues = "LIKE '%" . $_REQUEST[$field['slug']] . "%'";
			} else {

				if ( $field['search-values'] ) {

					foreach ( $_REQUEST[$field['slug']] as $k => $value ) {

						$tableAs .= $k;
						$compareValues = "LIKE '%" . $value . "%'";

						$query['join'][] = "INNER JOIN $wpdb->usermeta AS $tableAs ON wp_users.ID=$tableAs.user_id";

						$searchWhere[] = "($tableAs.meta_key='" . $field['slug'] . "' AND $tableAs.meta_value $compareValues)";
					}

					$search_where[] = "(" . implode( " OR ", $searchWhere ) . ")";

					$query['groupby'] = 'wp_users.ID';

					continue;
				} else {
					$compareValues = "= '" . maybe_serialize( $_REQUEST[$field['slug']] ) . "'";
				}
			}
		}

		if ( in_array( $field['profile-type-field'], array( 'number', 'runner' ) ) ) {

			if ( $field['type'] == 'range' ) {

				$compareValues = "BETWEEN '" . $_REQUEST[$field['slug']][0] . "' AND '" . $_REQUEST[$field['slug']][1] . "'";
			}
		}

		$query['join'][] = "INNER JOIN $wpdb->usermeta AS $tableAs ON wp_users.ID=$tableAs.user_id";
		$search_where[]	 = "($tableAs.meta_key='" . $field['slug'] . "' AND $tableAs.meta_value $compareValues)";
	}

	//$query['relation'] = rcl_get_option('usf-relation','AND');
	//if($query['relation']=='OR')
	//$query['groupby'] = 'wp_users.ID';

	$query['where'][] = '(' . implode( ' ' . $relation . ' ', $search_where ) . ')';

	if ( $relation == 'OR' )
		$query['groupby'] = 'wp_users.ID';

	//print_r($query);
	//exit;

	return $query;
}
