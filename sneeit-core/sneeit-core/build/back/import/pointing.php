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
	$sneeit_core_p_url = sanitize_key( $_POST['slug'] );
	$sneeit_core_p_post = dirname( $sneeit_core_p_url );
	$sneeit_core_p_slug = $sneeit_core_p_post . '/' . $sneeit_core_p_url . '.json';
	// dev-reply#524.
	$sneeit_core_p_dir = wp_remote_get( $sneeit_core_p_slug );
	if ( is_wp_error( $sneeit_core_p_dir ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_p_jsonurl = wp_remote_retrieve_body( $sneeit_core_p_dir );
	$sneeit_core_p_response = json_decode( $sneeit_core_p_jsonurl, true );
	if ( ! $sneeit_core_p_response ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_p_response ) || empty( $sneeit_core_p_response['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#542.
	echo json_encode( $sneeit_core_p_response );
	die();
}
/**
 * Check Documentation#530
 */
function sneeit_core_demo_pointing_deprecated() {
	sneeit_core_ajax_request_verify_die( 'slug' );
	$sneeit_core_p_url = $_POST['slug'];
	$sneeit_core_p_body = get_template_directory() . '/demos/';
	$sneeit_core_p_data = $sneeit_core_p_body . $sneeit_core_p_url;
	if ( ! file_exists( $sneeit_core_p_data ) ) {
		sneeit_core_ajax_error_die( 'There are no demo files found: ' . $sneeit_core_p_data );
	}
	$sneeit_core_p_response = json_decode( file_get_contents( $sneeit_core_p_data ), true );
	if ( empty( $sneeit_core_p_response ) || empty( $sneeit_core_p_response['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#566.
	if ( empty( $sneeit_core_p_response['info']['screenshot'] ) ) {
		$sneeit_core_p_demo = sneeit_core_demo_default_screenshot( $sneeit_core_p_data );
		if ( $sneeit_core_p_demo ) {
			$sneeit_core_p_response['info']['screenshot'] = $sneeit_core_p_demo;
		}
	}
	echo json_encode( $sneeit_core_p_response );
	die();
}
