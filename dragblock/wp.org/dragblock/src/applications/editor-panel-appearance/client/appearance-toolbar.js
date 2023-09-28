import { __ } from '@wordpress/i18n';
import { cloneDeep } from 'lodash';
import { createHigherOrderComponent } from '@wordpress/compose';
import {
    BlockControls, useInnerBlocksProps
} from '@wordpress/block-editor';


import {
    initDragBlockStyles
} from './appearance-settings';


import {
    flipHorizontal as flipH,
    flipVertical as flipV,
    rotateRight,
    rotateLeft
} from '@wordpress/icons';

import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';

import { ToolbarGroup } from '@wordpress/components';
import { ToolbarButton } from '@wordpress/components';
import {
    iconCover
} from '../../../library/client/icons/icons';
import { isBanningBlock } from '../../../library/client/ultils/banning';

/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 */
const dragBlockApperanceToolbar = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, isSelected, clientId, context, isMultiSelected, name } = props;
        let { dragBlockStyles, dragBlockClientId } = attributes;

        if (!dragBlockStyles) {
            dragBlockStyles = initDragBlockStyles(props.name);
        }

        const getCurrentStyleProperty = (slug, device = '') => {

            for (let i = 0; i < dragBlockStyles.length; i++) {
                let st = dragBlockStyles[i];
                if (st['slug'] === slug &&
                    !st['disabled'] &&
                    !st['selectors']


                ) {
                    if (!device && !st['devices'] || (st['devices'] && (device === st['devices']))) return i
                }
            }
            return -1;
        }
        const setCurrentStyleProperty = function (slug, index = -1, value = '', device = '') {
            let style = cloneDeep(dragBlockStyles);

            if (index === -1) {
                let new_style = {
                    slug: slug,
                    value: value,
                }
                if (device) {
                    new_style.devices = device
                }
                style.unshift(cloneDeep(new_style))
            } else {
                style[index]['value'] = value
            }
            setAttributes({ dragBlockStyles: style });
        }






        let fontSize = '';
        let fontSizeStep = .1;
        let fontSizeIndex = getCurrentStyleProperty('font-size');
        let fontSizeUnit = '';

        if (fontSizeIndex !== -1) {
            fontSize = dragBlockStyles[fontSizeIndex]['value']
        }

        if (!fontSize) {
            fontSize = '1em';
        }
        if (fontSize.indexOf('px') !== -1) fontSizeStep = 2;
        else if (fontSize.indexOf('em') !== -1) fontSizeStep = 0.5;
        fontSizeUnit = fontSize.replace(parseFloat(fontSize), '');
        fontSize = parseFloat(fontSize);




        let bgImg = '';
        let bgImgIndex = getCurrentStyleProperty('background-image');

        if (bgImgIndex !== -1) {
            bgImg = dragBlockStyles[bgImgIndex]['value'];
            bgImg = bgImg.replaceAll('url(', '').replaceAll(')', '').replaceAll('\'', '').replaceAll('"', '');
        }




        if (isBanningBlock(props)) {

            return (<><BlockEdit {...props} /></>)
        }

        return (
            <>
                <BlockEdit {...props} />

                <BlockControls>
                    {(props.name.indexOf('dragblock') !== -1) && (
                        <>

                            {['dragblock/icon', 'dragblock/link', 'dragblock/text'].includes(props.name) && (

                                <ToolbarGroup>
                                    <ToolbarButton
                                        label={__('Decrease size', 'dragblock')}
                                        onClick={() => {
                                            if (fontSize - fontSizeStep > 0) {
                                                fontSize -= fontSizeStep
                                                let style = cloneDeep(dragBlockStyles);
                                                if (fontSizeIndex === -1) {
                                                    style.unshift({
                                                        slug: 'font-size',
                                                        value: fontSize + fontSizeUnit
                                                    })
                                                } else {
                                                    style[fontSizeIndex]['value'] = fontSize + fontSizeUnit
                                                }
                                                setAttributes({ dragBlockStyles: style })
                                            }

                                        }}
                                    >
                                        <span className='dragblock-toolbar-text-icon'>A-</span>
                                    </ToolbarButton>
                                    <ToolbarButton
                                        label={__('Increase size', 'dragblock')}
                                        onClick={() => {
                                            fontSize += fontSizeStep;
                                            let style = cloneDeep(dragBlockStyles);
                                            if (fontSizeIndex === -1) {
                                                style.unshift({
                                                    slug: 'font-size',
                                                    value: fontSize + fontSizeUnit
                                                })
                                            } else {
                                                style[fontSizeIndex]['value'] = fontSize + fontSizeUnit
                                            }
                                            setAttributes({ dragBlockStyles: style })
                                        }}
                                    >
                                        <span className='dragblock-toolbar-text-icon'>A+</span>
                                    </ToolbarButton>
                                </ToolbarGroup>
                            )}

                            {props.name === 'dragblock/wrapper' && (
                                <>
                                    {/* <ImageControl
                                                        value={bgImg}
                                                        onChange={(media) => {
                                                            
                                                        }}
                                                        label={__('Background Image')}
                                                        text={iconCover}
                                                    /> */}
                                    <MediaUploadCheck>
                                        <MediaUpload
                                            onSelect={(media) => {


                                                let style = cloneDeep(dragBlockStyles);
                                                let value = `url("${media.url}")`;

                                                if (bgImgIndex === -1) {
                                                    style.unshift({
                                                        slug: 'background-image',
                                                        value: value
                                                    })
                                                } else {
                                                    style[bgImgIndex]['value'] = value
                                                }
                                                setAttributes({ dragBlockStyles: style })

                                            }}
                                            allowedTypes={['image']}
                                            value={bgImg}
                                            render={({ open }) => {
                                                return (
                                                    <ToolbarGroup>
                                                        <ToolbarButton label={__('Background Image')}
                                                            onClick={open}
                                                            className='dragblock-toolbar-background-image'>
                                                            {iconCover}
                                                        </ToolbarButton>
                                                    </ToolbarGroup>
                                                )
                                            }}
                                        />
                                    </MediaUploadCheck>
                                </>
                            )}
                            {props.name.indexOf('dragblock/icon') !== -1 && (
                                <>
                                    <ToolbarButton
                                        icon={rotateRight}
                                        label={__('Rotate', 'dragblock')}
                                        onClick={() => {
                                            let style = cloneDeep(dragBlockStyles);


                                            let value = 0;
                                            let index = -1;
                                            for (let i = 0; i < style.length; i++) {
                                                let st = style[i];
                                                if (st['slug'] === 'transform' &&
                                                    !st['disabled'] &&
                                                    !st['devices'] &&
                                                    !st['selectors'] &&
                                                    st['value'] && st['value'].indexOf('rotate(') !== -1
                                                ) {

                                                    value = st['value'].replace('rotate(', '').replace(')', '').replace('deg', '')
                                                    if (isNaN(value)) value = 0;
                                                    else value = parseInt(value)

                                                    if (value % 45) continue;


                                                    index = i;
                                                    break;

                                                }
                                            }

                                            value = 'rotate(' + (value + 45) + 'deg)';
                                            if (index === -1) {
                                                style.unshift({
                                                    slug: 'transform',
                                                    value: value
                                                })
                                            } else {
                                                style[index]['value'] = value
                                            }
                                            setAttributes({ dragBlockStyles: style })
                                        }}
                                    />
                                    <ToolbarButton
                                        icon={rotateLeft}
                                        label={__('Rotate', 'dragblock')}
                                        onClick={() => {
                                            let style = cloneDeep(dragBlockStyles);


                                            let value = 0;
                                            let index = -1;
                                            for (let i = 0; i < style.length; i++) {
                                                let st = style[i];
                                                if (st['slug'] === 'transform' &&
                                                    !st['disabled'] &&
                                                    !st['devices'] &&
                                                    !st['selectors'] &&
                                                    st['value'] && st['value'].indexOf('rotate(') !== -1
                                                ) {

                                                    value = st['value'].replace('rotate(', '').replace(')', '').replace('deg', '')
                                                    if (isNaN(value)) value = 0;
                                                    else value = parseInt(value)

                                                    if (value % 45) continue;


                                                    index = i;
                                                    break;

                                                }
                                            }

                                            value = 'rotate(' + (value - 45) + 'deg)';
                                            if (index === -1) {
                                                style.unshift({
                                                    slug: 'transform',
                                                    value: value
                                                })
                                            } else {
                                                style[index]['value'] = value
                                            }
                                            setAttributes({ dragBlockStyles: style })
                                        }}
                                    />
                                    <ToolbarButton
                                        icon={flipH}
                                        label={__('Flip Horizontal', 'dragblock')}
                                        onClick={() => {

                                            let style = cloneDeep(dragBlockStyles);


                                            let value = 0;
                                            let index = -1;
                                            for (let i = 0; i < style.length; i++) {
                                                let st = style[i];
                                                if (st['slug'] === 'transform' &&
                                                    !st['disabled'] &&
                                                    !st['devices'] &&
                                                    !st['selectors'] &&
                                                    st['value'] && st['value'].indexOf('rotateY(') !== -1
                                                ) {

                                                    value = st['value'].replace('rotateY(', '').replace(')', '').replace('deg', '')
                                                    if (isNaN(value)) value = 0;
                                                    else value = parseInt(value)


                                                    if (value % 180) continue;


                                                    index = i;
                                                    break;
                                                }
                                            }

                                            value = 'rotateY(' + (value + 180) + 'deg)';
                                            if (index === -1) {
                                                style.unshift({
                                                    slug: 'transform',
                                                    value: value
                                                })
                                            } else {
                                                style[index]['value'] = value
                                            }
                                            setAttributes({ dragBlockStyles: style })
                                        }}
                                    />
                                    <ToolbarButton
                                        icon={flipV}
                                        label={__('Flip Vertical', 'dragblock')}
                                        onClick={() => {

                                            let style = cloneDeep(dragBlockStyles);


                                            let value = 0;
                                            let index = -1;
                                            for (let i = 0; i < style.length; i++) {
                                                let st = style[i];
                                                if (st['slug'] === 'transform' &&
                                                    !st['disabled'] &&
                                                    !st['devices'] &&
                                                    !st['selectors'] &&
                                                    st['value'] && st['value'].indexOf('rotateX(') !== -1
                                                ) {

                                                    value = st['value'].replace('rotateX(', '').replace(')', '').replace('deg', '')
                                                    if (isNaN(value)) value = 0;
                                                    else value = parseInt(value)


                                                    if (value % 180) continue;


                                                    index = i;
                                                    break;
                                                }
                                            }

                                            value = 'rotateX(' + (value + 180) + 'deg)';
                                            if (index === -1) {
                                                style.unshift({
                                                    slug: 'transform',
                                                    value: value
                                                })
                                            } else {
                                                style[index]['value'] = value
                                            }
                                            setAttributes({ dragBlockStyles: style })
                                        }}
                                    />
                                </>
                            )}

                        </>

                    )}
                </BlockControls>


            </>
        );
    };
}, 'dragBlockApperanceToolbar');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/apperance-toolbar',
    dragBlockApperanceToolbar
);