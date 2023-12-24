<?php
/**
 * DragBlock's Site-settings.
 *
 * @package Site settings favicon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#33.
/**
 * Check Documentation#33
 */
function sneeit_core_site_settings_favicon_field() {
?>
	<div class="sneeit_core-favicon-setting-input-wrapper">
		<input type="url" name="<?php echo SNEEIT_CORE_SITE_FAVICON_META_KEY ?>" id="<?php echo SNEEIT_CORE_SITE_FAVICON_META_KEY ?>" class="regular-text" value="<?php echo esc_attr( get_option( SNEEIT_CORE_SITE_FAVICON_META_KEY ) ); ?>" />
		<button type="button" class="button button-secondary" id="<?php echo SNEEIT_CORE_SITE_FAVICON_META_KEY ?>"><?php _e( 'Upload Media', 'sneeit_core' ); ?></button>
	</div>
	<p class="description"><?php _e( 'Enter the SRC of your custom favicon image', 'sneeit_core' ); ?></p>
<?php
}
add_action( 'admin_init', 'sneeit_core_site_settings_favicon_init' );
/**
 * Check Documentation#314
 */
function sneeit_core_site_settings_favicon_init() {
	add_settings_field( SNEEIT_CORE_SITE_FAVICON_META_KEY, esc_html__( 'Site Favicon', 'sneeit_core' ), 'sneeit_core_site_settings_favicon_field', 'general' );
	register_setting( 'general', SNEEIT_CORE_SITE_FAVICON_META_KEY );
}
add_action( 'sneeit_core_seo_meta_graphs', 'sneeit_core_favicon_meta_tag', 1 );
/**
 * Check Documentation#320
 */
function sneeit_core_favicon_meta_tag() {
	$sneeit_core_ssf_meta = get_option( SNEEIT_CORE_SITE_FAVICON_META_KEY );
	if ( $sneeit_core_ssf_meta ) {
		echo '<link rel="icon" href="' . esc_url( $sneeit_core_ssf_meta ) . '" type="image/x-icon" />';
		echo '<link rel="shortcut icon" href="' . esc_url( $sneeit_core_ssf_meta ) . '" type="image/x-icon" />';
	}
}
