import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, ButtonBlockAppender } from '@wordpress/block-editor';
import { applyFilters } from '@wordpress/hooks';
import { useSelect, dispatch, select } from '@wordpress/data';

import './editor.scss';
import { cloneDeep } from 'lodash';

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
		name
	} = props;

	let { dragBlockAttrs, dragBlockClientId } = attributes;
	

	if (!dragBlockAttrs) {
		const newAttr = [
			{ slug: 'name', value: dragBlockClientId ? dragBlockClientId : clientId }
		];
		setAttributes({ dragBlockAttrs: cloneDeep(newAttr) });
		dragBlockAttrs = newAttr;
	}

	const allow_blocks = ['dragblock/option'];
	const template = [
		['dragblock/option', {
			dragBlockText: [
				{ slug: 'en_US', value: 'Select an Option' }
			],
			dragBlockAttrs: [{ slug: 'value', value: '' }]
		}],
		['dragblock/option', {
			dragBlockText: [
				{ slug: 'en_US', value: 'Value 01 Label' }
			],			
			dragBlockAttrs: [{ slug: 'value', value: 'value-01' }]
		}],
		['dragblock/option', {
			dragBlockText: [
				{ slug: 'en_US', value: 'Value 02 Label' }
			],			
			dragBlockAttrs: [{ slug: 'value', value: 'value-02' }]
		}],
	]

	const blockProps = useBlockProps();

	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			allowedBlocks: allow_blocks,
			template: template,
			orientation: "vertical",
			renderAppender: false,
			templateInsertUpdatesSelection: false,
		}
	);
	return <select {...innerBlocksProps} onChange={()=>{}}/>
}
