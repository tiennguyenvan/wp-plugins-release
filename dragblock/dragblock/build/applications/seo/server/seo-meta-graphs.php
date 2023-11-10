<?php
/**
 * DragBlock's Seo.
 *
 * @package Seo meta graphs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'wp_head', 'dragblock_meta_graphs', 1 );
/**
 * Check Documentation#243
 */
function dragblock_meta_graphs() {
	// dev-reply#247.
	if ( defined( 'WPSEO_FILE' ) ) {
		return;
	}
	$dragblock_smg_site = get_bloginfo( 'url' );
	$dragblock_smg_url = get_bloginfo( 'name' );
	$dragblock_smg_name = get_bloginfo( 'description' );
	$dragblock_smg_desc = str_replace( '_', '-', get_locale() );
	$dragblock_smg_locale = array();
	$dragblock_smg_graphs = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
	$dragblock_smg_logo = is_multisite() ? network_home_url() : null;
	// dev-reply#2428.
	$dragblock_smg_network = null;
	$dragblock_smg_root = $dragblock_smg_site;
	$dragblock_smg_archive = $dragblock_smg_url;
	$dragblock_smg_id = $dragblock_smg_name;
	$dragblock_smg_img = null;
	$dragblock_smg_obj = is_archive() ? get_queried_object() : null;
	if ( $dragblock_smg_obj ) {
		$dragblock_smg_network = ! empty( $dragblock_smg_obj->term_id ) ? $dragblock_smg_obj->term_id : ( ! empty( $dragblock_smg_obj->ID ) ? $dragblock_smg_obj->ID : null );
		$dragblock_smg_root = is_author() ? get_author_posts_url( $dragblock_smg_network ) : get_term_link( $dragblock_smg_network );
		$dragblock_smg_archive = ! empty( $dragblock_smg_obj->name ) ? $dragblock_smg_obj->name : ( ! empty( $dragblock_smg_obj->display_name ) ? $dragblock_smg_obj->display_name : '' );
		$dragblock_smg_id = is_author() ? get_the_author_meta( 'description', $dragblock_smg_network ) : $dragblock_smg_obj->description;
		// dev-reply#2442.
		$dragblock_smg_posts = get_posts( array( 'numberposts' => 1 ) );
		if ( $dragblock_smg_posts ) {
			$dragblock_smg_first = $dragblock_smg_posts[0];
			$dragblock_smg_post = get_post_thumbnail_id( $dragblock_smg_first->ID );
			if ( $dragblock_smg_post ) {
				// dev-reply#2449.
				$dragblock_smg_featured = wp_get_attachment_image_src( $dragblock_smg_post, 'full' );
				if ( $dragblock_smg_featured ) {
					$dragblock_smg_img = array(
						'src' => $dragblock_smg_featured[0], // dev-reply#2454.
						'width' => $dragblock_smg_featured[1], // dev-reply#2455.
						'height' => $dragblock_smg_featured[2], // dev-reply#2456.,
					);
				}
			}
		}
	}
	$dragblock_smg_image = is_singular() ? get_post()->ID : 0;
	if ( $dragblock_smg_image ) {
		$dragblock_smg_properties = get_the_title();
		$dragblock_smg_title = get_the_excerpt();
		$dragblock_smg_src = get_the_permalink();
		$dragblock_smg_width = null;
		// dev-reply#2473.
		$dragblock_smg_post = get_post_thumbnail_id();
		if ( $dragblock_smg_post ) {
			$dragblock_smg_height = wp_get_attachment_image_src( $dragblock_smg_post, 'full' );
			$dragblock_smg_width = $dragblock_smg_height[0];
			$dragblock_smg_type = $dragblock_smg_height[1];
			$dragblock_smg_categories = $dragblock_smg_height[2];
			$dragblock_smg_a = pathinfo( $dragblock_smg_width );
			$dragblock_smg_a = isset( $dragblock_smg_a['extension'] ) ? $dragblock_smg_a['extension'] : '';
		}
		// dev-reply#2485.
		$dragblock_smg_b = get_the_category();
		if ( $dragblock_smg_b ) {
			/**
			 * Check Documentation#2465
			 *
			 * @param object|array|string $dragblock_smg_cats check var-def#2465.
			 * @param object|array|string $dragblock_smg_category check var-def#2465.
			 */
			function custom_category_sort( $dragblock_smg_cats, $dragblock_smg_category ) {
				// dev-reply#2490.
				if ( $dragblock_smg_cats->category_parent === $dragblock_smg_category->cat_ID ) {
					return 1; // dev-reply#2492.
				} elseif ( $dragblock_smg_category->category_parent === $dragblock_smg_cats->cat_ID ) {
					return - 1; // dev-reply#2494.
				}
				if ( $dragblock_smg_cats->count === $dragblock_smg_category->count ) {
					return 0; // dev-reply#2499.
				}
				return ( $dragblock_smg_cats->count > $dragblock_smg_category->count ) ? - 1 : 1; // dev-reply#24102.
			}
			usort( $dragblock_smg_b, 'custom_category_sort' );
			// dev-reply#24105.
			/**
			 * Check Documentation#2480
			 *
			 * @param object|array|string $dragblock_smg_cat check var-def#2480.
			 */
			$dragblock_smg_data = array_map( function( $dragblock_smg_cat ) {
				$dragblock_smg_names = array(
					'name' => $dragblock_smg_cat->name,
					'url' => get_term_link( $dragblock_smg_cat ) // dev-reply#24109.,
				);
				return $dragblock_smg_names;
			}, $dragblock_smg_b );
			/**
			 * Check Documentation#2487
			 *
			 * @param object|array|string $dragblock_smg_cat check var-def#2487.
			 */
			$dragblock_smg_published = array_map( function( $dragblock_smg_cat ) {
				return $dragblock_smg_cat->name;
			}, $dragblock_smg_b );
		}
		$dragblock_smg_modified = get_the_date( 'c' ); // dev-reply#24118.
		$dragblock_smg_author = get_the_modified_date( 'c' ); // dev-reply#24119.
		$dragblock_smg_avatar = get_the_author_meta( 'ID' );
		$dragblock_smg_content = get_the_author_meta( 'display_name', $dragblock_smg_avatar );
		$dragblock_smg_read = get_avatar_url( $dragblock_smg_avatar );
		$dragblock_smg_est = get_author_posts_url( $dragblock_smg_avatar );
		$dragblock_smg_meta = get_the_content();
		$dragblock_smg_tag = ceil( str_word_count( $dragblock_smg_meta ) / 200 ); // dev-reply#24129.
	}
	$dragblock_smg_class = "class='dragblock-seo-meta-tag'";
	$dragblock_smg_eol = DRAGBLOCK_IS_LOCAL ? "\n" : '';
	$dragblock_smg_label1 = esc_attr( $dragblock_smg_image ? $dragblock_smg_src : ( is_archive() ? $dragblock_smg_root : $dragblock_smg_site ) );
	$dragblock_smg_label2 = ( is_singular() || is_archive() ) ? 'article' : 'wesbite';
	$dragblock_smg_data2 = $dragblock_smg_image ? $dragblock_smg_properties : ( is_archive() ? $dragblock_smg_archive : '' );
	if ( is_archive() ) {
		/* translators: see trans-note#24106 */
		$dragblock_smg_data2 = sprintf( esc_html__( '%s Archives', 'dragblock' ), $dragblock_smg_data2 );
	}
	$dragblock_smg_data2 = esc_attr( $dragblock_smg_data2 ? $dragblock_smg_data2 . ' - ' . $dragblock_smg_url : $dragblock_smg_url );
	$dragblock_smg_label = esc_attr( $dragblock_smg_image ? $dragblock_smg_title : ( is_archive() ? $dragblock_smg_id : $dragblock_smg_name ) );
	echo "<meta name='description' content='$dragblock_smg_label' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<link rel='canonical' href='$dragblock_smg_label1' $dragblock_smg_class />$dragblock_smg_eol";
	if ( is_front_page() ) {
		echo "<link rel='next' href='$dragblock_smg_site/page/2/' $dragblock_smg_class />$dragblock_smg_eol";
	}
	echo "<meta property='og:locale' content='$dragblock_smg_desc' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<meta property='og:type' content='$dragblock_smg_label2' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<meta property='og:title' content='$dragblock_smg_data2' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<meta property='og:description' content='$dragblock_smg_label' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<meta property='og:url' content='$dragblock_smg_label1' $dragblock_smg_class />$dragblock_smg_eol";
	echo "<meta property='og:site_name' content='$dragblock_smg_url' $dragblock_smg_class />$dragblock_smg_eol";
	if ( is_single() ) {
		$dragblock_smg_article = esc_attr( esc_html__( 'Written by', 'dragblock' ) );
		$dragblock_smg_json = esc_attr( esc_html__( 'Est. reading time', 'dragblock' ) );
		$dragblock_smg_webpage = esc_attr( esc_html__( '%s minutes', 'dragblock' ) );
		/* translators: see trans-note#24125 */
		$dragblock_smg_collection = sprintf( $dragblock_smg_webpage, $dragblock_smg_tag );
		echo "<meta property='article:published_time' content='$dragblock_smg_modified' $dragblock_smg_class />$dragblock_smg_eol";
		echo "<meta property='article:modified_time' content='$dragblock_smg_author' $dragblock_smg_class />$dragblock_smg_eol";
		if ( $dragblock_smg_width ) {
			echo "<meta property='og:image' content='$dragblock_smg_width' $dragblock_smg_class />$dragblock_smg_eol";
			echo "<meta property='og:image:width' content='$dragblock_smg_type' $dragblock_smg_class />$dragblock_smg_eol";
			echo "<meta property='og:image:height' content='$dragblock_smg_categories' $dragblock_smg_class />$dragblock_smg_eol";
			echo "<meta property='og:image:type' content='image/$dragblock_smg_a' $dragblock_smg_class />$dragblock_smg_eol";
		}
		echo "<meta name='author' content='$dragblock_smg_content' $dragblock_smg_class />$dragblock_smg_eol";
		echo "<meta name='twitter:label1' content='$dragblock_smg_article' $dragblock_smg_class />$dragblock_smg_eol";
		echo "<meta name='twitter:data1' content='$dragblock_smg_content' $dragblock_smg_class />$dragblock_smg_eol";
		echo "<meta name='twitter:label2' content='$dragblock_smg_json' $dragblock_smg_class />$dragblock_smg_eol";
		echo "<meta name='twitter:data2' content='$dragblock_smg_collection' $dragblock_smg_class />$dragblock_smg_eol";
	}
	echo "<meta name='twitter:card' content='summary_large_image' $dragblock_smg_class />$dragblock_smg_eol";
	if ( $dragblock_smg_image && is_single() ) {
		$dragblock_smg_breadcrumb = array(
			'@type' => 'Article',
			'@id' => $dragblock_smg_src . '#article',
			'isPartOf' => array(
				'@id' => $dragblock_smg_src
			),
			'author' => array(
				'name' => $dragblock_smg_content,
				'@id' => $dragblock_smg_site . '#/schema/person/5ff68e1c543d9cbf59b74e84c74a1350'
			),
			'headline' => $dragblock_smg_properties,
			'description' => $dragblock_smg_title,
			'datePublished' => $dragblock_smg_modified,
			'dateModified' => $dragblock_smg_author,
			'mainEntityOfPage' => array(
				'@id' => $dragblock_smg_src
			),
			'wordCount' => 522,
			'commentCount' => 0,
			'publisher' => array(
				'@id' => $dragblock_smg_site . '#organization'
			),
			'inLanguage' => 'en-US',
			'potentialAction' => array(
				array(
					'@type' => 'CommentAction',
					'name' => 'Comment',
					'target' => array(
						$dragblock_smg_src . '#respond'
					)
				)
			),
		);
		if ( ! empty( $dragblock_smg_width ) ) {
			$dragblock_smg_breadcrumb['image'] = array(
				'@id' => $dragblock_smg_src . '#primaryimage',
			);
			$dragblock_smg_breadcrumb['thumbnailUrl'] = array(
				'@id' => $dragblock_smg_width,
			);
			$dragblock_smg_breadcrumb['articleSection'] = array(
				'@id' => $dragblock_smg_width,
			);
		}
		if ( ! empty( $dragblock_smg_data ) ) {
			$dragblock_smg_breadcrumb['articleSection'] = $dragblock_smg_published;
		}
		array_push( $dragblock_smg_locale, $dragblock_smg_breadcrumb );
	}
	if ( $dragblock_smg_image ) {
		$dragblock_smg_list = array(
			'@type' => 'WebPage',
			'@id' => $dragblock_smg_src,
			'url' => $dragblock_smg_src,
			'name' => $dragblock_smg_properties . ' - ' . $dragblock_smg_url,
			'description' => $dragblock_smg_title,
			'isPartOf' => array(
				'@id' => $dragblock_smg_site . '#website'
			),
			'datePublished' => $dragblock_smg_modified,
			'dateModified' => $dragblock_smg_author,
			'breadcrumb' => array(
				'@id' => $dragblock_smg_src . '#breadcrumb'
			),
			'inLanguage' => 'en-US',
			'potentialAction' => array(
				array(
					'@type' => 'ReadAction',
					'target' => array(
						$dragblock_smg_src
					),
				),
			),
		);
		if ( ! empty( $dragblock_smg_width ) ) {
			$dragblock_smg_list['primaryImageOfPage'] = array(
				'@id' => $dragblock_smg_src . '#primaryimage',
			);
			$dragblock_smg_list['image'] = array(
				'@id' => $dragblock_smg_src . '#primaryimage',
			);
			$dragblock_smg_list['thumbnailUrl'] = $dragblock_smg_width;
		}
		array_push( $dragblock_smg_locale, $dragblock_smg_list );
	}
	if ( is_front_page() || is_archive() ) {
		$dragblock_smg_website = array(
			'@type' => 'CollectionPage',
			'@id' => $dragblock_smg_root,
			'url' => $dragblock_smg_root,
			'name' => $dragblock_smg_archive,
			'isPartOf' => array(
				'@id' => $dragblock_smg_site . '#website',
			),
			'about' => array(
				'@id' => $dragblock_smg_site . '#organization',
			),
			'description' => $dragblock_smg_id,
			'breadcrumb' => array(
				'@id' => $dragblock_smg_root . '#breadcrumb',
			),
			'inLanguage' => $dragblock_smg_desc,
		);
		if ( ! is_front_page() ) {
			unset( $dragblock_smg_website['about'] );
		}
		if ( $dragblock_smg_img ) {
			$dragblock_smg_website['primaryImageOfPage'] = array(
				'@id' => $dragblock_smg_root . '#primaryimage',
			);
			$dragblock_smg_website['image'] = array(
				'@id' => $dragblock_smg_root . '#primaryimage',
			);
			$dragblock_smg_website['thumbnailUrl'] = $dragblock_smg_img['src'];
		}
		array_push( $dragblock_smg_locale, $dragblock_smg_website );
	}
	if ( $dragblock_smg_image && ! empty( $dragblock_smg_width ) || $dragblock_smg_img ) {
		$dragblock_smg_organize = array(
			'@type' => 'ImageObject',
			'inLanguage' => 'en-US',
			'@id' => ( $dragblock_smg_img ? $dragblock_smg_root : $dragblock_smg_src ) . '#primaryimage',
			'url' => $dragblock_smg_img ? $dragblock_smg_img['src'] : $dragblock_smg_width,
			'contentUrl' => $dragblock_smg_img ? $dragblock_smg_img['src'] : $dragblock_smg_width,
			'width' => $dragblock_smg_img ? $dragblock_smg_img['width'] : $dragblock_smg_type,
			'height' => $dragblock_smg_img ? $dragblock_smg_img['height'] : $dragblock_smg_categories,
		);
		array_push( $dragblock_smg_locale, $dragblock_smg_organize );
	}
	$dragblock_smg_person = array(
		array(
			'@type' => 'ListItem',
			'position' => 1,
			'name' => esc_html__( 'Home' ),
			'item' => is_front_page() ? '' : $dragblock_smg_site,
		),
	);
	if ( $dragblock_smg_image ) {
		if ( ! empty( $dragblock_smg_data ) ) {
			foreach ( $dragblock_smg_data as $dragblock_smg_url_site ) {
				array_push( $dragblock_smg_person, array(
					'@type' => 'ListItem',
					'position' => count( $dragblock_smg_person ) + 1,
					'name' => $dragblock_smg_url_site['name'],
					'item' => $dragblock_smg_url_site['url'],
				) );
			}
		}
		array_push( $dragblock_smg_person, array(
			'@type' => 'ListItem',
			'position' => count( $dragblock_smg_person ) + 1,
			'name' => $dragblock_smg_properties,
			// dev-reply#24391.,
		) );
	}
	if ( $dragblock_smg_network ) {
		array_push( $dragblock_smg_person, array(
			'@type' => 'ListItem',
			'position' => count( $dragblock_smg_person ) + 1,
			'name' => $dragblock_smg_archive,
			// dev-reply#24399.,
		) );
	}
	$dragblock_smg_url_url = array(
		'@type' => 'BreadcrumbList',
		'@id' => ( $dragblock_smg_image ? $dragblock_smg_src : $dragblock_smg_root ) . '#breadcrumb',
		'itemListElement' => $dragblock_smg_person,
	);
	array_push( $dragblock_smg_locale, $dragblock_smg_url_url );
	$dragblock_smg_url_name = array(
		'@type' => 'Website',
		'@id' =>    $dragblock_smg_site . '#website',
		'url' => $dragblock_smg_site,
		'name' => $dragblock_smg_url,
		'description' => $dragblock_smg_name,
		'publisher' => array(
			'@id' => $dragblock_smg_site . '#organization',
		),
		'potentialAction' => array(
			0 => array(
				'@type' =>  'SearchAction',
				'target' =>  array(
					'@type' =>  'EntryPoint',
					'urlTemplate' =>  $dragblock_smg_site . '?s={search_term_string}',
				),
				'query-input' =>  'required name=search_term_string',
			),
		),
		'inLanguage' =>  $dragblock_smg_desc,
	);
	array_push( $dragblock_smg_locale, $dragblock_smg_url_name );
	if ( $dragblock_smg_graphs && count( $dragblock_smg_graphs ) > 3 ) {
		$dragblock_smg_url_desc = $dragblock_smg_graphs[0];
		$dragblock_smg_url_locale = $dragblock_smg_graphs[1];
		$dragblock_smg_url_graphs = $dragblock_smg_graphs[2];
		$dragblock_smg_url_logo = array(
			'@type' => 'Organization',
			'@id' => $dragblock_smg_site . '#organization',
			'name' => $dragblock_smg_url,
			'url' => $dragblock_smg_site,
			'logo' => array(
				'@type' => 'ImageObject',
				'@id' => $dragblock_smg_site . '#/schema/logo/image/',
				'url' => $dragblock_smg_url_desc,
				'contentUrl' => $dragblock_smg_url_desc,
				'width' => $dragblock_smg_url_locale,
				'height' => $dragblock_smg_url_graphs,
				'caption' => $dragblock_smg_url,
				'inLanguage' => $dragblock_smg_desc,
			),
			'image' => array(
				'@id' => $dragblock_smg_site . '#/schema/logo/image/',
			),
		);
		array_push( $dragblock_smg_locale, $dragblock_smg_url_logo );
	}
	if ( $dragblock_smg_image && is_single() ) {
		$dragblock_smg_url_network = array(
			'@type' => 'Person',
			'@id' => $dragblock_smg_site . '#/schema/person/5ff68e1c543d9cbf59b74e84c74a1350',
			'name' => $dragblock_smg_content,
			'image' => array(
				'@type' => 'ImageObject',
				'inLanguage' => 'en-US',
				'@id' => $dragblock_smg_site . '#/schema/person/image/',
				'url' => $dragblock_smg_read,
				'contentUrl' => $dragblock_smg_read,
				'caption' => $dragblock_smg_content
			),
			'url' => $dragblock_smg_est,
		);
		if ( $dragblock_smg_logo ) {
			$dragblock_smg_url_network['sameAs'] = array(
				$dragblock_smg_logo,
			);
		}
		array_push( $dragblock_smg_locale, $dragblock_smg_url_network );
	}
	if ( DRAGBLOCK_IS_LOCAL ) {
		$dragblock_smg_locale = json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph' => $dragblock_smg_locale,
			),
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
		);
	} else {
		$dragblock_smg_locale = json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph' => $dragblock_smg_locale,
			),
			JSON_UNESCAPED_SLASHES
		);
	}
	echo "<script type='application/ld+json' class='dragblock-seo-graph'>$dragblock_smg_locale</script>";
}
