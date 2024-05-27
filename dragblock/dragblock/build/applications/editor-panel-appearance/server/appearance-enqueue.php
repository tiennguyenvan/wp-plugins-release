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
 * Check Documentation#243
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
 * Check Documentation#2415
 *
 * @param object|array|string $dragblock_ae_dragblock check var-def#2415.
 * @param object|array|string $dragblock_ae_css check var-def#2415.
 */
function dragblock_appearance_collect_css( $dragblock_ae_dragblock, $dragblock_ae_css ) {
	// dev-reply#2457.
	if (
		'core/null' === $dragblock_ae_css['blockName'] ||
		empty( $dragblock_ae_css['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_ae_dragblock;
	}
	$dragblock_ae_theme = dragblock_uid_key( $dragblock_ae_css );
	global $dragblock_css;
	// dev-reply#2496.
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
			// dev-reply#24127.
			$dragblock_ae_block = dragblock_uid_key( $dragblock_ae_user );
			if ( ! empty( $dragblock_css[ $dragblock_ae_block ] ) ) {
				$dragblock_ae_json .= $dragblock_css[ $dragblock_ae_block ];
				unset( $dragblock_css[ $dragblock_ae_block ] );
				// dev-reply#24133.
			}
		}
	}
	if ( $dragblock_ae_json ) {
		$dragblock_css[ $dragblock_ae_theme ] = $dragblock_ae_json;
	}
	// dev-reply#24146.
	return $dragblock_ae_dragblock;
}
/**
 * Check Documentation#2463
 *
 * @param object|array|string $dragblock_ae_css check var-def#2463.
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
 * Check Documentation#2472
 *
 * @param object|array|string $dragblock_ae_content check var-def#2472.
 */
function dragblock_appearance_collect_json_data_theme( $dragblock_ae_content ) {
	global $dragblock_theme_json;
	$dragblock_theme_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_filter( 'wp_theme_json_data_default', 'dragblock_appearance_collect_json_data_default', 10, 1 );
/**
 * Check Documentation#2479
 *
 * @param object|array|string $dragblock_ae_content check var-def#2479.
 */
function dragblock_appearance_collect_json_data_default( $dragblock_ae_content ) {
	global $dragblock_default_json;
	$dragblock_default_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_filter( 'wp_theme_json_data_user', 'dragblock_appearance_collect_json_data_user', 10, 1 );
/**
 * Check Documentation#2486
 *
 * @param object|array|string $dragblock_ae_content check var-def#2486.
 */
function dragblock_appearance_collect_json_data_user( $dragblock_ae_content ) {
	global $dragblock_user_json;
	$dragblock_user_json = $dragblock_ae_content->get_data();
	return $dragblock_ae_content;
}
add_action( 'wp_enqueue_scripts', 'dragblock_appearance_front_scripts' );
/**
 * Check Documentation#2493
 */
function dragblock_appearance_front_scripts() {
	// dev-reply#24217.
	global $dragblock_css;
	// dev-reply#24232.
	$dragblock_ae_parsed = implode( '', $dragblock_css );
	// dev-reply#24235.
	global $dragblock_theme_json;
	global $dragblock_default_json;
	global $dragblock_user_json;
	// dev-reply#24244.
	if (
		! empty( $dragblock_user_json['settings']['color']['palette']['theme'] )
	) {
		$dragblock_theme_json['settings']['color']['palette']['theme'] = $dragblock_user_json['settings']['color']['palette']['theme'];
	}
	// dev-reply#24256.
	$dragblock_ae_uid = array();
	if ( ! empty( $dragblock_theme_json['settings']['color']['palette']['theme'] ) ) {
		$dragblock_ae_uid = array_merge( $dragblock_ae_uid, $dragblock_theme_json['settings']['color']['palette']['theme'] );
	}
	if ( ! empty( $dragblock_user_json['settings']['color']['palette']['custom'] ) ) {
		$dragblock_ae_uid = array_merge( $dragblock_ae_uid, $dragblock_user_json['settings']['color']['palette']['custom'] );
	}
	if ( ! empty( $dragblock_default_json['settings']['color']['palette']['default'] ) ) {
		$dragblock_ae_uid = array_merge( $dragblock_ae_uid, $dragblock_default_json['settings']['color']['palette']['default'] );
	}
	// dev-reply#24271.
	foreach ( $dragblock_ae_uid as $dragblock_ae_key ) {
		if ( empty( $dragblock_ae_key['slug'] ) ) {
			continue;
		}
		// dev-reply#24286.
		$dragblock_ae_parsed = str_replace(
			ColorVarStart . $dragblock_ae_key['slug'] . ColorVarEnd,
			$dragblock_ae_key['color'],
			$dragblock_ae_parsed
		);
		// dev-reply#24293.
		$dragblock_ae_parsed = str_replace(
			ColorVarStart . $dragblock_ae_key['slug'] . ColorVarAlphaSep . ColorVarEnd,
			substr( $dragblock_ae_key['color'], 0, 7 ),
			$dragblock_ae_parsed
		);
	}
	// dev-reply#24301.
	foreach ( $dragblock_ae_uid as $dragblock_ae_block => $dragblock_ae_uids ) {
		if ( empty( $dragblock_ae_uids['slug'] ) || empty( $dragblock_ae_uids['color'] ) ) {
			unset( $dragblock_ae_uid[ $dragblock_ae_block ] );
			continue;
		}
	}
	// dev-reply#24310.
	$dragblock_ae_json = explode( ColorVarStartNew, $dragblock_ae_parsed );
	for ( $dragblock_ae_selector = 1; $dragblock_ae_selector < count( $dragblock_ae_json ); $dragblock_ae_selector++ ) {
		$dragblock_ae_inner = explode( ColorVarEndNew, $dragblock_ae_json[ $dragblock_ae_selector ] );
		if ( count( $dragblock_ae_inner ) < 2 ) continue; // dev-reply#24316.
		if ( strpos( $dragblock_ae_inner[0], '{' ) !== false ) continue; // dev-reply#24317.
		$dragblock_ae_save = explode( ColorVarBackupSep, $dragblock_ae_inner[0] );
		$dragblock_ae_colors = $dragblock_ae_save[0];
		$dragblock_ae_color = strpos( $dragblock_ae_colors, ColorVarAlphaSepNew ) !== false;
		if ( $dragblock_ae_color ) {
			$dragblock_ae_colors = explode( ColorVarAlphaSepNew, $dragblock_ae_colors )[0];
		}
		$dragblock_ae_c = count( $dragblock_ae_save ) > 1 ? $dragblock_ae_save[1] : ''; // dev-reply#24328.
		foreach ( $dragblock_ae_uid as $dragblock_ae_uids ) {
			if ( ( $dragblock_ae_colors ) !== $dragblock_ae_uids['slug'] ) continue;
			$dragblock_ae_c = $dragblock_ae_uids['color'];
			break;
		}
		// dev-reply#24335.
		if ( empty( $dragblock_ae_c ) || strlen( $dragblock_ae_c ) > 36 ) continue;
		// dev-reply#24339.
		if ( $dragblock_ae_color ) {
			$dragblock_ae_c = substr( $dragblock_ae_c, 0, 7 );
		}
		unset( $dragblock_ae_inner[0] );
		$dragblock_ae_json[ $dragblock_ae_selector ] = $dragblock_ae_c . implode( ColorVarEndNew, $dragblock_ae_inner );
	}
	$dragblock_ae_parsed = implode( '', $dragblock_ae_json );
	// dev-reply#24350.
	$dragblock_ae_i = array();
	if ( ! empty( $dragblock_theme_json['settings']['color']['gradients']['theme'] ) ) {
		$dragblock_ae_i = array_merge( $dragblock_ae_i, $dragblock_theme_json['settings']['color']['gradients']['theme'] );
	}
	if ( ! empty( $dragblock_theme_json['settings']['color']['duotone']['theme'] ) ) {
		$dragblock_ae_i = array_merge( $dragblock_ae_i, $dragblock_theme_json['settings']['color']['duotone']['theme'] );
	}
	if ( ! empty( $dragblock_user_json['settings']['color']['gradients']['default'] ) ) {
		$dragblock_ae_i = array_merge( $dragblock_ae_i, $dragblock_user_json['settings']['color']['gradients']['default'] );
	}
	if ( ! empty( $dragblock_user_json['settings']['color']['gradients']['custom'] ) ) {
		$dragblock_ae_i = array_merge( $dragblock_ae_i, $dragblock_user_json['settings']['color']['gradients']['custom'] );
	}
	if ( ! empty( $dragblock_default_json['settings']['color']['duotone']['default'] ) ) {
		$dragblock_ae_i = array_merge( $dragblock_ae_i, $dragblock_default_json['settings']['color']['duotone']['default'] );
	}
	// dev-reply#24386.
	foreach ( $dragblock_ae_i as $dragblock_ae_block => $dragblock_ae_parts ) {
		if ( empty( $dragblock_ae_parts['slug'] ) ) {
			unset( $dragblock_ae_i[ $dragblock_ae_block ] );
			continue;
		}
		// dev-reply#24398.
		if ( empty( $dragblock_ae_parts['gradient'] ) ) {
			if ( empty( $dragblock_ae_parts['colors'] ) || count( $dragblock_ae_parts['colors'] ) < 2 ) {
				unset( $dragblock_ae_i[ $dragblock_ae_block ] );
				continue;
			}
			$dragblock_ae_parts['colors'][0] .= ' 50%';
			$dragblock_ae_parts['colors'][1] .= ' 50%';
			$dragblock_ae_parts['gradient'] = 'linear-gradient(135deg,' . implode( ',', $dragblock_ae_parts['colors'] ) . ')';
			unset( $dragblock_ae_parts['colors'] );
			$dragblock_ae_i[ $dragblock_ae_block ] = $dragblock_ae_parts;
		}
	}
	// dev-reply#24413.
	$dragblock_ae_var = '⮕g=';
	$dragblock_ae_slug = '⬇g='; // dev-reply#24415.
	$dragblock_ae_has = 'g⬅';
	$dragblock_ae_json = explode( GradientVarStart, $dragblock_ae_parsed );
	for ( $dragblock_ae_selector = 1; $dragblock_ae_selector < count( $dragblock_ae_json ); $dragblock_ae_selector++ ) {
		$dragblock_ae_inner = explode( GradientVarEnd, $dragblock_ae_json[ $dragblock_ae_selector ] );
		if ( count( $dragblock_ae_inner ) < 2 ) continue; // dev-reply#24422.
		if ( strpos( $dragblock_ae_inner[0], '{' ) !== false ) continue; // dev-reply#24423.
		$dragblock_ae_alpha = explode( GradientVarBackup, $dragblock_ae_inner[0] );
		// dev-reply#24427.
		if ( count( $dragblock_ae_alpha ) < 2 ) continue;
		$dragblock_ae_colors = $dragblock_ae_alpha[0];
		$dragblock_ae_c = $dragblock_ae_alpha[1]; // dev-reply#24431.
		if ( ! str_ends_with( $dragblock_ae_c, ')' ) ) continue;
		foreach ( $dragblock_ae_i as $dragblock_ae_parts ) {
			if ( ( $dragblock_ae_colors ) !== $dragblock_ae_parts['slug'] ) continue;
			$dragblock_ae_c = $dragblock_ae_parts['gradient'];
			break;
		}
		unset( $dragblock_ae_inner[0] );
		$dragblock_ae_json[ $dragblock_ae_selector ] = $dragblock_ae_c . implode( GradientVarEnd, $dragblock_ae_inner );
	}
	$dragblock_ae_parsed = implode( '', $dragblock_ae_json );
	if ( $dragblock_ae_parsed ) {
		wp_add_inline_style( DRAGBLOCK_EDITOR_INIT_SLUG, $dragblock_ae_parsed );
		if ( strpos( $dragblock_ae_parsed, 'animation-name' ) !== false ) {
			dragblock_enqueue( 'dragblock-app-animate', 'assets/css/animate.min.css' );
		}
	}
}
