<?php
/**
 * DragBlock's Import.
 *
 * @package Import pointing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_pointing', 'sneeit_core_demo_pointing' );
	add_action( 'wp_ajax_sneeit_core_demo_pointing', 'sneeit_core_demo_pointing' );
endif; // dev-reply#39.
/**
 * Check Documentation#36
 */
function sneeit_core_demo_pointing() {
	// dev-reply#315.
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_ip_jsonurl = sanitize_text_field( wp_unslash( $_POST['url'] ) );
	// dev-reply#320.
	$sneeit_core_ip_post = wp_remote_get( $sneeit_core_ip_jsonurl );
	if ( is_wp_error( $sneeit_core_ip_post ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data: ' . $sneeit_core_ip_post->get_error_message() . ' (' . $sneeit_core_ip_jsonurl . ')' );
	}
	$sneeit_core_ip_response = wp_remote_retrieve_body( $sneeit_core_ip_post );
	$sneeit_core_ip_body = json_decode( $sneeit_core_ip_response, true );
	if ( ! $sneeit_core_ip_body ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_ip_body ) || empty( $sneeit_core_ip_body['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#339.
	echo json_encode( $sneeit_core_ip_body );
	die();
}
