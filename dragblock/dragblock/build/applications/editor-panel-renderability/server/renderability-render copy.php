<?php
/**
 * DragBlock's Editor-panel-renderability.
 *
 * @package Renderability render copy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'render_block', 'dragblock_renderability_render', 1, 2 );
/**
 * Check Documentation#163
 *
 * @param object|array|string $dragblock_rr_block check var-def#163.
 * @param object|array|string $dragblock_rr_content check var-def#163.
 */
function dragblock_renderability_render( $dragblock_rr_block, $dragblock_rr_content ) {
	// dev-reply#167.
	if (
		'core/null' === $dragblock_rr_content['blockName'] ||
		empty( $dragblock_rr_content['attrs']['dragBlockRenderability'] )
	) {
		return $dragblock_rr_block;
	}
	$dragblock_rr_parsed = null;
	$dragblock_rr_browsers = null;
	$dragblock_rr_devices = null;
	$dragblock_rr_oses = null;
	$dragblock_rr_user = null;
	$dragblock_rr_logged = array();
	// dev-reply#1631.
	foreach ( $dragblock_rr_content['attrs']['dragBlockRenderability'] as $dragblock_rr_languages ) {
		if ( ! empty( $dragblock_rr_languages['disabled'] ) || empty( $dragblock_rr_languages['slug'] ) || ! isset( $dragblock_rr_languages['value'] ) ) {
			continue;
		}
		// dev-reply#1640.
		if ( 'url-query' === $dragblock_rr_languages['slug'] ) {
			// dev-reply#1643.
			if ( empty( $dragblock_rr_languages['name'] ) ) continue;
			$dragblock_rr_url = $dragblock_rr_languages['name'];
			// dev-reply#1648.
			if ( empty( $dragblock_rr_logged[ $dragblock_rr_url ] ) ) {
				$dragblock_rr_logged[ $dragblock_rr_url ] = array();
			}
			array_push( $dragblock_rr_logged[ $dragblock_rr_url ], $dragblock_rr_languages );
			continue;
		}
		if ( empty( $dragblock_rr_languages['value'] ) ) {
			continue;
		}
		if ( 'render' === $dragblock_rr_languages['slug'] ) {
			if ( $dragblock_rr_languages['value'] === 'never' ) {
				return '';
			}
			return $dragblock_rr_block;
		}
		// dev-reply#1671.
		if ( 'language' === $dragblock_rr_languages['slug'] ) {
			if ( null === $dragblock_rr_user ) {
				$dragblock_rr_user = false;
			}
			if ( false === $dragblock_rr_user ) {
				if ( ( empty( $dragblock_rr_languages['operator'] ) || '==' === $dragblock_rr_languages['operator'] ) ) {
					$dragblock_rr_user = ( get_locale() === $dragblock_rr_languages['value'] );
				} else {
					$dragblock_rr_user = ( get_locale() !== $dragblock_rr_languages['value'] );
				}
			}
			continue;
		}
		// dev-reply#1692.
		if ( 'browser' === $dragblock_rr_languages['slug'] ) {
			if ( null === $dragblock_rr_parsed ) {
				$dragblock_rr_parsed = false;
			}
			if ( false === $dragblock_rr_parsed ) {
				if ( ( empty( $dragblock_rr_languages['operator'] ) || '==' === $dragblock_rr_languages['operator'] ) ) {
					$dragblock_rr_parsed = ( dragblock_get_current_browser() === $dragblock_rr_languages['value'] );
				} else {
					$dragblock_rr_parsed = ( dragblock_get_current_browser() !== $dragblock_rr_languages['value'] );
				}
			}
			continue;
		}
		// dev-reply#16107.
		if ( 'device' === $dragblock_rr_languages['slug'] ) {
			if ( null === $dragblock_rr_browsers ) {
				$dragblock_rr_browsers = false;
			}
			if ( false === $dragblock_rr_browsers ) {
				if ( ( empty( $dragblock_rr_languages['operator'] ) || '==' === $dragblock_rr_languages['operator'] ) ) {
					$dragblock_rr_browsers = ( dragblock_get_current_device() === $dragblock_rr_languages['value'] );
				} else {
					$dragblock_rr_browsers = ( dragblock_get_current_device() !== $dragblock_rr_languages['value'] );
				}
			}
			continue;
		}
		// dev-reply#16122.
		if ( 'os' === $dragblock_rr_languages['slug'] ) {
			if ( null === $dragblock_rr_devices ) {
				$dragblock_rr_devices = false;
			}
			if ( false === $dragblock_rr_devices ) {
				if ( ( empty( $dragblock_rr_languages['operator'] ) || '==' === $dragblock_rr_languages['operator'] ) ) {
					$dragblock_rr_devices = ( dragblock_get_current_os() === $dragblock_rr_languages['value'] );
				} else {
					$dragblock_rr_devices = ( dragblock_get_current_os() !== $dragblock_rr_languages['value'] );
				}
			}
			continue;
		}
		// dev-reply#16137.
		if ( 'user-logged' === $dragblock_rr_languages['slug'] ) {
			if ( null === $dragblock_rr_oses ) {
				$dragblock_rr_oses = false;
			}
			if ( false === $dragblock_rr_oses ) {
				$dragblock_rr_query = is_user_logged_in() ? 'in' : 'out';
				if ( ( empty( $dragblock_rr_languages['operator'] ) || '==' === $dragblock_rr_languages['operator'] ) ) {
					$dragblock_rr_oses = ( ( $dragblock_rr_query ) === $dragblock_rr_languages['value'] );
				} else {
					$dragblock_rr_oses = ( ( $dragblock_rr_query ) !== $dragblock_rr_languages['value'] );
				}
			}
			continue;
		}
	}
	// dev-reply#16155.
	foreach ( $dragblock_rr_logged as $dragblock_rr_url => $dragblock_rr_conditions ) {
		// dev-reply#16164.
		$dragblock_rr_condition = false;
		$dragblock_rr_name = isset( $_GET[ $dragblock_rr_url ] ) ? sanitize_text_field( wp_unslash( $_GET[ $dragblock_rr_url ] ) ) : '';
		// dev-reply#16169.
		foreach ( $dragblock_rr_conditions as $dragblock_rr_status ) {
			$dragblock_rr_logic = empty( $dragblock_rr_status['operator'] ) || $dragblock_rr_status['operator'] === '==' ? '==' : '!=';
			$dragblock_rr_current = $dragblock_rr_status['value'];
			// dev-reply#16174.
			if (
				( $dragblock_rr_logic ) === '==' && ( $dragblock_rr_name ) === $dragblock_rr_current ||
				( $dragblock_rr_logic ) === '!=' && ( $dragblock_rr_name ) !== $dragblock_rr_current
			) {
				$dragblock_rr_condition = true;
				break;
			}
		}
		if ( ( $dragblock_rr_condition ) === false ) return '';
	}
	// dev-reply#16188.
	if ( null === $dragblock_rr_parsed ) $dragblock_rr_parsed = true;
	if ( null === $dragblock_rr_browsers ) $dragblock_rr_browsers = true;
	if ( null === $dragblock_rr_devices ) $dragblock_rr_devices = true;
	if ( null === $dragblock_rr_oses ) $dragblock_rr_oses = true;
	if ( null === $dragblock_rr_user ) $dragblock_rr_user = true;
	if ( $dragblock_rr_parsed && $dragblock_rr_browsers && $dragblock_rr_devices && $dragblock_rr_oses && $dragblock_rr_user ) return $dragblock_rr_block;
	return '';
}
