<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#93.
add_action( 'rest_api_init', 'dragblock_patterns_rest_api_init', 1 );
// dev-reply#935.
/**
 * Check Documentation#95
 */
function dragblock_patterns_rest_api_init() {
	// dev-reply#938.
	$dragblock_pl_debug = false;
	$dragblock_pl_pattern = 60 * 60 * 24; // dev-reply#942.
	$dragblock_pl_duration = DRAGBLOCK_K_PATTERN_CACHE . '--time';
	// dev-reply#945.
	if ( $dragblock_pl_debug ) {
		delete_transient( DRAGBLOCK_K_PATTERN_CACHE );
		delete_transient( $dragblock_pl_duration );
		// dev-reply#950.
	}
	$dragblock_pl_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
	$dragblock_pl_key = get_transient( $dragblock_pl_duration );
	$dragblock_pl_data = 'https://sneeit.com/api/validation/';
	// dev-reply#960.
	if ( ! $dragblock_pl_key || DRAGBLOCK_IS_LOCAL ) {
		// dev-reply#965.
		$dragblock_pl_time = wp_remote_request( $dragblock_pl_data, array(
			'body' => array(
				'get' => 'patterns',
			),
			'method' => 'POST',
		) );
		if ( ! is_wp_error( $dragblock_pl_time ) ) {
			$dragblock_pl_timer = json_decode( wp_remote_retrieve_body( $dragblock_pl_time ), true );
			if ( $dragblock_pl_debug ) {
				// dev-reply#976.
			}
			if ( ! empty( $dragblock_pl_timer['error'] ) || empty( $dragblock_pl_timer['patterns'] ) ) {
				// dev-reply#980.
				$dragblock_pl_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
			} else {
				// dev-reply#983.
				set_transient( DRAGBLOCK_K_PATTERN_CACHE, $dragblock_pl_timer );
				set_transient( $dragblock_pl_duration, true, $dragblock_pl_pattern );
			}
		} else {
			if ( $dragblock_pl_debug ) {
				// dev-reply#990.
			}
		}
	}
	if ( $dragblock_pl_debug ) {
		// dev-reply#997.
	}
	if ( ! $dragblock_pl_timer ) {
		// dev-reply#9103.
		return;
	}
	// dev-reply#9109.
	if ( ! empty( $dragblock_pl_timer['categories'] ) ) {
		foreach ( $dragblock_pl_timer['categories'] as $dragblock_pl_api => $dragblock_pl_url ) {
			$dragblock_pl_api = trim( explode( '-', $dragblock_pl_api )[0] );
			if ( $dragblock_pl_debug ) {
				// dev-reply#9115.
				var_dump( $dragblock_pl_api );
			}
			register_block_pattern_category( $dragblock_pl_api, $dragblock_pl_url );
		}
		if ( $dragblock_pl_debug ) {
			// dev-reply#9127.
		}
	}
	foreach ( $dragblock_pl_timer['patterns'] as $dragblock_pl_response => $dragblock_pl_cat ) {
		if ( empty( $dragblock_pl_cat['name'] ) || empty( $dragblock_pl_cat['categories'] ) ) {
			continue;
		}
		for ( $dragblock_pl_slug = 0; $dragblock_pl_slug < count( $dragblock_pl_cat['categories'] ); $dragblock_pl_slug++ ) {
			$dragblock_pl_cat['categories'][ $dragblock_pl_slug ] = trim( explode( '-', $dragblock_pl_cat['categories'][ $dragblock_pl_slug ] )[0] );
		}
		if ( $dragblock_pl_debug ) {
			var_dump( $dragblock_pl_cat );
		}
		if ( strpos( $dragblock_pl_cat['name'], 'dragblock/' ) === false ) {
			$dragblock_pl_cat['name'] = 'dragblock/' . $dragblock_pl_cat['name'];
		}
		register_block_pattern( $dragblock_pl_cat['name'], $dragblock_pl_cat );
	}
	if ( $dragblock_pl_debug ) {
		die();
	}
}
