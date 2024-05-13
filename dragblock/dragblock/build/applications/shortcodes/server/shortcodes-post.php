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
	// dev-reply#2417.
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
	// dev-reply#2451.
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
	// dev-reply#2473.
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
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#2488
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2488.
 * @param object|array|string $dragblock_sp_current check var-def#2488.
 */
function dragblock_shortcode_post_image_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	// dev-reply#24119.
	$dragblock_sp_snippet = '';
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		// dev-reply#24125.
		return $dragblock_sp_snippet;
	}
	$dragblock_sp_def = isset( $dragblock_sp_queries['size'] ) ? sanitize_text_field( $dragblock_sp_queries['size'] ) : 'full';
	// dev-reply#24131.
	if ( has_post_thumbnail( $dragblock_sp_current ) ) {
		$dragblock_sp_len = get_the_post_thumbnail_url( $dragblock_sp_current, $dragblock_sp_def );
		return $dragblock_sp_len;
	}
	// dev-reply#24137.
	$dragblock_sp_word = get_post_field( 'post_content', $dragblock_sp_current );
	if ( $dragblock_sp_word ) {
		$dragblock_sp_count = new DOMDocument();
		@$dragblock_sp_count->loadHTML( $dragblock_sp_word );
		$dragblock_sp_max = $dragblock_sp_count->getElementsByTagName( 'img' );
		if ( count( $dragblock_sp_max ) > 0 ) {
			$dragblock_sp_len = $dragblock_sp_max[0]->getAttribute( 'src' );
			return $dragblock_sp_len;
		}
		// dev-reply#24151.
		$dragblock_sp_blank = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_sp_blank, $dragblock_sp_word, $dragblock_sp_src );
		if ( count( $dragblock_sp_src ) > 0 ) {
			$dragblock_sp_size = $dragblock_sp_src[2];
			$dragblock_sp_len = 'https://img.youtube.com/vi/' . $dragblock_sp_size . '/hqdefault.jpg';
			return $dragblock_sp_len;
		}
	}
	// dev-reply#24164.
	return $dragblock_sp_snippet;
	// dev-reply#24168.
}
add_shortcode( 'dragblock.post.image.srcset', 'dragblock_shortcode_post_image_srcset' );
/**
 * Check Documentation#24129
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24129.
 * @param object|array|string $dragblock_sp_current check var-def#24129.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current || ! has_post_thumbnail( $dragblock_sp_current ) ) {
		return '';
	}
	// dev-reply#24195.
	$dragblock_sp_image = get_post_thumbnail_id( $dragblock_sp_current );
	$dragblock_sp_url = wp_get_attachment_image_srcset( $dragblock_sp_image );
	return $dragblock_sp_url;
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24143
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24143.
 * @param object|array|string $dragblock_sp_current check var-def#24143.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_sp_queries, $dragblock_sp_current ) {
	$dragblock_sp_def = isset( $dragblock_sp_queries['size'] ) ? sanitize_text_field( $dragblock_sp_queries['size'] ) : 'full';
	// dev-reply#24210.
	if ( 'full' === $dragblock_sp_def ) {
		return '';
	}
	// dev-reply#24215.
	if ( 'large' === $dragblock_sp_def ) {
		return '75vw';
		// dev-reply#24218.
	}
	if ( 'medium' === $dragblock_sp_def ) {
		return '50vw';
		// dev-reply#24223.
	}
	if ( 'thumbnail' === $dragblock_sp_def ) {
		return '25vw';
		// dev-reply#24228.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24165
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24165.
 * @param object|array|string $dragblock_sp_current check var-def#24165.
 */
function dragblock_shortcode_post_date( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24244.
	$dragblock_sp_content = get_post_field( 'post_date', $dragblock_sp_current );
	// dev-reply#24247.
	$dragblock_sp_doc = get_option( 'date_format' );
	// dev-reply#24250.
	$dragblock_sp_img = date_i18n( $dragblock_sp_doc, strtotime( $dragblock_sp_content ) );
	return $dragblock_sp_img;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24182
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24182.
 * @param object|array|string $dragblock_sp_current check var-def#24182.
 */
function dragblock_shortcode_post_author_url( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24266.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24269.
	$dragblock_sp_pattern = get_author_posts_url( $dragblock_sp_tags );
	return esc_url_raw( $dragblock_sp_pattern );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24197
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24197.
 * @param object|array|string $dragblock_sp_current check var-def#24197.
 */
function dragblock_shortcode_post_author_name( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24285.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24288.
	$dragblock_sp_matches = get_the_author_meta( 'display_name', $dragblock_sp_tags );
	// dev-reply#24291.
	return $dragblock_sp_matches;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24213
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24213.
 * @param object|array|string $dragblock_sp_current check var-def#24213.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24304.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24307.
	$dragblock_sp_video = get_avatar_url( $dragblock_sp_tags, array(
		'scheme' => 'https',
	) );
	// dev-reply#24312.
	return esc_url_raw( $dragblock_sp_video );
}
add_shortcode( 'dragblock.post.author.bio', 'dragblock_shortcode_post_author_bio' );
/**
 * Check Documentation#24231
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24231.
 * @param object|array|string $dragblock_sp_current check var-def#24231.
 */
function dragblock_shortcode_post_author_bio( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24327.
	$dragblock_sp_tags = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24330.
	$dragblock_sp_srcset = get_the_author_meta( 'description', $dragblock_sp_tags );
	// dev-reply#24333.
	return $dragblock_sp_srcset;
}
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24247
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24247.
 * @param object|array|string $dragblock_sp_current check var-def#24247.
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
	return $dragblock_sp_format; // dev-reply#24369.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24270
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24270.
 * @param object|array|string $dragblock_sp_current check var-def#24270.
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
	return $dragblock_sp_author ? $dragblock_sp_author : '#empty_cat_id'; // dev-reply#24399.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24293
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24293.
 * @param object|array|string $dragblock_sp_current check var-def#24293.
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
// dev-reply#24431.