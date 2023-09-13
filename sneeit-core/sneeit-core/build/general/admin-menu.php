<?php
/**
 * DragBlock's General.
 *
 * @package Admin menu
 */

if( ! defined( 'ABSPATH' ) ) exit;
define( 'SNEEIT_CORE_ADMIN_MENU_SLUG', 'sneeit-core' );
add_action( 'admin_menu', 'sneeit_core_admin_menu' );
/**
 * Check Documentation#85
 */
function sneeit_core_admin_menu() {
	if ( ! empty( $GLOBALS['admin_page_hooks'][ SNEEIT_CORE_ADMIN_MENU_SLUG ] ) ) {
		return;
	}
	$sneeit_core_0 = get_option( 'sneeit_license_username', '' );
	$sneeit_core_1 = sneeit_core_is_license_required();
	// dev-reply#818.
	add_menu_page(
		esc_html__( 'Sneeit Core', 'sneeit' ), // dev-reply#821.
		esc_html__( 'Sneeit Core', 'sneeit' ) . ( $sneeit_core_1 && ! $sneeit_core_0 ? ' <span class="awaiting-mod">!</span>' : '' ), // dev-reply#822.
		'manage_options', // dev-reply#823.
		SNEEIT_CORE_ADMIN_MENU_SLUG,
		'sneeit_core_admin_page', // dev-reply#825.
		SNEEIT_CORE_IMAGE_URL . 'sneeit-logo-16.png', // dev-reply#826.
		6 // dev-reply#827.
	);
	$sneeit_core_2 = array(
		'sneeit-core-import' => 'Import Demos',
		'sneeit-core-activate' => 'Activate Licenses',
	);
	$sneeit_core_3 = wp_get_theme();
	$sneeit_core_4 = $sneeit_core_3->get( 'UpdateURI' );
	// dev-reply#841.
	foreach ( $sneeit_core_2 as $sneeit_core_5 => $sneeit_core_6 ) {
		// dev-reply#843.
		if ( strpos( $sneeit_core_4, 'sneeit.com' ) === false && ( $sneeit_core_5 ) === 'sneeit-core-activate' ) {
			continue;
		}
		add_submenu_page(
			// dev-reply#851.
			SNEEIT_CORE_ADMIN_MENU_SLUG,
			$sneeit_core_6,
			$sneeit_core_6 . ( ( $sneeit_core_5 ) === 'sneeit-core-activate' && $sneeit_core_1 && ! $sneeit_core_0 ? ' <span class="awaiting-mod">!</span>' : '' ),
			// dev-reply#860.
			'manage_options',
			// dev-reply#863.
			$sneeit_core_5,
			'sneeit_core_admin_page'
		);
	}
	// dev-reply#871.
	remove_submenu_page( SNEEIT_CORE_ADMIN_MENU_SLUG, SNEEIT_CORE_ADMIN_MENU_SLUG );
	$sneeit_core_7 = $_SERVER['REQUEST_URI'];
	if (
		strpos( $sneeit_core_7, 'site-editor.php' ) === false &&
		! $sneeit_core_0 &&
		(
			empty( $_GET['page'] ) ||
			sanitize_text_field( $_GET['page'] ) !== 'sneeit-core-activate'
		)
	) {
		/**
		 * Check Documentation#856
		 */
		add_filter( 'admin_notices', function() {
			$sneeit_core_1 = sneeit_core_is_license_required();
			if ( ! $sneeit_core_1 ) {
				return;
			}
			$sneeit_core_3 = wp_get_theme();
			$sneeit_core_8 = $sneeit_core_3->get( 'Name' );
			echo '<section><div class="notice notice-large notice-warning is-dismissible">';
			echo '<h2 class="notice-title">';
			/* translators: see trans-note#865 */
			echo sprintf( esc_html__( 'Please activate "%s" theme before using the theme on your website. Thank You!', 'sneeit-core' ), $sneeit_core_8 );
			echo '</h2>';
			echo '<p>';
			echo '<a class="button button-large button-primary" href="' . menu_page_url( 'sneeit-core-activate', false ) . '">';
			echo esc_html__( 'Activate The Theme Now', 'sneeit-core' );
			echo '</a>';
			echo '</p>';
			echo '</div></section>';
		} );
	}
}
/**
 * Check Documentation#876
 */
function sneeit_core_admin_page() {
	// dev-reply#8106.
	$sneeit_core_9 = isset( $_GET['page'] ) ? $_GET['page'] : '';
	if ( ! $sneeit_core_9 ) return;
	echo '<div class="' . $sneeit_core_9 . ' app wrap">';
}
