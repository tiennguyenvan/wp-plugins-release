<?php
/**
 * DragBlock's Theme-settings.
 *
 * @package Default theme json
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $dragblock_update_theme_json;
$dragblock_update_theme_json = null;
// dev-reply#421.
add_filter( 'wp_theme_json_data_theme', 'dragblock_default_theme_json', 1, 1 );
/**
 * Check Documentation#46
 *
 * @param object|array|string $dragblock_dtj_dragblock check var-def#46.
 */
function dragblock_default_theme_json( $dragblock_dtj_dragblock ) {
	global $dragblock_update_theme_json;
	if ( ! empty( $dragblock_update_theme_json ) ) {
		return $dragblock_dtj_dragblock->update_with( $dragblock_update_theme_json );
	}
	$dragblock_update_theme_json = $dragblock_dtj_dragblock->get_data();
	// dev-reply#439.
	$dragblock_update_theme_json = dragblock_theme_json_merge( $dragblock_update_theme_json, DRAG_BLOCK_DEFAULT_THEME_JSON );
	if ( DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		if ( empty( $dragblock_update_theme_json['styles']['css'] ) ) {
			$dragblock_update_theme_json['styles']['css'] = '';
		}
		$dragblock_update_theme_json['styles']['css'] .= '/* START: CSS OF DRAGBLOCK */' . file_get_contents( dragblock_url( 'build/applications/front/style-index.css' ) ) . '/* END: CSS OF DRAGBLOCK */';
	}
	$dragblock_update_theme_json = apply_filters( 'dragblock_default_theme_json', $dragblock_update_theme_json );
	return $dragblock_dtj_dragblock->update_with( $dragblock_update_theme_json );
}
