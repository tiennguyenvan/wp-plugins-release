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
 * @param object|array|string $sneeit_core_0 check var-def#83.
 */
function sneeit_core_get_demo_post_id( $sneeit_core_0 = null ) {
	if ( ! $sneeit_core_0 ) {
		return null;
	}
	$sneeit_core_1 = get_post( $sneeit_core_0 );
	// dev-reply#811.
	if ( empty( $sneeit_core_1 ) ) {
		// dev-reply#813.
		$sneeit_core_2 = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_0,
			'meta_compare' => '=',
		) );
		// dev-reply#824.
		if ( empty( $sneeit_core_2 ) ) {
			return null;
		}
		return $sneeit_core_2[0]->ID;
	}
	return $sneeit_core_0;
}
/**
 * Check Documentation#828
 *
 * @param object|array|string $sneeit_core_3 check var-def#828.
 * @param object|array|string $sneeit_core_0 check var-def#828.
 * @param object|array|string $sneeit_core_4 check var-def#828.
 */
function sneeit_core_create_attachment( $sneeit_core_3, $sneeit_core_0 = null, $sneeit_core_4 = null ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	( ! $sneeit_core_4 ) && ( $sneeit_core_4 = sneeit_core_unique_image_name( $sneeit_core_3, $sneeit_core_5 ) );
	$sneeit_core_6 = wp_upload_dir()['path'] . '/' . $sneeit_core_4;
	// dev-reply#850.
	if ( ( $sneeit_core_6 ) !== $sneeit_core_3 ) {
		if ( ! copy( $sneeit_core_3, $sneeit_core_6 ) ) {
			// dev-reply#856.
			return false;
		}
		// dev-reply#860.
		if ( strpos( $sneeit_core_3, wp_upload_dir()['path'] ) !== false && ( $sneeit_core_3 ) !== SNEEIT_CORE_IMAGE_PATH . 'blank.png' ) {
			// dev-reply#862.
			unlink( $sneeit_core_3 );
		}
	}
	$sneeit_core_7 = wp_upload_dir()['url'] . $sneeit_core_4; // dev-reply#867.
	$sneeit_core_8 = wp_check_filetype( $sneeit_core_6, null );
	$sneeit_core_9 = array(
		'post_mime_type' => $sneeit_core_8['type'], // dev-reply#872.
		'guid' => $sneeit_core_7,
		'post_title' => $sneeit_core_4,
		'post_content' => '',
		'post_parent' => $sneeit_core_0,
	);
	// dev-reply#880.
	$sneeit_core_10 = wp_insert_attachment( $sneeit_core_9, $sneeit_core_6, $sneeit_core_0, true );
	if ( is_wp_error( $sneeit_core_10 ) ) {
		// dev-reply#886.
		return false;
	}
	if ( $sneeit_core_0 ) {
		// dev-reply#890.
		set_post_thumbnail( $sneeit_core_0, $sneeit_core_10 );
	}
	$sneeit_core_11 = wp_generate_attachment_metadata( $sneeit_core_10, $sneeit_core_6 );
	wp_update_attachment_metadata( $sneeit_core_10, $sneeit_core_11 );
	return $sneeit_core_10;
}
/**
 * Check Documentation#869
 *
 * @param object|array|string $sneeit_core_12 check var-def#869.
 */
function sneeit_core_get_demo_comment_id( $sneeit_core_12 ) {
	$sneeit_core_13 = get_comment( $sneeit_core_12 );
	// dev-reply#8115.
	if ( empty( $sneeit_core_13 ) ) {
		// dev-reply#8117.
		$sneeit_core_14 = get_comments( array(
			'status'      => 'approve',
			'number' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_12,
			'meta_compare' => '=',
		) );
		// dev-reply#8127.
		if ( empty( $sneeit_core_14 ) ) {
			return null;
		}
		return $sneeit_core_14[0]->ID;
	}
	return $sneeit_core_12;
}
