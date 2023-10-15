<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib admin menu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#52
 *
 * @param object|array|string $sneeit_core_lam_slug check var-def#52.
 * @param object|array|string $sneeit_core_lam_title check var-def#52.
 */
function sneeit_core_admin_submenu_register( $sneeit_core_lam_slug, $sneeit_core_lam_title = 'Sneeit Sub Menu' ) {
	add_action(
		'admin_menu',
		/**
		 * Check Documentation#56
		 */
		function() use ( $sneeit_core_lam_slug, $sneeit_core_lam_title ) {
			add_submenu_page(
				SNEEIT_CORE_SLUG, // dev-reply#59.
				$sneeit_core_lam_title,
				$sneeit_core_lam_title,
				'manage_options', // dev-reply#512.
				SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug, // dev-reply#513.
				/**
				 * Check Documentation#513
				 */
				function() use ( $sneeit_core_lam_slug ) {
					echo '<div class="' . SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug . ' app"></div>';
				}
			);
		}
	);
}
/**
 * Check Documentation#520
 *
 * @param object|array|string $sneeit_core_lam_slug check var-def#520.
 */
function sneeit_core_admin_bar_menu_register( $sneeit_core_lam_slug ) {
	/**
	 * Check Documentation#522
	 */
	add_action( 'wp_before_admin_bar_render', function() use ( $sneeit_core_lam_slug ) {
		$sneeit_core_lam_title = ucwords( str_replace( '-', ' ', $sneeit_core_lam_slug ) );
		global $wp_admin_bar;
		$sneeit_core_lam_wp = SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug;
		$sneeit_core_lam_admin = isset( $_GET['app'] ) ? $_GET['app'] : '';
		// dev-reply#531.
		if ( empty( $sneeit_core_lam_admin ) ) {
			$wp_admin_bar->add_menu(
				array(
					'id'    => $sneeit_core_lam_wp,
					'title' => 'Launch ' . $sneeit_core_lam_title,
					'href'  => add_query_arg( 'app', $sneeit_core_lam_wp ),
					'meta'  => array(
						'class' => $sneeit_core_lam_wp,
						// dev-reply#540.
					),
				)
			);
		} elseif ( ( $sneeit_core_lam_admin ) === $sneeit_core_lam_wp ) {
			$sneeit_core_lam_bar = remove_query_arg( 'app', $_SERVER['REQUEST_URI'] );
			$wp_admin_bar->add_menu(
				array(
					'id'    => $sneeit_core_lam_wp . '-exit',
					'title' => 'Exit ' . $sneeit_core_lam_title,
					'href'  => $sneeit_core_lam_bar,
					'meta'  => array(
						'class' => $sneeit_core_lam_wp . '-exit',
					),
				)
			);
		}
	} );
}
