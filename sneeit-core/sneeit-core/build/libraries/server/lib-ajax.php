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
 * @param object|array|string $sneeit_core_la_text check var-def#48.
 */
function sneeit_core_ajax_error_die( $sneeit_core_la_text ) {
	echo json_encode( array( 'error' => $sneeit_core_la_text ) );
	die();
}
/**
 * Check Documentation#413
 *
 * @param object|array|string $sneeit_core_la_fields check var-def#413.
 */
function sneeit_core_ajax_request_verify_die( $sneeit_core_la_fields = array() ) {
	if ( empty( $_POST['nonce'] ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'empty nonce', 'sneeit-core' ) );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], SNEEIT_CORE_KEY_NONCE ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'Timeout! Please reload the page.', 'sneeit-core' ) );
	}
	if ( is_string( $sneeit_core_la_fields ) ) {
		$sneeit_core_la_fields = explode( ',', $sneeit_core_la_fields );
	}
	if ( ! empty( $sneeit_core_la_fields ) ) {
		foreach ( $sneeit_core_la_fields as $sneeit_core_la_post ) {
			$sneeit_core_la_post = trim( $sneeit_core_la_post );
			if ( ! isset( $_POST[ $sneeit_core_la_post ] ) ) {
				/* translators: see trans-note#428 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'sneeit-core' ), $sneeit_core_la_post ) );
			}
		}
	}
}
/**
 * Check Documentation#433
 *
 * @param object|array|string $sneeit_core_la_field check var-def#433.
 */
function sneeit_core_ajax_succeed_die( $sneeit_core_la_field ) {
	echo json_encode( $sneeit_core_la_field );
	die();
}
