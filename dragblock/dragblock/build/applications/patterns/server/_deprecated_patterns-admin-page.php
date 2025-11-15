<?php
/**
 * DragBlock's Patterns.
 *
 * @package _deprecated_patterns admin page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_menu', 'dragblock_admin_menu_patterns' );
/**
 * Check Documentation#153
 */
function dragblock_admin_menu_patterns() {
	add_submenu_page(
		DRAGBLOCK_ADMIN_MENU_SLUG,
		esc_html__( 'Pattern Sets', 'dragblock' ),
		esc_html__( 'Pattern Sets', 'dragblock' ),
		'manage_options',
		DRAGBLOCK_PATTERNS,
		'dragblock_render_patterns_page' // dev-reply#1518.
	);
}
/**
 * Check Documentation#1514
 */
function dragblock_pattern_action() {
	if ( ! isset( $_GET['nonce'] ) || ! isset( $_GET['action'] ) || ! isset( $_GET['pattern_set'] ) ) {
		return;
	}
	// dev-reply#1527.
	$dragblock__ap_get = sanitize_text_field( wp_unslash( $_GET['nonce'] ) );
	if ( ! wp_verify_nonce( $dragblock__ap_get, DRAGBLOCK_PATTERN_SETS ) ) {
		wp_die( 'Wrong nonce' );
		return;
	}
	$dragblock__ap_nonce = sanitize_text_field( wp_unslash( $_GET['action'] ) );
	$dragblock__ap_action = sanitize_text_field( wp_unslash( $_GET['pattern_set'] ) );
	$dragblock__ap_set = get_option( DRAGBLOCK_PATTERN_SETS, array( 'dragblock' => true ) );
	$dragblock__ap_set[ $dragblock__ap_action ] = ( $dragblock__ap_nonce ) === 'activate';
	update_option( DRAGBLOCK_PATTERN_SETS, $dragblock__ap_set );
}
// dev-reply#1543.
/**
 * Check Documentation#1532
 */
function dragblock_render_patterns_page() {
	// dev-reply#1546.
	dragblock_pattern_action();
	$dragblock__ap_enabled = array(
		'dragblock' => esc_html__( 'DragBlock Free Patterns', 'dragblock' ),
		'core' => esc_html__( 'WordPress Core Patterns', 'dragblock' ),
	);
	// dev-reply#1556.
	foreach ( WP_Block_Patterns_Registry::get_instance()->get_all_registered() as $dragblock__ap_pattern ) {
		$dragblock__ap_sets = ! empty( $dragblock__ap_pattern['slug'] ) ? $dragblock__ap_pattern['slug'] : (
			! empty( $dragblock__ap_pattern['name'] ) ? $dragblock__ap_pattern['name'] : ''
		);
		$dragblock__ap_sets = explode( '/', $dragblock__ap_sets )[0];
		$dragblock__ap_enabled[ $dragblock__ap_sets ] = ucwords( implode( ' ', explode( '-', $dragblock__ap_sets ) ) . ' ' . esc_html__( 'Patterns', 'dragblock' ) );
	}
	// dev-reply#1564.
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	// dev-reply#1569.
/**
	 * Check class-def#1551
	 */
	class DragBlock_Patterns_Table extends WP_List_Table {
		public $enabled_pattern_sets = array();
		/**
		 * Check Documentation#1554
		 *
		 * @param object|array|string $dragblock__ap_enabled check var-def#1554.
		 */
		function __construct( $dragblock__ap_enabled = array() ) {
			parent::__construct( array(
				'singular' => 'plugin',
				'plural'   => 'plugins', // dev-reply#1579.
				'ajax'     => false,
			) );
			$this->items = array();
			foreach ( $dragblock__ap_enabled as $dragblock__ap_sets => $dragblock__ap_slug ) {
				array_push( $this->items, array(
					'name' => $dragblock__ap_slug,
					'slug' => $dragblock__ap_sets,
				) );
			}
			// dev-reply#1590.
			$this->enabled_pattern_sets = get_option( DRAGBLOCK_PATTERN_SETS, array( 'dragblock' => true ) );
		}
		// dev-reply#1594.
		/**
		 * Check Documentation#1572
		 */
		function get_columns() {
			$dragblock__ap_this = array(
				// dev-reply#1598.
				'name'     => esc_html__( 'Pattern Sets', 'dragblock' ),
				// dev-reply#15100.,
			);
			return $dragblock__ap_this;
		}
		// dev-reply#15105.
		/**
		 * Check Documentation#1582
		 */
		function prepare_items() {
			$this->_column_headers = array( $this->get_columns(), array(), array() );
		}
		/**
		 * Check Documentation#1586
		 *
		 * @param object|array|string $dragblock__ap_name check var-def#1586.
		 */
		public function single_row( $dragblock__ap_name ) {
			$dragblock__ap_columns = isset( $dragblock__ap_name['slug'] ) ? $dragblock__ap_name['slug'] : '';
			$dragblock__ap_item = isset( $dragblock__ap_name['name'] ) ? $dragblock__ap_name['name'] : '';
			$dragblock__ap_is = ! empty( $this->enabled_pattern_sets[ $dragblock__ap_columns ] );
			// dev-reply#15117.
			$dragblock__ap_get = wp_create_nonce( DRAGBLOCK_PATTERN_SETS );
			$dragblock__ap_active = add_query_arg(
				array(
					'page' => DRAGBLOCK_PATTERNS,
					'pattern_set' => $dragblock__ap_columns,
					'action' => ( $dragblock__ap_is ? 'deactivate' : 'activate' ),
					'nonce' => $dragblock__ap_get // dev-reply#15126.,
				),
				admin_url( 'admin.php' )
			);
			$dragblock__ap_href = $dragblock__ap_is ? esc_html__( 'Deactivate', 'dragblock' ) : esc_html__( 'Activate', 'dragblock' );
			$dragblock__ap_text = $dragblock__ap_is ? 'active' : 'inactive';
			echo '<tr class="' . $dragblock__ap_text . '"><td class="plugin-title column-primary">';
			echo '<strong>' . esc_html( $dragblock__ap_item ) . '</strong>';
			echo '<a href="' . esc_attr( $dragblock__ap_active ) . '">' . esc_html( $dragblock__ap_href ) . '</a>';
			echo '</td></tr>';
		}
		// dev-reply#15141.
		/**
		 * Check Documentation#15110
		 *
		 * @param object|array|string $dragblock__ap_name check var-def#15110.
		 */
		function column_cb( $dragblock__ap_name ) {
			return '<input type="checkbox" />';
		}
	}
	// dev-reply#15148.
	$dragblock__ap_row = new DragBlock_Patterns_Table( $dragblock__ap_enabled );
	// dev-reply#15151.
	$dragblock__ap_row->prepare_items();
	$dragblock__ap_set = 0;
	foreach ( $dragblock__ap_row->enabled_pattern_sets as $dragblock__ap_pattern ) {
		if ( $dragblock__ap_pattern ) {
			$dragblock__ap_set++;
		}
	}
	// dev-reply#15161.
	echo '<div class="wrap">';
	echo '<h2>' . esc_html__( 'Pattern Sets', 'dragblock' ) . '</h2>';
	if ( $dragblock__ap_set > 3 ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Warning: Enabling more than 3 pattern sets could hang up your editor.', 'dragblock' ) . '</p></div>';
	}
	$dragblock__ap_row->display();
	echo '</div>';
}
add_filter( 'rest_api_init', 'modify_block_patterns_response', 100 );
/**
 * Check Documentation#15135
 */
function modify_block_patterns_response() {
	// dev-reply#15175.
	$dragblock__ap_set = get_option( DRAGBLOCK_PATTERN_SETS, array( 'dragblock' => true ) );
	if ( empty( $dragblock__ap_set['core'] ) ) {
		remove_theme_support( 'core-block-patterns' );
	}
	foreach ( WP_Block_Patterns_Registry::get_instance()->get_all_registered() as $dragblock__ap_pattern ) {
		$dragblock__ap_sets = ! empty( $dragblock__ap_pattern['slug'] ) ? $dragblock__ap_pattern['slug'] : (
			! empty( $dragblock__ap_pattern['name'] ) ? $dragblock__ap_pattern['name'] : ''
		);
		$dragblock__ap_class = strpos( $dragblock__ap_sets, '/' ) !== false ? explode( '/', $dragblock__ap_sets )[0] : 'core';
		if ( ! empty( $dragblock__ap_set[ $dragblock__ap_class ] ) ) {
			continue;
		}
		unregister_block_pattern( $dragblock__ap_sets );
	}
}
