import {
	Button,

	__experimentalInputControl as InputControl,
	SelectControl,
} from '@wordpress/components';
import { Font } from 'lib-font';
import { __ } from '@wordpress/i18n';
import { variableAxesToCss } from '../demo-text-input/utils';

function UploadFontForm( {
	formData,
	setFormData,
	resetFormData,
	isFormValid,
	setAxes,
} ) {

	const nonce = document.querySelector( '#nonce' ).value;

	const onFileSelectChange = ( event ) => {
		const file = event.target.files[ 0 ];

		if ( ! file ) {
			resetFormData();
			return;
		}


		const reader = new FileReader();
		reader.readAsArrayBuffer( file );

		reader.onload = () => {

			const fontObj = new Font( 'Uploaded Font' );


			fontObj.fromDataBuffer( reader.result, file.name );

			fontObj.onload = ( onloadEvent ) => {


				const font = onloadEvent.detail.font;



				const { name } = font.opentype.tables;





				const fontName = name.get( 1 );
				const isItalic = name
					.get( 2 )
					.toLowerCase()
					.includes( 'italic' );
				const fontWeight =
					font.opentype.tables[ 'OS/2' ].usWeightClass || 'normal';


				const isVariable = !! font.opentype.tables.fvar;
				const weightAxis =
					isVariable &&
					font.opentype.tables.fvar.axes.find(
						( { tag } ) => tag === 'wght'
					);
				const weightRange = !! weightAxis
					? `${ weightAxis.minValue } ${ weightAxis.maxValue }`
					: null;
				const axes = isVariable
					? font.opentype.tables.fvar.axes.reduce(
							(
								acc,
								{ tag, minValue, defaultValue, maxValue }
							) => {
								acc[ tag ] = {
									tag,
									minValue,
									defaultValue,
									maxValue,
									currentValue: defaultValue,
								};
								return acc;
							},
							{}
					  )
					: {};
				const fontCredits = {
					copyright: name.get( 0 ),
					source: name.get( 11 ),
					license: name.get( 13 ),
					licenseURL: name.get( 14 ),
				};

				setFormData( {
					file,
					name: fontName,
					style: isItalic ? 'italic' : 'normal',
					weight: !! weightAxis ? weightRange : fontWeight,
					variable: isVariable,
					fontCredits,
				} );
				setAxes( axes );
			};
		};
	};

	const fontVariationSettings = variableAxesToCss( formData.axes );

	return (
		<>
			<form
				method="POST"
				id="font-upload-form"
				action=""
				encType="multipart/form-data"
			>
				<input type="hidden" name="nonce" value={ nonce } />

				<div className="form-group">
					<label htmlFor="font-file">
						{ __( 'Font file:', 'dragblock' ) }
					</label>
					<input
						type="file"
						name="font-file"
						id="font-file"
						onChange={ onFileSelectChange }
						accept=".otf, .ttf, .woff, .woff2"
					/>
					<small>
						{ __(
							'.otf, .ttf, .woff, .woff2 file extensions supported',
							'dragblock'
						) }
					</small>
				</div>

				<h4>
					{ __(
						'Font face definition for this font file:',
						'dragblock'
					) }
				</h4>

				<div className="form-group">
					<InputControl
						label={ __( 'Font name:', 'dragblock' ) }
						type="text"
						name="font-name"
						id="font-name"
						placeholder={ __( 'Font name', 'dragblock' ) }
						value={ formData.name || '' }
						onChange={ ( val ) =>
							setFormData( { ...formData, name: val } )
						}
					/>
				</div>

				<div className="form-group">
					<SelectControl
						label={ __( 'Font style:', 'dragblock' ) }
						name="font-style"
						id="font-style"
						value={ formData.style || '' }
						onChange={ ( val ) =>
							setFormData( { ...formData, style: val } )
						}
					>
						<option value="normal">Normal</option>
						<option value="italic">Italic</option>
					</SelectControl>
				</div>

				<div className="form-group">
					<InputControl
						label={ __( 'Font weight:', 'dragblock' ) }
						type="text"
						name="font-weight"
						id="font-weight"
						placeholder={ __(
							'Font weight:',
							'dragblock'
						) }
						value={ formData.weight || '' }
						onChange={ ( val ) =>
							setFormData( { ...formData, weight: val } )
						}

					/>
				</div>

				{ formData.variable && (
					<input
						type="hidden"
						name="font-variation-settings"
						value={ fontVariationSettings }
					/>
				) }

				{/* <input
					type="hidden"
					name="font-credits"
					value={ JSON.stringify( formData.fontCredits ) }
				/> */}
			</form>

			<Button
				variant="primary"
				type="submit"
				disabled={ ! isFormValid() }
				form="font-upload-form"
			>
				{ __( 'Upload Font', 'dragblock' ) }
			</Button>
		</>
	);
}

export default UploadFontForm;
