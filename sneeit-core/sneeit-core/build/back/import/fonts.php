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
 * @param object|array|string $sneeit_core_f_name check var-def#136.
 */
function sneeit_core_demo_get_font_slug( $sneeit_core_f_name ) {
	$sneeit_core_f_slug = sanitize_title( $sneeit_core_f_name );
	$sneeit_core_f_slug = preg_replace( '/\s+/', '', $sneeit_core_f_slug ); // dev-reply#1313.
	return $sneeit_core_f_slug;
}
/**
 * Check Documentation#1312
 *
 * @param object|array|string $sneeit_core_f_file check var-def#1312.
 */
function sneeit_core_has_font_mime_type( $sneeit_core_f_file ) {
	$sneeit_core_f_allowed_font_mime_types = array(
		'otf'   => 'font/otf',
		'ttf'   => 'font/ttf',
		'woff'  => 'font/woff',
		'woff2' => 'font/woff2',
	);
	$sneeit_core_f_filetype = wp_check_filetype( $sneeit_core_f_file, $sneeit_core_f_allowed_font_mime_types );
	return in_array( $sneeit_core_f_filetype['type'], $sneeit_core_f_allowed_font_mime_types, true );
}
/**
 * Check Documentation#1323
 */
function sneeit_core_demo_import_fonts() {
	sneeit_core_ajax_request_verify_die( 'data' );
	// dev-reply#1333.
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_f_upload_dir = wp_upload_dir();
	if ( ! is_dir( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/' ) ) {
		if ( ! mkdir( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/', 0777 );
	if ( ! is_dir( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/fonts/' ) ) {
		if ( ! mkdir( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/fonts/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock/fonts directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_f_upload_dir['basedir'] . '/dragblock/fonts/', 0777 );
	$sneeit_core_f_font_dir = $sneeit_core_f_upload_dir['basedir'] . '/dragblock/fonts/';
	$sneeit_core_f_font_url = $sneeit_core_f_upload_dir['baseurl'] . '/dragblock/fonts/';
	// dev-reply#1355.
	$sneeit_core_f_fonts = $_POST['data'];
	$sneeit_core_f_hash = array();
	$sneeit_core_f_dragblockkey = sanitize_key( 'dragblockFontLib' );
	$sneeit_core_f_dragblockoption = get_option( $sneeit_core_f_dragblockkey );
	foreach ( $sneeit_core_f_dragblockoption as $sneeit_core_f_key => $sneeit_core_f_value ) {
		$sneeit_core_f_hash[ $sneeit_core_f_value["fontFamily"] ] = $sneeit_core_f_key;
	}
	// dev-reply#1364.
	foreach ( $sneeit_core_f_fonts as $sneeit_core_f_name => $sneeit_core_f_faces ) {
		$sneeit_core_f_font = ! isset( $sneeit_core_f_hash[ $sneeit_core_f_name ] ) ? [] : $sneeit_core_f_dragblockoption[ $sneeit_core_f_hash[ $sneeit_core_f_name ] ];
		// dev-reply#1369.
		if ( empty( $sneeit_core_f_font['fontFamily'] ) ) {
			$sneeit_core_f_font['fontFamily'] = $sneeit_core_f_name;
		}
		if ( empty( $sneeit_core_f_font['slug'] ) ) {
			$sneeit_core_f_font['slug'] = sneeit_core_demo_get_font_slug( $sneeit_core_f_name );
		}
		if ( empty( $sneeit_core_f_font['fontFace'] ) ) {
			$sneeit_core_f_font['fontFace'] = array();
		}
		// dev-reply#1381.
		foreach ( $sneeit_core_f_faces as $sneeit_core_f_slug => $sneeit_core_f_url ) {
			// dev-reply#1383.
			$sneeit_core_f_style = strpos( $sneeit_core_f_slug, 'italic' ) !== false ? 'italic' : 'normal';
			$sneeit_core_f_weight = str_replace( 'italic', '', $sneeit_core_f_slug );
			if ( ( $sneeit_core_f_weight ) === '' || ( $sneeit_core_f_weight ) === 'regular' ) {
				$sneeit_core_f_weight = '400';
			}
			// dev-reply#1390.
			$sneeit_core_f_existed = false;
			foreach ( $sneeit_core_f_font['fontFace'] as $sneeit_core_f_face ) {
				if ( empty( $sneeit_core_f_face['fontStyle'] ) || empty( $sneeit_core_f_face['fontWeight'] ) ) {
					// dev-reply#1394.
					continue;
				}
				// dev-reply#1398.
				if ( ( $sneeit_core_f_style ) === $sneeit_core_f_face['fontStyle'] && ( $sneeit_core_f_weight ) === $sneeit_core_f_face['fontWeight'] ) {
					$sneeit_core_f_existed = true;
					break;
				}
			}
			// dev-reply#13106.
			if ( $sneeit_core_f_existed ) {
				continue;
			}
			// dev-reply#13113.
			if ( ! sneeit_core_has_font_mime_type( $sneeit_core_f_url ) ) {
				continue;
			}
			// dev-reply#13118.
			$sneeit_core_f_file_extension = pathinfo( $sneeit_core_f_url, PATHINFO_EXTENSION );
			$sneeit_core_f_file_name = $sneeit_core_f_font['slug'] . '_' . $sneeit_core_f_style . '_' . $sneeit_core_f_weight . '.' . $sneeit_core_f_file_extension;
			$sneeit_core_f_file_path = $sneeit_core_f_font_dir . $sneeit_core_f_file_name;
			$sneeit_core_f_file_url = $sneeit_core_f_font_url . $sneeit_core_f_file_name;
			$sneeit_core_f_temp_file = download_url( $sneeit_core_f_url );
			if ( is_wp_error( $sneeit_core_f_temp_file ) ) {
				/* translators: see trans-note#13101 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot download font %s', 'sneeit-core' ), $sneeit_core_f_file_name ) );
			}
			// dev-reply#13130.
			if ( ! rename( $sneeit_core_f_temp_file, $sneeit_core_f_file_path ) ) {
				/* translators: see trans-note#13105 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot copy font %s', 'sneeit-core' ), $sneeit_core_f_file_name ) );
			}
			// dev-reply#13135.
			$sneeit_core_f_font['fontFace'][] = array(
				'fontFamily' => $sneeit_core_f_name,
				'fontStyle'  => $sneeit_core_f_style,
				'fontWeight' => $sneeit_core_f_weight,
				'src'        => array( $sneeit_core_f_file_url ),
			);
		}
		// dev-reply#13143.
		if ( ! isset( $sneeit_core_f_hash[ $sneeit_core_f_name ] ) ) {
			$sneeit_core_f_dragblockoption[] = $sneeit_core_f_font;
		} else {
			$sneeit_core_f_dragblockoption[ $sneeit_core_f_hash[ $sneeit_core_f_name ] ] = $sneeit_core_f_font;
		}
	}
	// dev-reply#13151.
	update_option( $sneeit_core_f_dragblockkey, $sneeit_core_f_dragblockoption );
	echo json_encode( 'done' );
	die();
}
