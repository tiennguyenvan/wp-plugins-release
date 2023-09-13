<?php
/**
 * DragBlock's Import.
 *
 * @package Plugins
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_plugins', 'sneeit_core_demo_import_plugins' );
	add_action( 'wp_ajax_sneeit_core_demo_import_plugins', 'sneeit_core_demo_import_plugins' );
endif; // dev-reply#109.
/**
 * Check Documentation#106
 *
 * @param object|array|string $sneeit_core_0 check var-def#106.
 */
function sneeit_core_demo_activate_plugin( $sneeit_core_0 ) {
	$sneeit_core_1 = sneeit_core_plugin_install_file( $sneeit_core_0 );
	if ( ! $sneeit_core_1 ) {
		/* translators: see trans-note#1010 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( '"%s" has invalid file', 'sneeit-core' ), $sneeit_core_0 ) );
	}
	// dev-reply#1018.
	wp_cache_delete( 'plugins', 'plugins' );
	$sneeit_core_2 = activate_plugin( $sneeit_core_1 );
	if ( is_wp_error( $sneeit_core_2 ) ) {
		/* translators: see trans-note#1016 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot active "%1$s": file %2$s %3$s', 'sneeit-core' ), $sneeit_core_0, $sneeit_core_1, $sneeit_core_2->get_error_message() ) );
	}
}
/**
 * Check Documentation#1019
 *
 * @param object|array|string $sneeit_core_3 check var-def#1019.
 * @param object|array|string $sneeit_core_0 check var-def#1019.
 */
function sneeit_core_demo_unzip_activate_plugin( $sneeit_core_3, $sneeit_core_0 ) {
	// dev-reply#1032.
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_4 = unzip_file( $sneeit_core_3, WP_PLUGIN_DIR );
	if ( is_wp_error( $sneeit_core_4 ) ) {
		/* translators: see trans-note#1026 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot unzip "%1$s": %2$s', 'sneeit-core' ), $sneeit_core_0, $sneeit_core_4->get_error_message() ) );
	}
	if ( ! is_dir( WP_PLUGIN_DIR . '/' . $sneeit_core_0 ) ) {
		/* translators: see trans-note#1029 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( '"%s" has invalid slug', 'sneeit-core' ), $sneeit_core_0 ) );
	}
	sneeit_core_demo_activate_plugin( $sneeit_core_0 );
}
/**
 * Check Documentation#1033
 *
 * @param object|array|string $sneeit_core_5 check var-def#1033.
 * @param object|array|string $sneeit_core_3 check var-def#1033.
 * @param object|array|string $sneeit_core_0 check var-def#1033.
 */
function sneeit_core_demo_download_unzip_activate_plugin( $sneeit_core_5, $sneeit_core_3, $sneeit_core_0 ) {
	$sneeit_core_6 = download_url( $sneeit_core_5 );
	if ( is_wp_error( $sneeit_core_6 ) ) {
		/* translators: see trans-note#1037 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot download "%1$s": %2$s', 'sneeit-core' ), $sneeit_core_0, $sneeit_core_6->get_error_message() ) );
	}
	$sneeit_core_7 = dirname( $sneeit_core_3 );
	// dev-reply#1056.
	if ( ! is_dir( $sneeit_core_7 ) ) {
		// dev-reply#1058.
		if ( ! mkdir( $sneeit_core_7, 0777 ) ) {
			unlink( $sneeit_core_6 );
			/* translators: see trans-note#1045 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot create folder of %s', 'sneeit-core' ), $sneeit_core_0 ) );
		}
	}
	// dev-reply#1065.
	if ( ! rename( $sneeit_core_6, $sneeit_core_3 ) ) {
		unlink( $sneeit_core_6 );
		/* translators: see trans-note#1051 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot upload %s', 'sneeit-core' ), $sneeit_core_0 ) );
	}
	sneeit_core_demo_unzip_activate_plugin( $sneeit_core_3, $sneeit_core_0 );
}
/**
 * Check Documentation#1055
 */
function sneeit_core_demo_import_plugins() {
	sneeit_core_ajax_request_verify_die( 'data' );
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	$sneeit_core_8 = $_POST['data'];
	// dev-reply#1081.
	$sneeit_core_9 = get_option( 'active_plugins' );
	foreach ( $sneeit_core_9 as $sneeit_core_10 ) {
		// dev-reply#1085.
		unset( $sneeit_core_8[ dirname( $sneeit_core_10 ) ] );
	}
	// dev-reply#1091.
	foreach ( $sneeit_core_8 as $sneeit_core_0 => $sneeit_core_11 ) {
		// dev-reply#1093.
		if ( is_dir( WP_PLUGIN_DIR . '/' . $sneeit_core_0 ) ) {
			sneeit_core_demo_activate_plugin( $sneeit_core_0 );
			continue;
		}
		$sneeit_core_12 = $sneeit_core_13 = get_template_directory() . '/plugins/';
		$sneeit_core_13 = $sneeit_core_12 . $sneeit_core_0 . '.zip';
		// dev-reply#10103.
		if ( empty( $sneeit_core_11 ) ) {
			// dev-reply#10106.
			if ( file_exists( $sneeit_core_13 ) ) {
				sneeit_core_demo_unzip_activate_plugin( $sneeit_core_13, $sneeit_core_0 );
				continue;
			}
			// dev-reply#10112.
			sneeit_core_demo_download_unzip_activate_plugin(
				'https://downloads.wordpress.org/plugin/' . $sneeit_core_0 . '.zip',
				$sneeit_core_13,
				$sneeit_core_0
			);
			continue;
		}
		// dev-reply#10122.
		if ( strpos( $sneeit_core_11, '://sneeit.com' ) ) {
			$sneeit_core_11 = "https://github.com/tiennguyenvan/{$sneeit_core_0}-release/raw/main/{$sneeit_core_0}.zip";
		} elseif ( strpos( $sneeit_core_11, '.zip' ) === false ) {
			$sneeit_core_11 .= '/' . $sneeit_core_0 . '.zip';
		}
		sneeit_core_demo_download_unzip_activate_plugin(
			$sneeit_core_11,
			$sneeit_core_13,
			$sneeit_core_0
		);
	}
	echo json_encode( 'done' );
	die();
}
