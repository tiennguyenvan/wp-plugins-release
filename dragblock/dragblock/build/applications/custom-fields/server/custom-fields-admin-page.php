<?php
/**
 * DragBlock's Custom-fields.
 *
 * @package Custom fields admin page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_menu', 'dragblock_custom_fields_admin_menu' );
/**
 * Check Documentation#23
 */
function dragblock_custom_fields_admin_menu() {
	$dragblock_cfap_title = 'Custom Fields';
	add_submenu_page(
		DRAGBLOCK_ADMIN_MENU_SLUG, // dev-reply#28.
		$dragblock_cfap_title,
		$dragblock_cfap_title,
		'manage_options', // dev-reply#211.
		DRAGBLOCK_CUSTOM_FIELDS_SLUG,
		'dragblock_custom_fields_admin_page'
	);
}
/**
 * Check Documentation#214
 */
function dragblock_custom_fields_admin_page() {
	echo '<div class="' . DRAGBLOCK_CUSTOM_FIELDS_SLUG . ' app wrap"></div>';
}
