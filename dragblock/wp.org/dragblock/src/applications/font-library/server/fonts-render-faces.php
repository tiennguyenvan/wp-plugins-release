<?php
/**
 * DragBlock's Font-library.
 *
 * @package Fonts render faces
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#43.
/**
 * Check Documentation#43
 *
 * @param object|array|string $dragblock_frf_font_families check var-def#43.
 */
function dragblock_render_font_styles( $dragblock_frf_font_families ) {
	$dragblock_frf_styles = '';
	if ( ! is_array( $dragblock_frf_font_families ) ) {
		return $dragblock_frf_styles;
	}
	foreach ( $dragblock_frf_font_families as $dragblock_frf_font_family ) {
		if ( isset( $dragblock_frf_font_family['fontFace'] ) && is_array( $dragblock_frf_font_family['fontFace'] ) ) {
			foreach ( $dragblock_frf_font_family['fontFace'] as $dragblock_frf_font_face ) {
				if ( ! isset( $dragblock_frf_font_face['src'][0] ) || ! isset( $dragblock_frf_font_face['fontFamily'] ) ) {
					continue;
				}
				$dragblock_frf_font_face_url = esc_url_raw( $dragblock_frf_font_face['src'][0] );
				$dragblock_frf_font_face_weight = ! empty( $dragblock_frf_font_face['fontWeight'] ) ? $dragblock_frf_font_face['fontWeight'] : 'normal';
				$dragblock_frf_font_face_style = ! empty( $dragblock_frf_font_face['fontStyle'] ) ? $dragblock_frf_font_face['fontStyle'] : 'normal';
				$dragblock_frf_styles .= '@font-face {';
				$dragblock_frf_styles .= "font-family: '" . $dragblock_frf_font_face['fontFamily'] . "';";
				$dragblock_frf_styles .= 'src: url(' . $dragblock_frf_font_face_url . ');';
				$dragblock_frf_styles .= 'font-weight: ' . $dragblock_frf_font_face_weight . ';';
				$dragblock_frf_styles .= 'font-style: ' . $dragblock_frf_font_face_style . ';';
				$dragblock_frf_styles .= '}';
			}
		}
	}
	return $dragblock_frf_styles;
}
