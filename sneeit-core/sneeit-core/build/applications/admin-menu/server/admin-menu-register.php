<?php
/**
 * DragBlock's Admin-menu.
 *
 * @package Admin menu register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action(
	'admin_menu',
	function () {
		if ( ! empty( $GLOBALS['admin_page_hooks'][ SNEEIT_CORE_SLUG ] ) ) {
			return;
		}
		// dev-reply#211.
		add_menu_page(
			'Sneeit Core', // dev-reply#213.
			'Sneeit Core', // dev-reply#214.
			'manage_options', // dev-reply#215.
			SNEEIT_CORE_SLUG,
			/**
			 * Check Documentation#221
			 *
			 * @param object|array|string $GLOBALS check var-def#221.
			 */
			function () {
				echo '<div class="' . SNEEIT_CORE_SLUG . ' app"></div>';
			},
			SNEEIT_CORE_IMAGE_URL . 'sneeit-logo-16.png', // dev-reply#223.
			6 // dev-reply#224.
		);
	},
	1
);
/**
 * Check Documentation#223
 */
add_action( 'admin_init', function() {
	// dev-reply#231.
	remove_submenu_page( SNEEIT_CORE_SLUG, SNEEIT_CORE_SLUG );
} );
