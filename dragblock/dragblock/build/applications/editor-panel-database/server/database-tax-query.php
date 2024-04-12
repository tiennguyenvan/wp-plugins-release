<?php
/**
 * DragBlock's Editor-panel-database.
 *
 * @package Database tax query
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#53.
add_action( 'rest_api_init', 'dragblock_custom_taxonomy_rest_api' );
/**
 * Check Documentation#54
 */
function dragblock_custom_taxonomy_rest_api() {
	// dev-reply#57.
	$dragblock_dtq_custom = get_taxonomies( array(
		'public'   => true,
		'_builtin' => false,
	), 'objects' );
	// dev-reply#513.
	foreach ( $dragblock_dtq_custom as $dragblock_dtq_taxonomies ) {
		// dev-reply#515.
		register_rest_route( 'wp/v2', '/' . DRAGBLOCK_START_TAX_QUERY_KEY . $dragblock_dtq_taxonomies->name, array(
			'methods' => 'GET',
			'callback' => 'dragblock_search_taxonomy_terms',
			'permission_callback' => 'dragblock_request_custom_taxonomy_terms_permission',
			'args' => array(
				'search' => array(
					'required' => false,
					'validate_callback' => 'dragblock_validate_search_query_custom_taxonomy'
				),
			),
		) );
	}
}
/**
 * Check Documentation#526
 *
 * @param object|array|string $dragblock_dtq_taxonomy check var-def#526.
 * @param object|array|string $dragblock_dtq_param check var-def#526.
 * @param object|array|string $dragblock_dtq_request check var-def#526.
 */
function dragblock_validate_search_query_custom_taxonomy( $dragblock_dtq_taxonomy, $dragblock_dtq_param, $dragblock_dtq_request ) {
	return is_string( $dragblock_dtq_taxonomy );
}
// dev-reply#534.
/**
 * Check Documentation#530
 *
 * @param object|array|string $dragblock_dtq_key check var-def#530.
 */
function dragblock_search_taxonomy_terms( $dragblock_dtq_key ) {
	// dev-reply#536.
	$dragblock_dtq_data = $dragblock_dtq_key->get_route();
	$dragblock_dtq_slug = explode( '/', $dragblock_dtq_data );
	$dragblock_dtq_parts = end( $dragblock_dtq_slug );
	$dragblock_dtq_parts = str_replace( DRAGBLOCK_START_TAX_QUERY_KEY, '', $dragblock_dtq_parts );
	// dev-reply#542.
	$dragblock_dtq_name = $dragblock_dtq_key->get_param( 'search' );
	// dev-reply#544.
	$dragblock_dtq_search = get_terms( array(
		'taxonomy' => $dragblock_dtq_parts,
		'search' => $dragblock_dtq_name,
		'hide_empty' => false, // dev-reply#550.,
	) );
	$dragblock_dtq_term = array();
	foreach ( $dragblock_dtq_search as $dragblock_dtq_terms ) {
		$dragblock_dtq_term[] = array(
			'id' => $dragblock_dtq_terms->term_id,
			'name' => $dragblock_dtq_terms->name,
			'description' => $dragblock_dtq_terms->description,
			// dev-reply#560.,
		);
	}
	return $dragblock_dtq_term;
}
/**
 * Check Documentation#555
 */
function dragblock_request_custom_taxonomy_terms_permission() {
	if ( current_user_can( 'administrator' ) ) {
		return true;
	}
	return current_user_can( 'editor' );
}
