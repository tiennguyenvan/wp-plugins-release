import { useState } from '@wordpress/element';
import classnames from 'classnames';

import {
    SearchControl, Tooltip,
    Popover, Button
} from '@wordpress/components';

import { iconPlus } from '../icons/icons'
import { TextControl } from '@wordpress/components';




export default function ChosenControl({
    placeholder,
    onChange,
    tabIndex,
    value: originalValue,

    position,
    /*
    {
        slug: 'label'
    }
     */
    options,
}) {

    const [choseIndex, setChoseIndex] = useState(0);
    const [chosenResults, setChosenResults] = useState({});
    if (!originalValue) {
        originalValue = ''
    }


    if (!options) {
        options = {};
    }
    if (!position) {
        position = 'top'
    }
    if (!tabIndex) {
        tabIndex = 0;
    }
    const closeList = () => {
        setChoseIndex(0);
        setChosenResults({});
    }

    const maxResults = 6;


    const showList = (value) => {



        if (!value) {
            closeList();
            return;
        }
        value = value.trim().toLowerCase()
        let results = {};
        let results_len = 0;
        let searchWords = value.split(' ');
        let lastWord = searchWords[searchWords.length - 1];


        if (!value || !value.trim()) {
            for (let slug in options) {
                results[slug] = options[slug];
                if (++results_len === maxResults) {
                    break;
                }
            }

            setChosenResults({ ...results });
            return;
        }


        for (let slug in options) {
            let optionWord = options[slug].toLowerCase();

            if (optionWord === lastWord || optionWord === value) {
                continue;
            }

            let q = slug + ' ' + optionWord;

            let match = true;
            for (let word of searchWords) {


                if (q.indexOf(word) === -1 || optionWord === word) {
                    match = false;
                    break;
                }
            }

            if (match) {
                results[slug] = options[slug];

                if (++results_len >= maxResults) break;
            }
        }


        if (results_len === 0 && value.indexOf(' ') !== -1 && lastWord) {
            showList(lastWord);
            return;
        }

        setChosenResults({ ...results });
    }

    return (
        <div
            className={'dragblock-chosen-control ' + position}
            onMouseLeave={closeList}>
            <div className='components-base-control'>
                <div className='components-base-control__field'>


                    <input
                        className={classnames('components-text-control__input', {
                            'dragblock-chosen-control-input-showing': Object.keys(chosenResults).length > 0
                        })}
                        value={originalValue}
                        placeholder={placeholder}

                        onKeyDown={(event) => {
                            if (event.key === 'Tab' && Object.keys(chosenResults).length) {
                                event.preventDefault();
                            }


                            if (event.key === 'ArrowUp') {
                                if (choseIndex <= 0) setChoseIndex(Object.keys(chosenResults).length - 1)
                                else setChoseIndex(choseIndex - 1)
                            }

                            else if (event.key === 'ArrowDown') {
                                if (choseIndex >= Object.keys(chosenResults).length - 1) setChoseIndex(0)
                                else setChoseIndex(choseIndex + 1)
                            }
                            /*                     
                            we don't use arrow right at this time to prevent conflict the natural move 
                            inside the textControl
                             */
                            else if (event.key === "Enter" || event.key === 'Tab') {
                                closeList();
                                let keys = Object.keys(chosenResults);
                                if (keys.length - 1 < choseIndex || choseIndex < 0) return;
                                let slug = keys[choseIndex];


                                let lastWord = originalValue.split(' ');
                                lastWord[lastWord.length - 1] = slug;
                                onChange(lastWord.join(' '));
                            }
                        }}
                        onClick={() => {
                            showList(originalValue)
                        }}
                        onFocus={() => {
                            showList(originalValue)
                        }}

                        onChange={(event) => {

                            showList(event.target.value);
                            onChange(event.target.value)
                        }}
                    />
                </div>
            </div>
            {(Object.keys(options).length > 0) && (Object.keys(chosenResults).length > 0) && (
                <div className='options'
                    onMouseLeave={closeList}
                >
                    {Object.entries(chosenResults).map(([slug, label], index) => {
                        return (<a
                            key={index}
                            onClick={() => {

                                onChange(slug)


                                closeList();
                            }}
                            className={classnames('option', {
                                'active': choseIndex === index
                            })}
                        >
                            {label}
                        </a>)
                    })}
                </div>
            )}
        </div>
    )
}