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
 * Check Documentation#203
 *
 * @param object|array|string $dragblock_ar_parsed check var-def#203.
 */
function dragblock_attributes_parsing( $dragblock_ar_parsed ) {
	if ( empty( $dragblock_ar_parsed['attrs']['dragBlockAttrs'] ) ) {
		return $dragblock_ar_parsed;
	}
	// dev-reply#2013.
	$dragblock_ar_block = array();
	foreach ( $dragblock_ar_parsed['attrs']['dragBlockAttrs'] as $dragblock_ar_renderedattrs ) {
		// dev-reply#2017.
		if (
			! empty( $dragblock_ar_renderedattrs['disabled'] ) ||
			! isset( $dragblock_ar_renderedattrs['value'] ) ||
			empty( $dragblock_ar_renderedattrs['slug'] )
		) {
			continue;
		}
		// dev-reply#2026.
		if ( ! empty( $dragblock_ar_renderedattrs['locale'] ) ) {
			// dev-reply#2031.
			if ( DRAGBLOCK_SITE_LOCALE === $dragblock_ar_renderedattrs['locale'] ) {
				$dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] = $dragblock_ar_renderedattrs['value'];
			} elseif ( 'en_US' === $dragblock_ar_renderedattrs['locale'] && empty( $dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] ) ) {
				$dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] = $dragblock_ar_renderedattrs['value'];
			}
			continue;
		}
		// dev-reply#2044.
		if ( 'sizes' === $dragblock_ar_renderedattrs['slug'] ) {
			if ( ! empty( $dragblock_ar_renderedattrs['devices'] ) && strlen( $dragblock_ar_renderedattrs['devices'] ) < 3 ) {
				if ( 'd' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(min-width: 1025px) ' . $dragblock_ar_renderedattrs['value'];
				}
				if ( 't' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(min-width: 768px) and (max-width: 1024px) ' . $dragblock_ar_renderedattrs['value'];
				}
				if ( 'm' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(max-width: 767px) ' . $dragblock_ar_renderedattrs['value'];
				}
				if ( 'dt' === $dragblock_ar_renderedattrs['devices'] || 'td' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(min-width: 768px) ' . $dragblock_ar_renderedattrs['value'];
				}
				if ( 'dm' === $dragblock_ar_renderedattrs['devices'] || 'md' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(min-width: 1025px) ' . $dragblock_ar_renderedattrs['value'] . ', (max-width: 767px) ' . $dragblock_ar_renderedattrs['value'];
				}
				if ( 'tm' === $dragblock_ar_renderedattrs['devices'] || 'mt' === $dragblock_ar_renderedattrs['devices'] ) {
					$dragblock_ar_renderedattrs['value'] = '(max-width: 1024px) ' . $dragblock_ar_renderedattrs['value'];
				}
			}
		}
		// dev-reply#2069.
		if ( empty( $dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] ) ) {
			$dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] = $dragblock_ar_renderedattrs['value'];
		} else {
			$dragblock_ar_block[ $dragblock_ar_renderedattrs['slug'] ] .= ', ' . $dragblock_ar_renderedattrs['value'];
		}
	} // dev-reply#2075.
	$dragblock_ar_attr = false;
	if ( 'dragblock/image' === $dragblock_ar_parsed['blockName'] ) {
		// dev-reply#2082.
		if ( ! empty( $dragblock_ar_block['src'] ) ) {
			// dev-reply#2084.
			if ( strpos( $dragblock_ar_block['src'], '[dragblock.post.image.src' ) !== false ) {
				$dragblock_ar_attr = true;
				// dev-reply#2087.
				if ( empty( $dragblock_ar_block['alt'] ) ) {
					$dragblock_ar_block['alt'] = '[dragblock.post.title]';
				}
				if ( empty( $dragblock_ar_block['srcset'] ) ) {
					$dragblock_ar_block['srcset'] = '[dragblock.post.image.srcset]';
				}
			} else {
				$dragblock_ar_is = dragblock_get_image_srcsets( $dragblock_ar_block['src'] );
				if ( $dragblock_ar_is ) {
					$dragblock_ar_block['srcset'] = $dragblock_ar_is;
				}
			}
		}
		if ( empty( $dragblock_ar_block['alt'] ) ) {
			$dragblock_ar_post = empty( $dragblock_ar_block['src'] ) ? '' : esc_attr( basename( $dragblock_ar_block['src'] ) );
			$dragblock_ar_block['alt'] = empty( $dragblock_ar_post ) ? esc_html__( 'Just a placeholder', 'dragblock' ) : $dragblock_ar_post;
		}
		// dev-reply#20112.
		if ( empty( $dragblock_ar_block['loading'] ) ) {
			$dragblock_ar_block['loading'] = 'lazy';
			if ( empty( $dragblock_ar_block['decoding'] ) ) {
				$dragblock_ar_block['decoding'] = 'async';
			}
		}
	}
	// dev-reply#20131.
	if ( 'dragblock/link' === $dragblock_ar_parsed['blockName'] ) {
		// dev-reply#20133.
		if ( empty( $dragblock_ar_block['aria-label'] ) && ! empty( $dragblock_ar_parsed['innerBlocks'] ) ) {
			$dragblock_ar_image = '';
			foreach ( $dragblock_ar_parsed['innerBlocks'] as $dragblock_ar_srcsets ) {
				if ( empty( $dragblock_ar_srcsets['attrs'] ) ) {
					continue;
				}
				if ( 'dragblock/icon' === $dragblock_ar_srcsets['blockName'] ) {
					$dragblock_ar_image = 'Icon';
					continue;
				}
				if ( 'dragblock/text' !== $dragblock_ar_srcsets['blockName'] ) {
					continue;
				}
				if ( empty( $dragblock_ar_srcsets['attrs']['dragBlockText'] ) ) {
					continue;
				}
				foreach ( $dragblock_ar_srcsets['attrs']['dragBlockText'] as $dragblock_ar_alt ) {
					if (
						empty( $dragblock_ar_alt['slug'] ) ||
						! isset( $dragblock_ar_alt['value'] ) || '' === $dragblock_ar_alt['value'] ||
						! empty( $dragblock_ar_alt['disabled'] )
					) {
						continue;
					}
					// dev-reply#20161.
					if ( DRAGBLOCK_SITE_LOCALE === $dragblock_ar_alt['slug'] ) {
						$dragblock_ar_image = $dragblock_ar_alt['value'];
						break;
					} elseif ( 'en_US' === $dragblock_ar_alt['slug'] ) {
						$dragblock_ar_image = $dragblock_ar_alt['value'];
					}
				}
				if ( ! $dragblock_ar_image ) {
					break;
				}
				continue;
			}
			if ( $dragblock_ar_image ) {
				$dragblock_ar_block['aria-label'] = $dragblock_ar_image;
			}
		}
	}
	// dev-reply#20184.
	$dragblock_ar_aria = '';
	if ( ! empty( $dragblock_ar_block['name'] ) && dragblock_is_reseved_terms( $dragblock_ar_block['name'] ) ) {
		$dragblock_ar_block['name'] .= '__dragblock_wp_reseved_terms';
		// dev-reply#20201.
	}
	foreach ( $dragblock_ar_block as $dragblock_ar_label => $dragblock_ar_child ) {
		$dragblock_ar_text = esc_attr( do_shortcode( $dragblock_ar_child ) );
		// dev-reply#20206.
		if ( ( $dragblock_ar_label ) === 'src' && $dragblock_ar_attr && empty( $dragblock_ar_text ) ) {
			$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] = '';
			return $dragblock_ar_parsed;
		}
		$dragblock_ar_aria .= ( sanitize_key( $dragblock_ar_label ) . '="' . $dragblock_ar_text . '"' );
	}
	if ( $dragblock_ar_aria ) {
		$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] = $dragblock_ar_aria;
	}
	return $dragblock_ar_parsed;
}
add_filter( 'render_block', 'dragblock_attributes_insert', 10, 2 );
/**
 * Check Documentation#20162
 *
 * @param object|array|string $dragblock_ar_attrstring check var-def#20162.
 * @param object|array|string $dragblock_ar_parsed check var-def#20162.
 */
function dragblock_attributes_insert( $dragblock_ar_attrstring, $dragblock_ar_parsed ) {
	if ( empty( $dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] ) ) {
		// dev-reply#20228.
		if ( 'dragblock/image' === $dragblock_ar_parsed['blockName'] ) {
			return '';
		}
		return $dragblock_ar_attrstring;
	}
	$dragblock_ar_slug = strpos( $dragblock_ar_attrstring, '<' );
	if ( false === $dragblock_ar_slug ) {
		return $dragblock_ar_attrstring;
	}
	$dragblock_ar_value = strpos( $dragblock_ar_attrstring, ' ', $dragblock_ar_slug );
	$dragblock_ar_content = strpos( $dragblock_ar_attrstring, '>', $dragblock_ar_slug );
	$dragblock_ar_tag = $dragblock_ar_value;
	if ( false === $dragblock_ar_tag ) {
		$dragblock_ar_tag = $dragblock_ar_content;
	} elseif ( false !== $dragblock_ar_content && $dragblock_ar_content < $dragblock_ar_tag ) {
		$dragblock_ar_tag = $dragblock_ar_content;
	}
	if ( false === $dragblock_ar_tag ) {
		return $dragblock_ar_attrstring;
	}
	return ( substr( $dragblock_ar_attrstring, 0, $dragblock_ar_tag ) . ' ' .
		$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] .
		substr( $dragblock_ar_attrstring, $dragblock_ar_tag )
	);
}
