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
global $dragblock_query_param_strings;
$dragblock_queries = null;
$dragblock_current_query_list_id = null;
$dragblock_current_query_list_item_id = null;
$dragblock_loaded_posts = array();
$dragblock_query_param_strings = array();
// dev-reply#2040.
add_filter( 'render_block_data', 'dragblock_database_collector', 10, 1 );
/**
 * Check Documentation#2014
 *
 * @param object|array|string $dragblock_dr_dragblock check var-def#2014.
 */
function dragblock_database_collector( $dragblock_dr_dragblock ) {
	// dev-reply#2062.
	if ( empty( $dragblock_dr_dragblock['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_dr_dragblock;
	}
	global $dragblock_queries;
	global $dragblock_current_query_list_id;
	global $dragblock_current_query_list_item_id;
	global $dragblock_loaded_posts;
	global $dragblock_query_param_strings;
	// dev-reply#2083.
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
	// dev-reply#2099.
	if ( empty( $dragblock_dr_dragblock['attrs']['dragBlockQueries'] ) ) return $dragblock_dr_dragblock;
	$dragblock_dr_current = - 1;
	foreach ( $dragblock_dr_dragblock['attrs']['dragBlockQueries'] as $dragblock_dr_query ) {
		if ( ! empty( $dragblock_dr_query['disabled'] ) )	continue;
		$dragblock_dr_list = $dragblock_dr_query['slug'];
		$dragblock_dr_id = $dragblock_dr_query['id'];
		if ( empty( $dragblock_dr_query['params'] ) ) {
			$dragblock_dr_query['params'] = array();
		}
		$dragblock_dr_item = $dragblock_dr_query['params'];
		// dev-reply#20118.
		if ( in_array( $dragblock_dr_list, array( 'WP_Query', 'WP_Query_Default' ) ) ) {
			$dragblock_dr_loaded = array(
				'fields' => 'ids',
				// dev-reply#20123.,
			);
			$dragblock_dr_posts = '';
			$dragblock_dr_param = false;
			// dev-reply#20128.
			foreach ( $dragblock_dr_query['params'] as $dragblock_dr_strings ) {
				if ( ! empty( $dragblock_dr_strings['disabled'] ) || $dragblock_dr_strings['value'] === '' ) {
					continue;
				}
				// dev-reply#20134.
				$dragblock_dr_parsed = $dragblock_dr_strings['slug'];
				$dragblock_dr_block = $dragblock_dr_strings['value'];
				// dev-reply#20138.
				if ( ! in_array( $dragblock_dr_parsed, array( 'posts_per_page', 'ignore_loaded_posts' ) ) ) {
					$dragblock_dr_posts .= $dragblock_dr_parsed . ':' . $dragblock_dr_block;
				}
				// dev-reply#20148.
				if ( 'posts_per_page' === $dragblock_dr_parsed && is_numeric( $dragblock_dr_block ) ) {
					$dragblock_dr_current = (int) $dragblock_dr_block;
				}
				// dev-reply#20153.
				if ( 'ignore_loaded_posts' === $dragblock_dr_parsed ) {
					$dragblock_dr_param = 'all' === $dragblock_dr_strings['value'] ? 'all' : 'query';
					// dev-reply#20156.
					continue;
				}
				// dev-reply#20162.
				if ( strpos( $dragblock_dr_block, '[dragblock.' ) !== false ) {
					$dragblock_dr_block = do_shortcode( $dragblock_dr_block );
				}
				// dev-reply#20168.
				if ( strpos( $dragblock_dr_parsed, '__' ) !== false ) {
					$dragblock_dr_loaded[ $dragblock_dr_parsed ] = explode( ',', $dragblock_dr_block );
					continue;
				}
				$dragblock_dr_loaded[ $dragblock_dr_parsed ] = $dragblock_dr_block;
			}
			// dev-reply#20178.
			if ( isset( $dragblock_dr_loaded['orderby'] ) && DRAGBLOCK_POST_VIEWS_KEY === $dragblock_dr_loaded['orderby'] ) {
				$dragblock_dr_loaded['meta_key'] = DRAGBLOCK_POST_VIEWS_KEY;
				$dragblock_dr_loaded['orderby'] = 'meta_value_num';
			}
			// dev-reply#20184.
			if ( $dragblock_dr_param ) {
				$dragblock_dr_wp = array();
				if ( 'all' === $dragblock_dr_param ) {
					foreach ( $dragblock_loaded_posts as $dragblock_dr_post ) {
						if ( ! is_array( $dragblock_dr_post ) ) continue;
						$dragblock_dr_wp = array_merge( $dragblock_dr_wp, $dragblock_dr_post );
					}
				} elseif ( isset( $dragblock_loaded_posts[ $dragblock_dr_posts ] ) ) {
					$dragblock_dr_wp = $dragblock_loaded_posts[ $dragblock_dr_posts ];
				}
				if ( count( $dragblock_dr_wp ) ) {
					$dragblock_dr_loaded['post__not_in'] = $dragblock_dr_wp;
				}
			}
			$dragblock_current_query_list_id = $dragblock_dr_id;
			if ( 'WP_Query' === $dragblock_dr_list ) {
				// dev-reply#20207.
				$dragblock_dr_post = new WP_Query( dragblock_wp_query_args_processor( $dragblock_dr_loaded ) );
				$dragblock_dr_post = $dragblock_dr_post->posts;
				// dev-reply#20211.
				if ( $dragblock_dr_current > 0 ) {
					if ( ! isset( $dragblock_loaded_posts[ $dragblock_dr_posts ] ) ) {
						$dragblock_loaded_posts[ $dragblock_dr_posts ] = array();
					}
					// dev-reply#20219.
					foreach ( $dragblock_dr_post as $dragblock_dr_count ) {
						if ( in_array( $dragblock_dr_count, $dragblock_loaded_posts[ $dragblock_dr_posts ] ) ) {
							continue;
						}
						array_push( $dragblock_loaded_posts[ $dragblock_dr_posts ], $dragblock_dr_count );
					}
				} else {
					$dragblock_query_param_strings[ $dragblock_current_query_list_id ] = $dragblock_dr_posts;
					$dragblock_loaded_posts[ $dragblock_dr_posts ] = array();
				}
				$dragblock_queries[ $dragblock_current_query_list_id ] = $dragblock_dr_post;
				// dev-reply#20244.
				$dragblock_current_query_list_item_id = null;
			} elseif ( 'WP_Query_Default' === $dragblock_dr_list ) {
				// dev-reply#20247.
				$dragblock_current_query_list_item_id = null;
				$dragblock_current_query_list_id = 'default';
			}
		}
		// dev-reply#20253.
		if ( 'parse_item' === $dragblock_dr_list ) {
			if ( ! empty( $dragblock_dr_item['query_id'] ) ) {
				$dragblock_current_query_list_id = $dragblock_dr_item['query_id'];
			}
			if ( ! empty( $dragblock_dr_item['item_index'] ) ) {
				$dragblock_current_query_list_item_id = intval( $dragblock_dr_item['item_index'] );
			} elseif ( null === $dragblock_current_query_list_item_id ) {
				$dragblock_current_query_list_item_id = 0;
			} else {
				$dragblock_current_query_list_item_id++;
			}
			// dev-reply#20267.
			if (
				! isset( $dragblock_queries[ $dragblock_current_query_list_id ] ) ||
				! isset( $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] )
			) {
				$dragblock_dr_dragblock['attrs']['dragBlockRenderability'] = array(
					array(
						'slug' => 'render',
						'value' => 'never',
					),
				);
			} elseif ( isset( $dragblock_query_param_strings[ $dragblock_current_query_list_id ] ) ) {
				$dragblock_dr_posts = $dragblock_query_param_strings[ $dragblock_current_query_list_id ];
				array_push( $dragblock_loaded_posts[ $dragblock_dr_posts ], $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] );
			}
		}
	}
	return $dragblock_dr_dragblock;
}
/**
 * Check Documentation#20174
 *
 * @param object|array|string $dragblock_dr_loaded check var-def#20174.
 */
function dragblock_wp_query_args_processor( $dragblock_dr_loaded ) {
	// dev-reply#20295.
	$dragblock_dr_slug = array();
	foreach ( $dragblock_dr_loaded as $dragblock_dr_parsed => $dragblock_dr_params ) {
		// dev-reply#20298.
		if ( strpos( $dragblock_dr_parsed, DRAGBLOCK_START_TAX_QUERY_KEY ) === 0 ) {
			// dev-reply#20300.
			$dragblock_dr_args = str_replace( DRAGBLOCK_START_TAX_QUERY_KEY, '', $dragblock_dr_parsed );
			$dragblock_dr_args = str_replace( '__in', '', $dragblock_dr_args );
			// dev-reply#20303.
			$dragblock_dr_slug[] = array(
				'taxonomy' => $dragblock_dr_args,
				'field'    => 'term_id',
				'terms'    => $dragblock_dr_params,
			);
			// dev-reply#20309.
			unset( $dragblock_dr_loaded[ $dragblock_dr_parsed ] );
		}
	}
	// dev-reply#20314.
	if ( ! empty( $dragblock_dr_slug ) ) {
		$dragblock_dr_loaded['tax_query'] = $dragblock_dr_slug;
	}
	// dev-reply#20319.
	return $dragblock_dr_loaded;
}
// dev-reply#20325.
