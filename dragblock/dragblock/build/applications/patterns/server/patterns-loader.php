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
	$dragblock_pl_pattern = 60 * 60 * 24; // dev-reply#511.
	$dragblock_pl_duration = DRAGBLOCK_K_PATTERN_CACHE . '--time';
	delete_transient( $dragblock_pl_duration );
	$dragblock_pl_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
	$dragblock_pl_key = get_transient( $dragblock_pl_duration );
	// dev-reply#516.
	$dragblock_pl_data = 'https://sneeit.com/api/validation/';
	// dev-reply#519.
	if ( ! $dragblock_pl_key || DRAGBLOCK_IS_LOCAL ) {
		// dev-reply#524.
		$dragblock_pl_time = wp_remote_request( $dragblock_pl_data, array(
			'body' => array(
				'get' => 'patterns',
			),
			'method' => 'POST',
		) );
		if ( ! is_wp_error( $dragblock_pl_time ) ) {
			$dragblock_pl_timer = json_decode( wp_remote_retrieve_body( $dragblock_pl_time ), true );
			// dev-reply#535.
			if ( ! empty( $dragblock_pl_timer['error'] ) || empty( $dragblock_pl_timer['patterns'] ) ) {
				// dev-reply#538.
				$dragblock_pl_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
			} else {
				// dev-reply#541.
				set_transient( DRAGBLOCK_K_PATTERN_CACHE, $dragblock_pl_timer );
				set_transient( $dragblock_pl_duration, true, $dragblock_pl_pattern );
			}
		} else {
			// dev-reply#547.
		}
	}
	if ( ! $dragblock_pl_timer ) {
		// dev-reply#555.
		return;
	}
	if ( ! empty( $dragblock_pl_timer['categories'] ) ) {
		foreach ( $dragblock_pl_timer['categories'] as $dragblock_pl_api => $dragblock_pl_url ) {
			register_block_pattern_category( $dragblock_pl_api, $dragblock_pl_url );
		}
	}
	// dev-reply#568.
	foreach ( $dragblock_pl_timer['patterns'] as $dragblock_pl_response => $dragblock_pl_cat ) {
		if ( empty( $dragblock_pl_cat['name'] ) ) {
			continue;
		}
		register_block_pattern( $dragblock_pl_cat['name'], $dragblock_pl_cat );
	}
}
