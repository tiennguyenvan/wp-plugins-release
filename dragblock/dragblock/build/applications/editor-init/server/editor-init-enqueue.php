<?php
/**
 * DragBlock's Editor-init.
 *
 * @package Editor init enqueue
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#103.
define( 'COLOR_VAR_V0_START', '{c=' );
define( 'COLOR_VAR_V0_ALPHA_SEP', '@' );
define( 'COLOR_VAR_V0_END', '}' );
// dev-reply#109.
define( 'COLOR_VAR_V1_START', '▶c=' );
define( 'COLOR_VAR_V1_ALPHA_SEP', '▲━🄰' );
define( 'COLOR_VAR_V1_BACKUP_SEP', '▼c=' );
define( 'COLOR_VAR_V1_END', 'c◀' );
define( 'GRADIENT_VAR_V1_START', '⮕g=' );
define( 'GRADIENT_VAR_V1_BACKUP_SEP', '⬇g=' );
define( 'GRADIENT_VAR_V1_END', 'g⬅' );
// dev-reply#1028.
define( 'COLOR_VAR_V2_START', '/*@@dragBlockColorStart*/var(--wp--preset--color--' );
define( 'COLOR_VAR_V2_BACKUP_SEP', ',/*backupColor*/' );
define( 'COLOR_VAR_V2_ALPHA_SEP', '/*hasAlphaAppender=' );
define( 'COLOR_VAR_V2_END', '/*@@dragBlockColorEnd*/)' );
define( 'GRADIENT_VAR_V2_START', '/*@@dragBlockGradientStart*/var(--wp--preset--gradient--' );
define( 'GRADIENT_VAR_V2_BACKUP_SEP', ',/*backupGradient*/' );
define( 'GRADIENT_VAR_V2_END', '/*@@dragBlockGradientEnd*/)' );
add_action( 'enqueue_block_editor_assets', 'dragblock_editor_init_editor_assets' );
/**
 * Check Documentation#1023
 */
function dragblock_editor_init_editor_assets() {
	// dev-reply#1060.
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
	// dev-reply#1095.
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
		'themeUri' => get_stylesheet_directory_uri(),
		'startTaxQueryKey' => DRAGBLOCK_START_TAX_QUERY_KEY,
		'postViewsKey' => DRAGBLOCK_POST_VIEWS_KEY,
		// dev-reply#10115.
		'colorVarV0Start' => COLOR_VAR_V0_START,
		'colorVarV0AlphaSep' => COLOR_VAR_V0_ALPHA_SEP,
		'colorVarV0End' => COLOR_VAR_V0_END,
		'colorVarV1Start' => COLOR_VAR_V1_START,
		'colorVarV1AlphaSep' => COLOR_VAR_V1_ALPHA_SEP,
		'colorVarV1BackupSep' => COLOR_VAR_V1_BACKUP_SEP,
		'colorVarV1End' => COLOR_VAR_V1_END,
		'gradientVarV1Start' => GRADIENT_VAR_V1_START,
		'gradientVarV1BackupSep' => GRADIENT_VAR_V1_BACKUP_SEP,
		'gradientVarV1End' => GRADIENT_VAR_V1_END,
		// dev-reply#10127.
		'colorVarV2Start' => COLOR_VAR_V2_START,
		'colorVarV2BackupSep' => COLOR_VAR_V2_BACKUP_SEP, // dev-reply#10129.
		'colorVarV2AlphaSep' => COLOR_VAR_V2_ALPHA_SEP,
		'colorVarV2End' => COLOR_VAR_V2_END,
		'gradientVarV2Start' => GRADIENT_VAR_V2_START,
		'gradientVarV2BackupSep' => GRADIENT_VAR_V2_BACKUP_SEP, // dev-reply#10134.
		'gradientVarV2End' => GRADIENT_VAR_V2_END,
	) );
	// dev-reply#10138.
	wp_localize_script( DRAGBLOCK_EDITOR_INIT_SLUG, 'dragBlockEditorInit', $dragblock_eie_family );
}
add_action( 'after_setup_theme', 'dragblock_editor_init_editor_iframe', 100 );
/**
 * Check Documentation#1096
 */
function dragblock_editor_init_editor_iframe() {
	add_editor_style( DRAGBLOCK_URL . 'assets/css/animate.min.css' );
	// dev-reply#10152.
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		add_editor_style( DRAGBLOCK_URL . 'build/applications/editor-init/client/front/style-index.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'dragblock_editor_init_front_scripts' );
/**
 * Check Documentation#10105
 */
function dragblock_editor_init_front_scripts() {
	// dev-reply#10165.
	dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/index.js' );
	if ( ! DRAGBLOCK_CUSTOM_DEFAULT_STYLE ) {
		dragblock_enqueue( DRAGBLOCK_EDITOR_INIT_SLUG, 'build/applications/editor-init/client/front/style-index.css' );
	}
}
