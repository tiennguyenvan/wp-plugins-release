<?php
/**
 * DragBlock's Import.
 *
 * @package Load all demos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_load_all_demos', 'sneeit_core_load_all_demos' );
	add_action( 'wp_ajax_sneeit_core_load_all_demos', 'sneeit_core_load_all_demos' );
endif; // dev-reply#510.
/**
 * Check Documentation#56
 */
function sneeit_core_load_all_demos() {
	sneeit_core_ajax_request_verify_die( 'url' );
	$sneeit_core_lad_url = esc_url( $_POST['url'] );
	// dev-reply#518.
	$sneeit_core_lad_post = wp_remote_get( $sneeit_core_lad_url );
	if ( is_wp_error( $sneeit_core_lad_post ) ) {
		sneeit_core_ajax_error_die( 'Error fetching JSON data' );
	}
	$sneeit_core_lad_response = wp_remote_retrieve_body( $sneeit_core_lad_post );
	$sneeit_core_lad_body = json_decode( $sneeit_core_lad_response, true );
	if ( ! $sneeit_core_lad_body ) {
		sneeit_core_ajax_error_die( 'Invalid JSON data' );
	}
	$sneeit_core_lad_data = array();
	foreach ( $sneeit_core_lad_body as $sneeit_core_lad_list => $sneeit_core_lad_demo ) {
		// dev-reply#537.
		$sneeit_core_lad_name = is_numeric( $sneeit_core_lad_list ) ? $sneeit_core_lad_demo : $sneeit_core_lad_list;
		$sneeit_core_lad_categories = is_numeric( $sneeit_core_lad_list ) ? "" : $sneeit_core_lad_demo; // dev-reply#539.
		$sneeit_core_lad_data[ sanitize_key( $sneeit_core_lad_name ) ] = array(
			'info' => array(
				'name' => $sneeit_core_lad_name,
				'categories' => $sneeit_core_lad_categories,
			),
		);
		// dev-reply#546.
	}
	if ( empty( $sneeit_core_lad_data ) ) {
		sneeit_core_ajax_error_die( 'No valid demo data found' );
	}
	echo json_encode( $sneeit_core_lad_data );
	die();
}
/**
 * Check Documentation#539
 *
 * @param object|array|string $sneeit_core_lad_file check var-def#539.
 */
function sneeit_core_demo_default_screenshot( $sneeit_core_lad_file ) {
	$sneeit_core_lad_path = array( 'png', 'jpg', 'jpeg', 'gif' );
	foreach ( $sneeit_core_lad_path as $sneeit_core_lad_exts ) {
		$sneeit_core_lad_ext = str_replace( '.json', '.' . $sneeit_core_lad_exts, $sneeit_core_lad_file );
		if ( ! file_exists( $sneeit_core_lad_ext ) ) {
			continue;
		}
		return get_template_directory_uri() . '/demos/' . str_replace( '.json', '.' . $sneeit_core_lad_exts, basename( $sneeit_core_lad_file ) );
	}
	return '';
}
