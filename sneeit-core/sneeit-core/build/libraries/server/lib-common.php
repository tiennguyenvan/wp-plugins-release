<?php
/**
 * DragBlock's Libraries.
 *
 * @package Lib common
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check Documentation#192
 *
 * @param object|array|string $sneeit_core_lc_url check var-def#192.
 */
function sneeit_core_url_exists( $sneeit_core_lc_url ) {
	$sneeit_core_lc_headers = @get_headers( $sneeit_core_lc_url );
	if ( $sneeit_core_lc_headers && strpos( $sneeit_core_lc_headers[0], '200' ) !== false ) {
		return true; // dev-reply#195.
	} else {
		return false; // dev-reply#197.
	}
}
/**
 * Check Documentation#1910
 *
 * @param object|array|string $sneeit_core_lc_text check var-def#1910.
 */
function sneeit_core_text_to_slug( $sneeit_core_lc_text ) {
	$sneeit_core_lc_text = str_replace( array( ' ', '/' ), '-', $sneeit_core_lc_text );
	$sneeit_core_lc_text = strtolower( $sneeit_core_lc_text );
	return $sneeit_core_lc_text;
}
/**
 * Check Documentation#1916
 *
 * @param object|array|string $sneeit_core_lc_src check var-def#1916.
 */
function sneeit_core_is_image_src( $sneeit_core_lc_src ) {
	$sneeit_core_lc_src = strtolower( $sneeit_core_lc_src );
	return preg_match( "/\.(jpeg|jpg|gif|png)$/", $sneeit_core_lc_src );
}
/**
 * Check Documentation#1920
 *
 * @param object|array|string $sneeit_core_lc_menu check var-def#1920.
 * @param object|array|string $sneeit_core_lc_text check var-def#1920.
 * @param object|array|string $sneeit_core_lc_id check var-def#1920.
 * @param object|array|string $sneeit_core_lc_data check var-def#1920.
 */
function sneeit_core_create_menu( $sneeit_core_lc_menu, $sneeit_core_lc_text, $sneeit_core_lc_id, $sneeit_core_lc_data = 0 ) {
	static $sneeit_core_lc_parent = 1;
	$sneeit_core_lc_pos = array(
		'menu-item-title' => $sneeit_core_lc_text,
		'menu-item-status' => 'publish',
		'menu-item-type' => 'post_type',
		'menu-item-position' => $sneeit_core_lc_parent,
	);
	$sneeit_core_lc_slug = sneeit_core_text_to_slug( $sneeit_core_lc_text );
	$sneeit_core_lc_type = 'page';
	if ( ! empty( $sneeit_core_lc_id['url'] ) ) {
		$sneeit_core_lc_type = 'custom';
	} elseif ( ! empty( $sneeit_core_lc_id['cat'] ) ) {
		$sneeit_core_lc_type = 'taxonomy';
	}
	$sneeit_core_lc_page = get_page_by_path( $sneeit_core_lc_slug, OBJECT );
	if ( 'page' === $sneeit_core_lc_type ) {
		if ( isset( $sneeit_core_lc_page ) ) {
			$sneeit_core_lc_page = $sneeit_core_lc_page->ID;
		} else {
			$sneeit_core_lc_page = wp_insert_post( array(
				'post_type' => 'page',
				'post_name' => $sneeit_core_lc_slug,
				'guid' => $sneeit_core_lc_slug,
			) );
		}
		$sneeit_core_lc_pos['menu-item-object'] = 'page';
		$sneeit_core_lc_pos['menu-item-object-id'] = $sneeit_core_lc_page;
	} elseif ( 'custom' === $sneeit_core_lc_page ) {
		$sneeit_core_lc_pos['menu-item-type'] = 'custom';
		$sneeit_core_lc_pos['menu-item-url'] = $sneeit_core_lc_id['url'];
	} elseif ( 'taxonomy' === $sneeit_core_lc_page ) {
		$sneeit_core_lc_pos['menu-item-type'] = 'taxonomy';
		$sneeit_core_lc_pos['menu-item-object'] = 'category';
		$sneeit_core_lc_pos['menu-item-object-id'] = $sneeit_core_lc_id['cat'];
	}
	if ( $sneeit_core_lc_data ) {
		$sneeit_core_lc_pos['menu-item-parent-id'] = $sneeit_core_lc_data;
	}
	$sneeit_core_lc_db = wp_update_nav_menu_item( $sneeit_core_lc_menu, 0, $sneeit_core_lc_pos );
	if ( ! empty( $sneeit_core_lc_id['mega'] ) ) {
		update_post_meta( $sneeit_core_lc_db, 'enable_mega', true );
	}
	$sneeit_core_lc_parent++;
	return $sneeit_core_lc_db;
}
/**
 * Check Documentation#1967
 */
function sneeit_core_create_menu_on_submit() {
	$sneeit_core_lc_url = empty( $_POST['menu-items'] ) ? array() : $_POST['menu-items'];
	if ( 'default' === $sneeit_core_lc_url ) {
		$sneeit_core_lc_post = get_categories();
		shuffle( $sneeit_core_lc_post );
		$sneeit_core_lc_url = array(
			'HOME' => array(
				'icon' => 'fa-home',
			),
			'DEMOS' => array(
				'url' => '#',
				'mega' => true,
				'sub' => array(
					'Business' => array(
						'url' => '#',
						'sub' => array(
							'Business 1' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Business 2' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Business 3' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Business 4' => array(
								'url' => '#',
								'target' => '_blank'
							),
						)
					),
					'Magazine' => array(
						'url' => '#',
						'sub' => array(
							'Magazine 1' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Magazine 2' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Magazine 3' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Magazine 4' => array(
								'url' => '#',
								'target' => '_blank'
							),
						)
					),
					'Blog' => array(
						'url' => '#',
						'sub' => array(
							'Blog 1' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Blog 2' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Blog 3' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Blog 4' => array(
								'url' => '#',
								'target' => '_blank'
							),
						)
					),
					'Shop' => array(
						'url' => '#',
						'sub' => array(
							'Shop 1' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Shop 2' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Shop 3' => array(
								'url' => '#',
								'target' => '_blank'
							),
							'Shop 4' => array(
								'url' => '#',
								'target' => '_blank'
							),
						)
					),
				)
			),
			'DROP DOWN' => array(
				'url' => '#',
				'sub' => array(
					'Sub Menu Level 01' => array(
						'url' => '#'
					),
					'Sub Menu Level 02' => array(
						'url' => '#',
						'sub' => array(
							'Sub Menu Level 2.1' => array(
								'url' => '#'
							),
							'Sub Menu Level 2.2' => array(
								'url' => '#'
							),
							'Sub Menu Level 2.3' => array(
								'url' => '#'
							),
						)
					),
					'Sub Menu Level 03' => array(
						'url' => '#'
					),
				),
			),
			'MEGA CATE' => array(
				'cat' => array_slice( $sneeit_core_lc_post, 0, 1 ),
			),
		);
	} else {
		$sneeit_core_lc_url = json_decode( trim( wp_unslash( $sneeit_core_lc_url ) ), true );
	}
	$sneeit_core_lc_categories = 'Main Menu';
	$sneeit_core_lc_name = wp_get_nav_menu_object( $sneeit_core_lc_categories );
	if ( ! $sneeit_core_lc_name ) {
		$sneeit_core_lc_menu = wp_create_nav_menu( $sneeit_core_lc_categories );
		$sneeit_core_lc_exists = get_term_by( 'name', $sneeit_core_lc_categories, 'nav_menu' );
	}
	foreach ( $sneeit_core_lc_url as $sneeit_core_lc_new => $sneeit_core_lc_lv ) {
		$sneeit_core_lc_1 = sneeit_core_create_menu( $sneeit_core_lc_exists->term_id, $sneeit_core_lc_new, $sneeit_core_lc_lv );
		if ( empty( $sneeit_core_lc_lv['sub'] ) ) {
			continue;
		}
		foreach ( $sneeit_core_lc_lv['sub'] as $sneeit_core_lc_2 => $sneeit_core_lc_3 ) {
			$sneeit_core_lc_urlregex = sneeit_core_create_menu( $sneeit_core_lc_exists->term_id, $sneeit_core_lc_2, $sneeit_core_lc_3, $sneeit_core_lc_1 );
			if ( empty( $sneeit_core_lc_3['sub'] ) ) {
				continue;
			}
			foreach ( $sneeit_core_lc_3['sub'] as $sneeit_core_lc_matches => $sneeit_core_lc_headers_url ) {
				sneeit_core_create_menu( $sneeit_core_lc_exists->term_id, $sneeit_core_lc_matches, $sneeit_core_lc_headers_url, $sneeit_core_lc_urlregex );
			}
		}
	}
}
/**
 * Check Documentation#19221
 *
 * @param object|array|string $sneeit_core_lc_text check var-def#19221.
 */
function sneeit_core_extract_urls( $sneeit_core_lc_text ) {
	$sneeit_core_lc_headers_headers = '/\b(?:https?:\/\/|www\.)[^,\s]+/i';
	preg_match_all( $sneeit_core_lc_headers_headers, $sneeit_core_lc_text, $sneeit_core_lc_headers_text );
	return $sneeit_core_lc_headers_text[0];
}
