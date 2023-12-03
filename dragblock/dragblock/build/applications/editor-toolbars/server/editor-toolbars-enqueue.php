<?php
/**
 * DragBlock's Editor-toolbars.
 *
 * @package Editor toolbars enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_toolbars_panel_editor_assets' );
/**
 * Check Documentation#13
 */
function dragblock_toolbars_panel_editor_assets() {
	$dragblock_ete_slug = 'toolbars';
	dragblock_enqueue( "dragblock-{$dragblock_ete_slug}", "build/applications/editor-{$dragblock_ete_slug}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "dragblock-{$dragblock_ete_slug}", "build/applications/editor-{$dragblock_ete_slug}/client/index.css" );
}
