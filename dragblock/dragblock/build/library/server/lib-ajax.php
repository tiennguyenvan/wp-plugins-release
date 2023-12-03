<?php
/**
 * DragBlock's Library.
 *
 * @package Lib ajax
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#82
 *
 * @param object|array|string $dragblock_la_action check var-def#82.
 * @param object|array|string $dragblock_la_callback check var-def#82.
 */
function dragblock_ajax_register( $dragblock_la_action, $dragblock_la_callback = '' ) {
	if ( ! $dragblock_la_callback ) {
		$dragblock_la_callback = $dragblock_la_action;
	}
	if ( is_admin() ) :
		add_action( 'wp_ajax_nopriv_' . $dragblock_la_action, $dragblock_la_callback );
		add_action( 'wp_ajax_' . $dragblock_la_action, $dragblock_la_callback );
	endif; // dev-reply#814.
}
/**
 * Check Documentation#812
 *
 * @param object|array|string $dragblock_la_text check var-def#812.
 */
function dragblock_ajax_error_die( $dragblock_la_text ) {
	echo json_encode( array( 'error' => $dragblock_la_text ) );
	die();
}
/**
 * Check Documentation#817
 *
 * @param object|array|string $dragblock_la_fields check var-def#817.
 */
function dragblock_ajax_request_verify_die( $dragblock_la_fields = array() ) {
	if ( empty( $_POST['nonce'] ) ) {
		dragblock_ajax_error_die( esc_html__( 'Empty nonce', 'dragblock' ) );
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), DRAGBLOCK_NONCE_SLUG ) ) {
		dragblock_ajax_error_die( esc_html__( 'Timeout! Please reload the page.', 'dragblock' ) );
	}
	if ( is_string( $dragblock_la_fields ) ) {
		$dragblock_la_fields = explode( ',', $dragblock_la_fields );
	}
	if ( ! empty( $dragblock_la_fields ) ) {
		foreach ( $dragblock_la_fields as $dragblock_la_post ) {
			$dragblock_la_post = trim( $dragblock_la_post );
			if ( ! isset( $_POST[ $dragblock_la_post ] ) ) {
				/* translators: see trans-note#832 */
				dragblock_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'dragblock' ), $dragblock_la_post ) );
			}
		}
	}
}
/**
 * Check Documentation#837
 *
 * @param object|array|string $dragblock_la_field check var-def#837.
 */
function dragblock_ajax_succeed_die( $dragblock_la_field ) {
	echo json_encode( $dragblock_la_field );
	die();
}
dragblock_ajax_register( 'dragblock_url_search' );
/**
 * Check Documentation#843
 */
function dragblock_url_search() {
	dragblock_ajax_request_verify_die( 'search' );
	$dragblock_la_ret = sanitize_text_field( wp_unslash( $_POST['search'] ) );
	// dev-reply#857.
	$dragblock_la_search = get_taxonomies();
	$dragblock_la_taxonomies = array();
	// dev-reply#864.
	foreach ( $dragblock_la_search as $dragblock_la_results ) {
		// dev-reply#866.
		$dragblock_la_taxonomy = get_terms( array(
			'taxonomy' => $dragblock_la_results,
			'name__like' => $dragblock_la_ret,
			'hide_empty' => false,
		) );
		// dev-reply#873.
		foreach ( $dragblock_la_taxonomy as $dragblock_la_terms ) {
			$dragblock_la_term = get_term_link( $dragblock_la_terms );
			$dragblock_la_taxonomies[ $dragblock_la_term ] = array(
				'title' => $dragblock_la_terms->name,
				'type' => $dragblock_la_results,
			);
		}
	}
	// dev-reply#883.
	$dragblock_la_permalink = array(
		's' => $dragblock_la_ret, // dev-reply#885.
		'post_type' => 'any', // dev-reply#886.
		'status' => 'published',
		// dev-reply#888.,
	);
	$dragblock_la_args = get_posts( $dragblock_la_permalink );
	foreach ( $dragblock_la_args as $dragblock_la_posts ) {
		// dev-reply#896.
		$dragblock_la_term = get_permalink( $dragblock_la_posts );
		$dragblock_la_title = get_the_title( $dragblock_la_posts );
		$dragblock_la_taxonomies[ $dragblock_la_term ] = array(
			'title' => $dragblock_la_title,
			'type' => get_post_type( $dragblock_la_posts ),
		);
	}
	// dev-reply#8107.
	dragblock_ajax_succeed_die( array(
		'search' => $dragblock_la_ret,
		'results' => $dragblock_la_taxonomies,
	) );
}
