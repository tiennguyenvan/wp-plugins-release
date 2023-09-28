/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
import {
	useBlockProps
} from '@wordpress/block-editor';
import parseIcon from './utils/parse-icon';

/**
 * Internal dependencies
 */

/**
 * The save function for the Icon Block.
 *
 * @param {Object} props All props passed to this function.
 * @return {WPElement}   Element to render.
 */
export default function Save(props) {
	const {
		icon,
	} = props.attributes;


	if (!icon) {
		return null;
	}




	return (
		<span {...useBlockProps.save()} dangerouslySetInnerHTML={{ __html: icon }} />
	)
}
