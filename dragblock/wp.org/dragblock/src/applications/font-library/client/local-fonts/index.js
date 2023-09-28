import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import UploadFontForm from './upload-font-form';
import './local-fonts.css';
import DemoTextInput from '../demo-text-input';
import Demo from '../demo-text-input/demo';
import { variableAxesToCss } from '../demo-text-input/utils';
import BackButton from '../manage-fonts/back-button';

const INITIAL_FORM_DATA = {
	file: null,
	name: null,
	weight: null,
	style: null,
};

function LocalFonts() {
	const [ formData, setFormData ] = useState( INITIAL_FORM_DATA );
	const [ axes, setAxes ] = useState( {} );

	const resetFormData = () => {
		setFormData( INITIAL_FORM_DATA );
	};

	const resetAxes = () => {
		const newAxes = Object.keys( axes ).reduce( ( acc, axisTag ) => {
			acc[ axisTag ] = {
				...axes[ axisTag ],
				currentValue: axes[ axisTag ].defaultValue,
			};
			return acc;
		}, {} );
		setAxes( newAxes );
	};

	const isFormValid = () => {
		return (
			formData.file && formData.name && formData.weight && formData.style
		);
	};

	const demoStyle = () => {
		if ( ! isFormValid() ) {
			return {};
		}
		const style = {
			fontFamily: formData.name,
			fontWeight: formData.weight,
			fontStyle: formData.style,
		};
		if ( formData.variable ) {
			style.fontVariationSettings = variableAxesToCss( axes );
		}
		return style;
	};


	const onFormDataChange = async () => {
		if ( ! isFormValid() ) {
			return;
		}

		const data = await formData.file.arrayBuffer();
		const newFont = new FontFace( formData.name, data, {
			style: formData.style,
			weight: formData.weight,
		} );
		newFont
			.load()
			.then( function ( loadedFace ) {
				document.fonts.add( loadedFace );
			} )
			.catch( function ( error ) {


				console.error( error );
			} );
	};

	useEffect( () => {
		onFormDataChange();
	}, [ formData ] );

	return (
		<div className="layout">
			<main>
				<header>
					<BackButton />
					<h1>{ __( 'Upload Local Fonts', 'dragblock' ) }</h1>
					<p>
						{ __(
							'Add local fonts assets and font face definitions to the DragBlock\'s font library',
							'dragblock'
						) }
					</p>
				</header>
				<UploadFontForm
					isFormValid={ isFormValid }
					formData={ formData }
					setFormData={ setFormData }
					resetFormData={ resetFormData }
					setAxes={ setAxes }
				/>
			</main>

			<div className="preview">
				<h2>{ __( 'Font file preview', 'dragblock' ) }</h2>

				{ isFormValid() ? (
					<>
						<DemoTextInput
							axes={ axes }
							setAxes={ setAxes }
							resetAxes={ resetAxes }
						/>
						<p>{ __( 'Demo:', 'dragblock' ) }</p>
						<Demo style={ demoStyle() } />
					</>
				) : (
					<p>
						{ __(
							'Load a font file to preview it.',
							'dragblock'
						) }
					</p>
				) }
			</div>
		</div>
	);
}

export default LocalFonts;
