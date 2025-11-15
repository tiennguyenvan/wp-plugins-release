<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'dragblock_register_post_type', 'dragblock_register_pattern_type' );
/**
 * Check Documentation#13
 *
 * @param object|array|string $dragblock_pr_post check var-def#13.
 */
function dragblock_register_pattern_type( $dragblock_pr_post ) {
	$dragblock_pr_post[] = array(
		'slug' => 'dragblock-pattern',
		// dev-reply#17.,
	);
	return $dragblock_pr_post;
}
