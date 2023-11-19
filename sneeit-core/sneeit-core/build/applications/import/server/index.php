<?php
/**
 * DragBlock's Applications.
 *
 * @package Import
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// dev-reply#12.
sneeit_core_admin_app_register( 'import', 'Import Demos' );
require_once 'load-all-demos.php';
require_once 'load-selected-demo-content.php';
require_once 'import-plugins.php';
require_once 'import-options.php';
require_once 'import-terms.php';
require_once 'import-posts.php';
require_once 'import-comments.php';
require_once 'import-fonts.php';
