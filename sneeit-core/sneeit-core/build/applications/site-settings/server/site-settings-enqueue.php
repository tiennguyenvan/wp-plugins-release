<?php
/**
 * DragBlock's Site-settings.
 *
 * @package Site settings enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_init', 'sneeit_core_site_settings_assets' );
/**
 * Check Documentation#13
 */
function sneeit_core_site_settings_assets() {
	// dev-reply#110.
	sneeit_core_enqueue_app( 'site-settings', 'options-general.php', array( 'media', 'wp-color-picker' ) );
}
