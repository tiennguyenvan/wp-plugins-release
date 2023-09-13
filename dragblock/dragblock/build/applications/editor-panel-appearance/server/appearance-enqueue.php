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
	$dragblock_0 = 'appearance';
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.css" );
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
 * @param object|array|string $dragblock_1 check var-def#1515.
 * @param object|array|string $dragblock_2 check var-def#1515.
 */
function dragblock_appearance_collect_css( $dragblock_1, $dragblock_2 ) {
	if (
		'core/null' === $dragblock_2['blockName'] ||
		empty( $dragblock_2['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_1;
	}
	$dragblock_3 = $dragblock_2['blockName'] . $dragblock_2['attrs']['dragBlockClientId'];
	$dragblock_4 = '';
	if ( ! empty( $dragblock_2['attrs']['dragBlockCSS'] ) ) {
		global $dragblock_uids;
		if ( ! empty( $dragblock_uids[ $dragblock_3 ] ) ) {
			$dragblock_5 = '.' . $dragblock_uids[ $dragblock_3 ];
			$dragblock_4 =
				str_replace(
					'[data-dragblock-client-id="' . $dragblock_2['attrs']['dragBlockClientId'] . '"]',
					$dragblock_5,
					$dragblock_2['attrs']['dragBlockCSS']
				);
			// dev-reply#1594.
		}
	}
	global $dragblock_css;
	if ( ! empty( $dragblock_2['innerBlocks'] ) ) {
		foreach ( $dragblock_2['innerBlocks'] as $dragblock_6 ) {
			if ( empty( $dragblock_6['blockName'] ) || empty( $dragblock_6['attrs']['dragBlockClientId'] ) ) {
				continue;
			}
			$dragblock_7 = $dragblock_6['blockName'] . $dragblock_6['attrs']['dragBlockClientId'];
			if ( ! empty( $dragblock_css[ $dragblock_7 ] ) ) {
				$dragblock_4 .= $dragblock_css[ $dragblock_7 ];
				unset( $dragblock_css[ $dragblock_7 ] );
			}
		}
	}
	if ( $dragblock_4 ) {
		$dragblock_css[ $dragblock_3 ] = $dragblock_4;
	}
	return $dragblock_1;
}
add_filter( 'wp_theme_json_data_theme', 'dragblock_appearance_collect_json_data_theme', 10 );
/**
 * Check Documentation#1557
 *
 * @param object|array|string $dragblock_8 check var-def#1557.
 */
function dragblock_appearance_collect_json_data_theme( $dragblock_8 ) {
	global $dragblock_theme_json;
	$dragblock_theme_json = $dragblock_8->get_data();
	return $dragblock_8;
}
add_filter( 'wp_theme_json_data_default', 'dragblock_appearance_collect_json_data_default', 10 );
/**
 * Check Documentation#1564
 *
 * @param object|array|string $dragblock_8 check var-def#1564.
 */
function dragblock_appearance_collect_json_data_default( $dragblock_8 ) {
	global $dragblock_default_json;
	$dragblock_default_json = $dragblock_8->get_data();
	return $dragblock_8;
}
add_filter( 'wp_theme_json_data_user', 'dragblock_appearance_collect_json_data_user', 10 );
/**
 * Check Documentation#1571
 *
 * @param object|array|string $dragblock_8 check var-def#1571.
 */
function dragblock_appearance_collect_json_data_user( $dragblock_8 ) {
	global $dragblock_user_json;
	$dragblock_user_json = $dragblock_8->get_data();
	return $dragblock_8;
}
add_action( 'wp_enqueue_scripts', 'dragblock_appearance_front_scripts' );
/**
 * Check Documentation#1578
 */
function dragblock_appearance_front_scripts() {
	// dev-reply#15170.
	global $dragblock_css;
	$dragblock_9 = implode( '', $dragblock_css );
	// dev-reply#15186.
	global $dragblock_theme_json;
	global $dragblock_default_json;
	global $dragblock_user_json;
	// dev-reply#15195.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['theme'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = $dragblock_user_json['settings']['color']['palette']['theme'];
	}
	// dev-reply#15207.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['custom'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = array_merge( $dragblock_theme_json['settings']['color']['palette']['theme'], $dragblock_user_json['settings']['color']['palette']['custom'] );
	}
	if ( ! empty( $dragblock_theme_json['settings']['color']['palette']['theme'] ) ) {
		foreach ( $dragblock_theme_json['settings']['color']['palette']['theme'] as $dragblock_10 ) {
			// dev-reply#15217.
			$dragblock_9 = str_replace(
				'{c=' . $dragblock_10['slug'] . '}',
				$dragblock_10['color'],
				$dragblock_9
			);
			// dev-reply#15224.
			$dragblock_9 = str_replace(
				'{c=' . $dragblock_10['slug'] . '@}',
				substr( $dragblock_10['color'], 0, 7 ),
				$dragblock_9
			);
		}
	}
	if ( ! empty( $dragblock_default_json['settings']['color']['palette']['default'] ) ) {
		foreach ( $dragblock_default_json['settings']['color']['palette']['default'] as $dragblock_10 ) {
			// dev-reply#15235.
			$dragblock_9 = str_replace(
				'{c=' . $dragblock_10['slug'] . '}',
				$dragblock_10['color'],
				$dragblock_9
			);
			// dev-reply#15242.
			$dragblock_9 = str_replace(
				'{c=' . $dragblock_10['slug'] . '@}',
				substr( $dragblock_10['color'], 0, 7 ),
				$dragblock_9
			);
		}
	}
	if ( $dragblock_9 ) {
		wp_add_inline_style( DRAGBLOCK_EDITOR_INIT_SLUG, $dragblock_9 );
		if ( strpos( $dragblock_9, 'animation-name' ) !== false ) {
			dragblock_enqueue( 'dragblock-app-animate', 'assets/css/animate.min.css' );
		}
	}
}
