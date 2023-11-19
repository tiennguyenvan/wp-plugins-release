<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'http_request_args', 'sneeit_core_patterns_api_http_request_args', 1, 2 );
/**
 * Check Documentation#33
 *
 * @param object|array|string $sneeit_core_pl_parsed check var-def#33.
 * @param object|array|string $sneeit_core_pl_args check var-def#33.
 */
function sneeit_core_patterns_api_http_request_args( $sneeit_core_pl_parsed, $sneeit_core_pl_args ) {
	// dev-reply#39.
	if (
		strpos( $sneeit_core_pl_args, 'sneeit' ) === false ||
		strpos( $sneeit_core_pl_args, '/api/validation/' ) === false ||
		empty( $sneeit_core_pl_parsed['body'] ) ||
		empty( $sneeit_core_pl_parsed['body']['get'] ) ||
		'patterns' !== $sneeit_core_pl_parsed['body']['get']
	) {
		return $sneeit_core_pl_parsed;
	}
	$sneeit_core_pl_url = get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' );
	if ( empty( $sneeit_core_pl_url ) ) {
		return $sneeit_core_pl_parsed;
	}
	$sneeit_core_pl_licence = wp_get_theme();
	$sneeit_core_pl_parsed['body']['user'] = $sneeit_core_pl_url;
	$sneeit_core_pl_parsed['body']['item'] = $sneeit_core_pl_licence->get( 'Name' ) . ' WordPress Theme';
	$sneeit_core_pl_parsed['body']['uri'] = $sneeit_core_pl_licence->get( 'UpdateURI' );
	$sneeit_core_pl_parsed['body']['referer'] = admin_url( 'admin.php' );
	$sneeit_core_pl_parsed['body']['home'] = home_url();
	return $sneeit_core_pl_parsed;
}
