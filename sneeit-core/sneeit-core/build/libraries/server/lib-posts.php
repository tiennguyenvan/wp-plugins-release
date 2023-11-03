<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#42
 *
 * @param object|array|string $sneeit_core_lp_post check var-def#42.
 */
function sneeit_core_get_demo_post_id( $sneeit_core_lp_post = null ) {
	if ( ! $sneeit_core_lp_post ) {
		return null;
	}
	$sneeit_core_lp_id = get_post( $sneeit_core_lp_post );
	// dev-reply#49.
	if ( empty( $sneeit_core_lp_id ) ) {
		// dev-reply#411.
		$sneeit_core_lp_real = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => (int) $sneeit_core_lp_post,
			'meta_compare' => '=',
		) );
		// dev-reply#422.
		if ( empty( $sneeit_core_lp_real ) ) {
			return null;
		}
		return $sneeit_core_lp_real[0]->ID;
	}
	return $sneeit_core_lp_post;
}
/**
 * Check Documentation#427
 *
 * @param object|array|string $sneeit_core_lp_posts check var-def#427.
 */
function sneeit_core_get_demo_comment_id( $sneeit_core_lp_posts ) {
	$sneeit_core_lp_comment = get_comment( $sneeit_core_lp_posts );
	if ( $sneeit_core_lp_comment ) {
		return $sneeit_core_lp_comment->ID;
	}
	// dev-reply#440.
	$sneeit_core_lp_comments = get_comments( array(
		'fields' => 'ids', // dev-reply#444.
		'meta_key' => 'sneeit-demo-id',
		'meta_value' => $sneeit_core_lp_posts,
		'meta_compare' => '=',
	) );
	// dev-reply#451.
	if ( empty( $sneeit_core_lp_comments ) ) {
		return null;
	}
	return $sneeit_core_lp_comments[0];
}
