<?php
/**
 * DragBlock's Patterns.
 *
 * @package Patterns defines
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'DRAGBLOCK_PATTERNS', sanitize_key( 'dragBlockPatterns' ) ); // dev-reply#16.
define( 'DRAGBLOCK_PATTERN_SETS', sanitize_key( 'dragBlockPatternSets' ) ); // dev-reply#17.
global $dragblock_form_entries_message_error;
$dragblock_form_entries_message_error = array();
