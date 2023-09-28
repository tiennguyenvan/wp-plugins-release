/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	Dropdown, MenuItem,
	NavigableMenu, ToolbarButton,
	ToolbarGroup
} from '@wordpress/components';
import {
	BlockControls, useBlockProps
} from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

/**
 * Internal dependencies
 */

import InserterModal from './inserters/inserter';
import CustomInserterModal from './inserters/custom-inserter';
import IconPlaceholder from './placeholder';


import './editor.scss';



/**
 * The edit function for the Icon Block.
 *
 * @param {Object} props All props passed to this function.
 * @return {WPElement}   Element to render.
 */
export default function Edit(props) {
	const {
		attributes,
		setAttributes,
	} = props;
	const {
		icon,		
	} = attributes;
	




	const [isInserterOpen, setInserterOpen] = useState(false);
	const [isQuickInserterOpen, setQuickInserterOpen] = useState(false);
	const [isCustomInserterOpen, setCustomInserterOpen] = useState(false);

	const blockControls = (
		<>
			{!!icon && (
				<BlockControls>
					<ToolbarGroup>
						<Dropdown
							renderToggle={({ onToggle }) => (
								<ToolbarButton onClick={onToggle}>
									{__('Replace')}
								</ToolbarButton>
							)}
							renderContent={({ onClose }) => (
								<NavigableMenu>
									<MenuItem
										onClick={() => {
											setInserterOpen(true);
											onClose(true);
										}}
									>
										{__(
											'Browse icon library',
											'dragblock'
										)}
									</MenuItem>
									<MenuItem
										onClick={() => {
											setCustomInserterOpen(true);
											onClose(true);
										}}
									>
										{__(
											'Add/edit custom icon',
											'dragblock'
										)}
									</MenuItem>
								</NavigableMenu>
							)}
						/>
					</ToolbarGroup>
				</BlockControls>
			)}
		</>
	);




	return (
		<>
			{icon ? (
				<span {...useBlockProps()} dangerouslySetInnerHTML={{ __html: icon }} />
			) : (
				<span {...useBlockProps()}>
					<IconPlaceholder
						setInserterOpen={setInserterOpen}
						isQuickInserterOpen={isQuickInserterOpen}
						setQuickInserterOpen={setQuickInserterOpen}
						isCustomInserterOpen={isCustomInserterOpen}
						setCustomInserterOpen={setCustomInserterOpen}
						setAttributes={setAttributes}
						enableCustomIcons={true}
					/>
				</span>
			)}

			{blockControls}

			<InserterModal
				isInserterOpen={isInserterOpen}
				setInserterOpen={setInserterOpen}
				attributes={attributes}
				setAttributes={setAttributes}
			/>
			<CustomInserterModal
				isCustomInserterOpen={isCustomInserterOpen}
				setCustomInserterOpen={setCustomInserterOpen}
				attributes={attributes}
				setAttributes={setAttributes}
			/>
		</>
	);
}

