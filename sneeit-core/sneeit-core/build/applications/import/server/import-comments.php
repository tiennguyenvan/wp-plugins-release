<?php
/**
 * DragBlock's Import.
 *
 * @package Import comments
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
	$sneeit_core_ic_data = $_POST['data'];
	$sneeit_core_ic_post = array();
	foreach ( $sneeit_core_ic_data as $sneeit_core_ic_parents => $sneeit_core_ic_id ) {
		$sneeit_core_ic_comments = sneeit_core_get_demo_post_id( $sneeit_core_ic_parents );
		if ( empty( $sneeit_core_ic_comments ) ) {
			// dev-reply#521.
			continue;
		}
		// dev-reply#526.
		foreach ( $sneeit_core_ic_id as $sneeit_core_ic_comment => $sneeit_core_ic_args ) {
			$sneeit_core_ic_real = array(
				'comment_post_ID' => (int) $sneeit_core_ic_comments,
			);
			if ( ! empty( $sneeit_core_ic_args['email'] ) ) {
				$sneeit_core_ic_real['comment_author_email'] = $sneeit_core_ic_args['email'];
			}
			if ( ! empty( $sneeit_core_ic_args['name'] ) ) {
				$sneeit_core_ic_real['comment_author'] = $sneeit_core_ic_args['email'];
			}
			$sneeit_core_ic_parent = wp_insert_comment( $sneeit_core_ic_real );
			if ( empty( $sneeit_core_ic_parent ) ) {
				continue;
			}
			update_comment_meta( $sneeit_core_ic_parent, 'sneeit-demo-id', $sneeit_core_ic_comment );
			if ( ! empty( $sneeit_core_ic_args['parent'] ) ) {
				$sneeit_core_ic_post[ $sneeit_core_ic_parent ] = $sneeit_core_ic_args['parent'];
			}
		}
		// dev-reply#550.
		if ( count( $sneeit_core_ic_post ) ) {
			foreach ( $sneeit_core_ic_post as $sneeit_core_ic_comment => $sneeit_core_ic_post_data ) {
				$sneeit_core_ic_post_post = sneeit_core_get_demo_comment_id( $sneeit_core_ic_post_data );
				if ( empty( $sneeit_core_ic_post_post ) ) {
					continue;
				}
				wp_update_comment( array(
					'comment_ID' => $sneeit_core_ic_comment,
					'comment_parent' => $sneeit_core_ic_post_post,
				) );
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
