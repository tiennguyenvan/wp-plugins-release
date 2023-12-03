<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#52.
remove_theme_support( 'core-block-patterns' );
// dev-reply#55.
add_action( 'rest_api_init', 'dragblock_patterns_rest_api_init', 1 );
// dev-reply#57.
/**
 * Check Documentation#57
 */
function dragblock_patterns_rest_api_init() {
	$dragblock_pl_cache = 60 * 60 * 24; // dev-reply#511.
	$dragblock_pl_t = DRAGBLOCK_K_PATTERN_CACHE . '--time';
	$dragblock_pl_k = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
	$dragblock_pl_time = get_transient( $dragblock_pl_t );
	// dev-reply#515.
	$dragblock_pl_pattern = 'https://sneeit.com/api/validation/';
	// dev-reply#519.
	if ( ! $dragblock_pl_time || DRAGBLOCK_IS_LOCAL ) {
		// dev-reply#522.
		$dragblock_pl_data = wp_remote_request( $dragblock_pl_pattern, array(
			'body' => array(
				'get' => 'patterns',
			),
			'method' => 'POST',
		) );
		if ( ! is_wp_error( $dragblock_pl_data ) ) {
			$dragblock_pl_k = json_decode( wp_remote_retrieve_body( $dragblock_pl_data ), true );
			if ( ! empty( $dragblock_pl_k['error'] ) || empty( $dragblock_pl_k['patterns'] ) ) {
				// dev-reply#534.
				$dragblock_pl_k = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
			} else {
				set_transient( DRAGBLOCK_K_PATTERN_CACHE, $dragblock_pl_k );
				set_transient( $dragblock_pl_t, true, $dragblock_pl_cache );
			}
		}
		// dev-reply#542.
	}
	if ( ! $dragblock_pl_k ) {
		// dev-reply#550.
		return;
	}
	// dev-reply#554.
	if ( ! empty( $dragblock_pl_k['categories'] ) ) {
		foreach ( $dragblock_pl_k['categories'] as $dragblock_pl_api => $dragblock_pl_url ) {
			register_block_pattern_category( $dragblock_pl_api, $dragblock_pl_url );
		}
	}
	// dev-reply#564.
	foreach ( $dragblock_pl_k['patterns'] as $dragblock_pl_response => $dragblock_pl_cat ) {
		if ( empty( $dragblock_pl_cat['name'] ) ) {
			continue;
		}
		register_block_pattern( $dragblock_pl_cat['name'], $dragblock_pl_cat );
	}
}
