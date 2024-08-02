<?php
/**
 * DragBlock's Editor-panel-database.
 *
 * @package Database loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
dragblock_ajax_register( 'dragblock_database_loader' );
/**
 * Check Documentation#43
 */
function dragblock_database_loader() {
	dragblock_ajax_request_verify_die( 'data' );
	$dragblock_dl_data = json_decode( sanitize_text_field( wp_unslash( $_POST['data'] ) ), true );
	$dragblock_dl_data['fields'] = 'ids';
	if ( ! isset( $dragblock_dl_data['post_status'] ) ) {
		$dragblock_dl_data['post_status'] = 'publish';
	}
	// dev-reply#414.
	$dragblock_dl_post = new WP_Query( dragblock_wp_query_args_processor( $dragblock_dl_data ) );
	$dragblock_dl_query = $dragblock_dl_post->posts;
	$dragblock_dl_posts = array();
	foreach ( $dragblock_dl_query as $dragblock_dl_ids ) {
		$dragblock_dl_id = array();
		$dragblock_dl_id['id'] = $dragblock_dl_ids;
		$dragblock_dl_id['title'] = dragblock_shortcode_post_title( null, $dragblock_dl_ids );
		$dragblock_dl_id['snippet'] = dragblock_shortcode_post_snippet( null, $dragblock_dl_ids );
		$dragblock_dl_id['comment_number'] = dragblock_shortcode_post_comment_number( null, $dragblock_dl_ids );
		$dragblock_dl_id['post_count'] = dragblock_shortcode_post_view_count( null, $dragblock_dl_ids );
		$dragblock_dl_id['image_src'] = dragblock_shortcode_post_image_src( null, $dragblock_dl_ids );
		$dragblock_dl_id['date'] = dragblock_shortcode_post_date( null, $dragblock_dl_ids );
		$dragblock_dl_id['author_name'] = dragblock_shortcode_post_author_name( null, $dragblock_dl_ids );
		$dragblock_dl_id['author_avatar_src'] = dragblock_shortcode_post_author_avatar_src( null, $dragblock_dl_ids );
		$dragblock_dl_id['author_bio'] = dragblock_shortcode_post_author_bio( null, $dragblock_dl_ids );
		$dragblock_dl_id['cat_name'] = dragblock_shortcode_post_cat_name( null, $dragblock_dl_ids );
		$dragblock_dl_posts[] = $dragblock_dl_id;
	}
	// dev-reply#435.
	dragblock_ajax_succeed_die( $dragblock_dl_posts );
}
