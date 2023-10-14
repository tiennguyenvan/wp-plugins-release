<?php
/**
 * DragBlock's General.
 *
 * @package Posts
 */

if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Check Documentation#83
 *
 * @param object|array|string $sneeit_core_p_post check var-def#83.
 */
function sneeit_core_get_demo_post_id( $sneeit_core_p_post = null ) {
	if ( ! $sneeit_core_p_post ) {
		return null;
	}
	$sneeit_core_p_id = get_post( $sneeit_core_p_post );
	// dev-reply#811.
	if ( empty( $sneeit_core_p_id ) ) {
		// dev-reply#813.
		$sneeit_core_p_real = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_p_post,
			'meta_compare' => '=',
		) );
		// dev-reply#824.
		if ( empty( $sneeit_core_p_real ) ) {
			return null;
		}
		return $sneeit_core_p_real[0]->ID;
	}
	return $sneeit_core_p_post;
}
/**
 * Check Documentation#828
 *
 * @param object|array|string $sneeit_core_p_posts check var-def#828.
 * @param object|array|string $sneeit_core_p_post check var-def#828.
 * @param object|array|string $sneeit_core_p_file check var-def#828.
 */
function sneeit_core_create_attachment( $sneeit_core_p_posts, $sneeit_core_p_post = null, $sneeit_core_p_file = null ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	( ! $sneeit_core_p_file ) && ( $sneeit_core_p_file = sneeit_core_unique_image_name( $sneeit_core_p_posts, $sneeit_core_p_name ) );
	$sneeit_core_p_path = wp_upload_dir()['path'] . '/' . $sneeit_core_p_file;
	// dev-reply#850.
	if ( ( $sneeit_core_p_path ) !== $sneeit_core_p_posts ) {
		if ( ! copy( $sneeit_core_p_posts, $sneeit_core_p_path ) ) {
			// dev-reply#856.
			return false;
		}
		// dev-reply#860.
		if ( strpos( $sneeit_core_p_posts, wp_upload_dir()['path'] ) !== false && ( $sneeit_core_p_posts ) !== SNEEIT_CORE_IMAGE_PATH . 'blank.png' ) {
			// dev-reply#862.
			unlink( $sneeit_core_p_posts );
		}
	}
	$sneeit_core_p_url = wp_upload_dir()['url'] . $sneeit_core_p_file; // dev-reply#867.
	$sneeit_core_p_type = wp_check_filetype( $sneeit_core_p_path, null );
	$sneeit_core_p_args = array(
		'post_mime_type' => $sneeit_core_p_type['type'], // dev-reply#872.
		'guid' => $sneeit_core_p_url,
		'post_title' => $sneeit_core_p_file,
		'post_content' => '',
		'post_parent' => $sneeit_core_p_post,
	);
	// dev-reply#880.
	$sneeit_core_p_attachment = wp_insert_attachment( $sneeit_core_p_args, $sneeit_core_p_path, $sneeit_core_p_post, true );
	if ( is_wp_error( $sneeit_core_p_attachment ) ) {
		// dev-reply#886.
		return false;
	}
	if ( $sneeit_core_p_post ) {
		// dev-reply#890.
		set_post_thumbnail( $sneeit_core_p_post, $sneeit_core_p_attachment );
	}
	$sneeit_core_p_meta = wp_generate_attachment_metadata( $sneeit_core_p_attachment, $sneeit_core_p_path );
	wp_update_attachment_metadata( $sneeit_core_p_attachment, $sneeit_core_p_meta );
	return $sneeit_core_p_attachment;
}
/**
 * Check Documentation#869
 *
 * @param object|array|string $sneeit_core_p_comment check var-def#869.
 */
function sneeit_core_get_demo_comment_id( $sneeit_core_p_comment ) {
	$sneeit_core_p_comments = get_comment( $sneeit_core_p_comment );
	// dev-reply#8115.
	if ( empty( $sneeit_core_p_comments ) ) {
		// dev-reply#8117.
		$sneeit_core_p_id_post = get_comments( array(
			'status'      => 'approve',
			'number' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_p_comment,
			'meta_compare' => '=',
		) );
		// dev-reply#8127.
		if ( empty( $sneeit_core_p_id_post ) ) {
			return null;
		}
		return $sneeit_core_p_id_post[0]->ID;
	}
	return $sneeit_core_p_comment;
}
