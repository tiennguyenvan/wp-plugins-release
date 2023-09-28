/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
/**
 * WordPress dependencies
 */

/**
 * Internal dependencies
 */
import { Inserter } from '@wordpress/block-editor';
import { iconPlus } from '../icons/icons';

export default function AppenderButton(
    { rootClientId },
) {
    return (
        <Inserter
            position="bottom center"
            rootClientId={rootClientId}
            __experimentalIsQuick
            renderToggle={({
                onToggle,
            }) => {                
                return (
                    <a
                        title={__('Add a Child', 'dragblock')}
                        onClick={onToggle}
                    >
                        {iconPlus}
                    </a>
                );
            }}
            isAppender={true}
        />
    );
}
