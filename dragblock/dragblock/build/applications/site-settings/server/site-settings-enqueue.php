<?php
/**
 * DragBlock's Site-settings.
 *
 * @package Site settings enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_enqueue_scripts', 'dragblock_site_settings_assets' );
/**
 * Check Documentation#23
 */
function dragblock_site_settings_assets() {
	// dev-reply#29.
	global $pagenow;
	if ( ( $pagenow ) === 'options-general.php' ) { // dev-reply#211.
		$dragblock_sse_pagenow = 'site-settings';
		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
		wp_localize_script( 'jquery', 'dragBlockAdmin', dragblock_admin_common_inline_init_script( array(
			'siteFaviconKey' => DRAGBLOCK_SITE_FAVICON_META_KEY,
		) ) );
		dragblock_enqueue( "dragblock-{$dragblock_sse_pagenow}", "build/applications/{$dragblock_sse_pagenow}/client/index.js" );
		dragblock_enqueue( "dragblock-{$dragblock_sse_pagenow}", "build/applications/{$dragblock_sse_pagenow}/client/index.css" );
	}
}
