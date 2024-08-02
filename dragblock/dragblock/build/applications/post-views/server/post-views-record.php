<?php
/**
 * DragBlock's Post-views.
 *
 * @package Post views record
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#42
 *
 * @param object|array|string $dragblock_pvr_post check var-def#42.
 */
function dragblock_record_unique_post_view( $dragblock_pvr_post ) {
	// dev-reply#413.
	if ( empty( $dragblock_pvr_post ) ) {
		return;
	}
	// dev-reply#418.
	$dragblock_pvr_id = $_SERVER['REMOTE_ADDR'];
	$dragblock_pvr_ip = $_SERVER['HTTP_USER_AGENT'];
	// dev-reply#422.
	$dragblock_pvr_address = md5( $dragblock_pvr_id . $dragblock_pvr_ip );
	$dragblock_pvr_server = DRAGBLOCK_POST_VIEWS_KEY . '__' . $dragblock_pvr_post . '__' . $dragblock_pvr_address;
	// dev-reply#426.
	if ( false === get_transient( $dragblock_pvr_server ) ) {
		// dev-reply#428.
		$dragblock_pvr_user = (int) get_post_meta( $dragblock_pvr_post, DRAGBLOCK_POST_VIEWS_KEY, true );
		$dragblock_pvr_user++;
		update_post_meta( $dragblock_pvr_post, DRAGBLOCK_POST_VIEWS_KEY, $dragblock_pvr_user );
		// dev-reply#433.
		set_transient( $dragblock_pvr_server, true, 3600 );
	}
}
add_action( 'wp_head', 'dragblock_track_unique_post_views' );
/**
 * Check Documentation#425
 */
function dragblock_track_unique_post_views() {
	// dev-reply#441.
	if ( ! is_single() || ! is_main_query() || get_post_status() !== 'publish' ) {
		return;
	}
	global $post;
	if ( ! isset( $post->ID ) ) {
		return;
	}
	dragblock_record_unique_post_view( $post->ID );
}
