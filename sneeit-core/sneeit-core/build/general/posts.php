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
 * @param object|array|string $sneeit_core_p_post_id check var-def#83.
 */
function sneeit_core_get_demo_post_id( $sneeit_core_p_post_id = null ) {
	if ( ! $sneeit_core_p_post_id ) {
		return null;
	}
	$sneeit_core_p_real_post = get_post( $sneeit_core_p_post_id );
	// dev-reply#811.
	if ( empty( $sneeit_core_p_real_post ) ) {
		// dev-reply#813.
		$sneeit_core_p_real_posts = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_p_post_id,
			'meta_compare' => '=',
		) );
		// dev-reply#824.
		if ( empty( $sneeit_core_p_real_posts ) ) {
			return null;
		}
		return $sneeit_core_p_real_posts[0]->ID;
	}
	return $sneeit_core_p_post_id;
}
/**
 * Check Documentation#828
 *
 * @param object|array|string $sneeit_core_p_file check var-def#828.
 * @param object|array|string $sneeit_core_p_post_id check var-def#828.
 * @param object|array|string $sneeit_core_p_file_name check var-def#828.
 */
function sneeit_core_create_attachment( $sneeit_core_p_file, $sneeit_core_p_post_id = null, $sneeit_core_p_file_name = null ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	( ! $sneeit_core_p_file_name ) && ( $sneeit_core_p_file_name = sneeit_core_unique_image_name( $sneeit_core_p_file, $sneeit_core_p_id ) );
	$sneeit_core_p_file_path = wp_upload_dir()['path'] . '/' . $sneeit_core_p_file_name;
	// dev-reply#850.
	if ( ( $sneeit_core_p_file_path ) !== $sneeit_core_p_file ) {
		if ( ! copy( $sneeit_core_p_file, $sneeit_core_p_file_path ) ) {
			// dev-reply#856.
			return false;
		}
		// dev-reply#860.
		if ( strpos( $sneeit_core_p_file, wp_upload_dir()['path'] ) !== false && ( $sneeit_core_p_file ) !== SNEEIT_CORE_IMAGE_PATH . 'blank.png' ) {
			// dev-reply#862.
			unlink( $sneeit_core_p_file );
		}
	}
	$sneeit_core_p_file_url = wp_upload_dir()['url'] . $sneeit_core_p_file_name; // dev-reply#867.
	$sneeit_core_p_file_type = wp_check_filetype( $sneeit_core_p_file_path, null );
	$sneeit_core_p_args = array(
		'post_mime_type' => $sneeit_core_p_file_type['type'], // dev-reply#872.
		'guid' => $sneeit_core_p_file_url,
		'post_title' => $sneeit_core_p_file_name,
		'post_content' => '',
		'post_parent' => $sneeit_core_p_post_id,
	);
	// dev-reply#880.
	$sneeit_core_p_attachment_id = wp_insert_attachment( $sneeit_core_p_args, $sneeit_core_p_file_path, $sneeit_core_p_post_id, true );
	if ( is_wp_error( $sneeit_core_p_attachment_id ) ) {
		// dev-reply#886.
		return false;
	}
	if ( $sneeit_core_p_post_id ) {
		// dev-reply#890.
		set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_attachment_id );
	}
	$sneeit_core_p_attachment_meta = wp_generate_attachment_metadata( $sneeit_core_p_attachment_id, $sneeit_core_p_file_path );
	wp_update_attachment_metadata( $sneeit_core_p_attachment_id, $sneeit_core_p_attachment_meta );
	return $sneeit_core_p_attachment_id;
}
/**
 * Check Documentation#869
 *
 * @param object|array|string $sneeit_core_p_comment_id check var-def#869.
 */
function sneeit_core_get_demo_comment_id( $sneeit_core_p_comment_id ) {
	$sneeit_core_p_real_comment = get_comment( $sneeit_core_p_comment_id );
	// dev-reply#8115.
	if ( empty( $sneeit_core_p_real_comment ) ) {
		// dev-reply#8117.
		$sneeit_core_p_real_comments = get_comments( array(
			'status'      => 'approve',
			'number' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_p_comment_id,
			'meta_compare' => '=',
		) );
		// dev-reply#8127.
		if ( empty( $sneeit_core_p_real_comments ) ) {
			return null;
		}
		return $sneeit_core_p_real_comments[0]->ID;
	}
	return $sneeit_core_p_comment_id;
}
