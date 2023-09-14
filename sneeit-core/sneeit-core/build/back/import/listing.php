<?php
/**
 * DragBlock's Import.
 *
 * @package Listing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_listing', 'sneeit_core_demo_listing' );
	add_action( 'wp_ajax_sneeit_core_demo_listing', 'sneeit_core_demo_listing' );
endif; // dev-reply#49.
/**
 * Check Documentation#46
 */
function sneeit_core_demo_listing() {
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_0 = esc_url( $_POST['url'] );
	// dev-reply#418.
	$sneeit_core_1 = wp_remote_get( $sneeit_core_0 );
	if ( is_wp_error( $sneeit_core_1 ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_2 = wp_remote_retrieve_body( $sneeit_core_1 );
	$sneeit_core_3 = json_decode( $sneeit_core_2, true );
	if ( ! $sneeit_core_3 ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	$sneeit_core_4 = array();
	foreach ( $sneeit_core_3 as $sneeit_core_5 ) {
		$sneeit_core_4[ sanitize_key( $sneeit_core_5 ) ] = array( 'info' => array( 'name' => $sneeit_core_5 ) );
		// dev-reply#436.
	}
	if ( empty( $sneeit_core_4 ) ) {
		sneeit_core_ajax_error_die( 'No valid demo data found' );
	}
	echo json_encode( $sneeit_core_4 );
	die();
}
/**
 * Check Documentation#431
 *
 * @param object|array|string $sneeit_core_6 check var-def#431.
 */
function sneeit_core_demo_default_screenshot( $sneeit_core_6 ) {
	$sneeit_core_7 = array( 'png', 'jpg', 'jpeg', 'gif' );
	foreach ( $sneeit_core_7 as $sneeit_core_8 ) {
		$sneeit_core_9 = str_replace( '.json', '.' . $sneeit_core_8, $sneeit_core_6 );
		if ( ! file_exists( $sneeit_core_9 ) ) {
			continue;
		}
		return get_template_directory_uri() . '/demos/' . str_replace( '.json', '.' . $sneeit_core_8, basename( $sneeit_core_6 ) );
	}
	return '';
}
