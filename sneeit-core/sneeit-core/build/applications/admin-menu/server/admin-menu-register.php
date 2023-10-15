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
		// dev-reply#26.
		add_menu_page(
			'Sneeit Core', // dev-reply#28.
			'Sneeit Core', // dev-reply#29.
			'manage_options', // dev-reply#210.
			SNEEIT_CORE_SLUG,
			/**
			 * Check Documentation#217
			 */
			function () {
				echo '<div class="' . SNEEIT_CORE_SLUG . ' app"></div>';
			}, // dev-reply#217.
			SNEEIT_CORE_IMAGE_URL . 'sneeit-logo-16.png', // dev-reply#218.
			6 // dev-reply#219.
		);
	}
);
