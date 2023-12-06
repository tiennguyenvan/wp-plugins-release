<?php
/**
 * DragBlock's Site-settings.
 *
 * @package Site settings favicon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_SITE_FAVICON_META_KEY', 'dragblock_site_favicon' );
// dev-reply#33.
/**
 * Check Documentation#34
 */
function dragblock_site_settings_favicon_field() {
?>
	<div class="dragblock-favicon-setting-input-wrapper">
		<input type="url" name="<?php echo DRAGBLOCK_SITE_FAVICON_META_KEY ?>" id="<?php echo DRAGBLOCK_SITE_FAVICON_META_KEY ?>" class="regular-text" value="<?php echo esc_attr( get_option( DRAGBLOCK_SITE_FAVICON_META_KEY ) ); ?>" />
		<button type="button" class="button button-secondary" id="<?php echo DRAGBLOCK_SITE_FAVICON_META_KEY ?>"><?php _e( 'Upload Media', 'dragblock' ); ?></button>
	</div>
	<p class="description"><?php _e( 'Enter the SRC of your custom favicon image', 'dragblock' ); ?></p>
<?php
}
add_action( 'admin_init', 'dragblock_site_settings_favicon_init' );
/**
 * Check Documentation#315
 */
function dragblock_site_settings_favicon_init() {
	add_settings_field( DRAGBLOCK_SITE_FAVICON_META_KEY, esc_html__( 'Site Favicon', 'dragblock' ), 'dragblock_site_settings_favicon_field', 'general' );
	register_setting( 'general', DRAGBLOCK_SITE_FAVICON_META_KEY );
}
add_action( 'dragblock_seo_meta_graphs', 'dragblock_favicon_meta_tag', 1 );
/**
 * Check Documentation#321
 */
function dragblock_favicon_meta_tag() {
	$dragblock_ssf_meta = get_option( DRAGBLOCK_SITE_FAVICON_META_KEY );
	if ( $dragblock_ssf_meta ) {
		echo '<link rel="icon" href="' . esc_url( $dragblock_ssf_meta ) . '" type="image/x-icon" />';
		echo '<link rel="shortcut icon" href="' . esc_url( $dragblock_ssf_meta ) . '" type="image/x-icon" />';
	}
}
