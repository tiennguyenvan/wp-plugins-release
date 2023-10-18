<?php
/**
 * DragBlock's Library.
 *
 * @package Lib ajax
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#42
 *
 * @param object|array|string $dragblock_la_action check var-def#42.
 * @param object|array|string $dragblock_la_callback check var-def#42.
 */
function dragblock_ajax_register( $dragblock_la_action, $dragblock_la_callback ) {
	if ( is_admin() ) :
		add_action( 'wp_ajax_nopriv_' . $dragblock_la_action, $dragblock_la_callback );
		add_action( 'wp_ajax_' . $dragblock_la_action, $dragblock_la_callback );
	endif; // dev-reply#411.
}
/**
 * Check Documentation#49
 *
 * @param object|array|string $dragblock_la_text check var-def#49.
 */
function dragblock_ajax_error_die( $dragblock_la_text ) {
	echo json_encode( array( 'error' => $dragblock_la_text ) );
	die();
}
/**
 * Check Documentation#414
 *
 * @param object|array|string $dragblock_la_fields check var-def#414.
 */
function dragblock_ajax_request_verify_die( $dragblock_la_fields = array() ) {
	if ( empty( $_POST['nonce'] ) ) {
		dragblock_ajax_error_die( esc_html__( 'Empty nonce', 'dragblock' ) );
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), DRAGBLOCK_NONCE_SLUG ) ) {
		dragblock_ajax_error_die( esc_html__( 'Timeout! Please reload the page.', 'dragblock' ) );
	}
	if ( is_string( $dragblock_la_fields ) ) {
		$dragblock_la_fields = explode( ',', $dragblock_la_fields );
	}
	if ( ! empty( $dragblock_la_fields ) ) {
		foreach ( $dragblock_la_fields as $dragblock_la_post ) {
			$dragblock_la_post = trim( $dragblock_la_post );
			if ( ! isset( $_POST[ $dragblock_la_post ] ) ) {
				/* translators: see trans-note#429 */
				dragblock_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'dragblock' ), $dragblock_la_post ) );
			}
		}
	}
}
/**
 * Check Documentation#434
 *
 * @param object|array|string $dragblock_la_field check var-def#434.
 */
function dragblock_ajax_succeed_die( $dragblock_la_field ) {
	echo json_encode( $dragblock_la_field );
	die();
}
