<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib app
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#22
 *
 * @param object|array|string $sneeit_core_la_slug check var-def#22.
 * @param object|array|string $sneeit_core_la_title check var-def#22.
 */
function sneeit_core_admin_app_register( $sneeit_core_la_slug, $sneeit_core_la_title = '' ) {
	if ( empty( $sneeit_core_la_title ) ) {
		$sneeit_core_la_title = ucwords( str_replace( '-', ' ', $sneeit_core_la_slug ) );
	}
	sneeit_core_admin_submenu_register( $sneeit_core_la_slug, $sneeit_core_la_title );
	sneeit_core_enqueue_app( $sneeit_core_la_slug );
}
/**
 * Check Documentation#210
 *
 * @param object|array|string $sneeit_core_la_slug check var-def#210.
 * @param object|array|string $sneeit_core_la_title check var-def#210.
 */
function sneeit_core_front_app_register( $sneeit_core_la_slug, $sneeit_core_la_title = '' ) {
	if ( is_admin() ) {
		return;
	}
	if ( empty( $sneeit_core_la_title ) ) {
		$sneeit_core_la_title = ucwords( str_replace( '-', ' ', $sneeit_core_la_slug ) );
	}
	sneeit_core_admin_bar_menu_register( $sneeit_core_la_slug, $sneeit_core_la_title );
	sneeit_core_enqueue_app( $sneeit_core_la_slug, 'front' );
}
