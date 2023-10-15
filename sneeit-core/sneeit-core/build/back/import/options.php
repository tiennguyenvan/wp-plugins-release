<?php
/**
 * DragBlock's Import.
 *
 * @package Options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_options', 'sneeit_core_demo_import_options' );
	add_action( 'wp_ajax_sneeit_core_demo_import_options', 'sneeit_core_demo_import_options' );
endif; // dev-reply#29.
/**
 * Check Documentation#26
 */
function sneeit_core_demo_import_options() {
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_o_options = $_POST['data'];
	foreach ( $sneeit_core_o_options as $sneeit_core_o_post=>$sneeit_core_o_key ) {
		update_option( $sneeit_core_o_post, $sneeit_core_o_key );
	}
	echo json_encode( 'done' );
	die();
}
