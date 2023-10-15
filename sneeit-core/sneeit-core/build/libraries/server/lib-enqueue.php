<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#102
 *
 * @param object|array|string $sneeit_core_le_file check var-def#102.
 * @param object|array|string $sneeit_core_le_dep check var-def#102.
 */
function sneeit_core_enqueue_single( $sneeit_core_le_file, $sneeit_core_le_dep = null ) {
	$sneeit_core_le_slug = sneeit_core_text_to_slug( $sneeit_core_le_file );
	if ( strpos( $sneeit_core_le_file, '.css' ) !== false ) {
		wp_enqueue_style( $sneeit_core_le_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_le_file, $sneeit_core_le_dep, SNEEIT_CORE_VERSION );
	} else {
		wp_enqueue_script( $sneeit_core_le_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_le_file, $sneeit_core_le_dep, SNEEIT_CORE_VERSION, true );
	}
}
/**
 * Check Documentation#1011
 *
 * @param object|array|string $sneeit_core_le_files check var-def#1011.
 */
function sneeit_core_enqueue_multiple( $sneeit_core_le_files ) {
	if ( is_array( $sneeit_core_le_files ) ) {
		foreach ( $sneeit_core_le_files as $sneeit_core_le_key => $sneeit_core_le_file ) {
			// dev-reply#1018.
			if ( is_array( $sneeit_core_le_file ) ) {
				sneeit_core_enqueue_single( $sneeit_core_le_key, $sneeit_core_le_file );
				continue;
			}
			sneeit_core_enqueue_single( $sneeit_core_le_file );
		}
	} else {
		sneeit_core_enqueue_single( $sneeit_core_le_files );
	}
}
/**
 * Check Documentation#1026
 *
 * @param object|array|string $sneeit_core_le_slug check var-def#1026.
 * @param object|array|string $sneeit_core_le_location check var-def#1026.
 */
function sneeit_core_enqueue_app( $sneeit_core_le_slug, $sneeit_core_le_location = 'admin' ) {
	$sneeit_core_le_hook = 'admin_enqueue_scripts';
	if ( ( $sneeit_core_le_location ) === 'editor' ) {
		$sneeit_core_le_hook = 'enqueue_block_editor_assets';
	} elseif ( ( $sneeit_core_le_location ) === 'front' ) {
		$sneeit_core_le_hook = 'wp_enqueue_scripts';
	}
	if ( ( $sneeit_core_le_location ) === 'editor' ) {
		if ( strpos( $_SERVER['REQUEST_URI'], 'site-editor.php' ) === false ) {
			return;
		}
	} else {
		$sneeit_core_le_file = isset( $_GET['page'] ) ? $_GET['page'] : '';
		// dev-reply#1046.
		if ( empty( $sneeit_core_le_file ) ) {
			$sneeit_core_le_file = isset( $_GET['app'] ) ? $_GET['app'] : '';
		}
		// dev-reply#1050.
		if ( strpos( $sneeit_core_le_file, 'sneeit-core-' ) === false ) {
			return;
		}
		$sneeit_core_le_file = str_replace( 'sneeit-core-', '', $sneeit_core_le_file );
		if ( ( $sneeit_core_le_slug ) !== $sneeit_core_le_file ) {
			return;
		}
	}
	// dev-reply#1061.
	add_action(
		$sneeit_core_le_hook,
		/**
		 * Check Documentation#1056
		 */
		function() use ( $sneeit_core_le_slug, $sneeit_core_le_location ) {
			$sneeit_core_le_server = wp_get_theme();
			$sneeit_core_le_current = $sneeit_core_le_server->get( 'Name' );
			$sneeit_core_le_page = $sneeit_core_le_server->get( 'UpdateURI' );
			$sneeit_core_le_get = $sneeit_core_le_server->get( 'ThemeURI' );
			// dev-reply#1076.
			wp_enqueue_script( 'jquery' );
			wp_localize_script( 'jquery', 'sneeitCore', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
				'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
				'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
				'themePath' => get_stylesheet_directory(),
				'themeUrl' => get_stylesheet_directory_uri(),
				'themeUri' => $sneeit_core_le_get,
				'themeUpdateUri' => $sneeit_core_le_page,
				'themeName' => $sneeit_core_le_current,
				'themeSlug' => get_template(),
				'homeUrl' => home_url(),
				'uploadUrl' => wp_upload_dir()['url'],
				'isLocalhost' => SNEEIT_CORE_IS_LOCALHOST,
				// dev-reply#1092.
				'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#1093.,
			) );
			if ( ( $sneeit_core_le_location ) === 'editor' ) {
				sneeit_core_enqueue_single( "applications/{$sneeit_core_le_slug}/client/index.js", array( 'jquery' ) );
				sneeit_core_enqueue_single( "applications/{$sneeit_core_le_slug}/client/index.css" );
				return;
			}
			// dev-reply#10103.
			$sneeit_core_le_theme = include SNEEIT_CORE_BUILD_PATH . 'applications/' . $sneeit_core_le_slug . '/client/index.asset.php';
			// dev-reply#10108.
			foreach ( $sneeit_core_le_theme['dependencies'] as $sneeit_core_le_name ) {
				wp_enqueue_style( $sneeit_core_le_name );
			}
			// dev-reply#10112.
			array_push( $sneeit_core_le_theme['dependencies'], 'wp-i18n' );
			$sneeit_core_le_update = ( $sneeit_core_le_location ) === 'admin' ? '' : 'style-';
			// dev-reply#10117.
			sneeit_core_enqueue_multiple(
				array(
					"applications/{$sneeit_core_le_slug}/client/{$sneeit_core_le_update}index.css",
					"applications/{$sneeit_core_le_slug}/client/index.js" => $sneeit_core_le_theme['dependencies'],
				)
			);
		},
		1
	);
}
