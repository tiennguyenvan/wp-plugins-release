<?php
/**
 * DragBlock's .
 *
 * @package Build
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_URL', plugin_dir_url( DRAGBLOCK_FILE_PATH ) );
define( 'DRAGBLOCK_ASSETS_URL', DRAGBLOCK_URL . 'assets/' );
define( 'DRAGBLOCK_IMAGES_URL', DRAGBLOCK_ASSETS_URL . 'images/' );
define( 'DRAGBLOCK_PATH', plugin_dir_path( DRAGBLOCK_FILE_PATH ) );
define( 'DRAGBLOCK_BUILD_URL', DRAGBLOCK_URL . 'build/' );
define( 'DRAGBLOCK_BUILD_PATH', DRAGBLOCK_PATH . 'build/' );
define( 'DRAGBLOCK_APP_URL', DRAGBLOCK_BUILD_URL . 'applications/' );
define( 'DRAGBLOCK_APP_PATH', DRAGBLOCK_BUILD_PATH . 'applications/' );
define( 'DRAGBLOCK_NONCE_SLUG', 'dragBlockNonce' );
define( 'DRAGBLOCK_K_PATTERN_CACHE', 'dragblock_pattern_cache' );
define( 'DRAGBLOCK_EDITOR_INIT_SLUG', 'dragblock-editor-init' );
define( 'DRAGBLOCK_START_TAX_QUERY_KEY', 'tax_query__' );
define(
	'DRAG_BLOCK_DEFAULT_THEME_JSON',
	array(
		'$schema' => 'https://schemas.wp.org/wp/6.2/theme.json',
		'settings' =>
		array(
			'layout' =>
			array(
				'contentSize' => '1000px',
				'wideSize' => '1200px',
			),
			'color' =>
			array(
				'palette' => array(
					'theme' => array(
						0 =>
						array(
							'name' => 'Primary',
							'slug' => 'primary',
							'color' => '#976CEC',
						),
						1 =>
						array(
							'name' => 'Secondary',
							'slug' => 'secondary',
							'color' => '#E18CC9',
						),
						2 =>
						array(
							'name' => 'Tertiary',
							'slug' => 'tertiary',
							'color' => '#1dd1a1',
						),
						3 =>
						array(
							'name' => 'Base',
							'slug' => 'base',
							'color' => '#FAFAFA',
						),
						4 =>
						array(
							'name' => 'Contrast',
							'slug' => 'contrast',
							'color' => '#2D2D2D',
						),
					),
				),
			),
			'blocks' =>
			array(
				'core/site-title' =>
				array(
					'typography' =>
					array(
						'fontFamilies' =>
						array(),
					),
				),
			),
			'typography' =>
			array(
				'fontFamilies' => array(
					'default' =>  array(
						0 =>
						array(
							'fontFamily' => 'Arial, Helvetica, sans-serif',
							'name' => 'Arial',
							'slug' => 'arial',
						),
						1 =>
						array(
							'fontFamily' => '\'Arial Narrow\', Arial, sans-serif',
							'name' => 'Arial Narrow',
							'slug' => 'arial-narrow',
						),
						2 =>
						array(
							'fontFamily' => '\'Arial Black\', sans-serif',
							'name' => 'Arial Black',
							'slug' => 'arial-black',
						),
						3 =>
						array(
							'fontFamily' => '\'Book Antiqua\', Palatino, serif',
							'name' => 'Book Antiqua',
							'slug' => 'book-antiqua',
						),
						4 =>
						array(
							'fontFamily' => 'Cambria, Cochin, Georgia, Times, \'Times New Roman\', serif',
							'name' => 'Cambria',
							'slug' => 'cambria',
						),
						5 =>
						array(
							'fontFamily' => '\'Century Gothic\', sans-serif',
							'name' => 'Century Gothic',
							'slug' => 'century-gothic',
						),
						6 =>
						array(
							'fontFamily' => '\'Courier New\', Courier, monospace',
							'name' => 'Courier New',
							'slug' => 'courier-new',
						),
						7 =>
						array(
							'fontFamily' => 'cursive',
							'name' => 'Cursive',
							'slug' => 'cursive',
						),
						8 =>
						array(
							'fontFamily' => '\'Franklin Gothic Medium\', \'Arial Narrow\', Arial, sans-serif',
							'name' => 'Franklin Gothic Medium',
							'slug' => 'franklin-gothic-medium',
						),
						9 =>
						array(
							'fontFamily' => 'Georgia, \'Times New Roman\', Times, serif',
							'name' => 'Georgia',
							'slug' => 'georgia',
						),
						10 =>
						array(
							'fontFamily' => '\'Gill Sans\', \'Gill Sans MT\', Calibri, \'Trebuchet MS\', sans-serif',
							'name' => 'Gill Sans',
							'slug' => 'gill-sans',
						),
						11 =>
						array(
							'fontFamily' => 'Impact, Haettenschweiler, \'Arial Narrow Bold\', sans-serif',
							'name' => 'Impact',
							'slug' => 'impact',
						),
						12 =>
						array(
							'fontFamily' => '\'Lucida Console\', monaco, monospace',
							'name' => 'Lucida Console',
							'slug' => 'lucida-console',
						),
						13 =>
						array(
							'fontFamily' => '\'Lucida Sans\', \'Lucida Sans Regular\', \'Lucida Grande\', \'Lucida Sans Unicode\', Geneva, Verdana, sans-serif',
							'name' => 'Lucida Sans',
							'slug' => 'lucida-sans',
						),
						14 =>
						array(
							'fontFamily' => 'monospace',
							'name' => 'Monospace',
							'slug' => 'monospace',
						),
						15 =>
						array(
							'fontFamily' => 'Tahoma, \'Segoe UI\', Geneva, Verdana, sans-serif',
							'name' => 'Tahoma',
							'slug' => 'tahoma',
						),
						16 =>
						array(
							'fontFamily' => '\'Times New Roman\', Times, \'Brush Script MT\', serif',
							'name' => 'Times New Roman',
							'slug' => 'times-new-roman',
						),
						17 =>
						array(
							'fontFamily' => '\'Trebuchet MS\', \'Lucida Sans Unicode\', \'Lucida Grande\', \'Lucida Sans\', Arial, sans-serif',
							'name' => 'Trebuchet MS',
							'slug' => 'trebuchet-ms',
						),
						18 =>
						array(
							'fontFamily' => 'Verdana, Geneva, Tahoma, sans-serif',
							'name' => 'Verdana',
							'slug' => 'verdana',
						),
					),
				),
			),
		),
		'styles' =>
		array(
			'typography' =>
			array(
				'fontFamily' => '',
			),
			'color' =>
			array(
				'text' => 'var(--wp--preset--color--contrast)',
				'background' => 'var(--wp--preset--color--base)',
			),
			'elements' =>
			array(
				'link' =>
				array(
					'typography' =>
					array(
						'textDecoration' => 'none',
					),
					'color' =>
					array(
						'text' => 'var(--wp--preset--color--primary)',
					),
					':hover' =>
					array(
						'color' =>
						array(
							'text' => 'var(--wp--preset--color--secondary)',
						),
					),
				),
				'button' =>
				array(
					'typography' =>
					array(
						'textDecoration' => 'none',
					),
					'color' =>
					array(
						'text' => 'var(--wp--preset--color--tertiary)',
						'background' => 'var(--wp--preset--color--primary)',
					),
				),
				'heading' =>
				array(
					'color' =>
					array(
						'text' => 'var(--wp--preset--color--contrast)',
					),
				),
			),
		),
	)
);
// dev-reply#20269.
define( 'DRAGBLOCK_CUSTOM_DEFAULT_STYLE', false );
add_action( 'init', 'dragblock_init_defines', 1 );
/**
 * Check Documentation#20252
 */
function dragblock_init_defines() {
	$dragblock_b_upload = wp_upload_dir();
	define( 'DRAGBLOCK_UPLOAD_DIR', $dragblock_b_upload['basedir'] . '/dragblock' );
	define( 'DRAGBLOCK_UPLOAD_URL', $dragblock_b_upload['baseurl'] . '/dragblock' );
	// dev-reply#20283.
}
require_once 'library/server/index.php';
require_once 'applications/admin-menu/server/index.php';
require_once 'blocks/block-register.php';
require_once 'applications/tutorials/server/index.php';
require_once 'applications/patterns/server/index.php';
require_once 'applications/form-entries/server/index.php';
require_once 'applications/font-library/server/index.php';
require_once 'applications/theme-settings/server/index.php';
require_once 'applications/shortcodes/server/index.php';
require_once 'applications/editor-init/server/index.php';
require_once 'applications/editor-panel-database/server/index.php'; // dev-reply#20300.
require_once 'applications/editor-panel-content/server/index.php';
require_once 'applications/editor-panel-appearance/server/index.php';
require_once 'applications/editor-panel-attributes/server/index.php';
require_once 'applications/editor-panel-interactions/server/index.php';
require_once 'applications/editor-panel-renderability/server/index.php';
require_once 'applications/editor-toolbars/server/index.php';
$dragblock_b_dir = array(
	'post_type' => 'post',
	'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => array( 'quotes' ),
		),
		array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-quote' ),
			),
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array( 'wisdom' ),
			),
		),
	),
);
// dev-reply#20337.
