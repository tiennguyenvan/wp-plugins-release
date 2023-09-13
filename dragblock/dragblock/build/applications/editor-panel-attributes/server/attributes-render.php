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
 * Check Documentation#143
 *
 * @param object|array|string $dragblock_0 check var-def#143.
 */
function dragblock_attributes_parsing( $dragblock_0 ) {
	if ( empty( $dragblock_0['attrs']['dragBlockAttrs'] ) ) {
		return $dragblock_0;
	}
	// dev-reply#1413.
	$dragblock_1 = array();
	foreach ( $dragblock_0['attrs']['dragBlockAttrs'] as $dragblock_2 ) {
		// dev-reply#1417.
		if (
			! empty( $dragblock_2['disabled'] ) ||
			! isset( $dragblock_2['value'] ) ||
			empty( $dragblock_2['slug'] )
		) {
			continue;
		}
		// dev-reply#1426.
		if ( ! empty( $dragblock_2['locale'] ) ) {
			// dev-reply#1431.
			if ( DRAGBLOCK_SITE_LOCALE === $dragblock_2['locale'] ) {
				$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
			} elseif ( 'en_US' === $dragblock_2['locale'] && empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
				$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
			}
			continue;
		}
		// dev-reply#1444.
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
		// dev-reply#1469.
		if ( empty( $dragblock_1[ $dragblock_2['slug'] ] ) ) {
			$dragblock_1[ $dragblock_2['slug'] ] = $dragblock_2['value'];
		} else {
			$dragblock_1[ $dragblock_2['slug'] ] .= ', ' . $dragblock_2['value'];
		}
	}
	// dev-reply#1477.
	if ( 'dragblock/image' === $dragblock_0['blockName'] ) {
		// dev-reply#1479.
		if ( empty( $dragblock_1['loading'] ) ) {
			$dragblock_1['loading'] = 'lazy';
		}
		if ( empty( $dragblock_1['decoding'] ) ) {
			$dragblock_1['decoding'] = 'async';
		}
		// dev-reply#1487.
		if ( ! empty( $dragblock_1['src'] ) ) {
			// dev-reply#1489.
			if ( strpos( $dragblock_1['src'], '[dragblock.post.image.src' ) !== false ) {
				// dev-reply#1491.
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
	}
	// dev-reply#14112.
	$dragblock_4 = '';
	if ( ! empty( $dragblock_1['name'] ) && dragblock_is_reseved_terms( $dragblock_1['name'] ) ) {
		$dragblock_1['name'] .= '__dragblock_wp_reseved_terms';
		// dev-reply#14120.
	}
	foreach ( $dragblock_1 as $dragblock_5 => $dragblock_6 ) {
		$dragblock_4 .= ( sanitize_key( $dragblock_5 ) . '="' . esc_attr( do_shortcode( $dragblock_6 ) ) . '"' );
	}
	if ( $dragblock_4 ) {
		$dragblock_0['attrs']['dragBlockParsedAttrs'] = $dragblock_4;
	}
	return $dragblock_0;
}
add_filter( 'render_block', 'dragblock_attributes_insert', 10, 2 );
/**
 * Check Documentation#14104
 *
 * @param object|array|string $dragblock_7 check var-def#14104.
 * @param object|array|string $dragblock_0 check var-def#14104.
 */
function dragblock_attributes_insert( $dragblock_7, $dragblock_0 ) {
	if ( empty( $dragblock_0['attrs']['dragBlockParsedAttrs'] ) ) {
		return $dragblock_7;
	}
	$dragblock_8 = strpos( $dragblock_7, '<' );
	if ( false === $dragblock_8 ) {
		return $dragblock_7;
	}
	$dragblock_9 = strpos( $dragblock_7, ' ', $dragblock_8 );
	$dragblock_10 = strpos( $dragblock_7, '>', $dragblock_8 );
	$dragblock_11 = $dragblock_9;
	if ( false === $dragblock_11 ) {
		$dragblock_11 = $dragblock_10;
	} elseif ( false !== $dragblock_10 && $dragblock_10 < $dragblock_11 ) {
		$dragblock_11 = $dragblock_10;
	}
	if ( false === $dragblock_11 ) {
		return $dragblock_7;
	}
	return ( substr( $dragblock_7, 0, $dragblock_11 ) . ' ' .
		$dragblock_0['attrs']['dragBlockParsedAttrs'] .
		substr( $dragblock_7, $dragblock_11 )
	);
}
