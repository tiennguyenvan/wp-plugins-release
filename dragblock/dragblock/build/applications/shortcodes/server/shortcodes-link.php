<?php
/**
 * DragBlock's Shortcodes.
 *
 * @package Shortcodes link
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_shortcode( 'dragblock.home.url', 'dragblock_shortcode_home_url' );
/**
 * Check Documentation#83
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#83.
 */
function dragblock_shortcode_home_url( $dragblock_sl_attrs = array() ) {
	return get_home_url();
}
// dev-reply#815.
add_shortcode( 'dragblock.blog.url', 'dragblock_shortcode_blog_url' );
/**
 * Check Documentation#89
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#89.
 */
function dragblock_shortcode_blog_url( $dragblock_sl_attrs = array() ) {
	$dragblock_sl_link = add_query_arg( array(
		's' => '',
		'post_type' => 'post',
	), get_home_url() );
	// dev-reply#824.
	$dragblock_sl_blog = get_option( 'page_for_posts' );
	// dev-reply#827.
	if ( $dragblock_sl_blog ) {
		// dev-reply#829.
		$dragblock_sl_page = get_permalink( $dragblock_sl_blog );
		$dragblock_sl_link = $dragblock_sl_page;
	}
	return $dragblock_sl_link;
}
// dev-reply#840.
add_shortcode( 'dragblock.login.url', 'dragblock_shortcode_login_url' );
/**
 * Check Documentation#827
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#827.
 */
function dragblock_shortcode_login_url( $dragblock_sl_attrs = array() ) {
	return wp_login_url();
}
/**
 * Check Documentation#830
 */
function dragblock_current_url() {
	global $wp;
	return home_url( add_query_arg( $_GET, $wp->request ) );
}
// dev-reply#853.
add_shortcode( 'dragblock.share.url.twitter', 'dragblock_shortcode_share_url_twitter' );
/**
 * Check Documentation#837
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#837.
 */
function dragblock_shortcode_share_url_twitter( $dragblock_sl_attrs = array() ) {
	return 'https://twitter.com/intent/tweet?text=' . dragblock_current_url();
}
// dev-reply#860.
add_shortcode( 'dragblock.share.url.facebook', 'dragblock_shortcode_share_url_facebook' );
/**
 * Check Documentation#843
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#843.
 */
function dragblock_shortcode_share_url_facebook( $dragblock_sl_attrs = array() ) {
	return 'https://www.facebook.com/sharer/sharer.php?u=' . dragblock_current_url();
}
// dev-reply#867.
add_shortcode( 'dragblock.share.url.whatsapp', 'dragblock_shortcode_share_url_whatsapp' );
/**
 * Check Documentation#849
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#849.
 */
function dragblock_shortcode_share_url_whatsapp( $dragblock_sl_attrs = array() ) {
	return 'https://wa.me/?text=' . dragblock_current_url();
}
// dev-reply#874.
add_shortcode( 'dragblock.share.url.telegram', 'dragblock_shortcode_share_url_telegram' );
/**
 * Check Documentation#855
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#855.
 */
function dragblock_shortcode_share_url_telegram( $dragblock_sl_attrs = array() ) {
	return 'https://t.me/share/url?url=' . dragblock_current_url();
}
// dev-reply#881.
add_shortcode( 'dragblock.share.url.tumblr', 'dragblock_shortcode_share_url_tumblr' );
/**
 * Check Documentation#861
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#861.
 */
function dragblock_shortcode_share_url_tumblr( $dragblock_sl_attrs = array() ) {
	return 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . dragblock_current_url();
}
// dev-reply#888.
add_shortcode( 'dragblock.share.url.reddit', 'dragblock_shortcode_share_url_reddit' );
/**
 * Check Documentation#867
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#867.
 */
function dragblock_shortcode_share_url_reddit( $dragblock_sl_attrs = array() ) {
	return 'https://www.reddit.com/submit?url=' . dragblock_current_url();
}
// dev-reply#895.
add_shortcode( 'dragblock.share.url.linkedin', 'dragblock_shortcode_share_url_linkedin' );
/**
 * Check Documentation#873
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#873.
 */
function dragblock_shortcode_share_url_linkedin( $dragblock_sl_attrs = array() ) {
	return 'https://www.linkedin.com/sharing/share-offsite/?url=' . dragblock_current_url();
}
// dev-reply#8102.
add_shortcode( 'dragblock.share.url.gmail', 'dragblock_shortcode_share_url_gmail' );
/**
 * Check Documentation#879
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#879.
 */
function dragblock_shortcode_share_url_gmail( $dragblock_sl_attrs = array() ) {
	return 'https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&body=' . dragblock_current_url();
}
// dev-reply#8109.
add_shortcode( 'dragblock.share.url.email', 'dragblock_shortcode_share_url_email' );
/**
 * Check Documentation#885
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#885.
 */
function dragblock_shortcode_share_url_email( $dragblock_sl_attrs = array() ) {
	return 'mailto:?body=' . dragblock_current_url();
}
// dev-reply#8116.
add_shortcode( 'dragblock.share.url.navigator', 'dragblock_shortcode_share_url_navigator' );
/**
 * Check Documentation#891
 *
 * @param object|array|string $dragblock_sl_attrs check var-def#891.
 */
function dragblock_shortcode_share_url_navigator( $dragblock_sl_attrs = array() ) {
	return 'javascript:navigator.share?navigator.share({url:location.href}):null';
}
