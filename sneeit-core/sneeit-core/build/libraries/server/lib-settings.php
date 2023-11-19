<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#15
 *
 * @param object|array|string $sneeit_core_ls_upload check var-def#15.
 * @param object|array|string $sneeit_core_ls_upload check var-def#15.
 * @param object|array|string $sneeit_core_ls_upload check var-def#15.
 * @param object|array|string $sneeit_core_ls_upload check var-def#15.
 */
add_filter( 'upload_dir', function ( $sneeit_core_ls_upload = array() ) {
	$sneeit_core_ls_upload['baseurl'] = set_url_scheme( $sneeit_core_ls_upload['baseurl'] );
	return $sneeit_core_ls_upload;
}, 1, 1 );
