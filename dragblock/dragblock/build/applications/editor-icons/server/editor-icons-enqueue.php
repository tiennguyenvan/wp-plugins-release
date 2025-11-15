<?php
/**
 * DragBlock's Editor-icons.
 *
 * @package Editor icons enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_editor_icons_assets' );
/**
 * Check Documentation#13
 */
function dragblock_editor_icons_assets() {
	wp_enqueue_script(
		'dragblock-editor-icons',
		DRAGBLOCK_URL . 'build/applications/editor-icons/client/index.js',
		array(),
		DRAGBLOCK_VERSION,
		array( 'strategy' => 'async' )
	);
	// dev-reply#114.
}
