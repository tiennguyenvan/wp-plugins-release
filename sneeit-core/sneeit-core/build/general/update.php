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
 * @param object|array|string $sneeit_core_0 check var-def#124.
 * @param object|array|string $sneeit_core_1 check var-def#124.
 * @param object|array|string $sneeit_core_2 check var-def#124.
 * @param object|array|string $sneeit_core_3 check var-def#124.
 */
function sneeit_core_update_themes_sneeit( $sneeit_core_0, array $sneeit_core_1, string $sneeit_core_2, $sneeit_core_3 ) {
	// dev-reply#1224.
	if ( ! empty( $sneeit_core_0 ) ) {
		return $sneeit_core_0;
	}
	// dev-reply#1229.
	$sneeit_core_4 = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-themes-release/main/{$sneeit_core_2}/{$sneeit_core_2}/style.css",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	// dev-reply#1237.
	$sneeit_core_5 = '';
	if ( is_wp_error( $sneeit_core_4 ) ) {
		return;
	} else {
		$sneeit_core_5 = wp_remote_retrieve_body( $sneeit_core_4 );
	}
	// dev-reply#1250.
	$sneeit_core_6 = $sneeit_core_1['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_5, $sneeit_core_7 ) ) {
		$sneeit_core_6 = $sneeit_core_7[1];
	} else {
		return;
	}
	// dev-reply#1257.
	if ( ! version_compare( $sneeit_core_6, $sneeit_core_1['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_2,
		'version' => $sneeit_core_6,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-themes-release/raw/main/{$sneeit_core_2}/{$sneeit_core_2}.zip",
	);
}
add_filter( 'update_plugins_sneeit.com', 'sneeit_core_update_plugins_sneeit', 1, 4 );
/**
 * Check Documentation#1243
 *
 * @param object|array|string $sneeit_core_0 check var-def#1243.
 * @param object|array|string $sneeit_core_8 check var-def#1243.
 * @param object|array|string $sneeit_core_9 check var-def#1243.
 * @param object|array|string $sneeit_core_3 check var-def#1243.
 */
function sneeit_core_update_plugins_sneeit( $sneeit_core_0, array $sneeit_core_8, string $sneeit_core_9, $sneeit_core_3 ) {
	// dev-reply#1298.
	$sneeit_core_10 = dirname( SNEEIT_CORE_PLUGIN_PATH ) . '/dragblock/dragblock.php';
	if ( ! SNEEIT_CORE_IS_LOCALHOST || strpos( SNEEIT_CORE_PLUGIN_URL, 'localhost/release/' ) !== false ) {
		$sneeit_core_11 = file_get_contents( $sneeit_core_10 );
		if ( ( $sneeit_core_11 ) !== false && strpos( $sneeit_core_11, 'Update URI:' ) === false ) {
			// dev-reply#12104.
			$sneeit_core_12 = strpos( $sneeit_core_11, ' * License:' );
			if ( ( $sneeit_core_12 ) !== false ) {
				$sneeit_core_13 = " * Update URI: https://sneeit.com\n";
				$sneeit_core_14 = substr_replace( $sneeit_core_11, $sneeit_core_13, $sneeit_core_12, 0 );
				file_put_contents( $sneeit_core_10, $sneeit_core_14 );
			}
		}
	}
	// dev-reply#12116.
	if ( ! empty( $sneeit_core_0 ) ) {
		return $sneeit_core_0;
	}
	$sneeit_core_15 = $sneeit_core_8['TextDomain'];
	if ( empty( $sneeit_core_15 ) ) {
		return;
	}
	// dev-reply#12131.
	$sneeit_core_4 = wp_remote_get(
		"https://raw.githubusercontent.com/tiennguyenvan/wp-plugins-release/main/{$sneeit_core_15}/{$sneeit_core_15}/{$sneeit_core_15}.php",
		array(
			'user-agent' => 'tiennguyenvan',
		)
	);
	$sneeit_core_5 = '';
	if ( is_wp_error( $sneeit_core_4 ) ) {
		return;
	} else {
		$sneeit_core_5 = wp_remote_retrieve_body( $sneeit_core_4 );
	}
	// dev-reply#12147.
	$sneeit_core_6 = $sneeit_core_8['Version'];
	if ( preg_match( '/Version:\s+(\S+)/', $sneeit_core_5, $sneeit_core_7 ) ) {
		$sneeit_core_6 = $sneeit_core_7[1];
	} else {
		return;
	}
	if ( ! version_compare( $sneeit_core_6, $sneeit_core_8['Version'], '>' ) ) {
		return;
	}
	return array(
		'slug'    => $sneeit_core_8['TextDomain'],
		'version' => $sneeit_core_6,
		'url'     => '',
		'package' => "https://github.com/tiennguyenvan/wp-plugins-release/raw/main/{$sneeit_core_15}/{$sneeit_core_15}.zip",
	);
}
// dev-reply#12168.
add_action( 'activated_plugin', 'sneeit_core_refresh_theme_update_checker' );
add_action( 'deactivated_plugin', 'sneeit_core_refresh_theme_update_checker' );
/**
 * Check Documentation#12100
 *
 * @param object|array|string $sneeit_core_16 check var-def#12100.
 */
function sneeit_core_refresh_theme_update_checker( $sneeit_core_16 ) {
	delete_site_transient( 'update_themes' );
	delete_transient( 'update_themes' );
}
add_action( 'after_switch_theme', 'sneeit_core_refresh_plugin_update_checker' );
/**
 * Check Documentation#12106
 *
 * @param object|array|string $sneeit_core_16 check var-def#12106.
 */
function sneeit_core_refresh_plugin_update_checker( $sneeit_core_16 ) {
	delete_site_transient( 'update_plugins' );
	delete_transient( 'update_plugins' );
}
// dev-reply#12186.
add_action( 'admin_footer', 'sneeit_core_refresh_update_checker' );
/**
 * Check Documentation#12113
 *
 * @param object|array|string $sneeit_core_16 check var-def#12113.
 */
function sneeit_core_refresh_update_checker( $sneeit_core_16 ) {
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
