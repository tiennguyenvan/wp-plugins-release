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
 * Check Documentation#54
 */
function dragblock_editor_init_editor_assets() {
	// dev-reply#515.
	$dragblock_eie_font = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
	$dragblock_eie_families = ["Arial",
		"Arial Narrow",
		"Arial Black",
		"Book Antiqua",
		"Cambria",
		"Century Gothic",
		"Courier New",
		"Cursive",
		"Franklin Gothic Medium",
		"Georgia",
		"Gill Sans",
		"Impact",
		"Lucida Console",
		"Lucida Sans",
		"Monospace",
		"Tahoma",
		"Times New Roman",
		"Trebuchet MS",
		"Verdana" ];
	foreach( $dragblock_eie_font as $dragblock_eie_names ) {
		if ( empty( $dragblock_eie_names['fontFamily'] ) ) {
			continue;
		}
		array_unshift( $dragblock_eie_families, $dragblock_eie_names['fontFamily'] );
	}
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG . '-animate', 'assets/css/animate.min.css' );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.js', array( 'jquery' ) );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.css' );
	// dev-reply#550.
	$dragblock_eie_family = array(
		'blankDemoImgUrl' => DRAGBLOCK_URL . 'assets/images/demo/blank.png',
		'siteLocale' => DRAGBLOCK_SITE_LOCALE,
		'homeUrl' => get_home_url(),
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( DRAGBLOCK_NONCE_SLUG ),
		'fontName' => $dragblock_eie_families,
	);
	// dev-reply#560.
	wp_localize_script( DRAGBLOCK_EDITOR_INIT_SLUG, 'dragBlockEditorInit', $dragblock_eie_family );
}
add_action( 'after_setup_theme', 'dragblock_editor_init_editor_iframe', 100 );
/**
 * Check Documentation#551
 */
function dragblock_editor_init_editor_iframe() {
	add_editor_style( DRAGBLOCK_URL . 'assets/css/animate.min.css' );
	// dev-reply#573.
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		add_editor_style( DRAGBLOCK_URL . 'build/applications/editor-init/client/front/style-index.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'dragblock_editor_init_front_scripts' );
/**
 * Check Documentation#560
 */
function dragblock_editor_init_front_scripts() {
	// dev-reply#587.
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/index.js' );
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/style-index.css' );
	}
}
