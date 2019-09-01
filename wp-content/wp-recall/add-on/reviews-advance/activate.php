<?php
global $wpdb;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
$collate = '';

if ( $wpdb->has_cap( 'collation' ) ) {
    if ( ! empty( $wpdb->charset ) ) {
        $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
    }
    if ( ! empty( $wpdb->collate ) ) {
        $collate .= " COLLATE $wpdb->collate";
    }
}

$table = RCL_PREF ."reviews";
$sql = "CREATE TABLE IF NOT EXISTS ". $table . " (
    review_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    object_id BIGINT(20) UNSIGNED NOT NULL,
    rating_type VARCHAR(20) NOT NULL,
    object_author BIGINT(20) UNSIGNED NOT NULL,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    review_content LONGTEXT NOT NULL,
    review_comment TINYTEXT NOT NULL,
    rating_value VARCHAR(5) NOT NULL,
    review_date DATETIME NOT NULL,
    review_status TINYINT(1) UNSIGNED NOT NULL,
    PRIMARY KEY  review_id (review_id),
      KEY object_id (object_id),
      KEY rating_type (rating_type),
      KEY user_id (user_id)
    ) $collate;";

dbDelta( $sql );
