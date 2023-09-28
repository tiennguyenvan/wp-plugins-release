<?php
/**
 * DragBlock's Editor-panel-content.
 *
 * @package Content render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'render_block_data', 'dragblock_content_parser', 10, 1 );
/**
 * Check Documentation#53
 *
 * @param object|array|string $dragblock_cr_parsed_block check var-def#53.
 */
function dragblock_content_parser( $dragblock_cr_parsed_block ) {
	// dev-reply#510.
	if ( empty( $dragblock_cr_parsed_block['attrs']['dragBlockText'] ) ) {
		return $dragblock_cr_parsed_block;
	}
	// dev-reply#514.
	$dragblock_cr_content = '';
	$dragblock_cr_english_us_text = '';
	// dev-reply#519.
	foreach ( $dragblock_cr_parsed_block['attrs']['dragBlockText'] as $dragblock_cr_text ) {
		// dev-reply#521.
		if (
			empty( $dragblock_cr_text['slug'] ) ||
			! isset( $dragblock_cr_text['value'] ) ||
			'' === $dragblock_cr_text['value'] ||
			! empty( $dragblock_cr_text['disabled'] )
		) {
			continue;
		}
		// dev-reply#531.
		if ( DRAGBLOCK_SITE_LOCALE === $dragblock_cr_text['slug'] ) {
			$dragblock_cr_content = $dragblock_cr_text['value'];
			break;
		}
		// dev-reply#537.
		if ( 'en_US' === $dragblock_cr_text['slug'] ) {
			$dragblock_cr_english_us_text = $dragblock_cr_text['value'];
			continue;
		}
	}
	// dev-reply#544.
	if ( '' === $dragblock_cr_content && '' !== $dragblock_cr_english_us_text ) {
		$dragblock_cr_content = $dragblock_cr_english_us_text;
	}
	// dev-reply#550.
	$dragblock_cr_content = do_shortcode( $dragblock_cr_content );
	if ( $dragblock_cr_content ) {
		$dragblock_cr_parsed_block['attrs']['dragBlockParsedContent'] = $dragblock_cr_content;
	}
	return $dragblock_cr_parsed_block;
}
add_filter( 'render_block', 'dragblock_content_inserter', 10, 2 );
/**
 * Check Documentation#546
 *
 * @param object|array|string $dragblock_cr_block_content check var-def#546.
 * @param object|array|string $dragblock_cr_parsed_block check var-def#546.
 */
function dragblock_content_inserter( $dragblock_cr_block_content, $dragblock_cr_parsed_block ) {
	if ( empty( $dragblock_cr_parsed_block['attrs']['dragBlockParsedContent'] ) ) {
		return $dragblock_cr_block_content;
	}
	$dragblock_cr_tag_close = strrpos( $dragblock_cr_block_content, '</' );
	// dev-reply#572.
	if ( false === $dragblock_cr_tag_close ) {
		return $dragblock_cr_block_content;
	}
	return (
		substr( $dragblock_cr_block_content, 0, $dragblock_cr_tag_close ) .
		$dragblock_cr_parsed_block['attrs']['dragBlockParsedContent'] .
		substr( $dragblock_cr_block_content, $dragblock_cr_tag_close )
	);
}
