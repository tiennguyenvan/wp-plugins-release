<?php
/**
 * DragBlock's Editor-command-line.
 *
 * @package Editor command line enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_editor_command_line_assets' );
/**
 * Check Documentation#13
 */
function dragblock_editor_command_line_assets() {
	$dragblock_ecle_slug = 'command-line';
	dragblock_enqueue( "dragblock-{$dragblock_ecle_slug}", "build/applications/editor-{$dragblock_ecle_slug}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "dragblock-{$dragblock_ecle_slug}", "build/applications/editor-{$dragblock_ecle_slug}/client/index.css" );
}
