<?php
/**
 * DragBlock's Import.
 *
 * @package Import plugins
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
 * @param object|array|string $sneeit_core_ip_slug check var-def#106.
 */
function sneeit_core_demo_activate_plugin( $sneeit_core_ip_slug ) {
	$sneeit_core_ip_plugin = sneeit_core_plugin_install_file( $sneeit_core_ip_slug );
	if ( ! $sneeit_core_ip_plugin ) {
		/* translators: see trans-note#1010 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( '"%s" has invalid file', 'sneeit-core' ), $sneeit_core_ip_slug ) );
	}
	// dev-reply#1018.
	wp_cache_delete( 'plugins', 'plugins' );
	$sneeit_core_ip_file = activate_plugin( $sneeit_core_ip_plugin );
	if ( is_wp_error( $sneeit_core_ip_file ) ) {
		/* translators: see trans-note#1016 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot active "%1$s": file %2$s %3$s', 'sneeit-core' ), $sneeit_core_ip_slug, $sneeit_core_ip_plugin, $sneeit_core_ip_file->get_error_message() ) );
	}
}
/**
 * Check Documentation#1019
 *
 * @param object|array|string $sneeit_core_ip_active check var-def#1019.
 * @param object|array|string $sneeit_core_ip_slug check var-def#1019.
 */
function sneeit_core_demo_unzip_activate_plugin( $sneeit_core_ip_active, $sneeit_core_ip_slug ) {
	// dev-reply#1032.
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_ip_path = unzip_file( $sneeit_core_ip_active, WP_PLUGIN_DIR );
	if ( is_wp_error( $sneeit_core_ip_path ) ) {
		/* translators: see trans-note#1026 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot unzip "%1$s": %2$s', 'sneeit-core' ), $sneeit_core_ip_slug, $sneeit_core_ip_path->get_error_message() ) );
	}
	if ( ! is_dir( WP_PLUGIN_DIR . '/' . $sneeit_core_ip_slug ) ) {
		/* translators: see trans-note#1029 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( '"%s" has invalid slug', 'sneeit-core' ), $sneeit_core_ip_slug ) );
	}
	sneeit_core_demo_activate_plugin( $sneeit_core_ip_slug );
}
/**
 * Check Documentation#1033
 *
 * @param object|array|string $sneeit_core_ip_unzip check var-def#1033.
 * @param object|array|string $sneeit_core_ip_active check var-def#1033.
 * @param object|array|string $sneeit_core_ip_slug check var-def#1033.
 */
function sneeit_core_demo_download_unzip_activate_plugin( $sneeit_core_ip_unzip, $sneeit_core_ip_active, $sneeit_core_ip_slug ) {
	$sneeit_core_ip_url = download_url( $sneeit_core_ip_unzip );
	if ( is_wp_error( $sneeit_core_ip_url ) ) {
		/* translators: see trans-note#1037 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot download "%1$s": %2$s', 'sneeit-core' ), $sneeit_core_ip_slug, $sneeit_core_ip_url->get_error_message() ) );
	}
	$sneeit_core_ip_download = dirname( $sneeit_core_ip_active );
	// dev-reply#1056.
	if ( ! is_dir( $sneeit_core_ip_download ) ) {
		// dev-reply#1058.
		if ( ! mkdir( $sneeit_core_ip_download, 0777 ) ) {
			unlink( $sneeit_core_ip_url );
			/* translators: see trans-note#1045 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot create folder of %s', 'sneeit-core' ), $sneeit_core_ip_slug ) );
		}
	}
	// dev-reply#1065.
	if ( ! rename( $sneeit_core_ip_url, $sneeit_core_ip_active ) ) {
		unlink( $sneeit_core_ip_url );
		/* translators: see trans-note#1051 */
		sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot upload %s', 'sneeit-core' ), $sneeit_core_ip_slug ) );
	}
	sneeit_core_demo_unzip_activate_plugin( $sneeit_core_ip_active, $sneeit_core_ip_slug );
}
/**
 * Check Documentation#1055
 */
function sneeit_core_demo_import_plugins() {
	sneeit_core_ajax_request_verify_die( 'data' );
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	$sneeit_core_ip_dir = $_POST['data'];
	// dev-reply#1081.
	$sneeit_core_ip_plugins = get_option( 'active_plugins' );
	foreach ( $sneeit_core_ip_plugins as $sneeit_core_ip_post ) {
		// dev-reply#1085.
		unset( $sneeit_core_ip_dir[ dirname( $sneeit_core_ip_post ) ] );
	}
	// dev-reply#1091.
	foreach ( $sneeit_core_ip_dir as $sneeit_core_ip_slug => $sneeit_core_ip_short ) {
		// dev-reply#1093.
		if ( is_dir( WP_PLUGIN_DIR . '/' . $sneeit_core_ip_slug ) ) {
			sneeit_core_demo_activate_plugin( $sneeit_core_ip_slug );
			continue;
		}
		$sneeit_core_ip_update = $sneeit_core_ip_uri = get_template_directory() . '/plugins/';
		$sneeit_core_ip_uri = $sneeit_core_ip_update . $sneeit_core_ip_slug . '.zip';
		// dev-reply#10103.
		if ( empty( $sneeit_core_ip_short ) ) {
			// dev-reply#10106.
			if ( file_exists( $sneeit_core_ip_uri ) ) {
				sneeit_core_demo_unzip_activate_plugin( $sneeit_core_ip_uri, $sneeit_core_ip_slug );
				continue;
			}
			// dev-reply#10112.
			sneeit_core_demo_download_unzip_activate_plugin(
				'https://downloads.wordpress.org/plugin/' . $sneeit_core_ip_slug . '.zip',
				$sneeit_core_ip_uri,
				$sneeit_core_ip_slug
			);
			continue;
		}
		// dev-reply#10122.
		if ( strpos( $sneeit_core_ip_short, '://sneeit.com' ) ) {
			$sneeit_core_ip_short = "https://github.com/tiennguyenvan/{$sneeit_core_ip_slug}-release/raw/main/{$sneeit_core_ip_slug}.zip";
		} elseif ( strpos( $sneeit_core_ip_short, '.zip' ) === false ) {
			$sneeit_core_ip_short .= '/' . $sneeit_core_ip_slug . '.zip';
		}
		sneeit_core_demo_download_unzip_activate_plugin(
			$sneeit_core_ip_short,
			$sneeit_core_ip_uri,
			$sneeit_core_ip_slug
		);
	}
	echo json_encode( 'done' );
	die();
}
