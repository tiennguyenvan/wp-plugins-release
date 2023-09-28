import { select } from '@wordpress/data'

export function isBanningBlock(props) {
    
    const {clientId, isSelected, isMultiSelected} = props;
    return (!isSelected || isMultiSelected);


    const bannedParentBlocks = ['core/navigation', 'core/query']
    const bannedBlocks = ['core/navigation']
    if (bannedBlocks.includes(props.name)) {
        return true
    }
    let parentNames = select('core/block-editor').getBlockParents(clientId).map(parentId => {
        return select('core/block-editor').getBlock(parentId)['name'];
    });

    for (let name of parentNames) {
        if (name && bannedParentBlocks.includes(name)) {
            return true
        }
    }
    return false;
}