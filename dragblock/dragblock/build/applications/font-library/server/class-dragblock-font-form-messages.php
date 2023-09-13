<?php
/**
 * DragBlock's Font-library.
 *
 * @package Class dragblock font form messages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check class-def#132
 */
class DragBlock_Font_Form_Messages {
	/**
	 * Check Documentation#134
	 */
	public static function admin_notice_embed_font_success() {
		// dev-reply#137.
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_1 = '';
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			isset( $_POST['selection-data'] )
		) {
			$dragblock_2 = json_decode( sanitize_text_field( wp_unslash( $_POST['selection-data'] ) ), true );
			if ( ! empty( $dragblock_2 ) ) {
				$dragblock_3 = array();
				foreach ( $dragblock_2 as $dragblock_1 ) {
					$dragblock_3[] = $dragblock_1['family'];
				}
				$dragblock_1 = implode( ', ', $dragblock_3 );
			}
		}
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			isset( $_POST['font-name'] )
		) {
			$dragblock_1 = sanitize_text_field( wp_unslash( $_POST['font-name'] ) );
		}
		$dragblock_1 = esc_html( $dragblock_1 );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#1332 */
		$dragblock_4 = sprintf( esc_html__( '%1$s font added to the DragBlock\'s font library.', 'dragblock' ), $dragblock_1, $dragblock_0 );
		$dragblock_5 = esc_attr( 'admin.php?page=' . DRAGBLOCK_FONT_LIB_SLUG );
		$dragblock_6 = "<a href=\"{$dragblock_5}\">" . esc_html__( 'Font Library', 'dragblock' ) . '</a>';
		$dragblock_7 = "<div class=\"notice notice-success is-dismissible\"><p>{$dragblock_4}{$dragblock_6}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#1338
	 */
	public static function admin_notice_embed_font_permission_error() {
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_1 = '';
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			isset( $_POST['selection-data'] )
		) {
			$dragblock_2 = json_decode( sanitize_text_field( wp_unslash( $_POST['selection-data'] ) ), true );
			if ( ! empty( $dragblock_2 ) && ! empty( $dragblock_2['family'] ) ) {
				$dragblock_1 = $dragblock_2['family'];
			}
		}
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			isset( $_POST['font-name'] )
		) {
			$dragblock_1 = sanitize_text_field( wp_unslash( $_POST['font-name'] ) );
		}
		$dragblock_1 = esc_html( $dragblock_1 );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#1361 */
		$dragblock_4 = sprintf( esc_html__( 'Error adding %1$s font to the DragBlock\'s font library. WordPress lack permissions to write the font assets.', 'dragblock' ), $dragblock_1, $dragblock_0 );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#1365
	 */
	public static function admin_notice_embed_font_file_error() {
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_1 = '';
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			isset( $_POST['font-name'] )
		) {
			$dragblock_1 = sanitize_text_field( wp_unslash( $_POST['font-name'] ) );
		}
		$dragblock_1 = esc_html( $dragblock_1 );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#1378 */
		$dragblock_4 = sprintf( esc_html__( 'Error adding %1$s font to the DragBlock\'s font library. The uploaded file is not valid.', 'dragblock' ), $dragblock_1, $dragblock_0 );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#1382
	 */
	public static function admin_notice_font_asset_removal_error() {
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#1386 */
		$dragblock_4 = sprintf( esc_html__( 'Error removing font asset. WordPress lacks permissions to remove these font assets.', 'dragblock' ), $dragblock_0 );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#1390
	 */
	public static function admin_notice_manage_fonts_permission_error() {
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#1394 */
		$dragblock_4 = sprintf( esc_html__( 'Error handling font changes. WordPress lack permissions to manage the font assets.', 'dragblock' ), $dragblock_0 );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#1398
	 */
	public static function admin_notice_delete_font_success() {
		$dragblock_0 = wp_get_theme()->get( 'Name' );
		$dragblock_0 = esc_html( $dragblock_0 );
		/* translators: see trans-note#13102 */
		$dragblock_4 = sprintf( esc_html__( 'Font definition removed from the DragBlock\'s font library.', 'dragblock' ), $dragblock_0 );
		$dragblock_7 = "<div class=\"notice notice-success is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#13106
	 */
	public static function admin_notice_file_edit_error() {
		$dragblock_4 = esc_html( 'Error: `DISALLOW_FILE_EDIT` cannot be enabled in wp-config.php to make modifications to local files.' );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
	/**
	 * Check Documentation#13112
	 */
	public static function admin_notice_user_cant_edit_theme() {
		$dragblock_4 = esc_html( 'Error: You do not have sufficient permission to edit local files.' );
		$dragblock_7 = "<div class=\"notice notice-error is-dismissible\"><p>{$dragblock_4}</p></div>";
		echo wp_kses_post( $dragblock_7 );
	}
}
