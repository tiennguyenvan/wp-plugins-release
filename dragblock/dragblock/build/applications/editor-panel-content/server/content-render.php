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
 * Check Documentation#63
 *
 * @param object|array|string $dragblock_cr_parsed check var-def#63.
 */
function dragblock_content_parser( $dragblock_cr_parsed ) {
	// dev-reply#610.
	if ( empty( $dragblock_cr_parsed['attrs']['dragBlockText'] ) ) {
		return $dragblock_cr_parsed;
	}
	// dev-reply#614.
	$dragblock_cr_block = '';
	$dragblock_cr_content = '';
	$dragblock_cr_english = get_locale();
	// dev-reply#620.
	foreach ( $dragblock_cr_parsed['attrs']['dragBlockText'] as $dragblock_cr_us ) {
		// dev-reply#622.
		if (
			empty( $dragblock_cr_us['slug'] ) ||
			! isset( $dragblock_cr_us['value'] ) ||
			'' === $dragblock_cr_us['value'] ||
			! empty( $dragblock_cr_us['disabled'] )
		) {
			continue;
		}
		// dev-reply#632.
		if ( ( $dragblock_cr_english ) === $dragblock_cr_us['slug'] ) {
			$dragblock_cr_block = $dragblock_cr_us['value'];
			break;
		}
		// dev-reply#638.
		if ( 'en_US' === $dragblock_cr_us['slug'] ) {
			$dragblock_cr_content = $dragblock_cr_us['value'];
			continue;
		}
	}
	// dev-reply#645.
	if ( '' === $dragblock_cr_block && '' !== $dragblock_cr_content ) {
		$dragblock_cr_block = $dragblock_cr_content;
	}
	// dev-reply#652.
	$dragblock_cr_block = do_shortcode( $dragblock_cr_block );
	if ( ( $dragblock_cr_block ) !== '' ) {
		$dragblock_cr_parsed['attrs']['dragBlockParsedContent'] = $dragblock_cr_block;
	}
	return $dragblock_cr_parsed;
}
add_filter( 'render_block', 'dragblock_content_inserter', 10, 2 );
/**
 * Check Documentation#647
 *
 * @param object|array|string $dragblock_cr_text check var-def#647.
 * @param object|array|string $dragblock_cr_parsed check var-def#647.
 */
function dragblock_content_inserter( $dragblock_cr_text, $dragblock_cr_parsed ) {
	if ( ! isset( $dragblock_cr_parsed['attrs']['dragBlockParsedContent'] ) || $dragblock_cr_parsed['attrs']['dragBlockParsedContent'] === '' ) {
		return $dragblock_cr_text;
	}
	$dragblock_cr_site = strrpos( $dragblock_cr_text, '</' );
	// dev-reply#683.
	if ( false === $dragblock_cr_site ) {
		return $dragblock_cr_text;
	}
	return (
		substr( $dragblock_cr_text, 0, $dragblock_cr_site ) .
		$dragblock_cr_parsed['attrs']['dragBlockParsedContent'] .
		substr( $dragblock_cr_text, $dragblock_cr_site )
	);
}
