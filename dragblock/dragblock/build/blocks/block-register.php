<?php
/**
 * DragBlock's Blocks.
 *
 * @package Block register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'init', 'dragblock_block_init' );
/**
 * Check Documentation#43
 */
function dragblock_block_init() {
	// dev-reply#417.
	global $wp_version;
	if ( version_compare( $wp_version, '5.8.0' ) < 0 ) {
		return;
	}
	$dragblock_0 = DRAGBLOCK_BUILD_PATH . 'blocks/';
	// dev-reply#426.
	$dragblock_1 = array(
		// dev-reply#428.
		'wrapper',
		'link',
		'icon',
		'text',
		'image',
		// dev-reply#435.
		'form',
		'select',
		'option',
		'input',
		'textarea',
	);
	foreach ( $dragblock_1 as $dragblock_2 ) {
		register_block_type( $dragblock_0 . $dragblock_2 );
	}
	// dev-reply#446.
	wp_set_script_translations( 'dragblock-editor-script-js', 'dragblock' );
}
/**
 * Check Documentation#432
 *
 * @param object|array|string $dragblock_3 check var-def#432.
 */
function dragblock_register_block_category( $dragblock_3 ) {
	array_unshift(
		$dragblock_3,
		array(
			'slug'  => 'dragblock-form',
			'title' => esc_html__( 'DragBlock Form', 'dragBlock-block' ),
		)
	);
	array_unshift(
		$dragblock_3,
		array(
			'slug'  => 'dragblock-basic',
			'title' => esc_html__( 'DragBlock Basic', 'dragBlock-block' ),
		)
	);
	return $dragblock_3;
}
if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
	add_filter( 'block_categories_all', 'dragblock_register_block_category', 10, 2 );
} else {
	add_filter( 'block_categories', 'dragblock_register_block_category', 10, 2 );
}
