<?php
/**
 * DragBlock's General.
 *
 * @package Enqueue
 */

if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Check Documentation#93
 *
 * @param object|array|string $sneeit_core_0 check var-def#93.
 * @param object|array|string $sneeit_core_1 check var-def#93.
 */
function sneeit_core_enqueue_single( $sneeit_core_0, $sneeit_core_1 = null ) {
	$sneeit_core_2 = '';
	if ( SNEEIT_CORE_IS_LOCALHOST ) {
		$sneeit_core_2 = time();
	} elseif ( ! defined( 'SNEEIT_CORE_PLUGIN_VERSION' ) ) {
		$sneeit_core_3 = get_plugin_data( SNEEIT_CORE_PLUGIN_PATH_FILE );
		define( 'SNEEIT_CORE_PLUGIN_VERSION', $sneeit_core_3['Version'] );
		$sneeit_core_2 = SNEEIT_CORE_PLUGIN_VERSION;
	} else {
		$sneeit_core_2 = SNEEIT_CORE_PLUGIN_VERSION;
	}
	$sneeit_core_4 = sneeit_core_text_to_slug( $sneeit_core_0 );
	if ( strpos( $sneeit_core_0, '.css' ) !== false ) {
		wp_enqueue_style( $sneeit_core_4, SNEEIT_CORE_BUILD_URL . $sneeit_core_0, $sneeit_core_1, $sneeit_core_2 );
	} else {
		wp_enqueue_script( $sneeit_core_4, SNEEIT_CORE_BUILD_URL . $sneeit_core_0, $sneeit_core_1, $sneeit_core_2, true );
	}
}
/**
 * Check Documentation#922
 *
 * @param object|array|string $sneeit_core_5 check var-def#922.
 */
function sneeit_core_enqueue( $sneeit_core_5 ) {
	if ( is_array( $sneeit_core_5 ) ) {
		foreach ( $sneeit_core_5 as $sneeit_core_6 => $sneeit_core_0 ) {
			// dev-reply#929.
			if ( is_array( $sneeit_core_0 ) ) {
				sneeit_core_enqueue_single( $sneeit_core_6, $sneeit_core_0 );
				continue;
			}
			sneeit_core_enqueue_single( $sneeit_core_0 );
		}
	} else {
		sneeit_core_enqueue_single( $sneeit_core_5 );
	}
}
add_action( 'wp_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
/**
 * Check Documentation#939
 */
function sneeit_core_enqueue_scripts() {
	$sneeit_core_7 = isset( $_GET['page'] ) ? $_GET['page'] : '';
	if ( strpos( $sneeit_core_7, 'sneeit-core-' ) === false ) {
		return;
	}
	$sneeit_core_7 = str_replace(
		'sneeit-core-',
		'',
		$sneeit_core_7
	);
	$sneeit_core_8 = is_admin() ? 'back' : 'front';
	$sneeit_core_9 = SNEEIT_CORE_BUILD_PATH . '/' . $sneeit_core_8 . '/' . $sneeit_core_7 . '/index.asset.php';
	if ( ! file_exists( $sneeit_core_9 ) ) {
		return;
	}
	$sneeit_core_10 = wp_get_theme();
	$sneeit_core_11 = $sneeit_core_10->get( 'Name' );
	$sneeit_core_12 = $sneeit_core_10->get( 'UpdateURI' );
	$sneeit_core_13 = $sneeit_core_10->get( 'ThemeURI' );
	wp_enqueue_script( 'jquery' );
	wp_localize_script( 'jquery', 'sneeitCore', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
		'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
		'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
		'themePath' => get_stylesheet_directory(),
		'themeUrl' => get_stylesheet_directory_uri(),
		'themeUri' => $sneeit_core_13,
		'themeUpdateUri' => $sneeit_core_12,
		'themeName' => $sneeit_core_11,
		'themeSlug' => get_template(),
		'homeUrl' => home_url(),
		'uploadUrl' => wp_upload_dir()['url'],
		'isLocalhost' => SNEEIT_CORE_IS_LOCALHOST,
		// dev-reply#984.
		'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#985.,
	) );
	$sneeit_core_14 = include $sneeit_core_9;
	// dev-reply#992.
	foreach ( $sneeit_core_14['dependencies'] as $sneeit_core_15 ) {
		wp_enqueue_style( $sneeit_core_15 );
	}
	array_push( $sneeit_core_14['dependencies'], 'wp-i18n' );
	sneeit_core_enqueue( array( $sneeit_core_8 . '/' . $sneeit_core_7 . '/style-index.css', $sneeit_core_8 . '/' . $sneeit_core_7 . '/index.js' => $sneeit_core_14['dependencies'] ) );
}
