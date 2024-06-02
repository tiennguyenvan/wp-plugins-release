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
// dev-reply#1940.
add_filter( 'render_block_data', 'dragblock_database_collector', 10, 1 );
/**
 * Check Documentation#1914
 *
 * @param object|array|string $dragblock_dr_dragblock check var-def#1914.
 */
function dragblock_database_collector( $dragblock_dr_dragblock ) {
	// dev-reply#1962.
	if ( empty( $dragblock_dr_dragblock['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_dr_dragblock;
	}
	global $dragblock_queries;
	global $dragblock_current_query_list_id;
	global $dragblock_current_query_list_item_id;
	global $dragblock_loaded_posts;
	global $dragblock_query_param_strings;
	// dev-reply#1983.
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
	// dev-reply#1999.
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
		// dev-reply#19116.
		if ( in_array( $dragblock_dr_list, array( 'WP_Query', 'WP_Query_Default' ) ) ) {
			$dragblock_dr_loaded = array(
				'fields' => 'ids',
			);
			$dragblock_dr_posts = '';
			$dragblock_dr_param = false;
			// dev-reply#19125.
			foreach ( $dragblock_dr_query['params'] as $dragblock_dr_strings ) {
				if ( ! empty( $dragblock_dr_strings['disabled'] ) || $dragblock_dr_strings['value'] === '' ) {
					continue;
				}
				// dev-reply#19131.
				$dragblock_dr_parsed = $dragblock_dr_strings['slug'];
				$dragblock_dr_block = $dragblock_dr_strings['value'];
				// dev-reply#19135.
				if ( ! in_array( $dragblock_dr_parsed, array( 'posts_per_page', 'ignore_loaded_posts' ) ) ) {
					$dragblock_dr_posts .= $dragblock_dr_parsed . ':' . $dragblock_dr_block;
				}
				// dev-reply#19145.
				if ( 'posts_per_page' === $dragblock_dr_parsed && is_numeric( $dragblock_dr_block ) ) {
					$dragblock_dr_current = (int) $dragblock_dr_block;
				}
				// dev-reply#19150.
				if ( 'ignore_loaded_posts' === $dragblock_dr_parsed ) {
					$dragblock_dr_param = 'all' === $dragblock_dr_strings['value'] ? 'all' : 'query';
					// dev-reply#19153.
					continue;
				}
				// dev-reply#19159.
				if ( strpos( $dragblock_dr_block, '[dragblock.' ) !== false ) {
					$dragblock_dr_block = do_shortcode( $dragblock_dr_block );
				}
				// dev-reply#19164.
				if ( strpos( $dragblock_dr_parsed, '__' ) !== false ) {
					$dragblock_dr_loaded[ $dragblock_dr_parsed ] = explode( ',', $dragblock_dr_block );
					continue;
				}
				$dragblock_dr_loaded[ $dragblock_dr_parsed ] = $dragblock_dr_block;
			}
			// dev-reply#19173.
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
				$dragblock_dr_post = new WP_Query( dragblock_wp_query_args_processor( $dragblock_dr_loaded ) );
				$dragblock_dr_post = $dragblock_dr_post->posts;
				// dev-reply#19200.
				if ( $dragblock_dr_current > 0 ) {
					if ( ! isset( $dragblock_loaded_posts[ $dragblock_dr_posts ] ) ) {
						$dragblock_loaded_posts[ $dragblock_dr_posts ] = array();
					}
					// dev-reply#19205.
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
				// dev-reply#19231.
				$dragblock_current_query_list_item_id = null;
			} elseif ( 'WP_Query_Default' === $dragblock_dr_list ) {
				// dev-reply#19234.
				$dragblock_current_query_list_item_id = null;
				$dragblock_current_query_list_id = 'default';
			}
		}
		// dev-reply#19240.
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
			// dev-reply#19256.
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
 * Check Documentation#19167
 *
 * @param object|array|string $dragblock_dr_loaded check var-def#19167.
 */
function dragblock_wp_query_args_processor( $dragblock_dr_loaded ) {
	// dev-reply#19285.
	$dragblock_dr_slug = array();
	foreach ( $dragblock_dr_loaded as $dragblock_dr_parsed => $dragblock_dr_params ) {
		// dev-reply#19288.
		if ( strpos( $dragblock_dr_parsed, DRAGBLOCK_START_TAX_QUERY_KEY ) === 0 ) {
			// dev-reply#19290.
			$dragblock_dr_args = str_replace( DRAGBLOCK_START_TAX_QUERY_KEY, '', $dragblock_dr_parsed );
			$dragblock_dr_args = str_replace( '__in', '', $dragblock_dr_args );
			// dev-reply#19293.
			$dragblock_dr_slug[] = array(
				'taxonomy' => $dragblock_dr_args,
				'field'    => 'term_id',
				'terms'    => $dragblock_dr_params,
			);
			// dev-reply#19299.
			unset( $dragblock_dr_loaded[ $dragblock_dr_parsed ] );
		}
	}
	// dev-reply#19304.
	if ( ! empty( $dragblock_dr_slug ) ) {
		$dragblock_dr_loaded['tax_query'] = $dragblock_dr_slug;
	}
	// dev-reply#19309.
	return $dragblock_dr_loaded;
}
// dev-reply#19315.
