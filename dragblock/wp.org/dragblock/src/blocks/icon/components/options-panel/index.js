/**
 * Internal dependencies
 */
import OptionsPanelHeader from './header';

/**
 * Render the inspector control panel.
 *
 * @since 2.5.0
 * @param {Object} props All the props passed to this function
 * @return {string}		 Return the rendered JSX
 */
export default function OptionsPanel( props ) {
	const { label, attributes, options } = props;


	options.forEach( ( option ) => {
		if (
			option?.isDefault ||


			( attributes.hasOwnProperty( option.attributeSlug ) &&
				attributes[ option.attributeSlug ] !== undefined )
		) {
			option.isActive = true;
		}
	} );


	const activeOptions = options.filter( ( option ) => option.isActive );

	return (
		<div className="options-panel">
			<OptionsPanelHeader
				label={ label }
				activeOptions={ activeOptions }
				options={ options }
				{ ...props }
			/>
			{ activeOptions.length !== 0 && (
				<div className="options-panel-container">
					{ props.children }
				</div>
			) }
		</div>
	);
}
