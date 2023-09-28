
import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { cloneDeep } from 'lodash';
import { createHigherOrderComponent } from '@wordpress/compose'
import { useEffect, useState } from '@wordpress/element'
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
    __experimentalNumberControl as NumberControl
} from '@wordpress/components'

import DimensionControl from '../../../library/client/components/dimension-control';
import FontSizeControl from '../../../library/client/components/font-size-control';
import FontWeightControl from '../../../library/client/components/font-weight-control';
import LineHeightControl from '../../../library/client/components/line-height-control';
import TextDecorationControl from '../../../library/client/components/text-decoration-control';
import TextDecorationLineControl from '../../../library/client/components/text-decoration-line-control';
import TextDecorationStyleControl from '../../../library/client/components/text-decoration-style-control';
import TextTransformControl from '../../../library/client/components/text-transform-control';
import BorderStyleControl from '../../../library/client/components/border-style-control';
import BorderControl from '../../../library/client/components/border-control';
import TextShadowControl from '../../../library/client/components/text-shadow-control';
import BoxShadowControl from '../../../library/client/components/box-shadow-control';
import PositionControl from '../../../library/client/components/position-control';
import DisplayControl from '../../../library/client/components/display-control';

import {
    dragBlockMatchingColors,
    dragBlockMatchingBorderColors,
    dragBlockUnmatchingColors,
    dragBlockUnmatchingBorderColors,
    invertColor,
    dragBlockUnmatchingSizes,
    dragBlockMatchingSizes
} from '../../../library/client/ultils/styling';


import {
    interactionsNames as propNames,
} from './interactions-settings';


import { TextControl } from '@wordpress/components';
import { Flex } from '@wordpress/components';
import { FlexItem } from '@wordpress/components';
import TranslateControl from '../../../library/client/components/translate-control';
import TransformControl from '../../../library/client/components/transform-control';
import AlignItemsControl from '../../../library/client/components/align-items-control';
import JustifyContentControl from '../../../library/client/components/justify-content-control';
import FlexWrapControl from '../../../library/client/components/flex-wrap-control';
import FlexDirectionControl from '../../../library/client/components/flex-direction-control';
import MarginControl from '../../../library/client/components/margin-control';
import TextAlignControl from '../../../library/client/components/text-align-control';
import WidthControl from '../../../library/client/components/width-control';
import SelectorsControl from '../../../library/client/components/selectors-control';
import PopoverProperty from '../../../library/client/components/popover-property';
import AutocompleteSearchBox from '../../../library/client/components/autocomplete-search-box';
import { SelectControl } from '@wordpress/components';
import ChosenControl from '../../../library/client/components/chosen-control';
import { select } from '@wordpress/data'
import { isBanningBlock } from '../../../library/client/ultils/banning';
import { getClassList, getIdList, getSelectors } from '../../../library/client/ultils/selector';


/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 * @note setAttributes will trigger BlockEdit filter (and select Block for Grouping will also trigger BlockEdit)
 * so that will be an infinity loop if You setAttributes "automatically" inside BlockEdit
 * 
 * @note You also need to check if the attribute you want to set automatically has the same as its saved value
 * If it does, don't save because it will trigger infinity loops
 */

const dragBlockInteractionsControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, clientId, isSelected, isMultiSelected } = props;

        const [showControlPopover, setShowControlPopover] = useState(-1);

        let { dragBlockScripts, dragBlockAttrs, className, anchor } = attributes;



        if (!dragBlockScripts) {
            dragBlockScripts = [];
        }


        const updateDragBlockScripts = (property, sub, value, index) => {
            let newScript = cloneDeep(dragBlockScripts)
            if (!newScript[index][property]) {
                newScript[index][property] = []
            }
            if (!newScript[index][property][0]) {
                newScript[index][property][0] = {}
            }
            newScript[index][property][0][sub] = value;

            setAttributes({ dragBlockScripts: newScript })
        }
        const updateDragBlockScripts__ = (property, value, index) => {
            let newScript = cloneDeep(dragBlockScripts)
            newScript[index][property] = value;

            setAttributes({ dragBlockScripts: newScript })
        }

        const actNameToTargetText = (act) => {
            if (act.indexOf('toggle') === 0) { return __('of', 'dragblock') }
            if (act.indexOf('remove') === 0) { return __('from', 'dragblock') }
            if (act.indexOf('add') === 0) { return __('to', 'dragblock') }
            return __('target', 'dragblock')
        }

        const actionOptions = [
            { value: '', label: 'Choose an Action' },
            { value: 'toggleClass', label: 'Toggle Class' },
            { value: 'addClass', label: 'Add Class' },
            { value: 'removeClass', label: 'Remove Class' },




        ]

        if (isBanningBlock(props)) {
            return (<><BlockEdit {...props} /></>)
        }
        return (
            <>
                <BlockEdit {...props} />


                <InspectorControls ><div className='dragblock-inspector-controls interactions'>
                    <PanelBody
                        title={__('Interactions', 'dragblock')}
                        initialOpen={dragBlockScripts.length > 0}
                    >

                        {/* 
                        ------------------------------------------------------------------
                        SEARCH                                        
                        Show the added properties 
                        */}
                        <AutocompleteSearchBox
                            placeholder={__('+ Add a Trigger', 'dragblock')}
                            onSelect={(slug) => {
                                let script = cloneDeep(dragBlockScripts)

                                script.unshift({
                                    value: '',
                                    slug: slug,




                                });
                                setAttributes({ dragBlockScripts: script })
                                setShowControlPopover(0);
                            }}
                            suggestions={propNames}
                        />

                        {/* 
                        ------------------------------------------------------------------
                        PROPERTIES                                        
                        Show the added properties 
                        */}
                        {dragBlockScripts && 0 !== dragBlockScripts.length && (
                            <div className='properties'>
                                {
                                    dragBlockScripts.map((trigger, index) => {

                                        const {
                                            eventSource,

                                            /*
                                            condition element = {target, name, value}
                                            combination:  


                                            (e1 && e2) || (e3 && e4)
                                            [[e1, '&&', e2], '||', [e3, '&&', e4]]
                                            

                                            (e1 || e2) && (e3 || e4)
                                            [[e1, '||', e2], '&&', [e3, '||', e]]

                                            (e1 && e2) && (e3 || e4)
                                            [[e1, '&&', e2], '&&', [e3, '||', e4]]

                                            e1 || (e2 && (e3 || e4))
                                            [e1, '||', [e2, '&&', [e3, '||', e4]]
                                                                                        
                                            */
                                            conditions,
                                            thenActions, // [{target, name, value }]
                                            elseActions, // [{target, name, value }]









                                            disabled
                                        } = trigger;

                                        const availableSelector = getSelectors()
                                        const availableClasses = getClassList();
                                        const availableIds = getIdList();

                                        const condName = conditions && conditions[0] && conditions[0].name ? conditions[0].name : '';
                                        const condValue = conditions && conditions[0] && conditions[0].value ? conditions[0].value : '';
                                        const conTarget = conditions && conditions[0] && conditions[0].target ? conditions[0].target : '';

                                        const thenActName = thenActions && thenActions[0] && thenActions[0].name ? thenActions[0].name : '';
                                        const thenActValue = thenActions && thenActions[0] && thenActions[0].value ? thenActions[0].value : '';
                                        const thenActTarget = thenActions && thenActions[0] && thenActions[0].target ? thenActions[0].target : '';

                                        const elseActName = elseActions && elseActions[0] && elseActions[0].name ? elseActions[0].name : '';
                                        const elseActValue = elseActions && elseActions[0] && elseActions[0].value ? elseActions[0].value : '';
                                        const elseActTarget = elseActions && elseActions[0] && elseActions[0].target ? elseActions[0].target : '';


                                        return (
                                            <div key={index}>
                                                {/* 
                                                -----------------------------------------------------------------
                                                SHOW CODE LINES
                                                -----------------------------------------------------------------
                                                */}

                                                <a
                                                    className={
                                                        classnames('code-lines', {
                                                            'disabled': !!disabled
                                                        })
                                                    }
                                                    onClick={() => {
                                                        setShowControlPopover(index);
                                                    }}
                                                >
                                                    {/* EVENT CODE LINE */}
                                                    <code className='line event'>
                                                        <span className='event-label keyword'>{propNames[trigger.slug].label}</span>
                                                        <span className='event-name connector'>{__('on', 'dragblock')}</span>
                                                        <span className='event-source'>
                                                            {eventSource ? eventSource : __('this', 'dragblock')}
                                                        </span>
                                                    </code>

                                                    {/* CONDITION CODE LINE 
                                                    At this time, we allow to add only element, not allow && or ||
                                                    */}
                                                    {condName && condValue ? (

                                                        <code className='line condition'>
                                                            <span className='condition-label keyword'>{__('If', 'dragblock')}</span>
                                                            {conTarget ? (
                                                                <span className='cond-target condTarget1'>
                                                                    {conTarget}
                                                                </span>
                                                            ) : null}
                                                            <span className='condition-name connector'>{condName}</span>
                                                            <span className='cond-target condTarget1'>{condValue}</span>
                                                        </code>
                                                    ) : null}



                                                    {/* ACTION CODE LINE */}
                                                    {thenActValue && thenActName ?
                                                        (
                                                            <code
                                                                className={classnames('line then-action', {
                                                                    'disabled': !!disabled
                                                                })}>
                                                                <span className='then-action-label keyword'>{__('Then', 'dragblock')}</span>
                                                                <span className='then-action-name connector'>{thenActName}</span>
                                                                <span className='then-action-value'>{thenActValue}</span>
                                                                {thenActTarget ? (
                                                                    <>
                                                                        <span className='thenActTarget-text connector'>
                                                                            {actNameToTargetText(thenActName)}
                                                                        </span>
                                                                        <span className='thenActTarget-value'>{thenActTarget}</span>
                                                                    </>
                                                                ) : null}
                                                            </code>
                                                        ) :
                                                        (
                                                            <code className='line then-action'>{__('do nothing', 'dragblock')}</code>
                                                        )
                                                    }

                                                    {/* ELSE CODE LINE */}
                                                    {condName && condValue && elseActValue && elseActName ?
                                                        (
                                                            <code className='line else-action'>
                                                                <span className='else-action-label keyword'>{__('Else', 'dragblock')}</span>
                                                                <span className='else-action-name connector'>{elseActName}</span>
                                                                <span className='else-action-value'>{elseActValue}</span>
                                                                {elseActTarget ? (
                                                                    <>
                                                                        <span className='elseActTarget-text connector'>
                                                                            {actNameToTargetText(elseActName)}
                                                                        </span>
                                                                        <span className='elseActTarget-value'>{elseActTarget}</span>
                                                                    </>
                                                                ) : null}
                                                            </code>
                                                        ) : null
                                                    }

                                                </a>



                                                {/* 
                                                -----------------------------------------------------------------
                                                MODIFY CODE LINE POP OVER
                                                */}

                                                {
                                                    showControlPopover === index ? (
                                                        <PopoverProperty
                                                            className='dragblock-interactions-control-popover'
                                                            onClose={() => {
                                                                setShowControlPopover(-1);
                                                            }}
                                                            onMouseLeave={() => {
                                                                setShowControlPopover(-1);
                                                            }}
                                                            actions={{hidden: false}}
                                                            onAction={(action, newList) => {

                                                                if ('disable' === action) {
                                                                    if (newList[index]['disabled']) {
                                                                        delete newList[index]['disabled'];
                                                                    } else {
                                                                        newList[index]['disabled'] = '*';
                                                                    }
                                                                }
                                                                setShowControlPopover(-1);
                                                                setAttributes({ dragBlockScripts: newList })
                                                            }}
                                                            disabled={disabled}
                                                            list={dragBlockScripts}
                                                            index={index}

                                                        >
                                                            {/* 
                                                            --------------------------------------------------------------------
                                                            POPOVER CODE LINES >>>>>>>>>>>>>
                                                            --------------------------------------------------------------------
                                                            */}
                                                            <div className='trigger-lines'>
                                                                {/* 
                                                                --------------------------------------------------------------------
                                                                EVENT >>>>>>>>>>>>>
                                                                --------------------------------------------------------------------
                                                                */}
                                                                <div className='line event'>
                                                                    <div className='label'>
                                                                        {propNames[trigger.slug].label} {__('On', 'dragblock')}
                                                                    </div>
                                                                    <div className='controls'>
                                                                        {/* REPLACE SELECTOR CONTROL HERE WITH NOTES/HELPS */}
                                                                        <ChosenControl
                                                                            options={availableSelector}
                                                                            onChange={(value) => {
                                                                                updateDragBlockScripts('eventSource', value, index)
                                                                            }}
                                                                            value={eventSource}
                                                                            placeholder={__('Selector', 'dragblock')}

                                                                        />
                                                                        {/* <TextControl                                                                            
                                                                            value={eventSource}
                                                                            onChange={(value) => {
                                                                                updateDragBlockScripts('eventSource', value, index)
                                                                            }}
                                                                            placeholder={__('Selector', 'dragblock')}
                                                                        /> */}

                                                                    </div>

                                                                </div>


                                                                {/* 
                                                                --------------------------------------------------------------------
                                                                CONDITION >>>>>>>>>>>>>
                                                                --------------------------------------------------------------------
                                                                */}
                                                                <div className='line condition'>

                                                                    <div className='label'>
                                                                        {__('If', 'dragblock')}
                                                                    </div>
                                                                    <div className='controls'>
                                                                        {condName ? (
                                                                            <ChosenControl
                                                                                options={availableSelector}
                                                                                value={conTarget}
                                                                                onChange={(value) => {
                                                                                    updateDragBlockScripts('conditions', 'target', value, index);
                                                                                }}
                                                                                placeholder={__('Selector', 'dragblock')}
                                                                            />

                                                                        ) : null}
                                                                        <SelectControl
                                                                            value={condName}

                                                                            options={[
                                                                                { label: 'Choose a Condition', value: '' },
                                                                                { label: 'Is', value: 'is' },
                                                                            ]}
                                                                            onChange={(value) => {
                                                                                updateDragBlockScripts('conditions', 'name', value, index);
                                                                            }}
                                                                        />
                                                                        {condName ? (
                                                                            <ChosenControl
                                                                                options={availableSelector}
                                                                                value={condValue}
                                                                                onChange={(value) => {
                                                                                    updateDragBlockScripts('conditions', 'value', value, index);
                                                                                }}
                                                                                placeholder={__('Selector', 'dragblock')}
                                                                            />
                                                                        ) : null}
                                                                    </div>
                                                                </div>

                                                                {/* 
                                                                --------------------------------------------------------------------
                                                                ACTION >>>>>>>>>>>>>
                                                                --------------------------------------------------------------------
                                                                */}
                                                                <div className='line then-actions'>

                                                                    <div className='label'>
                                                                        {__('Then', 'dragblock')}
                                                                    </div>
                                                                    <div className='controls'>
                                                                        <SelectControl
                                                                            value={thenActName}
                                                                            options={actionOptions}
                                                                            onChange={(value) => {
                                                                                updateDragBlockScripts('thenActions', 'name', value, index);
                                                                            }}
                                                                        />
                                                                        {thenActName ? (
                                                                            <>
                                                                                <ChosenControl
                                                                                    position='top'
                                                                                    options={
                                                                                        thenActName.indexOf('Class') !== -1 ?
                                                                                            availableClasses : (
                                                                                                thenActName.indexOf('Id') !== -1 ?
                                                                                                    availableIds : null
                                                                                            )
                                                                                    }
                                                                                    value={thenActValue}
                                                                                    onChange={(value) => {
                                                                                        updateDragBlockScripts('thenActions', 'value', value, index);
                                                                                    }}
                                                                                    placeholder={
                                                                                        thenActName.indexOf('Class') !== -1 ?
                                                                                            __('Class Name', 'dragblock') : (
                                                                                                thenActName.indexOf('Id') !== -1 ?
                                                                                                    __('ID', 'dragblock') : 'default'
                                                                                            )
                                                                                    }
                                                                                />
                                                                                <div className='components-base-control fake'>
                                                                                    {actNameToTargetText(thenActName)}
                                                                                </div>
                                                                                <ChosenControl
                                                                                    position='top'
                                                                                    options={availableSelector}
                                                                                    value={thenActTarget}
                                                                                    onChange={(value) => {
                                                                                        updateDragBlockScripts('thenActions', 'target', value, index);
                                                                                    }}
                                                                                    placeholder={__('Selector', 'dragblock')}
                                                                                />
                                                                            </>

                                                                        ) : null}

                                                                    </div>
                                                                </div>



                                                                {/* 
                                                                --------------------------------------------------------------------
                                                                ELSE ACTION >>>>>>>>>>>>>
                                                                --------------------------------------------------------------------
                                                                */}
                                                                {condName && condValue ? (
                                                                    <div className='line else-actions'>

                                                                        <div className='label'>
                                                                            {__('Else', 'dragblock')}
                                                                        </div>
                                                                        <div className='controls'>
                                                                            <SelectControl
                                                                                value={elseActName}
                                                                                options={actionOptions}
                                                                                onChange={(value) => {
                                                                                    updateDragBlockScripts('elseActions', 'name', value, index);
                                                                                }}
                                                                            />
                                                                            {elseActName ? (
                                                                                <>
                                                                                    <ChosenControl
                                                                                        position='top'
                                                                                        options={
                                                                                            elseActValue && elseActValue.indexOf('Class') !== -1 ?
                                                                                                availableClasses : (
                                                                                                    elseActValue && elseActValue.indexOf('Id') !== -1 ?
                                                                                                        availableIds : null
                                                                                                )
                                                                                        }
                                                                                        value={elseActValue}
                                                                                        onChange={(value) => {
                                                                                            updateDragBlockScripts('elseActions', 'value', value, index);
                                                                                        }}
                                                                                        placeholder={
                                                                                            elseActValue && elseActValue.indexOf('Class') !== -1 ?
                                                                                                __('Class Name', 'dragblock') : (
                                                                                                    elseActValue && elseActValue.indexOf('Id') !== -1 ?
                                                                                                        __('ID', 'dragblock') : null
                                                                                                )
                                                                                        }
                                                                                    />
                                                                                    <div className='components-base-control fake'>
                                                                                        {actNameToTargetText(elseActName)}
                                                                                    </div>
                                                                                    <ChosenControl
                                                                                        position='top'
                                                                                        options={availableSelector}
                                                                                        value={elseActTarget}
                                                                                        onChange={(value) => {
                                                                                            updateDragBlockScripts('elseActions', 'target', value, index);
                                                                                        }}
                                                                                        placeholder={__('Selector', 'dragblock')}
                                                                                    />
                                                                                </>

                                                                            ) : null}

                                                                        </div>
                                                                    </div>

                                                                ) : null}

                                                            </div>


                                                        </PopoverProperty>
                                                    ) : null
                                                }

                                            </div>
                                        )
                                    })
                                }
                            </div>
                        )}




                    </PanelBody>

                </div></InspectorControls>


            </>
        );
    };
}, 'dragBlockInteractionsControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/interactions-controls',
    dragBlockInteractionsControls
);

