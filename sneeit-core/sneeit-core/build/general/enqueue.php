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
 * @param object|array|string $sneeit_core_0 check var-def#83.
 * @param object|array|string $sneeit_core_1 check var-def#83.
 */
function sneeit_core_enqueue_single( $sneeit_core_0, $sneeit_core_1 = null ) {
	$sneeit_core_2 = sneeit_core_text_to_slug( $sneeit_core_0 );
	if ( strpos( $sneeit_core_0, '.css' ) !== false ) {
		wp_enqueue_style( $sneeit_core_2, SNEEIT_CORE_BUILD_URL . $sneeit_core_0, $sneeit_core_1, SNEEIT_CORE_VERSION );
	} else {
		wp_enqueue_script( $sneeit_core_2, SNEEIT_CORE_BUILD_URL . $sneeit_core_0, $sneeit_core_1, SNEEIT_CORE_VERSION, true );
	}
}
/**
 * Check Documentation#812
 *
 * @param object|array|string $sneeit_core_3 check var-def#812.
 */
function sneeit_core_enqueue( $sneeit_core_3 ) {
	if ( is_array( $sneeit_core_3 ) ) {
		foreach ( $sneeit_core_3 as $sneeit_core_4 => $sneeit_core_0 ) {
			// dev-reply#818.
			if ( is_array( $sneeit_core_0 ) ) {
				sneeit_core_enqueue_single( $sneeit_core_4, $sneeit_core_0 );
				continue;
			}
			sneeit_core_enqueue_single( $sneeit_core_0 );
		}
	} else {
		sneeit_core_enqueue_single( $sneeit_core_3 );
	}
}
add_action( 'wp_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'sneeit_core_enqueue_scripts' );
/**
 * Check Documentation#829
 */
function sneeit_core_enqueue_scripts() {
	$sneeit_core_5 = isset( $_GET['page'] ) ? $_GET['page'] : '';
	if ( strpos( $sneeit_core_5, 'sneeit-core-' ) === false ) {
		return;
	}
	$sneeit_core_5 = str_replace(
		'sneeit-core-',
		'',
		$sneeit_core_5
	);
	$sneeit_core_6 = is_admin() ? 'back' : 'front';
	$sneeit_core_7 = SNEEIT_CORE_BUILD_PATH . '/' . $sneeit_core_6 . '/' . $sneeit_core_5 . '/index.asset.php';
	if ( ! file_exists( $sneeit_core_7 ) ) {
		return;
	}
	$sneeit_core_8 = wp_get_theme();
	$sneeit_core_9 = $sneeit_core_8->get( 'Name' );
	$sneeit_core_10 = $sneeit_core_8->get( 'UpdateURI' );
	$sneeit_core_11 = $sneeit_core_8->get( 'ThemeURI' );
	wp_enqueue_script( 'jquery' );
	wp_localize_script( 'jquery', 'sneeitCore', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
		'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
		'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
		'themePath' => get_stylesheet_directory(),
		'themeUrl' => get_stylesheet_directory_uri(),
		'themeUri' => $sneeit_core_11,
		'themeUpdateUri' => $sneeit_core_10,
		'themeName' => $sneeit_core_9,
		'themeSlug' => get_template(),
		'homeUrl' => home_url(),
		'uploadUrl' => wp_upload_dir()['url'],
		'isLocalhost' => SNEEIT_CORE_IS_LOCALHOST,
		// dev-reply#873.
		'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#874.,
	) );
	$sneeit_core_12 = include $sneeit_core_7;
	// dev-reply#881.
	foreach ( $sneeit_core_12['dependencies'] as $sneeit_core_13 ) {
		wp_enqueue_style( $sneeit_core_13 );
	}
	array_push( $sneeit_core_12['dependencies'], 'wp-i18n' );
	sneeit_core_enqueue( array( $sneeit_core_6 . '/' . $sneeit_core_5 . '/style-index.css', $sneeit_core_6 . '/' . $sneeit_core_5 . '/index.js' => $sneeit_core_12['dependencies'] ) );
}
