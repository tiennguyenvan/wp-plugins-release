<?php
/**
 * DragBlock's Tutorials.
 *
 * @package Tutorials register
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
sneeit_core_enqueue_app( 'tutorials', 'editor', array( 'wp-pointer' ) );
