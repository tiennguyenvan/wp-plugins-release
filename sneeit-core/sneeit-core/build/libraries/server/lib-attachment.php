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
 * Check Documentation#192
 *
 * @param object|array|string $sneeit_core_la_old check var-def#192.
 * @param object|array|string $sneeit_core_la_src check var-def#192.
 */
function sneeit_core_update_attachment( $sneeit_core_la_old, $sneeit_core_la_src ) {
	$sneeit_core_la_new = attachment_url_to_postid( $sneeit_core_la_old );
	if ( ! $sneeit_core_la_new ) return;
	// dev-reply#1912.
	$sneeit_core_la_attachment = get_post( $sneeit_core_la_new );
	$sneeit_core_la_id = $sneeit_core_la_attachment->post_parent ? $sneeit_core_la_attachment->post_parent : null;
	$sneeit_core_la_post = sneeit_core_download_image( $sneeit_core_la_src, $sneeit_core_la_id );
	if ( ! $sneeit_core_la_post ) {
		sneeit_core_ajax_error_die( 'Cannot download image ' . $sneeit_core_la_src );
		return false;
	}
	// dev-reply#1922.
	$sneeit_core_la_path = wp_get_attachment_metadata( $sneeit_core_la_new );
	if ( $sneeit_core_la_path && isset( $sneeit_core_la_path['file'] ) ) {
		$sneeit_core_la_meta = get_attached_file( $sneeit_core_la_new );
		if ( $sneeit_core_la_meta && file_exists( $sneeit_core_la_meta ) ) {
			// dev-reply#1927.
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
		// dev-reply#1943.
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
		if ( ! copy( $sneeit_core_la_post, $sneeit_core_la_meta ) ) {
			sneeit_core_ajax_error_die( 'Cannot copy to desired path for ' . $sneeit_core_la_src );
		}
		wp_delete_file( $sneeit_core_la_post );
		$sneeit_core_la_post = $sneeit_core_la_meta;
	}
	// dev-reply#1958.
	delete_post_meta( $sneeit_core_la_new, '_wp_attachment_metadata' );
	// dev-reply#1961.
	$sneeit_core_la_upload = wp_generate_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_post );
	if ( is_wp_error( $sneeit_core_la_upload ) ) {
		sneeit_core_ajax_error_die( 'Cannot generate meta for ' . $sneeit_core_la_src . ': ' . $sneeit_core_la_upload->get_error_message() );
	}
	// dev-reply#1967.
	wp_update_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_upload );
	update_attached_file( $sneeit_core_la_new, $sneeit_core_la_post );
	update_post_meta( $sneeit_core_la_new, 'sneeit-demo', $sneeit_core_la_src );
	return true;
}
/**
 * Check Documentation#1953
 *
 * @param object|array|string $sneeit_core_la_ext check var-def#1953.
 * @param object|array|string $sneeit_core_la_info check var-def#1953.
 */
function sneeit_core_download_image( $sneeit_core_la_ext, $sneeit_core_la_info = null ) {
	// dev-reply#1983.
	$sneeit_core_la_width = download_url( $sneeit_core_la_ext );
	if ( is_wp_error( $sneeit_core_la_width ) ) {
		// dev-reply#1986.
		return false;
	}
	// dev-reply#1990.
	$sneeit_core_la_height = wp_upload_dir()['path'] . '/' . sneeit_core_unique_image_name( $sneeit_core_la_ext, $sneeit_core_la_info );
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	if ( ! rename( $sneeit_core_la_width, $sneeit_core_la_height ) ) {
		unlink( $sneeit_core_la_width );
		return false;
	}
	// dev-reply#19102.
	$sneeit_core_la_editor = pathinfo( $sneeit_core_la_height, PATHINFO_EXTENSION );
	$sneeit_core_la_resized = getimagesize( $sneeit_core_la_height );
	if ( empty( $sneeit_core_la_resized ) || count( $sneeit_core_la_resized ) < 2 ) {
		// dev-reply#19108.
		return false;
	}
	$sneeit_core_la_saved = (int) $sneeit_core_la_resized[0];
	$sneeit_core_la_short = (int) $sneeit_core_la_resized[1];
	if ( empty( $sneeit_core_la_editor ) || ( $sneeit_core_la_editor ) === 'webp' || ( $sneeit_core_la_editor ) === 'avif' || $sneeit_core_la_saved > 2560 || $sneeit_core_la_short > 2560 ) {
		$sneeit_core_la_saved = min( (int) $sneeit_core_la_resized[0], 2560 );
		$sneeit_core_la_short = min( (int) $sneeit_core_la_resized[1], 2560 );
		$sneeit_core_la_name = wp_get_image_editor( $sneeit_core_la_height );
		if ( is_wp_error( $sneeit_core_la_name ) ) {
			// dev-reply#19120.
			return false;
		}
		$sneeit_core_la_finalname = $sneeit_core_la_name->resize( $sneeit_core_la_saved, $sneeit_core_la_short );
		if ( is_wp_error( $sneeit_core_la_finalname ) ) {
			// dev-reply#19125.
			return false;
		}
		$sneeit_core_la_part = $sneeit_core_la_name->save( $sneeit_core_la_name->generate_filename() );
		if ( is_wp_error( $sneeit_core_la_part ) ) {
			// dev-reply#19130.
			return false;
		}
		if ( ( $sneeit_core_la_height ) !== $sneeit_core_la_part['path'] ) {
			unlink( $sneeit_core_la_height );
			$sneeit_core_la_height = $sneeit_core_la_part['path'];
		}
	}
	return $sneeit_core_la_height;
}
/**
 * Check Documentation#19103
 *
 * @param object|array|string $sneeit_core_la_ext check var-def#19103.
 * @param object|array|string $sneeit_core_la_id check var-def#19103.
 */
function sneeit_core_unique_image_name( $sneeit_core_la_ext, $sneeit_core_la_id = null ) {
	// dev-reply#19150.
	$sneeit_core_la_file = basename( $sneeit_core_la_ext );
	$sneeit_core_la_editor = pathinfo( $sneeit_core_la_file, PATHINFO_EXTENSION );
	if ( $sneeit_core_la_editor ) {
		$sneeit_core_la_editor = '.' . $sneeit_core_la_editor;
	}
	$sneeit_core_la_file = str_replace( $sneeit_core_la_editor, '', $sneeit_core_la_file );
	// dev-reply#19158.
	$sneeit_core_la_file = preg_replace( '/[^a-zA-Z0-9]+/', '-', $sneeit_core_la_file );
	$sneeit_core_la_file = explode( '-', $sneeit_core_la_file );
	// dev-reply#19161.
	$sneeit_core_la_url = '';
	foreach ( $sneeit_core_la_file as $sneeit_core_la_type ) {
		if ( preg_match( '/\d/', $sneeit_core_la_type ) ) {
			continue;
		}
		$sneeit_core_la_url .= ( strlen( $sneeit_core_la_url ) ? '-' : '' ) . $sneeit_core_la_type;
	}
	if ( strlen( $sneeit_core_la_url ) > 50 || strlen( $sneeit_core_la_url ) < 10 ) {
		$sneeit_core_la_args = get_post( $sneeit_core_la_id );
		if ( ! empty( $sneeit_core_la_args ) && ! empty( $sneeit_core_la_args->post_title ) ) {
			$sneeit_core_la_url = sneeit_core_text_to_slug( $sneeit_core_la_args->post_title );
		}
	}
	$sneeit_core_la_file = ( $sneeit_core_la_url ? $sneeit_core_la_url . '-' : '' ) . time() . ( $sneeit_core_la_id ? '-' . $sneeit_core_la_id : '' ) . $sneeit_core_la_editor;
	return $sneeit_core_la_file;
}
/**
 * Check Documentation#19132
 *
 * @param object|array|string $sneeit_core_la_src_old check var-def#19132.
 * @param object|array|string $sneeit_core_la_id check var-def#19132.
 * @param object|array|string $sneeit_core_la_src_src check var-def#19132.
 */
function sneeit_core_create_attachment( $sneeit_core_la_src_old, $sneeit_core_la_id = null, $sneeit_core_la_src_src = null ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	( ! $sneeit_core_la_src_src ) && ( $sneeit_core_la_src_src = sneeit_core_unique_image_name( $sneeit_core_la_src_old, $sneeit_core_la_info ) );
	$sneeit_core_la_src_new = wp_upload_dir()['path'] . '/' . $sneeit_core_la_src_src;
	// dev-reply#19198.
	if ( ( $sneeit_core_la_src_new ) !== $sneeit_core_la_src_old ) {
		if ( ! copy( $sneeit_core_la_src_old, $sneeit_core_la_src_new ) ) {
			// dev-reply#19204.
			return false;
		}
		// dev-reply#19208.
		if ( strpos( $sneeit_core_la_src_old, wp_upload_dir()['path'] ) !== false && ( $sneeit_core_la_src_old ) !== SNEEIT_CORE_IMAGE_PATH . 'blank.png' ) {
			// dev-reply#19210.
			unlink( $sneeit_core_la_src_old );
		}
	}
	$sneeit_core_la_src_attachment = wp_upload_dir()['url'] . $sneeit_core_la_src_src; // dev-reply#19215.
	$sneeit_core_la_src_id = wp_check_filetype( $sneeit_core_la_src_new, null );
	$sneeit_core_la_src_post = array(
		'post_mime_type' => $sneeit_core_la_src_id['type'], // dev-reply#19220.
		'guid' => $sneeit_core_la_src_attachment,
		'post_title' => $sneeit_core_la_src_src,
		'post_content' => '',
		'post_parent' => $sneeit_core_la_id,
	);
	// dev-reply#19228.
	$sneeit_core_la_new = wp_insert_attachment( $sneeit_core_la_src_post, $sneeit_core_la_src_new, $sneeit_core_la_id, true );
	if ( is_wp_error( $sneeit_core_la_new ) ) {
		// dev-reply#19234.
		return false;
	}
	if ( $sneeit_core_la_id ) {
		// dev-reply#19238.
		set_post_thumbnail( $sneeit_core_la_id, $sneeit_core_la_new );
	}
	$sneeit_core_la_src_path = wp_generate_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_src_new );
	wp_update_attachment_metadata( $sneeit_core_la_new, $sneeit_core_la_src_path );
	return $sneeit_core_la_new;
}
