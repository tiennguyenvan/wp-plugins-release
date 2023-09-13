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
 * @param object|array|string $dragblock_0 check var-def#53.
 */
function dragblock_content_parser( $dragblock_0 ) {
	// dev-reply#510.
	if ( empty( $dragblock_0['attrs']['dragBlockText'] ) ) {
		return $dragblock_0;
	}
	// dev-reply#514.
	$dragblock_1 = '';
	$dragblock_2 = '';
	// dev-reply#519.
	foreach ( $dragblock_0['attrs']['dragBlockText'] as $dragblock_3 ) {
		// dev-reply#521.
		if (
			empty( $dragblock_3['slug'] ) ||
			! isset( $dragblock_3['value'] ) ||
			'' === $dragblock_3['value'] ||
			! empty( $dragblock_3['disabled'] )
		) {
			continue;
		}
		// dev-reply#531.
		if ( DRAGBLOCK_SITE_LOCALE === $dragblock_3['slug'] ) {
			$dragblock_1 = $dragblock_3['value'];
			break;
		}
		// dev-reply#537.
		if ( 'en_US' === $dragblock_3['slug'] ) {
			$dragblock_2 = $dragblock_3['value'];
			continue;
		}
	}
	// dev-reply#544.
	if ( '' === $dragblock_1 && '' !== $dragblock_2 ) {
		$dragblock_1 = $dragblock_2;
	}
	// dev-reply#550.
	$dragblock_1 = do_shortcode( $dragblock_1 );
	if ( $dragblock_1 ) {
		$dragblock_0['attrs']['dragBlockParsedContent'] = $dragblock_1;
	}
	return $dragblock_0;
}
add_filter( 'render_block', 'dragblock_content_inserter', 10, 2 );
/**
 * Check Documentation#546
 *
 * @param object|array|string $dragblock_4 check var-def#546.
 * @param object|array|string $dragblock_0 check var-def#546.
 */
function dragblock_content_inserter( $dragblock_4, $dragblock_0 ) {
	if ( empty( $dragblock_0['attrs']['dragBlockParsedContent'] ) ) {
		return $dragblock_4;
	}
	$dragblock_5 = strrpos( $dragblock_4, '</' );
	// dev-reply#572.
	if ( false === $dragblock_5 ) {
		return $dragblock_4;
	}
	return (
		substr( $dragblock_4, 0, $dragblock_5 ) .
		$dragblock_0['attrs']['dragBlockParsedContent'] .
		substr( $dragblock_4, $dragblock_5 )
	);
}
