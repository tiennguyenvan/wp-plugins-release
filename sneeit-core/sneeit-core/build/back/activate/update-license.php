<?php
/**
 * DragBlock's Activate.
 *
 * @package Update license
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_update_sneeit_license', 'sneeit_core_update_sneeit_license' );
	add_action( 'wp_ajax_sneeit_core_update_sneeit_license', 'sneeit_core_update_sneeit_license' );
endif; // dev-reply#29.
/**
 * Check Documentation#26
 */
function sneeit_core_update_sneeit_license() {
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_0 = sanitize_key( $_POST['data'] );
	update_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, $sneeit_core_0 );
	echo json_encode( 'DONE' );
	die();
}
