<?php
/**
 * DragBlock's Shortcodes.
 *
 * @package Shortcodes
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
	$dragblock_s_dragblock = null;
	if (
		null !== $dragblock_current_query_list_id &&
		! empty( $dragblock_queries ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ] ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] )
	) {
		$dragblock_s_dragblock = $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ];
	}
	return $dragblock_s_dragblock;
}
add_shortcode( 'dragblock.post.snippet', 'dragblock_shortcode_post_snippet' );
/**
 * Check Documentation#2424
 *
 * @param object|array|string $dragblock_s_queries check var-def#2424.
 * @param object|array|string $dragblock_s_current check var-def#2424.
 */
function dragblock_shortcode_post_snippet( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	// dev-reply#2451.
	$dragblock_s_query = '';
	$dragblock_s_list = '125';
	$dragblock_s_id = ! empty( $dragblock_s_queries['len'] ) ? sanitize_text_field( $dragblock_s_queries['len'] ) : $dragblock_s_list;
	if ( empty( $dragblock_s_id ) || ! is_numeric( $dragblock_s_id ) ) {
		$dragblock_s_id = $dragblock_s_list;
	}
	$dragblock_s_id = (int) $dragblock_s_id;
	if ( has_excerpt( $dragblock_s_current ) ) {
		$dragblock_s_query = get_the_excerpt( $dragblock_s_current );
	} else {
		$dragblock_s_query = get_the_content( null, false, $dragblock_s_current );
	}
	if ( strlen( $dragblock_s_query ) > $dragblock_s_id ) {
		$dragblock_s_item = count( explode( ' ', $dragblock_s_query ) );
		$dragblock_s_attrs = strlen( $dragblock_s_query ) / $dragblock_s_item;
		$dragblock_s_post = (int) ( $dragblock_s_id / $dragblock_s_attrs );
		$dragblock_s_query = wp_trim_words( $dragblock_s_query, $dragblock_s_post, '...' );
	}
	// dev-reply#2473.
	return $dragblock_s_query;
}
add_shortcode( 'dragblock.post.title', 'dragblock_shortcode_post_title' );
/**
 * Check Documentation#2455
 *
 * @param object|array|string $dragblock_s_queries check var-def#2455.
 * @param object|array|string $dragblock_s_current check var-def#2455.
 */
function dragblock_shortcode_post_title( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	return get_the_title( $dragblock_s_current );
}
add_shortcode( 'dragblock.post.url', 'dragblock_shortcode_post_url' );
/**
 * Check Documentation#2466
 *
 * @param object|array|string $dragblock_s_queries check var-def#2466.
 * @param object|array|string $dragblock_s_current check var-def#2466.
 */
function dragblock_shortcode_post_url( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return 'javascript:void(0)';
	}
	return get_the_permalink( $dragblock_s_current );
}
add_shortcode( 'dragblock.post.comment.number', 'dragblock_shortcode_post_comment_number' );
/**
 * Check Documentation#2477
 *
 * @param object|array|string $dragblock_s_queries check var-def#2477.
 * @param object|array|string $dragblock_s_current check var-def#2477.
 */
function dragblock_shortcode_post_comment_number( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	return get_comments_number( $dragblock_s_current );
}
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#2488
 *
 * @param object|array|string $dragblock_s_queries check var-def#2488.
 * @param object|array|string $dragblock_s_current check var-def#2488.
 */
function dragblock_shortcode_post_image_src( $dragblock_s_queries, $dragblock_s_current = null ) {
	// dev-reply#24120.
	$dragblock_s_snippet = '';
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		// dev-reply#24126.
		return $dragblock_s_snippet;
	}
	$dragblock_s_def = isset( $dragblock_s_queries['size'] ) ? sanitize_text_field( $dragblock_s_queries['size'] ) : 'full';
	// dev-reply#24132.
	if ( has_post_thumbnail( $dragblock_s_current ) ) {
		$dragblock_s_len = get_the_post_thumbnail_url( $dragblock_s_current, $dragblock_s_def );
		return $dragblock_s_len;
	}
	// dev-reply#24138.
	$dragblock_s_word = get_post_field( 'post_content', $dragblock_s_current );
	if ( $dragblock_s_word ) {
		$dragblock_s_count = new DOMDocument();
		@$dragblock_s_count->loadHTML( $dragblock_s_word );
		$dragblock_s_max = $dragblock_s_count->getElementsByTagName( 'img' );
		if ( count( $dragblock_s_max ) > 0 ) {
			$dragblock_s_len = $dragblock_s_max[0]->getAttribute( 'src' );
			return $dragblock_s_len;
		}
		// dev-reply#24152.
		$dragblock_s_blank = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_s_blank, $dragblock_s_word, $dragblock_s_src );
		if ( count( $dragblock_s_src ) > 0 ) {
			$dragblock_s_size = $dragblock_s_src[2];
			$dragblock_s_len = 'https://img.youtube.com/vi/' . $dragblock_s_size . '/hqdefault.jpg';
			return $dragblock_s_len;
		}
	}
	// dev-reply#24165.
	return $dragblock_s_snippet;
	// dev-reply#24169.
}
add_shortcode( 'dragblock.post.image.srcset', 'dragblock_shortcode_post_image_srcset' );
/**
 * Check Documentation#24129
 *
 * @param object|array|string $dragblock_s_queries check var-def#24129.
 * @param object|array|string $dragblock_s_current check var-def#24129.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current || ! has_post_thumbnail( $dragblock_s_current ) ) {
		return '';
	}
	// dev-reply#24196.
	$dragblock_s_image = get_post_thumbnail_id( $dragblock_s_current );
	$dragblock_s_url = wp_get_attachment_image_srcset( $dragblock_s_image );
	return $dragblock_s_url;
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24143
 *
 * @param object|array|string $dragblock_s_queries check var-def#24143.
 * @param object|array|string $dragblock_s_current check var-def#24143.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_s_queries, $dragblock_s_current ) {
	$dragblock_s_def = isset( $dragblock_s_queries['size'] ) ? sanitize_text_field( $dragblock_s_queries['size'] ) : 'full';
	// dev-reply#24211.
	if ( 'full' === $dragblock_s_def ) {
		return '';
	}
	// dev-reply#24216.
	if ( 'large' === $dragblock_s_def ) {
		return '75vw';
		// dev-reply#24219.
	}
	if ( 'medium' === $dragblock_s_def ) {
		return '50vw';
		// dev-reply#24224.
	}
	if ( 'thumbnail' === $dragblock_s_def ) {
		return '25vw';
		// dev-reply#24229.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24165
 *
 * @param object|array|string $dragblock_s_queries check var-def#24165.
 * @param object|array|string $dragblock_s_current check var-def#24165.
 */
function dragblock_shortcode_post_date( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	// dev-reply#24245.
	$dragblock_s_content = get_post_field( 'post_date', $dragblock_s_current );
	// dev-reply#24248.
	$dragblock_s_doc = get_option( 'date_format' );
	// dev-reply#24251.
	$dragblock_s_img = date_i18n( $dragblock_s_doc, strtotime( $dragblock_s_content ) );
	return $dragblock_s_img;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24182
 *
 * @param object|array|string $dragblock_s_queries check var-def#24182.
 * @param object|array|string $dragblock_s_current check var-def#24182.
 */
function dragblock_shortcode_post_author_url( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	// dev-reply#24267.
	$dragblock_s_tags = get_post_field( 'post_author', $dragblock_s_current );
	// dev-reply#24270.
	$dragblock_s_pattern = get_author_posts_url( $dragblock_s_tags );
	return esc_url_raw( $dragblock_s_pattern );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24197
 *
 * @param object|array|string $dragblock_s_queries check var-def#24197.
 * @param object|array|string $dragblock_s_current check var-def#24197.
 */
function dragblock_shortcode_post_author_name( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	// dev-reply#24286.
	$dragblock_s_tags = get_post_field( 'post_author', $dragblock_s_current );
	// dev-reply#24289.
	$dragblock_s_matches = get_the_author_meta( 'display_name', $dragblock_s_tags );
	// dev-reply#24292.
	return $dragblock_s_matches;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24213
 *
 * @param object|array|string $dragblock_s_queries check var-def#24213.
 * @param object|array|string $dragblock_s_current check var-def#24213.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	// dev-reply#24305.
	$dragblock_s_tags = get_post_field( 'post_author', $dragblock_s_current );
	// dev-reply#24308.
	$dragblock_s_video = get_avatar_url( $dragblock_s_tags, array(
		'scheme' => 'https',
	) );
	// dev-reply#24313.
	return esc_url_raw( $dragblock_s_video );
}
// dev-reply#24317.
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24232
 *
 * @param object|array|string $dragblock_s_queries check var-def#24232.
 * @param object|array|string $dragblock_s_current check var-def#24232.
 */
function dragblock_shortcode_post_cat_name( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	$dragblock_s_srcset = get_the_category( $dragblock_s_current );
	$dragblock_s_date = '';
	if ( ! empty( $dragblock_s_srcset ) ) {
		foreach ( $dragblock_s_srcset as $dragblock_s_format ) {
			if ( 0 === $dragblock_s_format->category_parent ) {
				return $dragblock_s_format->name;
			}
			if ( empty( $dragblock_s_date ) ) {
				$dragblock_s_date = $dragblock_s_format->name;
			}
		}
	}
	return $dragblock_s_date; // dev-reply#24370.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24255
 *
 * @param object|array|string $dragblock_s_queries check var-def#24255.
 * @param object|array|string $dragblock_s_current check var-def#24255.
 */
function dragblock_shortcode_post_cat_url( $dragblock_s_queries, $dragblock_s_current ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	$dragblock_s_srcset = get_the_category( $dragblock_s_current );
	$dragblock_s_formatted = '';
	if ( ! empty( $dragblock_s_srcset ) ) {
		foreach ( $dragblock_s_srcset as $dragblock_s_format ) {
			if ( 0 === $dragblock_s_format->category_parent ) {
				return esc_url_raw( get_category_link( $dragblock_s_format->term_id ) );
			}
			if ( empty( $dragblock_s_formatted ) ) {
				$dragblock_s_formatted = esc_url_raw( get_category_link( $dragblock_s_format->term_id ) );
			}
		}
	}
	return $dragblock_s_formatted ? $dragblock_s_formatted : '#empty_cat_id'; // dev-reply#24400.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24278
 *
 * @param object|array|string $dragblock_s_queries check var-def#24278.
 * @param object|array|string $dragblock_s_current check var-def#24278.
 */
function dragblock_shortcode_post_cat_id( $dragblock_s_queries, $dragblock_s_current = null ) {
	if ( ! $dragblock_s_current ) {
		$dragblock_s_current = dragblock_get_current_list_query_id();
	}
	if ( ! $dragblock_s_current ) {
		return '';
	}
	$dragblock_s_srcset = get_the_category( $dragblock_s_current );
	if ( ! empty( $dragblock_s_srcset ) ) {
		foreach ( $dragblock_s_srcset as $dragblock_s_format ) {
			if ( 0 === $dragblock_s_format->category_parent ) {
				return $dragblock_s_format->term_id;
			}
		}
	}
	return - 1;
}
// dev-reply#24432.
add_shortcode( 'dragblock.home.url', 'dragblock_shortcode_home_url' );
/**
 * Check Documentation#24298
 *
 * @param object|array|string $dragblock_s_queries check var-def#24298.
 */
function dragblock_shortcode_home_url( $dragblock_s_queries ) {
	return get_home_url();
}
add_shortcode( 'dragblock.share.url.twitter', 'dragblock_shortcode_share_url_twitter' );
/**
 * Check Documentation#24303
 *
 * @param object|array|string $dragblock_s_queries check var-def#24303.
 */
function dragblock_shortcode_share_url_twitter( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://twitter.com/intent/tweet?text=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.facebook', 'dragblock_shortcode_share_url_facebook' );
/**
 * Check Documentation#24311
 *
 * @param object|array|string $dragblock_s_queries check var-def#24311.
 */
function dragblock_shortcode_share_url_facebook( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.whatsapp', 'dragblock_shortcode_share_url_whatsapp' );
/**
 * Check Documentation#24319
 *
 * @param object|array|string $dragblock_s_queries check var-def#24319.
 */
function dragblock_shortcode_share_url_whatsapp( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://wa.me/?text=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.telegram', 'dragblock_shortcode_share_url_telegram' );
/**
 * Check Documentation#24327
 *
 * @param object|array|string $dragblock_s_queries check var-def#24327.
 */
function dragblock_shortcode_share_url_telegram( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://t.me/share/url?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.tumblr', 'dragblock_shortcode_share_url_tumblr' );
/**
 * Check Documentation#24335
 *
 * @param object|array|string $dragblock_s_queries check var-def#24335.
 */
function dragblock_shortcode_share_url_tumblr( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.reddit', 'dragblock_shortcode_share_url_reddit' );
/**
 * Check Documentation#24343
 *
 * @param object|array|string $dragblock_s_queries check var-def#24343.
 */
function dragblock_shortcode_share_url_reddit( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.reddit.com/submit?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.linkedin', 'dragblock_shortcode_share_url_linkedin' );
/**
 * Check Documentation#24351
 *
 * @param object|array|string $dragblock_s_queries check var-def#24351.
 */
function dragblock_shortcode_share_url_linkedin( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.gmail', 'dragblock_shortcode_share_url_gmail' );
/**
 * Check Documentation#24359
 *
 * @param object|array|string $dragblock_s_queries check var-def#24359.
 */
function dragblock_shortcode_share_url_gmail( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&body=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.email', 'dragblock_shortcode_share_url_email' );
/**
 * Check Documentation#24367
 *
 * @param object|array|string $dragblock_s_queries check var-def#24367.
 */
function dragblock_shortcode_share_url_email( $dragblock_s_queries ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'mailto:?body=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.navigator', 'dragblock_shortcode_share_url_navigator' );
/**
 * Check Documentation#24375
 *
 * @param object|array|string $dragblock_s_queries check var-def#24375.
 */
function dragblock_shortcode_share_url_navigator( $dragblock_s_queries ) {
	return 'javascript:navigator.share?navigator.share({url:location.href}):null';
}
add_filter( 'kses_allowed_protocols', 'dragblock_kses_allowed_protocols', 1 );
/**
 * Check Documentation#24380
 *
 * @param object|array|string $dragblock_s_author check var-def#24380.
 */
function dragblock_kses_allowed_protocols( $dragblock_s_author ) {
	$dragblock_s_author[] = 'data';
	$dragblock_s_author[] = 'javascript';
	return $dragblock_s_author;
}
