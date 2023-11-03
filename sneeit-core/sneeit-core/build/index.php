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
	define( 'SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME', 'sneeit_license_username' );
	define(
		'SNEEIT_CORE_IS_LOCAL',
		! empty( $_SERVER['OPENSSL_CONF'] ) && ( strpos( $_SERVER['OPENSSL_CONF'], 'C:/' ) === 0 ||
			strpos( $_SERVER['OPENSSL_CONF'], 'D:/' ) === 0 ||
			strpos( $_SERVER['OPENSSL_CONF'], 'E:/' ) === 0
		)
	);
	define( 'SNEEIT_CORE_VERSION', SNEEIT_CORE_IS_LOCAL ? time() : '23.10.14' );
	require_once SNEEIT_CORE_BUILD_PATH . 'libraries/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/admin-menu/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/import/server/index.php';
	require_once SNEEIT_CORE_BUILD_PATH . 'applications/activate/server/index.php';
// dev-reply#437.
