<?php
/**
 * DragBlock's Patterns.
 *
 * @package _deprecated_patterns loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#94.
add_action( 'rest_api_init', 'dragblock_patterns_rest_api_init', 1 );
// dev-reply#936.
/**
 * Check Documentation#95
 */
function dragblock_patterns_rest_api_init() {
	// dev-reply#939.
	$dragblock__l_debug = false;
	$dragblock__l_pattern = 60 * 60 * 24; // dev-reply#943.
	$dragblock__l_duration = DRAGBLOCK_K_PATTERN_CACHE . '--time';
	// dev-reply#946.
	if ( $dragblock__l_debug ) {
		delete_transient( DRAGBLOCK_K_PATTERN_CACHE );
		delete_transient( $dragblock__l_duration );
		// dev-reply#951.
	}
	$dragblock__l_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
	$dragblock__l_key = get_transient( $dragblock__l_duration );
	$dragblock__l_data = 'https://sneeit.com/api/validation/';
	// dev-reply#960.
	if ( ! $dragblock__l_key || DRAGBLOCK_IS_LOCAL ) {
		// dev-reply#965.
		$dragblock__l_time = wp_remote_request( $dragblock__l_data, array(
			'body' => array(
				'get' => 'patterns',
			),
			'method' => 'POST',
		) );
		if ( ! is_wp_error( $dragblock__l_time ) ) {
			$dragblock__l_timer = json_decode( wp_remote_retrieve_body( $dragblock__l_time ), true );
			if ( $dragblock__l_debug ) {
				// dev-reply#976.
			}
			if ( ! empty( $dragblock__l_timer['error'] ) || empty( $dragblock__l_timer['patterns'] ) ) {
				// dev-reply#980.
				$dragblock__l_timer = get_transient( DRAGBLOCK_K_PATTERN_CACHE );
			} else {
				// dev-reply#983.
				set_transient( DRAGBLOCK_K_PATTERN_CACHE, $dragblock__l_timer );
				set_transient( $dragblock__l_duration, true, $dragblock__l_pattern );
			}
		} else {
			if ( $dragblock__l_debug ) {
				// dev-reply#990.
			}
		}
	}
	if ( $dragblock__l_debug ) {
		// dev-reply#997.
	}
	if ( ! $dragblock__l_timer ) {
		// dev-reply#9103.
		return;
	}
	// dev-reply#9108.
	if ( ! empty( $dragblock__l_timer['categories'] ) ) {
		foreach ( $dragblock__l_timer['categories'] as $dragblock__l_api => $dragblock__l_url ) {
			$dragblock__l_api = trim( explode( '-', $dragblock__l_api )[0] );
			if ( $dragblock__l_debug ) {
				// dev-reply#9114.
				var_dump( $dragblock__l_api );
			}
			register_block_pattern_category( $dragblock__l_api, $dragblock__l_url );
		}
		if ( $dragblock__l_debug ) {
			// dev-reply#9126.
		}
	}
	foreach ( $dragblock__l_timer['patterns'] as $dragblock__l_response => $dragblock__l_cat ) {
		if ( empty( $dragblock__l_cat['name'] ) || empty( $dragblock__l_cat['categories'] ) ) {
			continue;
		}
		for ( $dragblock__l_slug = 0; $dragblock__l_slug < count( $dragblock__l_cat['categories'] ); $dragblock__l_slug++ ) {
			$dragblock__l_cat['categories'][ $dragblock__l_slug ] = trim( explode( '-', $dragblock__l_cat['categories'][ $dragblock__l_slug ] )[0] );
		}
		if ( $dragblock__l_debug ) {
			var_dump( $dragblock__l_cat );
		}
		if ( strpos( $dragblock__l_cat['name'], 'dragblock/' ) === false ) {
			$dragblock__l_cat['name'] = 'dragblock/' . $dragblock__l_cat['name'];
		}
		register_block_pattern( $dragblock__l_cat['name'], $dragblock__l_cat );
	}
	if ( $dragblock__l_debug ) {
		die();
	}
}
