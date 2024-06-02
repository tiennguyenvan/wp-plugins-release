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
	// dev-reply#2010.
	if ( empty( $dragblock_ar_parsed['attrs']['dragBlockAttrs'] ) ) {
		return $dragblock_ar_parsed;
	}
	// dev-reply#2017.
	$dragblock_ar_block = array();
	$dragblock_ar_renderedattrs = get_locale();
	foreach ( $dragblock_ar_parsed['attrs']['dragBlockAttrs'] as $dragblock_ar_site ) {
		// dev-reply#2022.
		if (
			! empty( $dragblock_ar_site['disabled'] ) ||
			! isset( $dragblock_ar_site['value'] ) ||
			empty( $dragblock_ar_site['slug'] )
		) {
			continue;
		}
		// dev-reply#2031.
		if ( ! empty( $dragblock_ar_site['locale'] ) ) {
			// dev-reply#2036.
			if ( ( $dragblock_ar_renderedattrs ) === $dragblock_ar_site['locale'] ) {
				$dragblock_ar_block[ $dragblock_ar_site['slug'] ] = $dragblock_ar_site['value'];
			} elseif ( 'en_US' === $dragblock_ar_site['locale'] && empty( $dragblock_ar_block[ $dragblock_ar_site['slug'] ] ) ) {
				$dragblock_ar_block[ $dragblock_ar_site['slug'] ] = $dragblock_ar_site['value'];
			}
			continue;
		}
		// dev-reply#2049.
		if ( 'sizes' === $dragblock_ar_site['slug'] ) {
			if ( ! empty( $dragblock_ar_site['devices'] ) && strlen( $dragblock_ar_site['devices'] ) < 3 ) {
				if ( 'd' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(min-width: 1025px) ' . $dragblock_ar_site['value'];
				}
				if ( 't' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(min-width: 768px) and (max-width: 1024px) ' . $dragblock_ar_site['value'];
				}
				if ( 'm' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(max-width: 767px) ' . $dragblock_ar_site['value'];
				}
				if ( 'dt' === $dragblock_ar_site['devices'] || 'td' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(min-width: 768px) ' . $dragblock_ar_site['value'];
				}
				if ( 'dm' === $dragblock_ar_site['devices'] || 'md' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(min-width: 1025px) ' . $dragblock_ar_site['value'] . ', (max-width: 767px) ' . $dragblock_ar_site['value'];
				}
				if ( 'tm' === $dragblock_ar_site['devices'] || 'mt' === $dragblock_ar_site['devices'] ) {
					$dragblock_ar_site['value'] = '(max-width: 1024px) ' . $dragblock_ar_site['value'];
				}
			}
		}
		// dev-reply#2074.
		if ( empty( $dragblock_ar_block[ $dragblock_ar_site['slug'] ] ) ) {
			$dragblock_ar_block[ $dragblock_ar_site['slug'] ] = $dragblock_ar_site['value'];
		} else {
			$dragblock_ar_block[ $dragblock_ar_site['slug'] ] .= ', ' . $dragblock_ar_site['value'];
		}
	} // dev-reply#2080.
	$dragblock_ar_locale = false;
	if ( 'dragblock/image' === $dragblock_ar_parsed['blockName'] ) {
		// dev-reply#2087.
		if ( ! empty( $dragblock_ar_block['src'] ) ) {
			// dev-reply#2089.
			if ( strpos( $dragblock_ar_block['src'], '[dragblock.post.image.src' ) !== false ) {
				$dragblock_ar_locale = true;
				// dev-reply#2092.
				if ( empty( $dragblock_ar_block['alt'] ) ) {
					$dragblock_ar_block['alt'] = '[dragblock.post.title]';
				}
				if ( empty( $dragblock_ar_block['srcset'] ) ) {
					$dragblock_ar_block['srcset'] = '[dragblock.post.image.srcset]';
				}
			} else {
				$dragblock_ar_attr = dragblock_get_image_srcsets( $dragblock_ar_block['src'] );
				if ( $dragblock_ar_attr ) {
					$dragblock_ar_block['srcset'] = $dragblock_ar_attr;
				}
			}
		}
		if ( empty( $dragblock_ar_block['alt'] ) ) {
			$dragblock_ar_is = empty( $dragblock_ar_block['src'] ) ? '' : esc_attr( basename( $dragblock_ar_block['src'] ) );
			$dragblock_ar_block['alt'] = empty( $dragblock_ar_is ) ? esc_html__( 'Just a placeholder', 'dragblock' ) : $dragblock_ar_is;
		}
		// dev-reply#20117.
		if ( empty( $dragblock_ar_block['loading'] ) ) {
			$dragblock_ar_block['loading'] = 'lazy';
			if ( empty( $dragblock_ar_block['decoding'] ) ) {
				$dragblock_ar_block['decoding'] = 'async';
			}
		}
	}
	// dev-reply#20134.
	if ( 'dragblock/link' === $dragblock_ar_parsed['blockName'] ) {
		// dev-reply#20136.
		if ( empty( $dragblock_ar_block['aria-label'] ) && ! empty( $dragblock_ar_parsed['innerBlocks'] ) ) {
			$dragblock_ar_post = '';
			foreach ( $dragblock_ar_parsed['innerBlocks'] as $dragblock_ar_image ) {
				if ( empty( $dragblock_ar_image['attrs'] ) ) {
					continue;
				}
				if ( 'dragblock/icon' === $dragblock_ar_image['blockName'] ) {
					$dragblock_ar_post = 'Icon';
					continue;
				}
				if ( 'dragblock/text' !== $dragblock_ar_image['blockName'] ) {
					continue;
				}
				if ( empty( $dragblock_ar_image['attrs']['dragBlockText'] ) ) {
					continue;
				}
				foreach ( $dragblock_ar_image['attrs']['dragBlockText'] as $dragblock_ar_srcsets ) {
					if (
						empty( $dragblock_ar_srcsets['slug'] ) ||
						! isset( $dragblock_ar_srcsets['value'] ) || '' === $dragblock_ar_srcsets['value'] ||
						! empty( $dragblock_ar_srcsets['disabled'] )
					) {
						continue;
					}
					// dev-reply#20164.
					if ( ( $dragblock_ar_renderedattrs ) === $dragblock_ar_srcsets['slug'] ) {
						$dragblock_ar_post = $dragblock_ar_srcsets['value'];
						break;
					} elseif ( 'en_US' === $dragblock_ar_srcsets['slug'] ) {
						$dragblock_ar_post = $dragblock_ar_srcsets['value'];
					}
				}
				if ( ! $dragblock_ar_post ) {
					break;
				}
				continue;
			}
			if ( $dragblock_ar_post ) {
				$dragblock_ar_block['aria-label'] = $dragblock_ar_post;
			}
		}
	}
	// dev-reply#20187.
	$dragblock_ar_alt = '';
	if ( ! empty( $dragblock_ar_block['name'] ) && dragblock_is_reseved_terms( $dragblock_ar_block['name'] ) ) {
		$dragblock_ar_block['name'] .= DRAGBLOCK_WP_RESEVED_TERMS_PLACEHOLDER;
	}
	foreach ( $dragblock_ar_block as $dragblock_ar_aria => $dragblock_ar_label ) {
		$dragblock_ar_child = esc_attr( do_shortcode( $dragblock_ar_label ) );
		// dev-reply#20210.
		if ( ( $dragblock_ar_aria ) === 'src' && $dragblock_ar_locale && empty( $dragblock_ar_child ) ) {
			$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] = '';
			return $dragblock_ar_parsed;
		}
		$dragblock_ar_alt .= ( sanitize_key( $dragblock_ar_aria ) . '="' . $dragblock_ar_child . '"' );
	}
	if ( $dragblock_ar_alt ) {
		$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] = $dragblock_ar_alt;
	}
	// dev-reply#20221.
	return $dragblock_ar_parsed;
}
add_filter( 'render_block', 'dragblock_attributes_insert', 10, 2 );
/**
 * Check Documentation#20164
 *
 * @param object|array|string $dragblock_ar_text check var-def#20164.
 * @param object|array|string $dragblock_ar_parsed check var-def#20164.
 */
function dragblock_attributes_insert( $dragblock_ar_text, $dragblock_ar_parsed ) {
	// dev-reply#20232.
	if ( empty( $dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] ) ) {
		// dev-reply#20235.
		if ( 'dragblock/image' === $dragblock_ar_parsed['blockName'] ) {
			return '';
		}
		return $dragblock_ar_text;
	}
	$dragblock_ar_attrstring = strpos( $dragblock_ar_text, '<' );
	if ( false === $dragblock_ar_attrstring ) {
		return $dragblock_ar_text;
	}
	$dragblock_ar_slug = strpos( $dragblock_ar_text, ' ', $dragblock_ar_attrstring );
	$dragblock_ar_value = strpos( $dragblock_ar_text, '>', $dragblock_ar_attrstring );
	$dragblock_ar_content = $dragblock_ar_slug;
	if ( false === $dragblock_ar_content ) {
		$dragblock_ar_content = $dragblock_ar_value;
	} elseif ( false !== $dragblock_ar_value && $dragblock_ar_value < $dragblock_ar_content ) {
		$dragblock_ar_content = $dragblock_ar_value;
	}
	if ( false === $dragblock_ar_content ) {
		return $dragblock_ar_text;
	}
	$dragblock_ar_text = ( substr( $dragblock_ar_text, 0, $dragblock_ar_content ) . ' ' .
		$dragblock_ar_parsed['attrs']['dragBlockParsedAttrs'] .
		substr( $dragblock_ar_text, $dragblock_ar_content )
	);
	return $dragblock_ar_text;
}
