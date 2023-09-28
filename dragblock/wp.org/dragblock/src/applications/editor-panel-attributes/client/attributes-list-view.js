import { cloneDeep, forEach, isEmpty } from "lodash";
import { __ } from '@wordpress/i18n';
import { getBlockText } from '../../../library/client/ultils/text';



(function ($) {
    /** 
     * =================================================================
     * displaying classnames for list view components
     * =================================================================
     */
    $(document).on('mousedown mouseenter keydown', '.edit-site-header-edit-mode__list-view-toggle, .edit-site-editor__list-view-panel-content, .block-editor-list-view-block-select-button', function () {

        let counter = 0;
        let wait = setInterval(function () {
            if ($(document).find('.block-editor-list-view-block-select-button:not(.dragblock-list-view-optimized)').length || counter >= 5000) {
                clearInterval(wait);
                if (counter >= 5000) {
                    return
                }
                showClassNames();
            }
        });
    });
    let showClassNames = () => {
        $(document).find('.block-editor-list-view-block-select-button').each(function () {

            if ($(this).hasClass('dragblock-list-view-optimized')) return;

            let blockClientId = $(this).attr('href');
            if (!blockClientId || blockClientId.indexOf('#block-') === -1) {
                return;
            }

            blockClientId = blockClientId.split('#block-')[1];


            $(this).find('.block-editor-list-view-block-select-button__title .components-truncate').attr('data-blockClientId', blockClientId);
            $(this).find('.block-editor-list-view-block-select-button__anchor').attr('data-blockClientId', blockClientId);
            $(this).attr('title', $(this).find('.block-editor-list-view-block-select-button__title').text());
            $(this).find('.block-editor-list-view-block-select-button__title .components-truncate').each(function () {
                $(this).attr('data-title', $(this).text());
            })
            $(this).addClass('dragblock-list-view-optimized');


            let blockAttrs = wp.data.select('core/block-editor').getBlockAttributes(blockClientId);
            if (!blockAttrs) {
                return;
            }

            let classNames = blockAttrs['className'];
            let tagName = blockAttrs['dragBlockTagName'] ?? '';            
            if (tagName === 'div') tagName = '';

            if (!classNames) {

                
                    let text = getBlockText(blockAttrs['dragBlockText']);
                    if (text) {
                        if (text.length > 50) {
                            text = text.substring(0, 20) + '...';
                        }
                        $(this).find('.block-editor-list-view-block-select-button__title .components-truncate').text('"'+text+'"');
                    } else if (tagName) {
                        $(this).find('.block-editor-list-view-block-select-button__title .components-truncate').text(tagName);
                    }                
                return;
            }

            classNames = '.' + classNames.split(' ').join('.');
            

            $(this).find('.block-editor-list-view-block-select-button__title .components-truncate').text(tagName + classNames);

        });
    }


    /** 
     * =================================================================
     * modifying class names directly from the list view
     * =================================================================
     */





    const usePrompt = true;


    $(document).on('dblclick', '.block-editor-list-view-block-select-button__title .components-truncate', function (e) {
        let blockClientId = $(this).attr('data-blockClientId');

        if (!blockClientId) {
            return;
        }

        let blockAttrs = wp.data.select('core/block-editor').getBlockAttributes(blockClientId);
        if (!blockAttrs) {
            return;
        }
        let classNames = blockAttrs['className'];
        let tagName = blockAttrs['dragBlockTagName'] ? blockAttrs['dragBlockTagName'] : '';
        if (tagName === 'div') tagName = '';


        if (usePrompt) {
            let val = prompt(__('Please enter class names', 'dragblock'), classNames);
            if (null === val) {
                return;
            }
            val = classnames(val, classNames);

            if (val !== classNames) {
                blockAttrs['className'] = val;
                wp.data.dispatch('core/block-editor').updateBlockAttributes(blockClientId, cloneDeep(blockAttrs));
                if (val) {
                    $(this).text(tagName + '.' + val.split(' ').join('.'));
                } else {
                    $(this).text(tagName + $(this).attr('data-title'));
                }

            }
            return;
        }















































    });


    $(document).on('dblclick', '.block-editor-list-view-block-select-button__anchor', function (e) {
        let blockClientId = $(this).attr('data-blockClientId');

        if (!blockClientId) {
            return;
        }

        let blockAttrs = wp.data.select('core/block-editor').getBlockAttributes(blockClientId);
        if (!blockAttrs) {
            return;
        }
        let anchor = blockAttrs['anchor'];

        let val = prompt(__('Please enter an anchor', 'dragblock'), anchor);
        if (null === val) {
            return;
        }
    

        if (val !== anchor) {
            blockAttrs['anchor'] = val;
            wp.data.dispatch('core/block-editor').updateBlockAttributes(blockClientId, cloneDeep(blockAttrs));
            if (val) {
                $(this).html(val.split(' ').join('#'));
            } else {
                $(this).html('');
            }
        }
    });

    function toSlug(string) {
        return string.trim().toLowerCase().replace(/[^a-zA-Z0-9_-]/g, '-');
    }

    function classnames(string) {
        if (null === string) return '';
        return string.trim().split(' ').map(e => toSlug(e)).join(' ');
    }
})(jQuery);