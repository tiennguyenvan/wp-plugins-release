<?php
/**
 * DragBlock's Import.
 *
 * @package Pointing
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
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_p_data = wp_unslash( $_POST['data'] );
	if ( empty( $sneeit_core_p_data['url'] ) ) {
		sneeit_core_ajax_error_die( 'Empty URL' );
	}
	$sneeit_core_p_post = sanitize_text_field( $sneeit_core_p_data['url'] );
	// dev-reply#325.
	$sneeit_core_p_jsonurl = wp_remote_get( $sneeit_core_p_post );
	if ( is_wp_error( $sneeit_core_p_jsonurl ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data: ' . $sneeit_core_p_jsonurl->get_error_message() . ' (' . $sneeit_core_p_post . ')' );
	}
	$sneeit_core_p_response = wp_remote_retrieve_body( $sneeit_core_p_jsonurl );
	$sneeit_core_p_data = json_decode( $sneeit_core_p_response, true );
	if ( ! $sneeit_core_p_data ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_p_data ) || empty( $sneeit_core_p_data['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#344.
	echo json_encode( $sneeit_core_p_data );
	die();
}
