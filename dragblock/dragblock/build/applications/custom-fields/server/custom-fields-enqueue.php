<?php
/**
 * DragBlock's Custom-fields.
 *
 * @package Custom fields enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_enqueue_scripts', 'dragblock_custom_field_app_enqueue' );
/**
 * Check Documentation#13
 */
function dragblock_custom_field_app_enqueue() {
	if ( ! dragblock_is_sub_admin_page( DRAGBLOCK_CUSTOM_FIELDS_SLUG ) ) {
		return;
	}
	// dev-reply#19.
	dragblock_admin_page_enqueue( DRAGBLOCK_APP_PATH . "custom-fields/client/admin/" );
}
