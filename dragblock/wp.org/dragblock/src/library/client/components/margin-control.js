import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose'
import { useState } from '@wordpress/element'
import {
	InspectorAdvancedControls,
	InspectorControls,
	useSetting,
	__experimentalPanelColorGradientSettings as PanelColorGradientSettings,
} from '@wordpress/block-editor'

import {
	ToggleControl,
	PanelBody,
	SearchControl,
	ColorPicker,
	ColorPalette,
	Tooltip,
	Popover,
	Autocomplete,
	Button,
	ButtonGroup
} from '@wordpress/components'

import DimensionControl from './dimension-control';
import BorderStyleControl from './border-style-control';
import OverlayToggleControl from './overlay-toggle-control';
import { iconCancelCircleFilled, iconLink, iconLinkOff, iconReset } from '../icons/icons';

export default function MarginControl({ value, onChange, switcher, minus }) {
	const [all, setAll] = useState(value.indexOf(' ') === -1);

	if (typeof (switcher) === 'undefined') {
		switcher = false;
	}
	if (typeof (minus) === 'undefined') {
		minus = false;
	}

	let partValue = typeof (value) === 'undefined' || value === '' ? '0px' : value;

	let [top, right, bottom, left] = [partValue, partValue, partValue, partValue]


	let values = partValue.split(' ');
	if (values.length === 2) {
		top = values[0];
		bottom = values[0];
		right = values[1];
		left = values[1];
	} else if (values.length === 3) {
		top = values[0];
		left = values[0];
		bottom = values[1];
		right = values[2];
	} else if (values.length === 4) {
		top = values[0];
		right = values[1];
		bottom = values[2];
		left = values[3];
	}

	if (top === '') top = '0px';
	if (right === '') top = '0px';
	if (bottom === '') bottom = '0px';
	if (left === '') left = '0px';



	const item = (position, value, onChange) => {
		return (
			<>

				<div className={'item ' + position}>
					{('all' !== position) ? (
						<>
							<span className='position'>{position}</span>
						</>
					) : null}
					<div className='control'>
						<DimensionControl
							value={value === 'auto' ? '' : value}
							units={
								{
									px: { value: 'px', label: 'px', min: (minus ? -500 : 0), max: 500, step: 1, default: 0 },
									'%': { value: '%', label: '%', min: (minus ? -100 : 0), max: 100, step: 1, default: 0 },
									em: { value: 'em', label: 'em', min: (minus ? -100 : 0), max: 100, step: 1, default: 0 },
									rem: { value: 'rem', label: 'rem', min: (minus ? -100 : 0), max: 100, step: 1, default: 0 },
									vw: { value: 'vw', label: 'vw', min: (minus ? -100 : 0), max: 100, step: 1, default: 0 },
									vh: { value: 'vh', label: 'vh', min: (minus ? -100 : 0), max: 100, step: 1, default: 0 },
								}
							}
							onChange={(newValue) => {
								onChange(newValue);
							}}
						/>
						{minus === true && (
							<OverlayToggleControl
								label={__('Auto', 'dragblock')}
								checked={value === 'auto'}
								onChange={() => {
									onChange(value === 'auto' ? '' : 'auto');
								}}
							/>
						)}

					</div>
				</div>
			</>
		)
	}
	return (
		<>
			<div className='dragblock-margin-control'>
				{switcher && (
					<>
						<div
							className={classnames('action switcher', { 'active': !all })}
							onClick={() => { setAll(!all) }}
						>
							{all && (iconLinkOff)}
							{!all && (iconLink)}
						</div>
						{
							value.indexOf(' ') !== -1 && (
								<div
									className={classnames('action reset')}
									onClick={() => {
										onChange('');
									}}
								>
									{iconCancelCircleFilled}
								</div>
							)

						}
					</>
				)}

				{(all) && (item('all', value.indexOf(' ') === -1 ? value : '', onChange))}

				{(!all) && (
					<>
						{item('top', top, function (value) {

							onChange([value, right, bottom, left].join(' '))
						})}
						{item('right', right, function (value) {
							onChange([top, value, bottom, left].join(' '))
						})}
						{item('bottom', bottom, function (value) {
							onChange([top, right, value, left].join(' '))
						})}
						{item('left', left, function (value) {
							onChange([top, right, bottom, value].join(' '))
						})}

					</>
				)}

			</div>
		</>

	)
}