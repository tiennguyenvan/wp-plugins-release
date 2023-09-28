import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import FontFamily from './font-family';

import DemoTextInput from '../demo-text-input';
import FontsPageLayout from '../fonts-page-layout';
import HelpModal from './help-modal';
import FontsSidebar from '../fonts-sidebar';
import PageHeader from './page-header';
import ConfirmDeleteModal from './confirm-delete-modal';
import { localFileAsThemeAssetUrl } from '../utils';
import './manage-fonts.css';

function ManageFonts() {	
	const nonce = document.querySelector('#nonce').value;


	const themeFontsJsonElement = document.querySelector('#dragblock-font-library-json');


	const manageFontsFormElement =
		document.querySelector('#manage-fonts-form');


	const themeFontsJsonValue = themeFontsJsonElement.innerHTML;

	const themeFontsJson = JSON.parse(themeFontsJsonValue) || [];


	const [newThemeFonts, setNewThemeFonts] = useState(themeFontsJson);


	const [fontToDelete, setFontToDelete] = useState({
		fontFamily: undefined,
		weight: undefined,
		style: undefined,
	});


	const [showConfirmDialog, setShowConfirmDialog] = useState(false);
	const [isHelpOpen, setIsHelpOpen] = useState(false);


	useEffect(() => {

		if (fontToDelete.fontFamily !== undefined) {

			manageFontsFormElement.submit();
		}
	}, [newThemeFonts]);

	

	const toggleIsHelpOpen = () => {
		setIsHelpOpen(!isHelpOpen);
	};

	function requestDeleteConfirmation(fontFamily, weight, style) {
		setFontToDelete(
			{ fontFamily, weight, style },
			setShowConfirmDialog(true)
		);
	}

	function confirmDelete() {
		setShowConfirmDialog(false);

		if (
			fontToDelete.weight !== undefined &&
			fontToDelete.style !== undefined
		) {
			deleteFontFace(
				fontToDelete.fontFamily,
				fontToDelete.weight,
				fontToDelete.style
			);
		} else {
			deleteFontFamily(fontToDelete.fontFamily);
		}
	}

	function cancelDelete() {
		setFontToDelete({});
		setShowConfirmDialog(false);
	}

	function deleteFontFamily(fontFamily) {
		const updatedFonts = newThemeFonts.map((family) => {
			if (
				fontFamily === family.fontFamily ||
				fontFamily === family.name
			) {
				return {
					...family,
					shouldBeRemoved: true,
				};
			}
			return family;
		});
		setNewThemeFonts(updatedFonts);
	}

	function deleteFontFace() {
		const { fontFamily, weight, style } = fontToDelete;
		const updatedFonts = newThemeFonts.reduce((acc, family) => {
			const { fontFace = [], ...updatedFamily } = family;
			if (
				fontFamily === family.fontFamily &&
				fontFace.filter((face) => !face.shouldBeRemoved).length ===
				1
			) {
				updatedFamily.shouldBeRemoved = true;
			}
			updatedFamily.fontFace = fontFace.map((face) => {
				if (
					weight === face.fontWeight &&
					style === face.fontStyle &&
					(fontFamily === family.fontFamily ||
						fontFamily === family.name)
				) {
					return {
						...face,
						shouldBeRemoved: true,
					};
				}
				return face;
			});
			return [...acc, updatedFamily];
		}, []);
		setNewThemeFonts(updatedFonts);
	}


	const fontsOutline = newThemeFonts.reduce((acc, fontFamily) => {
		acc[fontFamily.fontFamily] = {
			family: fontFamily.name || fontFamily.fontFamily,
			faces: (fontFamily.fontFace || []).map((face) => {
				return {
					weight: face.fontWeight,
					style: face.fontStyle,
					src: localFileAsThemeAssetUrl(face.src[0]),
				};
			}),
		};
		return acc;
	}, {});

	return (
		<>
			<HelpModal isOpen={isHelpOpen} onClose={toggleIsHelpOpen} />

			<FontsPageLayout>
				<main>
					<PageHeader toggleIsHelpOpen={toggleIsHelpOpen} />

					<ConfirmDeleteModal
						isOpen={showConfirmDialog}
						onConfirm={confirmDelete}
						onCancel={cancelDelete}
						fontToDelete={fontToDelete}
					/>

					<DemoTextInput />

					{newThemeFonts.length === 0 ? (
						<>
							<p>
								{__(
									'There are no font families installed in DragBlock\'s font library.',
									'dragblock'
								)}
							</p>
						</>

					) : (
						<div className="font-families">
							{newThemeFonts.map((fontFamily, i) => (
								<FontFamily
									fontFamily={fontFamily}
									key={`fontfamily${i}`}
									deleteFont={requestDeleteConfirmation}
								/>
							))}
						</div>
					)}

					<form method="POST" id="manage-fonts-form">
						<input
							type="hidden"
							name="dragblock-font-library-new-font-json"
							value={JSON.stringify(newThemeFonts)}
						/>
						<input type="hidden" name="nonce" value={nonce} />
					</form>
				</main>

				<FontsSidebar
					title={__('Font Library', 'dragblock')}
					fontsOutline={fontsOutline}
					handleDeleteFontFace={requestDeleteConfirmation}
					handleDeleteFontFamily={requestDeleteConfirmation}
				/>
			</FontsPageLayout>
		</>
	);
}

export default ManageFonts;
