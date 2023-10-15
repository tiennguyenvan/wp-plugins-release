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
 * @param object|array|string $sneeit_core_l_text check var-def#153.
 */
function sneeit_core_text_to_slug( $sneeit_core_l_text ) {
	$sneeit_core_l_text = str_replace( array( ' ', '/' ), '-', $sneeit_core_l_text );
	$sneeit_core_l_text = strtolower( $sneeit_core_l_text );
	return $sneeit_core_l_text;
}
/**
 * Check Documentation#159
 *
 * @param object|array|string $sneeit_core_l_src check var-def#159.
 */
function sneeit_core_is_image_src( $sneeit_core_l_src ) {
	$sneeit_core_l_src = strtolower( $sneeit_core_l_src );
	return preg_match( "/\.(jpeg|jpg|gif|png)$/", $sneeit_core_l_src );
}
/**
 * Check Documentation#1514
 *
 * @param object|array|string $sneeit_core_l_text check var-def#1514.
 */
function sneeit_core_ajax_error_die( $sneeit_core_l_text ) {
	echo json_encode( array( 'error' => $sneeit_core_l_text ) );
	die();
}
/**
 * Check Documentation#1519
 *
 * @param object|array|string $sneeit_core_l_fields check var-def#1519.
 */
function sneeit_core_ajax_request_verify_die( $sneeit_core_l_fields = array() ) {
	if ( empty( $_POST['nonce'] ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'empty nonce', 'sneeit-core' ) );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], SNEEIT_CORE_KEY_NONCE ) ) {
		sneeit_core_ajax_error_die( esc_html__( 'Timeout! Please reload the page.', 'sneeit-core' ) );
	}
	if ( is_string( $sneeit_core_l_fields ) ) {
		$sneeit_core_l_fields = explode( ',', $sneeit_core_l_fields );
	}
	if ( ! empty( $sneeit_core_l_fields ) ) {
		foreach ( $sneeit_core_l_fields as $sneeit_core_l_post ) {
			$sneeit_core_l_post = trim( $sneeit_core_l_post );
			if ( ! isset( $_POST[ $sneeit_core_l_post ] ) ) {
				/* translators: see trans-note#1534 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'sneeit-core' ), $sneeit_core_l_post ) );
			}
		}
	}
}
/**
 * Check Documentation#1539
 *
 * @param object|array|string $sneeit_core_l_src check var-def#1539.
 * @param object|array|string $sneeit_core_l_field check var-def#1539.
 */
function sneeit_core_unique_image_name( $sneeit_core_l_src, $sneeit_core_l_field = null ) {
	// dev-reply#1549.
	$sneeit_core_l_id = basename( $sneeit_core_l_src );
	$sneeit_core_l_short = pathinfo( $sneeit_core_l_id, PATHINFO_EXTENSION );
	if ( $sneeit_core_l_short ) {
		$sneeit_core_l_short = '.' . $sneeit_core_l_short;
	}
	$sneeit_core_l_id = str_replace( $sneeit_core_l_short, '', $sneeit_core_l_id );
	// dev-reply#1557.
	$sneeit_core_l_id = preg_replace( '/[^a-zA-Z0-9]+/', '-', $sneeit_core_l_id );
	$sneeit_core_l_id = explode( '-', $sneeit_core_l_id );
	// dev-reply#1560.
	$sneeit_core_l_name = '';
	foreach ( $sneeit_core_l_id as $sneeit_core_l_ext ) {
		if ( preg_match( '/\d/', $sneeit_core_l_ext ) ) {
			continue;
		}
		$sneeit_core_l_name .= ( strlen( $sneeit_core_l_name ) ? '-' : '' ) . $sneeit_core_l_ext;
	}
	if ( strlen( $sneeit_core_l_name ) > 50 || strlen( $sneeit_core_l_name ) < 10 ) {
		$sneeit_core_l_finalname = get_post( $sneeit_core_l_field );
		if ( ! empty( $sneeit_core_l_finalname ) && ! empty( $sneeit_core_l_finalname->post_title ) ) {
			$sneeit_core_l_name = sneeit_core_text_to_slug( $sneeit_core_l_finalname->post_title );
		}
	}
	$sneeit_core_l_id = ( $sneeit_core_l_name ? $sneeit_core_l_name . '-' : '' ) . time() . ( $sneeit_core_l_field ? '-' . $sneeit_core_l_field : '' ) . $sneeit_core_l_short;
	return $sneeit_core_l_id;
}
/**
 * Check Documentation#1568
 *
 * @param object|array|string $sneeit_core_l_src check var-def#1568.
 * @param object|array|string $sneeit_core_l_part check var-def#1568.
 */
function sneeit_core_download_image( $sneeit_core_l_src, $sneeit_core_l_part = null ) {
	// dev-reply#1589.
	$sneeit_core_l_download = download_url( $sneeit_core_l_src );
	if ( is_wp_error( $sneeit_core_l_download ) ) {
		// dev-reply#1592.
		return false;
	}
	// dev-reply#1596.
	$sneeit_core_l_path = wp_upload_dir()['path'] . '/' . sneeit_core_unique_image_name( $sneeit_core_l_src, $sneeit_core_l_part );
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	if ( ! rename( $sneeit_core_l_download, $sneeit_core_l_path ) ) {
		unlink( $sneeit_core_l_download );
		return false;
	}
	// dev-reply#15108.
	$sneeit_core_l_short = pathinfo( $sneeit_core_l_path, PATHINFO_EXTENSION );
	$sneeit_core_l_upload = getimagesize( $sneeit_core_l_path );
	if ( empty( $sneeit_core_l_upload ) || count( $sneeit_core_l_upload ) < 2 ) {
		// dev-reply#15114.
		return false;
	}
	$sneeit_core_l_info = (int) $sneeit_core_l_upload[0];
	$sneeit_core_l_width = (int) $sneeit_core_l_upload[1];
	if ( empty( $sneeit_core_l_short ) || ( $sneeit_core_l_short ) === 'webp' || ( $sneeit_core_l_short ) === 'avif' || $sneeit_core_l_info > 2560 || $sneeit_core_l_width > 2560 ) {
		$sneeit_core_l_info = min( (int) $sneeit_core_l_upload[0], 2560 );
		$sneeit_core_l_width = min( (int) $sneeit_core_l_upload[1], 2560 );
		$sneeit_core_l_height = wp_get_image_editor( $sneeit_core_l_path );
		if ( is_wp_error( $sneeit_core_l_height ) ) {
			// dev-reply#15126.
			return false;
		}
		$sneeit_core_l_editor = $sneeit_core_l_height->resize( $sneeit_core_l_info, $sneeit_core_l_width );
		if ( is_wp_error( $sneeit_core_l_editor ) ) {
			// dev-reply#15131.
			return false;
		}
		$sneeit_core_l_resized = $sneeit_core_l_height->save( $sneeit_core_l_height->generate_filename() );
		if ( is_wp_error( $sneeit_core_l_resized ) ) {
			// dev-reply#15136.
			return false;
		}
		if ( ( $sneeit_core_l_path ) !== $sneeit_core_l_resized['path'] ) {
			unlink( $sneeit_core_l_path );
			$sneeit_core_l_path = $sneeit_core_l_resized['path'];
		}
	}
	return $sneeit_core_l_path;
}
/**
 * Check Documentation#15118
 *
 * @param object|array|string $sneeit_core_l_saved check var-def#15118.
 */
function sneeit_core_plugin_install_file( $sneeit_core_l_saved ) {
	// dev-reply#15151.
	$sneeit_core_l_slug = WP_PLUGIN_DIR . '/' . $sneeit_core_l_saved . '/';
	if ( file_exists( $sneeit_core_l_slug . $sneeit_core_l_saved . '.php' ) ) {
		$sneeit_core_l_plugin = file_get_contents( $sneeit_core_l_slug . $sneeit_core_l_saved . '.php' );
		if ( $sneeit_core_l_plugin && strpos( $sneeit_core_l_plugin, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_l_slug . $sneeit_core_l_saved . '.php';
		}
	}
	// dev-reply#15160.
	$sneeit_core_l_file = glob( WP_PLUGIN_DIR . '/' . $sneeit_core_l_saved . '/*.php' );
	foreach ( $sneeit_core_l_file as $sneeit_core_l_content ) {
		$sneeit_core_l_plugin = file_get_contents( $sneeit_core_l_content );
		if ( $sneeit_core_l_plugin && strpos( $sneeit_core_l_plugin, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_l_content;
		}
	}
	return '';
}
/**
 * Check Documentation#15138
 */
function sneeit_core_is_license_required() {
	$sneeit_core_l_paths = wp_get_theme();
	$sneeit_core_l_theme = $sneeit_core_l_paths->get( 'UpdateURI' );
	// dev-reply#15177.
	return ( ! empty( $sneeit_core_l_theme ) &&
		strpos( $sneeit_core_l_theme, '://sneeit.com' ) &&
		empty( implode(
			'',
			explode(
				'/',
				explode( '://sneeit.com', $sneeit_core_l_theme )[1]
			)
		) )
	);
}
