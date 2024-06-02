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
add_filter( 'render_block', 'dragblock_form_render', 20, 2 );
/**
 * Check Documentation#105
 *
 * @param object|array|string $dragblock_fr_dragblock check var-def#105.
 * @param object|array|string $dragblock_fr_form check var-def#105.
 */
function dragblock_form_render( $dragblock_fr_dragblock, $dragblock_fr_form ) {
	// dev-reply#1029.
	if (
		'dragblock/form' !== $dragblock_fr_form['blockName'] ||
		empty( $dragblock_fr_form['attrs']['dragBlockClientId'] )
	) {
		return $dragblock_fr_dragblock;
	}
	// dev-reply#1039.
	global $dragblock_form_script_required;
	$dragblock_form_script_required = true;
	// dev-reply#1047.
	$dragblock_fr_script = false;
	if ( $dragblock_fr_form['attrs']['dragBlockAttrs'] ) {
		foreach ( $dragblock_fr_form['attrs']['dragBlockAttrs'] as $dragblock_fr_required ) {
			if ( 'action' === $dragblock_fr_required['slug'] ) {
				if ( trim( $dragblock_fr_required['value'] ) === DRAGBLOCK_FORM_ACTION_SHORTCODE ) {
					$dragblock_fr_script = true;
				}
				break;
			}
		}
	}
	// dev-reply#1062.
	if ( ! $dragblock_fr_script ) {
		// dev-reply#1064.
		$dragblock_fr_dragblock = str_replace( DRAGBLOCK_WP_RESEVED_TERMS_PLACEHOLDER, '', $dragblock_fr_dragblock );
		return $dragblock_fr_dragblock;
	}
	// dev-reply#1069.
	$dragblock_fr_block = '';
	foreach ( $dragblock_fr_form['attrs']['dragBlockAttrs'] as $dragblock_fr_required ) {
		if ( 'name' === $dragblock_fr_required['slug'] ) {
			if ( $dragblock_fr_required['value'] ) {
				$dragblock_fr_block = $dragblock_fr_required['value'];
			}
			break;
		}
	}
	if ( ! $dragblock_fr_block && $dragblock_fr_form['attrs']['dragBlockClientId'] ) {
		$dragblock_fr_block = $dragblock_fr_form['attrs']['dragBlockClientId'];
	}
	// dev-reply#1086.
	$dragblock_fr_content = strrpos( $dragblock_fr_dragblock, '</form>' );
	if ( false !== $dragblock_fr_content ) {
		$dragblock_fr_parsed = '';
		// dev-reply#1090.
		if ( $dragblock_fr_block ) {
			// dev-reply#1092.
			if ( strlen( $dragblock_fr_block ) > 32 ) {
				$dragblock_fr_block = substr( $dragblock_fr_block, 0, 32 );
			}
			// dev-reply#1097.
			$dragblock_fr_block = sanitize_key( $dragblock_fr_block );
			$dragblock_fr_parsed .= '<input type="hidden" name="' . DRAGBLOCK_FORM_CLIENT_ID_FIELD_NAME . '" value="' . esc_attr( $dragblock_fr_block ) . '"/>';
		}
		// dev-reply#10103.
		$dragblock_fr_parsed .= '<input type="text" name="' . DRAGBLOCK_FORM_TITLE_FIELD_NAME . '" value="">';
		$dragblock_fr_dragblock = substr( $dragblock_fr_dragblock, 0, $dragblock_fr_content ) . ' ' . $dragblock_fr_parsed . substr( $dragblock_fr_dragblock, $dragblock_fr_content );
	}
	// dev-reply#10113.
	global $dragblock_form_entries_message_error;
	// dev-reply#10116.
	$dragblock_fr_has = 'class="';
	$dragblock_fr_action = strpos( $dragblock_fr_dragblock, $dragblock_fr_has );
	if ( false === $dragblock_fr_action ) {
		$dragblock_fr_has = 'class=\'';
		$dragblock_fr_action = strpos( $dragblock_fr_dragblock, $dragblock_fr_has );
	}
	if ( false !== $dragblock_fr_action && isset( $dragblock_form_entries_message_error[ $dragblock_fr_block ] ) ) {
		$dragblock_fr_action += strlen( $dragblock_fr_has );
		if ( false === $dragblock_form_entries_message_error[ $dragblock_fr_block ] ) {
			// dev-reply#10128.
			$dragblock_fr_dragblock = substr( $dragblock_fr_dragblock, 0, $dragblock_fr_action ) . 'pass ' . substr( $dragblock_fr_dragblock, $dragblock_fr_action );
		} else {
			// dev-reply#10131.
			$dragblock_fr_dragblock = substr( $dragblock_fr_dragblock, 0, $dragblock_fr_action ) . 'fail ' . substr( $dragblock_fr_dragblock, $dragblock_fr_action );
		}
	}
	// dev-reply#10136.
	$dragblock_fr_dragblock = str_replace(
		'[dragblock.form.message.error]',
		! empty( $dragblock_form_entries_message_error[ $dragblock_fr_block ] ) ? $dragblock_form_entries_message_error[ $dragblock_fr_block ] : '',
		$dragblock_fr_dragblock
	);
	// dev-reply#10143.
	$dragblock_fr_dragblock = str_replace( DRAGBLOCK_FORM_ACTION_SHORTCODE, '', $dragblock_fr_dragblock );
	return $dragblock_fr_dragblock;
}
