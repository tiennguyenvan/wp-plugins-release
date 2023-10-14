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
endif; // dev-reply#59.
/**
 * Check Documentation#56
 */
function sneeit_core_demo_listing() {
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_l_url = esc_url( $_POST['url'] );
	// dev-reply#518.
	$sneeit_core_l_url = wp_remote_get( $sneeit_core_l_url );
	if ( is_wp_error( $sneeit_core_l_url ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_l_post = wp_remote_retrieve_body( $sneeit_core_l_url );
	$sneeit_core_l_response = json_decode( $sneeit_core_l_post, true );
	if ( ! $sneeit_core_l_response ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	$sneeit_core_l_body = array();
	foreach ( $sneeit_core_l_response as $sneeit_core_l_data => $sneeit_core_l_list ) {
		// dev-reply#535.
		$sneeit_core_l_demo = is_numeric( $sneeit_core_l_data ) ? $sneeit_core_l_list : $sneeit_core_l_data;
		$sneeit_core_l_name = is_numeric( $sneeit_core_l_data ) ? "" : $sneeit_core_l_list; // dev-reply#537.
		$sneeit_core_l_body[ sanitize_key( $sneeit_core_l_demo ) ] = array(
			'info' => array(
				'name' => $sneeit_core_l_demo,
				'categories' => $sneeit_core_l_name,
			),
		);
		// dev-reply#544.
	}
	if ( empty( $sneeit_core_l_body ) ) {
		sneeit_core_ajax_error_die( 'No valid demo data found' );
	}
	echo json_encode( $sneeit_core_l_body );
	die();
}
/**
 * Check Documentation#539
 *
 * @param object|array|string $sneeit_core_l_categories check var-def#539.
 */
function sneeit_core_demo_default_screenshot( $sneeit_core_l_categories ) {
	$sneeit_core_l_file = array( 'png', 'jpg', 'jpeg', 'gif' );
	foreach ( $sneeit_core_l_file as $sneeit_core_l_path ) {
		$sneeit_core_l_exts = str_replace( '.json', '.' . $sneeit_core_l_path, $sneeit_core_l_categories );
		if ( ! file_exists( $sneeit_core_l_exts ) ) {
			continue;
		}
		return get_template_directory_uri() . '/demos/' . str_replace( '.json', '.' . $sneeit_core_l_path, basename( $sneeit_core_l_categories ) );
	}
	return '';
}
