<?php
/**
 * DragBlock's Library.
 *
 * @package Lib identify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#92
 */
function dragblock_get_current_browser() {
	static $dragblock_li_browser_name = null;
	if ( ( $dragblock_li_browser_name ) !== null ) {
		// dev-reply#98.
		return $dragblock_li_browser_name;
	}
	$dragblock_li_browser_name = '';
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return $dragblock_li_browser_name;
	}
	$dragblock_li_user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
	if ( strpos( $dragblock_li_user_agent, 'Chrome' ) !== false ) {
		$dragblock_li_browser_name = 'chrome';
	} elseif ( strpos( $dragblock_li_user_agent, 'Firefox' ) !== false ) {
		$dragblock_li_browser_name = 'firefox';
	} elseif ( strpos( $dragblock_li_user_agent, 'Edge' ) !== false ) {
		$dragblock_li_browser_name = 'edge';
	} elseif ( strpos( $dragblock_li_user_agent, 'MSIE' ) !== false || strpos( $dragblock_li_user_agent, 'Trident/' ) !== false ) {
		$dragblock_li_browser_name = 'ie';
	} elseif ( strpos( $dragblock_li_user_agent, 'Opera' ) !== false ) {
		$dragblock_li_browser_name = 'opera';
	} elseif ( strpos( $dragblock_li_user_agent, 'Safari' ) !== false ) {
		$dragblock_li_browser_name = 'safari';
	} elseif ( strpos( $dragblock_li_user_agent, 'SamsungBrowser' ) !== false ) {
		$dragblock_li_browser_name = 'samsungi';
	}
	return strtolower( $dragblock_li_browser_name );
}
/**
 * Check Documentation#931
 */
function dragblock_get_current_device() {
	static $dragblock_li_device = null;
	if ( ( $dragblock_li_device ) !== null ) {
		// dev-reply#944.
		return $dragblock_li_device;
	}
	$dragblock_li_device = 'desktop';
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return $dragblock_li_device;
	}
	$dragblock_li_user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
	$dragblock_li_tablet_patterns = array(
		'/ipad/i',
		'/android(?!.*mobile)/i',
	);
	$dragblock_li_mobile_patterns = array(
		'/iphone/i',
		'/ipod/i',
		'/android.*mobile/i',
		'/windows phone/i',
		'/blackberry/i',
		'/nokia/i',
		'/sony/i',
		'/lg/i',
		'/htc/i',
		'/mot/i',
		'/samsung/i',
		'/palm/i',
		'/zte/i',
		'/fennec/i',
		'/opera mobi/i',
		'/opera mini/i',
		'/iemobile/i',
	);
	foreach ( $dragblock_li_tablet_patterns as $dragblock_li_pattern ) {
		if ( preg_match( $dragblock_li_pattern, $dragblock_li_user_agent ) ) {
			$dragblock_li_device = 'tablet';
			break;
		}
	}
	foreach ( $dragblock_li_mobile_patterns as $dragblock_li_pattern ) {
		if ( preg_match( $dragblock_li_pattern, $dragblock_li_user_agent ) ) {
			$dragblock_li_device = 'mobile';
			break;
		}
	}
	// dev-reply#993.
	return $dragblock_li_device;
}
/**
 * Check Documentation#981
 */
function dragblock_get_current_os() {
	static $dragblock_li_os = null;
	if ( ( $dragblock_li_os ) !== null ) {
		// dev-reply#9102.
		return $dragblock_li_os;
	}
	$dragblock_li_os = '';
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return $dragblock_li_os;
	}
	$dragblock_li_user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
	$dragblock_li_os_platforms = array(
		'windows' => '/windows/i',
		'linux' => '/linux/i',
		'macintosh' => '/macintosh|mac os x/i',
		'ios' => '/iphone|ipad|ipod/i',
		'android' => '/android/i',
	);
	foreach ( $dragblock_li_os_platforms as $dragblock_li_platform => $dragblock_li_pattern ) {
		if ( preg_match( $dragblock_li_pattern, $dragblock_li_user_agent ) ) {
			$dragblock_li_os = $dragblock_li_platform;
		}
	}
	// dev-reply#9126.
	return $dragblock_li_os;
}
