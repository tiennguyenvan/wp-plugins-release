<?php
/**
 * DragBlock's Settings.
 *
 * @package Settings sanitization
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'map_meta_cap', 'dragblock_allow_current_admin_unfiltered_html', 1, 4 );
/**
 * Check Documentation#23
 *
 * @param object|array|string $dragblock_ss_caps check var-def#23.
 * @param object|array|string $dragblock_ss_cap check var-def#23.
 * @param object|array|string $dragblock_ss_user check var-def#23.
 * @param object|array|string $dragblock_ss_id check var-def#23.
 */
function dragblock_allow_current_admin_unfiltered_html( $dragblock_ss_caps, $dragblock_ss_cap, $dragblock_ss_user, $dragblock_ss_id ) {
	if ( 'unfiltered_html' === $dragblock_ss_cap && current_user_can( 'administrator' ) && get_current_user_id() === $dragblock_ss_user ) {
		$dragblock_ss_caps[] = 'unfiltered_html';
	}
	return $dragblock_ss_caps;
}
