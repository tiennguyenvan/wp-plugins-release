<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib ajax
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#42
 *
 * @param object|array|string $sneeit_core_la_action check var-def#42.
 * @param object|array|string $sneeit_core_la_callback check var-def#42.
 */
function sneeit_core_ajax_register( $sneeit_core_la_action, $sneeit_core_la_callback ) {
	if ( is_admin() ) :
		add_action( 'wp_ajax_nopriv_' . $sneeit_core_la_action, $sneeit_core_la_callback );
		add_action( 'wp_ajax_' . $sneeit_core_la_action, $sneeit_core_la_callback );
	endif; // dev-reply#411.
}
/**
 * Check Documentation#48
 *
 * @param object|array|string $sneeit_core_la_fields check var-def#48.
 * @param object|array|string $sneeit_core_la_check check var-def#48.
 */
function sneeit_core_ajax_request_verify_die( $sneeit_core_la_fields = array(), $sneeit_core_la_check = false ) {
	if ( $sneeit_core_la_check && empty( $_POST['nonce'] ) ) {
		sneeit_core_ajax_error_die( 'empty nonce' );
	}
	if ( $sneeit_core_la_check && ! wp_verify_nonce( $_POST['nonce'], SNEEIT_CORE_KEY_NONCE ) ) {
		sneeit_core_ajax_error_die( 'wrong nonce' );
	}
	if ( is_string( $sneeit_core_la_fields ) ) {
		$sneeit_core_la_fields = explode( ',', $sneeit_core_la_fields );
	}
	foreach ( $sneeit_core_la_fields as $sneeit_core_la_nonce ) {
		$sneeit_core_la_nonce = trim( $sneeit_core_la_nonce );
		if ( ! isset( $_POST[ $sneeit_core_la_nonce ] ) ) {
			sneeit_core_ajax_error_die( 'missing required field: ' . $sneeit_core_la_nonce );
		}
	}
}
/**
 * Check Documentation#426
 *
 * @param object|array|string $sneeit_core_la_action check var-def#426.
 */
function sneeit_core_ajax_error_die( $sneeit_core_la_action ) {
	echo json_encode( array( 'error' => $sneeit_core_la_action ) );
	die();
}
/**
 * Check Documentation#431
 *
 * @param object|array|string $sneeit_core_la_post check var-def#431.
 */
function sneeit_core_ajax_succeed_die( $sneeit_core_la_post ) {
	echo json_encode( $sneeit_core_la_post );
	die();
}
