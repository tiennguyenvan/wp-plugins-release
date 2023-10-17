<?php
/**
 * DragBlock's Import.
 *
 * @package Import terms
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
	$sneeit_core_it_terms = $_POST['data'];
	global $wpdb;
	// dev-reply#519.
	$sneeit_core_it_post = array();
	foreach ( $sneeit_core_it_terms as $sneeit_core_it_wpdb => $sneeit_core_it_original ) {
		foreach ( $sneeit_core_it_original as $sneeit_core_it_taxonomy => $sneeit_core_it_items ) {
			// dev-reply#523.
			if ( term_exists( $sneeit_core_it_taxonomy, $sneeit_core_it_wpdb ) ) {
				$sneeit_core_it_post[ $sneeit_core_it_taxonomy ] = true;
				continue;
			}
			// dev-reply#529.
			$sneeit_core_it_taxonomy = (int) $sneeit_core_it_taxonomy;
			$wpdb->insert( $wpdb->terms, array(
				'term_id' => $sneeit_core_it_taxonomy,
				'name' => $sneeit_core_it_items['name'],
				'slug' => $sneeit_core_it_items['slug'],
			) );
			$wpdb->insert( $wpdb->term_taxonomy, ['term_id' => $sneeit_core_it_taxonomy,
				'taxonomy' => $sneeit_core_it_wpdb, ] );
		}
	}
	// dev-reply#543.
	foreach ( $sneeit_core_it_terms as $sneeit_core_it_wpdb => $sneeit_core_it_original ) {
		foreach ( $sneeit_core_it_original as $sneeit_core_it_taxonomy => $sneeit_core_it_items ) {
			// dev-reply#546.
			if ( ! empty( $sneeit_core_it_items['meta'] ) ) {
				foreach ( $sneeit_core_it_items['meta'] as $sneeit_core_it_id => $sneeit_core_it_item ) {
					update_term_meta( $sneeit_core_it_taxonomy, $sneeit_core_it_id, $sneeit_core_it_item );
				}
			}
			// dev-reply#553.
			if ( ! isset( $sneeit_core_it_post[ $sneeit_core_it_taxonomy ] ) ) {
				update_term_meta( $sneeit_core_it_taxonomy, 'sneeit-demo-id', 'created' );
			}
			// dev-reply#558.
			if ( empty( $sneeit_core_it_items['parent'] ) ) {
				continue;
			}
			$sneeit_core_it_taxonomy = (int) $sneeit_core_it_taxonomy;
			wp_update_term( $sneeit_core_it_taxonomy, $sneeit_core_it_wpdb, array(
				'parent' => (int) $sneeit_core_it_items['parent'],
			) );
		}
	}
	echo json_encode( 'done' );
	die();
}
