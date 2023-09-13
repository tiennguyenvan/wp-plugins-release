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
 * @param object|array|string $sneeit_core_0 check var-def#13.
 */
add_filter( 'upload_dir', function( $sneeit_core_0 ) {
	$sneeit_core_0['baseurl'] = set_url_scheme( $sneeit_core_0['baseurl'] );
	return $sneeit_core_0;
}, 1 );
