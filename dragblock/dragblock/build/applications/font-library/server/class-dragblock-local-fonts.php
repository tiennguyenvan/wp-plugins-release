<?php
/**
 * DragBlock's Font-library.
 *
 * @package Class dragblock local fonts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#33.
/**
 * Check class-def#33
 */
class DragBlock_Local_Fonts {
	/**
	 * Check Documentation#35
	 */
	public static function local_fonts_admin_page() {
		// dev-reply#39.
		wp_enqueue_script( 'inflate', DRAGBLOCK_BUILD_URL . 'applications/font-library/client/font-readers/index.js', array(), DRAGBLOCK_VERSION, false );
		DragBlock_React_App::bootstrap();
		$dragblock_0 = esc_attr( wp_create_nonce( 'dragblock_font_library' ) );
		$dragblock_1 = "<input id=\"nonce\" type=\"hidden\" value=\"{$dragblock_0}\" />";
		$dragblock_1 .= '<div id="dragblock-font-library-app"></div>';
		// dev-reply#320.
		$dragblock_2 = array(
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
		echo wp_kses( $dragblock_1, $dragblock_2 );
	}
}
