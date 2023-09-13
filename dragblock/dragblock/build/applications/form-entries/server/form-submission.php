<?php
/**
 * DragBlock's Form-entries.
 *
 * @package Form submission
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#124.
add_action( 'init', 'dragblock_form_submission', 1 );
// dev-reply#126.
/**
 * Check Documentation#125
 */
function dragblock_form_submission() {
	// dev-reply#1213.
	if (
		empty( $_POST['dragblock/form-nonce-field'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dragblock/form-nonce-field'] ) ), 'dragblock/form-nonce-action' )
	) {
		return;
	}
	// dev-reply#1221.
	if (
		// dev-reply#1225.
		! isset( $_POST['dragblock/form-title'] ) ||
		// dev-reply#1228.
		! empty( $_POST['dragblock/form-title'] ) ||
		// dev-reply#1231.
		empty( $_POST['dragblock/form-session-token'] )
	) {
		return;
	}
	// dev-reply#1238.
	if ( ! session_id() ) {
		session_start();
	}
	// dev-reply#1244.
	$dragblock_0 = sanitize_text_field( wp_unslash( $_POST['dragblock/form-session-token'] ) );
	if ( empty( $_SESSION[ $dragblock_0 ] ) ) {
		return;
	}
	$dragblock_1 = sanitize_text_field( wp_unslash( $_SESSION[ $dragblock_0 ] ) );
	// dev-reply#1251.
	if ( ! $dragblock_1 || time() - $dragblock_1 < 1 ) {
		return;
	}
	// dev-reply#1256.
	$dragblock_2 = '';
	if ( isset( $_POST['dragblock/form-client-id'] ) ) {
		$dragblock_2 = sanitize_text_field( wp_unslash( $_POST['dragblock/form-client-id'] ) );
	} else {
		$dragblock_2 = 'dragblock-form-unorganized';
	}
	// dev-reply#1265.
	unset( $_POST['dragblock/form-client-id'] );
	unset( $_POST['dragblock/form-nonce-field'] );
	unset( $_POST['dragblock/form-session-token'] );
	unset( $_POST['dragblock/form-title'] );
	unset( $_POST['submit'] );
	// dev-reply#1273.
	global $dragblock_form_entries_message_error;
	$dragblock_form_entries_message_error[ $dragblock_2 ] = false; // dev-reply#1275.
	$dragblock_3 = get_transient( 'dragblock/form-transient-' . $dragblock_2 );
	$dragblock_4 = sha1( http_build_query( $_POST ) );
	if ( ( $dragblock_3 ) === $dragblock_4 ) {
		set_transient( 'dragblock/form-transient-' . $dragblock_2, $dragblock_4, 3600 );
		$dragblock_form_entries_message_error[ $dragblock_2 ] = esc_html__( 'Duplicate submission', 'dragblock' );
		return;
	}
	set_transient( 'dragblock/form-transient-' . $dragblock_2, $dragblock_4, 3600 );
	// dev-reply#1288.
	$dragblock_5 = wp_insert_post(
		array(
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_type'     => DRAGBLOCK_FORM_ENTRY,
		)
	);
	if ( is_wp_error( $dragblock_5 ) ) {
		// dev-reply#1298.
		$dragblock_form_entries_message_error[ $dragblock_2 ] = $dragblock_5->get_error_message();
		return;
	}
	$dragblock_6 = '';
	$dragblock_7 = ucwords( str_replace( '-', ' ', sanitize_title( $dragblock_2 ) ) ) . ': #' . $dragblock_5;
	$dragblock_8 = array();
	foreach ( $_POST as $dragblock_9 => $dragblock_10 ) {
		$dragblock_10 = wp_unslash( $dragblock_10 );
		// dev-reply#12139.
		if ( strpos( $dragblock_9, '__dragblock_wp_reseved_terms' ) !== false ) {
			$dragblock_9 = str_replace( '__dragblock_wp_reseved_terms', '', $dragblock_9 );
		}
		if ( '_wp_http_referer' !== $dragblock_9 ) {
			$dragblock_6 .= '<p><strong>' . esc_html( $dragblock_9 ) . ':</strong> ' . esc_html( $dragblock_10 ) . '</p>';
		}
		array_push( $dragblock_8, sanitize_text_field( $dragblock_9 ) );
		// dev-reply#12149.
		update_post_meta( $dragblock_5, DRAGBLOCK_FORM_ENTRY . '--' . sanitize_text_field( $dragblock_9 ), sanitize_text_field( $dragblock_10 ) );
	}
	// dev-reply#12153.
	update_post_meta( $dragblock_5, DRAGBLOCK_FORM_ENTRY . '-keys', $dragblock_8 );
	wp_update_post(
		array(
			'ID' => $dragblock_5,
			'post_title' => $dragblock_7,
			'post_content' => $dragblock_6,
		)
	);
	// dev-reply#12166.
	$dragblock_11 = get_option( 'admin_email' );
	$dragblock_12 = array( 'Content-Type: text/html; charset=UTF-8' );
	$dragblock_13 = get_bloginfo( 'name' ) . ' - DragBlock Form – ' . $dragblock_7;
	if ( DRAGBLOCK_IS_LOCAL ) {
		return;
	}
	// dev-reply#12179.
	if ( ! wp_mail( $dragblock_11, $dragblock_13, $dragblock_6, $dragblock_12 ) ) {
		// dev-reply#12182.
		update_post_meta( $dragblock_5, DRAGBLOCK_FORM_ENTRY . '-failed-email', time() );
		return;
	}
	update_post_meta( $dragblock_5, DRAGBLOCK_FORM_ENTRY . '-failed-email', 'PASSED' );
	// dev-reply#12188.
}
