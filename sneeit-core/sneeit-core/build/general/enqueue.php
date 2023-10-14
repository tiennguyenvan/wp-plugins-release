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
	$sneeit_core_e_current = isset( $_GET['page'] ) ? $_GET['page'] : '';
	if ( strpos( $sneeit_core_e_current, 'sneeit-core-' ) === false ) {
		return;
	}
	$sneeit_core_e_current = str_replace(
		'sneeit-core-',
		'',
		$sneeit_core_e_current
	);
	$sneeit_core_e_page = is_admin() ? 'back' : 'front';
	$sneeit_core_e_file = SNEEIT_CORE_BUILD_PATH . '/' . $sneeit_core_e_page . '/' . $sneeit_core_e_current . '/index.asset.php';
	if ( ! file_exists( $sneeit_core_e_file ) ) {
		return;
	}
	$sneeit_core_e_get = wp_get_theme();
	$sneeit_core_e_location = $sneeit_core_e_get->get( 'Name' );
	$sneeit_core_e_asset = $sneeit_core_e_get->get( 'UpdateURI' );
	$sneeit_core_e_path = $sneeit_core_e_get->get( 'ThemeURI' );
	wp_enqueue_script( 'jquery' );
	wp_localize_script( 'jquery', 'sneeitCore', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
		'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
		'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
		'themePath' => get_stylesheet_directory(),
		'themeUrl' => get_stylesheet_directory_uri(),
		'themeUri' => $sneeit_core_e_path,
		'themeUpdateUri' => $sneeit_core_e_asset,
		'themeName' => $sneeit_core_e_location,
		'themeSlug' => get_template(),
		'homeUrl' => home_url(),
		'uploadUrl' => wp_upload_dir()['url'],
		'isLocalhost' => SNEEIT_CORE_IS_LOCALHOST,
		// dev-reply#873.
		'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#874.,
	) );
	$sneeit_core_e_theme = include $sneeit_core_e_file;
	// dev-reply#881.
	foreach ( $sneeit_core_e_theme['dependencies'] as $sneeit_core_e_name ) {
		wp_enqueue_style( $sneeit_core_e_name );
	}
	array_push( $sneeit_core_e_theme['dependencies'], 'wp-i18n' );
	sneeit_core_enqueue( array( $sneeit_core_e_page . '/' . $sneeit_core_e_current . '/style-index.css', $sneeit_core_e_page . '/' . $sneeit_core_e_current . '/index.js' => $sneeit_core_e_theme['dependencies'] ) );
}
