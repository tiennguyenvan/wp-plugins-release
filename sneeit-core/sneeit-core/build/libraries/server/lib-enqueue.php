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
 * Check Documentation#132
 *
 * @param object|array|string $sneeit_core_le_file check var-def#132.
 * @param object|array|string $sneeit_core_le_dep check var-def#132.
 */
function sneeit_core_enqueue_single( $sneeit_core_le_file, $sneeit_core_le_dep = null ) {
	$sneeit_core_le_slug = sneeit_core_text_to_slug( $sneeit_core_le_file );
	if ( strpos( $sneeit_core_le_file, '.css' ) !== false ) {
		wp_enqueue_style( $sneeit_core_le_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_le_file, $sneeit_core_le_dep, SNEEIT_CORE_VERSION );
	} else {
		wp_enqueue_script( $sneeit_core_le_slug, SNEEIT_CORE_BUILD_URL . $sneeit_core_le_file, $sneeit_core_le_dep, SNEEIT_CORE_VERSION, true );
		add_filter( 'load_script_translation_file', 'sneeit_core_translate_path', 10, 3 );
		wp_set_script_translations( $sneeit_core_le_slug, 'sneeit-core', SNEEIT_CORE_PLUGIN_PATH . '/languages/' );
		// dev-reply#1316.
	}
}
/**
 * Check Documentation#1314
 *
 * @param object|array|string $sneeit_core_le_file check var-def#1314.
 * @param object|array|string $sneeit_core_le_handle check var-def#1314.
 * @param object|array|string $sneeit_core_le_domain check var-def#1314.
 */
function sneeit_core_translate_path( $sneeit_core_le_file, $sneeit_core_le_handle, $sneeit_core_le_domain ) {
	if ( 'sneeit-core' !== $sneeit_core_le_domain ) {
		return $sneeit_core_le_file;
	}
	return str_replace( '-' . $sneeit_core_le_handle, '', $sneeit_core_le_file );
}
/**
 * Check Documentation#1321
 *
 * @param object|array|string $sneeit_core_le_files check var-def#1321.
 */
function sneeit_core_enqueue_multiple( $sneeit_core_le_files ) {
	if ( is_array( $sneeit_core_le_files ) ) {
		foreach ( $sneeit_core_le_files as $sneeit_core_le_key => $sneeit_core_le_file ) {
			// dev-reply#1334.
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
 * Check Documentation#1336
 *
 * @param object|array|string $sneeit_core_le_slug check var-def#1336.
 * @param object|array|string $sneeit_core_le_location check var-def#1336.
 * @param object|array|string $sneeit_core_le_dependencies check var-def#1336.
 */
function sneeit_core_enqueue_app( $sneeit_core_le_slug, $sneeit_core_le_location = 'admin', $sneeit_core_le_dependencies = array() ) {
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
		// dev-reply#1359.
		if ( empty( $_GET[ SNEEIT_CORE_SLUG ] ) || $_GET[ SNEEIT_CORE_SLUG ] !== $sneeit_core_le_slug ) {
			return;
		}
	} elseif ( strpos( $sneeit_core_le_location, '.php' ) !== false ) {
		// dev-reply#1368.
	} else {
		$sneeit_core_le_server = isset( $_GET['page'] ) ? $_GET['page'] : '';
		// dev-reply#1371.
		if ( empty( $sneeit_core_le_server ) ) {
			$sneeit_core_le_server = isset( $_GET['app'] ) ? $_GET['app'] : '';
		}
		// dev-reply#1375.
		if ( strpos( $sneeit_core_le_server, 'sneeit-core-' ) === false ) {
			return;
		}
		$sneeit_core_le_server = str_replace( 'sneeit-core-', '', $sneeit_core_le_server );
		if ( ( $sneeit_core_le_slug ) !== $sneeit_core_le_server ) {
			return;
		}
	}
	// dev-reply#1386.
	add_action(
		$sneeit_core_le_hook,
		/**
		 * Check Documentation#1374
		 */
		function() use ( $sneeit_core_le_slug, $sneeit_core_le_location, $sneeit_core_le_dependencies ) {
			// dev-reply#1395.
			if ( strpos( $sneeit_core_le_location, '.php' ) !== false ) {
				global $pagenow;
				if ( ( $pagenow ) !== $sneeit_core_le_location ) {
					return;
				}
				$sneeit_core_le_location = 'admin';
			}
			$sneeit_core_le_get = wp_get_theme();
			$sneeit_core_le_current = $sneeit_core_le_get->get( 'Name' );
			$sneeit_core_le_page = $sneeit_core_le_get->get( 'UpdateURI' );
			$sneeit_core_le_pagenow = $sneeit_core_le_get->get( 'ThemeURI' );
			// dev-reply#13111.
			wp_enqueue_script( 'jquery' );
			wp_localize_script( 'jquery', 'sneeitCore', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( SNEEIT_CORE_KEY_NONCE ),
				'imgUrl'   => SNEEIT_CORE_IMAGE_URL,
				'blankImgUrl'   => SNEEIT_CORE_BLANK_IMAGE_URL,
				'themePath' => get_stylesheet_directory(),
				'themeUrl' => get_stylesheet_directory_uri(),
				'themeUri' => $sneeit_core_le_pagenow,
				'themeUpdateUri' => $sneeit_core_le_page,
				'themeName' => $sneeit_core_le_current,
				'themeSlug' => get_template(),
				'homeUrl' => home_url(),
				'adminUrl' => admin_url(),
				'uploadUrl' => wp_upload_dir()['url'],
				'isLocalhost' => SNEEIT_CORE_IS_LOCAL,
				// dev-reply#13129.
				'sneeitLicenseUsername' => get_option( SNEEIT_CORE_KEY_SNEEIT_LICENSE_USERNAME, '' ), // dev-reply#13130.
				'siteFaviconKey' => SNEEIT_CORE_SITE_FAVICON_META_KEY,
				'siteThemeColorKey' => SNEEIT_CORE_SITE_THEME_COLOR_META_KEY,
			) );
			foreach ( $sneeit_core_le_dependencies as $sneeit_core_le_theme ) {
				if ( 'media' === $sneeit_core_le_theme ) {
					wp_enqueue_media();
					continue;
				}
				wp_enqueue_style( $sneeit_core_le_theme );
				wp_enqueue_script( $sneeit_core_le_theme );
			}
			// dev-reply#13144.
			if ( ( $sneeit_core_le_location ) === 'editor' ) {
				sneeit_core_enqueue_single( "applications/{$sneeit_core_le_slug}/client/index.js", array( 'jquery' ) );
				sneeit_core_enqueue_single( "applications/{$sneeit_core_le_slug}/client/index.css" );
				// dev-reply#13148.
				return;
			}
			// dev-reply#13152.
			$sneeit_core_le_name = include SNEEIT_CORE_BUILD_PATH . 'applications/' . $sneeit_core_le_slug . '/client/index.asset.php';
			// dev-reply#13157.
			foreach ( $sneeit_core_le_name['dependencies'] as $sneeit_core_le_update ) {
				wp_enqueue_style( $sneeit_core_le_update );
			}
			// dev-reply#13161.
			array_push( $sneeit_core_le_name['dependencies'], 'wp-i18n' );
			$sneeit_core_le_uri = ( $sneeit_core_le_location ) === 'admin' ? '' : 'style-';
			// dev-reply#13167.
			sneeit_core_enqueue_multiple(
				array(
					"applications/{$sneeit_core_le_slug}/client/{$sneeit_core_le_uri}index.css",
					"applications/{$sneeit_core_le_slug}/client/index.js" => $sneeit_core_le_name['dependencies'],
				)
			);
			// dev-reply#13175.
		},
		1
	);
}
