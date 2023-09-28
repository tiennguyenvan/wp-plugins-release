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
	$dragblock_s_item_id = null;
	if (
		null !== $dragblock_current_query_list_id &&
		! empty( $dragblock_queries ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ] ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] )
	) {
		$dragblock_s_item_id = $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ];
	}
	return $dragblock_s_item_id;
}
add_shortcode( 'dragblock.post.snippet', 'dragblock_shortcode_post_snippet' );
/**
 * Check Documentation#2424
 *
 * @param object|array|string $dragblock_s_attrs check var-def#2424.
 */
function dragblock_shortcode_post_snippet( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	$dragblock_s_def_len = '125';
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	// dev-reply#2453.
	$dragblock_s_snippet = '';
	$dragblock_s_len = ! empty( $dragblock_s_attrs['len'] ) ? sanitize_text_field( $dragblock_s_attrs['len'] ) : $dragblock_s_def_len;
	if ( empty( $dragblock_s_len ) || ! is_numeric( $dragblock_s_len ) ) {
		$dragblock_s_len = $dragblock_s_def_len;
	}
	$dragblock_s_len = (int) $dragblock_s_len;
	if ( has_excerpt( $dragblock_s_post_id ) ) {
		$dragblock_s_snippet = get_the_excerpt( $dragblock_s_post_id );
	} else {
		$dragblock_s_snippet = get_the_content( null, false, $dragblock_s_post_id );
	}
	if ( strlen( $dragblock_s_snippet ) > $dragblock_s_len ) {
		$dragblock_s_word_count = count( explode( ' ', $dragblock_s_snippet ) );
		$dragblock_s_word_len = strlen( $dragblock_s_snippet ) / $dragblock_s_word_count;
		$dragblock_s_max_word_count = (int) ( $dragblock_s_len / $dragblock_s_word_len );
		$dragblock_s_snippet = wp_trim_words( $dragblock_s_snippet, $dragblock_s_max_word_count, '...' );
	}
	// dev-reply#2474.
	return $dragblock_s_snippet;
}
add_shortcode( 'dragblock.post.title', 'dragblock_shortcode_post_title' );
/**
 * Check Documentation#2453
 *
 * @param object|array|string $dragblock_s_attrs check var-def#2453.
 */
function dragblock_shortcode_post_title( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	return get_the_title( $dragblock_s_post_id );
}
add_shortcode( 'dragblock.post.url', 'dragblock_shortcode_post_url' );
/**
 * Check Documentation#2462
 *
 * @param object|array|string $dragblock_s_attrs check var-def#2462.
 */
function dragblock_shortcode_post_url( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return 'javascript:void(0)';
	}
	return get_the_permalink( $dragblock_s_post_id );
}
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#2471
 *
 * @param object|array|string $dragblock_s_attrs check var-def#2471.
 */
function dragblock_shortcode_post_image_src( $dragblock_s_attrs ) {
	$dragblock_s_size = isset( $dragblock_s_attrs['size'] ) ? sanitize_text_field( $dragblock_s_attrs['size'] ) : 'full';
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
	}
	// dev-reply#24116.
	if ( has_post_thumbnail( $dragblock_s_post_id ) ) {
		$dragblock_s_image_url = get_the_post_thumbnail_url( $dragblock_s_post_id, $dragblock_s_size );
		return $dragblock_s_image_url;
	}
	// dev-reply#24123.
	$dragblock_s_content = get_post_field( 'post_content', $dragblock_s_post_id );
	if ( $dragblock_s_content ) {
		$dragblock_s_doc = new DOMDocument();
		@$dragblock_s_doc->loadHTML( $dragblock_s_content );
		$dragblock_s_img_tags = $dragblock_s_doc->getElementsByTagName( 'img' );
		if ( count( $dragblock_s_img_tags ) > 0 ) {
			$dragblock_s_image_url = $dragblock_s_img_tags[0]->getAttribute( 'src' );
			return $dragblock_s_image_url;
		}
		// dev-reply#24137.
		$dragblock_s_pattern = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_s_pattern, $dragblock_s_content, $dragblock_s_matches );
		if ( count( $dragblock_s_matches ) > 0 ) {
			$dragblock_s_video_id = $dragblock_s_matches[2];
			$dragblock_s_image_url = 'https://img.youtube.com/vi/' . $dragblock_s_video_id . '/hqdefault.jpg';
			return $dragblock_s_image_url;
		}
	}
	// dev-reply#24150.
	return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
	// dev-reply#24154.
}
add_shortcode( 'dragblock.post.image.srcset', 'dragblock_shortcode_post_image_srcset' );
/**
 * Check Documentation#24107
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24107.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id || ! has_post_thumbnail( $dragblock_s_post_id ) ) {
		return '';
	}
	// dev-reply#24180.
	$dragblock_s_image_id = get_post_thumbnail_id( $dragblock_s_post_id );
	$dragblock_s_image_srcset = wp_get_attachment_image_srcset( $dragblock_s_image_id );
	return $dragblock_s_image_srcset;
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24119
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24119.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_s_attrs ) {
	$dragblock_s_size = isset( $dragblock_s_attrs['size'] ) ? sanitize_text_field( $dragblock_s_attrs['size'] ) : 'full';
	// dev-reply#24195.
	if ( 'full' === $dragblock_s_size ) {
		return '';
	}
	// dev-reply#24200.
	if ( 'large' === $dragblock_s_size ) {
		return '75vw';
		// dev-reply#24203.
	}
	if ( 'medium' === $dragblock_s_size ) {
		return '50vw';
		// dev-reply#24208.
	}
	if ( 'thumbnail' === $dragblock_s_size ) {
		return '25vw';
		// dev-reply#24213.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24141
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24141.
 */
function dragblock_shortcode_post_date( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	// dev-reply#24228.
	$dragblock_s_post_date = get_post_field( 'post_date', $dragblock_s_post_id );
	// dev-reply#24231.
	$dragblock_s_date_format = get_option( 'date_format' );
	// dev-reply#24234.
	$dragblock_s_formatted_date = date_i18n( $dragblock_s_date_format, strtotime( $dragblock_s_post_date ) );
	return $dragblock_s_formatted_date;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24156
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24156.
 */
function dragblock_shortcode_post_author_url( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	// dev-reply#24249.
	$dragblock_s_author_id = get_post_field( 'post_author', $dragblock_s_post_id );
	// dev-reply#24252.
	$dragblock_s_author_url = get_author_posts_url( $dragblock_s_author_id );
	return esc_url_raw( $dragblock_s_author_url );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24169
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24169.
 */
function dragblock_shortcode_post_author_name( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	// dev-reply#24267.
	$dragblock_s_author_id = get_post_field( 'post_author', $dragblock_s_post_id );
	// dev-reply#24270.
	$dragblock_s_author_name = get_the_author_meta( 'display_name', $dragblock_s_author_id );
	// dev-reply#24273.
	return $dragblock_s_author_name;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24183
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24183.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	// dev-reply#24285.
	$dragblock_s_author_id = get_post_field( 'post_author', $dragblock_s_post_id );
	// dev-reply#24288.
	$dragblock_s_avatar_src = get_avatar_url( $dragblock_s_author_id );
	return esc_url_raw( $dragblock_s_avatar_src );
}
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24196
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24196.
 */
function dragblock_shortcode_post_cat_name( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	$dragblock_s_categories = get_the_category( $dragblock_s_post_id );
	if ( ! empty( $dragblock_s_categories ) ) {
		foreach ( $dragblock_s_categories as $dragblock_s_category ) {
			if ( 0 === $dragblock_s_category->category_parent ) {
				return $dragblock_s_category->name;
			}
		}
	}
	return ''; // dev-reply#24320.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24213
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24213.
 */
function dragblock_shortcode_post_cat_url( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	$dragblock_s_categories = get_the_category( $dragblock_s_post_id );
	if ( ! empty( $dragblock_s_categories ) ) {
		foreach ( $dragblock_s_categories as $dragblock_s_category ) {
			if ( 0 === $dragblock_s_category->category_parent ) {
				return esc_url_raw( get_category_link( $dragblock_s_category->term_id ) );
			}
		}
	}
	return '#empty_cat_id'; // dev-reply#24346.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24230
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24230.
 */
function dragblock_shortcode_post_cat_id( $dragblock_s_attrs ) {
	$dragblock_s_post_id = dragblock_get_current_list_query_id();
	if ( null === $dragblock_s_post_id ) {
		return '';
	}
	$dragblock_s_categories = get_the_category( $dragblock_s_post_id );
	if ( ! empty( $dragblock_s_categories ) ) {
		foreach ( $dragblock_s_categories as $dragblock_s_category ) {
			if ( 0 === $dragblock_s_category->category_parent ) {
				return $dragblock_s_category->term_id;
			}
		}
	}
	return - 1;
}
// dev-reply#24377.
add_shortcode( 'dragblock.share.url.twitter', 'dragblock_shortcode_share_url_twitter' );
/**
 * Check Documentation#24248
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24248.
 */
function dragblock_shortcode_share_url_twitter( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://twitter.com/intent/tweet?text=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.facebook', 'dragblock_shortcode_share_url_facebook' );
/**
 * Check Documentation#24256
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24256.
 */
function dragblock_shortcode_share_url_facebook( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.whatsapp', 'dragblock_shortcode_share_url_whatsapp' );
/**
 * Check Documentation#24264
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24264.
 */
function dragblock_shortcode_share_url_whatsapp( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://wa.me/?text=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.telegram', 'dragblock_shortcode_share_url_telegram' );
/**
 * Check Documentation#24272
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24272.
 */
function dragblock_shortcode_share_url_telegram( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://t.me/share/url?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.tumblr', 'dragblock_shortcode_share_url_tumblr' );
/**
 * Check Documentation#24280
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24280.
 */
function dragblock_shortcode_share_url_tumblr( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.reddit', 'dragblock_shortcode_share_url_reddit' );
/**
 * Check Documentation#24288
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24288.
 */
function dragblock_shortcode_share_url_reddit( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.reddit.com/submit?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.linkedin', 'dragblock_shortcode_share_url_linkedin' );
/**
 * Check Documentation#24296
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24296.
 */
function dragblock_shortcode_share_url_linkedin( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.gmail', 'dragblock_shortcode_share_url_gmail' );
/**
 * Check Documentation#24304
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24304.
 */
function dragblock_shortcode_share_url_gmail( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&body=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.email', 'dragblock_shortcode_share_url_email' );
/**
 * Check Documentation#24312
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24312.
 */
function dragblock_shortcode_share_url_email( $dragblock_s_attrs ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'mailto:?body=' . esc_url_raw( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
}
add_shortcode( 'dragblock.share.url.navigator', 'dragblock_shortcode_share_url_navigator' );
/**
 * Check Documentation#24320
 *
 * @param object|array|string $dragblock_s_attrs check var-def#24320.
 */
function dragblock_shortcode_share_url_navigator( $dragblock_s_attrs ) {
	return 'javascript:navigator.share?navigator.share({url:location.href}):null';
}
add_filter( 'kses_allowed_protocols', 'dragblock_kses_allowed_protocols', 1 );
/**
 * Check Documentation#24325
 *
 * @param object|array|string $dragblock_s_protocols check var-def#24325.
 */
function dragblock_kses_allowed_protocols( $dragblock_s_protocols ) {
	$dragblock_s_protocols[] = 'data';
	$dragblock_s_protocols[] = 'javascript';
	return $dragblock_s_protocols;
}
