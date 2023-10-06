<?php
/**
 * DragBlock's Editor-panel-renderability.
 *
 * @package Renderability render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'render_block', 'dragblock_renderability_render', 1, 2 );
/**
 * Check Documentation#103
 *
 * @param object|array|string $dragblock_rr_block_content check var-def#103.
 * @param object|array|string $dragblock_rr_parsed_block check var-def#103.
 */
function dragblock_renderability_render( $dragblock_rr_block_content, $dragblock_rr_parsed_block ) {
	if (
		'core/null' === $dragblock_rr_parsed_block['blockName'] ||
		empty( $dragblock_rr_parsed_block['attrs']['dragBlockRenderability'] )
	) {
		return $dragblock_rr_block_content;
	}
	$dragblock_rr_browsers = null;
	$dragblock_rr_devices = null;
	$dragblock_rr_oses = null;
	$dragblock_rr_user_logged = null;
	foreach ( $dragblock_rr_parsed_block['attrs']['dragBlockRenderability'] as $dragblock_rr_condition ) {
		if ( ! empty( $dragblock_rr_condition['disabled'] ) || empty( $dragblock_rr_condition['slug'] ) || empty( $dragblock_rr_condition['value'] ) ) {
			continue;
		}
		// dev-reply#1027.
		if ( 'browser' === $dragblock_rr_condition['slug'] ) {
			if ( null === $dragblock_rr_browsers ) {
				$dragblock_rr_browsers = false;
			}
			if ( false === $dragblock_rr_browsers ) {
				if ( ( empty( $dragblock_rr_condition['operator'] ) || '==' === $dragblock_rr_condition['operator'] ) ) {
					$dragblock_rr_browsers = ( dragblock_get_current_browser() === $dragblock_rr_condition['value'] );
				} else {
					$dragblock_rr_browsers = ( dragblock_get_current_browser() !== $dragblock_rr_condition['value'] );
				}
			}
			continue;
		}
		// dev-reply#1042.
		if ( 'device' === $dragblock_rr_condition['slug'] ) {
			if ( null === $dragblock_rr_devices ) {
				$dragblock_rr_devices = false;
			}
			if ( false === $dragblock_rr_devices ) {
				if ( ( empty( $dragblock_rr_condition['operator'] ) || '==' === $dragblock_rr_condition['operator'] ) ) {
					$dragblock_rr_devices = ( dragblock_get_current_device() === $dragblock_rr_condition['value'] );
				} else {
					$dragblock_rr_devices = ( dragblock_get_current_device() !== $dragblock_rr_condition['value'] );
				}
			}
			continue;
		}
		// dev-reply#1057.
		if ( 'os' === $dragblock_rr_condition['slug'] ) {
			if ( null === $dragblock_rr_oses ) {
				$dragblock_rr_oses = false;
			}
			if ( false === $dragblock_rr_oses ) {
				if ( ( empty( $dragblock_rr_condition['operator'] ) || '==' === $dragblock_rr_condition['operator'] ) ) {
					$dragblock_rr_oses = ( dragblock_get_current_os() === $dragblock_rr_condition['value'] );
				} else {
					$dragblock_rr_oses = ( dragblock_get_current_os() !== $dragblock_rr_condition['value'] );
				}
			}
			continue;
		}
		// dev-reply#1072.
		if ( 'user-logged' === $dragblock_rr_condition['slug'] ) {
			if ( null === $dragblock_rr_user_logged ) {
				$dragblock_rr_user_logged = false;
			}
			if ( false === $dragblock_rr_user_logged ) {
				$dragblock_rr_user_logged_status = is_user_logged_in() ? 'in' : 'out';
				if ( ( empty( $dragblock_rr_condition['operator'] ) || '==' === $dragblock_rr_condition['operator'] ) ) {
					$dragblock_rr_user_logged = ( ( $dragblock_rr_user_logged_status ) === $dragblock_rr_condition['value'] );
				} else {
					$dragblock_rr_user_logged = ( ( $dragblock_rr_user_logged_status ) !== $dragblock_rr_condition['value'] );
				}
			}
			continue;
		}
	}
	// dev-reply#1089.
	if ( null === $dragblock_rr_browsers ) {
		$dragblock_rr_browsers = true;
	}
	if ( null === $dragblock_rr_devices ) {
		$dragblock_rr_devices = true;
	}
	if ( null === $dragblock_rr_oses ) {
		$dragblock_rr_oses = true;
	}
	if ( null === $dragblock_rr_user_logged ) {
		$dragblock_rr_user_logged = true;
	}
	if ( $dragblock_rr_browsers && $dragblock_rr_devices && $dragblock_rr_oses && $dragblock_rr_user_logged ) {
		return $dragblock_rr_block_content;
	}
	return '';
}
