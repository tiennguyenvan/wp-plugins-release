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
	 * @param object|array|string $dragblock_0 check var-def#2420.
	 * @param object|array|string $dragblock_1 check var-def#2420.
	 * @param object|array|string $dragblock_2 check var-def#2420.
	 * @param object|array|string $dragblock_3 check var-def#2420.
	 */
	public function wp_check_filetype_and_ext( $dragblock_0, $dragblock_1, $dragblock_2, $dragblock_3 ) {
		if (
			! empty( $dragblock_0['ext'] ) ||
			! empty( $dragblock_0['type'] ) ||
			! empty( $dragblock_0['proper_filename '] )
		) {
			return $dragblock_0;
		}
		$dragblock_4 = pathinfo( sanitize_file_name( $dragblock_2 ), PATHINFO_EXTENSION );
		if ( empty( $dragblock_4 ) ) {
			return $dragblock_0;
		}
		$dragblock_0['ext'] = $dragblock_4;
		if ( ! empty( self::ALLOWED_FONT_MIME_TYPES[ $dragblock_4 ] ) ) {
			$dragblock_0['type'] = self::ALLOWED_FONT_MIME_TYPES[ $dragblock_4 ];
		}
		return $dragblock_0;
	}
	/**
	 * Check Documentation#2439
	 *
	 * @param object|array|string $dragblock_1 check var-def#2439.
	 */
	public function has_font_mime_type( $dragblock_1 ) {
		$dragblock_5 = wp_check_filetype( $dragblock_1, self::ALLOWED_FONT_MIME_TYPES );
		return in_array( $dragblock_5['type'], self::ALLOWED_FONT_MIME_TYPES, true );
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
		$dragblock_6 = $this->user_can_edit_themes();
		$dragblock_7 = $this->can_read_and_write_font_assets_directory();
		return $dragblock_6 && $dragblock_7;
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
		$dragblock_8 = get_temp_dir();
		$dragblock_9 = DRAGBLOCK_UPLOAD_DIR . '/fonts/';
		if ( ! is_dir( $dragblock_9 ) ) {
			// dev-reply#24122.
			wp_mkdir_p( $dragblock_9 );
		}
		if ( ! wp_is_writable( $dragblock_9 ) || ! is_readable( $dragblock_9 ) || ! wp_is_writable( $dragblock_8 ) ) {
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_manage_fonts_permission_error' ) );
			return false;
		}
		return true;
	}
	/**
	 * Check Documentation#24108
	 *
	 * @param object|array|string $dragblock_10 check var-def#24108.
	 */
	public function delete_font_asset( $dragblock_10 ) {
		// dev-reply#24135.
		$dragblock_11 = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $dragblock_10['src'][0] );
		if ( file_exists( $dragblock_11 ) && unlink( $dragblock_11 ) ) {
			return true;
		}
		return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_font_asset_removal_error' ) );
	}
	/**
	 * Check Documentation#24117
	 *
	 * @param object|array|string $dragblock_12 check var-def#24117.
	 */
	protected function prepare_font_families_for_database( $dragblock_12 ) {
		$dragblock_13 = array();
		foreach ( $dragblock_12 as $dragblock_14 ) {
			if ( isset( $dragblock_14['fontFace'] ) ) {
				$dragblock_15 = array();
				foreach ( $dragblock_14['fontFace'] as $dragblock_10 ) {
					$dragblock_16 = $dragblock_10;
					// dev-reply#24154.
					if ( ! isset( $dragblock_10['shouldBeRemoved'] ) && ! isset( $dragblock_14['shouldBeRemoved'] ) ) {
						$dragblock_15[] = $dragblock_16;
					} else {
						$this->delete_font_asset( $dragblock_10 );
					}
				}
				$dragblock_14['fontFace'] = $dragblock_15;
			}
			if ( ! isset( $dragblock_14['shouldBeRemoved'] ) ) {
				$dragblock_13[] = $dragblock_14;
			}
		}
		return $dragblock_13;
	}
	/**
	 * Check Documentation#24140
	 */
	public function save_manage_fonts_changes() {
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			! empty( $_POST['dragblock-font-library-new-font-json'] ) &&
			$this->has_file_and_user_permissions()
		) {
			// dev-reply#24183.
			$dragblock_17 = json_decode( sanitize_text_field( wp_unslash( $_POST['dragblock-font-library-new-font-json'] ) ), true );
			if ( empty( $dragblock_17 ) ) {
				// dev-reply#24187.
				return;
			}
			$dragblock_18 = $this->prepare_font_families_for_database( $dragblock_17 );
			$this->replace_all_font_families( $dragblock_18 );
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_delete_font_success' ) );
		}
	}
	/**
	 * Check Documentation#24159
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
				$dragblock_19 = sanitize_title( wp_unslash( $_POST['font-name'] ) );
				$dragblock_20 = sanitize_text_field( wp_unslash( $_POST['font-style'] ) );
				$dragblock_21 = sanitize_text_field( wp_unslash( $_POST['font-weight'] ) );
				$dragblock_22 = sanitize_text_field( wp_unslash( $_POST['font-name'] ) );
				$dragblock_23 = pathinfo( sanitize_file_name( wp_unslash( $_FILES['font-file']['name'] ) ), PATHINFO_EXTENSION );
				$dragblock_24 = $dragblock_19 . '_' . $dragblock_20 . '_' . $dragblock_21 . '.' . $dragblock_23;
				$dragblock_9 = DRAGBLOCK_UPLOAD_DIR . '/fonts/';
				$dragblock_25 = $dragblock_9 . $dragblock_24;
				// dev-reply#24226.
				$dragblock_26 = array(
					'test_form' => false,
					'mines' => self::ALLOWED_FONT_MIME_TYPES,
				);
				$dragblock_27 = wp_handle_upload( $_FILES['font-file'], $dragblock_26 );
				if ( isset( $dragblock_27['error'] ) ) {
					return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
				}
				// dev-reply#24240.
				if ( ! rename( $dragblock_27['file'], $dragblock_25 ) ) {
					return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
				}
				$dragblock_28 = array(
					'fontFamily' => $dragblock_22,
					'fontWeight' => $dragblock_21,
					'fontStyle'  => $dragblock_20,
					'src'        => array(
						// dev-reply#24250.
						DRAGBLOCK_UPLOAD_URL . '/fonts/' . $dragblock_24,
						// dev-reply#24252.
					),
				);
				if ( ! empty( $_POST['font-variation-settings'] ) ) {
					// dev-reply#24257.
					$dragblock_29 = sanitize_text_field( wp_unslash( $_POST['font-variation-settings'] ) );
					$dragblock_28['fontVariationSettings'] = $dragblock_29;
				}
				$dragblock_15 = array( $dragblock_28 );
				$this->add_or_update_font_faces( $dragblock_22, $dragblock_19, $dragblock_15 );
				// dev-reply#24266.
				return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_success' ) );
			}
			return add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_file_error' ) );
		}
	}
	/**
	 * Check Documentation#24220
	 *
	 * @param object|array|string $dragblock_30 check var-def#24220.
	 */
	public function get_font_slug( $dragblock_30 ) {
		$dragblock_31 = sanitize_title( $dragblock_30 );
		$dragblock_31 = preg_replace( '/\s+/', '', $dragblock_31 ); // dev-reply#24279.
		return $dragblock_31;
	}
	/**
	 * Check Documentation#24226
	 */
	public function save_google_fonts() {
		if (
			! empty( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'dragblock_font_library' ) &&
			! empty( $_POST['selection-data'] ) &&
			$this->has_file_and_user_permissions()
		) {
			// dev-reply#24291.
			$dragblock_32 = json_decode( sanitize_text_field( wp_unslash( $_POST['selection-data'] ) ), true );
			if ( empty( $dragblock_32 ) ) {
				return;
			}
			foreach ( $dragblock_32 as $dragblock_14 ) {
				$dragblock_33 = $dragblock_14['family'];
				$dragblock_19 = $this->get_font_slug( $dragblock_33 );
				$dragblock_34 = $dragblock_14['faces'];
				$dragblock_15 = array();
				foreach ( $dragblock_34 as $dragblock_35 ) {
					// dev-reply#24303.
					$dragblock_23 = pathinfo( $dragblock_35['src'], PATHINFO_EXTENSION );
					$dragblock_24 = $dragblock_19 . '_' . $dragblock_35['style'] . '_' . $dragblock_35['weight'] . '.' . $dragblock_23;
					// dev-reply#24307.
					$dragblock_36 = download_url( $dragblock_35['src'] );
					if ( $this->has_font_mime_type( $dragblock_35['src'] ) ) {
						// dev-reply#24312.
						rename( $dragblock_36, DRAGBLOCK_UPLOAD_DIR . '/fonts/' . $dragblock_24 );
						// dev-reply#24316.
						$dragblock_15[] = array(
							'fontFamily' => $dragblock_33,
							'fontStyle'  => $dragblock_35['style'],
							'fontWeight' => $dragblock_35['weight'],
							'src'        => array(
								// dev-reply#24322.
								DRAGBLOCK_UPLOAD_URL . '/fonts/' . $dragblock_24,
								// dev-reply#24327.
							),
						);
					}
				}
				$this->add_or_update_font_faces( $dragblock_33, $dragblock_19, $dragblock_15 );
				// dev-reply#24339.
			}
			add_action( 'admin_notices', array( 'DragBlock_Font_Form_Messages', 'admin_notice_embed_font_success' ) );
		}
	}
	/**
	 * Check Documentation#24272
	 *
	 * @param object|array|string $dragblock_12 check var-def#24272.
	 */
	public function replace_all_font_families( $dragblock_12 ) {
		// dev-reply#24352.
		update_option( DRAGBLOCK_FONT_LIB_SLUG, $dragblock_12 );
	}
	/**
	 * Check Documentation#24277
	 *
	 * @param object|array|string $dragblock_22 check var-def#24277.
	 * @param object|array|string $dragblock_19 check var-def#24277.
	 * @param object|array|string $dragblock_37 check var-def#24277.
	 */
	public function add_or_update_font_faces( $dragblock_22, $dragblock_19, $dragblock_37 ) {
		$dragblock_12 = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
		$dragblock_12[] = array(
			'fontFamily' => $dragblock_22,
			'slug'       => $dragblock_19,
			'fontFace'   => $dragblock_37,
		);
		update_option( DRAGBLOCK_FONT_LIB_SLUG, $dragblock_12 );
	}
}
$dragblock_38 = new DragBlock_Manage_Fonts_Admin();
