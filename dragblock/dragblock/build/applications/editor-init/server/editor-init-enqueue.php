<?php
/**
 * DragBlock's Editor-init.
 *
 * @package Editor init enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_EDITOR_INIT_SLUG', 'dragblock-editor-init' );
add_action( 'enqueue_block_editor_assets', 'dragblock_editor_init_editor_assets' );
/**
 * Check Documentation#44
 */
function dragblock_editor_init_editor_assets() {
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG . '-animate', 'assets/css/animate.min.css' );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.js', array( 'jquery' ) );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.css' );
	// dev-reply#416.
	$dragblock_eie_script = array(
		'blankDemoImgUrl' => DRAGBLOCK_URL . 'assets/images/demo/blank.png',
		'siteLocale' => DRAGBLOCK_SITE_LOCALE,
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( DRAGBLOCK_NONCE_SLUG ),
	);
	// dev-reply#424.
	wp_localize_script( DRAGBLOCK_EDITOR_INIT_SLUG, 'dragBlockEditorInit', $dragblock_eie_script );
}
add_action( 'after_setup_theme', 'dragblock_editor_init_editor_iframe', 100 );
/**
 * Check Documentation#420
 */
function dragblock_editor_init_editor_iframe() {
	add_editor_style( DRAGBLOCK_URL . 'assets/css/animate.min.css' );
	// dev-reply#437.
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		add_editor_style( DRAGBLOCK_URL . 'build/applications/editor-init/client/front/style-index.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'dragblock_editor_init_front_scripts' );
/**
 * Check Documentation#429
 */
function dragblock_editor_init_front_scripts() {
	// dev-reply#451.
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/index.js' );
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/style-index.css' );
	}
}
