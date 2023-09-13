<?php
/**
 * DragBlock's Editor-panel-interactions.
 *
 * @package Interactions enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_interactions_panel_editor_assets' );
/**
 * Check Documentation#73
 */
function dragblock_interactions_panel_editor_assets() {
	$dragblock_0 = 'interactions';
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.css" );
}
global $dragblock_js;
$dragblock_js = array();
add_filter( 'render_block', 'dragblock_interactions_collect_js', 10, 2 );
/**
 * Check Documentation#712
 *
 * @param object|array|string $dragblock_1 check var-def#712.
 * @param object|array|string $dragblock_2 check var-def#712.
 */
function dragblock_interactions_collect_js( $dragblock_1, $dragblock_2 ) {
	if (
		'core/null' === $dragblock_2['blockName'] ||
		empty( $dragblock_2['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_1;
	}
	$dragblock_3 = $dragblock_2['blockName'] . $dragblock_2['attrs']['dragBlockClientId'];
	$dragblock_4 = '';
	if ( ! empty( $dragblock_2['attrs']['dragBlockJS'] ) ) {
		global $dragblock_uids;
		if ( ! empty( $dragblock_uids[ $dragblock_3 ] ) ) {
			$dragblock_5 = '.' . $dragblock_uids[ $dragblock_3 ];
			$dragblock_4 =
				str_replace(
					'[data-dragblock-client-id="' . $dragblock_2['attrs']['dragBlockClientId'] . '"]',
					$dragblock_5,
					$dragblock_2['attrs']['dragBlockJS']
				);
		}
	}
	// dev-reply#759.
	global $dragblock_js;
	// dev-reply#763.
	if ( ! empty( $dragblock_2['innerBlocks'] ) ) {
		foreach ( $dragblock_2['innerBlocks'] as $dragblock_6 ) {
			if ( empty( $dragblock_6['blockName'] ) || empty( $dragblock_6['attrs']['dragBlockClientId'] ) ) {
				continue;
			}
			$dragblock_7 = $dragblock_6['blockName'] . $dragblock_6['attrs']['dragBlockClientId'];
			if ( ! empty( $dragblock_js[ $dragblock_7 ] ) ) {
				$dragblock_4 .= $dragblock_js[ $dragblock_7 ];
				unset( $dragblock_js[ $dragblock_7 ] );
			}
		}
	}
	if ( $dragblock_4 ) {
		$dragblock_js[ $dragblock_3 ] = $dragblock_4;
	}
	return $dragblock_1;
}
add_action( 'wp_footer', 'dragblock_enqueue_front_end' );
/**
 * Check Documentation#755
 */
function dragblock_enqueue_front_end() {
	global $dragblock_js;
	$dragblock_8 = implode( '', $dragblock_js );
	if ( $dragblock_8 ) {
		$dragblock_9 = array(
			'script' => array(
				'type' => true,
			),
		);
		echo wp_kses( "<script type='text/javascript'>{$dragblock_8}</script>", $dragblock_9 );
	}
}
