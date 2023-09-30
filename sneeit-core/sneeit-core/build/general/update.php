<?php
/**
 * DragBlock's General.
 *
 * @package Update
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#123.
add_filter( 'update_themes_sneeit.com', 'sneeit_core_update_themes_sneeit', 1, 4 );
/**
 * Check Documentation#124
 *
 * @param object|array|string $sneeit_core_u_update check var-def#124.
 * @param object|array|string $sneeit_core_u_theme_data check var-def#124.
 * @param object|array|string $sneeit_core_u_theme_stylesheet check var-def#124.
 * @param object|array|string $sneeit_core_u_locales check var-def#124.
 */
function sneeit_core_update_themes_sneeit( $sneeit_core_u_update, array $sneeit_core_u_theme_data, string $sneeit_core_u_theme_stylesheet, $sneeit_core_u_locales ) {
	// dev-reply#1224.
	if ( ! empty( $sneeit_core_u_update ) ) {
		return $sneeit_core_u_update;
	}
	// dev-reply#1229.
	$sneeit_core_u_response = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-themes-release/main/{$sneeit_core_u_theme_stylesheet}/{$sneeit_core_u_theme_stylesheet}/style.css",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	// dev-reply#1237.
	$sneeit_core_u_output = '';
	if ( is_wp_error( $sneeit_core_u_response ) ) {
		return;
	} else {
		$sneeit_core_u_output = wp_remote_retrieve_body( $sneeit_core_u_response );
	}
	// dev-reply#1250.
	$sneeit_core_u_new_version = $sneeit_core_u_theme_data['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_u_output, $sneeit_core_u_matches ) ) {
		$sneeit_core_u_new_version = $sneeit_core_u_matches[1];
	} else {
		return;
	}
	// dev-reply#1257.
	if ( ! version_compare( $sneeit_core_u_new_version, $sneeit_core_u_theme_data['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_u_theme_stylesheet,
		'version' => $sneeit_core_u_new_version,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-themes-release/raw/main/{$sneeit_core_u_theme_stylesheet}/{$sneeit_core_u_theme_stylesheet}.zip",
	);
}
add_filter( 'update_plugins_sneeit.com', 'sneeit_core_update_plugins_sneeit', 1, 4 );
/**
 * Check Documentation#1243
 *
 * @param object|array|string $sneeit_core_u_update check var-def#1243.
 * @param object|array|string $sneeit_core_u_plugin_data check var-def#1243.
 * @param object|array|string $sneeit_core_u_plugin_file check var-def#1243.
 * @param object|array|string $sneeit_core_u_locales check var-def#1243.
 */
function sneeit_core_update_plugins_sneeit( $sneeit_core_u_update, array $sneeit_core_u_plugin_data, string $sneeit_core_u_plugin_file, $sneeit_core_u_locales ) {
	// dev-reply#1298.
	$sneeit_core_u_dragblock_path = dirname( SNEEIT_CORE_PLUGIN_PATH ) . '/dragblock/dragblock.php';
	if ( ! SNEEIT_CORE_IS_LOCALHOST || strpos( SNEEIT_CORE_PLUGIN_URL, 'localhost/release/' ) !== false ) {
		$sneeit_core_u_dragblock_content = file_get_contents( $sneeit_core_u_dragblock_path );
		if ( ( $sneeit_core_u_dragblock_content ) !== false && strpos( $sneeit_core_u_dragblock_content, 'Update URI:' ) === false ) {
			// dev-reply#12104.
			$sneeit_core_u_insert_pos = strpos( $sneeit_core_u_dragblock_content, ' * License:' );
			if ( ( $sneeit_core_u_insert_pos ) !== false ) {
				$sneeit_core_u_update_uri = " * Update URI: https://sneeit.com\n";
				$sneeit_core_u_new_content = substr_replace( $sneeit_core_u_dragblock_content, $sneeit_core_u_update_uri, $sneeit_core_u_insert_pos, 0 );
				file_put_contents( $sneeit_core_u_dragblock_path, $sneeit_core_u_new_content );
			}
		}
	}
	// dev-reply#12116.
	if ( ! empty( $sneeit_core_u_update ) ) {
		return $sneeit_core_u_update;
	}
	$sneeit_core_u_plugin_slug = $sneeit_core_u_plugin_data['TextDomain'];
	if ( empty( $sneeit_core_u_plugin_slug ) ) {
		return;
	}
	// dev-reply#12131.
	$sneeit_core_u_response = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-plugins-release/main/{$sneeit_core_u_plugin_slug}/{$sneeit_core_u_plugin_slug}/{$sneeit_core_u_plugin_slug}.php",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	$sneeit_core_u_output = '';
	if ( is_wp_error( $sneeit_core_u_response ) ) {
		return;
	} else {
		$sneeit_core_u_output = wp_remote_retrieve_body( $sneeit_core_u_response );
	}
	// dev-reply#12147.
	$sneeit_core_u_new_version = $sneeit_core_u_plugin_data['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_u_output, $sneeit_core_u_matches ) ) {
		$sneeit_core_u_new_version = $sneeit_core_u_matches[1];
	} else {
		return;
	}
	if ( ! version_compare( $sneeit_core_u_new_version, $sneeit_core_u_plugin_data['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_u_plugin_data['TextDomain'],
		'version' => $sneeit_core_u_new_version,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-plugins-release/raw/main/{$sneeit_core_u_plugin_slug}/{$sneeit_core_u_plugin_slug}.zip",
	);
}
// dev-reply#12168.
add_action( 'activated_plugin', 'sneeit_core_refresh_theme_update_checker' );
add_action( 'deactivated_plugin', 'sneeit_core_refresh_theme_update_checker' );
/**
 * Check Documentation#12100
 *
 * @param object|array|string $sneeit_core_u_plugin check var-def#12100.
 */
function sneeit_core_refresh_theme_update_checker( $sneeit_core_u_plugin ) {
	delete_site_transient( 'update_themes' );
	delete_transient( 'update_themes' );
}
add_action( 'after_switch_theme', 'sneeit_core_refresh_plugin_update_checker' );
/**
 * Check Documentation#12106
 *
 * @param object|array|string $sneeit_core_u_plugin check var-def#12106.
 */
function sneeit_core_refresh_plugin_update_checker( $sneeit_core_u_plugin ) {
	delete_site_transient( 'update_plugins' );
	delete_transient( 'update_plugins' );
}
// dev-reply#12186.
add_action( 'admin_footer', 'sneeit_core_refresh_update_checker' );
/**
 * Check Documentation#12113
 *
 * @param object|array|string $sneeit_core_u_plugin check var-def#12113.
 */
function sneeit_core_refresh_update_checker( $sneeit_core_u_plugin ) {
	if ( empty( get_transient( 'sneeit_update_checker' ) ) ) {
		set_transient( 'sneeit_update_checker', true, 60 * 60 * 24 ); // dev-reply#12191.
		delete_site_transient( 'update_themes' );
		delete_transient( 'update_themes' );
		delete_site_transient( 'update_plugins' );
		delete_transient( 'update_plugins' );
		delete_site_option( '_site_transient_update_plugins' );
		delete_site_option( '_site_transient_update_theme' );
	}
}
