<?php
/**
 * DragBlock's Editor-panel-appearance.
 *
 * @package Appearance enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_appearance_panel_editor_assets' );
/**
 * Check Documentation#173
 */
function dragblock_appearance_panel_editor_assets() {
	$dragblock_ae_panel = 'appearance';
	dragblock_enqueue( "dragblock-{$dragblock_ae_panel}-panel", "build/applications/editor-panel-{$dragblock_ae_panel}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "dragblock-{$dragblock_ae_panel}-panel", "build/applications/editor-panel-{$dragblock_ae_panel}/client/index.css" );
}
global $dragblock_css;
$dragblock_css = array();
global $dragblock_theme_json;
global $dragblock_default_json;
global $dragblock_user_json;
add_filter( 'render_block', 'dragblock_appearance_collect_css', 10, 2 );
/**
 * Check Documentation#1715
 *
 * @param object|array|string $dragblock_ae_dragblock check var-def#1715.
 * @param object|array|string $dragblock_ae_css check var-def#1715.
 */
function dragblock_appearance_collect_css( $dragblock_ae_dragblock, $dragblock_ae_css ) {
	// dev-reply#1756.
	if (
		'core/null' === $dragblock_ae_css['blockName'] ||
		empty( $dragblock_ae_css['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_ae_dragblock;
	}
	$dragblock_ae_theme = dragblock_uid_key( $dragblock_ae_css );
	global $dragblock_css;
	// dev-reply#1795.
	if ( ! empty( $dragblock_css[ $dragblock_ae_theme ] ) ) {
		return $dragblock_ae_dragblock;
	}
	$dragblock_ae_json = '';
	global $dragblock_uids;
	if ( ! empty( $dragblock_ae_css['attrs']['dragBlockCSS'] ) ) {
		if ( ! empty( $dragblock_uids[ $dragblock_ae_theme ] ) ) {
			$dragblock_ae_default = '.' . $dragblock_uids[ $dragblock_ae_theme ];
			$dragblock_ae_json =
				str_replace(
					'[data-dragblock-client-id="' . $dragblock_ae_css['attrs']['dragBlockClientId'] . '"]',
					$dragblock_ae_default,
					$dragblock_ae_css['attrs']['dragBlockCSS']
				);
		}
	}
	if ( ! empty( $dragblock_ae_css['innerBlocks'] ) ) {
		foreach ( $dragblock_ae_css['innerBlocks'] as $dragblock_ae_user ) {
			if ( empty( $dragblock_ae_user['blockName'] ) || empty( $dragblock_ae_user['attrs']['dragBlockClientId'] ) ) {
				continue;
			}
			// dev-reply#17126.
			$dragblock_ae_block = dragblock_uid_key( $dragblock_ae_user );
			if ( ! empty( $dragblock_css[ $dragblock_ae_block ] ) ) {
				$dragblock_ae_json .= $dragblock_css[ $dragblock_ae_block ];
				unset( $dragblock_css[ $dragblock_ae_block ] );
				// dev-reply#17132.
			}
		}
	}
	if ( $dragblock_ae_json ) {
		$dragblock_css[ $dragblock_ae_theme ] = $dragblock_ae_json;
	}
// dev-reply#17145.
	return $dragblock_ae_dragblock;
}
/**
 * Check Documentation#1763
 *
 * @param object|array|string $dragblock_ae_css check var-def#1763.
 */
function dragblock_uid_key( $dragblock_ae_css ) {
	$dragblock_ae_theme = $dragblock_ae_css['blockName'] . '__' . $dragblock_ae_css['attrs']['dragBlockClientId'];
	if ( ! empty( $dragblock_ae_css['attrs']['className'] ) ) {
		$dragblock_ae_theme .= '__.' . $dragblock_ae_css['attrs']['className'];
	}
	return $dragblock_ae_theme;
}
add_filter( 'wp_theme_json_data_theme', 'dragblock_appearance_collect_json_data_theme', 10, 1 );
/**
 * Check Documentation#1771
 *
 * @param object|array|string $dragblock_ae_content check var-def#1771.
 */
function dragblock_appearance_collect_json_data_theme( $dragblock_ae_content ) {
	global $dragblock_theme_json;
	$dragblock_theme_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_filter( 'wp_theme_json_data_default', 'dragblock_appearance_collect_json_data_default', 10, 1 );
/**
 * Check Documentation#1778
 *
 * @param object|array|string $dragblock_ae_content check var-def#1778.
 */
function dragblock_appearance_collect_json_data_default( $dragblock_ae_content ) {
	global $dragblock_default_json;
	$dragblock_default_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_filter( 'wp_theme_json_data_user', 'dragblock_appearance_collect_json_data_user', 10, 1 );
/**
 * Check Documentation#1785
 *
 * @param object|array|string $dragblock_ae_content check var-def#1785.
 */
function dragblock_appearance_collect_json_data_user( $dragblock_ae_content ) {
	global $dragblock_user_json;
	$dragblock_user_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_action( 'wp_enqueue_scripts', 'dragblock_appearance_front_scripts' );
/**
 * Check Documentation#1792
 */
function dragblock_appearance_front_scripts() {
	// dev-reply#17215.
	global $dragblock_css;
	// dev-reply#17230.
	$dragblock_ae_parsed = implode( '', $dragblock_css );
	// dev-reply#17233.
	global $dragblock_theme_json;
	global $dragblock_default_json;
	global $dragblock_user_json;
	// dev-reply#17242.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['theme'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = $dragblock_user_json['settings']['color']['palette']['theme'];
	}
	// dev-reply#17254.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['custom'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = array_merge( $dragblock_theme_json['settings']['color']['palette']['theme'], $dragblock_user_json['settings']['color']['palette']['custom'] );
	}
	if ( ! empty( $dragblock_theme_json['settings']['color']['palette']['theme'] ) ) {
		foreach ( $dragblock_theme_json['settings']['color']['palette']['theme'] as $dragblock_ae_uid ) {
			if ( empty( $dragblock_ae_uid['slug'] ) ) {
				continue;
			}
			// dev-reply#17267.
			$dragblock_ae_parsed = str_replace(
				'{c=' . $dragblock_ae_uid['slug'] . '}',
				$dragblock_ae_uid['color'],
				$dragblock_ae_parsed
			);
			// dev-reply#17274.
			$dragblock_ae_parsed = str_replace(
				'{c=' . $dragblock_ae_uid['slug'] . '@}',
				substr( $dragblock_ae_uid['color'], 0, 7 ),
				$dragblock_ae_parsed
			);
		}
	}
	if ( ! empty( $dragblock_default_json['settings']['color']['palette']['default'] ) ) {
		foreach ( $dragblock_default_json['settings']['color']['palette']['default'] as $dragblock_ae_uid ) {
			if ( empty( $dragblock_ae_uid['slug'] ) ) {
				continue;
			}
			// dev-reply#17289.
			$dragblock_ae_parsed = str_replace(
				'{c=' . $dragblock_ae_uid['slug'] . '}',
				$dragblock_ae_uid['color'],
				$dragblock_ae_parsed
			);
			// dev-reply#17296.
			$dragblock_ae_parsed = str_replace(
				'{c=' . $dragblock_ae_uid['slug'] . '@}',
				substr( $dragblock_ae_uid['color'], 0, 7 ),
				$dragblock_ae_parsed
			);
		}
	}
	if ( $dragblock_ae_parsed ) {
		wp_add_inline_style( DRAGBLOCK_EDITOR_INIT_SLUG, $dragblock_ae_parsed );
		if ( strpos( $dragblock_ae_parsed, 'animation-name' ) !== false ) {
			dragblock_enqueue( 'dragblock-app-animate', 'assets/css/animate.min.css' );
		}
	}
}
