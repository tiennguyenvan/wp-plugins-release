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
	// dev-reply#2452.
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
	// dev-reply#2474.
	return $dragblock_sp_query;
}
add_shortcode( 'dragblock.post.content', 'dragblock_shortcode_post_content' );
/**
 * Check Documentation#2455
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2455.
 * @param object|array|string $dragblock_sp_current check var-def#2455.
 */
function dragblock_shortcode_post_content( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	return get_the_content( null, false, $dragblock_sp_current );;
}
add_shortcode( 'dragblock.post.title', 'dragblock_shortcode_post_title' );
/**
 * Check Documentation#2466
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2466.
 * @param object|array|string $dragblock_sp_current check var-def#2466.
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
 * Check Documentation#2477
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2477.
 * @param object|array|string $dragblock_sp_current check var-def#2477.
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
 * Check Documentation#2488
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2488.
 * @param object|array|string $dragblock_sp_current check var-def#2488.
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
 * Check Documentation#2499
 *
 * @param object|array|string $dragblock_sp_queries check var-def#2499.
 * @param object|array|string $dragblock_sp_current check var-def#2499.
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
// dev-reply#24148.
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#24111
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24111.
 * @param object|array|string $dragblock_sp_current check var-def#24111.
 */
function dragblock_shortcode_post_image_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	// dev-reply#24169.
	$dragblock_sp_snippet = '';
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		// dev-reply#24175.
		return $dragblock_sp_snippet;
	}
	// dev-reply#24180.
	if ( has_post_thumbnail( $dragblock_sp_current ) ) {
		if ( isset( $dragblock_sp_queries['size'] ) ) {
			return get_the_post_thumbnail_url( $dragblock_sp_current, $dragblock_sp_queries['size'] );
		}
		// dev-reply#24186.
		$dragblock_sp_def = get_post_thumbnail_id( $dragblock_sp_current );
		$dragblock_sp_len = wp_get_attachment_metadata( $dragblock_sp_def );
		if ( isset( $dragblock_sp_len['file'] ) && isset( $dragblock_sp_len['filesize'] ) ) {
			$dragblock_sp_word = '';
			$dragblock_sp_count = $dragblock_sp_len['filesize'];
			if ( ! empty( $dragblock_sp_len['sources'] ) ) {
				foreach ( $dragblock_sp_len['sources'] as $dragblock_sp_max ) {
					if ( empty( $dragblock_sp_max['file'] ) || empty( $dragblock_sp_max['filesize'] ) || $dragblock_sp_max['filesize'] > $dragblock_sp_count ) {
						continue;
					}
					$dragblock_sp_word = $dragblock_sp_max['file'];
					$dragblock_sp_count = $dragblock_sp_max['filesize'];
				}
			}
			if ( empty( $dragblock_sp_word ) ) {
				return get_the_post_thumbnail_url( $dragblock_sp_current, 'full' );
			}
			$dragblock_sp_blank = wp_get_upload_dir();
			$dragblock_sp_src = $dragblock_sp_len['file']; // dev-reply#24207.
			$dragblock_sp_image = pathinfo( $dragblock_sp_src, PATHINFO_DIRNAME );
			if ( ( $dragblock_sp_image ) === '.' ) { // dev-reply#24209.
				$dragblock_sp_image = ''; // dev-reply#24210.
			} else {
				$dragblock_sp_image .= '/';
			}
			$dragblock_sp_meta = trailingslashit( $dragblock_sp_blank['baseurl'] ) . $dragblock_sp_image . $dragblock_sp_word;
			return $dragblock_sp_meta;
		}
		return get_the_post_thumbnail_url( $dragblock_sp_current, 'full' );
		// dev-reply#24220.
	}
	$dragblock_sp_smallest = get_post_field( 'post_content', $dragblock_sp_current );
	if ( $dragblock_sp_smallest ) {
		$dragblock_sp_file = new DOMDocument();
		@$dragblock_sp_file->loadHTML( $dragblock_sp_smallest );
		$dragblock_sp_name = $dragblock_sp_file->getElementsByTagName( 'img' );
		if ( count( $dragblock_sp_name ) > 0 ) {
			$dragblock_sp_size = $dragblock_sp_name[0]->getAttribute( 'src' );
			return $dragblock_sp_size;
		}
		// dev-reply#24238.
		$dragblock_sp_source = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_sp_source, $dragblock_sp_smallest, $dragblock_sp_upload );
		if ( count( $dragblock_sp_upload ) > 0 ) {
			$dragblock_sp_dir = $dragblock_sp_upload[2];
			$dragblock_sp_size = 'https://img.youtube.com/vi/' . $dragblock_sp_dir . '/hqdefault.jpg';
			return $dragblock_sp_size;
		}
	}
	// dev-reply#24251.
	return $dragblock_sp_snippet;
	// dev-reply#24255.
}
add_shortcode( 'dragblock.post.image.srcset', 'dragblock_shortcode_post_image_srcset' );
/**
 * Check Documentation#24182
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24182.
 * @param object|array|string $dragblock_sp_current check var-def#24182.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	// dev-reply#24337.
	if ( ! $dragblock_sp_current || ! has_post_thumbnail( $dragblock_sp_current ) ) {
		return '';
	}
	$dragblock_sp_def = get_post_thumbnail_id( $dragblock_sp_current );
	$dragblock_sp_original = wp_get_attachment_image_srcset( $dragblock_sp_def );
	return $dragblock_sp_original;
}
add_shortcode( 'dragblock.post.image.caption', 'dragblock_shortcode_post_image_caption' );
/**
 * Check Documentation#24196
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24196.
 * @param object|array|string $dragblock_sp_current check var-def#24196.
 */
function dragblock_shortcode_post_image_caption( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	// dev-reply#24354.
	if ( ! $dragblock_sp_current || ! has_post_thumbnail( $dragblock_sp_current ) ) {
		return '';
	}
	$dragblock_sp_def = get_post_thumbnail_id( $dragblock_sp_current );
	// dev-reply#24361.
	$dragblock_sp_content = wp_get_attachment_caption( $dragblock_sp_def );
	return $dragblock_sp_content ? esc_html( $dragblock_sp_content ) : "";
}
add_shortcode( 'dragblock.post.image.alt', 'dragblock_shortcode_post_image_alt' );
/**
 * Check Documentation#24210
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24210.
 * @param object|array|string $dragblock_sp_current check var-def#24210.
 */
function dragblock_shortcode_post_image_alt( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	// dev-reply#24373.
	$dragblock_sp_def = get_post_thumbnail_id( $dragblock_sp_current );
	if ( ! $dragblock_sp_def ) {
		return '';
	}
	// dev-reply#24380.
	$dragblock_sp_doc = get_post_meta( $dragblock_sp_def, '_wp_attachment_image_alt', true );
	return $dragblock_sp_doc ? esc_html( $dragblock_sp_doc ) : '';
}
add_shortcode( 'dragblock.post.image.desc', 'dragblock_shortcode_post_image_desc' );
/**
 * Check Documentation#24224
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24224.
 * @param object|array|string $dragblock_sp_current check var-def#24224.
 */
function dragblock_shortcode_post_image_desc( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	// dev-reply#24392.
	$dragblock_sp_def = get_post_thumbnail_id( $dragblock_sp_current );
	if ( ! $dragblock_sp_def ) {
		return '';
	}
	// dev-reply#24399.
	$dragblock_sp_img = get_post_field( 'post_content', $dragblock_sp_def );
	return $dragblock_sp_img ? esc_html( $dragblock_sp_img ) : '';
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24238
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24238.
 * @param object|array|string $dragblock_sp_current check var-def#24238.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_sp_queries, $dragblock_sp_current ) {
	$dragblock_sp_tags = isset( $dragblock_sp_queries['size'] ) ? sanitize_text_field( $dragblock_sp_queries['size'] ) : 'full';
	// dev-reply#24414.
	if ( 'full' === $dragblock_sp_tags ) {
		return '';
	}
	// dev-reply#24419.
	if ( 'large' === $dragblock_sp_tags ) {
		return '75vw';
		// dev-reply#24422.
	}
	if ( 'medium' === $dragblock_sp_tags ) {
		return '50vw';
		// dev-reply#24427.
	}
	if ( 'thumbnail' === $dragblock_sp_tags ) {
		return '25vw';
		// dev-reply#24432.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24260
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24260.
 * @param object|array|string $dragblock_sp_current check var-def#24260.
 */
function dragblock_shortcode_post_date( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24448.
	$dragblock_sp_url = get_post_field( 'post_date', $dragblock_sp_current );
	// dev-reply#24451.
	$dragblock_sp_pattern = get_option( 'date_format' );
	// dev-reply#24454.
	$dragblock_sp_matches = date_i18n( $dragblock_sp_pattern, strtotime( $dragblock_sp_url ) );
	return $dragblock_sp_matches;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24277
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24277.
 * @param object|array|string $dragblock_sp_current check var-def#24277.
 */
function dragblock_shortcode_post_author_url( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24470.
	$dragblock_sp_video = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24473.
	$dragblock_sp_srcset = get_author_posts_url( $dragblock_sp_video );
	return esc_url_raw( $dragblock_sp_srcset );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24292
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24292.
 * @param object|array|string $dragblock_sp_current check var-def#24292.
 */
function dragblock_shortcode_post_author_name( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24489.
	$dragblock_sp_video = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24492.
	$dragblock_sp_caption = get_the_author_meta( 'display_name', $dragblock_sp_video );
	// dev-reply#24495.
	return $dragblock_sp_caption;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24308
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24308.
 * @param object|array|string $dragblock_sp_current check var-def#24308.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24508.
	$dragblock_sp_video = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24511.
	$dragblock_sp_alt = get_avatar_url( $dragblock_sp_video, array(
		'scheme' => 'https',
	) );
	// dev-reply#24516.
	return esc_url_raw( $dragblock_sp_alt );
}
add_shortcode( 'dragblock.post.author.bio', 'dragblock_shortcode_post_author_bio' );
/**
 * Check Documentation#24326
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24326.
 * @param object|array|string $dragblock_sp_current check var-def#24326.
 */
function dragblock_shortcode_post_author_bio( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	// dev-reply#24531.
	$dragblock_sp_video = get_post_field( 'post_author', $dragblock_sp_current );
	// dev-reply#24534.
	$dragblock_sp_text = get_the_author_meta( 'description', $dragblock_sp_video );
	// dev-reply#24537.
	return $dragblock_sp_text;
}
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24342
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24342.
 * @param object|array|string $dragblock_sp_current check var-def#24342.
 */
function dragblock_shortcode_post_cat_name( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_description = get_the_category( $dragblock_sp_current );
	$dragblock_sp_date = '';
	if ( ! empty( $dragblock_sp_description ) ) {
		// dev-reply#24558.
		foreach ( $dragblock_sp_description as $dragblock_sp_format ) {
			if ( 0 === $dragblock_sp_format->category_parent ) {
				return $dragblock_sp_format->name;
			}
			if ( empty( $dragblock_sp_date ) ) {
				$dragblock_sp_date = $dragblock_sp_format->name;
			}
		}
	}
	return $dragblock_sp_date; // dev-reply#24571.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24366
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24366.
 * @param object|array|string $dragblock_sp_current check var-def#24366.
 */
function dragblock_shortcode_post_cat_url( $dragblock_sp_queries, $dragblock_sp_current ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_description = get_the_category( $dragblock_sp_current );
	$dragblock_sp_formatted = '';
	if ( ! empty( $dragblock_sp_description ) ) {
		// dev-reply#24588.
		foreach ( $dragblock_sp_description as $dragblock_sp_format ) {
			if ( 0 === $dragblock_sp_format->category_parent ) {
				return esc_url_raw( get_category_link( $dragblock_sp_format->term_id ) );
			}
			if ( empty( $dragblock_sp_formatted ) ) {
				$dragblock_sp_formatted = esc_url_raw( get_category_link( $dragblock_sp_format->term_id ) );
			}
		}
	}
	return $dragblock_sp_formatted ? $dragblock_sp_formatted : '#empty_cat_id'; // dev-reply#24599.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24390
 *
 * @param object|array|string $dragblock_sp_queries check var-def#24390.
 * @param object|array|string $dragblock_sp_current check var-def#24390.
 */
function dragblock_shortcode_post_cat_id( $dragblock_sp_queries, $dragblock_sp_current = null ) {
	if ( ! $dragblock_sp_current ) {
		$dragblock_sp_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_sp_current ) {
		return '';
	}
	$dragblock_sp_description = get_the_category( $dragblock_sp_current );
	if ( empty( $dragblock_sp_description ) || is_wp_error( $dragblock_sp_description ) ) {
		$dragblock_sp_author = get_post_type( $dragblock_sp_current );
		if ( ! $dragblock_sp_author || 'post' === $dragblock_sp_author ) {
			return - 1;
		}
		$dragblock_sp_description = get_the_terms( $dragblock_sp_current, $dragblock_sp_author . '-category' );
		if ( empty( $dragblock_sp_description ) || is_wp_error( $dragblock_sp_description ) ) {
			$dragblock_sp_description = get_the_terms( $dragblock_sp_current, $dragblock_sp_author . '_category' );
			if ( empty( $dragblock_sp_description ) || is_wp_error( $dragblock_sp_description ) ) {
				return - 1;
			}
		}
	}
	// dev-reply#24629.
	foreach ( $dragblock_sp_description as $dragblock_sp_format ) {
		// dev-reply#24632.
		if ( 0 === $dragblock_sp_format->category_parent || 0 === $dragblock_sp_format->parent ) {
			return $dragblock_sp_format->term_id;
		}
	}
	// dev-reply#24637.
	return - 1;
}
// dev-reply#24642.
