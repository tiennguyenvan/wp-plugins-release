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
add_filter( 'render_block_data', 'dragblock_uid_parser', 1, 2 );
/**
 * Check Documentation#75
 *
 * @param object|array|string $dragblock_0 check var-def#75.
 * @param object|array|string $dragblock_1 check var-def#75.
 */
function dragblock_uid_parser( $dragblock_0, $dragblock_1 ) {
	if (
		'core/null' === $dragblock_0['blockName'] ||
		empty( $dragblock_0['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_0['attrs']['dragBlockCSS'] ) && empty( $dragblock_0['attrs']['dragBlockJS'] ) )
		// dev-reply#729.
	) {
		return $dragblock_0;
	}
	global $dragblock_uids;
	$dragblock_2 = $dragblock_0['blockName'] . $dragblock_0['attrs']['dragBlockClientId'];
	if ( ! empty( $dragblock_uids[ $dragblock_2 ] ) ) {
		return $dragblock_0;
	}
	$dragblock_3 = 'i' . count( $dragblock_uids );
	$dragblock_uids[ $dragblock_2 ] = $dragblock_3;
	return $dragblock_0;
}
add_filter( 'render_block', 'dragblock_uid_inserter', 10, 3 );
/**
 * Check Documentation#724
 *
 * @param object|array|string $dragblock_4 check var-def#724.
 * @param object|array|string $dragblock_0 check var-def#724.
 * @param object|array|string $dragblock_5 check var-def#724.
 */
function dragblock_uid_inserter( $dragblock_4, $dragblock_0, $dragblock_5 ) {
	if (
		'core/null' === $dragblock_0['blockName'] ||
		empty( $dragblock_0['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_0['attrs']['dragBlockCSS'] ) && empty( $dragblock_0['attrs']['dragBlockJS'] ) )
	) {
		return $dragblock_4;
	}
	global $dragblock_uids;
	$dragblock_2 = $dragblock_0['blockName'] . $dragblock_0['attrs']['dragBlockClientId'];
	// dev-reply#780.
	$dragblock_6 = 'class="';
	$dragblock_7 = strpos( $dragblock_4, $dragblock_6 );
	$dragblock_8 = strpos( $dragblock_4, '>' );
	// dev-reply#785.
	if ( false === $dragblock_8 ) {
		return $dragblock_4;
	}
	// dev-reply#790.
	if ( false === $dragblock_7 ) {
		return (
			substr( $dragblock_4, 0, $dragblock_8 ) .
			'class="' . ( $dragblock_uids[ $dragblock_2 ] ) . '"' .
			substr( $dragblock_4, $dragblock_8 )
		);
	}
	if ( $dragblock_7 >= $dragblock_8 ) {
		return $dragblock_4;
	}
	return (
		substr( $dragblock_4, 0, $dragblock_7 + strlen( $dragblock_6 ) ) .
		( $dragblock_uids[ $dragblock_2 ] ) . ' ' .
		substr( $dragblock_4, $dragblock_7 + strlen( $dragblock_6 ) )
	);
}
