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
		foreach ( $sneeit_core_l_fields as $sneeit_core_l_field ) {
			$sneeit_core_l_field = trim( $sneeit_core_l_field );
			if ( empty( $_POST[ $sneeit_core_l_field ] ) ) {
				/* translators: see trans-note#1534 */
				sneeit_core_ajax_error_die( sprintf( esc_html__( 'Missing required field: %s', 'sneeit-core' ), $sneeit_core_l_field ) );
			}
		}
	}
}
/**
 * Check Documentation#1539
 *
 * @param object|array|string $sneeit_core_l_src check var-def#1539.
 * @param object|array|string $sneeit_core_l_post_id check var-def#1539.
 */
function sneeit_core_unique_image_name( $sneeit_core_l_src, $sneeit_core_l_post_id = null ) {
	// dev-reply#1549.
	$sneeit_core_l_short_name = basename( $sneeit_core_l_src );
	$sneeit_core_l_ext = pathinfo( $sneeit_core_l_short_name, PATHINFO_EXTENSION );
	if ( $sneeit_core_l_ext ) {
		$sneeit_core_l_ext = '.' . $sneeit_core_l_ext;
	}
	$sneeit_core_l_short_name = str_replace( $sneeit_core_l_ext, '', $sneeit_core_l_short_name );
	// dev-reply#1557.
	$sneeit_core_l_short_name = preg_replace( '/[^a-zA-Z0-9]+/', '-', $sneeit_core_l_short_name );
	$sneeit_core_l_short_name = explode( '-', $sneeit_core_l_short_name );
	// dev-reply#1560.
	$sneeit_core_l_finalname = '';
	foreach ( $sneeit_core_l_short_name as $sneeit_core_l_part ) {
		if ( preg_match( '/\d/', $sneeit_core_l_part ) ) {
			continue;
		}
		$sneeit_core_l_finalname .= ( strlen( $sneeit_core_l_finalname ) ? '-' : '' ) . $sneeit_core_l_part;
	}
	if ( strlen( $sneeit_core_l_finalname ) > 50 || strlen( $sneeit_core_l_finalname ) < 10 ) {
		$sneeit_core_l_post = get_post( $sneeit_core_l_post_id );
		if ( ! empty( $sneeit_core_l_post ) && ! empty( $sneeit_core_l_post->post_title ) ) {
			$sneeit_core_l_finalname = sneeit_core_text_to_slug( $sneeit_core_l_post->post_title );
		}
	}
	$sneeit_core_l_short_name = ( $sneeit_core_l_finalname ? $sneeit_core_l_finalname . '-' : '' ) . time() . ( $sneeit_core_l_post_id ? '-' . $sneeit_core_l_post_id : '' ) . $sneeit_core_l_ext;
	return $sneeit_core_l_short_name;
}
/**
 * Check Documentation#1568
 *
 * @param object|array|string $sneeit_core_l_src check var-def#1568.
 * @param object|array|string $sneeit_core_l_id check var-def#1568.
 */
function sneeit_core_download_image( $sneeit_core_l_src, $sneeit_core_l_id = null ) {
	// dev-reply#1589.
	$sneeit_core_l_download_path = download_url( $sneeit_core_l_src );
	if ( is_wp_error( $sneeit_core_l_download_path ) ) {
		// dev-reply#1592.
		return false;
	}
	// dev-reply#1596.
	$sneeit_core_l_upload_path = wp_upload_dir()['path'] . '/' . sneeit_core_unique_image_name( $sneeit_core_l_src, $sneeit_core_l_id );
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
	if ( ! rename( $sneeit_core_l_download_path, $sneeit_core_l_upload_path ) ) {
		unlink( $sneeit_core_l_download_path );
		return false;
	}
	// dev-reply#15108.
	$sneeit_core_l_ext = pathinfo( $sneeit_core_l_upload_path, PATHINFO_EXTENSION );
	$sneeit_core_l_info = getimagesize( $sneeit_core_l_upload_path );
	if ( empty( $sneeit_core_l_info ) || count( $sneeit_core_l_info ) < 2 ) {
		// dev-reply#15114.
		return false;
	}
	$sneeit_core_l_width = (int) $sneeit_core_l_info[0];
	$sneeit_core_l_height = (int) $sneeit_core_l_info[1];
	if ( empty( $sneeit_core_l_ext ) || ( $sneeit_core_l_ext ) === 'webp' || ( $sneeit_core_l_ext ) === 'avif' || $sneeit_core_l_width > 2560 || $sneeit_core_l_height > 2560 ) {
		$sneeit_core_l_width = min( (int) $sneeit_core_l_info[0], 2560 );
		$sneeit_core_l_height = min( (int) $sneeit_core_l_info[1], 2560 );
		$sneeit_core_l_editor = wp_get_image_editor( $sneeit_core_l_upload_path );
		if ( is_wp_error( $sneeit_core_l_editor ) ) {
			// dev-reply#15126.
			return false;
		}
		$sneeit_core_l_resized = $sneeit_core_l_editor->resize( $sneeit_core_l_width, $sneeit_core_l_height );
		if ( is_wp_error( $sneeit_core_l_resized ) ) {
			// dev-reply#15131.
			return false;
		}
		$sneeit_core_l_saved = $sneeit_core_l_editor->save( $sneeit_core_l_editor->generate_filename() );
		if ( is_wp_error( $sneeit_core_l_saved ) ) {
			// dev-reply#15136.
			return false;
		}
		if ( ( $sneeit_core_l_upload_path ) !== $sneeit_core_l_saved['path'] ) {
			unlink( $sneeit_core_l_upload_path );
			$sneeit_core_l_upload_path = $sneeit_core_l_saved['path'];
		}
	}
	return $sneeit_core_l_upload_path;
}
/**
 * Check Documentation#15118
 *
 * @param object|array|string $sneeit_core_l_slug check var-def#15118.
 */
function sneeit_core_plugin_install_file( $sneeit_core_l_slug ) {
	// dev-reply#15151.
	$sneeit_core_l_plugin_path = WP_PLUGIN_DIR . '/' . $sneeit_core_l_slug . '/';
	if ( file_exists( $sneeit_core_l_plugin_path . $sneeit_core_l_slug . '.php' ) ) {
		$sneeit_core_l_file_content = file_get_contents( $sneeit_core_l_plugin_path . $sneeit_core_l_slug . '.php' );
		if ( $sneeit_core_l_file_content && strpos( $sneeit_core_l_file_content, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_l_plugin_path . $sneeit_core_l_slug . '.php';
		}
	}
	// dev-reply#15160.
	$sneeit_core_l_file_paths = glob( WP_PLUGIN_DIR . '/' . $sneeit_core_l_slug . '/*.php' );
	foreach ( $sneeit_core_l_file_paths as $sneeit_core_l_file_path ) {
		$sneeit_core_l_file_content = file_get_contents( $sneeit_core_l_file_path );
		if ( $sneeit_core_l_file_content && strpos( $sneeit_core_l_file_content, 'Plugin Name:' ) !== false ) {
			return $sneeit_core_l_file_path;
		}
	}
	return '';
}
/**
 * Check Documentation#15138
 */
function sneeit_core_is_license_required() {
	$sneeit_core_l_theme = wp_get_theme();
	$sneeit_core_l_theme_update_uri = $sneeit_core_l_theme->get( 'UpdateURI' );
	// dev-reply#15177.
	return ( ! empty( $sneeit_core_l_theme_update_uri ) &&
		strpos( $sneeit_core_l_theme_update_uri, '://sneeit.com' ) &&
		empty( implode(
			'',
			explode(
				'/',
				explode( '://sneeit.com', $sneeit_core_l_theme_update_uri )[1]
			)
		) )
	);
}
