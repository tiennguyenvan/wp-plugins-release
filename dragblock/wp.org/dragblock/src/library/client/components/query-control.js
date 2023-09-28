import { __ } from '@wordpress/i18n';
import AutocompleteSearchBox from './autocomplete-search-box';
import { useState } from '@wordpress/element';
import { getGlobalQueryObject, requestQueryObjects } from '../ultils/ajax';
import { iconClose, iconTrash } from '../icons/icons';
import { Tooltip } from '@wordpress/components';
export const QueryObjectControl = (props) => {
    const {
        value,
        type, // category, author, tag, post, ...        
        onSelect,
    } = props;

    let placeholder = __('Add an item', 'dragblock');
    switch (type) {
        case 'categories': placeholder = __('Add a Category', 'dragblock'); break;
        case 'authors': placeholder = __('Add an Author', 'dragblock'); break;
        case 'tags': placeholder = __('Add a Tag', 'dragblock'); break;
        case 'posts': placeholder = __('Add a Post', 'dragblock'); break;
    }

    let objectIds = (value ? value.split(',') : []);
    let objectNames = {}
    objectIds.map(id => {
        let obj = getGlobalQueryObject(type, id);
        if (obj && obj['name']) {
            objectNames[id] = obj['name'];
        } else if (id.indexOf('[dragblock.') !== -1) {
            objectNames[id] = __('Current Item', 'dragblock');
        } else {
            objectNames[id] = __('Fetching ...', 'dragblock');
        }
    });

    return (
        <div className={'dragblock-query-object-controls ' + type}>
            {objectIds.length > 0 && (
                <div className='object'>
                    {(objectIds).map((id, _i) => {
                        return (
                            <div className='name' key={_i}>
                                {id} : {objectNames[id]}

                                <a

                                    className='delete'
                                    onClick={() => {
                                        let newIds = new Set(objectIds);
                                        newIds.delete(id);
                                        onSelect(Array.from(newIds).join(','))
                                    }}
                                >
                                    <Tooltip
                                        text={__('Delete', 'dragblock')}
                                        delay={10}
                                        position='middle right'
                                    ><span>{iconTrash}</span></Tooltip>

                                </a>
                            </div>
                        )
                    })}
                </div>
            )}
            <AutocompleteSearchBox
                placeholder={placeholder}
                onSelect={(id) => {

                    if (!objectIds.includes(id)) {
                        objectIds.push(id);
                        onSelect(objectIds.join(','))
                    }
                }}
                suggestions={type}
            />
        </div>
    );
};




