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
add_action( 'init', 'dragblock_form_submission', 100 );
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
		! isset( $_POST[ DRAGBLOCK_FORM_TITLE_FIELD_NAME ] ) ||
		// dev-reply#1228.
		! empty( $_POST[ DRAGBLOCK_FORM_TITLE_FIELD_NAME ] ) ||
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
	$dragblock_fs_post = sanitize_text_field( wp_unslash( $_POST['dragblock/form-session-token'] ) );
	if ( empty( $_SESSION[ $dragblock_fs_post ] ) ) {
		return;
	}
	$dragblock_fs_unique = sanitize_text_field( wp_unslash( $_SESSION[ $dragblock_fs_post ] ) );
	// dev-reply#1251.
	if ( ! $dragblock_fs_unique || time() - $dragblock_fs_unique < 1 ) {
		return;
	}
	// dev-reply#1256.
	$dragblock_fs_id = '';
	if ( isset( $_POST[ DRAGBLOCK_FORM_CLIENT_ID_FIELD_NAME ] ) ) {
		$dragblock_fs_id = sanitize_text_field( wp_unslash( $_POST[ DRAGBLOCK_FORM_CLIENT_ID_FIELD_NAME ] ) );
	} else {
		$dragblock_fs_id = 'dragblock-form-unorganized';
	}
	// dev-reply#1265.
	unset( $_POST[ DRAGBLOCK_FORM_CLIENT_ID_FIELD_NAME ] );
	unset( $_POST['dragblock/form-nonce-field'] );
	unset( $_POST['dragblock/form-session-token'] );
	unset( $_POST[ DRAGBLOCK_FORM_TITLE_FIELD_NAME ] );
	unset( $_POST['submit'] );
	// dev-reply#1273.
	global $dragblock_form_entries_message_error;
	$dragblock_form_entries_message_error[ $dragblock_fs_id ] = false; // dev-reply#1275.
	$dragblock_fs_session = get_transient( 'dragblock/form-transient-' . $dragblock_fs_id );
	$dragblock_fs_createdformtime = array();
	foreach ( $_POST as $dragblock_fs_formclientid => $dragblock_fs_dragblock ) {
		$dragblock_fs_createdformtime[ sanitize_text_field( $dragblock_fs_formclientid ) ] = sanitize_textarea_field( wp_unslash( $dragblock_fs_dragblock ) );
	}
	$dragblock_fs_form = sha1( http_build_query( $dragblock_fs_createdformtime ) );
	if ( ( $dragblock_fs_session ) === $dragblock_fs_form ) {
		set_transient( 'dragblock/form-transient-' . $dragblock_fs_id, $dragblock_fs_form, 3600 );
		$dragblock_form_entries_message_error[ $dragblock_fs_id ] = esc_html__( 'Duplicate submission', 'dragblock' );
		return;
	}
	set_transient( 'dragblock/form-transient-' . $dragblock_fs_id, $dragblock_fs_form, 3600 );
	// dev-reply#1293.
	$dragblock_fs_entries = wp_insert_post(
		array(
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_type'     => DRAGBLOCK_FORM_ENTRY,
		)
	);
	if ( is_wp_error( $dragblock_fs_entries ) ) {
		// dev-reply#12103.
		$dragblock_form_entries_message_error[ $dragblock_fs_id ] = $dragblock_fs_entries->get_error_message();
		return;
	}
	$dragblock_fs_message = '';
	$dragblock_fs_error = ucwords( str_replace( '-', ' ', sanitize_title( $dragblock_fs_id ) ) ) . ': #' . $dragblock_fs_entries;
	$dragblock_fs_transienthash = array();
	foreach ( $dragblock_fs_createdformtime as $dragblock_fs_formclientid => $dragblock_fs_dragblock ) {
		// dev-reply#12144.
		if ( strpos( $dragblock_fs_formclientid, DRAGBLOCK_WP_RESEVED_TERMS_PLACEHOLDER ) !== false ) {
			$dragblock_fs_formclientid = str_replace( DRAGBLOCK_WP_RESEVED_TERMS_PLACEHOLDER, '', $dragblock_fs_formclientid );
		}
		if ( '_wp_http_referer' !== $dragblock_fs_formclientid ) {
			$dragblock_fs_message .= '<p><strong>' . esc_html( $dragblock_fs_formclientid ) . ':</strong> ' . esc_html( $dragblock_fs_dragblock ) . '</p>';
		}
		array_push( $dragblock_fs_transienthash, $dragblock_fs_formclientid );
		// dev-reply#12154.
		update_post_meta( $dragblock_fs_entries, DRAGBLOCK_FORM_ENTRY . '--' . $dragblock_fs_formclientid, $dragblock_fs_dragblock );
	}
	// dev-reply#12158.
	update_post_meta( $dragblock_fs_entries, DRAGBLOCK_FORM_ENTRY . '-keys', $dragblock_fs_transienthash );
	wp_update_post(
		array(
			'ID' => $dragblock_fs_entries,
			'post_title' => $dragblock_fs_error,
			'post_content' => $dragblock_fs_message,
		)
	);
	// dev-reply#12171.
	$dragblock_fs_sanitized = get_option( 'admin_email' );
	$dragblock_fs_key = array( 'Content-Type: text/html; charset=UTF-8' );
	$dragblock_fs_value = get_bloginfo( 'name' ) . ' - DragBlock Form – ' . $dragblock_fs_error;
	if ( DRAGBLOCK_IS_LOCAL ) {
		return;
	}
	// dev-reply#12184.
	if ( ! wp_mail( $dragblock_fs_sanitized, $dragblock_fs_value, $dragblock_fs_message, $dragblock_fs_key ) ) {
		// dev-reply#12187.
		update_post_meta( $dragblock_fs_entries, DRAGBLOCK_FORM_ENTRY . '-failed-email', time() );
		return;
	}
	update_post_meta( $dragblock_fs_entries, DRAGBLOCK_FORM_ENTRY . '-failed-email', 'PASSED' );
	// dev-reply#12193.
}
