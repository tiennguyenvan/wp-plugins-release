<?php
/**
 * DragBlock's Font-library.
 *
 * @package Class dragblock manage fonts admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Check class-def#242
 */
class DragBlock_Manage_Fonts_Admin {
	/**
	 * Check Documentation#244
	 */
	public function __construct() {
		// dev-reply#248.
		add_action( 'init', array( $this, 'save_manage_fonts_changes' ), 1 ); // dev-reply#249.
		add_action( 'admin_init', array( $this, 'save_google_fonts' ) );
		add_action( 'admin_init', array( $this, 'save_local_fonts' ) );
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'wp_check_filetype_and_ext' ), 10, 4 );
	}
	const ALLOWED_FONT_MIME_TYPES = array(
		'otf'   => 'font/otf',
		'ttf'   => 'font/ttf',
		'woff'  => 'font/woff',
		'woff2' => 'font/woff2',
	);
	// dev-reply#2423.
	/**
	 * Check Documentation#2420
	 *
	 * @param object|array|string $dragblock_cdmfa_wp_check_filetype_and_ext check var-def#2420.
	 * @param object|array|string $dragblock_cdmfa_file check var-def#2420.
	 * @param object|array|string $dragblock_cdmfa_filename check var-def#2420.
	 * @param object|array|string $dragblock_cdmfa_mimes check var-def#2420.
	 */
	public function wp_check_filetype_and_ext( $dragblock_cdmfa_wp_check_filetype_and_ext, $dragblock_cdmfa_file, $dragblock_cdmfa_filename, $dragblock_cdmfa_mimes ) {
		if (
			! empty( $dragblock_cdmfa_wp_check_filetype_and_ext['ext'] ) ||
			! empty( $dragblock_cdmfa_wp_check_filetype_and_ext['type'] ) ||
			! empty( $dragblock_cdmfa_wp_check_filetype_and_ext['proper_filename '] )
		) {
			return $dragblock_cdmfa_wp_check_filetype_and_ext;
		}
		$dragblock_cdmfa_ext = pathinfo( sanitize_file_name( $dragblock_cdmfa_filename ), PATHINFO_EXTENSION );
		if ( empty( $dragblock_cdmfa_ext ) ) {
			return $dragblock_cdmfa_wp_check_filetype_and_ext;
		}
		$dragblock_cdmfa_wp_check_filetype_and_ext['ext'] = $dragblock_cdmfa_ext;
		if ( ! empty( self::ALLOWED_FONT_MIME_TYPES[ $dragblock_cdmfa_ext ] ) ) {
			$dragblock_cdmfa_wp_check_filetype_and_ext['type'] = self::ALLOWED_FONT_MIME_TYPES[ $dragblock_cdmfa_ext ];
		}
		return $dragblock_cdmfa_wp_check_filetype_and_ext;
	}
	/**
	 * Check Documentation#2439
	 *
	 * @param object|array|string $dragblock_cdmfa_file check var-def#2439.
	 */
	public function has_font_mime_type( $dragblock_cdmfa_file ) {
		$dragblock_cdmfa_filetype = wp_check_filetype( $dragblock_cdmfa_file, self::ALLOWED_FONT_MIME_TYPES );
		return in_array( $dragblock_cdmfa_filetype['type'], self::ALLOWED_FONT_MIME_TYPES, true );
	}
	/**
	 * Check Documentation#2444
	 */
	public function create_admin_menu() {
		if ( ! wp_is_block_theme() ) {
			return;
		}
		// dev-reply#2460.
		add_submenu_page(
			DRAGBLOCK_ADMIN_MENU_SLUG,
			_x( 'Font Library', 'UI String', 'dragblock' ), // dev-reply#2466.
			_x( 'Font Library', 'UI String', 'dragblock' ), // dev-reply#2467.
			'edit_theme_options',
			DRAGBLOCK_FONT_LIB_SLUG,
			array( 'DragBlock_Fonts_Page', 'manage_fonts_admin_page' )
		);
		add_submenu_page(
			DRAGBLOCK_FONT_LIB_SLUG . '-google-font',
			_x( 'Embed Google font in the site editor', 'UI String', 'dragblock' ), // dev-reply#2475.
			_x( 'Embed Google Font', 'UI String', 'dragblock' ), // dev-reply#2476.
			'edit_theme_options',
			'dragblock-add-google-fonts',
			array( 'DragBlock_Google_Fonts', 'google_fonts_admin_page' )
		);
		add_submenu_page(
			DRAGBLOCK_FONT_LIB_SLUG . '-local-font',
			_x( 'Embed local font in the site editor', 'UI String', 'dragblock' ), // dev-reply#2485.
			_x( 'Embed local font', 'UI String', 'dragblock' ), // dev-reply#2486.
			'edit_theme_options',
			'dragblock-add-local-fonts',
			array( 'DragBlock_Local_Fonts', 'local_fonts_admin_page' )
		);
	}
	/**
	 * Check Documentation#2475
	 */
	public function has_file_and_user_permissions() {
		$dragblock_cdmfa_has_user_permissions = $this->user_can_edit_themes();
		$dragblock_cdmfa_has_file_permissions = $this->can_read_and_write_font_assets_directory();
		return $dragblock_cdmfa_has_user_permissions && $dragblock_cdmfa_has_file_permissions;
	}
	/**
	 * Check Documentation#2481
	 */
	public function user_can_edit_themes() {
		if ( defined( 'DISALLOW_FILE_EDIT' ) && true === DISALLOW_FILE_EDIT ) {
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_file_edit_error' ) );
			return false;
		}
		if ( ! current_user_can( 'edit_themes' ) ) {
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_user_cant_edit_theme' ) );
			return false;
		}
		return true;
	}
	/**
	 * Check Documentation#2493
	 */
	public function can_read_and_write_font_assets_directory() {
		// dev-reply#24116.
		$dragblock_cdmfa_temp_dir = get_temp_dir();
		$dragblock_cdmfa_font_assets_path = DRAGBLOCK_UPLOAD_DIR . '/fonts/';
		if ( ! is_dir( $dragblock_cdmfa_font_assets_path ) ) {
			// dev-reply#24122.
			wp_mkdir_p( $dragblock_cdmfa_font_assets_path );
		}
		if ( ! wp_is_writable( $dragblock_cdmfa_font_assets_path ) || ! is_readable( $dragblock_cdmfa_font_assets_path ) || ! wp_is_writable( $dragblock_cdmfa_temp_dir ) ) {
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_manage_fonts_permission_error' ) );
			return false;
		}
		return true;
	}
	/**
	 * Check Documentation#24108
	 */
	public function refresh_global_styles() {
		$dragblock_cdmfa_user_cpt = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( wp_get_theme(), true );
		if ( empty( $dragblock_cdmfa_user_cpt ) || empty( $dragblock_cdmfa_user_cpt['ID'] ) || empty( $dragblock_cdmfa_user_cpt['post_content'] ) ) {
			return;
		}
		// dev-reply#24145.
		$dragblock_cdmfa_theme_json = json_decode( $dragblock_cdmfa_user_cpt['post_content'], true );
		$dragblock_cdmfa_theme_json = dragblock_default_theme_json_font_lib( $dragblock_cdmfa_theme_json );
		// dev-reply#24149.
		wp_update_post( array(
			'ID'           => $dragblock_cdmfa_user_cpt['ID'],
			'post_content' => json_encode( $dragblock_cdmfa_theme_json ), // dev-reply#24152.,
		) );
	}
	/**
	 * Check Documentation#24123
	 *
	 * @param object|array|string $dragblock_cdmfa_font_face check var-def#24123.
	 */
	public function delete_font_asset( $dragblock_cdmfa_font_face ) {
		// dev-reply#24158.
		$dragblock_cdmfa_font_path = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $dragblock_cdmfa_font_face['src'][0] );
		if ( file_exists( $dragblock_cdmfa_font_path ) && unlink( $dragblock_cdmfa_font_path ) ) {
			return true;
		}
		return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_font_asset_removal_error' ) );
	}
	/**
	 * Check Documentation#24132
	 *
	 * @param object|array|string $dragblock_cdmfa_font_families check var-def#24132.
	 */
	protected function prepare_font_families_for_database( $dragblock_cdmfa_font_families ) {
		$dragblock_cdmfa_prepared_font_families = array();
		foreach ( $dragblock_cdmfa_font_families as $dragblock_cdmfa_font_family ) {
			if ( isset( $dragblock_cdmfa_font_family['fontFace'] ) ) {
				$dragblock_cdmfa_new_font_faces = array();
				foreach ( $dragblock_cdmfa_font_family['fontFace'] as $dragblock_cdmfa_font_face ) {
					$dragblock_cdmfa_updated_font_face = $dragblock_cdmfa_font_face;
					// dev-reply#24177.
					if ( ! isset( $dragblock_cdmfa_font_face['shouldBeRemoved'] ) && ! isset( $dragblock_cdmfa_font_family['shouldBeRemoved'] ) ) {
						$dragblock_cdmfa_new_font_faces[] = $dragblock_cdmfa_updated_font_face;
					} else {
						$this->delete_font_asset( $dragblock_cdmfa_font_face );
					}
				}
				$dragblock_cdmfa_font_family['fontFace'] = $dragblock_cdmfa_new_font_faces;
			}
			if ( ! isset( $dragblock_cdmfa_font_family['shouldBeRemoved'] ) ) {
				$dragblock_cdmfa_prepared_font_families[] = $dragblock_cdmfa_font_family;
			}
		}
		return $dragblock_cdmfa_prepared_font_families;
	}
	/**
	 * Check Documentation#24155
	 */
	public function save_manage_fonts_changes() {
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			! empty( $_POST['dragblock-font-library-new-font-json'] ) &&
			$this->has_file_and_user_permissions()
		) {
			// dev-reply#24206.
			$dragblock_cdmfa_new_font_json = json_decode( sanitize_text_field( wp_unslash( $_POST['dragblock-font-library-new-font-json'] ) ), true );
			if ( empty( $dragblock_cdmfa_new_font_json ) ) {
				// dev-reply#24210.
				return;
			}
			$dragblock_cdmfa_new_font_families = $this->prepare_font_families_for_database( $dragblock_cdmfa_new_font_json );
			$this->replace_all_font_families( $dragblock_cdmfa_new_font_families );
			// dev-reply#24216.
			$this->refresh_global_styles();
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_delete_font_success' ) );
		}
	}
	/**
	 * Check Documentation#24176
	 */
	public function save_local_fonts() {
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			! empty( $_FILES['font-file'] ) &&
			! empty( $_POST['font-name'] ) &&
			! empty( $_POST['font-weight'] ) &&
			! empty( $_POST['font-style'] ) &&
			$this->has_file_and_user_permissions()
		) {
			if (
				! empty( $_FILES ) &&
				isset( $_FILES['font-file'] ) &&
				isset( $_FILES['font-file']['name'] ) &&
				$this->has_font_mime_type( sanitize_file_name( $_FILES['font-file']['name'] ) )
			) {
				$dragblock_cdmfa_font_slug = sanitize_title( wp_unslash( $_POST['font-name'] ) );
				$dragblock_cdmfa_font_style = sanitize_text_field( wp_unslash( $_POST['font-style'] ) );
				$dragblock_cdmfa_font_weight = sanitize_text_field( wp_unslash( $_POST['font-weight'] ) );
				$dragblock_cdmfa_font_name = sanitize_text_field( wp_unslash( $_POST['font-name'] ) );
				$dragblock_cdmfa_file_extension = pathinfo( sanitize_file_name( wp_unslash( $_FILES['font-file']['name'] ) ), PATHINFO_EXTENSION );
				$dragblock_cdmfa_file_name = $dragblock_cdmfa_font_slug . '_' . $dragblock_cdmfa_font_style . '_' . $dragblock_cdmfa_font_weight . '.' . $dragblock_cdmfa_file_extension;
				$dragblock_cdmfa_font_assets_path = DRAGBLOCK_UPLOAD_DIR . '/fonts/';
				$dragblock_cdmfa_file_path = $dragblock_cdmfa_font_assets_path . $dragblock_cdmfa_file_name;
				// dev-reply#24251.
				$dragblock_cdmfa_upload_overrides = array(
					'test_form' => false,
					'mines' => self::ALLOWED_FONT_MIME_TYPES,
				);
				$dragblock_cdmfa_file_info = wp_handle_upload( $_FILES['font-file'], $dragblock_cdmfa_upload_overrides );
				if ( isset( $dragblock_cdmfa_file_info['error'] ) ) {
					return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
				}
				// dev-reply#24265.
				if ( ! rename( $dragblock_cdmfa_file_info['file'], $dragblock_cdmfa_file_path ) ) {
					return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
				}
				$dragblock_cdmfa_uploaded_font_face = array(
					'fontFamily' => $dragblock_cdmfa_font_name,
					'fontWeight' => $dragblock_cdmfa_font_weight,
					'fontStyle'  => $dragblock_cdmfa_font_style,
					'src'        => array(
						// dev-reply#24275.
						DRAGBLOCK_UPLOAD_URL . '/fonts/' . $dragblock_cdmfa_file_name,
						// dev-reply#24277.
					),
				);
				if ( ! empty( $_POST['font-variation-settings'] ) ) {
					// dev-reply#24282.
					$dragblock_cdmfa_font_variation_settings = sanitize_text_field( wp_unslash( $_POST['font-variation-settings'] ) );
					$dragblock_cdmfa_uploaded_font_face['fontVariationSettings'] = $dragblock_cdmfa_font_variation_settings;
				}
				$dragblock_cdmfa_new_font_faces = array( $dragblock_cdmfa_uploaded_font_face );
				$this->add_or_update_font_faces( $dragblock_cdmfa_font_name, $dragblock_cdmfa_font_slug, $dragblock_cdmfa_new_font_faces );
				// dev-reply#24291.
				$this->refresh_global_styles();
				return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_success' ) );
			}
			return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
		}
	}
	/**
	 * Check Documentation#24238
	 *
	 * @param object|array|string $dragblock_cdmfa_name check var-def#24238.
	 */
	public function get_font_slug( $dragblock_cdmfa_name ) {
		$dragblock_cdmfa_slug = sanitize_title( $dragblock_cdmfa_name );
		$dragblock_cdmfa_slug = preg_replace( '/\s+/', '', $dragblock_cdmfa_slug ); // dev-reply#24306.
		return $dragblock_cdmfa_slug;
	}
	/**
	 * Check Documentation#24244
	 */
	public function save_google_fonts() {
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			! empty( $_POST['selection-data'] ) &&
			$this->has_file_and_user_permissions()
		) {
			// dev-reply#24318.
			$dragblock_cdmfa_data = json_decode( sanitize_text_field( wp_unslash( $_POST['selection-data'] ) ), true );
			if ( empty( $dragblock_cdmfa_data ) ) {
				return;
			}
			foreach ( $dragblock_cdmfa_data as $dragblock_cdmfa_font_family ) {
				$dragblock_cdmfa_google_font_name = $dragblock_cdmfa_font_family['family'];
				$dragblock_cdmfa_font_slug = $this->get_font_slug( $dragblock_cdmfa_google_font_name );
				$dragblock_cdmfa_variants = $dragblock_cdmfa_font_family['faces'];
				$dragblock_cdmfa_new_font_faces = array();
				foreach ( $dragblock_cdmfa_variants as $dragblock_cdmfa_variant ) {
					// dev-reply#24330.
					$dragblock_cdmfa_file_extension = pathinfo( $dragblock_cdmfa_variant['src'], PATHINFO_EXTENSION );
					$dragblock_cdmfa_file_name = $dragblock_cdmfa_font_slug . '_' . $dragblock_cdmfa_variant['style'] . '_' . $dragblock_cdmfa_variant['weight'] . '.' . $dragblock_cdmfa_file_extension;
					// dev-reply#24334.
					$dragblock_cdmfa_temp_file = download_url( $dragblock_cdmfa_variant['src'] );
					if ( $this->has_font_mime_type( $dragblock_cdmfa_variant['src'] ) ) {
						// dev-reply#24339.
						rename( $dragblock_cdmfa_temp_file, DRAGBLOCK_UPLOAD_DIR . '/fonts/' . $dragblock_cdmfa_file_name );
						// dev-reply#24343.
						$dragblock_cdmfa_new_font_faces[] = array(
							'fontFamily' => $dragblock_cdmfa_google_font_name,
							'fontStyle'  => $dragblock_cdmfa_variant['style'],
							'fontWeight' => $dragblock_cdmfa_variant['weight'],
							'src'        => array(
								// dev-reply#24349.
								DRAGBLOCK_UPLOAD_URL . '/fonts/' . $dragblock_cdmfa_file_name,
								// dev-reply#24354.
							),
						);
					}
				}
				$this->add_or_update_font_faces( $dragblock_cdmfa_google_font_name, $dragblock_cdmfa_font_slug, $dragblock_cdmfa_new_font_faces );
				// dev-reply#24366.
			}
			$this->refresh_global_styles();
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_success' ) );
		}
	}
	/**
	 * Check Documentation#24291
	 *
	 * @param object|array|string $dragblock_cdmfa_font_families check var-def#24291.
	 */
	public function replace_all_font_families( $dragblock_cdmfa_font_families ) {
		// dev-reply#24381.
		update_option( DRAGBLOCK_FONT_LIB_SLUG, $dragblock_cdmfa_font_families );
	}
	/**
	 * Check Documentation#24296
	 *
	 * @param object|array|string $dragblock_cdmfa_font_name check var-def#24296.
	 * @param object|array|string $dragblock_cdmfa_font_slug check var-def#24296.
	 * @param object|array|string $dragblock_cdmfa_font_faces check var-def#24296.
	 */
	public function add_or_update_font_faces( $dragblock_cdmfa_font_name, $dragblock_cdmfa_font_slug, $dragblock_cdmfa_font_faces ) {
		$dragblock_cdmfa_font_families = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
		$dragblock_cdmfa_font_families[] = array(
			'fontFamily' => $dragblock_cdmfa_font_name,
			'slug'       => $dragblock_cdmfa_font_slug,
			'fontFace'   => $dragblock_cdmfa_font_faces,
		);
		update_option( DRAGBLOCK_FONT_LIB_SLUG, $dragblock_cdmfa_font_families );
	}
}
$dragblock_cdmfa_dragblock_manage_fonts_admin = new DragBlock_Manage_Fonts_Admin();
