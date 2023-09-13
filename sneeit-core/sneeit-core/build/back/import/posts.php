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
	$sneeit_core_0 = $_POST['data'];
	$sneeit_core_1 = $_POST['slug'];
	// dev-reply#2419.
	if ( ( $sneeit_core_1 ) === 'attachment' ) {
		return sneeit_core_demo_import_attachments( $sneeit_core_0 );
	}
	// dev-reply#2424.
	if ( ( $sneeit_core_1 ) === 'post' ) {
		// dev-reply#2426.
		$sneeit_core_2 = get_posts( array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'title' => 'Hello world!',
			'post_name__in' => 'hello-world',
			'posts_per_page' => 1,
		) );
		foreach ( $sneeit_core_2 as $sneeit_core_3 ) {
			wp_delete_post( $sneeit_core_3->ID, true );
		}
	}
	// dev-reply#2438.
	$sneeit_core_4 = get_posts( array(
		'post_type'      => $sneeit_core_1,
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
	foreach ( $sneeit_core_4 as $sneeit_core_5 ) {
		wp_delete_post( $sneeit_core_5->ID, true );
	}
	// dev-reply#2455.
	foreach ( $sneeit_core_0 as $sneeit_core_6 => $sneeit_core_7 ) {
		$sneeit_core_6 = (int) $sneeit_core_6;
		if ( empty( $sneeit_core_7['title'] ) || empty( $sneeit_core_7['name'] ) ) {
			continue;
		}
		// dev-reply#2461.
		if ( ( $sneeit_core_1 ) === 'page' || ( $sneeit_core_1 ) === 'post' ) {
			wp_delete_post( $sneeit_core_6, true );
		}
		// dev-reply#2466.
		$sneeit_core_4 = get_posts( array(
			'post_type'      => $sneeit_core_1,
			// dev-reply#2469.
			'title' => $sneeit_core_7['title'],
			// dev-reply#2471.
			'posts_per_page' => - 1,
		) );
		foreach ( $sneeit_core_4 as $sneeit_core_5 ) {
			// dev-reply#2476.
			wp_delete_post( $sneeit_core_5->ID, true );
		}
	}
	// dev-reply#2482.
	$sneeit_core_8 = 100; // dev-reply#2483.
	$sneeit_core_9 = time() - count( $sneeit_core_0 ) * $sneeit_core_8;
	$sneeit_core_10 = 0;
	foreach ( $sneeit_core_0 as $sneeit_core_6 => $sneeit_core_7 ) {
		$sneeit_core_6 = (int) $sneeit_core_6;
		if ( empty( $sneeit_core_7['title'] ) || empty( $sneeit_core_7['name'] ) ) {
			/* translators: see trans-note#2475 */
			sneeit_core_ajax_error_die( sprintf( esc_html__( 'Wrong %1$s Args %2$s', 'sneeit-core' ), $sneeit_core_1, $sneeit_core_6 ) );
		}
		$sneeit_core_11 = date( 'Y-m-d H:i:s', $sneeit_core_9 + $sneeit_core_10 * $sneeit_core_8 );
		$sneeit_core_12 = array(
			'import_id' => $sneeit_core_6,
			'post_status' => 'publish',
			'post_type' => $sneeit_core_1,
			// dev-reply#2498.
			'post_date' => date( 'Y-m-d H:i:s', $sneeit_core_9 + $sneeit_core_10 * $sneeit_core_8 ),
			'post_date_gmt' => get_gmt_from_date( $sneeit_core_11 ),
		);
		$sneeit_core_10++;
		if ( ! empty( $sneeit_core_7['title'] ) ) {
			$sneeit_core_12['post_title'] = $sneeit_core_7['title'];
		}
		if ( ! empty( $sneeit_core_7['content'] ) ) {
			$sneeit_core_12['post_content'] = $sneeit_core_7['content'];
		}
		if ( ! empty( $sneeit_core_7['name'] ) ) {
			$sneeit_core_12['post_name'] = $sneeit_core_7['name'];
		}
		// dev-reply#24116.
		$sneeit_core_13 = wp_insert_post( $sneeit_core_12, true );
		if ( is_wp_error( $sneeit_core_13 ) ) {
			continue;
			// dev-reply#24124.
		}
		if ( ( $sneeit_core_1 ) === 'page' || ( $sneeit_core_1 ) === 'posts' ) {
			global $wpdb;
			$sneeit_core_14 = $wpdb->prefix . 'posts';
			if (
				! empty( $wpdb->update(
					$sneeit_core_14,
					array( 'ID' => $sneeit_core_6 ),
					array( 'ID' => $sneeit_core_13 )
				) )
			) {
				$sneeit_core_13 = $sneeit_core_6;
			}
		}
		// dev-reply#24153.
		update_post_meta( $sneeit_core_13, 'sneeit-demo-id', $sneeit_core_6 );
		if ( ! empty( $sneeit_core_7['meta'] ) ) {
			foreach ( $sneeit_core_7['meta'] as $sneeit_core_15 => $sneeit_core_16 ) {
				update_post_meta( $sneeit_core_13, $sneeit_core_15, $sneeit_core_16 );
			}
		}
		// dev-reply#24163.
		if ( ! empty( $sneeit_core_7['terms'] ) ) {
			foreach ( $sneeit_core_7['terms'] as $sneeit_core_17 ) {
				$sneeit_core_18 = get_term( $sneeit_core_17 );
				if ( empty( $sneeit_core_18 ) || is_wp_error( $sneeit_core_18 ) ) {
					continue;
				}
				// dev-reply#24171.
				wp_set_post_terms( $sneeit_core_13, array( (int) $sneeit_core_17 ), $sneeit_core_18->taxonomy, true );
			}
		}
		// dev-reply#24176.
		if ( ( $sneeit_core_1 ) === 'wp_template' || ( $sneeit_core_1 ) === 'wp_template_part' || ( $sneeit_core_1 ) === 'wp_global_styles' ) {
			$sneeit_core_19 = array(
				'wp_theme' => array( get_stylesheet() ),
			);
			if ( ( $sneeit_core_1 ) === 'wp_template_part' && ! empty( $sneeit_core_7['area'] ) ) {
				$sneeit_core_19['wp_template_part_area'] = array( $sneeit_core_7['area'] );
			}
			foreach ( $sneeit_core_19 as $sneeit_core_20 => $sneeit_core_21 ) {
				foreach ( $sneeit_core_21 as $sneeit_core_22 ) {
					// dev-reply#24189.
					$sneeit_core_18 = wp_create_term( $sneeit_core_22, $sneeit_core_20 );
					if ( is_wp_error( $sneeit_core_18 ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24147 */
							sprintf(
								esc_html__( 'In %1$s (#%2$s/%3$s), cannot create %4$s for %5$s): %6$s', 'sneeit-core' ),
								$sneeit_core_1,
								$sneeit_core_13,
								$sneeit_core_6,
								$sneeit_core_22,
								$sneeit_core_20,
								$sneeit_core_18->get_error_message()
							)
						);
					}
					// dev-reply#24207.
					$sneeit_core_23 = wp_set_object_terms( $sneeit_core_13, array( (int) $sneeit_core_18['term_id'] ), $sneeit_core_20 );
					if ( is_wp_error( $sneeit_core_23 ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24162 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s: %6$s', 'sneeit-core' ),
								$sneeit_core_1,
								$sneeit_core_22,
								$sneeit_core_20,
								$sneeit_core_13,
								$sneeit_core_6,
								$sneeit_core_18->get_error_message()
							)
						);
					}
					if ( empty( $sneeit_core_23 ) ) {
						sneeit_core_ajax_error_die(
							/* translators: see trans-note#24175 */
							sprintf(
								esc_html__( 'In %1$s, cannot set %4$s of %5$s for #%2$s/%3$s', 'sneeit-core' ),
								$sneeit_core_1,
								$sneeit_core_22,
								$sneeit_core_20,
								$sneeit_core_13,
								$sneeit_core_6,
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
 * @param object|array|string $sneeit_core_0 check var-def#24193.
 */
function sneeit_core_demo_import_attachments( $sneeit_core_0 ) {
	// dev-reply#24261.
	$sneeit_core_24 = null;
	$sneeit_core_25 = get_posts( array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'posts_per_page' => 1,
	) );
	// dev-reply#24270.
	if ( ! empty( $sneeit_core_25 ) ) {
		$sneeit_core_24 = $sneeit_core_25[0]->ID;
	}
	foreach ( $sneeit_core_0 as $sneeit_core_6 => $sneeit_core_7 ) {
		$sneeit_core_6 = (int) $sneeit_core_6;
		$sneeit_core_26 = $sneeit_core_7['name'] ? $sneeit_core_7['name'] : null;
		// dev-reply#24278.
		$sneeit_core_13 = sneeit_core_get_demo_post_id( $sneeit_core_7['parent'] );
		// dev-reply#24287.
		$sneeit_core_27 = get_posts( array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key' => 'sneeit-demo-id',
			'meta_value' => $sneeit_core_6,
			'meta_compare' => '=',
		) );
		if ( ! empty( $sneeit_core_27 ) ) {
			// dev-reply#24304.
			if ( $sneeit_core_13 ) {
				set_post_thumbnail( $sneeit_core_13, $sneeit_core_27[0]->ID );
			}
			// dev-reply#24309.
			continue;
		}
		$sneeit_core_28 = '';
		$sneeit_core_29 = false;
		if ( ! empty( $sneeit_core_7['get'] ) ) {
			// dev-reply#24321.
			$sneeit_core_28 = sneeit_core_download_image( $sneeit_core_7['get'], $sneeit_core_13 );
			// dev-reply#24323.
			if ( empty( $sneeit_core_28 ) ) {
				// dev-reply#24326.
			}
		}
		if ( empty( $sneeit_core_28 ) ) {
			// dev-reply#24331.
			if ( $sneeit_core_26 ) {
				$sneeit_core_30 = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH, $sneeit_core_13, $sneeit_core_26 );
				if ( $sneeit_core_30 ) {
					set_post_thumbnail( $sneeit_core_13, $sneeit_core_30 );
					continue;
				}
			}
			// dev-reply#24341.
			if ( ! $sneeit_core_24 ) {
				$sneeit_core_24 = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_24 ) {
				set_post_thumbnail( $sneeit_core_13, $sneeit_core_24 );
			}
			continue;
		} else {
			$sneeit_core_29 = true;
		}
		// dev-reply#24359.
		$sneeit_core_31 = sneeit_core_create_attachment( $sneeit_core_28, $sneeit_core_13, $sneeit_core_26 );
		if ( ( $sneeit_core_31 ) === false ) {
			if ( $sneeit_core_29 ) {
				unlink( $sneeit_core_28 );
			}
			if ( ! $sneeit_core_24 ) {
				$sneeit_core_24 = sneeit_core_create_attachment( SNEEIT_CORE_BLANK_IMAGE_PATH );
			}
			if ( $sneeit_core_24 ) {
				set_post_thumbnail( $sneeit_core_13, $sneeit_core_24 );
			}
			continue;
		}
		set_post_thumbnail( $sneeit_core_13, $sneeit_core_31 );
		update_post_meta( $sneeit_core_31, 'sneeit-demo-id', $sneeit_core_6 );
		if ( ! empty( $sneeit_core_7['get'] ) ) {
			update_post_meta( $sneeit_core_31, 'sneeit-demo', $sneeit_core_7['get'] );
		}
	}
	echo json_encode( 'done' );
	die();
}
