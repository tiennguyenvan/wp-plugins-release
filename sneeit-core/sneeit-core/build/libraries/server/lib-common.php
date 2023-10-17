<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib common
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#62
 *
 * @param object|array|string $sneeit_core_lc_url check var-def#62.
 */
function sneeit_core_url_exists( $sneeit_core_lc_url ) {
	$sneeit_core_lc_headers = @get_headers( $sneeit_core_lc_url );
	if ( $sneeit_core_lc_headers && strpos( $sneeit_core_lc_headers[0], '200' ) !== false ) {
		return true; // dev-reply#65.
	} else {
		return false; // dev-reply#67.
	}
}
/**
 * Check Documentation#610
 *
 * @param object|array|string $sneeit_core_lc_text check var-def#610.
 */
function sneeit_core_text_to_slug( $sneeit_core_lc_text ) {
	$sneeit_core_lc_text = str_replace( array( ' ', '/' ), '-', $sneeit_core_lc_text );
	$sneeit_core_lc_text = strtolower( $sneeit_core_lc_text );
	return $sneeit_core_lc_text;
}
/**
 * Check Documentation#616
 *
 * @param object|array|string $sneeit_core_lc_src check var-def#616.
 */
function sneeit_core_is_image_src( $sneeit_core_lc_src ) {
	$sneeit_core_lc_src = strtolower( $sneeit_core_lc_src );
	return preg_match( "/\.(jpeg|jpg|gif|png)$/", $sneeit_core_lc_src );
}
/**
 * Check Documentation#620
 *
 * @param object|array|string $sneeit_core_lc_text check var-def#620.
 */
function sneeit_core_extract_urls( $sneeit_core_lc_text ) {
	$sneeit_core_lc_urlregex = '/\b(?:https?:\/\/|www\.)[^,\s]+/i';
	preg_match_all( $sneeit_core_lc_urlregex, $sneeit_core_lc_text, $sneeit_core_lc_matches );
	return $sneeit_core_lc_matches[0];
}
/**
 * Check Documentation#625
 *
 * @param object|array|string $sneeit_core_lc_slug check var-def#625.
 */
function sneeit_core_plugin_install_file( $sneeit_core_lc_slug ) {
	// dev-reply#632.
	$sneeit_core_lc_plugin = WP_PLUGIN_DIR . '/' . $sneeit_core_lc_slug . '/';
	if ( file_exists( $sneeit_core_lc_plugin . $sneeit_core_lc_slug . '.php' ) ) {
		$sneeit_core_lc_path = file_get_contents( $sneeit_core_lc_plugin . $sneeit_core_lc_slug . '.php' );
		if ( $sneeit_core_lc_path && strpos( $sneeit_core_lc_path, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_lc_plugin . $sneeit_core_lc_slug . '.php';
		}
	}
	// dev-reply#641.
	$sneeit_core_lc_file = glob( WP_PLUGIN_DIR . '/' . $sneeit_core_lc_slug . '/*.php' );
	foreach ( $sneeit_core_lc_file as $sneeit_core_lc_content ) {
		$sneeit_core_lc_path = file_get_contents( $sneeit_core_lc_content );
		if ( $sneeit_core_lc_path && strpos( $sneeit_core_lc_path, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_lc_content;
		}
	}
	return '';
}
/**
 * Check Documentation#645
 */
function sneeit_core_is_license_required() {
	$sneeit_core_lc_paths = wp_get_theme();
	$sneeit_core_lc_theme = $sneeit_core_lc_paths->get( 'UpdateURI' );
	// dev-reply#658.
	return ( ! empty( $sneeit_core_lc_theme ) &&
		strpos( $sneeit_core_lc_theme, '://sneeit.com' ) &&
		empty( implode(
			'',
			explode(
				'/',
				explode( '://sneeit.com', $sneeit_core_lc_theme )[1]
			)
		) )
	);
}
