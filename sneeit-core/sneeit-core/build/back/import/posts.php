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
	$sneeit_core_p_type = $_POST['slug'];
	// dev-reply#2419.
	if ( ( $sneeit_core_p_type ) === 'attachment' ) {
		return sneeit_core_demo_import_attachments( $sneeit_core_p_items );
	}
	// dev-reply#2424.
	if ( ( $sneeit_core_p_type ) === 'post' ) {
		// dev-reply#2426.
		$sneeit_core_p_hello_worlds = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'title' => 'Hello world!',
			'post_name__in' => 'hello-world',
			'posts_per_page' => 1,
		) );
		foreach ( $sneeit_core_p_hello_worlds as $sneeit_core_p_hello_world ) {
			wp_delete_post( $sneeit_core_p_hello_world->ID, true );
		}
	}
	// dev-reply#2438.
	$sneeit_core_p_duplicates = get_posts( array(
		'post_type'      => $sneeit_core_p_type,
		'post_status'    => 'publish',
		'meta_query' => array(
			array(
				'key' => 'sneeit-demo-id',
				// dev-reply#2445.
				'compare' => 'EXISTS',
			),
		),
		'posts_per_page' => - 1,
	) );
	foreach ( $sneeit_core_p_duplicates as $sneeit_core_p_p ) {
		wp_delete_post( $sneeit_core_p_p->ID, true );
	}
	// dev-reply#2455.
	foreach ( $sneeit_core_p_items as $sneeit_core_p_id => $sneeit_core_p_item ) {
		$sneeit_core_p_id = (int) $sneeit_core_p_id;
		if ( empty( $sneeit_core_p_item['title'] ) || empty( $sneeit_core_p_item['name'] ) ) {
			continue;
		}
		// dev-reply#2461.
		if ( ( $sneeit_core_p_type ) === 'page' || ( $sneeit_core_p_type ) === 'post' ) {
			wp_delete_post( $sneeit_core_p_id, true );
		}
		// dev-reply#2466.
		$sneeit_core_p_duplicates = get_posts( array(
			'post_type'      => $sneeit_core_p_type,
			// dev-reply#2469.
			'title' => $sneeit_core_p_item['title'],
			// dev-reply#2471.
			'posts_per_page' => - 1,
		) );
		foreach ( $sneeit_core_p_duplicates as $sneeit_core_p_p ) {
			// dev-reply#2476.
			wp_delete_post( $sneeit_core_p_p->ID, true );
		}
	}
	// dev-reply#2482.
	$sneeit_core_p_gap = 100; // dev-reply#2483.
	$sneeit_core_p_base_time = time() - count( $sneeit_core_p_items ) * $sneeit_core_p_gap;
	$sneeit_core_p_count = 0;
	foreach ( $sneeit_core_p_items as $sneeit_core_p_id => $sneeit_core_p_item ) {
		$sneeit_core_p_id = (int) $sneeit_core_p_id;
		if ( empty( $sneeit_core_p_item['title'] ) || empty( $sneeit_core_p_item['name'] ) ) {
			/* translators: see trans-note#2475 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Wrong %1$s Args %2$s', 'sneeit-core' ), $sneeit_core_p_type, $sneeit_core_p_id ) );
		}
		$sneeit_core_p_new_time = date( 'Y-m-d H:i:s', $sneeit_core_p_base_time + $sneeit_core_p_count * $sneeit_core_p_gap );
		$sneeit_core_p_args = array(
			'import_id' => $sneeit_core_p_id,
			'post_status' => 'publish',
			'post_type' => $sneeit_core_p_type,
			// dev-reply#2498.
			'post_date' => date( 'Y-m-d H:i:s', $sneeit_core_p_base_time + $sneeit_core_p_count * $sneeit_core_p_gap ),
			'post_date_gmt' => get_gmt_from_date( $sneeit_core_p_new_time ),
		);
		$sneeit_core_p_count++;
		if ( ! empty( $sneeit_core_p_item['title'] ) ) {
			$sneeit_core_p_args['post_title'] = $sneeit_core_p_item['title'];
		}
		if ( ! empty( $sneeit_core_p_item['content'] ) ) {
			$sneeit_core_p_args['post_content'] = $sneeit_core_p_item['content'];
		}
		if ( ! empty( $sneeit_core_p_item['name'] ) ) {
			$sneeit_core_p_args['post_name'] = $sneeit_core_p_item['name'];
		}
		// dev-reply#24116.
		$sneeit_core_p_post_id = wp_insert_post( $sneeit_core_p_args, true );
		if ( is_wp_error( $sneeit_core_p_post_id ) ) {
			continue;
			// dev-reply#24124.
		}
		if ( ( $sneeit_core_p_type ) === 'page' || ( $sneeit_core_p_type ) === 'posts' ) {
			global $wpdb;
			$sneeit_core_p_table_name = $wpdb->prefix . 'posts';
			if (
				! empty( $wpdb->update(
					$sneeit_core_p_table_name,
					array( 'ID' => $sneeit_core_p_id ),
					array( 'ID' => $sneeit_core_p_post_id )
				) )
			) {
				$sneeit_core_p_post_id = $sneeit_core_p_id;
			}
		}
		// dev-reply#24153.
		update_post_meta( $sneeit_core_p_post_id, 'sneeit-demo-id', $sneeit_core_p_id );
		if ( ! empty( $sneeit_core_p_item['meta'] ) ) {
			foreach ( $sneeit_core_p_item['meta'] as $sneeit_core_p_meta_key => $sneeit_core_p_meta_value ) {
				update_post_meta( $sneeit_core_p_post_id, $sneeit_core_p_meta_key, $sneeit_core_p_meta_value );
			}
		}
		// dev-reply#24163.
		if ( ! empty( $sneeit_core_p_item['terms'] ) ) {
			foreach ( $sneeit_core_p_item['terms'] as $sneeit_core_p_term_id ) {
				$sneeit_core_p_term = get_term( $sneeit_core_p_term_id );
				if ( empty( $sneeit_core_p_term ) || is_wp_error( $sneeit_core_p_term ) ) {
					continue;
				}
				// dev-reply#24171.
				wp_set_post_terms( $sneeit_core_p_post_id, array( (int) $sneeit_core_p_term_id ), $sneeit_core_p_term->taxonomy, true );
			}
		}
		// dev-reply#24176.
		if ( ( $sneeit_core_p_type ) === 'wp_template' || ( $sneeit_core_p_type ) === 'wp_template_part' || ( $sneeit_core_p_type ) === 'wp_global_styles' ) {
			$sneeit_core_p_affected_terms = array(
				'wp_theme' => array( get_stylesheet() ),
			);
			if ( ( $sneeit_core_p_type ) === 'wp_template_part' && ! empty( $sneeit_core_p_item['area'] ) ) {
				$sneeit_core_p_affected_terms['wp_template_part_area'] = array( $sneeit_core_p_item['area'] );
			}
			foreach ( $sneeit_core_p_affected_terms as $sneeit_core_p_taxonomy => $sneeit_core_p_terms ) {
				foreach ( $sneeit_core_p_terms as $sneeit_core_p_tag_name ) {
					// dev-reply#24189.
					$sneeit_core_p_term = wp_create_term( $sneeit_core_p_tag_name, $sneeit_core_p_taxonomy );
					if ( is_wp_error( $sneeit_core_p_term ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24147 */
							sprintf(
								esc_html__( 'In %1$s (#%2$s/%3$s), cannot create %4$s for %5$s): %6$s', 'sneeit-core' ),
								$sneeit_core_p_type,
								$sneeit_core_p_post_id,
								$sneeit_core_p_id,
								$sneeit_core_p_tag_name,
								$sneeit_core_p_taxonomy,
								$sneeit_core_p_term->get_error_message()
							)
						);
					}
					// dev-reply#24207.
					$sneeit_core_p_set = wp_set_object_terms( $sneeit_core_p_post_id, array( (int) $sneeit_core_p_term['term_id'] ), $sneeit_core_p_taxonomy );
					if ( is_wp_error( $sneeit_core_p_set ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24162 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s: %6$s', 'sneeit-core' ),
								$sneeit_core_p_type,
								$sneeit_core_p_tag_name,
								$sneeit_core_p_taxonomy,
								$sneeit_core_p_post_id,
								$sneeit_core_p_id,
								$sneeit_core_p_term->get_error_message()
							)
						);
					}
					if ( empty( $sneeit_core_p_set ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24175 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s', 'sneeit-core' ),
								$sneeit_core_p_type,
								$sneeit_core_p_tag_name,
								$sneeit_core_p_taxonomy,
								$sneeit_core_p_post_id,
								$sneeit_core_p_id,
							)
						);
					}
					// dev-reply#24241.
				}
			}
		}
	}
	echo json_encode( 'done' );
	die();
}
/**
 * Check Documentation#24193
 *
 * @param object|array|string $sneeit_core_p_items check var-def#24193.
 */
function sneeit_core_demo_import_attachments( $sneeit_core_p_items ) {
	// dev-reply#24261.
	$sneeit_core_p_default_attachment_id = null;
	$sneeit_core_p_attachments = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
	) );
	// dev-reply#24270.
	if ( ! empty( $sneeit_core_p_attachments ) ) {
		$sneeit_core_p_default_attachment_id = $sneeit_core_p_attachments[0]->ID;
	}
	foreach ( $sneeit_core_p_items as $sneeit_core_p_id => $sneeit_core_p_item ) {
		$sneeit_core_p_id = (int) $sneeit_core_p_id;
		$sneeit_core_p_name = $sneeit_core_p_item['name'] ? $sneeit_core_p_item['name'] : null;
		// dev-reply#24278.
		$sneeit_core_p_post_id = sneeit_core_get_demo_post_id( $sneeit_core_p_item['parent'] );
		// dev-reply#24287.
		$sneeit_core_p_created = get_posts( array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => $sneeit_core_p_id,
			'meta_compare' => '=',
		) );
		if ( ! empty( $sneeit_core_p_created ) ) {
			// dev-reply#24304.
			if ( $sneeit_core_p_post_id ) {
				set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_created[0]->ID );
			}
			// dev-reply#24309.
			continue;
		}
		$sneeit_core_p_file = '';
		$sneeit_core_p_unlink = false;
		if ( ! empty( $sneeit_core_p_item['get'] ) ) {
			// dev-reply#24321.
			$sneeit_core_p_file = sneeit_core_download_image( $sneeit_core_p_item['get'], $sneeit_core_p_post_id );
			// dev-reply#24323.
			if ( empty( $sneeit_core_p_file ) ) {
				// dev-reply#24326.
			}
		}
		if ( empty( $sneeit_core_p_file ) ) {
			// dev-reply#24331.
			if ( $sneeit_core_p_name ) {
				$sneeit_core_p_force_default_id = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH, $sneeit_core_p_post_id, $sneeit_core_p_name );
				if ( $sneeit_core_p_force_default_id ) {
					set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_force_default_id );
					continue;
				}
			}
			// dev-reply#24341.
			if ( ! $sneeit_core_p_default_attachment_id ) {
				$sneeit_core_p_default_attachment_id = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_p_default_attachment_id ) {
				set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_default_attachment_id );
			}
			continue;
		} else {
			$sneeit_core_p_unlink = true;
		}
		// dev-reply#24359.
		$sneeit_core_p_attachment_id = sneeit_core_create_attachment( $sneeit_core_p_file, $sneeit_core_p_post_id, $sneeit_core_p_name );
		if ( ( $sneeit_core_p_attachment_id ) === false ) {
			if ( $sneeit_core_p_unlink ) {
				unlink( $sneeit_core_p_file );
			}
			if ( ! $sneeit_core_p_default_attachment_id ) {
				$sneeit_core_p_default_attachment_id = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_p_default_attachment_id ) {
				set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_default_attachment_id );
			}
			continue;
		}
		set_post_thumbnail( $sneeit_core_p_post_id, $sneeit_core_p_attachment_id );
		update_post_meta( $sneeit_core_p_attachment_id, 'sneeit-demo-id', $sneeit_core_p_id );
		if ( ! empty( $sneeit_core_p_item['get'] ) ) {
			update_post_meta( $sneeit_core_p_attachment_id, 'sneeit-demo', $sneeit_core_p_item['get'] );
		}
	}
	echo json_encode( 'done' );
	die();
}
