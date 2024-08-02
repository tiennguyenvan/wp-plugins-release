<?php
/**
 * DragBlock's Shortcodes.
 *
 * @package Shortcodes post
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#242.
/**
 * Check Documentation#243
 */
function dragblock_get_current_list_query_id() {
	global $dragblock_queries;
	global $dragblock_current_query_list_id;
	global $dragblock_current_query_list_item_id;
	// dev-reply#2421.
	if ( null === $dragblock_current_query_list_item_id ) {
		$dragblock_current_query_list_item_id = 0;
	}
	$dragblock_sp_dragblock = null;
	if (
		null !== $dragblock_current_query_list_id &&
		! empty( $dragblock_queries ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ] ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] )
	) {
		$dragblock_sp_dragblock = $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ];
	}
	return $dragblock_sp_dragblock;
}
add_shortcode( 'dragblock.post.snippet', 'dragblock_shortcode_post_snippet' );
/**
 * Check Documentation#2424
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2424.
 * @param object|array|string $dragblock_sp_current check var-def#2424.
 */
function dragblock_shortcode_post_snippet( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#2455.
	$dragblock_sp_query = '';
	$dragblock_sp_list = '125';
	$dragblock_sp_id = ! empty( $dragblock_sp_queries['len'] ) ? sanitize_text_field( $dragblock_sp_queries['len'] ) : $dragblock_sp_list;
	if ( empty( $dragblock_sp_id ) || ! is_numeric( $dragblock_sp_id ) ) {
		$dragblock_sp_id = $dragblock_sp_list;
	}
	$dragblock_sp_id = (int) $dragblock_sp_id;
	if ( has_excerpt( $dragblock_sp_current ) ) {
		$dragblock_sp_query = get_the_excerpt( $dragblock_sp_current );
	} else {
		$dragblock_sp_query = get_the_content( null, false, $dragblock_sp_current );
	}
	if ( strlen( $dragblock_sp_query ) > $dragblock_sp_id ) {
		$dragblock_sp_item = count( explode( ' ', $dragblock_sp_query ) );
		$dragblock_sp_attrs = strlen( $dragblock_sp_query ) / $dragblock_sp_item;
		$dragblock_sp_post = (int) ( $dragblock_sp_id / $dragblock_sp_attrs );
		$dragblock_sp_query = wp_trim_words( $dragblock_sp_query, $dragblock_sp_post, '...' );
	}
	// dev-reply#2477.
	return $dragblock_sp_query;
}
add_shortcode( 'dragblock.post.title', 'dragblock_shortcode_post_title' );
/**
 * Check Documentation#2455
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2455.
 * @param object|array|string $dragblock_sp_current check var-def#2455.
 */
function dragblock_shortcode_post_title( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	return get_the_title( $dragblock_sp_current );
}
add_shortcode( 'dragblock.post.url', 'dragblock_shortcode_post_url' );
/**
 * Check Documentation#2466
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2466.
 * @param object|array|string $dragblock_sp_current check var-def#2466.
 */
function dragblock_shortcode_post_url( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return 'javascript:void(0)';
	}
	return get_the_permalink( $dragblock_sp_current );
}
add_shortcode( 'dragblock.post.comment.number', 'dragblock_shortcode_post_comment_number' );
/**
 * Check Documentation#2477
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2477.
 * @param object|array|string $dragblock_sp_current check var-def#2477.
 */
function dragblock_shortcode_post_comment_number( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	return get_comments_number( $dragblock_sp_current );
}
add_shortcode( 'dragblock.post.view.count', 'dragblock_shortcode_post_view_count' );
/**
 * Check Documentation#2488
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2488.
 * @param object|array|string $dragblock_sp_current check var-def#2488.
 */
function dragblock_shortcode_post_view_count( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	return (int) get_post_meta( $dragblock_sp_current, DRAGBLOCK_POST_VIEWS_KEY, true );
}
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#2498
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2498.
 * @param object|array|string $dragblock_sp_current check var-def#2498.
 */
function dragblock_shortcode_post_image_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	// dev-reply#24136.
	$dragblock_sp_snippet = '';
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		// dev-reply#24142.
		return $dragblock_sp_snippet;
	}
	$dragblock_sp_def = isset( $dragblock_sp_queries['size'] ) ? sanitize_text_field( $dragblock_sp_queries['size'] ) : 'full';
	// dev-reply#24148.
	if ( has_post_thumbnail( $dragblock_sp_current ) ) {
		$dragblock_sp_len = get_the_post_thumbnail_url( $dragblock_sp_current, $dragblock_sp_def );
		return $dragblock_sp_len;
	}
	// dev-reply#24154.
	$dragblock_sp_word = get_post_field( 'post_content', $dragblock_sp_current );
	if ( $dragblock_sp_word ) {
		$dragblock_sp_count = new DOMDocument();
		@$dragblock_sp_count->loadHTML( $dragblock_sp_word );
		$dragblock_sp_max = $dragblock_sp_count->getElementsByTagName( 'img' );
		if ( count( $dragblock_sp_max ) > 0 ) {
			$dragblock_sp_len = $dragblock_sp_max[0]->getAttribute( 'src' );
			return $dragblock_sp_len;
		}
		// dev-reply#24168.
		$dragblock_sp_blank = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_sp_blank, $dragblock_sp_word, $dragblock_sp_src );
		if ( count( $dragblock_sp_src ) > 0 ) {
			$dragblock_sp_size = $dragblock_sp_src[2];
			$dragblock_sp_len = 'https://img.youtube.com/vi/' . $dragblock_sp_size . '/hqdefault.jpg';
			return $dragblock_sp_len;
		}
	}
	// dev-reply#24181.
	return $dragblock_sp_snippet;
	// dev-reply#24185.
}
add_shortcode( 'dragblock.post.image.srcset', 'dragblock_shortcode_post_image_srcset' );
/**
 * Check Documentation#24139
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24139.
 * @param object|array|string $dragblock_sp_current check var-def#24139.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current || ! has_post_thumbnail( $dragblock_sp_current ) ) {
		return '';
	}
	// dev-reply#24212.
	$dragblock_sp_image = get_post_thumbnail_id( $dragblock_sp_current );
	$dragblock_sp_url = wp_get_attachment_image_srcset( $dragblock_sp_image );
	return $dragblock_sp_url;
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24153
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24153.
 * @param object|array|string $dragblock_sp_current check var-def#24153.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_sp_queries, $dragblock_sp_current ) {
	$dragblock_sp_def = isset( $dragblock_sp_queries['size'] ) ? sanitize_text_field( $dragblock_sp_queries['size'] ) : 'full';
	// dev-reply#24227.
	if ( 'full' === $dragblock_sp_def ) {
		return '';
	}
	// dev-reply#24232.
	if ( 'large' === $dragblock_sp_def ) {
		return '75vw';
		// dev-reply#24235.
	}
	if ( 'medium' === $dragblock_sp_def ) {
		return '50vw';
		// dev-reply#24240.
	}
	if ( 'thumbnail' === $dragblock_sp_def ) {
		return '25vw';
		// dev-reply#24245.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24175
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24175.
 * @param object|array|string $dragblock_sp_current check var-def#24175.
 */
function dragblock_shortcode_post_date( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24261.
	$dragblock_sp_content = get_post_field( 'post_date', $dragblock_sp_current );
	// dev-reply#24264.
	$dragblock_sp_doc = get_option( 'date_format' );
	// dev-reply#24267.
	$dragblock_sp_img = date_i18n( $dragblock_sp_doc, strtotime( $dragblock_sp_content ) );
	return $dragblock_sp_img;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24192
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24192.
 * @param object|array|string $dragblock_sp_current check var-def#24192.
 */
function dragblock_shortcode_post_author_url( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24283.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24286.
	$dragblock_sp_pattern = get_author_posts_url( $dragblock_sp_tags );
	return esc_url_raw( $dragblock_sp_pattern );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24207
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24207.
 * @param object|array|string $dragblock_sp_current check var-def#24207.
 */
function dragblock_shortcode_post_author_name( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24302.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24305.
	$dragblock_sp_matches = get_the_author_meta( 'display_name', $dragblock_sp_tags );
	// dev-reply#24308.
	return $dragblock_sp_matches;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24223
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24223.
 * @param object|array|string $dragblock_sp_current check var-def#24223.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24321.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24324.
	$dragblock_sp_video = get_avatar_url( $dragblock_sp_tags, array(
		'scheme' => 'https',
	) );
	// dev-reply#24329.
	return esc_url_raw( $dragblock_sp_video );
}
add_shortcode( 'dragblock.post.author.bio', 'dragblock_shortcode_post_author_bio' );
/**
 * Check Documentation#24241
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24241.
 * @param object|array|string $dragblock_sp_current check var-def#24241.
 */
function dragblock_shortcode_post_author_bio( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24344.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24347.
	$dragblock_sp_srcset = get_the_author_meta( 'description', $dragblock_sp_tags );
	// dev-reply#24350.
	return $dragblock_sp_srcset;
}
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24257
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24257.
 * @param object|array|string $dragblock_sp_current check var-def#24257.
 */
function dragblock_shortcode_post_cat_name( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_date = get_the_category( $dragblock_sp_current );
	$dragblock_sp_format = '';
	if ( ! empty( $dragblock_sp_date ) ) {
		foreach ( $dragblock_sp_date as $dragblock_sp_formatted ) {
			if ( 0 === $dragblock_sp_formatted->category_parent ) {
				return $dragblock_sp_formatted->name;
			}
			if ( empty( $dragblock_sp_format ) ) {
				$dragblock_sp_format = $dragblock_sp_formatted->name;
			}
		}
	}
	return $dragblock_sp_format; // dev-reply#24386.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24280
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24280.
 * @param object|array|string $dragblock_sp_current check var-def#24280.
 */
function dragblock_shortcode_post_cat_url( $dragblock_sp_queries, $dragblock_sp_current ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_date = get_the_category( $dragblock_sp_current );
	$dragblock_sp_author = '';
	if ( ! empty( $dragblock_sp_date ) ) {
		foreach ( $dragblock_sp_date as $dragblock_sp_formatted ) {
			if ( 0 === $dragblock_sp_formatted->category_parent ) {
				return esc_url_raw( get_category_link( $dragblock_sp_formatted->term_id ) );
			}
			if ( empty( $dragblock_sp_author ) ) {
				$dragblock_sp_author = esc_url_raw( get_category_link( $dragblock_sp_formatted->term_id ) );
			}
		}
	}
	return $dragblock_sp_author ? $dragblock_sp_author : '#empty_cat_id'; // dev-reply#24416.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24303
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24303.
 * @param object|array|string $dragblock_sp_current check var-def#24303.
 */
function dragblock_shortcode_post_cat_id( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_date = get_the_category( $dragblock_sp_current );
	if ( ! empty( $dragblock_sp_date ) ) {
		foreach ( $dragblock_sp_date as $dragblock_sp_formatted ) {
			if ( 0 === $dragblock_sp_formatted->category_parent ) {
				return $dragblock_sp_formatted->term_id;
			}
		}
	}
	return - 1;
}
// dev-reply#24448.
