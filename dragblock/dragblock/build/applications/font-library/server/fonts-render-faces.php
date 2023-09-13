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
 * @param object|array|string $dragblock_0 check var-def#43.
 */
function dragblock_render_font_styles( $dragblock_0 ) {
	$dragblock_1 = '';
	if ( ! is_array( $dragblock_0 ) ) {
		return $dragblock_1;
	}
	foreach ( $dragblock_0 as $dragblock_2 ) {
		if ( isset( $dragblock_2['fontFace'] ) && is_array( $dragblock_2['fontFace'] ) ) {
			foreach ( $dragblock_2['fontFace'] as $dragblock_3 ) {
				if ( ! isset( $dragblock_3['src'][0] ) || ! isset( $dragblock_3['fontFamily'] ) ) {
					continue;
				}
				$dragblock_4 = esc_url_raw( $dragblock_3['src'][0] );
				$dragblock_5 = ! empty( $dragblock_3['fontWeight'] ) ? $dragblock_3['fontWeight'] : 'normal';
				$dragblock_6 = ! empty( $dragblock_3['fontStyle'] ) ? $dragblock_3['fontStyle'] : 'normal';
				$dragblock_1 .= '@font-face {';
				$dragblock_1 .= "font-family: '" . $dragblock_3['fontFamily'] . "';";
				$dragblock_1 .= 'src: url(' . $dragblock_4 . ');';
				$dragblock_1 .= 'font-weight: ' . $dragblock_5 . ';';
				$dragblock_1 .= 'font-style: ' . $dragblock_6 . ';';
				$dragblock_1 .= '}';
			}
		}
	}
	return $dragblock_1;
}
