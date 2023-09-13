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
		$dragblock_0 = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
		// dev-reply#417.
		if ( class_exists( 'WP_Webfonts' ) !== true ) {
			$dragblock_1 = dragblock_render_font_styles( $dragblock_0 );
			wp_register_style( 'dragblock-font-library', false );
			wp_add_inline_style( 'dragblock-font-library', $dragblock_1 );
			wp_enqueue_style( 'dragblock-font-library' );
		}
		$dragblock_2 = wp_json_encode( $dragblock_0 );
		// dev-reply#432.
		$dragblock_3 = esc_html( preg_replace( '~(?:^|\G)\h{4}~m', "\t", $dragblock_2 ) );
		$dragblock_4 = esc_attr( wp_create_nonce( 'dragblock_font_library' ) );
		$dragblock_5 = "<p name=dragblock-font-library-json id=dragblock-font-library-json class=hidden>{$dragblock_3}</p>";
		$dragblock_5 .= '<div id=dragblock-font-library-app></div>';
		$dragblock_5 .= "<input type=hidden name=nonce id=nonce value=\"{$dragblock_4}\" />";
		// dev-reply#441.
		$dragblock_6 = array(
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
		echo wp_kses( $dragblock_5, $dragblock_6 );
	}
}
