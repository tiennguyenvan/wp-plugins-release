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
 * Check Documentation#153
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
 * Check Documentation#1515
 *
 * @param object|array|string $dragblock_ae_block_content check var-def#1515.
 * @param object|array|string $dragblock_ae_parsed_block check var-def#1515.
 */
function dragblock_appearance_collect_css( $dragblock_ae_block_content, $dragblock_ae_parsed_block ) {
	if (
		'core/null' === $dragblock_ae_parsed_block['blockName'] ||
		empty( $dragblock_ae_parsed_block['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_ae_block_content;
	}
	$dragblock_ae_uid_key = $dragblock_ae_parsed_block['blockName'] . $dragblock_ae_parsed_block['attrs']['dragBlockClientId'];
	$dragblock_ae_css = '';
	if ( ! empty( $dragblock_ae_parsed_block['attrs']['dragBlockCSS'] ) ) {
		global $dragblock_uids;
		if ( ! empty( $dragblock_uids[ $dragblock_ae_uid_key ] ) ) {
			$dragblock_ae_uid_selector = '.' . $dragblock_uids[ $dragblock_ae_uid_key ];
			$dragblock_ae_css =
				str_replace(
					'[data-dragblock-client-id="' . $dragblock_ae_parsed_block['attrs']['dragBlockClientId'] . '"]',
					$dragblock_ae_uid_selector,
					$dragblock_ae_parsed_block['attrs']['dragBlockCSS']
				);
			// dev-reply#1593.
		}
	}
	global $dragblock_css;
	if ( ! empty( $dragblock_ae_parsed_block['innerBlocks'] ) ) {
		foreach ( $dragblock_ae_parsed_block['innerBlocks'] as $dragblock_ae_inner_block ) {
			if ( empty( $dragblock_ae_inner_block['blockName'] ) || empty( $dragblock_ae_inner_block['attrs']['dragBlockClientId'] ) ) {
				continue;
			}
			$dragblock_ae_key = $dragblock_ae_inner_block['blockName'] . $dragblock_ae_inner_block['attrs']['dragBlockClientId'];
			if ( ! empty( $dragblock_css[ $dragblock_ae_key ] ) ) {
				$dragblock_ae_css .= $dragblock_css[ $dragblock_ae_key ];
				unset( $dragblock_css[ $dragblock_ae_key ] );
			}
		}
	}
	if ( $dragblock_ae_css ) {
		$dragblock_css[ $dragblock_ae_uid_key ] = $dragblock_ae_css;
	}
	return $dragblock_ae_block_content;
}
add_filter( 'wp_theme_json_data_theme', 'dragblock_appearance_collect_json_data_theme', 10 );
/**
 * Check Documentation#1557
 *
 * @param object|array|string $dragblock_ae_json check var-def#1557.
 */
function dragblock_appearance_collect_json_data_theme( $dragblock_ae_json ) {
	global $dragblock_theme_json;
	$dragblock_theme_json = $dragblock_ae_json->get_data();
	return $dragblock_ae_json;
}
add_filter( 'wp_theme_json_data_default', 'dragblock_appearance_collect_json_data_default', 10 );
/**
 * Check Documentation#1564
 *
 * @param object|array|string $dragblock_ae_json check var-def#1564.
 */
function dragblock_appearance_collect_json_data_default( $dragblock_ae_json ) {
	global $dragblock_default_json;
	$dragblock_default_json = $dragblock_ae_json->get_data();
	return $dragblock_ae_json;
}
add_filter( 'wp_theme_json_data_user', 'dragblock_appearance_collect_json_data_user', 10 );
/**
 * Check Documentation#1571
 *
 * @param object|array|string $dragblock_ae_json check var-def#1571.
 */
function dragblock_appearance_collect_json_data_user( $dragblock_ae_json ) {
	global $dragblock_user_json;
	$dragblock_user_json = $dragblock_ae_json->get_data();
	return $dragblock_ae_json;
}
add_action( 'wp_enqueue_scripts', 'dragblock_appearance_front_scripts' );
/**
 * Check Documentation#1578
 */
function dragblock_appearance_front_scripts() {
	// dev-reply#15169.
	global $dragblock_css;
	$dragblock_ae_dragblock_save_css = implode( '', $dragblock_css );
	// dev-reply#15185.
	global $dragblock_theme_json;
	global $dragblock_default_json;
	global $dragblock_user_json;
	// dev-reply#15194.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['theme'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = $dragblock_user_json['settings']['color']['palette']['theme'];
	}
	// dev-reply#15206.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['custom'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = array_merge( $dragblock_theme_json['settings']['color']['palette']['theme'], $dragblock_user_json['settings']['color']['palette']['custom'] );
	}
	if ( ! empty( $dragblock_theme_json['settings']['color']['palette']['theme'] ) ) {
		foreach ( $dragblock_theme_json['settings']['color']['palette']['theme'] as $dragblock_ae_color ) {
			// dev-reply#15216.
			$dragblock_ae_dragblock_save_css = str_replace(
				'{c=' . $dragblock_ae_color['slug'] . '}',
				$dragblock_ae_color['color'],
				$dragblock_ae_dragblock_save_css
			);
			// dev-reply#15223.
			$dragblock_ae_dragblock_save_css = str_replace(
				'{c=' . $dragblock_ae_color['slug'] . '@}',
				substr( $dragblock_ae_color['color'], 0, 7 ),
				$dragblock_ae_dragblock_save_css
			);
		}
	}
	if ( ! empty( $dragblock_default_json['settings']['color']['palette']['default'] ) ) {
		foreach ( $dragblock_default_json['settings']['color']['palette']['default'] as $dragblock_ae_color ) {
			// dev-reply#15234.
			$dragblock_ae_dragblock_save_css = str_replace(
				'{c=' . $dragblock_ae_color['slug'] . '}',
				$dragblock_ae_color['color'],
				$dragblock_ae_dragblock_save_css
			);
			// dev-reply#15241.
			$dragblock_ae_dragblock_save_css = str_replace(
				'{c=' . $dragblock_ae_color['slug'] . '@}',
				substr( $dragblock_ae_color['color'], 0, 7 ),
				$dragblock_ae_dragblock_save_css
			);
		}
	}
	if ( $dragblock_ae_dragblock_save_css ) {
		wp_add_inline_style( DRAGBLOCK_EDITOR_INIT_SLUG, $dragblock_ae_dragblock_save_css );
		if ( strpos( $dragblock_ae_dragblock_save_css, 'animation-name' ) !== false ) {
			dragblock_enqueue( 'dragblock-app-animate', 'assets/css/animate.min.css' );
		}
	}
}
