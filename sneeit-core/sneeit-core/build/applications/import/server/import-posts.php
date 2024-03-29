<?php
/**
 * DragBlock's Import.
 *
 * @package Import posts
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
	$sneeit_core_ip_items = $_POST['data'];
	$sneeit_core_ip_post = $_POST['slug'];
	// dev-reply#2419.
	if ( ( $sneeit_core_ip_post ) === 'attachment' ) {
		return sneeit_core_demo_import_attachments( $sneeit_core_ip_items );
	}
	// dev-reply#2426.
	if ( ( $sneeit_core_ip_post ) === 'post' ) {
		// dev-reply#2428.
		$sneeit_core_ip_type = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'title' => 'Hello world!',
			'post_name__in' => 'hello-world',
			'posts_per_page' => 1,
		) );
		foreach ( $sneeit_core_ip_type as $sneeit_core_ip_hello ) {
			wp_delete_post( $sneeit_core_ip_hello->ID, true );
		}
	}
	// dev-reply#2440.
	$sneeit_core_ip_worlds = get_posts( array(
		'post_type'      => $sneeit_core_ip_post,
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
	foreach ( $sneeit_core_ip_worlds as $sneeit_core_ip_world ) {
		wp_delete_post( $sneeit_core_ip_world->ID, true );
	}
	// dev-reply#2457.
	foreach ( $sneeit_core_ip_items as $sneeit_core_ip_duplicates => $sneeit_core_ip_p ) {
		$sneeit_core_ip_duplicates = (int) $sneeit_core_ip_duplicates;
		if ( empty( $sneeit_core_ip_p['title'] ) || empty( $sneeit_core_ip_p['name'] ) ) {
			continue;
		}
		// dev-reply#2463.
		if ( ( $sneeit_core_ip_post ) === 'page' || ( $sneeit_core_ip_post ) === 'post' ) {
			wp_delete_post( $sneeit_core_ip_duplicates, true );
		}
		// dev-reply#2468.
		$sneeit_core_ip_worlds = get_posts( array(
			'post_type'      => $sneeit_core_ip_post,
			// dev-reply#2471.
			'title' => $sneeit_core_ip_p['title'],
			// dev-reply#2473.
			'posts_per_page' => - 1,
		) );
		foreach ( $sneeit_core_ip_worlds as $sneeit_core_ip_world ) {
			// dev-reply#2478.
			wp_delete_post( $sneeit_core_ip_world->ID, true );
		}
	}
	// dev-reply#2484.
	$sneeit_core_ip_id = 300; // dev-reply#2485.
	$sneeit_core_ip_item = 2 * 24 * 60 * 60; // dev-reply#2486.
	$sneeit_core_ip_gap = time() - $sneeit_core_ip_item - count( $sneeit_core_ip_items ) * $sneeit_core_ip_id;
	$sneeit_core_ip_pad = 0;
	foreach ( $sneeit_core_ip_items as $sneeit_core_ip_duplicates => $sneeit_core_ip_p ) {
		$sneeit_core_ip_duplicates = (int) $sneeit_core_ip_duplicates;
		if ( empty( $sneeit_core_ip_p['title'] ) || empty( $sneeit_core_ip_p['name'] ) ) {
			/* translators: see trans-note#2476 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Wrong %1$s Args %2$s', 'sneeit-core' ), $sneeit_core_ip_post, $sneeit_core_ip_duplicates ) );
		}
		$sneeit_core_ip_base = date( 'Y-m-d H:i:s', $sneeit_core_ip_gap + $sneeit_core_ip_pad * $sneeit_core_ip_id );
		$sneeit_core_ip_time = array(
			'import_id' => $sneeit_core_ip_duplicates,
			'post_status' => 'publish',
			'post_type' => $sneeit_core_ip_post,
			// dev-reply#24101.
			'post_date' => date( 'Y-m-d H:i:s', $sneeit_core_ip_gap + $sneeit_core_ip_pad * $sneeit_core_ip_id ),
			'post_date_gmt' => get_gmt_from_date( $sneeit_core_ip_base ),
		);
		// dev-reply#24107.
		if ( ! empty( $sneeit_core_ip_p['terms'] ) ) {
			$sneeit_core_ip_time['post_category'] = [];
			$sneeit_core_ip_time['tags_input'] = [];
			foreach ( $sneeit_core_ip_p['terms'] as $sneeit_core_ip_count ) {
				$sneeit_core_ip_new = get_term( $sneeit_core_ip_count );
				if ( empty( $sneeit_core_ip_new ) || is_wp_error( $sneeit_core_ip_new ) ) {
					continue;
				}
				if ( $sneeit_core_ip_new->taxonomy === 'post_tag' ) {
					$sneeit_core_ip_time['tags_input'][] = $sneeit_core_ip_new->slug;
					continue;
				}
				$sneeit_core_ip_time['post_category'][] = $sneeit_core_ip_count;
			}
			// dev-reply#24124.
		}
		$sneeit_core_ip_pad++;
		if ( ! empty( $sneeit_core_ip_p['title'] ) ) {
			$sneeit_core_ip_time['post_title'] = $sneeit_core_ip_p['title'];
		}
		if ( ! empty( $sneeit_core_ip_p['content'] ) ) {
			$sneeit_core_ip_time['post_content'] = $sneeit_core_ip_p['content'];
		}
		if ( ! empty( $sneeit_core_ip_p['name'] ) ) {
			$sneeit_core_ip_time['post_name'] = $sneeit_core_ip_p['name'];
		}
		// dev-reply#24144.
		if ( ! empty( $sneeit_core_ip_p['parent'] ) && is_numeric( $sneeit_core_ip_p['parent'] ) ) {
			$sneeit_core_ip_args = get_posts( array(
				'post_type'      => $sneeit_core_ip_post,
				'posts_per_page' => 1,
				'meta_query' => array(
					array(
						'key' => 'sneeit-demo-id',
						'value' => (int) $sneeit_core_ip_p['parent'],
						'compare' => '=',
						'type' => 'NUMERIC', // dev-reply#24154.
					),
				),
			) );
			if ( $sneeit_core_ip_args ) {
				$sneeit_core_ip_args = $sneeit_core_ip_args[0];
				$sneeit_core_ip_time['post_parent'] = $sneeit_core_ip_args->id;
			}
		}
		// dev-reply#24165.
		$sneeit_core_ip_term = wp_insert_post( $sneeit_core_ip_time, true );
		if ( is_wp_error( $sneeit_core_ip_term ) ) {
			// dev-reply#24172.
			continue;
			// dev-reply#24174.
		}
		if ( ( $sneeit_core_ip_post ) === 'page' || ( $sneeit_core_ip_post ) === 'posts' ) {
			global $wpdb;
			$sneeit_core_ip_parent = $wpdb->prefix . 'posts';
			if (
				! empty( $wpdb->update(
					$sneeit_core_ip_parent,
					array( 'ID' => $sneeit_core_ip_duplicates ),
					array( 'ID' => $sneeit_core_ip_term )
				) )
			) {
				$sneeit_core_ip_term = $sneeit_core_ip_duplicates;
			}
		}
		// dev-reply#24203.
		update_post_meta( $sneeit_core_ip_term, 'sneeit-demo-id', $sneeit_core_ip_duplicates );
		if ( ! empty( $sneeit_core_ip_p['meta'] ) ) {
			foreach ( $sneeit_core_ip_p['meta'] as $sneeit_core_ip_wpdb => $sneeit_core_ip_table ) {
				update_post_meta( $sneeit_core_ip_term, $sneeit_core_ip_wpdb, $sneeit_core_ip_table );
			}
		}
		// dev-reply#24215.
		if ( ( $sneeit_core_ip_post ) === 'wp_template' || ( $sneeit_core_ip_post ) === 'wp_template_part' || ( $sneeit_core_ip_post ) === 'wp_global_styles' ) {
			$sneeit_core_ip_name = array(
				'wp_theme' => array( get_stylesheet() ),
			);
			if ( ( $sneeit_core_ip_post ) === 'wp_template_part' && ! empty( $sneeit_core_ip_p['area'] ) ) {
				$sneeit_core_ip_name['wp_template_part_area'] = array( $sneeit_core_ip_p['area'] );
			}
			foreach ( $sneeit_core_ip_name as $sneeit_core_ip_meta => $sneeit_core_ip_key ) {
				foreach ( $sneeit_core_ip_key as $sneeit_core_ip_value ) {
					// dev-reply#24241.
					$sneeit_core_ip_new = wp_create_term( $sneeit_core_ip_value, $sneeit_core_ip_meta );
					if ( is_wp_error( $sneeit_core_ip_new ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24174 */
							sprintf(
								esc_html__( 'In %1$s (#%2$s/%3$s), cannot create %4$s for %5$s: %6$s', 'sneeit-core' ),
								$sneeit_core_ip_post,
								$sneeit_core_ip_term,
								$sneeit_core_ip_duplicates,
								$sneeit_core_ip_value,
								$sneeit_core_ip_meta,
								$sneeit_core_ip_new->get_error_message()
							)
						);
					}
					// dev-reply#24259.
					$sneeit_core_ip_affected = wp_set_object_terms( $sneeit_core_ip_term, array( (int) $sneeit_core_ip_new['term_id'] ), $sneeit_core_ip_meta );
					if ( is_wp_error( $sneeit_core_ip_affected ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24189 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s: %6$s', 'sneeit-core' ),
								$sneeit_core_ip_post,
								$sneeit_core_ip_value,
								$sneeit_core_ip_meta,
								$sneeit_core_ip_term,
								$sneeit_core_ip_duplicates,
								$sneeit_core_ip_new->get_error_message()
							)
						);
					}
					if ( empty( $sneeit_core_ip_affected ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24202 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s', 'sneeit-core' ),
								$sneeit_core_ip_post,
								$sneeit_core_ip_value,
								$sneeit_core_ip_meta,
								$sneeit_core_ip_term,
								$sneeit_core_ip_duplicates,
							)
						);
					}
					// dev-reply#24293.
				}
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
/**
 * Check Documentation#24220
 *
 * @param object|array|string $sneeit_core_ip_items check var-def#24220.
 */
function sneeit_core_demo_import_attachments( $sneeit_core_ip_items ) {
	// dev-reply#24313.
	$sneeit_core_ip_terms = null;
	$sneeit_core_ip_taxonomy = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
	) );
	// dev-reply#24322.
	if ( ! empty( $sneeit_core_ip_taxonomy ) ) {
		$sneeit_core_ip_terms = $sneeit_core_ip_taxonomy[0]->ID;
	}
	foreach ( $sneeit_core_ip_items as $sneeit_core_ip_duplicates => $sneeit_core_ip_p ) {
		$sneeit_core_ip_duplicates = (int) $sneeit_core_ip_duplicates;
		$sneeit_core_ip_tag = $sneeit_core_ip_p['name'] ? $sneeit_core_ip_p['name'] : null;
		// dev-reply#24330.
		$sneeit_core_ip_term = sneeit_core_get_demo_post_id( $sneeit_core_ip_p['parent'] );
		// dev-reply#24339.
		$sneeit_core_ip_set = get_posts( array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => $sneeit_core_ip_duplicates,
			'meta_compare' => '=',
		) );
		if ( ! empty( $sneeit_core_ip_set ) ) {
			// dev-reply#24356.
			if ( $sneeit_core_ip_term ) {
				set_post_thumbnail( $sneeit_core_ip_term, $sneeit_core_ip_set[0]->ID );
			}
			// dev-reply#24361.
			continue;
		}
		$sneeit_core_ip_default = '';
		$sneeit_core_ip_attachment = false;
		if ( ! empty( $sneeit_core_ip_p['get'] ) ) {
			// dev-reply#24373.
			$sneeit_core_ip_default = sneeit_core_download_image( $sneeit_core_ip_p['get'], $sneeit_core_ip_term );
			// dev-reply#24375.
			if ( empty( $sneeit_core_ip_default ) ) {
				// dev-reply#24378.
			}
		}
		if ( empty( $sneeit_core_ip_default ) ) {
			// dev-reply#24383.
			if ( $sneeit_core_ip_tag ) {
				$sneeit_core_ip_attachments = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH, $sneeit_core_ip_term, $sneeit_core_ip_tag );
				if ( $sneeit_core_ip_attachments ) {
					set_post_thumbnail( $sneeit_core_ip_term, $sneeit_core_ip_attachments );
					continue;
				}
			}
			// dev-reply#24393.
			if ( ! $sneeit_core_ip_terms ) {
				$sneeit_core_ip_terms = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_ip_terms ) {
				set_post_thumbnail( $sneeit_core_ip_term, $sneeit_core_ip_terms );
			}
			continue;
		} else {
			$sneeit_core_ip_attachment = true;
		}
		// dev-reply#24411.
		$sneeit_core_ip_created = sneeit_core_create_attachment( $sneeit_core_ip_default, $sneeit_core_ip_term, $sneeit_core_ip_tag );
		if ( ( $sneeit_core_ip_created ) === false ) {
			if ( $sneeit_core_ip_attachment ) {
				unlink( $sneeit_core_ip_default );
			}
			if ( ! $sneeit_core_ip_terms ) {
				$sneeit_core_ip_terms = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_ip_terms ) {
				set_post_thumbnail( $sneeit_core_ip_term, $sneeit_core_ip_terms );
			}
			continue;
		}
		set_post_thumbnail( $sneeit_core_ip_term, $sneeit_core_ip_created );
		update_post_meta( $sneeit_core_ip_created, 'sneeit-demo-id', $sneeit_core_ip_duplicates );
		if ( ! empty( $sneeit_core_ip_p['get'] ) ) {
			update_post_meta( $sneeit_core_ip_created, 'sneeit-demo', $sneeit_core_ip_p['get'] );
		}
	}
	echo json_encode( 'done' );
	die();
}
