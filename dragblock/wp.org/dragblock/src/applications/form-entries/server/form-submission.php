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
	$dragblock_fs_unique_id = sanitize_text_field( wp_unslash( $_POST['dragblock/form-session-token'] ) );
	if ( empty( $_SESSION[ $dragblock_fs_unique_id ] ) ) {
		return;
	}
	$dragblock_fs_createdformtime = sanitize_text_field( wp_unslash( $_SESSION[ $dragblock_fs_unique_id ] ) );
	// dev-reply#1251.
	if ( ! $dragblock_fs_createdformtime || time() - $dragblock_fs_createdformtime < 1 ) {
		return;
	}
	// dev-reply#1256.
	$dragblock_fs_formclientid = '';
	if ( isset( $_POST['dragblock/form-client-id'] ) ) {
		$dragblock_fs_formclientid = sanitize_text_field( wp_unslash( $_POST['dragblock/form-client-id'] ) );
	} else {
		$dragblock_fs_formclientid = 'dragblock-form-unorganized';
	}
	// dev-reply#1265.
	unset( $_POST['dragblock/form-client-id'] );
	unset( $_POST['dragblock/form-nonce-field'] );
	unset( $_POST['dragblock/form-session-token'] );
	unset( $_POST['dragblock/form-title'] );
	unset( $_POST['submit'] );
	// dev-reply#1273.
	global $dragblock_form_entries_message_error;
	$dragblock_form_entries_message_error[ $dragblock_fs_formclientid ] = false; // dev-reply#1275.
	$dragblock_fs_transienthash = get_transient( 'dragblock/form-transient-' . $dragblock_fs_formclientid );
	$dragblock_fs_sanitized_post = array();
	foreach ( $_POST as $dragblock_fs_key => $dragblock_fs_value ) {
		$dragblock_fs_sanitized_post[ sanitize_text_field( $dragblock_fs_key ) ] = sanitize_textarea_field( wp_unslash( $dragblock_fs_value ) );
	}
	$dragblock_fs_newtransienthash = sha1( http_build_query( $dragblock_fs_sanitized_post ) );
	if ( ( $dragblock_fs_transienthash ) === $dragblock_fs_newtransienthash ) {
		set_transient( 'dragblock/form-transient-' . $dragblock_fs_formclientid, $dragblock_fs_newtransienthash, 3600 );
		$dragblock_form_entries_message_error[ $dragblock_fs_formclientid ] = esc_html__( 'Duplicate submission', 'dragblock' );
		return;
	}
	set_transient( 'dragblock/form-transient-' . $dragblock_fs_formclientid, $dragblock_fs_newtransienthash, 3600 );
	// dev-reply#1293.
	$dragblock_fs_post_id = wp_insert_post(
		array(
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_type'     => DRAGBLOCK_FORM_ENTRY,
		)
	);
	if ( is_wp_error( $dragblock_fs_post_id ) ) {
		// dev-reply#12103.
		$dragblock_form_entries_message_error[ $dragblock_fs_formclientid ] = $dragblock_fs_post_id->get_error_message();
		return;
	}
	$dragblock_fs_content = '';
	$dragblock_fs_title = ucwords( str_replace( '-', ' ', sanitize_title( $dragblock_fs_formclientid ) ) ) . ': #' . $dragblock_fs_post_id;
	$dragblock_fs_keys = array();
	foreach ( $dragblock_fs_sanitized_post as $dragblock_fs_key => $dragblock_fs_value ) {
		// dev-reply#12144.
		if ( strpos( $dragblock_fs_key, '__dragblock_wp_reseved_terms' ) !== false ) {
			$dragblock_fs_key = str_replace( '__dragblock_wp_reseved_terms', '', $dragblock_fs_key );
		}
		if ( '_wp_http_referer' !== $dragblock_fs_key ) {
			$dragblock_fs_content .= '<p><strong>' . esc_html( $dragblock_fs_key ) . ':</strong> ' . esc_html( $dragblock_fs_value ) . '</p>';
		}
		array_push( $dragblock_fs_keys, $dragblock_fs_key );
		// dev-reply#12154.
		update_post_meta( $dragblock_fs_post_id, DRAGBLOCK_FORM_ENTRY . '--' . $dragblock_fs_key, $dragblock_fs_value );
	}
	// dev-reply#12158.
	update_post_meta( $dragblock_fs_post_id, DRAGBLOCK_FORM_ENTRY . '-keys', $dragblock_fs_keys );
	wp_update_post(
		array(
			'ID' => $dragblock_fs_post_id,
			'post_title' => $dragblock_fs_title,
			'post_content' => $dragblock_fs_content,
		)
	);
	// dev-reply#12171.
	$dragblock_fs_to = get_option( 'admin_email' );
	$dragblock_fs_headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$dragblock_fs_subject = get_bloginfo( 'name' ) . ' - DragBlock Form – ' . $dragblock_fs_title;
	if ( DRAGBLOCK_IS_LOCAL ) {
		return;
	}
	// dev-reply#12184.
	if ( ! wp_mail( $dragblock_fs_to, $dragblock_fs_subject, $dragblock_fs_content, $dragblock_fs_headers ) ) {
		// dev-reply#12187.
		update_post_meta( $dragblock_fs_post_id, DRAGBLOCK_FORM_ENTRY . '-failed-email', time() );
		return;
	}
	update_post_meta( $dragblock_fs_post_id, DRAGBLOCK_FORM_ENTRY . '-failed-email', 'PASSED' );
	// dev-reply#12193.
}
