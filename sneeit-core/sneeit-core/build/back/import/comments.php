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
	$sneeit_core_c_parents = array();
	foreach ( $sneeit_core_c_data as $sneeit_core_c_id => $sneeit_core_c_comments ) {
		$sneeit_core_c_post_id = sneeit_core_get_demo_post_id( $sneeit_core_c_id );
		if ( empty( $sneeit_core_c_post_id ) ) {
			// dev-reply#521.
			continue;
		}
		// dev-reply#526.
		foreach ( $sneeit_core_c_comments as $sneeit_core_c_comment_id => $sneeit_core_c_comment ) {
			$sneeit_core_c_args = array(
				'comment_post_ID' => (int) $sneeit_core_c_post_id,
			);
			if ( ! empty( $sneeit_core_c_comment['email'] ) ) {
				$sneeit_core_c_args['comment_author_email'] = $sneeit_core_c_comment['email'];
			}
			if ( ! empty( $sneeit_core_c_comment['name'] ) ) {
				$sneeit_core_c_args['comment_author'] = $sneeit_core_c_comment['email'];
			}
			$sneeit_core_c_real_comment_id = wp_insert_comment( $sneeit_core_c_args );
			if ( empty( $sneeit_core_c_real_comment_id ) ) {
				continue;
			}
			update_comment_meta( $sneeit_core_c_real_comment_id, 'sneeit-demo-id', $sneeit_core_c_comment_id );
			if ( ! empty( $sneeit_core_c_comment['parent'] ) ) {
				$sneeit_core_c_parents[ $sneeit_core_c_real_comment_id ] = $sneeit_core_c_comment['parent'];
			}
		}
		// dev-reply#550.
		if ( count( $sneeit_core_c_parents ) ) {
			foreach ( $sneeit_core_c_parents as $sneeit_core_c_comment_id => $sneeit_core_c_parent_comment_id ) {
				$sneeit_core_c_real_parent_comment_id = sneeit_core_get_demo_comment_id( $sneeit_core_c_parent_comment_id );
				if ( empty( $sneeit_core_c_real_parent_comment_id ) ) {
					continue;
				}
				wp_update_comment( array(
					'comment_ID' => $sneeit_core_c_comment_id,
					'comment_parent' => $sneeit_core_c_real_parent_comment_id,
				) );
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
