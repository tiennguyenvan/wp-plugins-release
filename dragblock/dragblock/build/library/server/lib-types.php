<?php
/**
 * DragBlock's Library.
 *
 * @package Lib types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'init', 'dragblock_post_type_register_all' );
/**
 * Check Documentation#183
 */
function dragblock_post_type_register_all() {
	$dragblock_lt_post = apply_filters( 'dragblock_register_post_type', [] );
	foreach ( $dragblock_lt_post as $dragblock_lt_types ) {
		if ( empty( $dragblock_lt_types['slug'] ) ) {
			continue;
		}
		$dragblock_lt_type = $dragblock_lt_types['slug'];
		$dragblock_lt_slug = $dragblock_lt_types['icon'] ?? '';
		dragblock_post_type_register_one( $dragblock_lt_type, $dragblock_lt_slug );
	}
}
add_action( 'pre_get_posts', 'dragblock_post_type_get_archive' );
/**
 * Check Documentation#1816
 *
 * @param object|array|string $dragblock_lt_icon check var-def#1816.
 */
function dragblock_post_type_get_archive( $dragblock_lt_icon ) {
	if ( is_admin() ) {
		return;
	}
	if ( ! $dragblock_lt_icon->is_main_query() ) {
		return;
	}
	$dragblock_lt_post = apply_filters( 'dragblock_register_post_type', [] );
	foreach ( $dragblock_lt_post as $dragblock_lt_types ) {
		$dragblock_lt_type = $dragblock_lt_types['slug'];
		if ( ! is_post_type_archive( $dragblock_lt_type ) ) {
			continue;
		}
		if ( isset( $_GET['cat'] ) ) {
			$dragblock_lt_icon->set( 'tax_query', array(
				array(
					'taxonomy' => $dragblock_lt_type . '-category',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $_GET['cat'] ),
				),
			) );
		}
		if ( isset( $_GET['tag'] ) ) {
			$dragblock_lt_icon->set( 'tax_query', array(
				array(
					'taxonomy' => $dragblock_lt_type . '-tag',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $_GET['tag'] ),
				),
			) );
		}
		break;
	}
}
/**
 * Check Documentation#1851
 *
 * @param object|array|string $dragblock_lt_type check var-def#1851.
 * @param object|array|string $dragblock_lt_slug check var-def#1851.
 */
function dragblock_post_type_register_one( $dragblock_lt_type, $dragblock_lt_slug = '' ) {
	// dev-reply#1867.
	$dragblock_lt_query = $dragblock_lt_type . 's';
	$dragblock_lt_get = empty( $dragblock_lt_slug );
	$dragblock_lt_permalink = dragblock_slug_to_title( $dragblock_lt_type );
	$dragblock_lt_hidden = $dragblock_lt_permalink . 's';
	$dragblock_lt_single = $dragblock_lt_type . '-category';
	$dragblock_lt_plural = $dragblock_lt_type . '-tag';
	// dev-reply#1876.
	$dragblock_lt_cat = array(
		'name'                  => $dragblock_lt_hidden,
		'singular_name'         => $dragblock_lt_permalink,
		'menu_name'             => $dragblock_lt_hidden,
		'name_admin_bar'        => $dragblock_lt_permalink,
		'archives'              => $dragblock_lt_permalink . ' Archives',
		'attributes'            => $dragblock_lt_permalink . ' Attributes',
		'parent_item_colon'     => 'Parent  ' . $dragblock_lt_permalink . ':',
		'all_items'             => 'All ' . $dragblock_lt_hidden,
		'add_new_item'          => 'Add New ' . $dragblock_lt_permalink,
		'add_new'               => 'Add New',
		'new_item'              => 'New ' . $dragblock_lt_permalink,
		'edit_item'             => 'Edit ',
		'update_item'           => 'Update ' . $dragblock_lt_permalink,
		'view_item'             => 'View ' . $dragblock_lt_permalink,
		'view_items'            => 'View ' . $dragblock_lt_hidden,
		'search_items'          => 'Search ' . $dragblock_lt_permalink,
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => $dragblock_lt_permalink . 'Insert into ' . $dragblock_lt_permalink,
		'uploaded_to_this_item' => $dragblock_lt_permalink . 'Uploaded to this ' . $dragblock_lt_permalink,
		'items_list'            => $dragblock_lt_hidden . ' list',
		'items_list_navigation' => $dragblock_lt_hidden . ' list navigation',
		'filter_items_list'     => 'Filter ' . $dragblock_lt_hidden . ' list',
	);
	$dragblock_lt_tag = array(
		'label'                 => $dragblock_lt_permalink,
		'description'           => 'Custom post type for ' . $dragblock_lt_hidden,
		'labels'                => $dragblock_lt_cat,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( $dragblock_lt_single, $dragblock_lt_plural ),
		'hierarchical'          => false,
		'public'                => true,
		'publicly_queryable'    => true,
		'show_in_rest'          => true,
		'has_archive'           => true,
		'show_ui'               => ! $dragblock_lt_get,
		'show_in_menu'          => ! $dragblock_lt_get,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'rewrite'               => array( 'slug' => $dragblock_lt_query ),
		'menu_icon'				=> $dragblock_lt_slug,
	);
	register_post_type( $dragblock_lt_type, $dragblock_lt_tag );
	// dev-reply#18132.
	$dragblock_lt_cat = array(
		'name'              => $dragblock_lt_permalink . ' Categories',
		'singular_name'     => $dragblock_lt_permalink . ' Category',
		'search_items'      => 'Search ' . $dragblock_lt_permalink . ' Categories',
		'all_items'         => 'All ' . $dragblock_lt_permalink . ' Categories',
		'parent_item'       => 'Parent ' . $dragblock_lt_permalink . ' Category',
		'parent_item_colon' => 'Parent ' . $dragblock_lt_permalink . ' Category:',
		'edit_item'         => 'Edit ' . $dragblock_lt_permalink . ' Category',
		'update_item'       => 'Update ' . $dragblock_lt_permalink . ' Category',
		'add_new_item'      => 'Add New ' . $dragblock_lt_permalink . ' Category',
		'new_item_name'     => 'New ' . $dragblock_lt_permalink . ' Category Name',
		'menu_name'         => $dragblock_lt_permalink . ' Categories',
	);
	$dragblock_lt_tag = array(
		'hierarchical'      => true,
		'public'            => true,
		'publicly_queryable' => true,
		'show_in_rest' 		=> true,
		'labels'            => $dragblock_lt_cat,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => $dragblock_lt_single ),
	);
	register_taxonomy( $dragblock_lt_single, array( $dragblock_lt_type ), $dragblock_lt_tag );
	// dev-reply#18161.
	$dragblock_lt_cat = array(
		'name'                       => $dragblock_lt_permalink . ' Tags',
		'singular_name'              => $dragblock_lt_permalink . ' Tag',
		'search_items'               => 'Search ' . $dragblock_lt_permalink . ' Tags',
		'popular_items'              => 'Popular ' . $dragblock_lt_permalink . ' Tags',
		'all_items'                  => 'All ' . $dragblock_lt_permalink . ' Tags',
		'edit_item'                  => 'Edit ' . $dragblock_lt_permalink . ' Tag',
		'update_item'                => 'Update ' . $dragblock_lt_permalink . ' Tag',
		'add_new_item'               => 'Add New ' . $dragblock_lt_permalink . ' Tag',
		'new_item_name'              => 'New ' . $dragblock_lt_permalink . ' Tag Name',
		'separate_items_with_commas' => 'Separate ' . $dragblock_lt_permalink . ' tags with commas',
		'add_or_remove_items'        => 'Add or remove ' . $dragblock_lt_permalink . ' tags',
		'choose_from_most_used'      => 'Choose from the most used ' . $dragblock_lt_permalink . ' tags',
		'not_found'                  => 'No ' . $dragblock_lt_permalink . ' tags found.',
		'menu_name'                  => $dragblock_lt_permalink . ' Tags',
	);
	$dragblock_lt_tag = array(
		'hierarchical'          => false,
		'labels'                => $dragblock_lt_cat,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => $dragblock_lt_plural ),
	);
	register_taxonomy( $dragblock_lt_plural, array( $dragblock_lt_type ), $dragblock_lt_tag );
	// dev-reply#18189.
	$dragblock_lt_labels = '/' . $dragblock_lt_single . '/';
	if ( strpos( $_SERVER['REQUEST_URI'], $dragblock_lt_labels ) !== false ) {
		$dragblock_lt_args = explode( $dragblock_lt_labels, $_SERVER['REQUEST_URI'] );
		$dragblock_lt_separator = trim( $dragblock_lt_args[1], '/' );
		// dev-reply#18196.
		$dragblock_lt_server = isset( $_SERVER['QUERY_STRING'] ) ? '&' . $_SERVER['QUERY_STRING'] : '';
		wp_redirect( home_url( '/' . $dragblock_lt_query . '?cat=' . $dragblock_lt_separator . $dragblock_lt_server ), 301 );
		exit;
	}
}
