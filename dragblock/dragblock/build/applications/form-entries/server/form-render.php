<?php
/**
 * DragBlock's Form-entries.
 *
 * @package Form render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $dragblock_form_script_required;
$dragblock_form_script_required = false;
add_filter( 'render_block', 'dragblock_form_render', 10, 2 );
/**
 * Check Documentation#95
 *
 * @param object|array|string $dragblock_0 check var-def#95.
 * @param object|array|string $dragblock_1 check var-def#95.
 */
function dragblock_form_render( $dragblock_0, $dragblock_1 ) {
	// dev-reply#910.
	if ( empty( $dragblock_1['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_0;
	}
	// dev-reply#915.
	if (
		'dragblock/form' !== $dragblock_1['blockName'] ||
		strpos( $dragblock_0, '[dragblock.form.action]' ) === false
	) {
		return $dragblock_0;
	}
	global $dragblock_form_script_required;
	$dragblock_form_script_required = true;
	// dev-reply#926.
	$dragblock_2 = false;
	if ( $dragblock_1['attrs']['dragBlockAttrs'] ) {
		foreach ( $dragblock_1['attrs']['dragBlockAttrs'] as $dragblock_3 ) {
			if ( 'action' === $dragblock_3['slug'] ) {
				if ( trim( $dragblock_3['value'] ) === '[dragblock.form.action]' ) {
					$dragblock_2 = true;
				}
				break;
			}
		}
	}
	// dev-reply#939.
	if ( ! $dragblock_2 ) {
		return $dragblock_0;
	}
	// dev-reply#944.
	$dragblock_4 = '';
	foreach ( $dragblock_1['attrs']['dragBlockAttrs'] as $dragblock_3 ) {
		if ( 'name' === $dragblock_3['slug'] ) {
			if ( $dragblock_3['value'] ) {
				$dragblock_4 = $dragblock_3['value'];
			}
			break;
		}
	}
	if ( ! $dragblock_4 && $dragblock_1['attrs']['dragBlockClientId'] ) {
		$dragblock_4 = $dragblock_1['attrs']['dragBlockClientId'];
	}
	// dev-reply#962.
	$dragblock_5 = strrpos( $dragblock_0, '</form>' );
	if ( false !== $dragblock_5 ) {
		$dragblock_6 = '';
		// dev-reply#966.
		if ( $dragblock_4 ) {
			// dev-reply#968.
			if ( strlen( $dragblock_4 ) > 32 ) {
				$dragblock_4 = substr( $dragblock_4, 0, 32 );
			}
			// dev-reply#973.
			$dragblock_4 = sanitize_key( $dragblock_4 );
			$dragblock_6 .= '<input type="hidden" name="dragblock/form-client-id" value="' . esc_attr( $dragblock_4 ) . '"/>';
		}
		// dev-reply#979.
		$dragblock_6 .= '<input type="text" name="dragblock/form-title" value="">';
		$dragblock_0 = substr( $dragblock_0, 0, $dragblock_5 ) . ' ' . $dragblock_6 . substr( $dragblock_0, $dragblock_5 );
	}
	// dev-reply#989.
	global $dragblock_form_entries_message_error;
	// dev-reply#992.
	$dragblock_7 = 'class="';
	$dragblock_8 = strpos( $dragblock_0, $dragblock_7 );
	if ( false === $dragblock_8 ) {
		$dragblock_7 = 'class=\'';
		$dragblock_8 = strpos( $dragblock_0, $dragblock_7 );
	}
	if ( false !== $dragblock_8 && isset( $dragblock_form_entries_message_error[ $dragblock_4 ] ) ) {
		$dragblock_8 += strlen( $dragblock_7 );
		if ( false === $dragblock_form_entries_message_error[ $dragblock_4 ] ) {
			// dev-reply#9104.
			$dragblock_0 = substr( $dragblock_0, 0, $dragblock_8 ) . 'pass ' . substr( $dragblock_0, $dragblock_8 );
		} else {
			// dev-reply#9107.
			$dragblock_0 = substr( $dragblock_0, 0, $dragblock_8 ) . 'fail ' . substr( $dragblock_0, $dragblock_8 );
		}
	}
	// dev-reply#9112.
	$dragblock_0 = str_replace(
		'[dragblock.form.message.error]',
		! empty( $dragblock_form_entries_message_error[ $dragblock_4 ] ) ? $dragblock_form_entries_message_error[ $dragblock_4 ] : '',
		$dragblock_0
	);
	// dev-reply#9119.
	$dragblock_0 = str_replace( '[dragblock.form.action]', '', $dragblock_0 );
	return $dragblock_0;
}
