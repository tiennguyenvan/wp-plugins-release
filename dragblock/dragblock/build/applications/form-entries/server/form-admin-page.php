<?php
/**
 * DragBlock's Form-entries.
 *
 * @package Form admin page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'admin_menu', 'dragblock_admin_menu_form_entries' );
/**
 * Check Documentation#73
 */
function dragblock_admin_menu_form_entries() {
	add_submenu_page(
		DRAGBLOCK_ADMIN_MENU_SLUG,
		esc_html__( 'DragBlock - Form Entries', 'dragblock' ),
		esc_html__( 'Form Entries', 'dragblock' ),
		'manage_options',
		'edit.php?post_type=' . DRAGBLOCK_FORM_ENTRY,
		''
	);
}
add_filter( 'manage_' . DRAGBLOCK_FORM_ENTRY . '_posts_columns', 'dragblock_manage_posts_columns_form_entries' );
/**
 * Check Documentation#715
 *
 * @param object|array|string $dragblock_0 check var-def#715.
 */
function dragblock_manage_posts_columns_form_entries( $dragblock_0 ) {
	unset( $dragblock_0['date'] );
	$dragblock_0['content'] = esc_html__( 'Content', 'dragblock' );
	$dragblock_0['referrer'] = esc_html__( 'Referrer', 'dragblock' );
	$dragblock_0['email'] = esc_html__( 'Emailed', 'dragblock' );
	$dragblock_0['date'] = esc_html__( 'Date', 'dragblock' );
	return $dragblock_0;
}
add_action( 'manage_' . DRAGBLOCK_FORM_ENTRY . '_posts_custom_column', 'dragblock_manage_posts_custom_column_form_entries', 10, 2 );
/**
 * Check Documentation#725
 *
 * @param object|array|string $dragblock_1 check var-def#725.
 * @param object|array|string $dragblock_2 check var-def#725.
 */
function dragblock_manage_posts_custom_column_form_entries( $dragblock_1, $dragblock_2 ) {
	if ( 'content' === $dragblock_1 ) {
		echo wp_kses(
			get_the_content( $dragblock_2 ),
			array(
				'strong' => array(),
				'p' => array(),
			)
		);
		return;
	}
	if ( 'referrer' === $dragblock_1 ) {
		$dragblock_3 = get_post_meta( $dragblock_2, DRAGBLOCK_FORM_ENTRY . '--_wp_http_referer', true );
		$dragblock_4 = '<a target="_blank" href="' . esc_url( $dragblock_3 ) . '">' . esc_html( $dragblock_3 ) . '</a>';
		echo wp_kses(
			$dragblock_4,
			array(
				'a' => array(
					'target' => array(),
					'href' => array(),
				),
			)
		);
		return;
	}
	if ( 'email' === $dragblock_1 ) {
		$dragblock_5 = get_post_meta( $dragblock_2, DRAGBLOCK_FORM_ENTRY . '-failed-email', true );
		if ( 'PASSED' === $dragblock_5 ) {
			echo wp_kses(
				'<span class="dragblock-form-emailed-successful">' . esc_html__( 'SENT', 'dragblock' ) . '</span>',
				array(
					'span' => array(
						'class' => array(),
					),
				)
			);
		} elseif ( ! $dragblock_5 ) {
			echo wp_kses(
				'<strong class="dragblock-form-emailed-local">' . esc_html__( 'LOCAL', 'dragblock' ) . '</strong>',
				array(
					'strong' => array(
						'class' => array(),
					),
				)
			);
		} else {
			echo wp_kses(
				'<strong class="dragblock-form-emailed-failed">' . esc_html__( 'FAILED', 'dragblock' ) . '</strong>',
				array(
					'strong' => array(
						'class' => array(),
					),
				)
			);
		}
		return;
	}
}
