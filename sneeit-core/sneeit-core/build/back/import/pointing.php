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
endif; // dev-reply#59.
/**
 * Check Documentation#56
 */
function sneeit_core_demo_pointing() {
	sneeit_core_ajax_request_verify_die( 'url', 'slug' );
	$sneeit_core_p_url = esc_url( $_POST['url'] );
	$sneeit_core_p_slug = sanitize_key( $_POST['slug'] );
	$sneeit_core_p_dir = dirname( $sneeit_core_p_url );
	$sneeit_core_p_jsonurl = $sneeit_core_p_dir . '/' . $sneeit_core_p_slug . '.json';
	// dev-reply#522.
	$sneeit_core_p_response = wp_remote_get( $sneeit_core_p_jsonurl );
	if ( is_wp_error( $sneeit_core_p_response ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_p_body = wp_remote_retrieve_body( $sneeit_core_p_response );
	$sneeit_core_p_data = json_decode( $sneeit_core_p_body, true );
	if ( ! $sneeit_core_p_data ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_p_data ) || empty( $sneeit_core_p_data['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#540.
	echo json_encode( $sneeit_core_p_data );
	die();
}
/**
 * Check Documentation#530
 */
function sneeit_core_demo_pointing_deprecated() {
	sneeit_core_ajax_request_verify_die( 'slug' );
	$sneeit_core_p_slug = $_POST['slug'];
	$sneeit_core_p_demo_path = get_template_directory() . '/demos/';
	$sneeit_core_p_file_path = $sneeit_core_p_demo_path . $sneeit_core_p_slug;
	if ( ! file_exists( $sneeit_core_p_file_path ) ) {
		sneeit_core_ajax_error_die( 'There are no demo files found: ' . $sneeit_core_p_file_path );
	}
	$sneeit_core_p_data = json_decode( file_get_contents( $sneeit_core_p_file_path ), true );
	if ( empty( $sneeit_core_p_data ) || empty( $sneeit_core_p_data['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#564.
	if ( empty( $sneeit_core_p_data['info']['screenshot'] ) ) {
		$sneeit_core_p_screenshot_src = sneeit_core_demo_default_screenshot( $sneeit_core_p_file_path );
		if ( $sneeit_core_p_screenshot_src ) {
			$sneeit_core_p_data['info']['screenshot'] = $sneeit_core_p_screenshot_src;
		}
	}
	echo json_encode( $sneeit_core_p_data );
	die();
}
