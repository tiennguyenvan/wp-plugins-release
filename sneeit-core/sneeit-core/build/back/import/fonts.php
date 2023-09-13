<?php
/**
 * DragBlock's Import.
 *
 * @package Fonts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if( is_admin() ) :
	add_action( 'wp_ajax_nopriv_sneeit_core_demo_import_fonts', 'sneeit_core_demo_import_fonts' );
	add_action( 'wp_ajax_sneeit_core_demo_import_fonts', 'sneeit_core_demo_import_fonts' );
endif; // dev-reply#139.
/**
 * Check Documentation#136
 *
 * @param object|array|string $sneeit_core_0 check var-def#136.
 */
function sneeit_core_demo_get_font_slug( $sneeit_core_0 ) {
	$sneeit_core_1 = sanitize_title( $sneeit_core_0 );
	$sneeit_core_1 = preg_replace( '/\s+/', '', $sneeit_core_1 ); // dev-reply#1313.
	return $sneeit_core_1;
}
/**
 * Check Documentation#1312
 *
 * @param object|array|string $sneeit_core_2 check var-def#1312.
 */
function sneeit_core_has_font_mime_type( $sneeit_core_2 ) {
	$sneeit_core_3 = array(
		'otf'   => 'font/otf',
		'ttf'   => 'font/ttf',
		'woff'  => 'font/woff',
		'woff2' => 'font/woff2',
	);
	$sneeit_core_4 = wp_check_filetype( $sneeit_core_2, $sneeit_core_3 );
	return in_array( $sneeit_core_4['type'], $sneeit_core_3, true );
}
/**
 * Check Documentation#1323
 */
function sneeit_core_demo_import_fonts() {
	sneeit_core_ajax_request_verify_die( 'data' );
	// dev-reply#1333.
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_5 = wp_upload_dir();
	if ( ! is_dir( $sneeit_core_5['basedir'] . '/dragblock/' ) ) {
		if ( ! mkdir( $sneeit_core_5['basedir'] . '/dragblock/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_5['basedir'] . '/dragblock/', 0777 );
	if ( ! is_dir( $sneeit_core_5['basedir'] . '/dragblock/fonts/' ) ) {
		if ( ! mkdir( $sneeit_core_5['basedir'] . '/dragblock/fonts/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock/fonts directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_5['basedir'] . '/dragblock/fonts/', 0777 );
	$sneeit_core_6 = $sneeit_core_5['basedir'] . '/dragblock/fonts/';
	$sneeit_core_7 = $sneeit_core_5['baseurl'] . '/dragblock/fonts/';
	// dev-reply#1355.
	$sneeit_core_8 = $_POST['data'];
	$sneeit_core_9 = array();
	$sneeit_core_10 = sanitize_key( 'dragblockFontLib' );
	$sneeit_core_11 = get_option( $sneeit_core_10 );
	foreach ( $sneeit_core_11 as $sneeit_core_12 => $sneeit_core_13 ) {
		$sneeit_core_9[ $sneeit_core_13["fontFamily"] ] = $sneeit_core_12;
	}
	// dev-reply#1364.
	foreach ( $sneeit_core_8 as $sneeit_core_0 => $sneeit_core_14 ) {
		$sneeit_core_15 = ! isset( $sneeit_core_9[ $sneeit_core_0 ] ) ? [] : $sneeit_core_11[ $sneeit_core_9[ $sneeit_core_0 ] ];
		// dev-reply#1369.
		if ( empty( $sneeit_core_15['fontFamily'] ) ) {
			$sneeit_core_15['fontFamily'] = $sneeit_core_0;
		}
		if ( empty( $sneeit_core_15['slug'] ) ) {
			$sneeit_core_15['slug'] = sneeit_core_demo_get_font_slug( $sneeit_core_0 );
		}
		if ( empty( $sneeit_core_15['fontFace'] ) ) {
			$sneeit_core_15['fontFace'] = array();
		}
		// dev-reply#1381.
		foreach ( $sneeit_core_14 as $sneeit_core_1 => $sneeit_core_16 ) {
			// dev-reply#1383.
			$sneeit_core_17 = strpos( $sneeit_core_1, 'italic' ) !== false ? 'italic' : 'normal';
			$sneeit_core_18 = str_replace( 'italic', '', $sneeit_core_1 );
			if ( ( $sneeit_core_18 ) === '' || ( $sneeit_core_18 ) === 'regular' ) {
				$sneeit_core_18 = '400';
			}
			// dev-reply#1390.
			$sneeit_core_19 = false;
			foreach ( $sneeit_core_15['fontFace'] as $sneeit_core_20 ) {
				if ( empty( $sneeit_core_20['fontStyle'] ) || empty( $sneeit_core_20['fontWeight'] ) ) {
					// dev-reply#1394.
					continue;
				}
				// dev-reply#1398.
				if ( ( $sneeit_core_17 ) === $sneeit_core_20['fontStyle'] && ( $sneeit_core_18 ) === $sneeit_core_20['fontWeight'] ) {
					$sneeit_core_19 = true;
					break;
				}
			}
			// dev-reply#13106.
			if ( $sneeit_core_19 ) {
				continue;
			}
			// dev-reply#13113.
			if ( ! sneeit_core_has_font_mime_type( $sneeit_core_16 ) ) {
				continue;
			}
			// dev-reply#13118.
			$sneeit_core_21 = pathinfo( $sneeit_core_16, PATHINFO_EXTENSION );
			$sneeit_core_22 = $sneeit_core_15['slug'] . '_' . $sneeit_core_17 . '_' . $sneeit_core_18 . '.' . $sneeit_core_21;
			$sneeit_core_23 = $sneeit_core_6 . $sneeit_core_22;
			$sneeit_core_24 = $sneeit_core_7 . $sneeit_core_22;
			$sneeit_core_25 = download_url( $sneeit_core_16 );
			if ( is_wp_error( $sneeit_core_25 ) ) {
				/* translators: see trans-note#13101 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot download font %s', 'sneeit-core' ), $sneeit_core_22 ) );
			}
			// dev-reply#13130.
			if ( ! rename( $sneeit_core_25, $sneeit_core_23 ) ) {
				/* translators: see trans-note#13105 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot copy font %s', 'sneeit-core' ), $sneeit_core_22 ) );
			}
			// dev-reply#13135.
			$sneeit_core_15['fontFace'][] = array(
				'fontFamily' => $sneeit_core_0,
				'fontStyle'  => $sneeit_core_17,
				'fontWeight' => $sneeit_core_18,
				'src'        => array( $sneeit_core_24 ),
			);
		}
		// dev-reply#13143.
		if ( ! isset( $sneeit_core_9[ $sneeit_core_0 ] ) ) {
			$sneeit_core_11[] = $sneeit_core_15;
		} else {
			$sneeit_core_11[ $sneeit_core_9[ $sneeit_core_0 ] ] = $sneeit_core_15;
		}
	}
	// dev-reply#13151.
	update_option( $sneeit_core_10, $sneeit_core_11 );
	echo json_encode( 'done' );
	die();
}
