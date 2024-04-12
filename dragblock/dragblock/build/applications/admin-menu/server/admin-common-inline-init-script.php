<?php
/**
 * DragBlock's Admin-menu.
 *
 * @package Admin common inline init script
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#12
 *
 * @param object|array|string $dragblock_aciis_extra check var-def#12.
 */
function dragblock_admin_common_inline_init_script( $dragblock_aciis_extra = array() ) {
	// dev-reply#15.
	return array_merge( array(
		'blankDemoImgUrl' => DRAGBLOCK_URL . 'assets/images/demo/blank.png',
		'siteLocale' => get_locale(),
		'homeUrl' => get_home_url(),
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( DRAGBLOCK_NONCE_SLUG ),
	), $dragblock_aciis_extra );
}
