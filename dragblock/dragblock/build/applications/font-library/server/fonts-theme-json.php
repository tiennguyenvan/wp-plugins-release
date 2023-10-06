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
 * Check Documentation#103
 *
 * @param object|array|string $dragblock_ftj_theme_json check var-def#103.
 */
function dragblock_default_theme_json_font_lib( $dragblock_ftj_theme_json ) {
	if ( ! isset( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] ) ) {
		$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] = array();
	}
	// dev-reply#1016.
	$dragblock_ftj_existed_families = array();
	foreach ( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] as $dragblock_ftj_index => $dragblock_ftj_fontfamily ) {
		if ( empty( $dragblock_ftj_fontfamily['slug'] ) ) {
			continue;
		}
		$dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] = $dragblock_ftj_index;
	}
	// dev-reply#1025.
	$dragblock_ftj_uploaded_families = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
	foreach ( $dragblock_ftj_uploaded_families as $dragblock_ftj_fontfamily ) {
		if ( empty( $dragblock_ftj_fontfamily['slug'] ) || empty( $dragblock_ftj_fontfamily['fontFace'] ) ) {
			continue;
		}
		// dev-reply#1032.
		if (
			isset( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ) &&
			! empty( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ]['src'][0] ) &&
			strpos( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ]['src'][0], '/dragblock/' ) === false
		) {
			continue;
		}
		// dev-reply#1042.
		foreach ( $dragblock_ftj_fontfamily['fontFace'] as $dragblock_ftj_key => $dragblock_ftj_value ) {
			if ( empty( $dragblock_ftj_value['fontDisplay'] ) || 'fallback' === $dragblock_ftj_value['fontDisplay'] ) {
				$dragblock_ftj_fontfamily['fontFace'][ $dragblock_ftj_key ]['fontDisplay'] = 'swap';
			}
		}
		$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_ftj_fontfamily );
		// dev-reply#1050.
		if ( isset( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ) ) {
			unset( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ] );
			unset( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] );
		}
	}
	// dev-reply#1057.
	if ( ! empty( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] ) ) {
		// dev-reply#1059.
		foreach ( DRAG_BLOCK_DEFAULT_THEME_JSON['settings']['typography']['fontFamilies'] as $dragblock_ftj_fontfamily ) {
			if ( empty( $dragblock_ftj_fontfamily['slug'] ) ) {
				continue;
			}
			$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][] = ( $dragblock_ftj_fontfamily );
			// dev-reply#1067.
			if ( isset( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ) ) {
				unset( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] ] );
				unset( $dragblock_ftj_existed_families[ $dragblock_ftj_fontfamily['slug'] ] );
			}
		}
	}
	// dev-reply#1074.
	foreach ( $dragblock_ftj_existed_families as $dragblock_ftj_slug => $dragblock_ftj_index ) {
		// dev-reply#1076.
		if (
			! empty( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_index ]['src'][0] ) &&
			strpos( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_index ]['src'][0], '/dragblock/' ) === false
		) {
			continue;
		}
		unset( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'][ $dragblock_ftj_index ] );
	}
	// dev-reply#1088.
	$dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] = array_values( $dragblock_ftj_theme_json['settings']['typography']['fontFamilies']['theme'] );
	return $dragblock_ftj_theme_json;
}
add_filter( 'wp_theme_json_data_user', 'dragblock_theme_json_data_user_font', 100 );
/**
 * Check Documentation#1074
 *
 * @param object|array|string $dragblock_ftj_theme_json_object check var-def#1074.
 */
function dragblock_theme_json_data_user_font( $dragblock_ftj_theme_json_object ) {
	$dragblock_ftj_theme_json = $dragblock_ftj_theme_json_object->get_data();
	$dragblock_ftj_theme_json = dragblock_default_theme_json_font_lib( $dragblock_ftj_theme_json );
	return $dragblock_ftj_theme_json_object->update_with( $dragblock_ftj_theme_json );
}
