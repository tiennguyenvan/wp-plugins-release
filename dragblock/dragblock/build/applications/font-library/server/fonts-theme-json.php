<?php
/**
 * DragBlock's Font-library.
 *
 * @package Fonts theme json
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'dragblock_default_theme_json', 'dragblock_default_theme_json_font_lib' );
/**
 * Check Documentation#53
 *
 * @param object|array|string $dragblock_0 check var-def#53.
 */
function dragblock_default_theme_json_font_lib( $dragblock_0 ) {
	if ( ! isset( $dragblock_0['settings']['typography']['fontFamilies']['theme'] ) ) {
		$dragblock_0['settings']['typography']['fontFamilies']['theme'] = array();
	}
	// dev-reply#516.
	$dragblock_1 = array();
	foreach ( $dragblock_0['settings']['typography']['fontFamilies']['theme'] as $dragblock_2 ) {
		if ( empty( $dragblock_2['slug'] ) ) {
			continue;
		}
		$dragblock_1[ $dragblock_2['slug'] ] = true;
	}
	// dev-reply#525.
	$dragblock_3 = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
	foreach ( $dragblock_3 as $dragblock_2 ) {
		if ( empty( $dragblock_2['slug'] ) || empty( $dragblock_2['fontFace'] ) || ! empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
			continue;
		}
		$dragblock_0['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_2 );
		$dragblock_1[ $dragblock_2['slug'] ] = true;
	}
	if ( empty( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] ) ) {
		return $dragblock_0;
	}
	// dev-reply#540.
	foreach ( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] as $dragblock_2 ) {
		if ( empty( $dragblock_2['slug'] ) || ! empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
			continue;
		}
		$dragblock_0['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_2 );
		$dragblock_1[ $dragblock_2['slug'] ] = true;
	}
	return $dragblock_0;
}
