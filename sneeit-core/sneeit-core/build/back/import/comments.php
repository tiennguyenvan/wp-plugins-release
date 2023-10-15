<?php
/**
 * DragBlock's Import.
 *
 * @package Comments
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_comments', 'sneeit_core_demo_import_comments' );
	add_action( 'wp_ajax_sneeit_core_demo_import_comments', 'sneeit_core_demo_import_comments' );
endif; // dev-reply#59.
/**
 * Check Documentation#56
 */
function sneeit_core_demo_import_comments() {
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_c_data = $_POST['data'];
	$sneeit_core_c_post = array();
	foreach ( $sneeit_core_c_data as $sneeit_core_c_parents => $sneeit_core_c_id ) {
		$sneeit_core_c_comments = sneeit_core_get_demo_post_id( $sneeit_core_c_parents );
		if ( empty( $sneeit_core_c_comments ) ) {
			// dev-reply#521.
			continue;
		}
		// dev-reply#526.
		foreach ( $sneeit_core_c_id as $sneeit_core_c_comment => $sneeit_core_c_args ) {
			$sneeit_core_c_real = array(
				'comment_post_ID' => (int) $sneeit_core_c_comments,
			);
			if ( ! empty( $sneeit_core_c_args['email'] ) ) {
				$sneeit_core_c_real['comment_author_email'] = $sneeit_core_c_args['email'];
			}
			if ( ! empty( $sneeit_core_c_args['name'] ) ) {
				$sneeit_core_c_real['comment_author'] = $sneeit_core_c_args['email'];
			}
			$sneeit_core_c_parent = wp_insert_comment( $sneeit_core_c_real );
			if ( empty( $sneeit_core_c_parent ) ) {
				continue;
			}
			update_comment_meta( $sneeit_core_c_parent, 'sneeit-demo-id', $sneeit_core_c_comment );
			if ( ! empty( $sneeit_core_c_args['parent'] ) ) {
				$sneeit_core_c_post[ $sneeit_core_c_parent ] = $sneeit_core_c_args['parent'];
			}
		}
		// dev-reply#550.
		if ( count( $sneeit_core_c_post ) ) {
			foreach ( $sneeit_core_c_post as $sneeit_core_c_comment => $sneeit_core_c_post_data ) {
				$sneeit_core_c_post_post = sneeit_core_get_demo_comment_id( $sneeit_core_c_post_data );
				if ( empty( $sneeit_core_c_post_post ) ) {
					continue;
				}
				wp_update_comment( array(
					'comment_ID' => $sneeit_core_c_comment,
					'comment_parent' => $sneeit_core_c_post_post,
				) );
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
