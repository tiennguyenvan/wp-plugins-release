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
			$sneeit_core_lam_sneeit = get_option( 'sneeit_license_username', '' );
			$sneeit_core_lam_license = sneeit_core_is_license_required();
			add_submenu_page(
				SNEEIT_CORE_SLUG, // dev-reply#512.
				$sneeit_core_lam_title,
				$sneeit_core_lam_title . ( ( $sneeit_core_lam_slug ) === 'activate' && $sneeit_core_lam_license && ! $sneeit_core_lam_sneeit ? ' <span class="awaiting-mod">!</span>' : '' ),
				'manage_options', // dev-reply#515.
				SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug, // dev-reply#516.
				/**
				 * Check Documentation#515
				 */
				function() use ( $sneeit_core_lam_slug ) {
					echo '<div class="' . SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug . ' app"></div>';
				}
			);
		}
	);
}
/**
 * Check Documentation#522
 *
 * @param object|array|string $sneeit_core_lam_slug check var-def#522.
 */
function sneeit_core_admin_bar_menu_register( $sneeit_core_lam_slug ) {
	/**
	 * Check Documentation#524
	 */
	add_action( 'wp_before_admin_bar_render', function() use ( $sneeit_core_lam_slug ) {
		$sneeit_core_lam_title = ucwords( str_replace( '-', ' ', $sneeit_core_lam_slug ) );
		global $wp_admin_bar;
		$sneeit_core_lam_username = SNEEIT_CORE_SLUG . '-' . $sneeit_core_lam_slug;
		$sneeit_core_lam_required = isset( $_GET['app'] ) ? $_GET['app'] : '';
		// dev-reply#534.
		if ( empty( $sneeit_core_lam_required ) ) {
			$wp_admin_bar->add_menu(
				array(
					'id'    => $sneeit_core_lam_username,
					'title' => 'Launch ' . $sneeit_core_lam_title,
					'href'  => add_query_arg( 'app', $sneeit_core_lam_username ),
					'meta'  => array(
						'class' => $sneeit_core_lam_username,
						// dev-reply#543.
					),
				)
			);
		} elseif ( ( $sneeit_core_lam_required ) === $sneeit_core_lam_username ) {
			$sneeit_core_lam_wp = remove_query_arg( 'app', $_SERVER['REQUEST_URI'] );
			$wp_admin_bar->add_menu(
				array(
					'id'    => $sneeit_core_lam_username . '-exit',
					'title' => 'Exit ' . $sneeit_core_lam_title,
					'href'  => $sneeit_core_lam_wp,
					'meta'  => array(
						'class' => $sneeit_core_lam_username . '-exit',
					),
				)
			);
		}
	} );
}
