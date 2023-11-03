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
global $dragblock_loaded_posts;
$dragblock_queries = null;
$dragblock_current_query_list_id = null;
$dragblock_current_query_list_item_id = null;
$dragblock_loaded_posts = array();
// dev-reply#1232.
add_filter( 'render_block_data', 'dragblock_database_collector', 10, 1 );
/**
 * Check Documentation#1212
 *
 * @param object|array|string $dragblock_dr_dragblock check var-def#1212.
 */
function dragblock_database_collector( $dragblock_dr_dragblock ) {
	// dev-reply#1255.
	if ( empty( $dragblock_dr_dragblock['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_dr_dragblock;
	}
	// dev-reply#1266.
	global $dragblock_queries;
	global $dragblock_current_query_list_id;
	global $dragblock_current_query_list_item_id;
	global $dragblock_loaded_posts;
	// dev-reply#1273.
	if ( empty( $dragblock_queries ) ) {
		global $wp_query;
		$dragblock_current_query_list_id = 'default';
		$dragblock_current_query_list_item_id = null;
		$dragblock_queries[ $dragblock_current_query_list_id ] = array();
		if ( property_exists( $wp_query, 'posts' ) && is_array( $wp_query->posts ) ) {
			foreach ( $wp_query->posts as $dragblock_dr_queries ) {
				array_push( $dragblock_queries[ $dragblock_current_query_list_id ], $dragblock_dr_queries->ID );
			}
		}
	}
	// dev-reply#1288.
	if ( ! empty( $dragblock_dr_dragblock['attrs']['dragBlockQueries'] ) ) {
		foreach ( $dragblock_dr_dragblock['attrs']['dragBlockQueries'] as $dragblock_dr_current ) {
			if ( ! empty( $dragblock_dr_current['disabled'] ) ) {
				continue;
			}
			$dragblock_dr_query = $dragblock_dr_current['slug'];
			$dragblock_dr_list = $dragblock_dr_current['id'];
			if ( empty( $dragblock_dr_current['params'] ) ) {
				$dragblock_dr_current['params'] = array();
			}
			$dragblock_dr_id = $dragblock_dr_current['params'];
			// dev-reply#12104.
			if ( in_array( $dragblock_dr_query, array( 'WP_Query', 'WP_Query_Default' ) ) ) {
				$dragblock_dr_item = array(
					'fields' => 'ids',
				);
				$dragblock_dr_loaded = '';
				$dragblock_dr_posts = false;
				// dev-reply#12112.
				foreach ( $dragblock_dr_current['params'] as $dragblock_dr_parsed ) {
					if ( ! empty( $dragblock_dr_parsed['disabled'] ) || $dragblock_dr_parsed['value'] === '' ) {
						continue;
					}
					// dev-reply#12118.
					$dragblock_dr_block = $dragblock_dr_parsed['slug'];
					$dragblock_dr_wp = $dragblock_dr_parsed['value'];
					// dev-reply#12122.
					if ( ! in_array( $dragblock_dr_block, array( 'count', 'ignore_loaded_posts' ) ) ) {
						$dragblock_dr_loaded .= $dragblock_dr_block . ':' . $dragblock_dr_wp;
					}
					// dev-reply#12131.
					if ( 'ignore_loaded_posts' === $dragblock_dr_block ) {
						$dragblock_dr_posts = true;
						// dev-reply#12134.
						continue;
					}
					// dev-reply#12140.
					if ( strpos( $dragblock_dr_wp, '[dragblock.' ) !== false ) {
						$dragblock_dr_wp = do_shortcode( $dragblock_dr_wp );
					}
					// dev-reply#12145.
					if ( strpos( $dragblock_dr_block, '__' ) !== false ) {
						$dragblock_dr_item[ $dragblock_dr_block ] = explode( ',', $dragblock_dr_wp );
						continue;
					}
					$dragblock_dr_item[ $dragblock_dr_block ] = $dragblock_dr_wp;
				}
				if ( $dragblock_dr_posts && isset( $dragblock_loaded_posts[ $dragblock_dr_loaded ] ) ) {
					$dragblock_dr_item['post__not_in'] = $dragblock_loaded_posts[ $dragblock_dr_loaded ];
				}
				$dragblock_current_query_list_id = $dragblock_dr_list;
				if ( 'WP_Query' === $dragblock_dr_query ) {
					$dragblock_dr_post = new WP_Query( $dragblock_dr_item );
					$dragblock_dr_post = $dragblock_dr_post->posts;
					if ( ! isset( $dragblock_loaded_posts[ $dragblock_dr_loaded ] ) ) {
						$dragblock_loaded_posts[ $dragblock_dr_loaded ] = array();
					}
					foreach ( $dragblock_dr_post as $dragblock_dr_slug ) {
						if ( in_array( $dragblock_dr_slug, $dragblock_loaded_posts[ $dragblock_dr_loaded ] ) ) {
							continue;
						}
						array_push( $dragblock_loaded_posts[ $dragblock_dr_loaded ], $dragblock_dr_slug );
					}
					$dragblock_queries[ $dragblock_current_query_list_id ] = $dragblock_dr_post;
					// dev-reply#12178.
					$dragblock_current_query_list_item_id = null;
				} elseif ( 'WP_Query_Default' === $dragblock_dr_query ) {
					// dev-reply#12181.
					$dragblock_current_query_list_item_id = null;
					$dragblock_current_query_list_id = 'default';
				}
			}
			// dev-reply#12187.
			if ( 'parse_item' === $dragblock_dr_query ) {
				if ( ! empty( $dragblock_dr_id['query_id'] ) ) {
					$dragblock_current_query_list_id = $dragblock_dr_id['query_id'];
				}
				if ( ! empty( $dragblock_dr_id['item_index'] ) ) {
					$dragblock_current_query_list_item_id = intval( $dragblock_dr_id['item_index'] );
				} elseif ( null === $dragblock_current_query_list_item_id ) {
					$dragblock_current_query_list_item_id = 0;
				} else {
					$dragblock_current_query_list_item_id++;
				}
			}
		}
	}
	return $dragblock_dr_dragblock;
}
// dev-reply#12206.
