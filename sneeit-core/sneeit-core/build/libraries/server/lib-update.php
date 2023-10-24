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
	if ( ! empty( $sneeit_core_lu_update ) ) {
		return $sneeit_core_lu_update;
	}
	$sneeit_core_lu_plugin = $sneeit_core_lu_version['TextDomain'];
	if ( empty( $sneeit_core_lu_plugin ) ) {
		return;
	}
	// dev-reply#11166.
	$sneeit_core_lu_locales = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-plugins-release/main/{$sneeit_core_lu_plugin}/{$sneeit_core_lu_plugin}/{$sneeit_core_lu_plugin}.php",
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
	// dev-reply#11182.
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
		'package' => "https://github.com/tiennguyenvan/wp-plugins-release/raw/main/{$sneeit_core_lu_plugin}/{$sneeit_core_lu_plugin}.zip",
	);
}
// dev-reply#11203.
add_action( 'activated_plugin', 'sneeit_core_refresh_theme_update_checker' );
add_action( 'deactivated_plugin', 'sneeit_core_refresh_theme_update_checker' );
/**
 * Check Documentation#1185
 *
 * @param object|array|string $sneeit_core_lu_file check var-def#1185.
 */
function sneeit_core_refresh_theme_update_checker( $sneeit_core_lu_file ) {
	delete_site_transient( 'update_themes' );
	delete_transient( 'update_themes' );
}
add_action( 'after_switch_theme', 'sneeit_core_refresh_plugin_update_checker' );
/**
 * Check Documentation#1191
 *
 * @param object|array|string $sneeit_core_lu_file check var-def#1191.
 */
function sneeit_core_refresh_plugin_update_checker( $sneeit_core_lu_file ) {
	delete_site_transient( 'update_plugins' );
	delete_transient( 'update_plugins' );
}
// dev-reply#11221.
add_action( 'admin_footer', 'sneeit_core_refresh_update_checker' );
/**
 * Check Documentation#1198
 *
 * @param object|array|string $sneeit_core_lu_file check var-def#1198.
 */
function sneeit_core_refresh_update_checker( $sneeit_core_lu_file ) {
	if ( empty( get_transient( 'sneeit_update_checker' ) ) ) {
		set_transient( 'sneeit_update_checker', true, 60 * 60 * 24 ); // dev-reply#11226.
		delete_site_transient( 'update_themes' );
		delete_transient( 'update_themes' );
		delete_site_transient( 'update_plugins' );
		delete_transient( 'update_plugins' );
		delete_site_option( '_site_transient_update_plugins' );
		delete_site_option( '_site_transient_update_theme' );
	}
}
