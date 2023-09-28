
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
    databaseQueries as DBQueries,
    databaseParams as DBParams,
} from './database-settings';


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
import { QueryObjectControl } from '../../../library/client/components/query-control';
import { CheckboxControl } from '@wordpress/components';
import { getGlobalQueryObject, requestQueryObjects } from '../../../library/client/ultils/ajax';


/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 * @note setAttributes will trigger BlockEdit filter (and select Block for Grouping will also trigger BlockEdit)
 * so that will be an infinity loop if You setAttributes "automatically" inside BlockEdit
 * 
 * @note You also need to check if the attribute you want to set automatically has the same as its saved value
 * If it does, don't save because it will trigger infinity loops
 */

/**
 * DBQueryVariables is for mapping name-id for queries quickly
 */
var DBQueryVariables = new Object();
const dragBlockDatabaseControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        const { attributes, setAttributes, clientId, isSelected, isMultiSelected } = props;

        const [queryIndexPop, setQueryIndexPop] = useState(-1);
        const [paramIndexPop, setParamIndexPop] = useState([queryIndexPop, -1]);

        useEffect(() => {
            if (window['dragblock-query-ids'] && Object.keys(window['dragblock-query-ids']).length > 0) {
                for (let type in window['dragblock-query-ids']) {
                    requestQueryObjects(type, window['dragblock-query-ids'][type])
                }
            }
        });


        let { dragBlockClientId, dragBlockQueries, dragBlockAttrs, className, anchor } = attributes;



        if (!dragBlockQueries) {
            dragBlockQueries = [];
        }
        for (let query of dragBlockQueries) {
            let { name, id } = query;
            if (name) {
                DBQueryVariables[id] = name;
            }
        }


        const arrayParams = ['authors', 'categories', 'tags', 'posts'];


        /* 
        ------------------------------------------------------------------
        LOADING ALL QUERY IDS
        ------------------------------------------------------------------
        */
        if (!window['dragblock-query-ids']) {
            window['dragblock-query-ids'] = {}
        }
        for (let query of dragBlockQueries) {
            if (!query['params']) continue;
            for (let param of query.params) {
                let type = DBParams[param.slug].type;
                if (!arrayParams.includes(type)) continue;
                if (!window['dragblock-query-ids'][type]) {
                    window['dragblock-query-ids'][type] = new Set();
                }
                param.value.split(',').map(id => {
                    if (isNaN(id)) return
                    window['dragblock-query-ids'][type].add(id)
                })
            }

        }


        /* 
        ------------------------------------------------------------------
        QUERY ADD MORE
        ------------------------------------------------------------------
        */
        const querySearchBox = () => {
            return (
                <AutocompleteSearchBox
                    placeholder={__('+ Add a Query/Function', 'dragblock')}
                    onSelect={(newQuerySlug) => {
                        let queries = cloneDeep(dragBlockQueries)
                        queries.unshift({
                            slug: newQuerySlug,
                            name: '',
                            id: (dragBlockClientId + '__' + clientId),
                            params: []




                        });
                        setAttributes({ dragBlockQueries: queries })


                    }}
                    suggestions={DBQueries}
                />
            )
        }

        /* 
        ------------------------------------------------------------------
        QUERY INFO
        ------------------------------------------------------------------
        */
        const queryInfo = (query, queryIndex) => {
            const {
                slug,
                name,
                id,
                params,
                disabled
            } = query;

            let label = DBQueries[slug]['label'];


            return (
                <a
                    className='title'
                    onClick={() => {
                        setQueryIndexPop(queryIndex);
                    }}
                >
                    <span className='variable'>${name ? name.replaceAll(' ', '_') : ''}</span> = <span className='keyword'>{label.replaceAll(' ', '_')}</span>
                </a>
            )
        }
        /* 
        ------------------------------------------------------------------
        QUERY EDITOR POPOVER
        ------------------------------------------------------------------
        */
        const queryEditorPopover = (query, queryIndex) => {
            const {
                slug,
                name,
                id,
                params,
                disabled
            } = query;

            return (
                <PopoverProperty
                    className='dragblock-database-query-control-popover'
                    onClose={() => {
                        setQueryIndexPop(-1);
                    }}
                    onMouseLeave={() => {
                        setQueryIndexPop(-1);
                    }}
                    onKeyDown={(event) => {
                        if (event.key === 'Escape' || event.key === 'Enter') {
                            setQueryIndexPop(-1);
                        }
                    }}
                    actions={{
                        hidden: false,
                        delete: function (newList, index) {

                            delete DBQueryVariables[newList[index]['id']];
                            newList.splice(index, 1)
                            return newList;
                        }
                    }}

                    onAction={(action, newQueryList) => {

                        if ('disable' === action) {
                            if (newQueryList[queryIndex]['disabled']) {
                                delete newQueryList[queryIndex]['disabled'];
                            } else {
                                newQueryList[queryIndex]['disabled'] = '*';
                            }
                        }
                        setQueryIndexPop(-1);
                        setAttributes({ dragBlockQueries: newQueryList })
                    }}

                    disabled={disabled}
                    list={dragBlockQueries}
                    index={queryIndex}
                >
                    <TextControl
                        label={__('Variable Name', 'dragblock')}
                        value={name}
                        onChange={(newQueryTitle) => {
                            let queries = cloneDeep(dragBlockQueries)
                            queries[queryIndex]['name'] = newQueryTitle.replace(/[^a-zA-Z0-9_$]/g, '_');
                            DBQueryVariables[queries[queryIndex]['id']] = queries[queryIndex]['name'];
                            setAttributes({ dragBlockQueries: queries })
                        }}
                    />
                </PopoverProperty>
            )
        }


        /* 
        ------------------------------------------------------------------
        PARAM ADDMORE
        ------------------------------------------------------------------
        */
        const paramAddMore = (queryIndex, availableParams) => {
            return (
                <AutocompleteSearchBox
                    placeholder={__('+ Add a Parameter', 'dragblock')}
                    onSelect={(newParamSlug) => {
                        let queries = cloneDeep(dragBlockQueries)

                        queries[queryIndex]['params'].unshift({
                            slug: newParamSlug,
                            value: '',
                        });
                        setAttributes({ dragBlockQueries: queries })
                        setParamIndexPop([queryIndex, 0]);
                    }}
                    suggestions={availableParams}
                />
            )
        }


        /* 
        ------------------------------------------------------------------
        PARAM INFO
        ------------------------------------------------------------------
        */
        const paramInfo = (queryIndex, param, paramIndex) => {
            const {
                slug,
                value,
                disabled
            } = param;
            let type = DBParams[slug].type;
            let isArrayParam = arrayParams.includes(type) && value;
            let displayNames = {}

            if (isArrayParam) {
                let ids = value.split(',');
                ids.map(id => {
                    let obj = getGlobalQueryObject(type, id);
                    if (obj !== null) {
                        displayNames[id] = obj
                    }
                })
                if (Object.keys(displayNames).length < ids.length) {
                    isArrayParam = false
                }
            }

            return (
                <a
                    key={paramIndex}
                    className='param'
                    onClick={() => {
                        setParamIndexPop([queryIndex, paramIndex])
                    }}
                >
                    <span className='slug keyword'>{slug}</span>:

                    {isArrayParam ? (
                        <>
                            {/* /// array-like parameters */}
                            <span className='value array'>{
                                Object.entries(displayNames).map(([id, obj], elKey) => {
                                    return (
                                        <span className='object' key={elKey}>
                                            <span className='id'>{id}</span>:
                                            <span className='name'> {obj['name']}</span>
                                        </span>
                                    )
                                })
                            }</span>
                        </>
                    ) : (
                        <>
                            {/* /// linear params */}
                            <span className='value'> {
                                (DBParams[slug].type === 'query_variable' &&
                                    DBQueryVariables[value] ? '$' + DBQueryVariables[value] : value) || __('default', 'dragblock')
                            }
                            </span>
                        </>
                    )}
                </a>
            )
        }

        /* 
        ------------------------------------------------------------------
        PARAM ATTRIBUTE UPDATE
        ------------------------------------------------------------------
        */
        const paramUpdate = (queryIndex, paramIndex, value) => {

            let queries = cloneDeep(dragBlockQueries)
            queries[queryIndex]['params'][paramIndex]['value'] = value;
            setAttributes({ dragBlockQueries: queries })
        }

        /* 
        ------------------------------------------------------------------
        PARAM CONTROLS
        ------------------------------------------------------------------
        */
        const paramControls = (queryIndex, param, paramIndex) => {
            const {
                slug,
                value,
                disabled
            } = param;
            let options = [];


            if (DBParams[slug].type === 'query_variable') {
                options = Object.entries(DBQueryVariables).map(([key, value]) => {
                    return { value: key, label: '$' + value }
                });
                options.unshift({ value: '', label: __('Default', 'dragblock') });
            }

            return (
                <>
                    {arrayParams.includes(DBParams[slug].type) && (
                        <QueryObjectControl
                            type={DBParams[slug].type}
                            value={value}
                            onSearch={() => {
                                setIsSearchingQuery(true);
                            }}
                            onClose={() => {
                                setIsSearchingQuery(false);
                            }}

                            onSelect={(value) => {
                                paramUpdate(queryIndex, paramIndex, value);
                            }}
                        />
                    )}
                    {DBParams[slug].type === 'text' && (
                        <TextControl
                            value={value}
                            onChange={(value) => {
                                paramUpdate(queryIndex, paramIndex, value);
                            }}
                        />
                    )}
                    {DBParams[slug].type === 'number' && (
                        <NumberControl
                            value={value}
                            onChange={(value) => {
                                paramUpdate(queryIndex, paramIndex, value);
                            }}
                        />
                    )}
                    {DBParams[slug].type === 'checkbox' && (
                        <CheckboxControl
                            value={value}
                            onChange={(value) => {
                                paramUpdate(queryIndex, paramIndex, value);
                            }}
                        />
                    )}
                    {DBParams[slug].type === 'select' && (
                        <SelectControl
                            value={value}
                            onChange={(value) => {
                                paramUpdate(queryIndex, paramIndex, value);
                            }}
                            options={DBParams[slug].options}
                        />
                    )}
                    {DBParams[slug].type === 'query_variable' && (
                        <>
                            <SelectControl
                                value={value}
                                onChange={(value) => {
                                    paramUpdate(queryIndex, paramIndex, value);
                                }}
                                options={options}
                            />
                        </>
                    )}
                </>
            )
        }

        /* 
        ------------------------------------------------------------------
        PARAM EDITOR POPOVER
        ------------------------------------------------------------------
        */
        const paramEditPopover = (queryIndex, param, paramIndex) => {
            const {
                slug,
                value,
                disabled
            } = param;

            return (
                <PopoverProperty
                    className='dragblock-database-param-control-popover'
                    onClose={() => {
                        setParamIndexPop([queryIndex, -1]);
                    }}
                    onMouseLeave={() => {
                        setParamIndexPop([queryIndex, -1]);
                    }}
                    actions={{hidden: false}}
                    onAction={(action, newParamList) => {

                        if ('disable' === action) {
                            if (newParamList[queryIndex]['params'][paramIndex]['disabled']) {
                                delete newParamList[queryIndex]['params'][paramIndex]['disabled'];
                            } else {
                                newParamList[queryIndex]['params'][paramIndex]['disabled'] = '*';
                            }
                        }

                        let newQueryList = cloneDeep(dragBlockQueries);
                        newQueryList[queryIndex]['params'] = newParamList;

                        setParamIndexPop([queryIndex, -1]);
                        setAttributes({ dragBlockQueries: newQueryList })
                    }}

                    disabled={disabled}
                    list={dragBlockQueries[queryIndex]['params']}
                    index={paramIndex}
                >
                    <>

                        <div className='title'>{DBParams[param['slug']]['label']}</div>
                        {paramControls(queryIndex, param, paramIndex)}
                    </>
                </PopoverProperty>
            )
        }

        if (isBanningBlock(props)) {
            return (<><BlockEdit {...props} /></>)
        }
        return (
            <>
                <BlockEdit {...props} />

                <InspectorControls ><div className='dragblock-inspector-controls database'>
                    <PanelBody
                        title={__('Database', 'dragblock')}
                        initialOpen={dragBlockQueries.length > 0}
                    >


                        {querySearchBox()}


                        {/* QUERIES */}
                        {dragBlockQueries && dragBlockQueries.length > 0 && (
                            <div className='properties queries'>
                                {dragBlockQueries.map((query, queryIndex) => {

                                    const {
                                        slug,
                                        name,
                                        id,
                                        params,
                                        disabled
                                    } = query;



                                    let availableParams = new Object();
                                    if (params) {
                                        let addedParams = new Set(params.map(e => e['slug']));

                                        for (let paramSlug of DBQueries[slug]['params']) {
                                            if (addedParams.has(paramSlug)) continue;
                                            if (!DBParams[paramSlug]) continue;

                                            availableParams[paramSlug] = DBParams[paramSlug];
                                        }
                                    }


                                    const [selectedQueryIndex, selectedParamIndex] = paramIndexPop

                                    {/* QUERIES' INFO */ }
                                    return (

                                        <div className={classnames('query', { 'active': '' !== disabled })} key={queryIndex}>

                                            {queryInfo(query, queryIndex)}

                                            <div className='query-params'>
                                                {/* PARAMS INFO */}
                                                {params && params.length > 0 && (
                                                    params.map((param, paramIndex) => {
                                                        return (
                                                            <div key={paramIndex}>
                                                                {paramInfo(queryIndex, param, paramIndex)}
                                                                {selectedQueryIndex === queryIndex &&
                                                                    selectedParamIndex === paramIndex && (
                                                                        paramEditPopover(queryIndex, param, paramIndex)
                                                                    )}
                                                            </div>
                                                        )
                                                    })
                                                )}


                                                {/* ADD MORE PARAM */}
                                                {Object.keys(availableParams).length > 0 && (
                                                    paramAddMore(queryIndex, availableParams)
                                                )}
                                            </div>

                                            {queryIndexPop === queryIndex && (
                                                queryEditorPopover(query, queryIndex)
                                            )}

                                        </div>
                                    )
                                })}
                            </div>
                        )}
                    </PanelBody>
                </div></InspectorControls>


            </>
        );
    };
}, 'dragBlockDatabaseControls');

wp.hooks.addFilter(
    'editor.BlockEdit',
    'dragblock/database-controls',
    dragBlockDatabaseControls
);

