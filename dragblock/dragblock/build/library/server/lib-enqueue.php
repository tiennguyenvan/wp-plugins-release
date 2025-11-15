<?php
/**
 * DragBlock's Library.
 *
 * @package Lib enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#42
 *
 * @param object|array|string $dragblock_le_handle check var-def#42.
 * @param object|array|string $dragblock_le_path check var-def#42.
 * @param object|array|string $dragblock_le_dep check var-def#42.
 */
function dragblock_enqueue_register( $dragblock_le_handle, $dragblock_le_path, $dragblock_le_dep = null ) {
	// dev-reply#48.
	if ( strpos( $dragblock_le_path, '.js' ) ) {
		wp_register_script(
			$dragblock_le_handle,
			DRAGBLOCK_URL . $dragblock_le_path,
			$dragblock_le_dep,
			DRAGBLOCK_VERSION,
			true
		);
	} else {
		wp_register_style(
			$dragblock_le_handle,
			DRAGBLOCK_URL . $dragblock_le_path,
			$dragblock_le_dep,
			DRAGBLOCK_VERSION
		);
	}
}
/**
 * Check Documentation#424
 *
 * @param object|array|string $dragblock_le_handle check var-def#424.
 * @param object|array|string $dragblock_le_path check var-def#424.
 * @param object|array|string $dragblock_le_dep check var-def#424.
 */
function dragblock_enqueue( $dragblock_le_handle, $dragblock_le_path, $dragblock_le_dep = null ) {
	dragblock_enqueue_register( $dragblock_le_handle, $dragblock_le_path, $dragblock_le_dep );
	// dev-reply#435.
	if ( strpos( $dragblock_le_path, '.js' ) ) {
		wp_enqueue_script( $dragblock_le_handle );
	} else {
		wp_enqueue_style( $dragblock_le_handle );
	}
}
/**
 * Check Documentation#436
 *
 * @param object|array|string $dragblock_le_path check var-def#436.
 * @param object|array|string $dragblock_le_dep check var-def#436.
 */
function dragblock_admin_page_enqueue( $dragblock_le_path, $dragblock_le_dep = array() ) {
	// dev-reply#453.
	$dragblock_le_asset = include $dragblock_le_path . 'index.asset.php';
	// dev-reply#457.
	foreach ( $dragblock_le_asset['dependencies'] as $dragblock_le_file ) {
		wp_enqueue_style( $dragblock_le_file );
	}
	foreach ( $dragblock_le_asset['dependencies'] as $dragblock_le_style ) {
		array_push( $dragblock_le_dep, $dragblock_le_style );
	}
	// dev-reply#465.
	array_push( $dragblock_le_asset['dependencies'], 'wp-i18n' );
	$dragblock_le_script = str_replace( DRAGBLOCK_PATH, '', $dragblock_le_path );
	dragblock_enqueue( $dragblock_le_path, $dragblock_le_script . 'index.css', $dragblock_le_dep );
	dragblock_enqueue( $dragblock_le_path, $dragblock_le_script . 'index.js', $dragblock_le_dep );
}
