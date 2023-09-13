<?php
/**
 * DragBlock's Admin-menu.
 *
 * @package Menu register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_ADMIN_MENU_SLUG', 'dragblockAdminMenu' ); // dev-reply#22.
add_action( 'admin_menu', 'dragblock_admin_main_menu', 1 );
/**
 * Check Documentation#24
 */
function dragblock_admin_main_menu() {
	if ( ! empty( $GLOBALS['admin_page_hooks'][ DRAGBLOCK_ADMIN_MENU_SLUG ] ) ) {
		return;
	}
	add_menu_page(
		esc_attr__( 'DragBlock Welcome Page', 'dragblock' ),
		esc_attr__( 'DragBlock', 'dragblock' ),
		'manage_options',
		DRAGBLOCK_ADMIN_MENU_SLUG,
		'dragblock_admin_main_menu_page',
		plugins_url( 'dragblock/assets/images/brands/favicon-20x20.png' ),
		6
	);
}
// dev-reply#224.
/**
 * Check Documentation#220
 */
function dragblock_admin_main_menu_page() {
	// dev-reply#227.
	echo '<h1>' . esc_html__( 'Welcome to DragBlock', 'dragblock' ) . '</h1>';
	echo '<p>' . esc_html__( 'If you have any suggestion, please send to <a href="mailto:contact@dragblock.com"><strong>contact@dragblock.com</strong></a>. Thank you very much.', 'dragblock' ) . '</p>';
}
