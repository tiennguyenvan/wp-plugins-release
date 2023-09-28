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
 * @param object|array|string $dragblock_au_parsed_block check var-def#75.
 * @param object|array|string $dragblock_au_source_block check var-def#75.
 */
function dragblock_uid_parser( $dragblock_au_parsed_block, $dragblock_au_source_block ) {
	if (
		'core/null' === $dragblock_au_parsed_block['blockName'] ||
		empty( $dragblock_au_parsed_block['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_au_parsed_block['attrs']['dragBlockCSS'] ) && empty( $dragblock_au_parsed_block['attrs']['dragBlockJS'] ) )
		// dev-reply#729.
	) {
		return $dragblock_au_parsed_block;
	}
	global $dragblock_uids;
	$dragblock_au_uid_key = $dragblock_au_parsed_block['blockName'] . $dragblock_au_parsed_block['attrs']['dragBlockClientId'];
	if ( ! empty( $dragblock_uids[ $dragblock_au_uid_key ] ) ) {
		return $dragblock_au_parsed_block;
	}
	$dragblock_au_short_class = 'i' . count( $dragblock_uids );
	$dragblock_uids[ $dragblock_au_uid_key ] = $dragblock_au_short_class;
	return $dragblock_au_parsed_block;
}
add_filter( 'render_block', 'dragblock_uid_inserter', 10, 3 );
/**
 * Check Documentation#724
 *
 * @param object|array|string $dragblock_au_block_content check var-def#724.
 * @param object|array|string $dragblock_au_parsed_block check var-def#724.
 * @param object|array|string $dragblock_au_block check var-def#724.
 */
function dragblock_uid_inserter( $dragblock_au_block_content, $dragblock_au_parsed_block, $dragblock_au_block ) {
	if (
		'core/null' === $dragblock_au_parsed_block['blockName'] ||
		empty( $dragblock_au_parsed_block['attrs']['dragBlockClientId'] ) ||
		( empty( $dragblock_au_parsed_block['attrs']['dragBlockCSS'] ) && empty( $dragblock_au_parsed_block['attrs']['dragBlockJS'] ) )
	) {
		return $dragblock_au_block_content;
	}
	global $dragblock_uids;
	$dragblock_au_uid_key = $dragblock_au_parsed_block['blockName'] . $dragblock_au_parsed_block['attrs']['dragBlockClientId'];
	// dev-reply#780.
	$dragblock_au_class_key = 'class="';
	$dragblock_au_class_start = strpos( $dragblock_au_block_content, $dragblock_au_class_key );
	$dragblock_au_class_end = strpos( $dragblock_au_block_content, '>' );
	// dev-reply#785.
	if ( false === $dragblock_au_class_end ) {
		return $dragblock_au_block_content;
	}
	// dev-reply#790.
	if ( false === $dragblock_au_class_start ) {
		return (
			substr( $dragblock_au_block_content, 0, $dragblock_au_class_end ) .
			'class="' . ( $dragblock_uids[ $dragblock_au_uid_key ] ) . '"' .
			substr( $dragblock_au_block_content, $dragblock_au_class_end )
		);
	}
	if ( $dragblock_au_class_start >= $dragblock_au_class_end ) {
		return $dragblock_au_block_content;
	}
	return (
		substr( $dragblock_au_block_content, 0, $dragblock_au_class_start + strlen( $dragblock_au_class_key ) ) .
		( $dragblock_uids[ $dragblock_au_uid_key ] ) . ' ' .
		substr( $dragblock_au_block_content, $dragblock_au_class_start + strlen( $dragblock_au_class_key ) )
	);
}
