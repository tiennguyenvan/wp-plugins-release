/**
 * External dependencies
 */
import { intersection } from 'lodash';

/**
 * WordPress dependencies
 */
import { useMemo } from '@wordpress/element';
import {
	BaseControl,
	RangeControl,
	Flex,
	FlexItem,
	__experimentalSpacer as Spacer, // eslint-disable-line
	__experimentalUseCustomUnits as useCustomUnits, // eslint-disable-line
	__experimentalUnitControl as UnitControl, // eslint-disable-line
	__experimentalParseQuantityAndUnitFromRawValue as parseQuantityAndUnitFromRawValue, // eslint-disable-line
} from '@wordpress/components';
import { useSetting } from '@wordpress/block-editor';

import AvailableSelectedUnit, { defaultUnits } from './settings';
import LegendLabel from './label';

export default function DimensionControl({ onChange, label, value, placeholder, units }) {
	
	const rangeValue = (isNaN(value) ? 0 : parseFloat(value));



	const isForceUnits = (Array.isArray(units));
	if (isForceUnits) {
		let temp = units;
		units = new Object();
		for (let u of temp) {
			units[u['value']] = u;
		}
	}

	if (!isForceUnits || !units) {
		units = Object.assign({}, defaultUnits, units);
	}
	

	let { availableUnits, selectedUnit } = AvailableSelectedUnit({ value, units: Object.values(units) });

	if (!availableUnits.length) {
		availableUnits = Object.values(units);
	}
	

	const handleSliderChange = (next) => {
		
		onChange([next, selectedUnit].join(''));
	};

	const handleChange = (unitValue) => {
		




		onChange(unitValue);

	};

	const handleUnitChange = (newUnit) => {


		const [currentValue, currentUnit] =
			parseQuantityAndUnitFromRawValue(value);

		if (['em', 'rem'].includes(newUnit) && currentUnit === 'px') {

			onChange((currentValue / 16).toFixed(2) + newUnit);
		} else if (
			['em', 'rem'].includes(currentUnit) &&
			newUnit === 'px'
		) {

			onChange(Math.round(currentValue * 16) + newUnit);
		} else if (
			['vh', 'vw', '%'].includes(newUnit) &&
			currentValue > 100
		) {

			onChange(100 + newUnit);
		}
	};

	

	return (
		<fieldset className="dragblock-dimension-control">

			<LegendLabel className='label'>
				{label}
			</LegendLabel>
			<div className='control'>
				<div className='unit'>
					<UnitControl
						value={value}
						units={availableUnits}
						onChange={handleChange}
						onUnitChange={handleUnitChange}

						min={units[selectedUnit]
							?.min ?? 0}
						max={
							units[selectedUnit]
								?.max ?? 100
						}
						step={
							units[selectedUnit]
								?.step ?? 0.1
						}

						placeholder={placeholder}
					/>
				</div>
				<div className='spacer'>
					<Spacer marginX={2} marginBottom={0}>
						<RangeControl
							value={rangeValue}
							min={units[selectedUnit]
								?.min ?? 0}
							max={
								units[selectedUnit]
									?.max ?? 100
							}
							step={
								units[selectedUnit]
									?.step ?? 0.1
							}
							withInputField={false}
							onChange={handleSliderChange}
							__nextHasNoMarginBottom
						/>
					</Spacer>
				</div>
			</div>
		</fieldset>
	);
}
