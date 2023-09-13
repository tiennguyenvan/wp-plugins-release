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
	$sneeit_core_0 = $_POST['data'];
	$sneeit_core_1 = array();
	foreach ( $sneeit_core_0 as $sneeit_core_2 => $sneeit_core_3 ) {
		$sneeit_core_4 = sneeit_core_get_demo_post_id( $sneeit_core_2 );
		if ( empty( $sneeit_core_4 ) ) {
			// dev-reply#521.
			continue;
		}
		// dev-reply#526.
		foreach ( $sneeit_core_3 as $sneeit_core_5 => $sneeit_core_6 ) {
			$sneeit_core_7 = array(
				'comment_post_ID' => (int) $sneeit_core_4,
			);
			if ( ! empty( $sneeit_core_6['email'] ) ) {
				$sneeit_core_7['comment_author_email'] = $sneeit_core_6['email'];
			}
			if ( ! empty( $sneeit_core_6['name'] ) ) {
				$sneeit_core_7['comment_author'] = $sneeit_core_6['email'];
			}
			$sneeit_core_8 = wp_insert_comment( $sneeit_core_7 );
			if ( empty( $sneeit_core_8 ) ) {
				continue;
			}
			update_comment_meta( $sneeit_core_8, 'sneeit-demo-id', $sneeit_core_5 );
			if ( ! empty( $sneeit_core_6['parent'] ) ) {
				$sneeit_core_1[ $sneeit_core_8 ] = $sneeit_core_6['parent'];
			}
		}
		// dev-reply#550.
		if ( count( $sneeit_core_1 ) ) {
			foreach ( $sneeit_core_1 as $sneeit_core_5 => $sneeit_core_9 ) {
				$sneeit_core_10 = sneeit_core_get_demo_comment_id( $sneeit_core_9 );
				if ( empty( $sneeit_core_10 ) ) {
					continue;
				}
				wp_update_comment( array(
					'comment_ID' => $sneeit_core_5,
					'comment_parent' => $sneeit_core_10,
				) );
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
