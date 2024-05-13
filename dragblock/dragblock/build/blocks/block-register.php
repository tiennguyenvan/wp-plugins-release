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
 * Check Documentation#83
 */
function dragblock_block_init() {
	// dev-reply#817.
	global $wp_version;
	if ( version_compare( $wp_version, '5.8.0' ) < 0 ) {
		return;
	}
	$dragblock_br_wp = DRAGBLOCK_BUILD_PATH . 'blocks/';
	// dev-reply#826.
	$dragblock_br_version = array(
		// dev-reply#828.
		'wrapper',
		'link',
		'icon',
		'text',
		'image',
		// dev-reply#834.
		'form',
		'select',
		'option',
		'input',
		'textarea',
	);
	foreach ( $dragblock_br_version as $dragblock_br_path ) {
		register_block_type( $dragblock_br_wp . $dragblock_br_path );
	}
	// dev-reply#847.
	wp_set_script_translations( 'dragblock-editor-script-js', 'dragblock' );
}
if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
	add_filter( 'block_categories_all', 'dragblock_register_block_category', 10, 2 );
} else {
	add_filter( 'block_categories', 'dragblock_register_block_category', 10, 2 );
}
/**
 * Check Documentation#837
 *
 * @param object|array|string $dragblock_br_blocks check var-def#837.
 * @param object|array|string $dragblock_br_block check var-def#837.
 */
function dragblock_register_block_category( $dragblock_br_blocks, $dragblock_br_block ) {
	array_unshift(
		$dragblock_br_blocks,
		array(
			'slug'  => 'dragblock-form',
			'title' => esc_html__( 'DragBlock Form', 'dragBlock-block' ),
		)
	);
	array_unshift(
		$dragblock_br_blocks,
		array(
			'slug'  => 'dragblock-basic',
			'title' => esc_html__( 'DragBlock Basic', 'dragBlock-block' ),
		)
	);
	return $dragblock_br_blocks;
}
add_filter( 'register_block_type_args', 'dragblock_err_loading_block_invalid_param_attrs', 1, 2 );
/**
 * Check Documentation#856
 *
 * @param object|array|string $dragblock_br_categories check var-def#856.
 * @param object|array|string $dragblock_br_editor check var-def#856.
 */
function dragblock_err_loading_block_invalid_param_attrs( $dragblock_br_categories, $dragblock_br_editor ) {
	if ( ! isset( $dragblock_br_categories['attributes'] ) ) {
		$dragblock_br_categories['attributes'] = array();
	}
	// dev-reply#895.
	$dragblock_br_context = array(
		'dragBlockClientId' => 'string',
		'dragBlockStyles' => 'array',
		'dragBlockCSS' => 'string',
		'dragBlockAttrs' => 'string',
		'dragBlockQueries' => 'array',
		'dragBlockPHP' => 'string',
		'dragBlockScripts' => 'array',
		'dragBlockJS' => 'string',
		'dragBlockRenderability' => 'string',
	);
	foreach ( $dragblock_br_context as $dragblock_br_args => $dragblock_br_type ) {
		if ( isset( $dragblock_br_categories['attributes'][ $dragblock_br_args ] ) ) {
			continue;
		}
		$dragblock_br_categories['attributes'][ $dragblock_br_args ] = array( 'type' => $dragblock_br_type, 'default' => '' );
	}
	// dev-reply#8115.
	if ( ! isset( $dragblock_br_categories['attributes']['anchor'] ) ) {
		$dragblock_br_categories['attributes']['anchor'] = array(
			'type' => 'string',
			'source' => 'attribute',
			'default' => '',
			'attribute' => 'id',
			'selector' =>  '*', // dev-reply#8122.,
		);
	}
	return $dragblock_br_categories;
}
