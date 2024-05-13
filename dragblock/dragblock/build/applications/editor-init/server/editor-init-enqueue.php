<?php
/**
 * DragBlock's Editor-init.
 *
 * @package Editor init enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'ColorVarStart', '{c=' );
define( 'ColorVarAlphaSep', '@' );
define( 'ColorVarEnd', '}' );
define( 'ColorVarStartNew', '▶c=' );
define( 'ColorVarAlphaSepNew', '▲━🄰' );
define( 'ColorVarBackupSep', '▼c=' );
define( 'ColorVarEndNew', 'c◀' );
define( 'GradientVarStart', '⮕g=' );
define( 'GradientVarBackup', '⬇g=' );
define( 'GradientVarEnd', 'g⬅' );
add_action( 'enqueue_block_editor_assets', 'dragblock_editor_init_editor_assets' );
/**
 * Check Documentation#713
 */
function dragblock_editor_init_editor_assets() {
	// dev-reply#720.
	$dragblock_eie_font = get_option( DRAGBLOCK_FONT_LIB_SLUG, array() );
	$dragblock_eie_families = ["Arial",
		"Arial Narrow",
		"Arial Black",
		"Book Antiqua",
		"Cambria",
		"Century Gothic",
		"Courier New",
		"Cursive",
		"Franklin Gothic Medium",
		"Georgia",
		"Gill Sans",
		"Impact",
		"Lucida Console",
		"Lucida Sans",
		"Monospace",
		"Tahoma",
		"Times New Roman",
		"Trebuchet MS",
		"Verdana" ];
	foreach ( $dragblock_eie_font as $dragblock_eie_names ) {
		if ( empty( $dragblock_eie_names['fontFamily'] ) ) {
			continue;
		}
		array_unshift( $dragblock_eie_families, $dragblock_eie_names['fontFamily'] );
	}
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG . '-animate', 'assets/css/animate.min.css' );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.js', array( 'jquery' ) );
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/editor/index.css' );
	// dev-reply#755.
	$dragblock_eie_family = dragblock_admin_common_inline_init_script( array(
		'fontName' => $dragblock_eie_families,
		'taxonomies' => array_keys(
			get_taxonomies(
				array(
					'public'   => true,
					'_builtin' => false,
				)
			)
		),
		'postTypes' => array_keys( get_post_types() ),
		'startTaxQueryKey' => DRAGBLOCK_START_TAX_QUERY_KEY,
		// dev-reply#773.
		'colorVarStart' => ColorVarStart,
		'colorVarAlphaSep' => ColorVarAlphaSep,
		'colorVarEnd' => ColorVarEnd,
		'colorVarStartNew' => ColorVarStartNew,
		'colorVarAlphaSepNew' => ColorVarAlphaSepNew,
		'colorVarBackupSep' => ColorVarBackupSep, // dev-reply#780.
		'colorVarEndNew' => ColorVarEndNew,
		'gradientVarStart' => GradientVarStart,
		'gradientVarBackup' => GradientVarBackup, // dev-reply#784.
		'gradientVarEnd' => GradientVarEnd,
	) );
	// dev-reply#788.
	wp_localize_script( DRAGBLOCK_EDITOR_INIT_SLUG, 'dragBlockEditorInit', $dragblock_eie_family );
}
add_action( 'after_setup_theme', 'dragblock_editor_init_editor_iframe', 100 );
/**
 * Check Documentation#776
 */
function dragblock_editor_init_editor_iframe() {
	add_editor_style( DRAGBLOCK_URL . 'assets/css/animate.min.css' );
	// dev-reply#7102.
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		add_editor_style( DRAGBLOCK_URL . 'build/applications/editor-init/client/front/style-index.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'dragblock_editor_init_front_scripts' );
/**
 * Check Documentation#785
 */
function dragblock_editor_init_front_scripts() {
	// dev-reply#7115.
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/index.js' );
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/style-index.css' );
	}
}
