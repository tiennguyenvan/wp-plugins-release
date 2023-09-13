<?php
/**
 * DragBlock's Editor-panel-content.
 *
 * @package Content enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_content_panel_editor_assets' );
/**
 * Check Documentation#13
 */
function dragblock_content_panel_editor_assets() {
	$dragblock_0 = 'content';
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "{$dragblock_0}-panel", "build/applications/editor-panel-{$dragblock_0}/client/index.css" );
}
