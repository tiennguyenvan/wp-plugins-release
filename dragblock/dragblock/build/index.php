<?php
/**
 * DragBlock's .
 *
 * @package Build
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_OPENSSL_CONF', isset( $_SERVER['OPENSSL_CONF'] ) ? sanitize_text_field( wp_unslash( $_SERVER['OPENSSL_CONF'] ) ) : '' );
define(
	'DRAGBLOCK_IS_LOCAL',
	strpos( DRAGBLOCK_OPENSSL_CONF, 'C:/' ) === 0 ||
		strpos( DRAGBLOCK_OPENSSL_CONF, 'D:/' ) === 0 ||
		strpos( DRAGBLOCK_OPENSSL_CONF, 'E:/' ) === 0
);
define( 'DRAGBLOCK_SITE_LOCALE', get_locale() );
define( 'DRAGBLOCK_VERSION', DRAGBLOCK_IS_LOCAL ? time() : get_plugin_data( DRAGBLOCK_FILE_PATH )['Version'] );
define( 'DRAGBLOCK_URL', plugin_dir_url( DRAGBLOCK_FILE_PATH ) );
define( 'DRAGBLOCK_PATH', plugin_dir_path( DRAGBLOCK_FILE_PATH ) );
define( 'DRAGBLOCK_BUILD_URL', DRAGBLOCK_URL . 'build/' );
define( 'DRAGBLOCK_BUILD_PATH', DRAGBLOCK_PATH . 'build/' );
define( 'DRAGBLOCK_APP_URL', DRAGBLOCK_BUILD_URL . 'applications/' );
define( 'DRAGBLOCK_APP_PATH', DRAGBLOCK_BUILD_PATH . 'applications/' );
// dev-reply#418.
define( 'DRAGBLOCK_CUSTOM_DEFAULT_STYLE', false );
add_action( 'init', 'dragblock_init_defines', 1 );
/**
 * Check Documentation#420
 */
function dragblock_init_defines() {
	$dragblock_0 = wp_upload_dir();
	define( 'DRAGBLOCK_UPLOAD_DIR', $dragblock_0['basedir'] . '/dragblock' );
	define( 'DRAGBLOCK_UPLOAD_URL', $dragblock_0['baseurl'] . '/dragblock' );
	// dev-reply#430.
}
require_once 'library/server/index.php';
require_once 'applications/editor-init/server/index.php';
require_once 'applications/editor-panel-content/server/index.php';
require_once 'applications/editor-panel-attributes/server/index.php';
require_once 'applications/editor-panel-appearance/server/index.php';
require_once 'applications/editor-panel-interactions/server/index.php';
require_once 'applications/editor-panel-database/server/index.php'; // dev-reply#444.
require_once 'blocks/block-register.php';
require_once 'applications/admin-menu/server/index.php';
require_once 'applications/form-entries/server/index.php';
require_once 'applications/font-library/server/index.php';
require_once 'applications/theme-settings/server/index.php';
require_once 'applications/shortcodes/server/index.php';
