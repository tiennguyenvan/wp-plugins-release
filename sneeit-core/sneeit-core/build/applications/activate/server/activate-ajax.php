<?php
/**
 * DragBlock's Activate.
 *
 * @package Activate ajax
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_update_sneeit_license', 'sneeit_core_update_sneeit_license' );
	add_action( 'wp_ajax_sneeit_core_update_sneeit_license', 'sneeit_core_update_sneeit_license' );
endif; // dev-reply#28.
/**
 * Check Documentation#26
 */
function sneeit_core_update_sneeit_license() {
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_aa_data = sanitize_text_field( wp_unslash( $_POST['data'] ) );
	update_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, $sneeit_core_aa_data );
	echo json_encode( 'DONE' );
	die();
}
