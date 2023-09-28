import { __ } from '@wordpress/i18n';
import { createHigherOrderComponent } from '@wordpress/compose';
import { useRef, useState } from '@wordpress/element';
import { cloneDeep } from 'lodash'
import {
    __experimentalLinkControl as LinkControl,
    BlockControls
} from '@wordpress/block-editor';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import {
    Popover, ToolbarGroup,
    ToolbarButton
} from '@wordpress/components';
import {
    link,
    linkOff
} from '@wordpress/icons';

import {
    findAttrIndex,
    deleteAttr,
    setAttr,
    getAttr,
} from './attributes-settings';
import { select } from '@wordpress/data'
import { isBanningBlock } from '../../../library/client/ultils/banning';
import { Button } from '@wordpress/components';
import { iconCloudUpload, iconImage, iconMedia, iconUpload } from '../../../library/client/icons/icons';
import AppenderButton from '../../../library/client/components/appender';

/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 */
const dragBlockAttributesToolbar = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, clientId, isSelected, isMultiSelected } = props;

        let { dragBlockAttrs } = attributes;



        if (!dragBlockAttrs) {
            dragBlockAttrs = [];
        }

        const [isEditingURL, setIsEditingURL] = useState(false);
        const NEW_TAB_REL = 'noreferrer noopener';

        function unlink() {
            let newAttr = cloneDeep(dragBlockAttrs);


            let delList = ['href', 'target', 'rel']
            for (let delAttr of delList) {
                deleteAttr(newAttr, delAttr);
            }

            setAttributes({
                dragBlockAttrs: newAttr
            });
            setIsEditingURL(false);
        }

        function onToggleOpenInNewTab(attrList, value) {
            const newLinkTarget = (value ? '_blank' : '');
            const updatedRel = (newLinkTarget ? NEW_TAB_REL : '');

            if (newLinkTarget) {
                setAttr(attrList, 'target', newLinkTarget);
            } else {
                deleteAttr(attrList, 'target');
            }

            if (updatedRel) {
                setAttr(attrList, 'rel', updatedRel);
            } else {
                deleteAttr(attrList, 'rel');
            }
        }

        let href = getAttr(dragBlockAttrs, 'href');
        let target = getAttr(dragBlockAttrs, 'target');
        let src = getAttr(dragBlockAttrs, 'src');


        if (isBanningBlock(props)) {
            return (<><BlockEdit {...props} /></>)
        }
        return (
            <>
                <BlockEdit {...props} />

                {(props.name === 'dragblock/link') && (
                    <>
                        <BlockControls>
                            <ToolbarGroup>
                                <ToolbarButton
                                    name="link"
                                    icon={link}
                                    title={__('Link', 'dragblock')}
                                    onClick={() => {
                                        setIsEditingURL(true)
                                    }}
                                    isActive={href !== null}
                                />
                                {(href !== null) ? (
                                    <ToolbarButton
                                        name="link-off"
                                        icon={linkOff}
                                        title={__('Unlink', 'dragblock')}

                                        onClick={() => {
                                            unlink();
                                        }}

                                    />
                                ) : null}
                                {isEditingURL && (
                                    <Popover
                                        position="bottom center"
                                        onClose={() => {
                                            setIsEditingURL(false);

                                        }}
                                    >
                                        {<LinkControl

                                            className="wp-block-navigation-link__inline-link-input"
                                            value={{
                                                url: (href === null ? '' : href),
                                                opensInNewTab: (target !== '_blank' ? '' : target)
                                            }}
                                            onChange={({
                                                url: newURL,
                                                opensInNewTab: newOpensInNewTab,
                                            }) => {
                                                let newAttr = cloneDeep(dragBlockAttrs);
                                                setAttr(newAttr, 'href', newURL)

                                                onToggleOpenInNewTab(newAttr, newOpensInNewTab);



                                                setAttributes({ dragBlockAttrs: newAttr });
                                            }}
                                            onRemove={() => {
                                                unlink();
                                            }}
                                        />}
                                    </Popover>
                                )}
                            </ToolbarGroup>
                        </BlockControls>



                    </>
                )}

                {
                    (props.name === 'dragblock/image') && (
                        <BlockControls>

                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => {
                                        if (!media['url']) return;

                                        let newAttr = cloneDeep(dragBlockAttrs);
                                        setAttr(newAttr, 'src', media['url'])


                                        setAttributes({ dragBlockAttrs: newAttr });
                                    }}
                                    allowedTypes={['image']}
                                    value={src}
                                    render={({ open }) => (
                                        <ToolbarGroup>
                                            <ToolbarButton
                                                label={__('Upload Image', 'dragblock')}
                                                onClick={open}
                                                className='dragblock-toolbar-upload-media'>
                                                {iconImage}
                                            </ToolbarButton>
                                        </ToolbarGroup>

                                    )}
                                />
                            </MediaUploadCheck>

                        </BlockControls>

                    )
                }

                {([
                    'dragblock/wrapper', 
                    'dragblock/link', 
                    'dragblock/form', 
                    'dragblock/select',                    
                ].includes(props.name)) && (
                    <BlockControls>
                        <ToolbarGroup>
                            <ToolbarButton>
                                <AppenderButton rootClientId={clientId} />
                            </ToolbarButton>
                        </ToolbarGroup>
                    </BlockControls>
                )}

            </>
        );
    };
}, 'dragBlockAttributesToolbar');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/attributes-toolbar',
    dragBlockAttributesToolbar
);