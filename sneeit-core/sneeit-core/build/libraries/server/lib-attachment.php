<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib attachment
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#112
 *
 * @param object|array|string $sneeit_core_la_old check var-def#112.
 * @param object|array|string $sneeit_core_la_src check var-def#112.
 */
function sneeit_core_update_attachment( $sneeit_core_la_old, $sneeit_core_la_src ) {
	$sneeit_core_la_new = attachment_url_to_postid( $sneeit_core_la_old );
	if ( ! $sneeit_core_la_new ) return;
	// dev-reply#1112.
	$sneeit_core_la_attachment = get_post( $sneeit_core_la_new );
	$sneeit_core_la_id = $sneeit_core_la_attachment->post_parent ? $sneeit_core_la_attachment->post_parent : null;
	$sneeit_core_la_post = sneeit_core_download_image( $sneeit_core_la_src, $sneeit_core_la_id );
	if ( ! $sneeit_core_la_post ) {
		sneeit_core_ajax_error_die( 'Cannot download image ' . $sneeit_core_la_src );
		return false;
	}
	// dev-reply#1122.
	$sneeit_core_la_path = wp_get_attachment_metadata( $sneeit_core_la_new );
	if ( $sneeit_core_la_path && isset( $sneeit_core_la_path['file'] ) ) {
		$sneeit_core_la_meta = get_attached_file( $sneeit_core_la_new );
		if ( $sneeit_core_la_meta && file_exists( $sneeit_core_la_meta ) ) {
			// dev-reply#1127.
			wp_delete_file( $sneeit_core_la_meta );
		}
		foreach ( $sneeit_core_la_path['sizes'] as $sneeit_core_la_size ) {
			$sneeit_core_la_download = path_join( dirname( $sneeit_core_la_meta ), $sneeit_core_la_size['file'] );
			if ( $sneeit_core_la_download && file_exists( $sneeit_core_la_download ) ) {
				wp_delete_file( $sneeit_core_la_download );
			}
		}
	}
	$sneeit_core_la_meta = wp_upload_dir()['basedir'] . '/' . $sneeit_core_la_path['file'];
	if ( ( empty( $sneeit_core_la_id ) || strpos( $sneeit_core_la_meta, '--blank.png' ) === false ) && ( $sneeit_core_la_meta ) !== $sneeit_core_la_post ) {
		// dev-reply#1143.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
		if ( ! copy( $sneeit_core_la_post, $sneeit_core_la_meta ) ) {
			sneeit_core_ajax_error_die( 'Cannot copy to desired path for ' . $sneeit_core_la_src );
		}
		wp_delete_file( $sneeit_core_la_post );
		$sneeit_core_la_post = $sneeit_core_la_meta;
	}
	// dev-reply#1158.
	delete_post_meta( $sneeit_core_la_new, '_wp_attachment_metadata' );
	// dev-reply#1161.
	$sneeit_core_la_short = wp_generate_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_post );
	if ( is_wp_error( $sneeit_core_la_short ) ) {
		sneeit_core_ajax_error_die( 'Cannot generate meta for ' . $sneeit_core_la_src . ': ' . $sneeit_core_la_short->get_error_message() );
	}
	// dev-reply#1167.
	wp_update_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_short );
	update_attached_file( $sneeit_core_la_new, $sneeit_core_la_post );
	update_post_meta( $sneeit_core_la_new, 'sneeit-demo', $sneeit_core_la_src );
	return true;
}
/**
 * Check Documentation#1153
 *
 * @param object|array|string $sneeit_core_la_name check var-def#1153.
 * @param object|array|string $sneeit_core_la_id check var-def#1153.
 */
function sneeit_core_download_image( $sneeit_core_la_name, $sneeit_core_la_id = null ) {
	$sneeit_core_la_ext = download_url( $sneeit_core_la_name );
	if ( is_wp_error( $sneeit_core_la_ext ) ) {
		sneeit_core_ajax_error_die( 'Cannot download ' . $sneeit_core_la_name );
	}
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_la_post = wp_upload_dir()['path'] . '/' . sneeit_core_unique_image_name( $sneeit_core_la_name, $sneeit_core_la_id );
	if ( ! copy( $sneeit_core_la_ext, $sneeit_core_la_post ) ) {
		unlink( $sneeit_core_la_ext );
		sneeit_core_ajax_error_die( 'Cannot copy file ' . $sneeit_core_la_ext . ' of ' . $sneeit_core_la_name . ' to ' . $sneeit_core_la_post );
	}
	unlink( $sneeit_core_la_ext );
	// dev-reply#1197.
	return $sneeit_core_la_post;
}
/**
 * Check Documentation#1170
 *
 * @param object|array|string $sneeit_core_la_name check var-def#1170.
 * @param object|array|string $sneeit_core_la_id check var-def#1170.
 */
function sneeit_core_unique_image_name( $sneeit_core_la_name, $sneeit_core_la_id = null ) {
	// dev-reply#11144.
	$sneeit_core_la_finalname = basename( $sneeit_core_la_name );
	$sneeit_core_la_part = pathinfo( $sneeit_core_la_finalname, PATHINFO_EXTENSION );
	if ( $sneeit_core_la_part ) {
		$sneeit_core_la_part = '.' . $sneeit_core_la_part;
	}
	$sneeit_core_la_finalname = str_replace( $sneeit_core_la_part, '', $sneeit_core_la_finalname );
	// dev-reply#11152.
	$sneeit_core_la_finalname = preg_replace( '/[^a-zA-Z0-9]+/', '-', $sneeit_core_la_finalname );
	$sneeit_core_la_finalname = explode( '-', $sneeit_core_la_finalname );
	// dev-reply#11155.
	$sneeit_core_la_src_old = '';
	foreach ( $sneeit_core_la_finalname as $sneeit_core_la_src_src ) {
		if ( preg_match( '/\d/', $sneeit_core_la_src_src ) ) {
			continue;
		}
		$sneeit_core_la_src_old .= ( strlen( $sneeit_core_la_src_old ) ? '-' : '' ) . $sneeit_core_la_src_src;
	}
	if ( strlen( $sneeit_core_la_src_old ) > 50 || strlen( $sneeit_core_la_src_old ) < 10 ) {
		$sneeit_core_la_src_new = get_post( $sneeit_core_la_id );
		if ( ! empty( $sneeit_core_la_src_new ) && ! empty( $sneeit_core_la_src_new->post_title ) ) {
			$sneeit_core_la_src_old = sneeit_core_text_to_slug( $sneeit_core_la_src_new->post_title );
		}
	}
	$sneeit_core_la_finalname = $sneeit_core_la_src_old . '-' . time() . ( $sneeit_core_la_id ? '-' . $sneeit_core_la_id : '' ) . $sneeit_core_la_part;
	return $sneeit_core_la_finalname;
}
