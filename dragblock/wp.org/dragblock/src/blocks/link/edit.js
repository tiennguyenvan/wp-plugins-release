import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, ButtonBlockAppender } from '@wordpress/block-editor';
import { applyFilters } from '@wordpress/hooks';
import { useSelect, dispatch, select } from '@wordpress/data';

import './editor.scss';

/**
 * 
 * @param {Object} props 
 * @returns 
 */
export default function Edit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
	} = props;

	const allow_blocks = ['dragblock/text', 'dragblock/icon', 'dragblock/image'];
	const template = [
		['dragblock/text', {
			dragBlockText: [
				{ slug: 'en_US', value: 'Click Here' }
			]
		}]
	]

	const innerBlockIds = useSelect(select => { return select('core/block-editor').getBlockOrder(clientId); });
	const blockProps = useBlockProps();

	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			allowedBlocks: [...allow_blocks],
			template: [
				['dragblock/text', {
					dragBlockText: [
						{ slug: 'en_US', value: 'Click Here' }
					]
				}]
			],
			orientation: "horizontal",
			renderAppender: false,
			templateInsertUpdatesSelection: false,
		}
	);

	return <a {...innerBlocksProps} data-content-length={innerBlockIds.length} />
}
