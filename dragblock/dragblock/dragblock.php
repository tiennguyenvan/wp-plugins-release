<?php
/**
 * Plugin Name: DragBlock
 * Plugin URI: https://dragblock.com/
 * Requires at least: 5.9
 * Requires PHP: 7.0
 * Version: 23.09.13
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

require_once 'build/index.php';
