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
	$sneeit_core_t_terms = $_POST['data'];
	global $wpdb;
	// dev-reply#519.
	$sneeit_core_t_original_terms = array();
	foreach ( $sneeit_core_t_terms as $sneeit_core_t_taxonomy => $sneeit_core_t_items ) {
		foreach ( $sneeit_core_t_items as $sneeit_core_t_id => $sneeit_core_t_item ) {
			// dev-reply#523.
			if ( term_exists( $sneeit_core_t_id, $sneeit_core_t_taxonomy ) ) {
				$sneeit_core_t_original_terms[ $sneeit_core_t_id ] = true;
				continue;
			}
			// dev-reply#529.
			$sneeit_core_t_id = (int) $sneeit_core_t_id;
			$wpdb->insert( $wpdb->terms, array(
				'term_id' => $sneeit_core_t_id,
				'name' => $sneeit_core_t_item['name'],
				'slug' => $sneeit_core_t_item['slug'],
			) );
			$wpdb->insert( $wpdb->term_taxonomy, ['term_id' => $sneeit_core_t_id,
				'taxonomy' => $sneeit_core_t_taxonomy, ] );
		}
	}
	// dev-reply#543.
	foreach ( $sneeit_core_t_terms as $sneeit_core_t_taxonomy => $sneeit_core_t_items ) {
		foreach ( $sneeit_core_t_items as $sneeit_core_t_id => $sneeit_core_t_item ) {
			// dev-reply#546.
			if ( ! empty( $sneeit_core_t_item['meta'] ) ) {
				foreach ( $sneeit_core_t_item['meta'] as $sneeit_core_t_key => $sneeit_core_t_value ) {
					update_term_meta( $sneeit_core_t_id, $sneeit_core_t_key, $sneeit_core_t_value );
				}
			}
			// dev-reply#553.
			if ( ! isset( $sneeit_core_t_original_terms[ $sneeit_core_t_id ] ) ) {
				update_term_meta( $sneeit_core_t_id, 'sneeit-demo-id', 'created' );
			}
			// dev-reply#558.
			if ( empty( $sneeit_core_t_item['parent'] ) ) {
				continue;
			}
			$sneeit_core_t_id = (int) $sneeit_core_t_id;
			wp_update_term( $sneeit_core_t_id, $sneeit_core_t_taxonomy, array(
				'parent' => (int) $sneeit_core_t_item['parent'],
			) );
		}
	}
	echo json_encode( 'done' );
	die();
}
