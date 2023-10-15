<?php
/**
 * DragBlock's Import.
 *
 * @package Posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_posts', 'sneeit_core_demo_import_posts' );
	add_action( 'wp_ajax_sneeit_core_demo_import_posts', 'sneeit_core_demo_import_posts' );
endif; // dev-reply#249.
/**
 * Check Documentation#246
 */
function sneeit_core_demo_import_posts() {
	sneeit_core_ajax_request_verify_die( ['data', 'slug' ] );
	$sneeit_core_p_items = $_POST['data'];
	$sneeit_core_p_post = $_POST['slug'];
	// dev-reply#2419.
	if ( ( $sneeit_core_p_post ) === 'attachment' ) {
		return sneeit_core_demo_import_attachments( $sneeit_core_p_items );
	}
	// dev-reply#2426.
	if ( ( $sneeit_core_p_post ) === 'post' ) {
		// dev-reply#2428.
		$sneeit_core_p_type = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'title' => 'Hello world!',
			'post_name__in' => 'hello-world',
			'posts_per_page' => 1,
		) );
		foreach ( $sneeit_core_p_type as $sneeit_core_p_hello ) {
			wp_delete_post( $sneeit_core_p_hello->ID, true );
		}
	}
	// dev-reply#2440.
	$sneeit_core_p_worlds = get_posts( array(
		'post_type'      => $sneeit_core_p_post,
		'post_status'    => 'publish',
		'meta_query' => array(
			array(
				'key' => 'sneeit-demo-id',
				// dev-reply#2447.
				'compare' => 'EXISTS',
			),
		),
		'posts_per_page' => - 1,
	) );
	foreach ( $sneeit_core_p_worlds as $sneeit_core_p_world ) {
		wp_delete_post( $sneeit_core_p_world->ID, true );
	}
	// dev-reply#2457.
	foreach ( $sneeit_core_p_items as $sneeit_core_p_duplicates => $sneeit_core_p_p ) {
		$sneeit_core_p_duplicates = (int) $sneeit_core_p_duplicates;
		if ( empty( $sneeit_core_p_p['title'] ) || empty( $sneeit_core_p_p['name'] ) ) {
			continue;
		}
		// dev-reply#2463.
		if ( ( $sneeit_core_p_post ) === 'page' || ( $sneeit_core_p_post ) === 'post' ) {
			wp_delete_post( $sneeit_core_p_duplicates, true );
		}
		// dev-reply#2468.
		$sneeit_core_p_worlds = get_posts( array(
			'post_type'      => $sneeit_core_p_post,
			// dev-reply#2471.
			'title' => $sneeit_core_p_p['title'],
			// dev-reply#2473.
			'posts_per_page' => - 1,
		) );
		foreach ( $sneeit_core_p_worlds as $sneeit_core_p_world ) {
			// dev-reply#2478.
			wp_delete_post( $sneeit_core_p_world->ID, true );
		}
	}
	// dev-reply#2484.
	$sneeit_core_p_id = 100; // dev-reply#2485.
	$sneeit_core_p_item = time() - count( $sneeit_core_p_items ) * $sneeit_core_p_id;
	$sneeit_core_p_gap = 0;
	foreach ( $sneeit_core_p_items as $sneeit_core_p_duplicates => $sneeit_core_p_p ) {
		$sneeit_core_p_duplicates = (int) $sneeit_core_p_duplicates;
		if ( empty( $sneeit_core_p_p['title'] ) || empty( $sneeit_core_p_p['name'] ) ) {
			/* translators: see trans-note#2475 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Wrong %1$s Args %2$s', 'sneeit-core' ), $sneeit_core_p_post, $sneeit_core_p_duplicates ) );
		}
		$sneeit_core_p_base = date( 'Y-m-d H:i:s', $sneeit_core_p_item + $sneeit_core_p_gap * $sneeit_core_p_id );
		$sneeit_core_p_time = array(
			'import_id' => $sneeit_core_p_duplicates,
			'post_status' => 'publish',
			'post_type' => $sneeit_core_p_post,
			// dev-reply#24100.
			'post_date' => date( 'Y-m-d H:i:s', $sneeit_core_p_item + $sneeit_core_p_gap * $sneeit_core_p_id ),
			'post_date_gmt' => get_gmt_from_date( $sneeit_core_p_base ),
		);
		// dev-reply#24106.
		if ( ! empty( $sneeit_core_p_p['terms'] ) ) {
			$sneeit_core_p_time['post_category'] = [];
			$sneeit_core_p_time['tags_input'] = [];
			foreach ( $sneeit_core_p_p['terms'] as $sneeit_core_p_count ) {
				$sneeit_core_p_new = get_term( $sneeit_core_p_count );
				if ( empty( $sneeit_core_p_new ) || is_wp_error( $sneeit_core_p_new ) ) {
					continue;
				}
				if ( $sneeit_core_p_new->taxonomy === 'post_tag' ) {
					$sneeit_core_p_time['tags_input'][] = $sneeit_core_p_new->slug;
					continue;
				}
				$sneeit_core_p_time['post_category'][] = $sneeit_core_p_count;
			}
			// dev-reply#24123.
		}
		$sneeit_core_p_gap++;
		if ( ! empty( $sneeit_core_p_p['title'] ) ) {
			$sneeit_core_p_time['post_title'] = $sneeit_core_p_p['title'];
		}
		if ( ! empty( $sneeit_core_p_p['content'] ) ) {
			$sneeit_core_p_time['post_content'] = $sneeit_core_p_p['content'];
		}
		if ( ! empty( $sneeit_core_p_p['name'] ) ) {
			$sneeit_core_p_time['post_name'] = $sneeit_core_p_p['name'];
		}
		// dev-reply#24143.
		$sneeit_core_p_args = wp_insert_post( $sneeit_core_p_time, true );
		if ( is_wp_error( $sneeit_core_p_args ) ) {
			// dev-reply#24150.
			continue;
			// dev-reply#24152.
		}
		if ( ( $sneeit_core_p_post ) === 'page' || ( $sneeit_core_p_post ) === 'posts' ) {
			global $wpdb;
			$sneeit_core_p_term = $wpdb->prefix . 'posts';
			if (
				! empty( $wpdb->update(
					$sneeit_core_p_term,
					array( 'ID' => $sneeit_core_p_duplicates ),
					array( 'ID' => $sneeit_core_p_args )
				) )
			) {
				$sneeit_core_p_args = $sneeit_core_p_duplicates;
			}
		}
		// dev-reply#24181.
		update_post_meta( $sneeit_core_p_args, 'sneeit-demo-id', $sneeit_core_p_duplicates );
		if ( ! empty( $sneeit_core_p_p['meta'] ) ) {
			foreach ( $sneeit_core_p_p['meta'] as $sneeit_core_p_wpdb => $sneeit_core_p_table ) {
				update_post_meta( $sneeit_core_p_args, $sneeit_core_p_wpdb, $sneeit_core_p_table );
			}
		}
		// dev-reply#24191.
		if ( ( $sneeit_core_p_post ) === 'wp_template' || ( $sneeit_core_p_post ) === 'wp_template_part' || ( $sneeit_core_p_post ) === 'wp_global_styles' ) {
			$sneeit_core_p_name = array(
				'wp_theme' => array( get_stylesheet() ),
			);
			if ( ( $sneeit_core_p_post ) === 'wp_template_part' && ! empty( $sneeit_core_p_p['area'] ) ) {
				$sneeit_core_p_name['wp_template_part_area'] = array( $sneeit_core_p_p['area'] );
			}
			foreach ( $sneeit_core_p_name as $sneeit_core_p_meta => $sneeit_core_p_key ) {
				foreach ( $sneeit_core_p_key as $sneeit_core_p_value ) {
					// dev-reply#24217.
					$sneeit_core_p_new = wp_create_term( $sneeit_core_p_value, $sneeit_core_p_meta );
					if ( is_wp_error( $sneeit_core_p_new ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24154 */
							sprintf(
								esc_html__( 'In %1$s (#%2$s/%3$s), cannot create %4$s for %5$s): %6$s', 'sneeit-core' ),
								$sneeit_core_p_post,
								$sneeit_core_p_args,
								$sneeit_core_p_duplicates,
								$sneeit_core_p_value,
								$sneeit_core_p_meta,
								$sneeit_core_p_new->get_error_message()
							)
						);
					}
					// dev-reply#24235.
					$sneeit_core_p_affected = wp_set_object_terms( $sneeit_core_p_args, array( (int) $sneeit_core_p_new['term_id'] ), $sneeit_core_p_meta );
					if ( is_wp_error( $sneeit_core_p_affected ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24169 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s: %6$s', 'sneeit-core' ),
								$sneeit_core_p_post,
								$sneeit_core_p_value,
								$sneeit_core_p_meta,
								$sneeit_core_p_args,
								$sneeit_core_p_duplicates,
								$sneeit_core_p_new->get_error_message()
							)
						);
					}
					if ( empty( $sneeit_core_p_affected ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24182 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s', 'sneeit-core' ),
								$sneeit_core_p_post,
								$sneeit_core_p_value,
								$sneeit_core_p_meta,
								$sneeit_core_p_args,
								$sneeit_core_p_duplicates,
							)
						);
					}
					// dev-reply#24269.
				}
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
/**
 * Check Documentation#24200
 *
 * @param object|array|string $sneeit_core_p_items check var-def#24200.
 */
function sneeit_core_demo_import_attachments( $sneeit_core_p_items ) {
	// dev-reply#24289.
	$sneeit_core_p_terms = null;
	$sneeit_core_p_taxonomy = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
	) );
	// dev-reply#24298.
	if ( ! empty( $sneeit_core_p_taxonomy ) ) {
		$sneeit_core_p_terms = $sneeit_core_p_taxonomy[0]->ID;
	}
	foreach ( $sneeit_core_p_items as $sneeit_core_p_duplicates => $sneeit_core_p_p ) {
		$sneeit_core_p_duplicates = (int) $sneeit_core_p_duplicates;
		$sneeit_core_p_tag = $sneeit_core_p_p['name'] ? $sneeit_core_p_p['name'] : null;
		// dev-reply#24306.
		$sneeit_core_p_args = sneeit_core_get_demo_post_id( $sneeit_core_p_p['parent'] );
		// dev-reply#24315.
		$sneeit_core_p_set = get_posts( array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => $sneeit_core_p_duplicates,
			'meta_compare' => '=',
		) );
		if ( ! empty( $sneeit_core_p_set ) ) {
			// dev-reply#24332.
			if ( $sneeit_core_p_args ) {
				set_post_thumbnail( $sneeit_core_p_args, $sneeit_core_p_set[0]->ID );
			}
			// dev-reply#24337.
			continue;
		}
		$sneeit_core_p_default = '';
		$sneeit_core_p_attachment = false;
		if ( ! empty( $sneeit_core_p_p['get'] ) ) {
			// dev-reply#24349.
			$sneeit_core_p_default = sneeit_core_download_image( $sneeit_core_p_p['get'], $sneeit_core_p_args );
			// dev-reply#24351.
			if ( empty( $sneeit_core_p_default ) ) {
				// dev-reply#24354.
			}
		}
		if ( empty( $sneeit_core_p_default ) ) {
			// dev-reply#24359.
			if ( $sneeit_core_p_tag ) {
				$sneeit_core_p_attachments = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH, $sneeit_core_p_args, $sneeit_core_p_tag );
				if ( $sneeit_core_p_attachments ) {
					set_post_thumbnail( $sneeit_core_p_args, $sneeit_core_p_attachments );
					continue;
				}
			}
			// dev-reply#24369.
			if ( ! $sneeit_core_p_terms ) {
				$sneeit_core_p_terms = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_p_terms ) {
				set_post_thumbnail( $sneeit_core_p_args, $sneeit_core_p_terms );
			}
			continue;
		} else {
			$sneeit_core_p_attachment = true;
		}
		// dev-reply#24387.
		$sneeit_core_p_created = sneeit_core_create_attachment( $sneeit_core_p_default, $sneeit_core_p_args, $sneeit_core_p_tag );
		if ( ( $sneeit_core_p_created ) === false ) {
			if ( $sneeit_core_p_attachment ) {
				unlink( $sneeit_core_p_default );
			}
			if ( ! $sneeit_core_p_terms ) {
				$sneeit_core_p_terms = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_p_terms ) {
				set_post_thumbnail( $sneeit_core_p_args, $sneeit_core_p_terms );
			}
			continue;
		}
		set_post_thumbnail( $sneeit_core_p_args, $sneeit_core_p_created );
		update_post_meta( $sneeit_core_p_created, 'sneeit-demo-id', $sneeit_core_p_duplicates );
		if ( ! empty( $sneeit_core_p_p['get'] ) ) {
			update_post_meta( $sneeit_core_p_created, 'sneeit-demo', $sneeit_core_p_p['get'] );
		}
	}
	echo json_encode( 'done' );
	die();
}
