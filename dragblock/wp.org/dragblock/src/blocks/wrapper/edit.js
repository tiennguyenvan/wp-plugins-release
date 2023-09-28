import { __ } from '@wordpress/i18n';

import { cloneDeep, isNumber } from 'lodash';



import './editor.scss';
import { SelectControl } from '@wordpress/components';
import { useSelect, dispatch, select } from '@wordpress/data';

import classnames from 'classnames';

import { createHigherOrderComponent } from '@wordpress/compose';
import { useState } from '@wordpress/element';
import {
	BlockControls,
	useBlockProps, InnerBlocks, InspectorControls,
	useInnerBlocksProps,
	ButtonBlockAppender
} from '@wordpress/block-editor';


import {
	Tooltip
} from '@wordpress/components';

import {
	initDragBlockStyles
} from '../../applications/editor-panel-appearance/client/appearance-settings';


import {
	flipHorizontal as flipH,
	flipVertical as flipV,
	rotateRight,
	rotateLeft
} from '@wordpress/icons';


import { ToolbarGroup } from '@wordpress/components';
import { ToolbarButton } from '@wordpress/components';
import DropdownToolbar from '../../library/client/components/dropdown-toolbar';
import {
	iconAlignTopBoxO,
	iconAlignCenterBoxO,
	iconAlignBottomBoxO,

	iconJustifyNoneO,
	iconJustifyLeftO,
	iconJustifyCenterO,
	iconJustifyRightO,
	iconJustifySpaceBetweenO,
	iconAlignLeft,
	iconAlignCenter,
	iconAlignRight,
	iconAlignJustify, iconFixedWidth,
	iconAlignNoneBoxO,
	iconLayoutBlockBlueBoxO,
	iconLayoutFlexComplexBlueBoxO,
	iconLayoutGridBlueBoxO,
	iconLayoutBlockGreenBoxO,
	iconLayoutFlexComplexGreenBoxO,
	iconLayoutGridGreenBoxO,
	iconCol3RCO,
	iconGridSelectCol14Row12,
	iconLayoutFlexGreenBoxO,
	iconLayoutFlexBlueBoxO
} from '../../library/client/icons/icons';
import PopoverToolbar from '../../library/client/components/popover-toolbar';
import { Icon } from '@wordpress/components';



const CustomButtonBlockAppender = (props) => {
	return (
		<ButtonBlockAppender
			{...props}
			renderContents={() => <Icon icon="plus" />}
		/>
	);
};

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
		context,
		isSelected
	} = props;
	let {
		dragBlockStyles,
		dragBlockTagName
	} = attributes;

	/*
	carefully check when set 
	the state variable in the main thread 
	to not make a stale state 
	because everytime you update a state variable 
	the main thread will start again
	*/

	const [selectedItemIndex, setSelectedItemIndex] = useState(0);

	const [isMouseDowned, setIsMouseDonwed] = useState(false);
	const [selectedDevice, setSelectedDevice] = useState('');

	const [selectedGridArea, setSelectedGridArea] = useState('');





	let parentDragBlockStyles = []
	if (context && context['dragblock/wrapper-dragBlockStyles']) {
		parentDragBlockStyles = context['dragblock/wrapper-dragBlockStyles'];
	}

	if (!dragBlockStyles) {
		dragBlockStyles = initDragBlockStyles(props.name);
	}
	const getCurrentStyleProperty = (slug, device = '', arr = dragBlockStyles) => {
		for (let i = 0; i < arr.length; i++) {
			let st = arr[i];
			if (st['slug'] === slug &&
				!st['disabled'] &&
				!st['selectors']


			) {
				if (!device && !st['devices'] || (st['devices'] && (device === st['devices']))) return i
			}
		}
		return -1;
	}
	const setCurrentStyleProperty = function (slug, index = -1, value = '', device = '', childIndex = -1) {

		let style = (childIndex === -1 ? cloneDeep(dragBlockStyles) : cloneDeep(innerBlockAttrs[childIndex]['dragBlockStyles']));


		if (index === -1) {
			let new_style = {
				slug: slug,
				value: value,
			}
			if (device) {
				new_style.devices = device
			}
			style.unshift({ ...new_style })
		} else {
			style[index]['value'] = value
		}
		if (childIndex === -1) {
			setAttributes({ dragBlockStyles: cloneDeep(style) });
		} else {

			dispatch('core/block-editor').updateBlockAttributes(innerBlockIds[childIndex], { dragBlockStyles: cloneDeep(style) });
		}
	}


	let displayValue = '';

	let displayIndex = getCurrentStyleProperty('display');

	if (displayIndex !== -1) {
		displayValue = dragBlockStyles[displayIndex]['value']
	}



	let orientation = 'vertical';
	
	if (displayValue === 'flex') {
		let flexDirIdx = getCurrentStyleProperty('flex-direction');
		if (flexDirIdx === -1 || dragBlockStyles[flexDirIdx] !== 'column') {
			orientation = 'horizontal';
		}
	}


	const innerBlockIds = useSelect(select => { return select('core/block-editor').getBlockOrder(clientId); });

	const placeHolderMarkup = null;
	const blockProps = useBlockProps();




	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			orientation: orientation,
			renderAppender: false,
			templateInsertUpdatesSelection: false,
		}
	);






	const blockMarkup = (
		<>
			{(dragBlockTagName === 'div' || !dragBlockTagName) && (
				<div {...innerBlocksProps} data-content-length={innerBlockIds.length} />
			)}
			{(dragBlockTagName === 'section') && (<section {...innerBlocksProps} />)}
			{(dragBlockTagName === 'header') && (<header {...innerBlocksProps} />)}
			{(dragBlockTagName === 'footer') && (<footer {...innerBlocksProps} />)}
			{(dragBlockTagName === 'main') && (<main {...innerBlocksProps} />)}
			{(dragBlockTagName === 'article') && (<article {...innerBlocksProps} />)}
			{(dragBlockTagName === 'aside') && (<aside {...innerBlocksProps} />)}
			{(dragBlockTagName === 'nav') && (<nav {...innerBlocksProps} />)}
			{(dragBlockTagName === 'button') && (<button {...innerBlocksProps} />)}
			{(dragBlockTagName === 'ul') && (<ul {...innerBlocksProps} />)}
			{(dragBlockTagName === 'li') && (<li {...innerBlocksProps} />)}
			{(dragBlockTagName === 'blockquote') && (<blockquote {...innerBlocksProps} />)}
			{(dragBlockTagName === 'pre') && (<pre {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h1') && (<h1 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h2') && (<h2 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h3') && (<h3 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h4') && (<h4 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h5') && (<h5 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'h6') && (<h6 {...innerBlocksProps} />)}
			{(dragBlockTagName === 'label') && (<label {...innerBlocksProps} />)}
			{(dragBlockTagName === 'fieldset') && (<fieldset {...innerBlocksProps} />)}
			{(dragBlockTagName === 'legend') && (<legend {...innerBlocksProps} />)}
		</>
	)

	if (!isSelected) return <>{blockMarkup}</>;




	let innerBlockAttrs = []
	for (let innerBlockClientId of innerBlockIds) {
		const childBlock = select('core/block-editor').getBlock(innerBlockClientId);

		if (!childBlock.attributes['dragBlockStyles']) {
			childBlock.attributes['dragBlockStyles'] = initDragBlockStyles(childBlock.name);
		}
		innerBlockAttrs.push(childBlock.attributes);
	}




	let parentDisplayValue = '';

	if (parentDragBlockStyles.length) {
		let parentDisplayIndex = getCurrentStyleProperty('display', '', parentDragBlockStyles)
		if (parentDisplayIndex !== -1) {
			parentDisplayValue = parentDragBlockStyles[parentDisplayIndex]['value'];
		}
	}







	const displayOptions = [
		{
			label: __('Default', 'dragblock'),
			value: '',

			icon: iconLayoutBlockBlueBoxO,
		},

		{
			label: __('Flex Box', 'dragblock'),
			value: 'flex',
			icon: iconLayoutFlexBlueBoxO,
		},
		{
			label: __('Grid Box', 'dragblock'),
			value: 'grid',
			icon: iconLayoutGridBlueBoxO,
		},
	];
	






	const justifyContentOptions = [
		{
			label: __('Default', 'dragblock'),
			value: '',
			icon: iconJustifyNoneO,
		},
		{
			label: __('Left', 'dragblock'),
			value: 'left',
			icon: iconJustifyLeftO,
		},
		{
			label: __('Center', 'dragblock'),
			value: 'center',
			icon: iconJustifyCenterO,
		},
		{
			label: __('Right', 'dragblock'),
			value: 'right',
			icon: iconJustifyRightO,
		},
		{
			label: __('Space Between', 'dragblock'),
			value: 'space-between',
			icon: iconJustifySpaceBetweenO,
		}
	]
	let justifyContentValue = '';

	let justifyContentIndex = getCurrentStyleProperty('justify-content');

	if (justifyContentIndex !== -1) {
		justifyContentValue = dragBlockStyles[justifyContentIndex]['value']
	}






	const alignItemsOptions = [
		{
			label: __('Default', 'dragblock'),
			value: '',
			icon: iconAlignNoneBoxO,
		},
		{
			label: __('Top', 'dragblock'),
			value: 'start',
			icon: iconAlignTopBoxO,
		},
		{
			label: __('Middle', 'dragblock'),
			value: 'center',
			icon: iconAlignCenterBoxO,
		},
		{
			label: __('Bottom', 'dragblock'),
			value: 'end',
			icon: iconAlignBottomBoxO,
		}
	]
	let alignItemsValue = '';

	let alignItemsIndex = getCurrentStyleProperty('align-items');

	if (alignItemsIndex !== -1) {
		alignItemsValue = dragBlockStyles[alignItemsIndex]['value']
	}










	const enableFlexBasicOptions = true

	const getFlexBasisOptions = (device, label) => {
		const propSlug = 'flex-basis';
		const flexBasisLines = [
			[
				'1/1', '1/2', '1/3', '1/4', '1/5', '1/6',
			],
			[
				'2/3', '2/5', '3/4', '3/5', '4/5', '5/6',
			]
		]
		let index = getCurrentStyleProperty(propSlug, device);
		let value = (index !== -1 && dragBlockStyles[index]) ? dragBlockStyles[index].value : '';

		return (
			<div className={'section ' + device}>
				<label>{label}</label>
				<div className='options'>
					<div className='left'>
						<a onClick={() => {
							setCurrentStyleProperty(propSlug, index, '', device);
						}}
							className={classnames('default', { 'active': !value })}
						>
							{__('Default', 'dragBlock-block')}
						</a>
						<a onClick={() => {
							setCurrentStyleProperty(propSlug, index, 'auto', device);
						}}
							className={classnames('auto', { 'active': (value === 'auto') })}
						>
							{__('Auto', 'dragBlock-block')}
						</a>
					</div>
					<div className='right'>

						{flexBasisLines.map((e, _i) => {
							return (
								<div className='line' key={_i}>
									{e.map((e, _i) => {
										let numerator = e.split('/')[0];
										let denominator = e.split('/')[1];
										let tooltipText = '█ '.repeat(numerator) + '░ '.repeat(denominator - numerator);
										let newValue = (100 * numerator / denominator).toFixed(2) + '%';

										return (
											<a
												key={_i}
												onClick={() => {
													setCurrentStyleProperty(propSlug, index, newValue, device);
												}}
												className={classnames('percent', { 'active': (value === newValue) })}
											>
												<Tooltip delay={10} text={tooltipText} position='top center'><span>{e}</span></Tooltip>
											</a>
										)
									})}
								</div>
							)
						})}
					</div>
				</div>
			</div>
		)
	}

	const flexBasisOptions = (
		<div className='dragblock-toolbar-popover-grid-content flex-basis'>
			{getFlexBasisOptions('d', __('Desktop', 'dragblock'))}
			{getFlexBasisOptions('t', __('Tablet', 'dragblock'))}
			{getFlexBasisOptions('m', __('Mobile', 'dragblock'))}
		</div>
	)




	const getGridTempColNum = (value) => {
		if (!value) return 0

		return parseInt(value.replace('repeat(', '').replace(',1fr)', ''))
	}


	const getGridTempColOptions = (device, label) => {
		const propSlug = 'grid-template-columns';

		const gridTempColLines = [
			[
				1, 2, 3, 4, 5, 6,
			],
			[
				7, 8, 9, 10, 11, 12
			]
		]

		let index = getCurrentStyleProperty(propSlug, device);
		let value = (index !== -1 && dragBlockStyles[index]) ? dragBlockStyles[index].value : 0;
		if (value) {
			value = getGridTempColNum(value)
		}

		return (
			<div className={'section ' + device}>
				<label>{label}</label>
				<div className='options'>
					<div className='left'>
						<a onClick={() => {
							setCurrentStyleProperty(propSlug, index, '', device);
						}}
							className={classnames('default', { 'active': !value })}
						>
							<span>{__('Default', 'dragBlock-block')}</span>
						</a>
					</div>
					<div className='right'>
						{gridTempColLines.map((e, _i) => {
							return (
								<div className='line' key={_i}>
									{e.map((e, _i) => {
										let tooltipText = '█ '.repeat(e);
										return (
											<a
												key={_i}
												onClick={() => {
													setCurrentStyleProperty(propSlug, index, 'repeat(' + e.toString() + ',1fr)', device);
												}}
												className={classnames('number', { 'active': (value === e) })}
											>
												<Tooltip delay={10} text={tooltipText} position='top center'><span>{e.toString()}</span></Tooltip>
											</a>
										)
									})}
								</div>
							)
						})}
					</div>
				</div>
			</div>
		)
	}

	const gridTempColOptions = (
		<div className='dragblock-toolbar-popover-grid-content grid-template-columns'>
			{getGridTempColOptions('d', __('Desktop', 'dragblock'))}
			{getGridTempColOptions('t', __('Tablet', 'dragblock'))}
			{getGridTempColOptions('m', __('Mobile', 'dragblock'))}
		</div>
	)






	const textAlignOptions = [
		{
			label: __('Left', 'dragblock'),
			value: '',
			icon: iconAlignLeft,
		},
		{
			label: __('Center', 'dragblock'),
			value: 'center',
			icon: iconAlignCenter,
		},
		{
			label: __('Right', 'dragblock'),
			value: 'right',
			icon: iconAlignRight,
		},
		{
			label: __('Justify', 'dragblock'),
			value: 'justify',
			icon: iconAlignJustify,
		}
	];

	let textAlignValue = '';

	let textAlignIndex = getCurrentStyleProperty('text-align');

	if (textAlignIndex !== -1) {
		textAlignValue = dragBlockStyles[textAlignIndex]['value']
	}

	/**


	@todo: This is not done yet

	*/
	const enableGridItemAreaOptions = false;

	if (enableGridItemAreaOptions) {
		const getGridItemAreaOptions = (device, label) => {
			let parentColIndex = getCurrentStyleProperty('grid-template-columns', device, parentDragBlockStyles);

			if (parentColIndex === -1) return null;

			let parentColValue = getGridTempColNum(parentDragBlockStyles[parentColIndex]['value']);



			if (!parentColValue) return null;



			let colIndex = getCurrentStyleProperty('grid-column', device)
			let rowIndex = getCurrentStyleProperty('grid-row', device);

			if (colIndex === -1) {
				setCurrentStyleProperty('grid-column', colIndex, '', device)
				colIndex = getCurrentStyleProperty('grid-column', device)
			}
			if (rowIndex === -1) {
				setCurrentStyleProperty('grid-row', colIndex, '', device)
				rowIndex = getCurrentStyleProperty('grid-row', device)
			}


			let colValue = colIndex === -1 ? '0/0' : dragBlockStyles[colIndex]['value'];
			let rowValue = rowIndex === -1 ? '0/0' : dragBlockStyles[rowIndex]['value'];
			colValue = colValue.split('/');
			rowValue = rowValue.split('/');

			if (colValue.length !== 2) {
				colValue = [0, 0]
			}
			if (rowValue.length !== 2) {
				rowValue = [0, 0]
			}

			let [colStartValue, colEndValue] = colValue.map(e => (isNaN(e) ? 0 : parseInt(e)))
			let [rowStartValue, rowEndValue] = rowValue.map(e => (isNaN(e) ? 0 : parseInt(e)))


			if (colEndValue > parentColValue + 1) {
				colEndValue = parentColValue + 1;
			}

			let gridTempPlaceLines = new Array(6).fill(null).map(e => new Array(parentColValue).fill(null));


			if ('undefined' !== typeof (isMouseDowned__)) { var isMouseDowned__ = false }
			if ('undefined' !== typeof (selectingColStart)) { var selectingColStart = colStartValue }
			if ('undefined' !== typeof (selectingColEnd)) { var selectingColEnd = colEndValue }
			if ('undefined' !== typeof (selectingRowStart)) { var selectingRowStart = rowStartValue }
			if ('undefined' !== typeof (selectingRowEnd)) { var selectingRowEnd = rowEndValue }


			return (
				<div className={'section ' + device} onMouseEnter={() => {
					isMouseDowned__ = false;
					selectingColStart = colStartValue;
					selectingRowStart = rowStartValue;
					selectingColEnd = colEndValue;
					selectingRowEnd = rowEndValue;
				}}>
					<label>{label}</label>
					<div className='options'>
						<div className='left'>
							<a
								className={classnames('default', { 'active': (colStartValue === 0) })}
								onClick={() => {
									setCurrentStyleProperty('grid-column', colIndex, '', device);
									setCurrentStyleProperty('row-column', rowIndex, '', device);
								}}
							>
								<span>{__('Default', 'dragBlock-block')}</span>
							</a>
						</div>
						<div className='right'>
							{gridTempPlaceLines.map((e, i) => {
								return (
									<div className='line' key={i}>
										{e.map((e, j) => {
											let colStart = (j + 1);
											let colEnd = (j + 2);
											let rowStart = (i + 1);
											let rowEnd = (i + 2);
											let isActive = (colStart >= selectingColStart) &&
												(colEnd <= selectingColEnd) &&
												(rowStart >= selectingRowStart) &&
												(rowEnd <= selectingRowEnd)

											return (
												<a
													key={j}
													onMouseEnter={() => {
														if (!isMouseDowned__) return;


														if (isActive) {
															if (selectingColStart < colStart) selectingColStart = colStart;
															if (selectingRowStart < rowStart) selectingRowStart = rowStart
															if (selectingColEnd > colEnd) selectingColEnd = colEnd;
															if (selectingRowEnd > rowEnd) selectingRowEnd = rowEnd;
														} else {
															if (selectingColStart > colStart) selectingColStart = colStart;
															if (selectingRowStart > rowStart) selectingRowStart = rowStart;
															if (selectingColEnd < colEnd) selectingColEnd = colEnd;
															if (selectingRowEnd < rowEnd) selectingRowEnd = rowEnd;
														}



													}}
													onMouseDown={() => {
														isMouseDowned__ = true;
														selectingColStart = colStart;
														selectingRowStart = rowStart;
														selectingColEnd = colEnd;
														selectingRowEnd = rowEnd;









													}}
													onMouseUp={() => {
														setCurrentStyleProperty('grid-column', colIndex, selectingColStart.toString() + '/' + selectingColEnd.toString(), device);
														setCurrentStyleProperty('grid-row', rowIndex, selectingRowStart.toString() + '/' + selectingRowEnd.toString(), device);
														isMouseDowned__ = false;
													}}
													className={classnames('cell', { 'active': isActive })}
												>

												</a>
											)
										})}
									</div>
								)
							})}
						</div>
					</div>
				</div>
			)
		}

		const gridItemAreaOptions = (
			<div className='dragblock-toolbar-popover-grid-content grid-item-area'>
				{getGridItemAreaOptions('d', __('Desktop', 'dragblock'))}
				{getGridItemAreaOptions('t', __('Tablet', 'dragblock'))}
				{getGridItemAreaOptions('m', __('Mobile', 'dragblock'))}
			</div>
		);
	}



	/***************************************************************
	We chose to add grid-column and grid-row to the children because
	that would allow a chance to apply on-item layout selection system.
	For example, we can visually resize item on the grid
	
	@see:
	We put properties on the child element instead of using nth-child
	on the parent to not overcomplicated the appearance list of the parent
	*****************************************************************/

	const gridRowCol2Area = (rowStart, colStart, rowEnd, colEnd) => {
		return (rowStart + '/' + colStart + '/' + rowEnd + '/' + colEnd);
	}

	/**
	 * 
	 * @param {*} area 
	 * @returns [row-start, col-start, row-end, col-end]
	 */
	const gridArea2RowCol = (area) => {
		if (!area) return [0, 0, 0, 0];
		let gridArea = area.split('/');

		if (gridArea.length === 4) {
			for (let value of gridArea) {
				if (isNaN(value)) return [0, 0, 0, 0];
			}

			return gridArea.map(e => parseInt(e));
		}

		return [0, 0, 0, 0];
	}

	/**
	 * 
	 * @param {*} i 
	 * @returns [row-start, column-start, row-end, column-end]
	 */
	const itemIndex2RowCol = (i, colNum) => {
		let j = i % colNum;
		i = parseInt(i / colNum);
		return [i + 1, j + 1, i + 2, j + 2]
	}

	const getGridLayoutOptions = (device, label) => {
		if (!innerBlockIds.length) return null;

		let parentColIndex = getCurrentStyleProperty('grid-template-columns', device);
		if (parentColIndex === -1) return null;
		let parentColNum = getGridTempColNum(dragBlockStyles[parentColIndex]['value']);
		if (!parentColNum) return null;
		const maxRowNum = 6; // change in the editor.scss too
		let reseted = true;
		let gridItems = new Array(innerBlockIds.length).fill(null).map((_, i) => {
			const gridStyle = innerBlockAttrs[i]['dragBlockStyles'];
			let ret = new Object();
			ret.gridAreaIndex = getCurrentStyleProperty('grid-area', device, gridStyle);



			ret.gridArea = (ret.gridAreaIndex === -1 ? '' : gridStyle[ret.gridAreaIndex]['value'])
			let [rowStart, colStart, rowEnd, colEnd] = gridArea2RowCol(ret.gridArea);



			if (colEnd > parentColNum + 1) {
				colEnd = parentColNum + 1;
			}
			if (rowEnd > maxRowNum) {
				rowEnd = maxRowNum;
			}

			ret.gridArea = gridRowCol2Area(rowStart, colStart, rowEnd, colEnd);
			if (ret.gridArea !== '0/0/0/0') {
				reseted = false;
			}



			return ret;
		});

		let maskItems = new Array(parentColNum * maxRowNum).fill(null);


		return (
			<div className={'section ' + device}
			>
				<label>{label}</label>

				<div className='options'>
					<div className='left'>
						<a
							className={classnames('default', {
								'active': (
									(gridItems[selectedItemIndex] && (!gridItems[selectedItemIndex]['gridArea'] || gridItems[selectedItemIndex]['gridArea'] === '0/0/0/0'))
								)
							})}
							onClick={() => {
								const gridStyle = innerBlockAttrs[selectedItemIndex]['dragBlockStyles'];
								let gridAreaIndex = getCurrentStyleProperty('grid-area', device, gridStyle);




								setSelectedDevice('default' + device);
								setCurrentStyleProperty(
									'grid-area',
									gridAreaIndex,
									'',
									device,
									selectedItemIndex
								);
							}}
						>
							<span>{__('Default', 'dragBlock-block')}</span>
						</a>

						<a
							className={classnames('reset', { 'active': (reseted) })}
							onClick={() => {

								setSelectedDevice('reset' + device);
								gridItems.map((__, index) => {
									const gridStyle = innerBlockAttrs[index]['dragBlockStyles'];
									let gridAreaIndex = getCurrentStyleProperty('grid-area', device, gridStyle);


									setCurrentStyleProperty(
										'grid-area',
										gridAreaIndex,
										'',
										device,
										index
									);

								})

							}}
						>
							<span>{__('Reset All', 'dragBlock-block')}</span>
						</a>
					</div>


					<div className='right'>
						<div className='blocks' style={{ gridTemplateColumns: 'repeat(' + parentColNum + ',1fr)' }}>
							{
								gridItems.map((gE, gI) => {

									let gridArea = gE.gridArea;


									if (isMouseDowned && gI === selectedItemIndex && device === selectedDevice) {
										gridArea = selectedGridArea;
									}

									let isActive = (gridArea !== '' && gridArea !== '0/0/0/0')

									return (
										<a
											key={gI}
											style={{ gridArea: gridArea }}
											className={classnames('block', {
												'active': isActive,
												'selected': ((gI === selectedItemIndex))
											})}
										>{gI + 1}</a>
									)
								})
							}
						</div>

						<div className='mask' style={{ gridTemplateColumns: 'repeat(' + parentColNum + ',1fr)' }}>
							{
								maskItems.map((_, i) => {
									return (
										<a
											key={i}
											onMouseDown={() => {
												setIsMouseDonwed(true);
												setSelectedDevice(device)
												let [
													rowStart,
													colStart,
													rowEnd,
													colEnd
												] = itemIndex2RowCol(i, parentColNum)
												let gridArea = gridRowCol2Area(rowStart, colStart, rowEnd, colEnd);
												setSelectedGridArea(gridArea);
											}}
											onMouseEnter={() => {
												if (!isMouseDowned) return;

												let [
													curRowStart,
													curColStart,
													curRowEnd,
													curColEnd
												] = gridArea2RowCol(selectedGridArea)
												let [
													rowStart,
													colStart,
													rowEnd,
													colEnd
												] = itemIndex2RowCol(i, parentColNum)

												const isActive =
													(curRowStart <= rowStart) && (rowEnd <= curRowEnd) &&
													(curColStart <= colStart) && (colEnd <= curColEnd)

												if (isActive) {
													if (curRowStart < rowStart) curRowStart = rowStart
													if (curColStart < colStart) curColStart = colStart;
													if (curRowEnd > rowEnd) curRowEnd = rowEnd;
													if (curColEnd > colEnd) curColEnd = colEnd;
												} else {
													if (curRowStart > rowStart) curRowStart = rowStart;
													if (curColStart > colStart) curColStart = colStart;
													if (curRowEnd < rowEnd) curRowEnd = rowEnd;
													if (curColEnd < colEnd) curColEnd = colEnd;
												}
												let gridArea = gridRowCol2Area(curRowStart, curColStart, curRowEnd, curColEnd);
												setSelectedGridArea(gridArea);

											}}
											onMouseUp={() => {
												setIsMouseDonwed(false);
												setSelectedDevice('')

												const gridStyle = innerBlockAttrs[selectedItemIndex]['dragBlockStyles'];
												let gridAreaIndex = getCurrentStyleProperty('grid-area', device, gridStyle);



												setCurrentStyleProperty(
													'grid-area',
													gridAreaIndex,
													selectedGridArea,
													device,
													selectedItemIndex
												);

												setSelectedGridArea('');
											}}

										></a>
									)
								})
							}
						</div>


					</div>
				</div>
			</div>
		)
	}

	const gridLayoutOptionOnDesktop = getGridLayoutOptions('d', __('Desktop', 'dragblock'))
	const gridLayoutOptionOnTablet = getGridLayoutOptions('t', __('Tablet', 'dragblock'))
	const gridLayoutOptionOnMobile = getGridLayoutOptions('m', __('Mobile', 'dragblock'))


	const gridLayoutOptions = (
		gridLayoutOptionOnDesktop || gridLayoutOptionOnTablet || gridLayoutOptionOnMobile
	) ? (
		<div className='dragblock-toolbar-popover-grid-content grid-layout'>
			<div className='items'>
				{
					innerBlockIds.map((_, i) => {
						return (
							<a
								key={i}
								className={classnames('item', {
									'selected': (i === selectedItemIndex)
								})}
								onClick={() => {
									setSelectedItemIndex(i)
								}}
							>{(i + 1)}</a>
						)
					})
				}
			</div>
			<div className='sections'>
				{gridLayoutOptionOnDesktop}
				{gridLayoutOptionOnTablet}
				{gridLayoutOptionOnMobile}
			</div>
		</div>
	) : null;


	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<DropdownToolbar
						value={displayValue}
						options={displayOptions}
						label={__('Display Mode')}
						onChange={(value) => { setCurrentStyleProperty('display', displayIndex, value) }}
					/>


					{(enableFlexBasicOptions) && (parentDisplayValue === 'flex') && (
						<>
							<PopoverToolbar
								icon={iconFixedWidth}
								label={__('Flex Basis', 'dragblock')}
							>
								{flexBasisOptions}
							</PopoverToolbar>

						</>
					)}
					{(enableGridItemAreaOptions) && (parentDisplayValue === 'grid') && (
						<>
							<PopoverToolbar
								icon={iconGridSelectCol14Row12}
								label={__('Select Item Area', 'dragblock')}
							>
								{gridItemAreaOptions}
							</PopoverToolbar>

						</>
					)}
					{(!displayValue) && (
						<>
							<DropdownToolbar
								value={textAlignValue}
								options={textAlignOptions}
								label={__('Text Align')}
								onChange={(value) => { setCurrentStyleProperty('text-align', textAlignIndex, value) }}
							/>
						</>
					)}

					{(displayValue === 'flex') && (
						<>
							<DropdownToolbar
								value={justifyContentValue}
								options={justifyContentOptions}
								label={__('Justify Content')}
								onChange={(value) => { setCurrentStyleProperty('justify-content', justifyContentIndex, value) }}
							/>

							<DropdownToolbar
								value={alignItemsValue}
								options={alignItemsOptions}
								label={__('Align Items')}
								onChange={(value) => { setCurrentStyleProperty('align-items', alignItemsIndex, value) }}
							/>
						</>
					)}

					{(displayValue === 'grid') && (
						<>
							<PopoverToolbar
								icon={iconCol3RCO}
								label={__('Grid Column Number', 'dragblock')}
							>
								{gridTempColOptions}
							</PopoverToolbar>

							{((innerBlockIds.length) && (gridLayoutOptions)) ? (
								<PopoverToolbar
									onKeyDown={(event) => {
										if (!isNaN(event.key)) {
											setSelectedItemIndex(Number(event.key) - 1);
										}
									}}
									icon={iconGridSelectCol14Row12}
									label={__('Grid Layout Designer', 'dragblock')}
								>
									{gridLayoutOptions}
								</PopoverToolbar>
							) : null}

						</>
					)}







				</ToolbarGroup>
			</BlockControls>

			<InspectorControls __experimentalGroup="advanced">
				<SelectControl
					label={__('Tag Name', 'dragblock')}
					value={dragBlockTagName}
					onChange={(value) => {
						setAttributes({ dragBlockTagName: value })
					}}
					options={
						[
							{ value: 'div', label: __('<div> (Default)', 'dragblock') },
							{ value: 'section', label: __('<footer>', 'dragblock') },
							{ value: 'header', label: __('<header>', 'dragblock') },
							{ value: 'footer', label: __('<footer>', 'dragblock') },
							{ value: 'main', label: __('<main>', 'dragblock') },
							{ value: 'article', label: __('<article>', 'dragblock') },
							{ value: 'aside', label: __('<aside>', 'dragblock') },
							{ value: 'nav', label: __('<nav>', 'dragblock') },
							{ value: 'ul', label: __('<ul>', 'dragblock') },
							{ value: 'li', label: __('<li>', 'dragblock') },
							{ value: 'button', label: __('<button>', 'dragblock') },
							{ value: 'blockquote', label: __('<blockquote>', 'dragblock') },
							{ value: 'pre', label: __('<pre>', 'dragblock') },
							{ value: 'h1', label: __('<h1>', 'dragblock') },
							{ value: 'h2', label: __('<h2>', 'dragblock') },
							{ value: 'h3', label: __('<h3>', 'dragblock') },
							{ value: 'h4', label: __('<h4>', 'dragblock') },
							{ value: 'h5', label: __('<h5>', 'dragblock') },
							{ value: 'h6', label: __('<h6>', 'dragblock') },
							{ value: 'label', label: __('<label>', 'dragblock') },
							{ value: 'fieldset', label: __('<fieldset>', 'dragblock') },
							{ value: 'legend', label: __('<legend>', 'dragblock') },
						]
					}
				/>
			</InspectorControls>
			<>{blockMarkup}</>
		</>
	);
}