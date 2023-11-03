<?php
/**
 * DragBlock's Editor-panel-attributes.
 *
 * @package Attributes uid
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $dragblock_uids;
$dragblock_uids = array();
global $dragblock_preload;
$dragblock_preload = array();
add_filter( 'render_block_data', 'dragblock_uid_parser', 1, 2 );
/**
 * Check Documentation#77
 *
 * @param object|array|string $dragblock_au_dragblock check var-def#77.
 * @param object|array|string $dragblock_au_uids check var-def#77.
 */
function dragblock_uid_parser( $dragblock_au_dragblock, $dragblock_au_uids ) {
	if (
		'core/null' === $dragblock_au_dragblock['blockName'] ||
		empty( $dragblock_au_dragblock['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_au_dragblock['attrs']['dragBlockCSS'] ) && empty( $dragblock_au_dragblock['attrs']['dragBlockJS'] ) )
		// dev-reply#730.
	) {
		return $dragblock_au_dragblock;
	}
	global $dragblock_uids;
	$dragblock_au_preload = dragblock_uid_key( $dragblock_au_dragblock );
	if ( ! empty( $dragblock_uids[ $dragblock_au_preload ] ) ) {
		return $dragblock_au_dragblock;
	}
	$dragblock_au_parsed = 'i' . count( $dragblock_uids );
	$dragblock_uids[ $dragblock_au_preload ] = $dragblock_au_parsed;
	return $dragblock_au_dragblock;
}
add_filter( 'render_block', 'dragblock_uid_inserter', 10, 3 );
/**
 * Check Documentation#726
 *
 * @param object|array|string $dragblock_au_block check var-def#726.
 * @param object|array|string $dragblock_au_dragblock check var-def#726.
 * @param object|array|string $dragblock_au_source check var-def#726.
 */
function dragblock_uid_inserter( $dragblock_au_block, $dragblock_au_dragblock, $dragblock_au_source ) {
	if (
		'core/null' === $dragblock_au_dragblock['blockName'] ||
		empty( $dragblock_au_dragblock['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_au_dragblock['attrs']['dragBlockCSS'] ) && empty( $dragblock_au_dragblock['attrs']['dragBlockJS'] ) )
	) {
		return $dragblock_au_block;
	}
	global $dragblock_uids;
	// dev-reply#782.
	$dragblock_au_preload = dragblock_uid_key( $dragblock_au_dragblock );
	$dragblock_au_uid = 'class="';
	$dragblock_au_key = strpos( $dragblock_au_block, $dragblock_au_uid );
	$dragblock_au_short = strpos( $dragblock_au_block, '>' );
	// dev-reply#790.
	if ( false === $dragblock_au_short ) {
		return $dragblock_au_block;
	}
	// dev-reply#795.
	if ( false === $dragblock_au_key ) {
		return (
			substr( $dragblock_au_block, 0, $dragblock_au_short ) .
			' class="' . ( $dragblock_uids[ $dragblock_au_preload ] ) . '"' .
			substr( $dragblock_au_block, $dragblock_au_short )
		);
	}
	if ( $dragblock_au_key >= $dragblock_au_short ) {
		return $dragblock_au_block;
	}
	return (
		substr( $dragblock_au_block, 0, $dragblock_au_key + strlen( $dragblock_au_uid ) ) .
		( $dragblock_uids[ $dragblock_au_preload ] ) . ' ' .
		substr( $dragblock_au_block, $dragblock_au_key + strlen( $dragblock_au_uid ) )
	);
}
