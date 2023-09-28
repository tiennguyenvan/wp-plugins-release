<?php
/**
 * DragBlock's Editor-panel-database.
 *
 * @package Database render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $dragblock_queries;
global $dragblock_current_query_list_id;
global $dragblock_current_query_list_item_id;
$dragblock_queries = null;
$dragblock_current_query_list_id = null;
$dragblock_current_query_list_item_id = null;
add_filter( 'render_block_data', 'dragblock_database_collector', 10, 1 );
/**
 * Check Documentation#109
 *
 * @param object|array|string $dragblock_dr_parsed_block check var-def#109.
 */
function dragblock_database_collector( $dragblock_dr_parsed_block ) {
	// dev-reply#1037.
	if ( empty( $dragblock_dr_parsed_block['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_dr_parsed_block;
	}
	// dev-reply#1048.
	global $dragblock_queries;
	global $dragblock_current_query_list_id;
	global $dragblock_current_query_list_item_id;
	// dev-reply#1054.
	if ( empty( $dragblock_queries ) ) {
		global $wp_query;
		$dragblock_current_query_list_id = 'default';
		$dragblock_current_query_list_item_id = null;
		$dragblock_queries[ $dragblock_current_query_list_id ] = array();
		if ( property_exists( $wp_query, 'posts' ) && is_array( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $dragblock_dr_post ) {
				array_push( $dragblock_queries[ $dragblock_current_query_list_id ], $dragblock_dr_post->ID );
			}
		}
	}
	// dev-reply#1069.
	if ( ! empty( $dragblock_dr_parsed_block['attrs']['dragBlockQueries'] ) ) {
		foreach ( $dragblock_dr_parsed_block['attrs']['dragBlockQueries'] as $dragblock_dr_query ) {
			if ( ! empty( $dragblock_dr_query['disabled'] ) ) {
				continue;
			}
			$dragblock_dr_slug = $dragblock_dr_query['slug'];
			$dragblock_dr_id = $dragblock_dr_query['id'];
			if ( empty( $dragblock_dr_query['params'] ) ) {
				$dragblock_dr_query['params'] = array();
			}
			$dragblock_dr_params = $dragblock_dr_query['params'];
			// dev-reply#1084.
			if ( in_array( $dragblock_dr_slug, array( 'WP_Query', 'WP_Query_Default' ) ) ) {
				$dragblock_dr_args = array(
					'fields' => 'ids',
				);
				foreach ( $dragblock_dr_query['params'] as $dragblock_dr_param ) {
					if ( ! empty( $dragblock_dr_param['disabled'] ) || empty( $dragblock_dr_param['value'] ) ) {
						continue;
					}
					// dev-reply#1096.
					$dragblock_dr_key = $dragblock_dr_param['slug'];
					$dragblock_dr_val = $dragblock_dr_param['value'];
					// dev-reply#10100.
					if ( 'ignore_loaded_posts' === $dragblock_dr_key ) {
						if ( $dragblock_dr_val ) {
							$dragblock_dr_args['post__not_in'] = array_merge( ...array_values( $dragblock_queries ) );
						}
						continue;
					}
					// dev-reply#10108.
					if ( strpos( $dragblock_dr_val, '[dragblock.' ) !== false ) {
						$dragblock_dr_val = do_shortcode( $dragblock_dr_val );
					}
					// dev-reply#10113.
					if ( strpos( $dragblock_dr_key, '__' ) !== false ) {
						$dragblock_dr_args[ $dragblock_dr_key ] = explode( ',', $dragblock_dr_val );
						continue;
					}
					$dragblock_dr_args[ $dragblock_dr_key ] = $dragblock_dr_val;
				}
				$dragblock_current_query_list_id = $dragblock_dr_id;
				if ( 'WP_Query' === $dragblock_dr_slug ) {
					$dragblock_queries[ $dragblock_current_query_list_id ] = new WP_Query( $dragblock_dr_args );
					$dragblock_queries[ $dragblock_current_query_list_id ] = $dragblock_queries[ $dragblock_current_query_list_id ]->posts;
					// dev-reply#10129.
					$dragblock_current_query_list_item_id = null;
				} elseif ( 'WP_Query_Default' === $dragblock_dr_slug ) {
					// dev-reply#10132.
					$dragblock_current_query_list_item_id = null;
					$dragblock_current_query_list_id = 'default';
				}
			}
			// dev-reply#10138.
			if ( 'parse_item' === $dragblock_dr_slug ) {
				if ( ! empty( $dragblock_dr_params['query_id'] ) ) {
					$dragblock_current_query_list_id = $dragblock_dr_params['query_id'];
				}
				if ( ! empty( $dragblock_dr_params['item_index'] ) ) {
					$dragblock_current_query_list_item_id = intval( $dragblock_dr_params['item_index'] );
				} elseif ( null === $dragblock_current_query_list_item_id ) {
					$dragblock_current_query_list_item_id = 0;
				} else {
					$dragblock_current_query_list_item_id++;
				}
			}
		}
	}
	return $dragblock_dr_parsed_block;
}
