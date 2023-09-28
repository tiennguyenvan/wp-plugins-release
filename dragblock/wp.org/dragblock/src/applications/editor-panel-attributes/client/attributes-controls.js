
import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { cloneDeep, isEmpty } from 'lodash';
import { createHigherOrderComponent } from '@wordpress/compose'
import { useEffect, useState } from '@wordpress/element'
import { useBlockProps } from '@wordpress/block-editor';

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
    attributesNames as propNames,
    defaultAttributes as defaultProps,
    findAttrIndex,
    initDragBlockAttrs
} from './attributes-settings';


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
import { SelectControl, FormFileUpload } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { select } from '@wordpress/data'
import { isBanningBlock } from '../../../library/client/ultils/banning';
import ChosenControl from '../../../library/client/components/chosen-control';
import { dragBlockQueryShortcodes } from '../../../library/client/ultils/shortcodes';
import { wpSystemNativeClasses } from '../../../library/client/ultils/selector';
import MultillingualTextControl from '../../../library/client/components/multilingual-text-control';
import { iconClipboardCheck, iconClipboardMinus, iconClipboardPlus, iconDesktop, iconMobile, iconTable, iconTablet } from '../../../library/client/icons/icons';
import { getLowestCommonAncestorWithSelectedBlock } from '@wordpress/block-editor/build/store/selectors';


/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 * @note setAttributes will trigger BlockEdit filter (and select Block for Grouping will also trigger BlockEdit)
 * so that will be an infinity loop if You setAttributes "automatically" inside BlockEdit
 * 
 * @note You also need to check if the attribute you want to set automatically has the same as its saved value
 * If it does, don't save because it will trigger infinity loops
 */
const dragBlockAttributesControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, clientId, isSelected, isMultiSelected } = props;
        const [showControlPopover, setShowControlPopover] = useState(-1);
        const [selectedCtrl, setSelectedCtrl] = useState({})

        let { dragBlockClientId, dragBlockAttrs } = attributes;




        if (!dragBlockAttrs) {
            dragBlockAttrs = initDragBlockAttrs(props.name);
        }

        const cltrPopover = (index) => {
            setShowControlPopover(index);
            setSelectedCtrl({});
        }

        const updateDragBlockAttrs = (value, index, locale) => {
            let newAttr = cloneDeep(dragBlockAttrs)
            newAttr[index]['value'] = value;

            if (locale) {
                newAttr[index]['locale'] = locale;
            }

            setAttributes({ dragBlockAttrs: newAttr })
        }
        const updateDevices = (styleList, index, device) => {
            let style = cloneDeep(styleList)
            if (!style[index]['devices']) style[index]['devices'] = '';
            if (style[index]['devices'].indexOf(device) === -1) style[index]['devices'] += device;
            else style[index]['devices'] = style[index]['devices'].replace(device, '')
            if (style[index]['devices'] === '') delete style[index]['devices']

            return style;
        }

        const deviceControl = (text, icon, value, index, prop) => {
            return (
                <>
                    <Tooltip
                        text={text}
                        delay={10}
                        position='top center'
                    >
                        <a className={
                            classnames('extra-item', {
                                'active': prop['devices'] && prop['devices'].indexOf(value) !== -1
                            })
                        }
                            onClick={() => {
                                setAttributes({ dragBlockAttrs: updateDevices(dragBlockAttrs, index, value) })
                            }}
                        >
                            {icon}
                        </a>
                    </Tooltip>
                </>
            )

        }

        if (isBanningBlock(props)) {
            return (<><BlockEdit {...props} /></>)
        }
        return (
            <>
                <BlockEdit {...props} />

                <InspectorControls><div className='dragblock-inspector-controls attributes' onKeyDown={(e) => {
                    console.log(e.key);
                }}>
                    <PanelBody
                        title={__('Attributes', 'dragblock')}
                        initialOpen={dragBlockAttrs.length > 0}
                    >
                        {/* 
                        ------------------------------------------------------------------
                        SEARCH                                        
                        Show the added properties 
                        */}
                        <AutocompleteSearchBox
                            placeholder={__('+ Add an Attribute', 'dragblock')}
                            onSelect={(slug) => {
                                let attr = cloneDeep(dragBlockAttrs)

                                attr.unshift({
                                    value: '',
                                    slug: slug,




                                });

                                setAttributes({ dragBlockAttrs: attr })
                                cltrPopover(0);

                            }}
                            suggestions={propNames}
                        />

                        {/* 
                        ------------------------------------------------------------------
                        COPY PASTE ATTRIBUTES                        
                        */}
                        {Object.keys(selectedCtrl).length > 0 && (
                            <div className='dragblock-attributes-clipboard'>
                                <a className='copy' onClick={() => {
                                    window['dragblock-attributes-clipboard'] = []

                                    for (let id in selectedCtrl) {
                                        window['dragblock-attributes-clipboard'].push(cloneDeep(dragBlockAttrs[id]));
                                    }
                                    setSelectedCtrl({});
                                }}>
                                    {iconClipboardPlus} {__('Copy', 'dragblock')}
                                </a>
                            </div>
                        )}

                        {!!window['dragblock-attributes-clipboard'] && window['dragblock-attributes-clipboard'].length > 0 && (
                            <div className='dragblock-attributes-clipboard'>
                                <a className='paste' onClick={() => {
                                    let newAttrs = cloneDeep(dragBlockAttrs);
                                    newAttrs.unshift(...window['dragblock-attributes-clipboard']);
                                    setAttributes({ dragBlockAttrs: newAttrs });
                                    setSelectedCtrl({})
                                }}>
                                    {iconClipboardCheck} {__('Paste', 'dragblock')}
                                </a>
                                <a className='clear' onClick={() => {
                                    delete window['dragblock-attributes-clipboard'];
                                    setSelectedCtrl({})
                                }}>
                                    {iconClipboardMinus} {__('Clear', 'dragblock')}
                                </a>
                            </div>
                        )}

                        {/* 
                        ------------------------------------------------------------------
                        PROPERTIES                                        
                        Show the added properties 
                        */}
                        {dragBlockAttrs && 0 !== dragBlockAttrs.length && (
                            <div className='properties'>
                                {
                                    dragBlockAttrs.map((prop, index) => {
                                        return (
                                            <div key={index}>
                                                {/* 
                                                -----------------------------------------------------------------
                                                SHOW PROPERTIES
                                                */}
                                                <Tooltip
                                                    delay={10}
                                                    text={propNames[prop.slug].note}
                                                    position='middle left'
                                                >
                                                    <a
                                                        className={
                                                            classnames('', {
                                                                'disabled': !!prop['disabled'],
                                                                'selected': !!selectedCtrl[index]
                                                            })
                                                        }
                                                        onKeyDown={(e) => {
                                                            console.log(e.key);
                                                        }}
                                                        onClick={(e) => {
                                                            if (e.ctrlKey && !e.altKey && !e.shiftKey && !e.key) {
                                                                let selected = cloneDeep(selectedCtrl);
                                                                if (selected[index]) {
                                                                    delete selected[index];
                                                                }
                                                                else {
                                                                    selected[index] = true;
                                                                }

                                                                setSelectedCtrl(selected);
                                                                return;
                                                            }
                                                            cltrPopover(index);
                                                        }}
                                                    >
                                                        {prop['devices'] ? <strong className='devices'>{prop['devices']}</strong> : null}
                                                        <code>{propNames[prop.slug].label}{
                                                            prop['locale'] ? (
                                                                <span>{prop['locale']}</span>
                                                            ) : null
                                                        }:</code>
                                                        {prop.value}
                                                    </a>
                                                </Tooltip>


                                                {/* 
                                                -----------------------------------------------------------------
                                                MODIFY PROPERTY POP OVER
                                                */}

                                                {
                                                    showControlPopover === index ? (
                                                        <PopoverProperty
                                                            className='dragblock-attributes-control-popover'
                                                            onClose={() => { cltrPopover(-1); }}
                                                            onMouseLeave={() => { cltrPopover(-1); }}
                                                            onKeyDown={(event) => {
                                                                if (event.key === 'Escape' || event.key === 'Enter') {
                                                                    cltrPopover(-1);
                                                                }
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
                                                                cltrPopover(-1);
                                                                setAttributes({ dragBlockAttrs: newList })
                                                            }}

                                                            title={propNames[prop.slug].label}
                                                            disabled={prop['disabled']}
                                                            list={dragBlockAttrs}
                                                            index={index}

                                                        >
                                                            {/* 
                                                            --------------------------------------------------------------------
                                                            POPOVER VALUE >>>>>>>>>>>>>
                                                            --------------------------------------------------------------------
                                                            */}
                                                            <div className='value'>
                                                                {/* ACTION */}
                                                                {propNames[prop.slug].type === 'action' && (
                                                                    <ChosenControl
                                                                        options={
                                                                            {
                                                                                '[dragblock.form.action]': __('DragBlock Form Action'),
                                                                            }
                                                                        }
                                                                        onChange={(value) => {
                                                                            updateDragBlockAttrs(value, index)
                                                                        }}
                                                                        value={prop.value}
                                                                        placeholder={__('Input Action Type', 'dragblock')}
                                                                    />
                                                                )}
                                                                {/* UNIT */}
                                                                {propNames[prop.slug].type === 'unit' && (
                                                                    <DimensionControl
                                                                        value={prop.value}
                                                                        units={
                                                                            propNames[prop.slug]['units'] ? propNames[prop.slug]['units'] : null
                                                                        }
                                                                        onChange={(value) => {
                                                                            updateDragBlockAttrs(value, index)
                                                                        }}
                                                                    />

                                                                )}
                                                                {/* MULTILINGUAL TEXT */}
                                                                {propNames[prop.slug].type === 'multilingual-text' && (
                                                                    <MultillingualTextControl
                                                                        onChange={(value, locale) => {
                                                                            updateDragBlockAttrs(value, index, locale)
                                                                        }}
                                                                        value={prop['value']}
                                                                        locale={prop['locale']}
                                                                    />
                                                                )}
                                                                {/* TEXT */}
                                                                {propNames[prop.slug].type === 'text' && (
                                                                    <ChosenControl
                                                                        options={Object.fromEntries(Object.entries(dragBlockQueryShortcodes).map(([key, value]) => [key, value['label']]))}
                                                                        onChange={(value) => {
                                                                            updateDragBlockAttrs(value, index)
                                                                        }}
                                                                        value={prop.value}
                                                                        placeholder={__('Type [ for shortcodes', 'dragblock')}
                                                                    />
                                                                )}

                                                                {/* Number */}
                                                                {propNames[prop.slug].type === 'number' && (
                                                                    <NumberControl
                                                                        value={(prop.value ? Number(prop.value) : '')}
                                                                        min={-99}
                                                                        max={9999}
                                                                        step={1}
                                                                        onChange={(value) => { updateDragBlockAttrs(value, index) }}
                                                                    />
                                                                )}

                                                                {/* Select */}
                                                                {propNames[prop.slug].type === 'select' && (
                                                                    <SelectControl
                                                                        value={prop.value}
                                                                        options={propNames[prop.slug].options ? propNames[prop.slug].options : []}
                                                                        onChange={(value) => { updateDragBlockAttrs(value, index) }}
                                                                    />
                                                                )}

                                                            </div>

                                                            {/* 
                                                            --------------------------------------------------------------------
                                                            >>>>>>>>>>>> POPOVER ADVANCED
                                                            --------------------------------------------------------------------
                                                            */}
                                                            {/* DEVICES */}
                                                            {
                                                                prop.slug === 'sizes' && (
                                                                    <Flex className='extra devices'>
                                                                        <FlexItem className='label'>{__('Devices', 'dragblock')}</FlexItem>
                                                                        <FlexItem className='control'>
                                                                            {deviceControl(
                                                                                __('Desktop (d)', 'dragblock'),
                                                                                iconDesktop,
                                                                                'd',
                                                                                index,
                                                                                prop
                                                                            )}
                                                                            {deviceControl(
                                                                                __('Tablet (t)', 'dragblock'),
                                                                                iconTablet,
                                                                                't',
                                                                                index,
                                                                                prop
                                                                            )}
                                                                            {deviceControl(
                                                                                __('Mobile (m)', 'dragblock'),
                                                                                iconMobile,
                                                                                'm',
                                                                                index,
                                                                                prop
                                                                            )}
                                                                        </FlexItem>
                                                                    </Flex>
                                                                )
                                                            }


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

                </div></InspectorControls >

            </>
        );
    };
}, 'dragBlockAttributesControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/attributes-controls',
    dragBlockAttributesControls
);


var dragBlockClientPrevId = '';
var dragBlockClientIds = {};


var dragBlockAttrInit = false;

const dragBlockAttributesControlsUniqueID = createHigherOrderComponent((BlockListBlock) => {

    return (props) => {


        const { attributes, setAttributes, clientId, isSelected, name } = props;
        let { dragBlockClientId, dragBlockAttrs, dragBlockStyles, className, anchor } = attributes;



        let dragBlockClientIdCollision = false;
        if (dragBlockClientId) {
            if (!dragBlockClientIds[dragBlockClientId]) {
                dragBlockClientIds[dragBlockClientId] = true;
            } else {

                dragBlockClientIdCollision = true;
            }
        }


        useEffect(() => {
            if (!dragBlockClientId || dragBlockClientIdCollision) {
                setAttributes({ dragBlockClientId: clientId });
            }


            dragBlockClientIds = {};


            if (!isSelected) {
                return;
            }















            /**
             * Init: We should collect all classes and ids from all blocks (only when site load, when the list is empty)
             * Init: We should collect all selectored inputing by users (only when site loaded, when the list is empty)
             * Update: we should collect all heirarchied from parent blocks (only when selected)             
             * 
             * Only init when selected because this is when we actually need to take action
             */
            /**
             * Collect all inherited classes/ids from child blocks
             * @param {*} $blocks 
             * @param {*} $parentSelectors 
             */
            function getChildBlockSelectors($blocks, $parentSelectors = []) {
                for (const { clientId, attributes } of $blocks) {

                    const childSelectors = new Set();
                    if (attributes['className']) {
                        attributes['className'].split(' ').map(e => {
                            childSelectors.add('.' + e);
                            window['dragBlockSelectors'].classes.add('.' + e);
                        });
                    }


                    if (attributes['anchor']) {
                        attributes['anchor'].split(' ').map(e => {
                            childSelectors.add('#' + e);
                            window['dragBlockSelectors'].ids.add('#' + e);
                        });
                    }

                    const selectors = Array.from(childSelectors);
                    for (let parSel of $parentSelectors) {
                        for (let childSel of childSelectors) {
                            selectors.push(parSel + ' ' + childSel);
                        }
                    }

                    selectors.map(e => {
                        window['dragBlockSelectors'].selectors.add(e);
                    })


                    let children = wp.data.select('core/block-editor').getBlock(clientId);
                    if (children !== null) {
                        const { innerBlocks } = children;
                        if (innerBlocks.length) {
                            getChildBlockSelectors(innerBlocks, selectors)
                        }
                    }

                }
            }

            if (isEmpty(window['dragBlockSelectors'])) {
                window['dragBlockSelectors'] = {
                    classes: new Set(),
                    ids: new Set(),
                };
            }


            window['dragBlockSelectors']['selectors'] = new Set();

            if (className) {
                className.split(' ').map(e => {
                    window['dragBlockSelectors'].classes.add('.' + e);
                    window['dragBlockSelectors'].selectors.add('.' + e);
                });
            }


            if (anchor) {
                anchor.split(' ').map(e => {
                    window['dragBlockSelectors'].ids.add('#' + e);
                    window['dragBlockSelectors'].selectors.add('#' + e);
                });
            }

            let children = wp.data.select('core/block-editor').getBlock(clientId);
            if (children !== null) {
                const { innerBlocks } = children;
                if (innerBlocks.length) {
                    getChildBlockSelectors(innerBlocks);
                }
            }


            if (dragBlockStyles && dragBlockStyles.length) {
                for (let style of dragBlockStyles) {
                    if (style['selectors']) {
                        window['dragBlockSelectors'].selectors.add(style['selectors']);
                    }
                }
            }



            if (wpSystemNativeClasses[props.name]) {

                wpSystemNativeClasses[props.name].map(e => {

                    window['dragBlockSelectors'].selectors.add(e)
                    window['dragBlockSelectors'].classes.add(e);
                })
            }

        });


        let wrapperProps = {
            ...props.wrapperProps,
            'data-dragblock-client-id': dragBlockClientId,
            onSubmit: (e) => {
                if (name === 'dragblock/form') {
                    e.preventDefault(); // Prevent form submission
                }
            }
        };




        if ((!dragBlockAttrInit || isSelected) && dragBlockAttrs && dragBlockAttrs.length) {
            dragBlockAttrInit = true;

            for (let attr of dragBlockAttrs) {
                if (isEmpty(attr['value']) || !isEmpty(attr['disabled'])) {
                    continue;
                }
                let value = '';


                if (attr['slug'] === 'href') {
                    value = '#dragBlock-attribute-placeholder';
                }
                else if (attr['slug'] === 'target') {
                    value = '';
                }
                else if (propNames[attr['slug']].type === 'multilingual-text') {
                    if (attr['locale'] === dragBlockEditorInit.siteLocale) {
                        value = attr['value'];
                    }
                }
                else {
                    value = attr['value'];
                }


                if (!value) {
                    continue;
                }
                wrapperProps[attr['slug']] = value;
            }
        }


        if (dragBlockAttrs && dragBlockAttrs.length) {
            for (let attr of dragBlockAttrs) {
                if (isEmpty(attr['value']) ||
                    !isEmpty(attr['disabled']) ||
                    isEmpty(attr['slug']) ||
                    (attr['slug'] !== 'type' && propNames[attr['slug']].type !== 'multilingual-text')) {
                    continue;
                }

                if (isEmpty(wrapperProps[attr['slug']]) || attr['locale'] === dragBlockEditorInit.siteLocale) {
                    wrapperProps[attr['slug']] = attr['value'];
                }
            }
        }



        if (anchor) {
            wrapperProps['className'] = 'dragblock-id-classname-placeholder--' + anchor;
        }



        return (
            <>
                <BlockListBlock {...props} wrapperProps={wrapperProps} />
            </>
        );
    };
}, 'dragBlockAttributesControlsUniqueID');

wp.hooks.addFilter(
    'editor.BlockListBlock',
    'dragblock/attributes-controls-unique-id',
    dragBlockAttributesControlsUniqueID
);