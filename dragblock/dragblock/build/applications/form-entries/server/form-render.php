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
 * @param object|array|string $dragblock_fr_block_content check var-def#95.
 * @param object|array|string $dragblock_fr_parsed_block check var-def#95.
 */
function dragblock_form_render( $dragblock_fr_block_content, $dragblock_fr_parsed_block ) {
	// dev-reply#911.
	if ( empty( $dragblock_fr_parsed_block['attrs']['dragBlockClientId'] ) ) {
		return $dragblock_fr_block_content;
	}
	// dev-reply#917.
	if (
		'dragblock/form' !== $dragblock_fr_parsed_block['blockName'] ||
		strpos( $dragblock_fr_block_content, '[dragblock.form.action]' ) === false
	) {
		return str_replace( '__dragblock_wp_reseved_terms', '', $dragblock_fr_block_content );
	}
	global $dragblock_form_script_required;
	$dragblock_form_script_required = true;
	// dev-reply#928.
	$dragblock_fr_hasaction = false;
	if ( $dragblock_fr_parsed_block['attrs']['dragBlockAttrs'] ) {
		foreach ( $dragblock_fr_parsed_block['attrs']['dragBlockAttrs'] as $dragblock_fr_attr ) {
			if ( 'action' === $dragblock_fr_attr['slug'] ) {
				if ( trim( $dragblock_fr_attr['value'] ) === '[dragblock.form.action]' ) {
					$dragblock_fr_hasaction = true;
				}
				break;
			}
		}
	}
	// dev-reply#941.
	if ( ! $dragblock_fr_hasaction ) {
		return $dragblock_fr_block_content;
	}
	// dev-reply#946.
	$dragblock_fr_formclientid = '';
	foreach ( $dragblock_fr_parsed_block['attrs']['dragBlockAttrs'] as $dragblock_fr_attr ) {
		if ( 'name' === $dragblock_fr_attr['slug'] ) {
			if ( $dragblock_fr_attr['value'] ) {
				$dragblock_fr_formclientid = $dragblock_fr_attr['value'];
			}
			break;
		}
	}
	if ( ! $dragblock_fr_formclientid && $dragblock_fr_parsed_block['attrs']['dragBlockClientId'] ) {
		$dragblock_fr_formclientid = $dragblock_fr_parsed_block['attrs']['dragBlockClientId'];
	}
	// dev-reply#964.
	$dragblock_fr_postendform = strrpos( $dragblock_fr_block_content, '</form>' );
	if ( false !== $dragblock_fr_postendform ) {
		$dragblock_fr_extrainput = '';
		// dev-reply#968.
		if ( $dragblock_fr_formclientid ) {
			// dev-reply#970.
			if ( strlen( $dragblock_fr_formclientid ) > 32 ) {
				$dragblock_fr_formclientid = substr( $dragblock_fr_formclientid, 0, 32 );
			}
			// dev-reply#975.
			$dragblock_fr_formclientid = sanitize_key( $dragblock_fr_formclientid );
			$dragblock_fr_extrainput .= '<input type="hidden" name="dragblock/form-client-id" value="' . esc_attr( $dragblock_fr_formclientid ) . '"/>';
		}
		// dev-reply#981.
		$dragblock_fr_extrainput .= '<input type="text" name="dragblock/form-title" value="">';
		$dragblock_fr_block_content = substr( $dragblock_fr_block_content, 0, $dragblock_fr_postendform ) . ' ' . $dragblock_fr_extrainput . substr( $dragblock_fr_block_content, $dragblock_fr_postendform );
	}
	// dev-reply#991.
	global $dragblock_form_entries_message_error;
	// dev-reply#994.
	$dragblock_fr_classanchor = 'class="';
	$dragblock_fr_posclassstart = strpos( $dragblock_fr_block_content, $dragblock_fr_classanchor );
	if ( false === $dragblock_fr_posclassstart ) {
		$dragblock_fr_classanchor = 'class=\'';
		$dragblock_fr_posclassstart = strpos( $dragblock_fr_block_content, $dragblock_fr_classanchor );
	}
	if ( false !== $dragblock_fr_posclassstart && isset( $dragblock_form_entries_message_error[ $dragblock_fr_formclientid ] ) ) {
		$dragblock_fr_posclassstart += strlen( $dragblock_fr_classanchor );
		if ( false === $dragblock_form_entries_message_error[ $dragblock_fr_formclientid ] ) {
			// dev-reply#9106.
			$dragblock_fr_block_content = substr( $dragblock_fr_block_content, 0, $dragblock_fr_posclassstart ) . 'pass ' . substr( $dragblock_fr_block_content, $dragblock_fr_posclassstart );
		} else {
			// dev-reply#9109.
			$dragblock_fr_block_content = substr( $dragblock_fr_block_content, 0, $dragblock_fr_posclassstart ) . 'fail ' . substr( $dragblock_fr_block_content, $dragblock_fr_posclassstart );
		}
	}
	// dev-reply#9114.
	$dragblock_fr_block_content = str_replace(
		'[dragblock.form.message.error]',
		! empty( $dragblock_form_entries_message_error[ $dragblock_fr_formclientid ] ) ? $dragblock_form_entries_message_error[ $dragblock_fr_formclientid ] : '',
		$dragblock_fr_block_content
	);
	// dev-reply#9121.
	$dragblock_fr_block_content = str_replace( '[dragblock.form.action]', '', $dragblock_fr_block_content );
	return $dragblock_fr_block_content;
}
