<?php
/**
 * DragBlock's Theme-settings.
 *
 * @package Default theme json
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $dragblock_update_theme_json;
$dragblock_update_theme_json = null;
// dev-reply#1721.
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
// dev-reply#17265.
add_filter( 'wp_theme_json_data_theme', 'dragblock_default_theme_json', 1, 1 );
/**
 * Check Documentation#17242
 *
 * @param object|array|string $dragblock_dtj_dragblock check var-def#17242.
 */
function dragblock_default_theme_json( $dragblock_dtj_dragblock ) {
	global $dragblock_update_theme_json;
	if ( ! empty( $dragblock_update_theme_json ) ) {
		return $dragblock_dtj_dragblock->update_with( $dragblock_update_theme_json );
	}
	$dragblock_update_theme_json = $dragblock_dtj_dragblock->get_data();
	// dev-reply#17277.
	$dragblock_update_theme_json = dragblock_theme_json_merge( $dragblock_update_theme_json, DRAG_BLOCK_DEFAULT_THEME_JSON );
	if ( DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		if ( empty( $dragblock_update_theme_json['styles']['css'] ) ) {
			$dragblock_update_theme_json['styles']['css'] = '';
		}
		$dragblock_update_theme_json['styles']['css'] .= '/* START: CSS OF DRAGBLOCK */' . file_get_contents( dragblock_url( 'build/applications/front/style-index.css' ) ) . '/* END: CSS OF DRAGBLOCK */';
	}
	$dragblock_update_theme_json = apply_filters( 'dragblock_default_theme_json', $dragblock_update_theme_json );
	return $dragblock_dtj_dragblock->update_with( $dragblock_update_theme_json );
}
