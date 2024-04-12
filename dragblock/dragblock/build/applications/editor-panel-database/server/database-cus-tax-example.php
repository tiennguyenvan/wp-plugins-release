<?php
/**
 * DragBlock's Editor-panel-database.
 *
 * @package Database cus tax example
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#134.
add_action( 'init', 'pridanie_archiv_ctt' );
/**
 * Check Documentation#134
 */
function pridanie_archiv_ctt() {
	$dragblock_dcte_labels = array(
		'name' => esc_html_x( 'Archives', 'taxonomy general name', 'goblyn-functions' ),
		'singular_name' => esc_html_x( 'Archive', 'taxonomy singular name', 'goblyn-functions' ),
		'menu_name' => esc_html__( 'Archives', 'goblyn-functions' ),
		'all_items' => esc_html__( 'All archives', 'goblyn-functions' ),
		'edit_item' => esc_html__( 'Edit archive', 'goblyn-functions' ),
		'view_item' => esc_html__( 'Show archive', 'goblyn-functions' ),
		'update_item' => esc_html__( 'Update archive', 'goblyn-functions' ),
		'add_new_item' => esc_html__( 'Add new archive', 'goblyn-functions' ),
		'new_item_name' => esc_html__( 'Add new', 'goblyn-functions' ),
		'parent_item' => esc_html__( 'Parent archive', 'goblyn-functions' ),
		'parent_item_colon' => esc_html__( 'Parent archive:', 'goblyn-functions' ),
		'search_items' => esc_html__( 'Search archive', 'goblyn-functions' ),
		'not_found' => esc_html__( 'No archives found.', 'goblyn-functions' ),
	);
	register_taxonomy(
		'archive',
		array( 'post' ),
		array(
			'hierarchical' => true,
			'labels' => $dragblock_dcte_labels,
			'public' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'archivy', 'with_front' => true ),
		)
	);
}
// dev-reply#1343.
/**
 * Check Documentation#1337
 */
function pridanie_filtrov_archivy() {
	global $typenow;
	$dragblock_dcte_typenow = 'post';
	$dragblock_dcte_post = 'archive';
	if ( ( $typenow ) === $dragblock_dcte_typenow ) {
		$dragblock_dcte_type = isset( $_GET[ $dragblock_dcte_post ] ) ? $_GET[ $dragblock_dcte_post ] : '';
		$dragblock_dcte_taxonomy = get_taxonomy( $dragblock_dcte_post );
		wp_dropdown_categories(
			array(
				/* translators: see trans-note#1347 */
				'show_option_all' => esc_html( sprintf( esc_html__( 'All archives', 'goblyn-functions' ), $dragblock_dcte_taxonomy->label ) ),
				'taxonomy' => $dragblock_dcte_post,
				'name' => $dragblock_dcte_post,
				'orderby' => 'name',
				'selected' => $dragblock_dcte_type,
				'show_count' => false,
				'hide_empty' => true,
			)
		);
	};
}
add_action( 'restrict_manage_posts', 'pridanie_filtrov_archivy' );
add_filter( 'parse_query', 'kovertovanie_id_term_query_archivy' );
/**
 * Check Documentation#1360
 *
 * @param object|array|string $dragblock_dcte_selected check var-def#1360.
 */
function kovertovanie_id_term_query_archivy( $dragblock_dcte_selected ) {
	global $pagenow;
	$dragblock_dcte_typenow = 'post';
	$dragblock_dcte_post = 'archive';
	$dragblock_dcte_get = &$dragblock_dcte_selected->query_vars;
	if (
		( $pagenow ) === 'edit.php' &&
		isset( $dragblock_dcte_get['post_type'] ) &&
		$dragblock_dcte_get['post_type'] === $dragblock_dcte_typenow &&
		isset( $dragblock_dcte_get[ $dragblock_dcte_post ] ) &&
		is_numeric( $dragblock_dcte_get[ $dragblock_dcte_post ] ) &&
		$dragblock_dcte_get[ $dragblock_dcte_post ] !== 0
	) {
		$dragblock_dcte_info = get_term_by( 'id', $dragblock_dcte_get[ $dragblock_dcte_post ], $dragblock_dcte_post );
		$dragblock_dcte_get[ $dragblock_dcte_post ] = $dragblock_dcte_info->slug;
	}
}
// dev-reply#1391.
add_action( 'init', 'create_platform_taxonomy' );
// dev-reply#13110.
/**
 * Check Documentation#1381
 */
function create_platform_taxonomy() {
	$dragblock_dcte_labels = array(
		'name' => _x( 'Platforms', 'taxonomy general name' ),
		'singular_name' => _x( 'Platform', 'taxonomy singular name' ),
		'search_items' => esc_html__( 'Search Platforms' ),
		'all_items' => esc_html__( 'All Platforms' ),
		'parent_item' => esc_html__( 'Parent Platform' ),
		'parent_item_colon' => esc_html__( 'Parent Platform:' ),
		'edit_item' => esc_html__( 'Edit Platform' ),
		'update_item' => esc_html__( 'Update Platform' ),
		'add_new_item' => esc_html__( 'Add New Platform' ),
		'new_item_name' => esc_html__( 'New Platform Name' ),
		'menu_name' => esc_html__( 'Platform' ),
	);
	$dragblock_dcte_query = array(
		'hierarchical' => false, // dev-reply#13127.
		'labels' => $dragblock_dcte_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'platform' ), // dev-reply#13132.,
	);
	register_taxonomy( 'platform', array( 'post' ), $dragblock_dcte_query ); // dev-reply#13136.
}
if ( ! empty( $_GET['sneeit-demo-debug'] ) ) {
}
