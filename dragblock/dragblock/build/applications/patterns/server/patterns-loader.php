<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#42.
remove_theme_support( 'core-block-patterns' );
// dev-reply#45.
add_action( 'rest_api_init', 'dragblock_patterns_rest_api_init', 1 );
// dev-reply#47.
/**
 * Check Documentation#47
 */
function dragblock_patterns_rest_api_init() {
	$dragblock_pl_cache = 60 * 60 * 24; // dev-reply#410.
	$dragblock_pl_t = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
	$dragblock_pl_pattern = 'https://sneeit.com/api/validation/';
	// dev-reply#415.
	if ( ! $dragblock_pl_t || DRAGBLOCK_IS_LOCAL ) {
		// dev-reply#418.
		$dragblock_pl_data = wp_remote_request( $dragblock_pl_pattern, array(
			'body' => array(
				'get' => 'patterns',
			),
			'method' => 'POST',
		) );
		// dev-reply#426.
		if ( is_wp_error( $dragblock_pl_data ) ) {
			add_theme_support( 'core-block-patterns' );
			return;
		}
		$dragblock_pl_t = json_decode( wp_remote_retrieve_body( $dragblock_pl_data ), true );
		if ( ! empty( $dragblock_pl_t['error'] ) || empty( $dragblock_pl_t['patterns'] ) ) {
			return;
		}
		set_transient( DRAGBLOCK_K_PATTERN_CACHE, $dragblock_pl_t, $dragblock_pl_cache );
	}
	// dev-reply#451.
	if ( ! empty( $dragblock_pl_t['categories'] ) ) {
		foreach ( $dragblock_pl_t['categories'] as $dragblock_pl_api => $dragblock_pl_url ) {
			register_block_pattern_category( $dragblock_pl_api, $dragblock_pl_url );
		}
	}
	// dev-reply#464.
	foreach ( $dragblock_pl_t['patterns'] as $dragblock_pl_response => $dragblock_pl_cat ) {
		if ( empty( $dragblock_pl_cat['name'] ) ) {
			continue;
		}
		register_block_pattern( $dragblock_pl_cat['name'], $dragblock_pl_cat );
	}
}
