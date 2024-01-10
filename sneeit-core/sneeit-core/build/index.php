<?php
/**
 * DragBlock's .
 *
 * @package Build
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	define( 'SNEEIT_CORE_BUILD_URL', SNEEIT_CORE_PLUGIN_URL . 'build/' );
	define( 'SNEEIT_CORE_BUILD_PATH', SNEEIT_CORE_PLUGIN_PATH . 'build/' );
	define( 'SNEEIT_CORE_SRC_URL', SNEEIT_CORE_PLUGIN_URL . 'src/' );
	define( 'SNEEIT_CORE_SRC_PATH', SNEEIT_CORE_PLUGIN_PATH . 'src/' );
	define( 'SNEEIT_CORE_IMAGE_URL', SNEEIT_CORE_PLUGIN_URL . 'images/' );
	define( 'SNEEIT_CORE_IMAGE_PATH', SNEEIT_CORE_PLUGIN_PATH . 'images/' );
	define( 'SNEEIT_CORE_BLANK_IMAGE_PATH', SNEEIT_CORE_IMAGE_PATH . 'blank.png' );
	define( 'SNEEIT_CORE_BLANK_IMAGE_URL', SNEEIT_CORE_IMAGE_URL . 'blank.png' );
	define( 'SNEEIT_CORE_SLUG', 'sneeit-core' );
	define( 'SNEEIT_CORE_KEY_NONCE', 'sneeit-core-nonce' );
	define( 'SNEEIT_CORE_SITE_FAVICON_META_KEY', 'sneeit_core_site_favicon' );
	define( 'SNEEIT_CORE_SITE_THEME_COLOR_META_KEY', 'sneeit_core_theme_color' );
	define( 'SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME', 'sneeit_license_username' );
	if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
		define( 'WP_ENVIRONMENT_TYPE', 'live' );
	}
	define(
		'SNEEIT_CORE_IS_LOCAL',
		defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'local'
	);
	define( 'SNEEIT_CORE_VERSION', SNEEIT_CORE_IS_LOCAL ? time() : '23.10.14' );
	require_once SNEEIT_CORE_BUILD_PATH . 'libraries/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/admin-menu/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/import/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/activate/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/patterns/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/seo/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/site-settings/server/index.php';
// dev-reply#444.
