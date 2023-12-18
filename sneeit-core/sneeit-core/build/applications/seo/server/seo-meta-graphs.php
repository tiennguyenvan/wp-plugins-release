<?php
/**
 * DragBlock's Seo.
 *
 * @package Seo meta graphs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'wp_head', 'sneeit_core_meta_graphs', 1 );
/**
 * Check Documentation#243
 */
function sneeit_core_meta_graphs() {
	// dev-reply#245.
	if ( defined( 'WPSEO_FILE' ) ) {
		return;
	}
	$sneeit_core_smg_site = get_bloginfo( 'url' );
	$sneeit_core_smg_url = get_bloginfo( 'name' );
	$sneeit_core_smg_name = get_bloginfo( 'description' );
	$sneeit_core_smg_desc = str_replace( '_', '-', get_locale() );
	$sneeit_core_smg_locale = array();
	$sneeit_core_smg_graphs = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
	$sneeit_core_smg_logo = is_multisite() ? network_home_url() : null;
	// dev-reply#2426.
	$sneeit_core_smg_network = null;
	$sneeit_core_smg_root = $sneeit_core_smg_site;
	$sneeit_core_smg_archive = $sneeit_core_smg_url;
	$sneeit_core_smg_id = $sneeit_core_smg_name;
	$sneeit_core_smg_img = null;
	$sneeit_core_smg_obj = is_archive() ? get_queried_object() : null;
	if ( $sneeit_core_smg_obj ) {
		$sneeit_core_smg_network = ! empty( $sneeit_core_smg_obj->term_id ) ? $sneeit_core_smg_obj->term_id : ( ! empty( $sneeit_core_smg_obj->ID ) ? $sneeit_core_smg_obj->ID : null );
	}
	if ( $sneeit_core_smg_network ) {
		$sneeit_core_smg_root = is_author() ? get_author_posts_url( $sneeit_core_smg_network ) : get_term_link( $sneeit_core_smg_network );
		$sneeit_core_smg_archive = ! empty( $sneeit_core_smg_obj->name ) ? $sneeit_core_smg_obj->name : ( ! empty( $sneeit_core_smg_obj->display_name ) ? $sneeit_core_smg_obj->display_name : '' );
		$sneeit_core_smg_id = is_author() ? get_the_author_meta( 'description', $sneeit_core_smg_network ) : $sneeit_core_smg_obj->description;
		// dev-reply#2442.
		$sneeit_core_smg_posts = get_posts( array( 'numberposts' => 1 ) );
		if ( $sneeit_core_smg_posts ) {
			$sneeit_core_smg_first = $sneeit_core_smg_posts[0];
			$sneeit_core_smg_post = get_post_thumbnail_id( $sneeit_core_smg_first->ID );
			if ( $sneeit_core_smg_post ) {
				// dev-reply#2449.
				$sneeit_core_smg_featured = wp_get_attachment_image_src( $sneeit_core_smg_post, 'full' );
				if ( $sneeit_core_smg_featured ) {
					$sneeit_core_smg_img = array(
						'src' => $sneeit_core_smg_featured[0], // dev-reply#2454.
						'width' => $sneeit_core_smg_featured[1], // dev-reply#2455.
						'height' => $sneeit_core_smg_featured[2], // dev-reply#2456.,
					);
				}
			}
		}
	}
	$sneeit_core_smg_image = is_singular() ? get_post()->ID : 0;
	if ( $sneeit_core_smg_image ) {
		$sneeit_core_smg_properties = get_the_title();
		$sneeit_core_smg_title = get_the_excerpt();
		$sneeit_core_smg_src = get_the_permalink();
		$sneeit_core_smg_width = null;
		// dev-reply#2475.
		$sneeit_core_smg_post = get_post_thumbnail_id();
		if ( $sneeit_core_smg_post ) {
			$sneeit_core_smg_height = wp_get_attachment_image_src( $sneeit_core_smg_post, 'full' );
			$sneeit_core_smg_width = $sneeit_core_smg_height[0];
			$sneeit_core_smg_type = $sneeit_core_smg_height[1];
			$sneeit_core_smg_categories = $sneeit_core_smg_height[2];
			$sneeit_core_smg_a = pathinfo( $sneeit_core_smg_width );
			$sneeit_core_smg_a = isset( $sneeit_core_smg_a['extension'] ) ? $sneeit_core_smg_a['extension'] : '';
		}
		// dev-reply#2487.
		$sneeit_core_smg_b = get_the_category();
		if ( $sneeit_core_smg_b ) {
			/**
			 * Check Documentation#2467
			 *
			 * @param object|array|string $sneeit_core_smg_cats check var-def#2467.
			 * @param object|array|string $sneeit_core_smg_category check var-def#2467.
			 */
			function custom_category_sort( $sneeit_core_smg_cats, $sneeit_core_smg_category ) {
				// dev-reply#2492.
				if ( $sneeit_core_smg_cats->category_parent === $sneeit_core_smg_category->cat_ID ) {
					return 1; // dev-reply#2494.
				} elseif ( $sneeit_core_smg_category->category_parent === $sneeit_core_smg_cats->cat_ID ) {
					return - 1; // dev-reply#2496.
				}
				if ( $sneeit_core_smg_cats->count === $sneeit_core_smg_category->count ) {
					return 0; // dev-reply#24101.
				}
				return ( $sneeit_core_smg_cats->count > $sneeit_core_smg_category->count ) ? - 1 : 1; // dev-reply#24104.
			}
			usort( $sneeit_core_smg_b, 'custom_category_sort' );
			// dev-reply#24107.
			/**
			 * Check Documentation#2482
			 *
			 * @param object|array|string $sneeit_core_smg_cat check var-def#2482.
			 */
			$sneeit_core_smg_data = array_map( function( $sneeit_core_smg_cat ) {
				$sneeit_core_smg_names = array(
					'name' => $sneeit_core_smg_cat->name,
					'url' => get_term_link( $sneeit_core_smg_cat ) // dev-reply#24111.,
				);
				return $sneeit_core_smg_names;
			}, $sneeit_core_smg_b );
			/**
			 * Check Documentation#2489
			 *
			 * @param object|array|string $sneeit_core_smg_cat check var-def#2489.
			 */
			$sneeit_core_smg_published = array_map( function( $sneeit_core_smg_cat ) {
				return $sneeit_core_smg_cat->name;
			}, $sneeit_core_smg_b );
		}
		$sneeit_core_smg_modified = get_the_date( 'c' ); // dev-reply#24120.
		$sneeit_core_smg_author = get_the_modified_date( 'c' ); // dev-reply#24121.
		$sneeit_core_smg_avatar = get_the_author_meta( 'ID' );
		$sneeit_core_smg_content = get_the_author_meta( 'display_name', $sneeit_core_smg_avatar );
		$sneeit_core_smg_read = get_avatar_url( $sneeit_core_smg_avatar );
		$sneeit_core_smg_est = get_author_posts_url( $sneeit_core_smg_avatar );
		$sneeit_core_smg_meta = get_the_content();
		$sneeit_core_smg_tag = ceil( str_word_count( $sneeit_core_smg_meta ) / 200 ); // dev-reply#24131.
	}
	do_action( 'sneeit_core_seo_meta_graphs' );
	$sneeit_core_smg_class = "class='sneeit_core-seo-meta-tag'";
	$sneeit_core_smg_eol = SNEEIT_CORE_IS_LOCAL ? "\n" : '';
	$sneeit_core_smg_label1 = esc_attr( $sneeit_core_smg_image ? $sneeit_core_smg_src : ( is_archive() ? $sneeit_core_smg_root: $sneeit_core_smg_site ) );
	$sneeit_core_smg_label2 = ( is_singular() || is_archive() ) ? 'article' : 'wesbite';
	$sneeit_core_smg_data2 = $sneeit_core_smg_image ? $sneeit_core_smg_properties : ( is_archive() ? $sneeit_core_smg_archive : '' );
	if ( is_archive() ) {
		/* translators: see trans-note#24109 */
		$sneeit_core_smg_data2 = sprintf( esc_html__( '%s Archives', 'sneeit_core' ), $sneeit_core_smg_data2 );
	}
	$sneeit_core_smg_data2 = esc_attr( $sneeit_core_smg_data2 ? $sneeit_core_smg_data2 . ' - ' . $sneeit_core_smg_url : $sneeit_core_smg_url );
	$sneeit_core_smg_label = esc_attr( $sneeit_core_smg_image ? $sneeit_core_smg_title : ( is_archive() ? $sneeit_core_smg_id : $sneeit_core_smg_name ) );
	echo "<meta name='description' content='$sneeit_core_smg_label' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<link rel='canonical' href='$sneeit_core_smg_label1' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	if ( is_front_page() ) {
		echo "<link rel='next' href='$sneeit_core_smg_site/page/2/' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	}
	echo "<meta property='og:locale' content='$sneeit_core_smg_desc' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<meta property='og:type' content='$sneeit_core_smg_label2' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<meta property='og:title' content='$sneeit_core_smg_data2' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<meta property='og:description' content='$sneeit_core_smg_label' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<meta property='og:url' content='$sneeit_core_smg_label1' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	echo "<meta property='og:site_name' content='$sneeit_core_smg_url' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	if ( is_single() ) {
		$sneeit_core_smg_article = esc_attr( esc_html__( 'Written by', 'sneeit_core' ) );
		$sneeit_core_smg_json = esc_attr( esc_html__( 'Est. reading time', 'sneeit_core' ) );
		$sneeit_core_smg_webpage = esc_attr( esc_html__( '%s minutes', 'sneeit_core' ) );
		/* translators: see trans-note#24128 */
		$sneeit_core_smg_collection = sprintf( $sneeit_core_smg_webpage, $sneeit_core_smg_tag );
		echo "<meta property='article:published_time' content='$sneeit_core_smg_modified' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		echo "<meta property='article:modified_time' content='$sneeit_core_smg_author' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		if ( $sneeit_core_smg_width ) {
			echo "<meta property='og:image' content='$sneeit_core_smg_width' $sneeit_core_smg_class />$sneeit_core_smg_eol";
			echo "<meta property='og:image:width' content='$sneeit_core_smg_type' $sneeit_core_smg_class />$sneeit_core_smg_eol";
			echo "<meta property='og:image:height' content='$sneeit_core_smg_categories' $sneeit_core_smg_class />$sneeit_core_smg_eol";
			echo "<meta property='og:image:type' content='image/$sneeit_core_smg_a' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		}
		echo "<meta name='author' content='$sneeit_core_smg_content' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		echo "<meta name='twitter:label1' content='$sneeit_core_smg_article' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		echo "<meta name='twitter:data1' content='$sneeit_core_smg_content' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		echo "<meta name='twitter:label2' content='$sneeit_core_smg_json' $sneeit_core_smg_class />$sneeit_core_smg_eol";
		echo "<meta name='twitter:data2' content='$sneeit_core_smg_collection' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	}
	echo "<meta name='twitter:card' content='summary_large_image' $sneeit_core_smg_class />$sneeit_core_smg_eol";
	if ( $sneeit_core_smg_image && is_single() ) {
		$sneeit_core_smg_breadcrumb = array(
			'@type' => 'Article',
			'@id' => $sneeit_core_smg_src . '#article',
			'isPartOf' => array(
				'@id' => $sneeit_core_smg_src
			),
			'author' => array(
				'name' => $sneeit_core_smg_content,
				'@id' => $sneeit_core_smg_site . '#/schema/person/5ff68e1c543d9cbf59b74e84c74a1350'
			),
			'headline' => $sneeit_core_smg_properties,
			'description' => $sneeit_core_smg_title,
			'datePublished' => $sneeit_core_smg_modified,
			'dateModified' => $sneeit_core_smg_author,
			'mainEntityOfPage' => array(
				'@id' => $sneeit_core_smg_src
			),
			'wordCount' => 522,
			'commentCount' => 0,
			'publisher' => array(
				'@id' => $sneeit_core_smg_site . '#organization'
			),
			'inLanguage' => 'en-US',
			'potentialAction' => array(
				array(
					'@type' => 'CommentAction',
					'name' => 'Comment',
					'target' => array(
						$sneeit_core_smg_src . '#respond'
					)
				)
			),
		);
		if ( ! empty( $sneeit_core_smg_width ) ) {
			$sneeit_core_smg_breadcrumb['image'] = array(
				'@id' => $sneeit_core_smg_src . '#primaryimage',
			);
			$sneeit_core_smg_breadcrumb['thumbnailUrl'] = array(
				'@id' => $sneeit_core_smg_width,
			);
			$sneeit_core_smg_breadcrumb['articleSection'] = array(
				'@id' => $sneeit_core_smg_width,
			);
		}
		if ( ! empty( $sneeit_core_smg_data ) ) {
			$sneeit_core_smg_breadcrumb['articleSection'] = $sneeit_core_smg_published;
		}
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_breadcrumb );
	}
	if ( $sneeit_core_smg_image ) {
		$sneeit_core_smg_list = array(
			'@type' => 'WebPage',
			'@id' => $sneeit_core_smg_src,
			'url' => $sneeit_core_smg_src,
			'name' => $sneeit_core_smg_properties . ' - ' . $sneeit_core_smg_url,
			'description' => $sneeit_core_smg_title,
			'isPartOf' => array(
				'@id' => $sneeit_core_smg_site . '#website'
			),
			'datePublished' => $sneeit_core_smg_modified,
			'dateModified' => $sneeit_core_smg_author,
			'breadcrumb' => array(
				'@id' => $sneeit_core_smg_src . '#breadcrumb'
			),
			'inLanguage' => 'en-US',
			'potentialAction' => array(
				array(
					'@type' => 'ReadAction',
					'target' => array(
						$sneeit_core_smg_src
					),
				),
			),
		);
		if ( ! empty( $sneeit_core_smg_width ) ) {
			$sneeit_core_smg_list['primaryImageOfPage'] = array(
				'@id' => $sneeit_core_smg_src . '#primaryimage',
			);
			$sneeit_core_smg_list['image'] = array(
				'@id' => $sneeit_core_smg_src . '#primaryimage',
			);
			$sneeit_core_smg_list['thumbnailUrl'] = $sneeit_core_smg_width;
		}
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_list );
	}
	if ( is_front_page() || is_archive() ) {
		$sneeit_core_smg_website = array(
			'@type' => 'CollectionPage',
			'@id' => $sneeit_core_smg_root,
			'url' => $sneeit_core_smg_root,
			'name' => $sneeit_core_smg_archive,
			'isPartOf' => array(
				'@id' => $sneeit_core_smg_site . '#website',
			),
			'about' => array(
				'@id' => $sneeit_core_smg_site . '#organization',
			),
			'description' => $sneeit_core_smg_id,
			'breadcrumb' => array(
				'@id' => $sneeit_core_smg_root . '#breadcrumb',
			),
			'inLanguage' => $sneeit_core_smg_desc,
		);
		if ( ! is_front_page() ) {
			unset( $sneeit_core_smg_website['about'] );
		}
		if ( $sneeit_core_smg_img ) {
			$sneeit_core_smg_website['primaryImageOfPage'] = array(
				'@id' => $sneeit_core_smg_root . '#primaryimage',
			);
			$sneeit_core_smg_website['image'] = array(
				'@id' => $sneeit_core_smg_root . '#primaryimage',
			);
			$sneeit_core_smg_website['thumbnailUrl'] = $sneeit_core_smg_img['src'];
		}
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_website );
	}
	if ( $sneeit_core_smg_image && ! empty( $sneeit_core_smg_width ) || $sneeit_core_smg_img ) {
		$sneeit_core_smg_organize = array(
			'@type' => 'ImageObject',
			'inLanguage' => 'en-US',
			'@id' => ( $sneeit_core_smg_img ? $sneeit_core_smg_root : $sneeit_core_smg_src ) . '#primaryimage',
			'url' => $sneeit_core_smg_img ? $sneeit_core_smg_img['src'] : $sneeit_core_smg_width,
			'contentUrl' => $sneeit_core_smg_img ? $sneeit_core_smg_img['src'] : $sneeit_core_smg_width,
			'width' => $sneeit_core_smg_img ? $sneeit_core_smg_img['width'] : $sneeit_core_smg_type,
			'height' => $sneeit_core_smg_img ? $sneeit_core_smg_img['height'] : $sneeit_core_smg_categories,
		);
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_organize );
	}
	$sneeit_core_smg_person = array(
		array(
			'@type' => 'ListItem',
			'position' => 1,
			'name' => esc_html__( 'Home' ),
			'item' => is_front_page() ? '' : $sneeit_core_smg_site,
		),
	);
	if ( $sneeit_core_smg_image ) {
		if ( ! empty( $sneeit_core_smg_data ) ) {
			foreach ( $sneeit_core_smg_data as $sneeit_core_smg_url_site ) {
				array_push( $sneeit_core_smg_person, array(
					'@type' => 'ListItem',
					'position' => count( $sneeit_core_smg_person ) + 1,
					'name' => $sneeit_core_smg_url_site['name'],
					'item' => $sneeit_core_smg_url_site['url'],
				) );
			}
		}
		array_push( $sneeit_core_smg_person, array(
			'@type' => 'ListItem',
			'position' => count( $sneeit_core_smg_person ) + 1,
			'name' => $sneeit_core_smg_properties,
			'item' => $sneeit_core_smg_src,
		) );
	}
	if ( $sneeit_core_smg_network ) {
		array_push( $sneeit_core_smg_person, array(
			'@type' => 'ListItem',
			'position' => count( $sneeit_core_smg_person ) + 1,
			'name' => $sneeit_core_smg_archive,
			'item' => $sneeit_core_smg_root,
		) );
	}
	$sneeit_core_smg_url_url = array(
		'@type' => 'BreadcrumbList',
		'@id' => ( $sneeit_core_smg_image ? $sneeit_core_smg_src : $sneeit_core_smg_root ) . '#breadcrumb',
		'itemListElement' => $sneeit_core_smg_person,
	);
	array_push( $sneeit_core_smg_locale, $sneeit_core_smg_url_url );
	$sneeit_core_smg_url_name = array(
		'@type' => 'Website',
		'@id' =>    $sneeit_core_smg_site . '#website',
		'url' => $sneeit_core_smg_site,
		'name' => $sneeit_core_smg_url,
		'description' => $sneeit_core_smg_name,
		'publisher' => array(
			'@id' => $sneeit_core_smg_site . '#organization',
		),
		'potentialAction' => array(
			0 => array(
				'@type' =>  'SearchAction',
				'target' =>  array(
					'@type' =>  'EntryPoint',
					'urlTemplate' =>  $sneeit_core_smg_site . '?s={search_term_string}',
				),
				'query-input' =>  'required name=search_term_string',
			),
		),
		'inLanguage' =>  $sneeit_core_smg_desc,
	);
	array_push( $sneeit_core_smg_locale, $sneeit_core_smg_url_name );
	if ( $sneeit_core_smg_graphs && count( $sneeit_core_smg_graphs ) > 3 ) {
		$sneeit_core_smg_url_desc = $sneeit_core_smg_graphs[0];
		$sneeit_core_smg_url_locale = $sneeit_core_smg_graphs[1];
		$sneeit_core_smg_url_graphs = $sneeit_core_smg_graphs[2];
		$sneeit_core_smg_url_logo = array(
			'@type' => 'Organization',
			'@id' => $sneeit_core_smg_site . '#organization',
			'name' => $sneeit_core_smg_url,
			'url' => $sneeit_core_smg_site,
			'logo' => array(
				'@type' => 'ImageObject',
				'@id' => $sneeit_core_smg_site . '#/schema/logo/image/',
				'url' => $sneeit_core_smg_url_desc,
				'contentUrl' => $sneeit_core_smg_url_desc,
				'width' => $sneeit_core_smg_url_locale,
				'height' => $sneeit_core_smg_url_graphs,
				'caption' => $sneeit_core_smg_url,
				'inLanguage' => $sneeit_core_smg_desc,
			),
			'image' => array(
				'@id' => $sneeit_core_smg_site . '#/schema/logo/image/',
			),
		);
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_url_logo );
	}
	if ( $sneeit_core_smg_image && is_single() ) {
		$sneeit_core_smg_url_network = array(
			'@type' => 'Person',
			'@id' => $sneeit_core_smg_site . '#/schema/person/5ff68e1c543d9cbf59b74e84c74a1350',
			'name' => $sneeit_core_smg_content,
			'image' => array(
				'@type' => 'ImageObject',
				'inLanguage' => 'en-US',
				'@id' => $sneeit_core_smg_site . '#/schema/person/image/',
				'url' => $sneeit_core_smg_read,
				'contentUrl' => $sneeit_core_smg_read,
				'caption' => $sneeit_core_smg_content
			),
			'url' => $sneeit_core_smg_est,
		);
		if ( $sneeit_core_smg_logo ) {
			$sneeit_core_smg_url_network['sameAs'] = array(
				$sneeit_core_smg_logo,
			);
		}
		array_push( $sneeit_core_smg_locale, $sneeit_core_smg_url_network );
	}
	if ( SNEEIT_CORE_IS_LOCAL ) {
		$sneeit_core_smg_locale = json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph' => $sneeit_core_smg_locale,
			),
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
		);
	} else {
		$sneeit_core_smg_locale = json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph' => $sneeit_core_smg_locale,
			),
			JSON_UNESCAPED_SLASHES
		);
	}
	echo "<script type='application/ld+json' class='sneeit_core-seo-graph'>$sneeit_core_smg_locale</script>";
}
