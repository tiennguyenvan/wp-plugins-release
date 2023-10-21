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
		$sneeit_core_amr_globals = get_option( 'sneeit_license_username', '' );
		$sneeit_core_amr_sneeit = sneeit_core_is_license_required();
		// dev-reply#315.
		add_menu_page(
			'Sneeit Core', // dev-reply#317.
			'Sneeit Core' . ( $sneeit_core_amr_sneeit && ! $sneeit_core_amr_globals ? ' <span class="awaiting-mod">!</span>' : '' ), // dev-reply#318.
			'manage_options', // dev-reply#319.
			SNEEIT_CORE_SLUG,
			/**
			 * Check Documentation#323
			 *
			 * @param object|array|string $GLOBALS check var-def#323.
			 * @param object|array|string $sneeit_core_amr_globals check var-def#323.
			 * @param object|array|string $sneeit_core_amr_sneeit check var-def#323.
			 * @param object|array|string $sneeit_core_amr_sneeit check var-def#323.
			 * @param object|array|string $sneeit_core_amr_globals check var-def#323.
			 */
			function () {
				echo '<div class="' . SNEEIT_CORE_SLUG . ' app"></div>';
			},
			SNEEIT_CORE_IMAGE_URL . 'sneeit-logo-16.png', // dev-reply#327.
			6 // dev-reply#328.
		);
	},
	1
);
/**
 * Check Documentation#325
 */
add_action( 'admin_init', function() {
	// dev-reply#335.
	remove_submenu_page( SNEEIT_CORE_SLUG, SNEEIT_CORE_SLUG );
}, 100 );
