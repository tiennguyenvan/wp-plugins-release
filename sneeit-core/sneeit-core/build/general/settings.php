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
 * @param object|array|string $sneeit_core_s_upload check var-def#13.
 */
add_filter( 'upload_dir', function( $sneeit_core_s_upload ) {
	$sneeit_core_s_upload['baseurl'] = set_url_scheme( $sneeit_core_s_upload['baseurl'] );
	return $sneeit_core_s_upload;
}, 1 );
