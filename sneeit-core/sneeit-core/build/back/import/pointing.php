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
endif; // dev-reply#69.
/**
 * Check Documentation#66
 */
function sneeit_core_demo_pointing() {
	// dev-reply#615.
	sneeit_core_ajax_request_verify_die( 'url' );
	// dev-reply#618.
	$sneeit_core_p_jsonurl = sanitize_text_field( wp_unslash( $_POST['url'] ) );
	// dev-reply#632.
	$sneeit_core_p_jsonurl = wp_remote_get( $sneeit_core_p_jsonurl );
	if ( is_wp_error( $sneeit_core_p_jsonurl ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data: ' . $sneeit_core_p_jsonurl->get_error_message() . ' (' . $sneeit_core_p_jsonurl . ')' );
	}
	$sneeit_core_p_post = wp_remote_retrieve_body( $sneeit_core_p_jsonurl );
	$sneeit_core_p_response = json_decode( $sneeit_core_p_post, true );
	if ( ! $sneeit_core_p_response ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_p_response ) || empty( $sneeit_core_p_response['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#651.
	echo json_encode( $sneeit_core_p_response );
	die();
}
/**
 * Check Documentation#629
 */
function sneeit_core_demo_pointing_deprecated() {
	sneeit_core_ajax_request_verify_die( 'slug' );
	$sneeit_core_p_body = $_POST['slug'];
	$sneeit_core_p_data = get_template_directory() . '/demos/';
	$sneeit_core_p_slug = $sneeit_core_p_data . $sneeit_core_p_body;
	if ( ! file_exists( $sneeit_core_p_slug ) ) {
		sneeit_core_ajax_error_die( 'There are no demo files found: ' . $sneeit_core_p_slug );
	}
	$sneeit_core_p_response = json_decode( file_get_contents( $sneeit_core_p_slug ), true );
	if ( empty( $sneeit_core_p_response ) || empty( $sneeit_core_p_response['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#675.
	if ( empty( $sneeit_core_p_response['info']['screenshot'] ) ) {
		$sneeit_core_p_demo = sneeit_core_demo_default_screenshot( $sneeit_core_p_slug );
		if ( $sneeit_core_p_demo ) {
			$sneeit_core_p_response['info']['screenshot'] = $sneeit_core_p_demo;
		}
	}
	echo json_encode( $sneeit_core_p_response );
	die();
}
