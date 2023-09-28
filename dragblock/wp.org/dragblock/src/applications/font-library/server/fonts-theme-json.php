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
 * @param object|array|string $dragblock_ftj_theme_json check var-def#53.
 */
function dragblock_default_theme_json_font_lib( $dragblock_ftj_theme_json ) {
	if ( ! isset( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] ) ) {
		$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] = array();
	}
	// dev-reply#516.
	$dragblock_ftj_existed_families = array();
	foreach ( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] as $dragblock_ftj_fontfamily ) {
		if ( empty( $dragblock_ftj_fontfamily['slug'] ) ) {
			continue;
		}
		$dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] = true;
	}
	// dev-reply#525.
	$dragblock_ftj_uploaded_families = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
	foreach ( $dragblock_ftj_uploaded_families as $dragblock_ftj_fontfamily ) {
		if ( empty( $dragblock_ftj_fontfamily['slug'] ) || empty( $dragblock_ftj_fontfamily['fontFace'] ) || ! empty( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ) ) {
			continue;
		}
		$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_ftj_fontfamily );
		$dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] = true;
	}
	if ( empty( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] ) ) {
		return $dragblock_ftj_theme_json;
	}
	// dev-reply#540.
	foreach ( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] as $dragblock_ftj_fontfamily ) {
		if ( empty( $dragblock_ftj_fontfamily['slug'] ) || ! empty( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ) ) {
			continue;
		}
		$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_ftj_fontfamily );
		$dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] = true;
	}
	return $dragblock_ftj_theme_json;
}
