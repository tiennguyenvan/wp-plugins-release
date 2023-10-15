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
	$sneeit_core_l_post = wp_remote_get( $sneeit_core_l_url );
	if ( is_wp_error( $sneeit_core_l_post ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_l_response = wp_remote_retrieve_body( $sneeit_core_l_post );
	$sneeit_core_l_body = json_decode( $sneeit_core_l_response, true );
	if ( ! $sneeit_core_l_body ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	$sneeit_core_l_data = array();
	foreach ( $sneeit_core_l_body as $sneeit_core_l_list => $sneeit_core_l_demo ) {
		// dev-reply#535.
		$sneeit_core_l_name = is_numeric( $sneeit_core_l_list ) ? $sneeit_core_l_demo : $sneeit_core_l_list;
		$sneeit_core_l_categories = is_numeric( $sneeit_core_l_list ) ? "" : $sneeit_core_l_demo; // dev-reply#537.
		$sneeit_core_l_data[ sanitize_key( $sneeit_core_l_name ) ] = array(
			'info' => array(
				'name' => $sneeit_core_l_name,
				'categories' => $sneeit_core_l_categories,
			),
		);
		// dev-reply#544.
	}
	if ( empty( $sneeit_core_l_data ) ) {
		sneeit_core_ajax_error_die( 'No valid demo data found' );
	}
	echo json_encode( $sneeit_core_l_data );
	die();
}
/**
 * Check Documentation#539
 *
 * @param object|array|string $sneeit_core_l_file check var-def#539.
 */
function sneeit_core_demo_default_screenshot( $sneeit_core_l_file ) {
	$sneeit_core_l_path = array( 'png', 'jpg', 'jpeg', 'gif' );
	foreach ( $sneeit_core_l_path as $sneeit_core_l_exts ) {
		$sneeit_core_l_ext = str_replace( '.json', '.' . $sneeit_core_l_exts, $sneeit_core_l_file );
		if ( ! file_exists( $sneeit_core_l_ext ) ) {
			continue;
		}
		return get_template_directory_uri() . '/demos/' . str_replace( '.json', '.' . $sneeit_core_l_exts, basename( $sneeit_core_l_file ) );
	}
	return '';
}
