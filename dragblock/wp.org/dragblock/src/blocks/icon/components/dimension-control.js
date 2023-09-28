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

const RANGE_CONTROL_CUSTOM_SETTINGS = {
	px: { max: 1000, step: 1 },
	'%': { max: 100, step: 1 },
	vw: { max: 100, step: 1 },
	vh: { max: 100, step: 1 },
	em: { max: 50, step: 0.1 },
	rem: { max: 50, step: 0.1 },
};

export default function DimensionControl( { onChange, label, units, value } ) {
	const customRangeValue = parseFloat( value );
	const themeJsonUnits = useSetting( 'spacing.units' );
	let defaultUnits;

	if ( units && themeJsonUnits ) {
		defaultUnits = intersection( units, themeJsonUnits );
	} else {
		defaultUnits = units || themeJsonUnits;
	}

	const availableUnits = useCustomUnits( {
		availableUnits: defaultUnits || [ '%', 'px', 'em', 'rem', 'vh', 'vw' ],
	} );

	const selectedUnit =
		useMemo(
			() => parseQuantityAndUnitFromRawValue( value ),
			[ value ]
		)[ 1 ] ||
		availableUnits[ 0 ]?.value ||
		'px';

	const handleSliderChange = ( next ) => {
		onChange( [ next, selectedUnit ].join( '' ) );
	};

	const handleChange = ( unitValue ) => {

		const [ newValue, newUnit ] = // eslint-disable-line
			parseQuantityAndUnitFromRawValue( unitValue );
		if ( newValue ) {
			onChange( unitValue );
		}
	};

	const handleUnitChange = ( newUnit ) => {


		const [ currentValue, currentUnit ] =
			parseQuantityAndUnitFromRawValue( value );

		if ( [ 'em', 'rem' ].includes( newUnit ) && currentUnit === 'px' ) {

			onChange( ( currentValue / 16 ).toFixed( 2 ) + newUnit );
		} else if (
			[ 'em', 'rem' ].includes( currentUnit ) &&
			newUnit === 'px'
		) {

			onChange( Math.round( currentValue * 16 ) + newUnit );
		} else if (
			[ 'vh', 'vw', '%' ].includes( newUnit ) &&
			currentValue > 100
		) {

			onChange( 100 + newUnit );
		}
	};

	return (
		<fieldset className="components-dimension-control">
			<BaseControl.VisualLabel as="legend">
				{ label }
			</BaseControl.VisualLabel>
			<Flex>
				<FlexItem>
					<UnitControl
						value={ value }
						units={ availableUnits }
						onChange={ handleChange }
						onUnitChange={ handleUnitChange }
						min={ 0 }
						size={ '__unstable-large' }
					/>
				</FlexItem>
				<FlexItem>
					<Spacer marginX={ 2 } marginBottom={ 0 }>
						<RangeControl
							value={ customRangeValue }
							min={ 0 }
							max={
								RANGE_CONTROL_CUSTOM_SETTINGS[ selectedUnit ]
									?.max ?? 100
							}
							step={
								RANGE_CONTROL_CUSTOM_SETTINGS[ selectedUnit ]
									?.step ?? 0.1
							}
							withInputField={ false }
							onChange={ handleSliderChange }
							__nextHasNoMarginBottom
						/>
					</Spacer>
				</FlexItem>
			</Flex>
		</fieldset>
	);
}
