<?php

/**
 * Plugin Name: Sneeit Core
 * Plugin URI:  https://sneeit.com/
 * Version: 23.10.21-1614
 * Author:      Sneeit.Com
 * Author URI:  https://sneeit.com/
 * Update URI:  https://sneeit.com/
 * Requires at least: 5.9
 * Requires PHP: 7.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sneeit-core
 * Domain Path: /languages 
 * Description: This plugin will help theme developers import demos, and authenticating and updating their themes
 * @package sneeit-core
 */
if (!defined('ABSPATH')) exit;


define('SNEEIT_CORE_MICROSERVICE', true);
/******************************************/
/*DEFINES*/



/*common*/
define('SNEEIT_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SNEEIT_CORE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SNEEIT_CORE_PLUGIN_PATH_FILE', __FILE__);


if (SNEEIT_CORE_MICROSERVICE) :
    require_once SNEEIT_CORE_PLUGIN_PATH . 'build/index.php';
else:
    /*URL parts*/
    define('SNEEIT_CORE_BUILD_URL', SNEEIT_CORE_PLUGIN_URL . 'build/');
    define('SNEEIT_CORE_BUILD_PATH', SNEEIT_CORE_PLUGIN_PATH . 'build/');

    define('SNEEIT_CORE_SRC_URL', SNEEIT_CORE_PLUGIN_URL . 'src/');
    define('SNEEIT_CORE_SRC_PATH', SNEEIT_CORE_PLUGIN_PATH . 'src/');

    define('SNEEIT_CORE_IMAGE_URL', SNEEIT_CORE_PLUGIN_URL . 'images/');
    define('SNEEIT_CORE_IMAGE_PATH', SNEEIT_CORE_PLUGIN_PATH . 'images/');

    define('SNEEIT_CORE_BLANK_IMAGE_PATH', SNEEIT_CORE_IMAGE_PATH . 'blank.png');
    define('SNEEIT_CORE_BLANK_IMAGE_URL', SNEEIT_CORE_IMAGE_URL . 'blank.png');
    define('SNEEIT_CORE_KEY_NONCE', 'sneeit-core-nonce');

    /**
don't change this key
     */
    define('SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME', 'sneeit_license_username');

    define(
        'SNEEIT_CORE_IS_LOCAL',
        !empty($_SERVER['OPENSSL_CONF']) && (strpos($_SERVER['OPENSSL_CONF'], 'C:/') == 0 ||
            strpos($_SERVER['OPENSSL_CONF'], 'D:/') == 0 ||
            strpos($_SERVER['OPENSSL_CONF'], 'E:/') == 0
        )
    );
    define('SNEEIT_CORE_VERSION', SNEEIT_CORE_IS_LOCAL ? time() : '23.10.21-1614');

    function sneeit_core_include_files_recursive($folder_path)
    {
        $file_paths = glob($folder_path . '/*.php');

        foreach ($file_paths as $file_path) {
            if (basename($file_path) === 'index.asset.php' || strpos($file_path, 'applications/') !== false || strpos($file_path, 'libraries/') !== false) {
                continue;
            }
            require_once $file_path;
        }

        $sub_folders = glob($folder_path . '/*', GLOB_ONLYDIR);

        foreach ($sub_folders as $sub_folder) {
            sneeit_core_include_files_recursive($sub_folder);
        }
    }

    // if rename a file, please restart the start again
    // for the plugins like this where we release to customers' sites,
    // we should allow to check for the status after building immediately
    $folder_path = SNEEIT_CORE_BUILD_PATH;

    if (is_dir(SNEEIT_CORE_SRC_PATH)) {
        $folder_path = SNEEIT_CORE_SRC_PATH;
    }
    sneeit_core_include_files_recursive($folder_path);

endif;


