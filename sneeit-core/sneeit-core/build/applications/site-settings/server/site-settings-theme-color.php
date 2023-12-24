<?php
/**
 * DragBlock's Site-settings.
 *
 * @package Site settings theme color
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#23.
/**
 * Check Documentation#23
 */
function sneeit_core_site_settings_theme_color_field() {
?>
	<div class="sneeit_core-theme-color-setting-input-wrapper">
		<input type="text" name="<?php echo SNEEIT_CORE_SITE_THEME_COLOR_META_KEY ?>" id="<?php echo SNEEIT_CORE_SITE_THEME_COLOR_META_KEY ?>" class="color-input" value="<?php echo esc_attr( get_option( SNEEIT_CORE_SITE_THEME_COLOR_META_KEY, '' ) ); ?>" />
	</div>
	<p class="description"><?php _e( 'Color of site tab on mobile browsers', 'sneeit_core' ); ?></p>
<?php
}
add_action( 'admin_init', 'sneeit_core_site_settings_theme_color_init' );
/**
 * Check Documentation#213
 */
function sneeit_core_site_settings_theme_color_init() {
	add_settings_field(
		SNEEIT_CORE_SITE_THEME_COLOR_META_KEY,
		esc_html__( 'Site Theme Color', 'sneeit_core' ),
		'sneeit_core_site_settings_theme_color_field',
		'general'
	);
	register_setting( 'general', SNEEIT_CORE_SITE_THEME_COLOR_META_KEY );
}
add_action( 'wp_head', 'sneeit_core_theme_color_meta_tag' );
/**
 * Check Documentation#224
 */
function sneeit_core_theme_color_meta_tag() {
	$sneeit_core_sstc_theme = get_option( SNEEIT_CORE_SITE_THEME_COLOR_META_KEY, '' );
	echo '<meta name="theme-color" content="' . esc_attr( $sneeit_core_sstc_theme ) . '" />';
}
?>
