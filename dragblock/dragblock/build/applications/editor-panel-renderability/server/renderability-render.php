<?php
/**
 * DragBlock's Editor-panel-renderability.
 *
 * @package Renderability render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#182
 *
 * @param object|array|string $dragblock_rr_block check var-def#182.
 */
function couldBlockBeRendered( $dragblock_rr_block ) {
	if ( is_null( $dragblock_rr_block ) ) {
		// dev-reply#185.
		return true;
	}
	if ( $dragblock_rr_block instanceof WP_Block ) {
		$dragblock_rr_block = $dragblock_rr_block->parsed_block;
	}
	if (
		is_null( $dragblock_rr_block ) ||
		'core/null' === $dragblock_rr_block['blockName'] ||
		empty( $dragblock_rr_block['attrs']['dragBlockRenderability'] )
	) {
		// dev-reply#1817.
		return true;
	}
	// dev-reply#1822.
	$dragblock_rr_browsers = null;
	$dragblock_rr_devices = null;
	$dragblock_rr_oses = null;
	$dragblock_rr_user = null;
	$dragblock_rr_logged = null;
	$dragblock_rr_languages = array();
	// dev-reply#1840.
	foreach ( $dragblock_rr_block['attrs']['dragBlockRenderability'] as $dragblock_rr_url ) {
		if ( ! empty( $dragblock_rr_url['disabled'] ) || empty( $dragblock_rr_url['slug'] ) || ! isset( $dragblock_rr_url['value'] ) ) {
			continue;
		}
		// dev-reply#1849.
		if ( 'url-query' === $dragblock_rr_url['slug'] ) {
			// dev-reply#1852.
			if ( empty( $dragblock_rr_url['name'] ) ) continue;
			$dragblock_rr_query = $dragblock_rr_url['name'];
			// dev-reply#1857.
			if ( empty( $dragblock_rr_languages[ $dragblock_rr_query ] ) ) {
				$dragblock_rr_languages[ $dragblock_rr_query ] = array();
			}
			array_push( $dragblock_rr_languages[ $dragblock_rr_query ], $dragblock_rr_url );
			continue;
		}
		if ( empty( $dragblock_rr_url['value'] ) ) {
			continue;
		}
		if ( 'render' === $dragblock_rr_url['slug'] ) {
			if ( $dragblock_rr_url['value'] === 'never' ) {
				return false;
			}
			return true;
		}
		// dev-reply#1880.
		if ( 'language' === $dragblock_rr_url['slug'] ) {
			if ( null === $dragblock_rr_logged ) {
				$dragblock_rr_logged = false;
			}
			if ( false === $dragblock_rr_logged ) {
				if ( ( empty( $dragblock_rr_url['operator'] ) || '==' === $dragblock_rr_url['operator'] ) ) {
					$dragblock_rr_logged = ( get_locale() === $dragblock_rr_url['value'] );
				} else {
					$dragblock_rr_logged = ( get_locale() !== $dragblock_rr_url['value'] );
				}
			}
			continue;
		}
		// dev-reply#18101.
		if ( 'browser' === $dragblock_rr_url['slug'] ) {
			if ( null === $dragblock_rr_browsers ) {
				$dragblock_rr_browsers = false;
			}
			if ( false === $dragblock_rr_browsers ) {
				if ( ( empty( $dragblock_rr_url['operator'] ) || '==' === $dragblock_rr_url['operator'] ) ) {
					$dragblock_rr_browsers = ( dragblock_get_current_browser() === $dragblock_rr_url['value'] );
				} else {
					$dragblock_rr_browsers = ( dragblock_get_current_browser() !== $dragblock_rr_url['value'] );
				}
			}
			continue;
		}
		// dev-reply#18116.
		if ( 'device' === $dragblock_rr_url['slug'] ) {
			if ( null === $dragblock_rr_devices ) {
				$dragblock_rr_devices = false;
			}
			if ( false === $dragblock_rr_devices ) {
				if ( ( empty( $dragblock_rr_url['operator'] ) || '==' === $dragblock_rr_url['operator'] ) ) {
					$dragblock_rr_devices = ( dragblock_get_current_device() === $dragblock_rr_url['value'] );
				} else {
					$dragblock_rr_devices = ( dragblock_get_current_device() !== $dragblock_rr_url['value'] );
				}
			}
			continue;
		}
		// dev-reply#18131.
		if ( 'os' === $dragblock_rr_url['slug'] ) {
			if ( null === $dragblock_rr_oses ) {
				$dragblock_rr_oses = false;
			}
			if ( false === $dragblock_rr_oses ) {
				if ( ( empty( $dragblock_rr_url['operator'] ) || '==' === $dragblock_rr_url['operator'] ) ) {
					$dragblock_rr_oses = ( dragblock_get_current_os() === $dragblock_rr_url['value'] );
				} else {
					$dragblock_rr_oses = ( dragblock_get_current_os() !== $dragblock_rr_url['value'] );
				}
			}
			continue;
		}
		// dev-reply#18146.
		if ( 'user-logged' === $dragblock_rr_url['slug'] ) {
			if ( null === $dragblock_rr_user ) {
				$dragblock_rr_user = false;
			}
			if ( false === $dragblock_rr_user ) {
				$dragblock_rr_conditions = is_user_logged_in() ? 'in' : 'out';
				if ( ( empty( $dragblock_rr_url['operator'] ) || '==' === $dragblock_rr_url['operator'] ) ) {
					$dragblock_rr_user = ( ( $dragblock_rr_conditions ) === $dragblock_rr_url['value'] );
				} else {
					$dragblock_rr_user = ( ( $dragblock_rr_conditions ) !== $dragblock_rr_url['value'] );
				}
			}
			continue;
		}
	}
	// dev-reply#18164.
	foreach ( $dragblock_rr_languages as $dragblock_rr_query => $dragblock_rr_condition ) {
		// dev-reply#18171.
		$dragblock_rr_name = false;
		$dragblock_rr_status = isset( $_GET[ $dragblock_rr_query ] ) ? sanitize_text_field( wp_unslash( $_GET[ $dragblock_rr_query ] ) ) : '';
		// dev-reply#18176.
		foreach ( $dragblock_rr_condition as $dragblock_rr_logic ) {
			$dragblock_rr_current = empty( $dragblock_rr_logic['operator'] ) || $dragblock_rr_logic['operator'] === '==' ? '==' : '!=';
			$dragblock_rr_get = $dragblock_rr_logic['value'];
			// dev-reply#18181.
			if (
				( $dragblock_rr_current ) === '==' && ( $dragblock_rr_status ) === $dragblock_rr_get ||
				( $dragblock_rr_current ) === '!=' && ( $dragblock_rr_status ) !== $dragblock_rr_get
			) {
				$dragblock_rr_name = true;
				break;
			}
		}
		// dev-reply#18191.
		if ( ( $dragblock_rr_name ) === false ) {
			// dev-reply#18195.
			return false;
		}
	}
	// dev-reply#18201.
	if ( null === $dragblock_rr_browsers ) $dragblock_rr_browsers = true;
	if ( null === $dragblock_rr_devices ) $dragblock_rr_devices = true;
	if ( null === $dragblock_rr_oses ) $dragblock_rr_oses = true;
	if ( null === $dragblock_rr_user ) $dragblock_rr_user = true;
	if ( null === $dragblock_rr_logged ) $dragblock_rr_logged = true;
	// dev-reply#18208.
	if ( $dragblock_rr_browsers && $dragblock_rr_devices && $dragblock_rr_oses && $dragblock_rr_user && $dragblock_rr_logged ) return true;
	return false;
}
add_filter( 'pre_render_block', 'dragblock_renderability_render', 99999, 3 );
/**
 * Check Documentation#18159
 *
 * @param object|array|string $dragblock_rr_cond check var-def#18159.
 * @param object|array|string $dragblock_rr_operator check var-def#18159.
 * @param object|array|string $dragblock_rr_value check var-def#18159.
 */
function dragblock_renderability_render( $dragblock_rr_cond = null, $dragblock_rr_operator = null, $dragblock_rr_value = null ) {
	// dev-reply#18221.
	if ( ! couldBlockBeRendered( $dragblock_rr_value ) || ! couldBlockBeRendered( $dragblock_rr_operator ) ) {
		// dev-reply#18229.
		return '';
	}
	return $dragblock_rr_cond;
}
