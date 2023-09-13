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
 * @param object|array|string $dragblock_0 check var-def#109.
 */
function dragblock_database_collector( $dragblock_0 ) {
	// dev-reply#1037.
	if ( empty( $dragblock_0['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_0;
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
			foreach ( $wp_query->posts as $dragblock_1 ) {
				array_push( $dragblock_queries[ $dragblock_current_query_list_id ], $dragblock_1->ID );
			}
		}
	}
	// dev-reply#1069.
	if ( ! empty( $dragblock_0['attrs']['dragBlockQueries'] ) ) {
		foreach ( $dragblock_0['attrs']['dragBlockQueries'] as $dragblock_2 ) {
			if ( ! empty( $dragblock_2['disabled'] ) ) {
				continue;
			}
			$dragblock_3 = $dragblock_2['slug'];
			$dragblock_4 = $dragblock_2['id'];
			if ( empty( $dragblock_2['params'] ) ) {
				$dragblock_2['params'] = array();
			}
			$dragblock_5 = $dragblock_2['params'];
			// dev-reply#1084.
			if ( in_array( $dragblock_3, array( 'WP_Query', 'WP_Query_Default' ) ) ) {
				$dragblock_6 = array(
					'fields' => 'ids',
				);
				foreach ( $dragblock_2['params'] as $dragblock_7 ) {
					if ( ! empty( $dragblock_7['disabled'] ) || empty( $dragblock_7['value'] ) ) {
						continue;
					}
					// dev-reply#1096.
					$dragblock_8 = $dragblock_7['slug'];
					$dragblock_9 = $dragblock_7['value'];
					// dev-reply#10100.
					if ( 'ignore_loaded_posts' === $dragblock_8 ) {
						if ( $dragblock_9 ) {
							$dragblock_6['post__not_in'] = array_merge( ...array_values( $dragblock_queries ) );
						}
						continue;
					}
					// dev-reply#10108.
					if ( strpos( $dragblock_9, '[dragblock.' ) !== false ) {
						$dragblock_9 = do_shortcode( $dragblock_9 );
					}
					// dev-reply#10113.
					if ( strpos( $dragblock_8, '__' ) !== false ) {
						$dragblock_6[ $dragblock_8 ] = explode( ',', $dragblock_9 );
						continue;
					}
					$dragblock_6[ $dragblock_8 ] = $dragblock_9;
				}
				$dragblock_current_query_list_id = $dragblock_4;
				if ( 'WP_Query' === $dragblock_3 ) {
					$dragblock_queries[ $dragblock_current_query_list_id ] = new WP_Query( $dragblock_6 );
					$dragblock_queries[ $dragblock_current_query_list_id ] = $dragblock_queries[ $dragblock_current_query_list_id ]->posts;
					// dev-reply#10129.
					$dragblock_current_query_list_item_id = null;
				} elseif ( 'WP_Query_Default' === $dragblock_3 ) {
					// dev-reply#10132.
					$dragblock_current_query_list_item_id = null;
					$dragblock_current_query_list_id = 'default';
				}
			}
			// dev-reply#10138.
			if ( 'parse_item' === $dragblock_3 ) {
				if ( ! empty( $dragblock_5['query_id'] ) ) {
					$dragblock_current_query_list_id = $dragblock_5['query_id'];
				}
				if ( ! empty( $dragblock_5['item_index'] ) ) {
					$dragblock_current_query_list_item_id = intval( $dragblock_5['item_index'] );
				} elseif ( null === $dragblock_current_query_list_item_id ) {
					$dragblock_current_query_list_item_id = 0;
				} else {
					$dragblock_current_query_list_item_id++;
				}
			}
		}
	}
	return $dragblock_0;
}
