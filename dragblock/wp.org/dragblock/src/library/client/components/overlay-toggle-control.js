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
    ButtonGroup,
	SelectControl,
} from '@wordpress/components'

import DimensionControl from './dimension-control';

export default function OverlayToggleControl({label, checked, onChange}) {

	return (
        <>
            <div className={classnames('dragblock-overlay-toggle-control', {
                'checked': checked
            })}
            onClick={onChange}
            >
                {label}
            </div>
        </>
    );
}