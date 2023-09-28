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
	} = props;
	let {dragBlockAttrs, dragBlockClientId} = attributes;
	if (!dragBlockAttrs) {
        const newAttr = [
			/* we don't reduce to 32 chars here so we can solve on the server side and choose the method we ant */
            { slug: 'name', value: dragBlockClientId ? dragBlockClientId : clientId }, 
			
            { slug: 'method', value: 'POST' },
			{ slug: 'action', value: '[dragblock.form.action]' },
        ];
        setAttributes({ dragBlockAttrs: cloneDeep(newAttr) });
        dragBlockAttrs = newAttr;
    }


	const blockProps = useBlockProps();

	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{			
			orientation: "horizontal",
			renderAppender: false,	
			templateInsertUpdatesSelection: false,
		}
	);
	

	return <form {...innerBlocksProps} />
}
