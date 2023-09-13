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
	$dragblock_0 = null;
	if (
		null !== $dragblock_current_query_list_id &&
		! empty( $dragblock_queries ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ] ) &&
		! empty( $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ] )
	) {
		$dragblock_0 = $dragblock_queries[ $dragblock_current_query_list_id ][ $dragblock_current_query_list_item_id ];
	}
	return $dragblock_0;
}
add_shortcode( 'dragblock.post.snippet', 'dragblock_shortcode_post_snippet' );
/**
 * Check Documentation#2424
 *
 * @param object|array|string $dragblock_1 check var-def#2424.
 */
function dragblock_shortcode_post_snippet( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	$dragblock_3 = '125';
	if ( null === $dragblock_2 ) {
		return '';
	}
	// dev-reply#2453.
	$dragblock_4 = '';
	$dragblock_5 = ! empty( $dragblock_1['len'] ) ? sanitize_text_field( $dragblock_1['len'] ) : $dragblock_3;
	if ( empty( $dragblock_5 ) || ! is_numeric( $dragblock_5 ) ) {
		$dragblock_5 = $dragblock_3;
	}
	$dragblock_5 = (int) $dragblock_5;
	if ( has_excerpt( $dragblock_2 ) ) {
		$dragblock_4 = get_the_excerpt( $dragblock_2 );
	} else {
		$dragblock_4 = get_the_content( null, false, $dragblock_2 );
	}
	if ( strlen( $dragblock_4 ) > $dragblock_5 ) {
		$dragblock_6 = count( explode( ' ', $dragblock_4 ) );
		$dragblock_7 = strlen( $dragblock_4 ) / $dragblock_6;
		$dragblock_8 = (int) ( $dragblock_5 / $dragblock_7 );
		$dragblock_4 = wp_trim_words( $dragblock_4, $dragblock_8, '...' );
	}
	// dev-reply#2474.
	return $dragblock_4;
}
add_shortcode( 'dragblock.post.title', 'dragblock_shortcode_post_title' );
/**
 * Check Documentation#2453
 *
 * @param object|array|string $dragblock_1 check var-def#2453.
 */
function dragblock_shortcode_post_title( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	return get_the_title( $dragblock_2 );
}
add_shortcode( 'dragblock.post.url', 'dragblock_shortcode_post_url' );
/**
 * Check Documentation#2462
 *
 * @param object|array|string $dragblock_1 check var-def#2462.
 */
function dragblock_shortcode_post_url( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return 'javascript:void(0)';
	}
	return get_the_permalink( $dragblock_2 );
}
add_shortcode( 'dragblock.post.image.src', 'dragblock_shortcode_post_image_src' );
/**
 * Check Documentation#2471
 *
 * @param object|array|string $dragblock_1 check var-def#2471.
 */
function dragblock_shortcode_post_image_src( $dragblock_1 ) {
	$dragblock_9 = isset( $dragblock_1['size'] ) ? sanitize_text_field( $dragblock_1['size'] ) : 'full';
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
	}
	// dev-reply#24116.
	if ( has_post_thumbnail( $dragblock_2 ) ) {
		$dragblock_10 = get_the_post_thumbnail_url( $dragblock_2, $dragblock_9 );
		return $dragblock_10;
	}
	// dev-reply#24123.
	$dragblock_11 = get_post_field( 'post_content', $dragblock_2 );
	if ( $dragblock_11 ) {
		$dragblock_12 = new DOMDocument();
		@$dragblock_12->loadHTML( $dragblock_11 );
		$dragblock_13 = $dragblock_12->getElementsByTagName( 'img' );
		if ( count( $dragblock_13 ) > 0 ) {
			$dragblock_10 = $dragblock_13[0]->getAttribute( 'src' );
			return $dragblock_10;
		}
		// dev-reply#24137.
		$dragblock_14 = '/<iframe.*?src="(https?:\/\/www\.youtube\.com\/embed\/([\w-]+))".*?><\/iframe>/i';
		preg_match( $dragblock_14, $dragblock_11, $dragblock_15 );
		if ( count( $dragblock_15 ) > 0 ) {
			$dragblock_16 = $dragblock_15[2];
			$dragblock_10 = 'https://img.youtube.com/vi/' . $dragblock_16 . '/hqdefault.jpg';
			return $dragblock_10;
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
 * @param object|array|string $dragblock_1 check var-def#24107.
 */
function dragblock_shortcode_post_image_srcset( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 || ! has_post_thumbnail( $dragblock_2 ) ) {
		return '';
	}
	// dev-reply#24180.
	$dragblock_17 = get_post_thumbnail_id( $dragblock_2 );
	$dragblock_18 = wp_get_attachment_image_srcset( $dragblock_17 );
	return $dragblock_18;
}
add_shortcode( 'dragblock.post.image.sizes', 'dragblock_shortcode_post_image_sizes' );
/**
 * Check Documentation#24119
 *
 * @param object|array|string $dragblock_1 check var-def#24119.
 */
function dragblock_shortcode_post_image_sizes( $dragblock_1 ) {
	$dragblock_9 = isset( $dragblock_1['size'] ) ? sanitize_text_field( $dragblock_1['size'] ) : 'full';
	// dev-reply#24195.
	if ( 'full' === $dragblock_9 ) {
		return '';
	}
	// dev-reply#24200.
	if ( 'large' === $dragblock_9 ) {
		return '75vw';
		// dev-reply#24203.
	}
	if ( 'medium' === $dragblock_9 ) {
		return '50vw';
		// dev-reply#24208.
	}
	if ( 'thumbnail' === $dragblock_9 ) {
		return '25vw';
		// dev-reply#24213.
	}
}
add_shortcode( 'dragblock.post.date', 'dragblock_shortcode_post_date' );
/**
 * Check Documentation#24141
 *
 * @param object|array|string $dragblock_1 check var-def#24141.
 */
function dragblock_shortcode_post_date( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	// dev-reply#24228.
	$dragblock_19 = get_post_field( 'post_date', $dragblock_2 );
	// dev-reply#24231.
	$dragblock_20 = get_option( 'date_format' );
	// dev-reply#24234.
	$dragblock_21 = date_i18n( $dragblock_20, strtotime( $dragblock_19 ) );
	return $dragblock_21;
}
add_shortcode( 'dragblock.post.author.url', 'dragblock_shortcode_post_author_url' );
/**
 * Check Documentation#24156
 *
 * @param object|array|string $dragblock_1 check var-def#24156.
 */
function dragblock_shortcode_post_author_url( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	// dev-reply#24249.
	$dragblock_22 = get_post_field( 'post_author', $dragblock_2 );
	// dev-reply#24252.
	$dragblock_23 = get_author_posts_url( $dragblock_22 );
	return esc_url_raw( $dragblock_23 );
}
add_shortcode( 'dragblock.post.author.name', 'dragblock_shortcode_post_author_name' );
/**
 * Check Documentation#24169
 *
 * @param object|array|string $dragblock_1 check var-def#24169.
 */
function dragblock_shortcode_post_author_name( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	// dev-reply#24267.
	$dragblock_22 = get_post_field( 'post_author', $dragblock_2 );
	// dev-reply#24270.
	$dragblock_24 = get_the_author_meta( 'display_name', $dragblock_22 );
	// dev-reply#24273.
	return $dragblock_24;
}
add_shortcode( 'dragblock.post.author.avatar.src', 'dragblock_shortcode_post_author_avatar_src' );
/**
 * Check Documentation#24183
 *
 * @param object|array|string $dragblock_1 check var-def#24183.
 */
function dragblock_shortcode_post_author_avatar_src( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	// dev-reply#24285.
	$dragblock_22 = get_post_field( 'post_author', $dragblock_2 );
	// dev-reply#24288.
	$dragblock_25 = get_avatar_url( $dragblock_22 );
	return esc_url_raw( $dragblock_25 );
}
add_shortcode( 'dragblock.post.cat.name', 'dragblock_shortcode_post_cat_name' );
/**
 * Check Documentation#24196
 *
 * @param object|array|string $dragblock_1 check var-def#24196.
 */
function dragblock_shortcode_post_cat_name( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	$dragblock_26 = get_the_category( $dragblock_2 );
	if ( ! empty( $dragblock_26 ) ) {
		foreach ( $dragblock_26 as $dragblock_27 ) {
			if ( 0 === $dragblock_27->category_parent ) {
				return $dragblock_27->name;
			}
		}
	}
	return ''; // dev-reply#24320.
}
add_shortcode( 'dragblock.post.cat.url', 'dragblock_shortcode_post_cat_url' );
/**
 * Check Documentation#24213
 *
 * @param object|array|string $dragblock_1 check var-def#24213.
 */
function dragblock_shortcode_post_cat_url( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	$dragblock_26 = get_the_category( $dragblock_2 );
	if ( ! empty( $dragblock_26 ) ) {
		foreach ( $dragblock_26 as $dragblock_27 ) {
			if ( 0 === $dragblock_27->category_parent ) {
				return esc_url_raw( get_category_link( $dragblock_27->term_id ) );
			}
		}
	}
	return '#empty_cat_id'; // dev-reply#24346.
}
add_shortcode( 'dragblock.post.cat.id', 'dragblock_shortcode_post_cat_id' );
/**
 * Check Documentation#24230
 *
 * @param object|array|string $dragblock_1 check var-def#24230.
 */
function dragblock_shortcode_post_cat_id( $dragblock_1 ) {
	$dragblock_2 = dragblock_get_current_list_query_id();
	if ( null === $dragblock_2 ) {
		return '';
	}
	$dragblock_26 = get_the_category( $dragblock_2 );
	if ( ! empty( $dragblock_26 ) ) {
		foreach ( $dragblock_26 as $dragblock_27 ) {
			if ( 0 === $dragblock_27->category_parent ) {
				return $dragblock_27->term_id;
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
 * @param object|array|string $dragblock_1 check var-def#24248.
 */
function dragblock_shortcode_share_url_twitter( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://twitter.com/intent/tweet?text=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.facebook', 'dragblock_shortcode_share_url_facebook' );
/**
 * Check Documentation#24256
 *
 * @param object|array|string $dragblock_1 check var-def#24256.
 */
function dragblock_shortcode_share_url_facebook( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.whatsapp', 'dragblock_shortcode_share_url_whatsapp' );
/**
 * Check Documentation#24264
 *
 * @param object|array|string $dragblock_1 check var-def#24264.
 */
function dragblock_shortcode_share_url_whatsapp( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://wa.me/?text=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.telegram', 'dragblock_shortcode_share_url_telegram' );
/**
 * Check Documentation#24272
 *
 * @param object|array|string $dragblock_1 check var-def#24272.
 */
function dragblock_shortcode_share_url_telegram( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://t.me/share/url?url=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.tumblr', 'dragblock_shortcode_share_url_tumblr' );
/**
 * Check Documentation#24280
 *
 * @param object|array|string $dragblock_1 check var-def#24280.
 */
function dragblock_shortcode_share_url_tumblr( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.reddit', 'dragblock_shortcode_share_url_reddit' );
/**
 * Check Documentation#24288
 *
 * @param object|array|string $dragblock_1 check var-def#24288.
 */
function dragblock_shortcode_share_url_reddit( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.reddit.com/submit?url=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.linkedin', 'dragblock_shortcode_share_url_linkedin' );
/**
 * Check Documentation#24296
 *
 * @param object|array|string $dragblock_1 check var-def#24296.
 */
function dragblock_shortcode_share_url_linkedin( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://www.linkedin.com/sharing/share-offsite/?url=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.gmail', 'dragblock_shortcode_share_url_gmail' );
/**
 * Check Documentation#24304
 *
 * @param object|array|string $dragblock_1 check var-def#24304.
 */
function dragblock_shortcode_share_url_gmail( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&body=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.email', 'dragblock_shortcode_share_url_email' );
/**
 * Check Documentation#24312
 *
 * @param object|array|string $dragblock_1 check var-def#24312.
 */
function dragblock_shortcode_share_url_email( $dragblock_1 ) {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return '';
	}
	return 'mailto:?body=' . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}
add_shortcode( 'dragblock.share.url.navigator', 'dragblock_shortcode_share_url_navigator' );
/**
 * Check Documentation#24320
 *
 * @param object|array|string $dragblock_1 check var-def#24320.
 */
function dragblock_shortcode_share_url_navigator( $dragblock_1 ) {
	return 'javascript:navigator.share?navigator.share({url:location.href}):null';
}
add_filter( 'kses_allowed_protocols', 'dragblock_kses_allowed_protocols', 1 );
/**
 * Check Documentation#24325
 *
 * @param object|array|string $dragblock_28 check var-def#24325.
 */
function dragblock_kses_allowed_protocols( $dragblock_28 ) {
	$dragblock_28[] = 'data';
	$dragblock_28[] = 'javascript';
	return $dragblock_28;
}
