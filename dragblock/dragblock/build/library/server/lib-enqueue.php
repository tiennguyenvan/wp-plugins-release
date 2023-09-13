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
 * Check Documentation#32
 *
 * @param object|array|string $dragblock_0 check var-def#32.
 * @param object|array|string $dragblock_1 check var-def#32.
 * @param object|array|string $dragblock_2 check var-def#32.
 */
function dragblock_enqueue_register( $dragblock_0, $dragblock_1, $dragblock_2 = null ) {
	// dev-reply#39.
	if ( strpos( $dragblock_1, '.js' ) ) {
		wp_register_script(
			$dragblock_0,
			DRAGBLOCK_URL . $dragblock_1,
			$dragblock_2,
			DRAGBLOCK_VERSION,
			true
		);
	} else {
		wp_register_style(
			$dragblock_0,
			DRAGBLOCK_URL . $dragblock_1,
			$dragblock_2,
			DRAGBLOCK_VERSION
		);
	}
}
/**
 * Check Documentation#324
 *
 * @param object|array|string $dragblock_0 check var-def#324.
 * @param object|array|string $dragblock_1 check var-def#324.
 * @param object|array|string $dragblock_2 check var-def#324.
 */
function dragblock_enqueue( $dragblock_0, $dragblock_1, $dragblock_2 = null ) {
	dragblock_enqueue_register( $dragblock_0, $dragblock_1, $dragblock_2 );
	// dev-reply#336.
	if ( strpos( $dragblock_1, '.js' ) ) {
		wp_enqueue_script( $dragblock_0 );
	} else {
		wp_enqueue_style( $dragblock_0 );
	}
}
