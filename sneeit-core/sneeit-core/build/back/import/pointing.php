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
	$sneeit_core_0 = esc_url( $_POST['url'] );
	$sneeit_core_1 = sanitize_key( $_POST['slug'] );
	$sneeit_core_2 = dirname( $sneeit_core_0 );
	$sneeit_core_3 = $sneeit_core_2 . '/' . $sneeit_core_1 . '.json';
	// dev-reply#522.
	$sneeit_core_4 = wp_remote_get( $sneeit_core_3 );
	if ( is_wp_error( $sneeit_core_4 ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_5 = wp_remote_retrieve_body( $sneeit_core_4 );
	$sneeit_core_6 = json_decode( $sneeit_core_5, true );
	if ( ! $sneeit_core_6 ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	if ( empty( $sneeit_core_6 ) || empty( $sneeit_core_6['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#540.
	echo json_encode( $sneeit_core_6 );
	die();
}
/**
 * Check Documentation#530
 */
function sneeit_core_demo_pointing_deprecated() {
	sneeit_core_ajax_request_verify_die( 'slug' );
	$sneeit_core_1 = $_POST['slug'];
	$sneeit_core_7 = get_template_directory() . '/demos/';
	$sneeit_core_8 = $sneeit_core_7 . $sneeit_core_1;
	if ( ! file_exists( $sneeit_core_8 ) ) {
		sneeit_core_ajax_error_die( 'There are no demo files found: ' . $sneeit_core_8 );
	}
	$sneeit_core_6 = json_decode( file_get_contents( $sneeit_core_8 ), true );
	if ( empty( $sneeit_core_6 ) || empty( $sneeit_core_6['info'] ) ) {
		sneeit_core_ajax_error_die( 'File data is empty' );
	}
	// dev-reply#564.
	if ( empty( $sneeit_core_6['info']['screenshot'] ) ) {
		$sneeit_core_9 = sneeit_core_demo_default_screenshot( $sneeit_core_8 );
		if ( $sneeit_core_9 ) {
			$sneeit_core_6['info']['screenshot'] = $sneeit_core_9;
		}
	}
	echo json_encode( $sneeit_core_6 );
	die();
}
