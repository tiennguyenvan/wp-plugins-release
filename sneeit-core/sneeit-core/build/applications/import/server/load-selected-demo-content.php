<?php
/**
 * DragBlock's Import.
 *
 * @package Load selected demo content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_load_selected_demo_content', 'sneeit_core_load_selected_demo_content' );
	add_action( 'wp_ajax_sneeit_core_load_selected_demo_content', 'sneeit_core_load_selected_demo_content' );
endif; // dev-reply#39.
/**
 * Check Documentation#36
 */
function sneeit_core_load_selected_demo_content() {
	// dev-reply#312.
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_lsdc_jsonurl = sanitize_text_field( wp_unslash( $_POST['url'] ) );
	// dev-reply#317.
	$sneeit_core_lsdc_post = wp_remote_get( $sneeit_core_lsdc_jsonurl );
	if ( is_wp_error( $sneeit_core_lsdc_post ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data: ' . $sneeit_core_lsdc_post->get_error_message() . ' (' . $sneeit_core_lsdc_jsonurl . ')' );
	}
	$sneeit_core_lsdc_response = wp_remote_retrieve_body( $sneeit_core_lsdc_post );
	$sneeit_core_lsdc_body = json_decode( $sneeit_core_lsdc_response, true );
	if ( ! $sneeit_core_lsdc_body ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_lsdc_body ) || empty( $sneeit_core_lsdc_body['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#336.
	echo json_encode( $sneeit_core_lsdc_body );
	die();
}
