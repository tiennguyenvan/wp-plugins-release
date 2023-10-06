<?php
/**
 * DragBlock's Editor-panel-attributes.
 *
 * @package Attributes render
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'render_block_data', 'dragblock_attributes_parsing', 10, 1 );
/**
 * Check Documentation#163
 *
 * @param object|array|string $dragblock_ar_parsed_block check var-def#163.
 */
function dragblock_attributes_parsing( $dragblock_ar_parsed_block ) {
	if ( empty( $dragblock_ar_parsed_block['attrs']['dragBlockAttrs'] ) ) {
		return $dragblock_ar_parsed_block;
	}
	// dev-reply#1613.
	$dragblock_ar_renderedattrs = array();
	foreach ( $dragblock_ar_parsed_block['attrs']['dragBlockAttrs'] as $dragblock_ar_attr ) {
		// dev-reply#1617.
		if (
			! empty( $dragblock_ar_attr['disabled'] ) ||
			! isset( $dragblock_ar_attr['value'] ) ||
			empty( $dragblock_ar_attr['slug'] )
		) {
			continue;
		}
		// dev-reply#1626.
		if ( ! empty( $dragblock_ar_attr['locale'] ) ) {
			// dev-reply#1631.
			if ( DRAGBLOCK_SITE_LOCALE === $dragblock_ar_attr['locale'] ) {
				$dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] = $dragblock_ar_attr['value'];
			} elseif ( 'en_US' === $dragblock_ar_attr['locale'] && empty( $dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] ) ) {
				$dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] = $dragblock_ar_attr['value'];
			}
			continue;
		}
		// dev-reply#1644.
		if ( 'sizes' === $dragblock_ar_attr['slug'] ) {
			if ( ! empty( $dragblock_ar_attr['devices'] ) && strlen( $dragblock_ar_attr['devices'] ) < 3 ) {
				if ( 'd' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(min-width: 1025px) ' . $dragblock_ar_attr['value'];
				}
				if ( 't' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(min-width: 768px) and (max-width: 1024px) ' . $dragblock_ar_attr['value'];
				}
				if ( 'm' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(max-width: 767px) ' . $dragblock_ar_attr['value'];
				}
				if ( 'dt' === $dragblock_ar_attr['devices'] || 'td' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(min-width: 768px) ' . $dragblock_ar_attr['value'];
				}
				if ( 'dm' === $dragblock_ar_attr['devices'] || 'md' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(min-width: 1025px) ' . $dragblock_ar_attr['value'] . ', (max-width: 767px) ' . $dragblock_ar_attr['value'];
				}
				if ( 'tm' === $dragblock_ar_attr['devices'] || 'mt' === $dragblock_ar_attr['devices'] ) {
					$dragblock_ar_attr['value'] = '(max-width: 1024px) ' . $dragblock_ar_attr['value'];
				}
			}
		}
		// dev-reply#1669.
		if ( empty( $dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] ) ) {
			$dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] = $dragblock_ar_attr['value'];
		} else {
			$dragblock_ar_renderedattrs[ $dragblock_ar_attr['slug'] ] .= ', ' . $dragblock_ar_attr['value'];
		}
	}
	// dev-reply#1677.
	if ( 'dragblock/image' === $dragblock_ar_parsed_block['blockName'] ) {
		// dev-reply#1679.
		if ( empty( $dragblock_ar_renderedattrs['loading'] ) ) {
			$dragblock_ar_renderedattrs['loading'] = 'lazy';
		}
		if ( empty( $dragblock_ar_renderedattrs['decoding'] ) ) {
			$dragblock_ar_renderedattrs['decoding'] = 'async';
		}
		// dev-reply#1687.
		if ( ! empty( $dragblock_ar_renderedattrs['src'] ) ) {
			// dev-reply#1689.
			if ( strpos( $dragblock_ar_renderedattrs['src'], '[dragblock.post.image.src' ) !== false ) {
				// dev-reply#1691.
				if ( empty( $dragblock_ar_renderedattrs['alt'] ) ) {
					$dragblock_ar_renderedattrs['alt'] = '[dragblock.post.title]';
				}
				if ( empty( $dragblock_ar_renderedattrs['srcset'] ) ) {
					$dragblock_ar_renderedattrs['srcset'] = '[dragblock.post.image.srcset]';
				}
			} else {
				$dragblock_ar_srcsets = dragblock_get_image_srcsets( $dragblock_ar_renderedattrs['src'] );
				if ( $dragblock_ar_srcsets ) {
					$dragblock_ar_renderedattrs['srcset'] = $dragblock_ar_srcsets;
				}
			}
		}
		if ( empty( $dragblock_ar_renderedattrs['alt'] ) ) {
			$dragblock_ar_alt = empty( $dragblock_ar_renderedattrs['src'] ) ? '' : esc_attr( basename( $dragblock_ar_renderedattrs['src'] ) );
			$dragblock_ar_renderedattrs['alt'] = empty( $dragblock_ar_alt ) ? esc_html__( 'Just a placeholder', 'dragblock' ) : $dragblock_ar_alt;
		}
	}
	// dev-reply#16117.
	if ( 'dragblock/link' === $dragblock_ar_parsed_block['blockName'] ) {
		// dev-reply#16119.
		if ( empty( $dragblock_ar_renderedattrs['aria-label'] ) ) {
			$dragblock_ar_renderedattrs['aria-label'] = esc_html__( 'DragBlock Link Block', 'dragblock' );
		}
	}
	// dev-reply#16125.
	$dragblock_ar_attrstring = '';
	if ( ! empty( $dragblock_ar_renderedattrs['name'] ) && dragblock_is_reseved_terms( $dragblock_ar_renderedattrs['name'] ) ) {
		$dragblock_ar_renderedattrs['name'] .= '__dragblock_wp_reseved_terms';
		// dev-reply#16142.
	}
	foreach ( $dragblock_ar_renderedattrs as $dragblock_ar_slug => $dragblock_ar_value ) {
		$dragblock_ar_attrstring .= ( sanitize_key( $dragblock_ar_slug ) . '="' . esc_attr( do_shortcode( $dragblock_ar_value ) ) . '"' );
	}
	if ( $dragblock_ar_attrstring ) {
		$dragblock_ar_parsed_block['attrs']['dragBlockParsedAttrs'] = $dragblock_ar_attrstring;
	}
	return $dragblock_ar_parsed_block;
}
add_filter( 'render_block', 'dragblock_attributes_insert', 10, 2 );
/**
 * Check Documentation#16115
 *
 * @param object|array|string $dragblock_ar_block_content check var-def#16115.
 * @param object|array|string $dragblock_ar_parsed_block check var-def#16115.
 */
function dragblock_attributes_insert( $dragblock_ar_block_content, $dragblock_ar_parsed_block ) {
	if ( empty( $dragblock_ar_parsed_block['attrs']['dragBlockParsedAttrs'] ) ) {
		return $dragblock_ar_block_content;
	}
	$dragblock_ar_tag_start = strpos( $dragblock_ar_block_content, '<' );
	if ( false === $dragblock_ar_tag_start ) {
		return $dragblock_ar_block_content;
	}
	$dragblock_ar_first_space = strpos( $dragblock_ar_block_content, ' ', $dragblock_ar_tag_start );
	$dragblock_ar_tag_end = strpos( $dragblock_ar_block_content, '>', $dragblock_ar_tag_start );
	$dragblock_ar_insert_index = $dragblock_ar_first_space;
	if ( false === $dragblock_ar_insert_index ) {
		$dragblock_ar_insert_index = $dragblock_ar_tag_end;
	} elseif ( false !== $dragblock_ar_tag_end && $dragblock_ar_tag_end < $dragblock_ar_insert_index ) {
		$dragblock_ar_insert_index = $dragblock_ar_tag_end;
	}
	if ( false === $dragblock_ar_insert_index ) {
		return $dragblock_ar_block_content;
	}
	return ( substr( $dragblock_ar_block_content, 0, $dragblock_ar_insert_index ) . ' ' .
		$dragblock_ar_parsed_block['attrs']['dragBlockParsedAttrs'] .
		substr( $dragblock_ar_block_content, $dragblock_ar_insert_index )
	);
}
