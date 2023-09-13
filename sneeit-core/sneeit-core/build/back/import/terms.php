<?php
/**
 * DragBlock's Import.
 *
 * @package Terms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_terms', 'sneeit_core_demo_import_terms' );
	add_action( 'wp_ajax_sneeit_core_demo_import_terms', 'sneeit_core_demo_import_terms' );
endif; // dev-reply#59.
/**
 * Check Documentation#56
 */
function sneeit_core_demo_import_terms() {
	sneeit_core_ajax_request_verify_die( 'data' );
	$sneeit_core_0 = $_POST['data'];
	global $wpdb;
	// dev-reply#519.
	$sneeit_core_1 = array();
	foreach ( $sneeit_core_0 as $sneeit_core_2 => $sneeit_core_3 ) {
		foreach ( $sneeit_core_3 as $sneeit_core_4 => $sneeit_core_5 ) {
			// dev-reply#523.
			if ( term_exists( $sneeit_core_4, $sneeit_core_2 ) ) {
				$sneeit_core_1[ $sneeit_core_4 ] = true;
				continue;
			}
			// dev-reply#529.
			$sneeit_core_4 = (int) $sneeit_core_4;
			$wpdb->insert( $wpdb->terms, array(
				'term_id' => $sneeit_core_4,
				'name' => $sneeit_core_5['name'],
				'slug' => $sneeit_core_5['slug'],
			) );
			$wpdb->insert( $wpdb->term_taxonomy, ['term_id' => $sneeit_core_4,
				'taxonomy' => $sneeit_core_2, ] );
		}
	}
	// dev-reply#543.
	foreach ( $sneeit_core_0 as $sneeit_core_2 => $sneeit_core_3 ) {
		foreach ( $sneeit_core_3 as $sneeit_core_4 => $sneeit_core_5 ) {
			// dev-reply#546.
			if ( ! empty( $sneeit_core_5['meta'] ) ) {
				foreach ( $sneeit_core_5['meta'] as $sneeit_core_6 => $sneeit_core_7 ) {
					update_term_meta( $sneeit_core_4, $sneeit_core_6, $sneeit_core_7 );
				}
			}
			// dev-reply#553.
			if ( ! isset( $sneeit_core_1[ $sneeit_core_4 ] ) ) {
				update_term_meta( $sneeit_core_4, 'sneeit-demo-id', 'created' );
			}
			// dev-reply#558.
			if ( empty( $sneeit_core_5['parent'] ) ) {
				continue;
			}
			$sneeit_core_4 = (int) $sneeit_core_4;
			wp_update_term( $sneeit_core_4, $sneeit_core_2, array(
				'parent' => (int) $sneeit_core_5['parent'],
			) );
		}
	}
	echo json_encode( 'done' );
	die();
}
