import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { applyFilters } from '@wordpress/hooks'

/**
 * 
 * @param {Object} props 
 * @returns 
 */
export default function save(props) {		
	const {attributes} = props;	
	let blockProps = useBlockProps.save();

	return (
		<form {...blockProps}>			
				<InnerBlocks.Content />			
		</form>
	);
}
