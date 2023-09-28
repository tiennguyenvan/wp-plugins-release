


import classnames from 'classnames';
import { ToolbarButton } from '@wordpress/components';
import { Dropdown } from '@wordpress/components';
import { NavigableMenu } from '@wordpress/components';
import { MenuItem } from '@wordpress/components';
import { Popover } from '@wordpress/components';
import {
    close
} from '@wordpress/icons'
import { useState } from '@wordpress/element';

export default function PopoverToolbar({
    children,
    icon,
    label,
    onKeyDown
}) {

    const [isPopoverToolbarOpen, setPopoverToolbarOpen] = useState(false);
    const closePopoverToolbar = () => {
        setPopoverToolbarOpen(false);
    }
    const openPopoverToolbar = () => {
        setPopoverToolbarOpen(true);
    }

    let initCursor = null;



    return (
        <>
            <ToolbarButton onClick={openPopoverToolbar} icon={icon} label={label} tooltipPosition='top center' />
            {isPopoverToolbarOpen && (
                <Popover
                    onKeyDown={onKeyDown}
                    className='dragblock-toolbar-popover'
                    onFocusOutside={closePopoverToolbar}
                    onClose={closePopoverToolbar}
                    onMouseMove={(e) => {
                        if (initCursor === null) {
                            initCursor = { X: e.clientX, Y: e.clientY }
                            return;
                        }
                    }}
                    onMouseLeave={(e) => {
                        if (initCursor === null || initCursor.X === e.clientX || initCursor.Y === e.clientY) {
                            return;
                        }
                        closePopoverToolbar();
                    }}
                >
                    {children}
                </Popover>
            )}
        </>
    );
}