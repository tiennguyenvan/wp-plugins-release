<?php
/**
 * DragBlock's General.
 *
 * @package Settings
 */

if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Check Documentation#13
 *
 * @param object|array|string $sneeit_core_s_upload_dir check var-def#13.
 */
add_filter( 'upload_dir', function( $sneeit_core_s_upload_dir ) {
	$sneeit_core_s_upload_dir['baseurl'] = set_url_scheme( $sneeit_core_s_upload_dir['baseurl'] );
	return $sneeit_core_s_upload_dir;
}, 1 );
