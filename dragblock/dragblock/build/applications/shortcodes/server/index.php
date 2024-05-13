<?php
/**
 * DragBlock's Applications.
 *
 * @package Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once 'shortcodes-post.php';
require_once 'shortcodes-link.php';
add_filter( 'kses_allowed_protocols', 'dragblock_kses_allowed_protocols', 1 );
/**
 * Check Documentation#15
 *
 * @param object|array|string $dragblock_s_protocols check var-def#15.
 */
function dragblock_kses_allowed_protocols( $dragblock_s_protocols ) {
	$dragblock_s_protocols[] = 'data';
	$dragblock_s_protocols[] = 'javascript';
	return $dragblock_s_protocols;
}
