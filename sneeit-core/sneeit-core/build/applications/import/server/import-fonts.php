<?php
/**
 * DragBlock's Import.
 *
 * @package Import fonts
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
 * @param object|array|string $sneeit_core_if_name check var-def#136.
 */
function sneeit_core_demo_get_font_slug( $sneeit_core_if_name ) {
	$sneeit_core_if_slug = sanitize_title( $sneeit_core_if_name );
	$sneeit_core_if_slug = preg_replace( '/\s+/', '', $sneeit_core_if_slug ); // dev-reply#1313.
	return $sneeit_core_if_slug;
}
/**
 * Check Documentation#1312
 *
 * @param object|array|string $sneeit_core_if_file check var-def#1312.
 */
function sneeit_core_has_font_mime_type( $sneeit_core_if_file ) {
	$sneeit_core_if_allowed = array(
		'otf'   => 'font/otf',
		'ttf'   => 'font/ttf',
		'woff'  => 'font/woff',
		'woff2' => 'font/woff2',
	);
	$sneeit_core_if_font = wp_check_filetype( $sneeit_core_if_file, $sneeit_core_if_allowed );
	return in_array( $sneeit_core_if_font['type'], $sneeit_core_if_allowed, true );
}
/**
 * Check Documentation#1323
 */
function sneeit_core_demo_import_fonts() {
	sneeit_core_ajax_request_verify_die( 'data' );
	// dev-reply#1333.
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	$sneeit_core_if_mime = wp_upload_dir();
	if ( ! is_dir( $sneeit_core_if_mime['basedir'] . '/dragblock/' ) ) {
		if ( ! mkdir( $sneeit_core_if_mime['basedir'] . '/dragblock/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_if_mime['basedir'] . '/dragblock/', 0777 );
	if ( ! is_dir( $sneeit_core_if_mime['basedir'] . '/dragblock/fonts/' ) ) {
		if ( ! mkdir( $sneeit_core_if_mime['basedir'] . '/dragblock/fonts/', 0777 ) ) {
			sneeit_core_ajax_error_die( esc_html__( 'Cannot create dragblock/fonts directory', 'sneeit-core' ) );
		}
	}
	chmod( $sneeit_core_if_mime['basedir'] . '/dragblock/fonts/', 0777 );
	$sneeit_core_if_types = $sneeit_core_if_mime['basedir'] . '/dragblock/fonts/';
	$sneeit_core_if_filetype = $sneeit_core_if_mime['baseurl'] . '/dragblock/fonts/';
	// dev-reply#1355.
	$sneeit_core_if_upload = $_POST['data'];
	$sneeit_core_if_dir = array();
	$sneeit_core_if_url = sanitize_key( 'dragblockFontLib' );
	$sneeit_core_if_fonts = get_option( $sneeit_core_if_url );
	foreach ( $sneeit_core_if_fonts as $sneeit_core_if_post => $sneeit_core_if_hash ) {
		$sneeit_core_if_dir[ $sneeit_core_if_hash["fontFamily"] ] = $sneeit_core_if_post;
	}
	// dev-reply#1364.
	foreach ( $sneeit_core_if_upload as $sneeit_core_if_name => $sneeit_core_if_dragblockkey ) {
		$sneeit_core_if_dragblockoption = ! isset( $sneeit_core_if_dir[ $sneeit_core_if_name ] ) ? [] : $sneeit_core_if_fonts[ $sneeit_core_if_dir[ $sneeit_core_if_name ] ];
		// dev-reply#1369.
		if ( empty( $sneeit_core_if_dragblockoption['fontFamily'] ) ) {
			$sneeit_core_if_dragblockoption['fontFamily'] = $sneeit_core_if_name;
		}
		if ( empty( $sneeit_core_if_dragblockoption['slug'] ) ) {
			$sneeit_core_if_dragblockoption['slug'] = sneeit_core_demo_get_font_slug( $sneeit_core_if_name );
		}
		if ( empty( $sneeit_core_if_dragblockoption['fontFace'] ) ) {
			$sneeit_core_if_dragblockoption['fontFace'] = array();
		}
		// dev-reply#1381.
		foreach ( $sneeit_core_if_dragblockkey as $sneeit_core_if_slug => $sneeit_core_if_key ) {
			// dev-reply#1383.
			$sneeit_core_if_value = strpos( $sneeit_core_if_slug, 'italic' ) !== false ? 'italic' : 'normal';
			$sneeit_core_if_faces = str_replace( 'italic', '', $sneeit_core_if_slug );
			if ( ( $sneeit_core_if_faces ) === '' || ( $sneeit_core_if_faces ) === 'regular' ) {
				$sneeit_core_if_faces = '400';
			}
			// dev-reply#1390.
			$sneeit_core_if_style = false;
			foreach ( $sneeit_core_if_dragblockoption['fontFace'] as $sneeit_core_if_weight ) {
				if ( empty( $sneeit_core_if_weight['fontStyle'] ) || empty( $sneeit_core_if_weight['fontWeight'] ) ) {
					// dev-reply#1394.
					continue;
				}
				// dev-reply#1398.
				if ( ( $sneeit_core_if_value ) === $sneeit_core_if_weight['fontStyle'] && ( $sneeit_core_if_faces ) === $sneeit_core_if_weight['fontWeight'] ) {
					$sneeit_core_if_style = true;
					break;
				}
			}
			// dev-reply#13106.
			if ( $sneeit_core_if_style ) {
				continue;
			}
			// dev-reply#13113.
			if ( ! sneeit_core_has_font_mime_type( $sneeit_core_if_key ) ) {
				continue;
			}
			// dev-reply#13118.
			$sneeit_core_if_existed = pathinfo( $sneeit_core_if_key, PATHINFO_EXTENSION );
			$sneeit_core_if_face = $sneeit_core_if_dragblockoption['slug'] . '_' . $sneeit_core_if_value . '_' . $sneeit_core_if_faces . '.' . $sneeit_core_if_existed;
			$sneeit_core_if_extension = $sneeit_core_if_types . $sneeit_core_if_face;
			$sneeit_core_if_path = $sneeit_core_if_filetype . $sneeit_core_if_face;
			$sneeit_core_if_temp = download_url( $sneeit_core_if_key );
			if ( is_wp_error( $sneeit_core_if_temp ) ) {
				/* translators: see trans-note#13101 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot download font %s', 'sneeit-core' ), $sneeit_core_if_face ) );
			}
			// dev-reply#13130.
			if ( ! rename( $sneeit_core_if_temp, $sneeit_core_if_extension ) ) {
				/* translators: see trans-note#13105 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Cannot copy font %s', 'sneeit-core' ), $sneeit_core_if_face ) );
			}
			// dev-reply#13135.
			$sneeit_core_if_dragblockoption['fontFace'][] = array(
				'fontFamily' => $sneeit_core_if_name,
				'fontStyle'  => $sneeit_core_if_value,
				'fontWeight' => $sneeit_core_if_faces,
				'src'        => array( $sneeit_core_if_path ),
			);
		}
		// dev-reply#13143.
		if ( ! isset( $sneeit_core_if_dir[ $sneeit_core_if_name ] ) ) {
			$sneeit_core_if_fonts[] = $sneeit_core_if_dragblockoption;
		} else {
			$sneeit_core_if_fonts[ $sneeit_core_if_dir[ $sneeit_core_if_name ] ] = $sneeit_core_if_dragblockoption;
		}
	}
	// dev-reply#13151.
	update_option( $sneeit_core_if_url, $sneeit_core_if_fonts );
	echo json_encode( 'done' );
	die();
}
