<?php
/**
 * DragBlock's Form-entries.
 *
 * @package Form defines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_FORM_ENTRY', sanitize_key( 'dragBlockFormMsg' ) ); // dev-reply#16.
define( 'DRAGBLOCK_FORM_ACTION_SHORTCODE', '[dragblock.form.action]' );
define( 'DRAGBLOCK_FORM_CLIENT_ID_FIELD_NAME', 'dragblock/form-client-id' );
define( 'DRAGBLOCK_FORM_TITLE_FIELD_NAME', 'dragblock/form-title' );
global $dragblock_form_entries_message_error;
$dragblock_form_entries_message_error = array();
