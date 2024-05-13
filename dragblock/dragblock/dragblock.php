<?php

/**
 * Plugin Name: DragBlock
 * Plugin URI: https://dragblock.com/
 * Requires at least: 5.9
 * Requires PHP: 7.0
 * Version: 24.05.12
 * Author: DragBlock.Com
 * Author URI: https://dragblock.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Design stunning websites without any coding knowledge using DragBlock, the feature-rich Gutenberg plugin for lightning-fast site creation.
 * Text Domain: dragblock
 * Domain Path: /languages
 *
 * @package dragblock
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'DRAGBLOCK_FILE_PATH', __FILE__ );
define( 'DRAGBLOCK_OPENSSL_CONF', isset( $_SERVER['OPENSSL_CONF'] ) ? sanitize_text_field( wp_unslash( $_SERVER['OPENSSL_CONF'] ) ) : '' );
if (!defined('WP_ENVIRONMENT_TYPE')) {
    define('WP_ENVIRONMENT_TYPE', 'live');
}
define(
	'DRAGBLOCK_IS_LOCAL',
	defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local'
);
define( 'DRAGBLOCK_VERSION', DRAGBLOCK_IS_LOCAL ? time() : '24.05.12' );
require_once 'build/index.php';


