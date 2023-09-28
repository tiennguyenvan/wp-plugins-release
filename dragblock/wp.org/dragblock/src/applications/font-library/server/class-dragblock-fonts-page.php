<?php
/**
 * DragBlock's Font-library.
 *
 * @package Class dragblock fonts page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#43.
/**
 * Check class-def#43
 */
class DragBlock_Fonts_Page {
	/**
	 * Check Documentation#45
	 */
	public static function manage_fonts_admin_page() {
		DragBlock_React_App::bootstrap();
		// dev-reply#411.
		$dragblock_cdfp_font_families = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
		// dev-reply#417.
		if ( class_exists( 'WP_Webfonts' ) !== true ) {
			$dragblock_cdfp_font_assets_stylesheet = dragblock_render_font_styles( $dragblock_cdfp_font_families );
			wp_register_style( 'dragblock-font-library', false );
			wp_add_inline_style( 'dragblock-font-library', $dragblock_cdfp_font_assets_stylesheet );
			wp_enqueue_style( 'dragblock-font-library' );
		}
		$dragblock_cdfp_fonts_json = wp_json_encode( $dragblock_cdfp_font_families );
		// dev-reply#432.
		$dragblock_cdfp_fonts_json_string = esc_html( preg_replace( '~(?:^|\G)\h{4}~m', "\t", $dragblock_cdfp_fonts_json ) );
		$dragblock_cdfp_font_app_nonce = esc_attr( wp_create_nonce( 'dragblock_font_library' ) );
		$dragblock_cdfp_font_app_html = "<p name=dragblock-font-library-json id=dragblock-font-library-json class=hidden>{$dragblock_cdfp_fonts_json_string}</p>";
		$dragblock_cdfp_font_app_html .= '<div id=dragblock-font-library-app></div>';
		$dragblock_cdfp_font_app_html .= "<input type=hidden name=nonce id=nonce value=\"{$dragblock_cdfp_font_app_nonce}\" />";
		// dev-reply#441.
		$dragblock_cdfp_allowed_html = array(
			'p' => array(
				'name' => true,
				'id' => true,
				'class' => true,
			),
			'div' => array(
				'id' => true,
			),
			'input' => array(
				'type' => true,
				'name' => true,
				'id' => true,
				'value' => true,
			),
		);
		echo wp_kses( $dragblock_cdfp_font_app_html, $dragblock_cdfp_allowed_html );
	}
}
