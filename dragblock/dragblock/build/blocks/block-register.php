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
 * Check Documentation#113
 */
function dragblock_block_init() {
	// dev-reply#1117.
	global $wp_version;
	if ( version_compare( $wp_version, '5.8.0' ) < 0 ) {
		return;
	}
	$dragblock_br_wp = DRAGBLOCK_BUILD_PATH . 'blocks/';
	// dev-reply#1126.
	$dragblock_br_version = array(
		// dev-reply#1128.
		'wrapper',
		'link',
		'icon',
		'text',
		'image',
		// dev-reply#1134.
		'form',
		'select',
		'option',
		'input',
		'textarea',
		// dev-reply#1143.
		'pattern',
		// dev-reply#1146.
		'slider',
		'slide',
	);
	foreach ( $dragblock_br_version as $dragblock_br_path ) {
		register_block_type( $dragblock_br_wp . $dragblock_br_path );
	}
	// dev-reply#1155.
	wp_set_script_translations( 'dragblock-editor-script-js', 'dragblock' );
}
if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
	add_filter( 'block_categories_all', 'dragblock_register_block_category', 10, 2 );
} else {
	add_filter( 'block_categories', 'dragblock_register_block_category', 10, 2 );
}
/**
 * Check Documentation#1142
 *
 * @param object|array|string $dragblock_br_blocks check var-def#1142.
 * @param object|array|string $dragblock_br_block check var-def#1142.
 */
function dragblock_register_block_category( $dragblock_br_blocks, $dragblock_br_block ) {
	array_unshift(
		$dragblock_br_blocks,
		array(
			'slug'  => 'dragblock-compact',
			'title' => esc_html__( 'DragBlock Compact', 'dragBlock-block' ),
		)
	);
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
 * Check Documentation#1168
 *
 * @param object|array|string $dragblock_br_categories check var-def#1168.
 * @param object|array|string $dragblock_br_editor check var-def#1168.
 */
function dragblock_err_loading_block_invalid_param_attrs( $dragblock_br_categories, $dragblock_br_editor ) {
	if ( ! isset( $dragblock_br_categories['attributes'] ) ) {
		$dragblock_br_categories['attributes'] = array();
	}
	// dev-reply#11114.
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
	// dev-reply#11134.
	if ( ! isset( $dragblock_br_categories['attributes']['anchor'] ) ) {
		$dragblock_br_categories['attributes']['anchor'] = array(
			'type' => 'string',
			'source' => 'attribute',
			'default' => '',
			'attribute' => 'id',
			'selector' =>  '*', // dev-reply#11141.,
		);
	}
	return $dragblock_br_categories;
}
add_filter( 'map_meta_cap', 'dragblock_multisite_allow_admins_unfiltered_html', 1, 4 );
/**
 * Check Documentation#11104
 *
 * @param object|array|string $dragblock_br_dragblock check var-def#11104.
 * @param object|array|string $dragblock_br_attrs check var-def#11104.
 * @param object|array|string $dragblock_br_attr check var-def#11104.
 * @param object|array|string $dragblock_br_categories check var-def#11104.
 */
function dragblock_multisite_allow_admins_unfiltered_html( $dragblock_br_dragblock, $dragblock_br_attrs, $dragblock_br_attr, $dragblock_br_categories ) {
	if ( ! is_multisite() ) {
		return $dragblock_br_dragblock;
	}
	$dragblock_br_caps = get_userdata( $dragblock_br_attr );
	if ( ! $dragblock_br_caps ) {
		return $dragblock_br_dragblock; // dev-reply#11162.
	}
	if ( is_super_admin( $dragblock_br_attr ) ) {
		return $dragblock_br_dragblock;
	}
	if ( ! in_array( 'administrator', (array) $dragblock_br_caps->roles ) ) {
		return $dragblock_br_dragblock;
	}
	$dragblock_br_dragblock = array( 'unfiltered_html' );
	return $dragblock_br_dragblock;
}
// dev-reply#11177.
