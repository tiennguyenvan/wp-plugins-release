<?php
/**
 * DragBlock's General.
 *
 * @package Lib
 */

if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Check Documentation#153
 *
 * @param object|array|string $sneeit_core_0 check var-def#153.
 */
function sneeit_core_text_to_slug( $sneeit_core_0 ) {
	$sneeit_core_0 = str_replace( array( ' ', '/' ), '-', $sneeit_core_0 );
	$sneeit_core_0 = strtolower( $sneeit_core_0 );
	return $sneeit_core_0;
}
/**
 * Check Documentation#159
 *
 * @param object|array|string $sneeit_core_1 check var-def#159.
 */
function sneeit_core_is_image_src( $sneeit_core_1 ) {
	$sneeit_core_1 = strtolower( $sneeit_core_1 );
	return preg_match( "/\.(jpeg|jpg|gif|png)$/", $sneeit_core_1 );
}
/**
 * Check Documentation#1514
 *
 * @param object|array|string $sneeit_core_0 check var-def#1514.
 */
function sneeit_core_ajax_error_die( $sneeit_core_0 ) {
	echo json_encode( array( 'error' => $sneeit_core_0 ) );
	die();
}
/**
 * Check Documentation#1519
 *
 * @param object|array|string $sneeit_core_2 check var-def#1519.
 */
function sneeit_core_ajax_request_verify_die( $sneeit_core_2 = array() ) {
	if ( empty( $_POST['nonce'] ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'empty nonce', 'sneeit-core' ) );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], SNEEIT_CORE_KEY_NONCE ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'Timeout! Please reload the page.', 'sneeit-core' ) );
	}
	if ( is_string( $sneeit_core_2 ) ) {
		$sneeit_core_2 = explode( ',', $sneeit_core_2 );
	}
	if ( ! empty( $sneeit_core_2 ) ) {
		foreach ( $sneeit_core_2 as $sneeit_core_3 ) {
			$sneeit_core_3 = trim( $sneeit_core_3 );
			if ( empty( $_POST[ $sneeit_core_3 ] ) ) {
				/* translators: see trans-note#1534 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'sneeit-core' ), $sneeit_core_3 ) );
			}
		}
	}
}
/**
 * Check Documentation#1539
 *
 * @param object|array|string $sneeit_core_1 check var-def#1539.
 * @param object|array|string $sneeit_core_4 check var-def#1539.
 */
function sneeit_core_unique_image_name( $sneeit_core_1, $sneeit_core_4 = null ) {
	// dev-reply#1549.
	$sneeit_core_5 = basename( $sneeit_core_1 );
	$sneeit_core_6 = pathinfo( $sneeit_core_5, PATHINFO_EXTENSION );
	if ( $sneeit_core_6 ) {
		$sneeit_core_6 = '.' . $sneeit_core_6;
	}
	$sneeit_core_5 = str_replace( $sneeit_core_6, '', $sneeit_core_5 );
	// dev-reply#1557.
	$sneeit_core_5 = preg_replace( '/[^a-zA-Z0-9]+/', '-', $sneeit_core_5 );
	$sneeit_core_5 = explode( '-', $sneeit_core_5 );
	// dev-reply#1560.
	$sneeit_core_7 = '';
	foreach ( $sneeit_core_5 as $sneeit_core_8 ) {
		if ( preg_match( '/\d/', $sneeit_core_8 ) ) {
			continue;
		}
		$sneeit_core_7 .= ( strlen( $sneeit_core_7 ) ? '-' : '' ) . $sneeit_core_8;
	}
	if ( strlen( $sneeit_core_7 ) > 50 || strlen( $sneeit_core_7 ) < 10 ) {
		$sneeit_core_9 = get_post( $sneeit_core_4 );
		if ( ! empty( $sneeit_core_9 ) && ! empty( $sneeit_core_9->post_title ) ) {
			$sneeit_core_7 = sneeit_core_text_to_slug( $sneeit_core_9->post_title );
		}
	}
	$sneeit_core_5 = ( $sneeit_core_7 ? $sneeit_core_7 . '-' : '' ) . time() . ( $sneeit_core_4 ? '-' . $sneeit_core_4 : '' ) . $sneeit_core_6;
	return $sneeit_core_5;
}
/**
 * Check Documentation#1568
 *
 * @param object|array|string $sneeit_core_1 check var-def#1568.
 * @param object|array|string $sneeit_core_10 check var-def#1568.
 */
function sneeit_core_download_image( $sneeit_core_1, $sneeit_core_10 = null ) {
	// dev-reply#1589.
	$sneeit_core_11 = download_url( $sneeit_core_1 );
	if ( is_wp_error( $sneeit_core_11 ) ) {
		// dev-reply#1592.
		return false;
	}
	// dev-reply#1596.
	$sneeit_core_12 = wp_upload_dir()['path'] . '/' . sneeit_core_unique_image_name( $sneeit_core_1, $sneeit_core_10 );
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	if ( ! rename( $sneeit_core_11, $sneeit_core_12 ) ) {
		unlink( $sneeit_core_11 );
		return false;
	}
	// dev-reply#15108.
	$sneeit_core_6 = pathinfo( $sneeit_core_12, PATHINFO_EXTENSION );
	$sneeit_core_13 = getimagesize( $sneeit_core_12 );
	if ( empty( $sneeit_core_13 ) || count( $sneeit_core_13 ) < 2 ) {
		// dev-reply#15114.
		return false;
	}
	$sneeit_core_14 = (int) $sneeit_core_13[0];
	$sneeit_core_15 = (int) $sneeit_core_13[1];
	if ( empty( $sneeit_core_6 ) || ( $sneeit_core_6 ) === 'webp' || ( $sneeit_core_6 ) === 'avif' || $sneeit_core_14 > 2560 || $sneeit_core_15 > 2560 ) {
		$sneeit_core_14 = min( (int) $sneeit_core_13[0], 2560 );
		$sneeit_core_15 = min( (int) $sneeit_core_13[1], 2560 );
		$sneeit_core_16 = wp_get_image_editor( $sneeit_core_12 );
		if ( is_wp_error( $sneeit_core_16 ) ) {
			// dev-reply#15126.
			return false;
		}
		$sneeit_core_17 = $sneeit_core_16->resize( $sneeit_core_14, $sneeit_core_15 );
		if ( is_wp_error( $sneeit_core_17 ) ) {
			// dev-reply#15131.
			return false;
		}
		$sneeit_core_18 = $sneeit_core_16->save( $sneeit_core_16->generate_filename() );
		if ( is_wp_error( $sneeit_core_18 ) ) {
			// dev-reply#15136.
			return false;
		}
		if ( ( $sneeit_core_12 ) !== $sneeit_core_18['path'] ) {
			unlink( $sneeit_core_12 );
			$sneeit_core_12 = $sneeit_core_18['path'];
		}
	}
	return $sneeit_core_12;
}
/**
 * Check Documentation#15118
 *
 * @param object|array|string $sneeit_core_19 check var-def#15118.
 */
function sneeit_core_plugin_install_file( $sneeit_core_19 ) {
	// dev-reply#15151.
	$sneeit_core_20 = WP_PLUGIN_DIR . '/' . $sneeit_core_19 . '/';
	if ( file_exists( $sneeit_core_20 . $sneeit_core_19 . '.php' ) ) {
		$sneeit_core_21 = file_get_contents( $sneeit_core_20 . $sneeit_core_19 . '.php' );
		if ( $sneeit_core_21 && strpos( $sneeit_core_21, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_20 . $sneeit_core_19 . '.php';
		}
	}
	// dev-reply#15160.
	$sneeit_core_22 = glob( WP_PLUGIN_DIR . '/' . $sneeit_core_19 . '/*.php' );
	foreach ( $sneeit_core_22 as $sneeit_core_23 ) {
		$sneeit_core_21 = file_get_contents( $sneeit_core_23 );
		if ( $sneeit_core_21 && strpos( $sneeit_core_21, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_23;
		}
	}
	return '';
}
/**
 * Check Documentation#15138
 */
function sneeit_core_is_license_required() {
	$sneeit_core_24 = wp_get_theme();
	$sneeit_core_25 = $sneeit_core_24->get( 'UpdateURI' );
	// dev-reply#15177.
	return ( ! empty( $sneeit_core_25 ) &&
		strpos( $sneeit_core_25, '://sneeit.com' ) &&
		empty( implode(
			'',
			explode(
				'/',
				explode( '://sneeit.com', $sneeit_core_25 )[1]
			)
		) )
	);
}
