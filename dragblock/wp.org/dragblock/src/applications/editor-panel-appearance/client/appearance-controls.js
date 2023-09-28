import classnames from 'classnames';
import { __ } from '@wordpress/i18n';
import { cloneDeep, isString } from 'lodash';
import { createHigherOrderComponent } from '@wordpress/compose'
import { useEffect, useRef, useState } from '@wordpress/element'
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
    __experimentalNumberControl as NumberControl,
    Icon
} from '@wordpress/components'

import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';

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
    appearanceProperties as propNames,
    initDragBlockStyles
} from './appearance-settings'
import {
    dragBlockAppearanceStyle
} from './appearance-style';
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
import HeightControl from '../../../library/client/components/height-control';
import ChosenControl from '../../../library/client/components/chosen-control';
import { select } from '@wordpress/data'
import { isBanningBlock } from '../../../library/client/ultils/banning';
import ImageControl from '../../../library/client/components/image-control';
import { SelectControl } from '@wordpress/components';
import { getSelectors } from '../../../library/client/ultils/selector';
import AnimationNameControl from '../../../library/client/components/animation-control';
import { iconAlignCenterBoxO, iconBox, iconCircle, iconCrop, iconMinusCircle, iconPageBreak, iconPlus, iconTablet, iconUngroup } from '../../../library/client/icons/icons';
import { iconDesktop } from '../../../library/client/icons/icons';
import { iconMobile } from '../../../library/client/icons/icons';


/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 */
const dragBlockApperanceControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, isSelected, clientId, isMultiSelected } = props;



        let { dragBlockStyles, className } = attributes;
        const [showControlPopover, setShowControlPopover] = useState(-1);
        const [editSelector, setEditSelector] = useState(false);
        const [groupIndex, setGroupIndex] = useState(-1);
        const [shownHiddenStyles, setShownHiddenStyles] = useState(false)
        const avaiColors = useSetting('color.palette.theme').concat(useSetting('color.palette.custom') || [])/*.concat(useSetting('color.palette.default'));;*/
        const contentSize = useSetting('layout.contentSize');
        const wideSize = useSetting('layout.wideSize');

        if (!dragBlockStyles) {
            dragBlockStyles = initDragBlockStyles(props.name);
        }



        const openControlPopover = (index) => {
            setGroupIndex(-1);
            setShowControlPopover(index);
        }
        const closeControlPopover = () => {
            setShowControlPopover(-1);
            setEditSelector(false);
        }



        const clipBoardSlug = 'dragblockStyleClipboard';

        const isIndexInClipboard = (index) => {
            return (
                window[clipBoardSlug] &&
                window[clipBoardSlug]['id'] === clientId &&
                index >= window[clipBoardSlug]['index'] &&
                index < window[clipBoardSlug]['lastIndex']
            )
        }
        const isIndexInClipboardCutAction = (index) => {
            return (
                window[clipBoardSlug] &&
                window[clipBoardSlug]['id'] === clientId &&
                index >= window[clipBoardSlug]['index'] &&
                index < window[clipBoardSlug]['lastIndex'] &&
                window[clipBoardSlug]['action'] &&
                window[clipBoardSlug]['action'] == 'cut'
            )
        }
        const isOwnClipboard = () => {
            return (
                window[clipBoardSlug] &&
                window[clipBoardSlug]['id'] === clientId
            )
        }
        const deleteClipboard = () => {
            delete window[clipBoardSlug];
        }
































        const showColorPreview = (value) => {
            if (!isString(value)) {
                return value;
            }
            if (value.indexOf('#') === -1) return value
            value = value.split('#');
            return (
                <>
                    <span>{value[0]}  </span>
                    <span className='color'
                        style={{
                            backgroundColor: '#' + value[1]
                        }}
                    ></span>#{value[1]}


                </>
            )
        }

        const updateDragBlockStyles = (value, index, color = false, size = false) => {
            if (typeof (value) === 'undefined') {
                return;
            }
            if (color) {
                value = dragBlockMatchingColors({ value: value.trim(), colors: avaiColors });
            }
            if (size) {
                value = dragBlockMatchingSizes({ value, contentSize, wideSize });
            }


            let style = cloneDeep(dragBlockStyles)
            style[index].value = value;

            setAttributes({ dragBlockStyles: style })
        }

        const updateDevices = (styleList, index, device) => {
            let style = cloneDeep(styleList)
            if (!style[index]['devices']) style[index]['devices'] = '';
            if (style[index]['devices'].indexOf(device) === -1) style[index]['devices'] += device;
            else style[index]['devices'] = style[index]['devices'].replace(device, '')
            if (style[index]['devices'] === '') delete style[index]['devices']

            return style;
        }

        const updateMasterSelector = (styleList, index, device = nulls, selectors = null) => {
            let style = cloneDeep(styleList)
            let prop = style[index];

            let i = index + 1;
            for (; i < style.length; i++) {
                let s = style[i];
                if (s['devices'] !== prop['devices'] || s['selectors'] !== prop['selectors']) {
                    break;
                }
            }
            for (let j = index; j < i; j++) {
                if (device !== null) {
                    style = updateDevices(style, j, device);
                }
                if (selectors !== null) {
                    style[j]['selectors'] = selectors;
                }
            }
            return style;
        }


        const styleGroupLastIndex = (list, index) => {
            let lastIndex = index + 1;

            for (; lastIndex < list.length; lastIndex++) {
                if (list[lastIndex]['selectors'] !== list[index]['selectors'] ||
                    list[lastIndex]['devices'] !== list[index]['devices']
                ) {
                    break;
                }
            }

            return lastIndex;
        }
        const styleGroupStartIndex = (list, lastIndex) => {
            let startIndex = lastIndex - 1;

            for (; startIndex > -1; startIndex--) {
                if (list[lastIndex]['selectors'] !== list[startIndex]['selectors'] ||
                    list[lastIndex]['devices'] !== list[startIndex]['devices']) {
                    break;
                }
            }

            return startIndex + 1;
        }








        let supportedStates = {
            ':hover': __('(h) Mouse Hover', 'dragblock'),
            ':focus': __('(f) Tab Focus', 'dragblock'),
            ':checked': __('(c) Checked Input', 'dragblock'),
            ':target': __('(t) Targeted Element', 'dragblock'),
            ':active': __('(a) Activated Element', 'dragblock'),

        }


        let masterSelector = {
            'devices': '',
            'selectors': '',
            'shown': false
        };


        let hasHiddenStyles = false;
        for (let style of dragBlockStyles) {
            if (style['hidden']) {
                hasHiddenStyles = true;
                break;
            }
        }



        if (isBanningBlock(props)) {
            return (<><BlockEdit {...props} /></>)
        }
        return (
            <>
                <BlockEdit {...props} />


                {/* 
                -----------------------------------------------------------------
                CUSTOM STYLE
                -----------------------------------------------------------------
                */}
                <InspectorControls><div className='dragblock-inspector-controls appearance'>
                    <PanelBody
                        title={__('Appearance', 'dragblock')}
                        initialOpen={dragBlockStyles.length > 0}
                    >
                        {/* 
                                ------------------------------------------------------------------
                                SEARCH                                        
                                Show the added properties 
                                */}



                        <AutocompleteSearchBox
                            placeholder={__('+ Add a Property', 'dragblock')}
                            onSelect={(slug) => {
                                deleteClipboard();
                                let style = cloneDeep(dragBlockStyles)

                                if (groupIndex !== -1) {
                                    let item = {
                                        value: '',
                                        slug: slug,
                                    }
                                    if (style[groupIndex]['selectors']) {
                                        item['selectors'] = style[groupIndex]['selectors']
                                    }
                                    if (style[groupIndex]['devices']) {
                                        item['devices'] = style[groupIndex]['devices']
                                    }
                                    style.splice(groupIndex, 0, cloneDeep(item))
                                } else {
                                    style.unshift({
                                        value: '',
                                        slug: slug,



                                    });
                                }

                                setAttributes({ dragBlockStyles: style })
                                openControlPopover(groupIndex !== -1 ? groupIndex : 0);
                            }}

                            suggestions={propNames}
                        />
                        {/* 
                                ------------------------------------------------------------------
                                GLOBAL TOOLS           
                                ------------------------------------------------------------------                                
                                Show the added properties 
                                We don't organize the properties into selectors because that is not
                                the way our brain thinking and that is also not flexible as leaving
                                the properties standing alone.
                                */}
                        {(!!window[clipBoardSlug]) && window[clipBoardSlug]['id'] !== clientId && (
                            <>
                                <Tooltip
                                    delay={10}
                                    text={__('Paste Style from Clipboard', 'dragblock')}
                                    position='top center'

                                >
                                    <a
                                        className={classnames('global-action paste')}
                                        onClick={() => {
                                            let clipboard = window[clipBoardSlug]
                                            let newStyle = cloneDeep(dragBlockStyles);


                                            for (let attr of clipboard['attrs']) {
                                                newStyle.unshift(attr);
                                            }
                                            setAttributes({ dragBlockStyles: newStyle });



                                            if (clipboard['action'] === 'cut') {
                                                let holderAttrs = wp.data.select('core/block-editor').getBlockAttributes(clipboard['id']);
                                                if (holderAttrs && holderAttrs['dragBlockStyles']) {
                                                    holderAttrs = cloneDeep(holderAttrs)

                                                    let style = holderAttrs['dragBlockStyles'];
                                                    let attrs = clipboard['attrs'];
                                                    let match = true;
                                                    let j = 0;
                                                    for (let i = clipboard['index']; i < style.length && i < clipboard['lastIndex']; i++, j++) {
                                                        for (let p in attrs[j]) {
                                                            if (style[i][p] !== attrs[j][p]) {
                                                                match = false;
                                                                break;
                                                            }
                                                        }
                                                    }

                                                    if (match) {

                                                        style.splice(clipboard['index'], clipboard['lastIndex'] - clipboard['index']);
                                                        holderAttrs['dragBlockStyles'] = style;


                                                        wp.data.dispatch('core/block-editor').updateBlockAttributes(clipboard['id'], holderAttrs);
                                                    }
                                                }
                                            }


                                            deleteClipboard()


                                        }}>
                                        {iconBox} {__('Paste Styles', 'dragblock')}
                                    </a>
                                </Tooltip>
                            </>
                        )}

                        {hasHiddenStyles && (
                            <>
                                <a className='global-action hidden-styles-toggle' onClick={() => {
                                    setShownHiddenStyles(!shownHiddenStyles);
                                }}>
                                    {shownHiddenStyles && (<>{iconMinusCircle} {__('Hide Hidden', 'dragblock')}</>)}
                                    {!shownHiddenStyles && (<>{iconCircle} {__('Show Hidden', 'dragblock')}</>)}
                                </a>
                            </>
                        )}

                        {/* 
                                ------------------------------------------------------------------
                                PROPERTIES           
                                ------------------------------------------------------------------                                
                                Show the added properties 
                                We don't organize the properties into selectors because that is not
                                the way our brain thinking and that is also not flexible as leaving
                                the properties standing alone.
                                */}
                        {dragBlockStyles && 0 !== dragBlockStyles.length && (
                            <div className='properties'>
                                {
                                    dragBlockStyles.map((prop, index) => {
                                        /*
                                        everytime we see a change in devices and selectors compared to the previous prop,
                                        we update the master selectors and decide if it has something to show
                                        */
                                        let showMasterSelector = false
                                        let devices = prop['devices'] ? prop['devices'] : '';
                                        let selectors = prop['selectors'] ? prop['selectors'] : '';

                                        if (masterSelector['devices'] !== devices ||
                                            masterSelector['selectors'] !== selectors
                                        ) {                                            
                                            masterSelector['devices'] = devices;
                                            masterSelector['selectors'] = selectors;


                                            showMasterSelector = true && (!prop['hidden'] || shownHiddenStyles);

                                            if (!showMasterSelector) {
                                                masterSelector['shown'] = false;
                                            }
                                        }

                                        else if (masterSelector['shown'] === false) {
                                            showMasterSelector = true && (!prop['hidden'] || shownHiddenStyles);
                                        }


                                        if (showMasterSelector) {
                                            masterSelector['shown'] = true;
                                        }


                                        
                                        /*
                                        For showing states
                                        */
                                        let showStates = true;
                                        let stateSelectors = new Object(); // {:hover = set('raw sel1', 'raw sel2'), ...}
                                        let stateSelectorSet = '';

                                        if (prop['selectors']) {
                                            let selectors = prop['selectors'].split(',').map(e => e.trim());
                                            for (let selector of selectors) {

                                                if (selector.indexOf(':') !== -1) {
                                                    selector = selector.split(':');



                                                    if (!supportedStates[':' + selector[1]]) {
                                                        showStates = false;
                                                        break;
                                                    }



                                                    if (stateSelectors['']) {
                                                        showStates = false;
                                                        break;
                                                    }


                                                    if (!stateSelectors[':' + selector[1]]) {
                                                        stateSelectors[':' + selector[1]] = new Set();
                                                    }
                                                    stateSelectors[':' + selector[1]].add(selector[0]);
                                                    continue;
                                                }




                                                if (!stateSelectors['']) {
                                                    stateSelectors[''] = new Set();
                                                }
                                                stateSelectors[''].add(selector);
                                            }


                                            if (showStates) {




                                                for (let state in stateSelectors) {

                                                    let orderedSelectors = [...stateSelectors[state]].sort((a, b) => a > b).join(',');



                                                    if (!stateSelectorSet) {
                                                        stateSelectorSet = orderedSelectors;
                                                        continue;
                                                    }


                                                    if (stateSelectorSet !== orderedSelectors) {
                                                        showStates = false;
                                                        break;
                                                    }
                                                }
                                                if (stateSelectors['']) {
                                                    delete stateSelectors[''];
                                                }

                                            }
                                        }

                                        return (
                                            <div key={index} className={classnames('property-wrapper', {
                                            })}>
                                                {(showMasterSelector) ? (
                                                    <>
                                                        <div className='master-selector'>
                                                            <Tooltip
                                                                delay={10}
                                                                text={__('Edit selector', 'dragblock')}
                                                                position='middle left'
                                                            >
                                                                <a
                                                                    className='master-selector-name'
                                                                    onClick={function () {
                                                                        setEditSelector(true);
                                                                        openControlPopover(index);
                                                                        if (isIndexInClipboard(index)) {
                                                                            deleteClipboard();
                                                                        }
                                                                    }}>
                                                                    {prop['devices'] ? (<span className='devices'>{prop['devices']}</span>) : null}
                                                                    {prop['selectors'] ? <span className='selectors'>{
                                                                        prop['selectors'].indexOf('&') === 0 ? (
                                                                            <>
                                                                                <strong>&</strong>
                                                                                {prop['selectors'].substring(1)}
                                                                            </>
                                                                        ) : (
                                                                            prop['selectors']
                                                                        )
                                                                    }</span> : null}
                                                                </a>
                                                            </Tooltip>

                                                            <Tooltip
                                                                delay={10}
                                                                text={__('Add a property', 'dragblock')}
                                                                position='top center'
                                                            >
                                                                <a
                                                                    className='master-selector-add'
                                                                    onClick={function () {
                                                                        setGroupIndex(index);
                                                                        document.querySelector('.dragblock-inspector-controls.appearance .fake-search-button').click();
                                                                    }}>
                                                                    +
                                                                </a>
                                                            </Tooltip>
                                                        </div>
                                                    </>
                                                ) : ''}

                                                {(!prop['hidden'] || shownHiddenStyles) && (
                                                    <Tooltip
                                                        delay={10}
                                                        text={propNames[prop.slug].note}
                                                        position='middle left'
                                                    >
                                                        <a
                                                            className={
                                                                classnames('property', {
                                                                    'disabled': !!prop['disabled'],
                                                                    'has-selector': (prop['devices'] || prop['selectors']),
                                                                    'default': !prop.value,
                                                                    'inClipboardCut': isIndexInClipboardCutAction(index)
                                                                })
                                                            }
                                                            onClick={() => {
                                                                if (isIndexInClipboard(index)) {
                                                                    deleteClipboard();
                                                                }
                                                                setEditSelector(false);
                                                                openControlPopover(index);
                                                            }}
                                                        >
                                                            <code>
                                                                {propNames[prop.slug].label}
                                                                {prop['hidden'] ? (<strong> ⛔</strong>) : ':'}
                                                            </code>
                                                            {prop.value ?
                                                                (
                                                                    <span
                                                                        className={'value-preview ' + propNames[prop.slug].type}
                                                                    >
                                                                        {showColorPreview(
                                                                            dragBlockUnmatchingSizes({
                                                                                value: dragBlockUnmatchingColors({
                                                                                    value: prop.value, colors: avaiColors
                                                                                }),
                                                                                contentSize,
                                                                                wideSize
                                                                            })
                                                                        )}
                                                                    </span>
                                                                )
                                                                :
                                                                (
                                                                    <span>default</span>
                                                                )
                                                            }
                                                        </a>
                                                    </Tooltip>

                                                )}
                                                {/* 
                                                            -----------------------------------------------------------------
                                                            MODIFY PROPERTY POP OVER
                                                             */}

                                                {
                                                    showControlPopover === index ? (
                                                        <PopoverProperty
                                                            className='dragblock-appearance-control-popover'
                                                            onClose={closeControlPopover}
                                                            onMouseLeave={() => {
                                                                closeControlPopover();
                                                            }}
                                                            onKeyDown={(event) => {
                                                                if (event.key === 'Escape') {
                                                                    closeControlPopover()
                                                                }
                                                            }}
                                                            actions={
                                                                editSelector ? {
                                                                    top: function (newList, index) {
                                                                        if (index === 0) {
                                                                            return newList;
                                                                        }
                                                                        let lastIndex = styleGroupLastIndex(newList, index)

                                                                        let group = newList.splice(index, lastIndex - index);

                                                                        newList.unshift(...group);

                                                                        return newList;
                                                                    },
                                                                    bottom: function (newList, index) {
                                                                        let lastIndex = styleGroupLastIndex(newList, index)
                                                                        if (lastIndex >= newList.length - 1) {
                                                                            return newList;
                                                                        }
                                                                        let group = newList.splice(index, lastIndex - index);
                                                                        newList.push(...group);
                                                                        return newList;
                                                                    },
                                                                    up: function (newList, index) {
                                                                        if (index === 0) {
                                                                            return newList;
                                                                        }
                                                                        let lastIndex = styleGroupLastIndex(newList, index)
                                                                        let group = newList.splice(index, lastIndex - index);

                                                                        let startIndexPrevGroup = styleGroupStartIndex(newList, index - 1);
                                                                        newList.splice(startIndexPrevGroup, 0, ...group);
                                                                        return newList;
                                                                    },
                                                                    down: function (newList, index) {
                                                                        let lastIndex = styleGroupLastIndex(newList, index)
                                                                        if (lastIndex >= newList.length - 1) {
                                                                            return newList;
                                                                        }
                                                                        let group = newList.splice(index, lastIndex - index);
                                                                        let lastIndexPrevGroup = styleGroupLastIndex(newList, index + 1);
                                                                        newList.splice(lastIndexPrevGroup, 0, ...group);
                                                                        return newList;
                                                                    },

                                                                    duplicate: false,

                                                                    disable: function (newList, index) {
                                                                        let lastIndex = styleGroupLastIndex(newList, index)
                                                                        let disabledAll = true;
                                                                        for (let i = index; i < lastIndex; i++) {
                                                                            if (!newList[i]['disabled']) {
                                                                                disabledAll = false;
                                                                                break;
                                                                            }
                                                                        }

                                                                        if (disabledAll) {


                                                                            for (let i = index; i < lastIndex; i++) {
                                                                                delete newList[i]['disabled']
                                                                            }
                                                                        } else {


                                                                            for (let i = index; i < lastIndex; i++) {
                                                                                newList[i]['disabled'] = '*';
                                                                            }
                                                                        }

                                                                        return newList;
                                                                    },



                                                                    hidden: false,
                                                                    delete: false,

                                                                    custom: {

                                                                        cut: (
                                                                            <Tooltip
                                                                                delay={10}
                                                                                text={__('Cut', 'dragblock')}
                                                                                position='top center'

                                                                            >
                                                                                <a className='action cut' onClick={() => {
                                                                                    let lastIndex = styleGroupLastIndex(dragBlockStyles, index)
                                                                                    let attrs = [];
                                                                                    for (let i = index; i < lastIndex; i++) {
                                                                                        attrs.push(cloneDeep(dragBlockStyles[i]));
                                                                                    }
                                                                                    window[clipBoardSlug] = {
                                                                                        action: 'cut',
                                                                                        id: clientId,
                                                                                        index: index,
                                                                                        lastIndex: lastIndex,
                                                                                        attrs: attrs
                                                                                    };
                                                                                    closeControlPopover();
                                                                                }}>
                                                                                    {iconPageBreak}
                                                                                </a>
                                                                            </Tooltip>
                                                                        ),
                                                                        copy: (
                                                                            <Tooltip
                                                                                delay={10}
                                                                                text={__('Copy', 'dragblock')}
                                                                                position='top center'

                                                                            >
                                                                                <a className='action copy' onClick={() => {
                                                                                    let lastIndex = styleGroupLastIndex(dragBlockStyles, index)
                                                                                    let attrs = [];
                                                                                    for (let i = index; i < lastIndex; i++) {
                                                                                        attrs.push(cloneDeep(dragBlockStyles[i]));
                                                                                    }
                                                                                    window[clipBoardSlug] = {
                                                                                        action: 'copy',
                                                                                        id: clientId,
                                                                                        index: index,
                                                                                        lastIndex: lastIndex,
                                                                                        attrs: attrs
                                                                                    };
                                                                                    closeControlPopover();
                                                                                }}>
                                                                                    {iconUngroup}
                                                                                </a>
                                                                            </Tooltip>
                                                                        )
                                                                    }
                                                                } : null
                                                            }
                                                            onAction={(action, newList) => {


                                                                if ('disable' === action && !editSelector) {
                                                                    if (newList[index]['disabled']) {
                                                                        delete newList[index]['disabled'];
                                                                    } else {
                                                                        newList[index]['disabled'] = '*';
                                                                    }
                                                                }
                                                                if ('hidden' === action && !editSelector) {
                                                                    if (newList[index]['hidden']) {
                                                                        delete newList[index]['hidden'];
                                                                    } else {
                                                                        newList[index]['hidden'] = '*';
                                                                    }
                                                                }
                                                                if (isIndexInClipboard(index)) {
                                                                    deleteClipboard();
                                                                } else if (isOwnClipboard()) {
                                                                    if ('top' === action && index >= window[clipBoardSlug]['index'] ||
                                                                        'bottom' === action && index < window[clipBoardSlug]['lastIndex'] ||
                                                                        'up' === action && index === window[clipBoardSlug]['lastIndex'] ||
                                                                        'down' === action && index === window[clipBoardSlug]['index'] - 1 ||
                                                                        'delete' === action && index < window[clipBoardSlug]['lastIndex'] ||
                                                                        'duplicate' === action
                                                                    ) {
                                                                        deleteClipboard();
                                                                    }
                                                                }

                                                                closeControlPopover()
                                                                setAttributes({ dragBlockStyles: newList })
                                                            }}

                                                            title={editSelector ? __('Edit Selectors', 'dragblock') : propNames[prop.slug].label}
                                                            disabled={prop['disabled']}
                                                            hidden={prop['hidden']}
                                                            list={dragBlockStyles}
                                                            index={index}
                                                        >
                                                            {/* 
                                                                    --------------------------------------------------------------------
                                                                    POPOVER VALUE >>>>>>>>>>>>>
                                                                    --------------------------------------------------------------------
                                                                    */}

                                                            {(!editSelector) && (
                                                                <div className='value'>
                                                                    {/* COLOR */}
                                                                    {propNames[prop.slug].type === 'color' && (
                                                                        <ColorPalette
                                                                            enableAlpha={true}
                                                                            colors={avaiColors}
                                                                            value={dragBlockUnmatchingColors({ value: prop.value, colors: avaiColors })}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, true) }}
                                                                        >
                                                                        </ColorPalette>
                                                                    )}

                                                                    {/* UNIT */}
                                                                    {propNames[prop.slug].type === 'unit' && (
                                                                        <DimensionControl
                                                                            value={prop.value}
                                                                            units={
                                                                                propNames[prop.slug]['units'] ? propNames[prop.slug]['units'] : null
                                                                            }
                                                                            onChange={(value) => { updateDragBlockStyles(value, index) }}
                                                                        />

                                                                    )}
                                                                    {/* SELECT */}
                                                                    {propNames[prop.slug].type === 'select' && (
                                                                        <SelectControl
                                                                            value={prop.value}
                                                                            options={propNames[prop.slug].options}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index) }}
                                                                        />

                                                                    )}
                                                                    {/* TEXT */}
                                                                    {propNames[prop.slug].type === 'text' && (
                                                                        <TextControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }}
                                                                        />
                                                                    )}
                                                                    {/* Margin */}
                                                                    {(propNames[prop.slug].type === 'margin') && (
                                                                        <MarginControl
                                                                            value={prop.value}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index) }}
                                                                            switcher={prop.slug === 'margin' || prop.slug === 'padding'}
                                                                            minus={prop.slug.indexOf('padding') === -1}
                                                                        />

                                                                    )}
                                                                    {/* Number */}
                                                                    {propNames[prop.slug].type === 'number' && (
                                                                        <NumberControl
                                                                            value={(prop.value ? Number(prop.value) : '')}
                                                                            min={propNames[prop.slug].min ? propNames[prop.slug].min : -99}
                                                                            max={propNames[prop.slug].max ? propNames[prop.slug].max : 9999}
                                                                            step={propNames[prop.slug].step ? propNames[prop.slug].step : 1}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index) }}
                                                                        />
                                                                    )}

                                                                    {/* FONT SIZE */}
                                                                    {propNames[prop.slug].type === 'font-size' && (
                                                                        <FontSizeControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* FONT WEIGHT */}
                                                                    {propNames[prop.slug].type === 'font-weight' && (
                                                                        <FontWeightControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* LINE HEIGHT */}
                                                                    {propNames[prop.slug].type === 'line-height' && (
                                                                        <LineHeightControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* TEXT DECORATION LINE */}
                                                                    {propNames[prop.slug].type === 'text-decoration-line' && (
                                                                        <TextDecorationLineControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* TEXT DECORATION STYLE */}
                                                                    {propNames[prop.slug].type === 'text-decoration-style' && (
                                                                        <TextDecorationStyleControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* TEXT TRANSFORM */}
                                                                    {propNames[prop.slug].type === 'text-transform' && (
                                                                        <TextTransformControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* TEXT ALIGN */}
                                                                    {propNames[prop.slug].type === 'text-align' && (
                                                                        <TextAlignControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}

                                                                    {/* TEXT DECORATION */}
                                                                    {propNames[prop.slug].type === 'text-decoration' && (
                                                                        <TextDecorationControl
                                                                            value={dragBlockUnmatchingColors({ value: prop.value, colors: avaiColors })}
                                                                            colors={avaiColors}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, true) }}
                                                                        />
                                                                    )}
                                                                    {/* BORDER STYLE */}
                                                                    {propNames[prop.slug].type === 'border-style' && (
                                                                        <BorderStyleControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* BORDER */}
                                                                    {propNames[prop.slug].type === 'border' && (
                                                                        <BorderControl
                                                                            value={dragBlockUnmatchingColors({ value: prop.value, colors: avaiColors })}
                                                                            colors={avaiColors}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, true) }}
                                                                        />
                                                                    )}
                                                                    {/* TEXT SHADOW */}
                                                                    {propNames[prop.slug].type === 'text-shadow' && (
                                                                        <TextShadowControl
                                                                            value={dragBlockUnmatchingColors({ value: prop.value, colors: avaiColors })}
                                                                            colors={avaiColors}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, true) }}
                                                                        />
                                                                    )}
                                                                    {/* BOX SHADOW */}
                                                                    {propNames[prop.slug].type === 'box-shadow' && (
                                                                        <BoxShadowControl
                                                                            value={dragBlockUnmatchingColors({ value: prop.value, colors: avaiColors })}
                                                                            colors={avaiColors}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, true) }}
                                                                        />
                                                                    )}
                                                                    {/* POSITION */}
                                                                    {propNames[prop.slug].type === 'position' && (
                                                                        <PositionControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* POSITION */}
                                                                    {propNames[prop.slug].type === 'display' && (
                                                                        <DisplayControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* TRANSLATE */}
                                                                    {propNames[prop.slug].type === 'translate' && (
                                                                        <TranslateControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* TRANSFORM */}
                                                                    {propNames[prop.slug].type === 'transform' && (
                                                                        <TransformControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* ALIGN ITEMS */}
                                                                    {propNames[prop.slug].type === 'align-items' && (
                                                                        <AlignItemsControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* JUSTIFY CONTENT */}
                                                                    {propNames[prop.slug].type === 'justify-content' && (
                                                                        <JustifyContentControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* FLEX WRAP */}
                                                                    {propNames[prop.slug].type === 'flex-wrap' && (
                                                                        <FlexWrapControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* FLEX DIRECTION */}
                                                                    {propNames[prop.slug].type === 'flex-direction' && (
                                                                        <FlexDirectionControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}
                                                                    {/* WIDTH & FLEX BASIC*/}
                                                                    {(propNames[prop.slug].type === 'width' || propNames[prop.slug].type === 'flex-basis') && (
                                                                        <WidthControl
                                                                            value={dragBlockUnmatchingSizes({ value: prop.value, contentSize, wideSize })}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, false, true) }}
                                                                        />
                                                                    )}
                                                                    {/* HEIGHT */}
                                                                    {(propNames[prop.slug].type === 'height') && (
                                                                        <HeightControl
                                                                            value={dragBlockUnmatchingSizes({ value: prop.value, contentSize, wideSize })}
                                                                            onChange={(value) => { updateDragBlockStyles(value, index, false, true) }}
                                                                        />
                                                                    )}
                                                                    {/* ANIMATION NAME */}
                                                                    {(propNames[prop.slug].type === 'animation-name') && (
                                                                        <AnimationNameControl value={prop.value} onChange={(value) => { updateDragBlockStyles(value, index) }} />
                                                                    )}


                                                                </div>
                                                            )}

                                                            {/* 
                                                                    --------------------------------------------------------------------
                                                                    >>>>>>>>>>>> POPOVER ADVANCED
                                                                    --------------------------------------------------------------------
                                                                    */}
                                                            {/* DEVICES */}
                                                            <Flex className='extra devices'>
                                                                <FlexItem className='label'>{__('Devices', 'dragblock')}</FlexItem>
                                                                <FlexItem className='control'>
                                                                    <Tooltip
                                                                        text={__('Desktop (d)', 'dragblock')}
                                                                        delay={10}
                                                                        position='top center'
                                                                    >
                                                                        <a className={
                                                                            classnames('extra-item', {
                                                                                'active': prop['devices'] && prop['devices'].indexOf('d') !== -1
                                                                            })
                                                                        }
                                                                            onClick={() => {

                                                                                if (editSelector) {
                                                                                    setAttributes({ dragBlockStyles: updateMasterSelector(dragBlockStyles, index, 'd') })
                                                                                    return;
                                                                                }






                                                                                setAttributes({ dragBlockStyles: updateDevices(dragBlockStyles, index, 'd') })
                                                                            }}
                                                                        >
                                                                            {iconDesktop}
                                                                            {/* <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.5 16h-.7V8c0-1.1-.9-2-2-2H6.2c-1.1 0-2 .9-2 2v8h-.7c-.8 0-1.5.7-1.5 1.5h20c0-.8-.7-1.5-1.5-1.5zM5.7 8c0-.3.2-.5.5-.5h11.6c.3 0 .5.2.5.5v7.6H5.7V8z"></path></svg> */}

                                                                        </a>
                                                                    </Tooltip>




                                                                    <Tooltip
                                                                        text={__('Tablet (t)', 'dragblock')}
                                                                        delay={10} position='top center'
                                                                    >
                                                                        <a className={
                                                                            classnames('extra-item', {
                                                                                'active': prop['devices'] && prop['devices'].indexOf('t') !== -1
                                                                            })
                                                                        }
                                                                            onClick={() => {
                                                                                if (editSelector) {
                                                                                    setAttributes({ dragBlockStyles: updateMasterSelector(dragBlockStyles, index, 't') })
                                                                                    return;
                                                                                }

                                                                                setAttributes({ dragBlockStyles: updateDevices(dragBlockStyles, index, 't') })
                                                                            }}
                                                                        >
                                                                            {iconTablet}
                                                                            {/* <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M17 4H7c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm.5 14c0 .3-.2.5-.5.5H7c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v12zm-7.5-.5h4V16h-4v1.5z"></path></svg> */}

                                                                        </a>
                                                                    </Tooltip>

                                                                    <Tooltip
                                                                        text={__('Mobile (m)', 'dragblock')}
                                                                        delay={10} position='top center'
                                                                    >
                                                                        <a className={
                                                                            classnames('extra-item', {
                                                                                'active': prop['devices'] && prop['devices'].indexOf('m') !== -1
                                                                            })
                                                                        }
                                                                            onClick={() => {
                                                                                if (editSelector) {
                                                                                    setAttributes({ dragBlockStyles: updateMasterSelector(dragBlockStyles, index, 'm') })
                                                                                    return;
                                                                                }

                                                                                setAttributes({ dragBlockStyles: updateDevices(dragBlockStyles, index, 'm') })
                                                                            }}
                                                                        >
                                                                            {iconMobile}
                                                                            {/* <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M15 4H9c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm.5 14c0 .3-.2.5-.5.5H9c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h6c.3 0 .5.2.5.5v12zm-4.5-.5h2V16h-2v1.5z"></path></svg> */}

                                                                        </a>
                                                                    </Tooltip>
                                                                </FlexItem>
                                                            </Flex>



                                                            {/* 

                                                                    STATES 
                                                                    */}
                                                            {showStates !== false && (<Flex className='extra states'>
                                                                <FlexItem className='label'>{__('States', 'dragblock')}</FlexItem>
                                                                <FlexItem className='control'>
                                                                    {
                                                                        Object.entries(supportedStates).map(([stateValue, stateText], elKey) => {
                                                                            return (

                                                                                <a key={elKey} className={
                                                                                    classnames('extra-item', {
                                                                                        'active': !!stateSelectors[stateValue],
                                                                                    })
                                                                                }
                                                                                    onClick={() => {

                                                                                        if (stateSelectors[stateValue]) {

                                                                                            delete stateSelectors[stateValue];
                                                                                        } else {

                                                                                            stateSelectors[stateValue] = true;
                                                                                        }


                                                                                        stateSelectorSet = stateSelectorSet.split(',')


                                                                                        if (Object.keys(stateSelectors).length === 0) {

                                                                                            stateSelectors[''] = true;
                                                                                        }


                                                                                        let newSelector = Object.keys(stateSelectors).map(state => {
                                                                                            return stateSelectorSet.join(state + ',') + state
                                                                                        }).join(', ');

                                                                                        if (editSelector) {
                                                                                            setAttributes({ dragBlockStyles: updateMasterSelector(dragBlockStyles, index, null, newSelector) })
                                                                                            return;
                                                                                        }

                                                                                        let style = cloneDeep(dragBlockStyles)
                                                                                        style[index]['selectors'] = newSelector;

                                                                                        if (style[index]['selectors'] === '') {
                                                                                            delete style[index]['selectors']
                                                                                        }

                                                                                        setAttributes({ dragBlockStyles: style })
                                                                                    }}
                                                                                >
                                                                                    <Tooltip
                                                                                        text={stateText}
                                                                                        delay={10}
                                                                                        position='top center'
                                                                                    >
                                                                                        <span>{stateValue}</span>
                                                                                    </Tooltip>
                                                                                </a>

                                                                            )
                                                                        })
                                                                    }


                                                                </FlexItem>
                                                            </Flex>)}


                                                            {/* SELECTORS 
                                                                    We use "selector" to comply with the "states"
                                                                    */}
                                                            <Flex className='extra selectors'>
                                                                <FlexItem className='label'>{__('Selectors', 'dragblock')}</FlexItem>
                                                                <FlexItem className='control'>
                                                                    <ChosenControl
                                                                        position='top'
                                                                        options={getSelectors()}
                                                                        value={prop.selectors}

                                                                        onChange={(value) => {
                                                                            if (editSelector) {
                                                                                setAttributes({ dragBlockStyles: updateMasterSelector(dragBlockStyles, index, null, value) })

                                                                                return;
                                                                            }

                                                                            let style = cloneDeep(dragBlockStyles);
                                                                            style[index]['selectors'] = value;
                                                                            setAttributes({ dragBlockStyles: style })
                                                                        }}
                                                                    />

                                                                </FlexItem>
                                                            </Flex>


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
}, 'dragBlockApperanceControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/apperance-controls',
    dragBlockApperanceControls
);