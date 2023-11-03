<?php
/**
 * DragBlock's Tutorials.
 *
 * @package Tutorials enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_tutorials_panel_editor_assets' );
/**
 * Check Documentation#23
 */
function dragblock_tutorials_panel_editor_assets() {
	$dragblock_te_panel = 'tutorials';
	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );
	dragblock_enqueue( "dragblock-{$dragblock_te_panel}", "build/applications/{$dragblock_te_panel}/client/editor/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "dragblock-{$dragblock_te_panel}", "build/applications/{$dragblock_te_panel}/client/editor/index.css" );
}
