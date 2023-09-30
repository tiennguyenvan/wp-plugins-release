<?php
/**
 * DragBlock's General.
 *
 * @package Enqueue
 */

if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Check Documentation#83
 *
 * @param object|array|string $sneeit_core_e_file check var-def#83.
 * @param object|array|string $sneeit_core_e_dep check var-def#83.
 */
function sneeit_core_enqueue_single( $sneeit_core_e_file, $sneeit_core_e_dep = null ) {
	$sneeit_core_e_slug = sneeit_core_text_to_slug( $sneeit_core_e_file );
	if ( strpos( $sneeit_core_e_file, '.css' ) !== false ) {
		wp_enqueue_style( $sneeit_core_e_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_e_file, $sneeit_core_e_dep, SNEEIT_CORE_VERSION );
	} else {
		wp_enqueue_script( $sneeit_core_e_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_e_file, $sneeit_core_e_dep, SNEEIT_CORE_VERSION, true );
	}
}
/**
 * Check Documentation#812
 *
 * @param object|array|string $sneeit_core_e_files check var-def#812.
 */
function sneeit_core_enqueue( $sneeit_core_e_files ) {
	if ( is_array( $sneeit_core_e_files ) ) {
		foreach ( $sneeit_core_e_files as $sneeit_core_e_key => $sneeit_core_e_file ) {
			// dev-reply#818.
			if ( is_array( $sneeit_core_e_file ) ) {
				sneeit_core_enqueue_single( $sneeit_core_e_key, $sneeit_core_e_file );
				continue;
			}
			sneeit_core_enqueue_single( $sneeit_core_e_file );
		}
	} else {
		sneeit_core_enqueue_single( $sneeit_core_e_files );
	}
}
add_action( 'wp_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
/**
 * Check Documentation#829
 */
function sneeit_core_enqueue_scripts() {
	$sneeit_core_e_current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
	if ( strpos( $sneeit_core_e_current_page, 'sneeit-core-' ) === false ) {
		return;
	}
	$sneeit_core_e_current_page = str_replace(
		'sneeit-core-',
		'',
		$sneeit_core_e_current_page
	);
	$sneeit_core_e_location = is_admin() ? 'back' : 'front';
	$sneeit_core_e_asset_path = SNEEIT_CORE_BUILD_PATH . '/' . $sneeit_core_e_location . '/' . $sneeit_core_e_current_page . '/index.asset.php';
	if ( ! file_exists( $sneeit_core_e_asset_path ) ) {
		return;
	}
	$sneeit_core_e_theme = wp_get_theme();
	$sneeit_core_e_theme_name = $sneeit_core_e_theme->get( 'Name' );
	$sneeit_core_e_theme_update_uri = $sneeit_core_e_theme->get( 'UpdateURI' );
	$sneeit_core_e_theme_uri = $sneeit_core_e_theme->get( 'ThemeURI' );
	wp_enqueue_script( 'jquery' );
	wp_localize_script( 'jquery', 'sneeitCore', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
		'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
		'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
		'themePath' => get_stylesheet_directory(),
		'themeUrl' => get_stylesheet_directory_uri(),
		'themeUri' => $sneeit_core_e_theme_uri,
		'themeUpdateUri' => $sneeit_core_e_theme_update_uri,
		'themeName' => $sneeit_core_e_theme_name,
		'themeSlug' => get_template(),
		'homeUrl' => home_url(),
		'uploadUrl' => wp_upload_dir()['url'],
		'isLocalhost' => SNEEIT_CORE_IS_LOCALHOST,
		// dev-reply#873.
		'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#874.,
	) );
	$sneeit_core_e_asset_file = include $sneeit_core_e_asset_path;
	// dev-reply#881.
	foreach ( $sneeit_core_e_asset_file['dependencies'] as $sneeit_core_e_style ) {
		wp_enqueue_style( $sneeit_core_e_style );
	}
	array_push( $sneeit_core_e_asset_file['dependencies'], 'wp-i18n' );
	sneeit_core_enqueue( array( $sneeit_core_e_location . '/' . $sneeit_core_e_current_page . '/style-index.css', $sneeit_core_e_location . '/' . $sneeit_core_e_current_page . '/index.js' => $sneeit_core_e_asset_file['dependencies'] ) );
}
