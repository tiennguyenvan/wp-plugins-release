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
 * Check Documentation#153
 *
 * @param object|array|string $dragblock_0 check var-def#153.
 */
function dragblock_attributes_parsing( $dragblock_0 ) {
	if ( empty( $dragblock_0['attrs']['dragBlockAttrs'] ) ) {
		return $dragblock_0;
	}
	// dev-reply#1513.
	$dragblock_1 = array();
	foreach ( $dragblock_0['attrs']['dragBlockAttrs'] as $dragblock_2 ) {
		// dev-reply#1517.
		if (
			! empty( $dragblock_2['disabled'] ) ||
			! isset( $dragblock_2['value'] ) ||
			empty( $dragblock_2['slug'] )
		) {
			continue;
		}
		// dev-reply#1526.
		if ( ! empty( $dragblock_2['locale'] ) ) {
			// dev-reply#1531.
			if ( DRAGBLOCK_SITE_LOCALE === $dragblock_2['locale'] ) {
				$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
			} elseif ( 'en_US' === $dragblock_2['locale'] && empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
				$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
			}
			continue;
		}
		// dev-reply#1544.
		if ( 'sizes' === $dragblock_2['slug'] ) {
			if ( ! empty( $dragblock_2['devices'] ) && strlen( $dragblock_2['devices'] ) < 3 ) {
				if ( 'd' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(min-width: 1025px) ' . $dragblock_2['value'];
				}
				if ( 't' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(min-width: 768px) and (max-width: 1024px) ' . $dragblock_2['value'];
				}
				if ( 'm' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(max-width: 767px) ' . $dragblock_2['value'];
				}
				if ( 'dt' === $dragblock_2['devices'] || 'td' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(min-width: 768px) ' . $dragblock_2['value'];
				}
				if ( 'dm' === $dragblock_2['devices'] || 'md' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(min-width: 1025px) ' . $dragblock_2['value'] . ', (max-width: 767px) ' . $dragblock_2['value'];
				}
				if ( 'tm' === $dragblock_2['devices'] || 'mt' === $dragblock_2['devices'] ) {
					$dragblock_2['value'] = '(max-width: 1024px) ' . $dragblock_2['value'];
				}
			}
		}
		// dev-reply#1569.
		if ( empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
			$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
		} else {
			$dragblock_1[ $dragblock_2['slug'] ] .= ', ' . $dragblock_2['value'];
		}
	}
	// dev-reply#1577.
	if ( 'dragblock/image' === $dragblock_0['blockName'] ) {
		// dev-reply#1579.
		if ( empty( $dragblock_1['loading'] ) ) {
			$dragblock_1['loading'] = 'lazy';
		}
		if ( empty( $dragblock_1['decoding'] ) ) {
			$dragblock_1['decoding'] = 'async';
		}
		// dev-reply#1587.
		if ( ! empty( $dragblock_1['src'] ) ) {
			// dev-reply#1589.
			if ( strpos( $dragblock_1['src'], '[dragblock.post.image.src' ) !== false ) {
				// dev-reply#1591.
				if ( empty( $dragblock_1['alt'] ) ) {
					$dragblock_1['alt'] = '[dragblock.post.title]';
				}
				if ( empty( $dragblock_1['srcset'] ) ) {
					$dragblock_1['srcset'] = '[dragblock.post.image.srcset]';
				}
			} else {
				$dragblock_3 = dragblock_get_image_srcsets( $dragblock_1['src'] );
				if ( $dragblock_3 ) {
					$dragblock_1['srcset'] = $dragblock_3;
				}
			}
		}
		if ( empty( $dragblock_1['alt'] ) ) {
			$dragblock_4 = empty( $dragblock_1['src'] ) ? '' : esc_attr( basename( $dragblock_1['src'] ) );
			$dragblock_1['alt'] = empty( $dragblock_4 ) ? esc_html__( 'Just a placeholder', 'dragblock' ) : $dragblock_4;
		}
	}
	// dev-reply#15117.
	if ( 'dragblock/link' === $dragblock_0['blockName'] ) {
		// dev-reply#15119.
		if ( empty( $dragblock_1['aria-label'] ) ) {
			$dragblock_1['aria-label'] = esc_html__( 'DragBlock Link Block', 'dragblock' );
		}
	}
	// dev-reply#15125.
	$dragblock_5 = '';
	if ( ! empty( $dragblock_1['name'] ) && dragblock_is_reseved_terms( $dragblock_1['name'] ) ) {
		$dragblock_1['name'] .= '__dragblock_wp_reseved_terms';
		// dev-reply#15133.
	}
	foreach ( $dragblock_1 as $dragblock_6 => $dragblock_7 ) {
		$dragblock_5 .= ( sanitize_key( $dragblock_6 ) . '="' . esc_attr( do_shortcode( $dragblock_7 ) ) . '"' );
	}
	if ( $dragblock_5 ) {
		$dragblock_0['attrs']['dragBlockParsedAttrs'] = $dragblock_5;
	}
	return $dragblock_0;
}
add_filter( 'render_block', 'dragblock_attributes_insert', 10, 2 );
/**
 * Check Documentation#15115
 *
 * @param object|array|string $dragblock_8 check var-def#15115.
 * @param object|array|string $dragblock_0 check var-def#15115.
 */
function dragblock_attributes_insert( $dragblock_8, $dragblock_0 ) {
	if ( empty( $dragblock_0['attrs']['dragBlockParsedAttrs'] ) ) {
		return $dragblock_8;
	}
	$dragblock_9 = strpos( $dragblock_8, '<' );
	if ( false === $dragblock_9 ) {
		return $dragblock_8;
	}
	$dragblock_10 = strpos( $dragblock_8, ' ', $dragblock_9 );
	$dragblock_11 = strpos( $dragblock_8, '>', $dragblock_9 );
	$dragblock_12 = $dragblock_10;
	if ( false === $dragblock_12 ) {
		$dragblock_12 = $dragblock_11;
	} elseif ( false !== $dragblock_11 && $dragblock_11 < $dragblock_12 ) {
		$dragblock_12 = $dragblock_11;
	}
	if ( false === $dragblock_12 ) {
		return $dragblock_8;
	}
	return ( substr( $dragblock_8, 0, $dragblock_12 ) . ' ' .
		$dragblock_0['attrs']['dragBlockParsedAttrs'] .
		substr( $dragblock_8, $dragblock_12 )
	);
}
