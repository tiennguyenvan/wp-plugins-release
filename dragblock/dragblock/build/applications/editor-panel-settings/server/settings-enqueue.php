<?php
/**
 * DragBlock's Editor-panel-settings.
 *
 * @package Settings enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'enqueue_block_editor_assets', 'dragblock_settings_panel_editor_assets' );
/**
 * Check Documentation#33
 */
function dragblock_settings_panel_editor_assets() {
	$dragblock_se_panel = 'settings';
	dragblock_enqueue( "dragblock-{$dragblock_se_panel}-panel", "build/applications/editor-panel-{$dragblock_se_panel}/client/index.js", array( DRAGBLOCK_EDITOR_INIT_SLUG ) );
	dragblock_enqueue( "dragblock-{$dragblock_se_panel}-panel", "build/applications/editor-panel-{$dragblock_se_panel}/client/index.css" );
}
add_action( 'wp_enqueue_scripts', 'dragblock_settings_frontend_enqueue', 1 );
/**
 * Check Documentation#310
 */
function dragblock_settings_frontend_enqueue() {
	global $dragblock_js;
	if ( ! $dragblock_js ) {
		return;
	}
	$dragblock_se_dragblock = implode( '', $dragblock_js );
	if ( strpos( $dragblock_se_dragblock, 'new Swiper' ) !== false ) {
		wp_enqueue_style(
			'dragblock-swiper-css',
			DRAGBLOCK_URL . '/assets/plugins/swiper/swiper.min.css',
			array(),
			'11.1.15'
		);
		wp_enqueue_script(
			'dragblock-swiper-js',
			DRAGBLOCK_URL . '/assets/plugins/swiper/swiper.min.js',
			array(),
			'11.1.15',
			true
		);
	}
}
