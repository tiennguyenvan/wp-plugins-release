<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib update
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#113.
add_filter( 'update_themes_sneeit.com', 'sneeit_core_update_themes_sneeit', 1, 4 );
/**
 * Check Documentation#114
 *
 * @param object|array|string $sneeit_core_lu_update check var-def#114.
 * @param object|array|string $sneeit_core_lu_theme check var-def#114.
 * @param object|array|string $sneeit_core_lu_data check var-def#114.
 * @param object|array|string $sneeit_core_lu_stylesheet check var-def#114.
 */
function sneeit_core_update_themes_sneeit( $sneeit_core_lu_update, array $sneeit_core_lu_theme, string $sneeit_core_lu_data, $sneeit_core_lu_stylesheet ) {
	// dev-reply#1124.
	if ( ! empty( $sneeit_core_lu_update ) ) {
		return $sneeit_core_lu_update;
	}
	// dev-reply#1129.
	$sneeit_core_lu_locales = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-themes-release/main/{$sneeit_core_lu_data}/{$sneeit_core_lu_data}/style.css",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	// dev-reply#1137.
	$sneeit_core_lu_response = '';
	if ( is_wp_error( $sneeit_core_lu_locales ) ) {
		return;
	} else {
		$sneeit_core_lu_response = wp_remote_retrieve_body( $sneeit_core_lu_locales );
	}
	// dev-reply#1150.
	$sneeit_core_lu_output = $sneeit_core_lu_theme['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_lu_response, $sneeit_core_lu_new ) ) {
		$sneeit_core_lu_output = $sneeit_core_lu_new[1];
	} else {
		return;
	}
	// dev-reply#1157.
	if ( ! version_compare( $sneeit_core_lu_output, $sneeit_core_lu_theme['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_lu_data,
		'version' => $sneeit_core_lu_output,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-themes-release/raw/main/{$sneeit_core_lu_data}/{$sneeit_core_lu_data}.zip",
	);
}
add_filter( 'update_plugins_sneeit.com', 'sneeit_core_update_plugins_sneeit', 1, 4 );
/**
 * Check Documentation#1143
 *
 * @param object|array|string $sneeit_core_lu_update check var-def#1143.
 * @param object|array|string $sneeit_core_lu_version check var-def#1143.
 * @param object|array|string $sneeit_core_lu_matches check var-def#1143.
 * @param object|array|string $sneeit_core_lu_stylesheet check var-def#1143.
 */
function sneeit_core_update_plugins_sneeit( $sneeit_core_lu_update, array $sneeit_core_lu_version, string $sneeit_core_lu_matches, $sneeit_core_lu_stylesheet ) {
	// dev-reply#1198.
	$sneeit_core_lu_plugin = dirname( SNEEIT_CORE_PLUGIN_PATH ) . '/dragblock/dragblock.php';
	if ( true ) {
		$sneeit_core_lu_file = file_get_contents( $sneeit_core_lu_plugin );
		if ( ( $sneeit_core_lu_file ) !== false && strpos( $sneeit_core_lu_file, 'Update URI:' ) === false ) {
			// dev-reply#11108.
			$sneeit_core_lu_dragblock = strpos( $sneeit_core_lu_file, ' * License:' );
			if ( ( $sneeit_core_lu_dragblock ) !== false ) {
				$sneeit_core_lu_path = " * Update URI: https://sneeit.com\n";
				$sneeit_core_lu_content = substr_replace( $sneeit_core_lu_file, $sneeit_core_lu_path, $sneeit_core_lu_dragblock, 0 );
				file_put_contents( $sneeit_core_lu_plugin, $sneeit_core_lu_content );
			}
		}
	}
	// dev-reply#11120.
	if ( ! empty( $sneeit_core_lu_update ) ) {
		return $sneeit_core_lu_update;
	}
	$sneeit_core_lu_insert = $sneeit_core_lu_version['TextDomain'];
	if ( empty( $sneeit_core_lu_insert ) ) {
		return;
	}
	// dev-reply#11135.
	$sneeit_core_lu_locales = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-plugins-release/main/{$sneeit_core_lu_insert}/{$sneeit_core_lu_insert}/{$sneeit_core_lu_insert}.php",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	$sneeit_core_lu_response = '';
	if ( is_wp_error( $sneeit_core_lu_locales ) ) {
		return;
	} else {
		$sneeit_core_lu_response = wp_remote_retrieve_body( $sneeit_core_lu_locales );
	}
	// dev-reply#11151.
	$sneeit_core_lu_output = $sneeit_core_lu_version['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_lu_response, $sneeit_core_lu_new ) ) {
		$sneeit_core_lu_output = $sneeit_core_lu_new[1];
	} else {
		return;
	}
	if ( ! version_compare( $sneeit_core_lu_output, $sneeit_core_lu_version['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_lu_version['TextDomain'],
		'version' => $sneeit_core_lu_output,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-plugins-release/raw/main/{$sneeit_core_lu_insert}/{$sneeit_core_lu_insert}.zip",
	);
}
// dev-reply#11172.
add_action( 'activated_plugin', 'sneeit_core_refresh_theme_update_checker' );
add_action( 'deactivated_plugin', 'sneeit_core_refresh_theme_update_checker' );
/**
 * Check Documentation#11100
 *
 * @param object|array|string $sneeit_core_lu_pos check var-def#11100.
 */
function sneeit_core_refresh_theme_update_checker( $sneeit_core_lu_pos ) {
	delete_site_transient( 'update_themes' );
	delete_transient( 'update_themes' );
}
add_action( 'after_switch_theme', 'sneeit_core_refresh_plugin_update_checker' );
/**
 * Check Documentation#11106
 *
 * @param object|array|string $sneeit_core_lu_pos check var-def#11106.
 */
function sneeit_core_refresh_plugin_update_checker( $sneeit_core_lu_pos ) {
	delete_site_transient( 'update_plugins' );
	delete_transient( 'update_plugins' );
}
// dev-reply#11190.
add_action( 'admin_footer', 'sneeit_core_refresh_update_checker' );
/**
 * Check Documentation#11113
 *
 * @param object|array|string $sneeit_core_lu_pos check var-def#11113.
 */
function sneeit_core_refresh_update_checker( $sneeit_core_lu_pos ) {
	if ( empty( get_transient( 'sneeit_update_checker' ) ) ) {
		set_transient( 'sneeit_update_checker', true, 60 * 60 * 24 ); // dev-reply#11195.
		delete_site_transient( 'update_themes' );
		delete_transient( 'update_themes' );
		delete_site_transient( 'update_plugins' );
		delete_transient( 'update_plugins' );
		delete_site_option( '_site_transient_update_plugins' );
		delete_site_option( '_site_transient_update_theme' );
	}
}