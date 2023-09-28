import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { applyFilters } from '@wordpress/hooks';
import './editor.scss';
import { TextControl, Button } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { getAttr, setAttr } from '../../applications/editor-panel-attributes/client/attributes-settings';
import { dragBlockQueryShortcodes } from '../../library/client/ultils/shortcodes';
import { getYoutubeThumbnail } from '../../library/client/ultils/text';
import { cloneDeep } from 'lodash';
import { useEffect } from '@wordpress/element';
import { useRef } from '@wordpress/element';
/**
 * 
 * @param {Object} props 
 * @returns 
 */
export default function Edit(props) {

    const { attributes, setAttributes, isSelected } = props;
    const { dragBlockAttrs } = attributes;




    let setSRC = getAttr(dragBlockAttrs, 'src');


    let blockProps = useBlockProps();

    if (!setSRC) {
        blockProps['src'] = dragBlockEditorInit.blankDemoImgUrl;
    } else {

        if (setSRC.indexOf('[') !== -1 && setSRC.indexOf(']') !== -1) {
            for (let shortcode in dragBlockQueryShortcodes) {
                let sc = dragBlockQueryShortcodes[shortcode];
                if (sc['placeholder']) {
                    setSRC = setSRC.replaceAll(shortcode, sc['placeholder'])
                } else {
                    setSRC = setSRC.replaceAll(shortcode, dragBlockEditorInit.blankDemoImgUrl);
                }
            }
        }
        else {



            let youTubeSRC = getYoutubeThumbnail(setSRC);

            if (youTubeSRC && youTubeSRC != setSRC) {
                let newAttrs = cloneDeep(dragBlockAttrs);
                setAttr(newAttrs, 'src', youTubeSRC);
                setAttributes({ dragBlockAttrs: newAttrs });
                setSRC = youTubeSRC;
            }
        }

        blockProps['src'] = setSRC;
    }

    if (!isSelected) {

    }

    return (

        <img {...blockProps} />

    );
}
