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
endif; // dev-reply#79.
/**
 * Check Documentation#76
 */
function sneeit_core_demo_listing() {
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_0 = esc_url( $_POST['url'] );
	// dev-reply#718.
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
		// dev-reply#736.
	}
	if ( empty( $sneeit_core_4 ) ) {
		sneeit_core_ajax_error_die( 'No valid demo data found' );
	}
	echo json_encode( $sneeit_core_4 );
	die();
}
/**
 * Check Documentation#731
 *
 * @param object|array|string $sneeit_core_6 check var-def#731.
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
/**
 * Check Documentation#743
 */
function sneeit_core_demo_listing_deprecated() {
	sneeit_core_ajax_request_verify_die();
	$sneeit_core_10 = get_template_directory() . '/demos/';
	$sneeit_core_11 = glob( $sneeit_core_10 . '/*.json' );
	if ( empty( $sneeit_core_11 ) ) {
		sneeit_core_ajax_error_die( 'There are no demo files' );
	}
	$sneeit_core_4 = array();
	foreach ( $sneeit_core_11 as $sneeit_core_6 ) {
		$sneeit_core_3 = json_decode( file_get_contents( $sneeit_core_6 ), true );
		if ( empty( $sneeit_core_3 ) || empty( $sneeit_core_3['info'] ) ) {
			continue;
		}
		// dev-reply#782.
		if ( empty( $sneeit_core_3['info']['screenshot'] ) ) {
			$sneeit_core_12 = sneeit_core_demo_default_screenshot( $sneeit_core_6 );
			if ( $sneeit_core_12 ) {
				$sneeit_core_3['info']['screenshot'] = $sneeit_core_12;
			}
		}
		$sneeit_core_4[ basename( $sneeit_core_6 ) ] = array( 'info' => $sneeit_core_3['info'] );
	}
	if ( empty( $sneeit_core_4 ) ) {
		sneeit_core_ajax_error_die( 'There are no valid demo files' );
	}
	echo json_encode( $sneeit_core_4 );
	die();
}
