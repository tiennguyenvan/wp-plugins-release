import {

	__experimentalConfirmDialog as ConfirmDialog,
} from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';

function ConfirmDeleteModal( { isOpen, onConfirm, onCancel, fontToDelete } ) {
	const deleteFontFaceMessage = sprintf(

		__(
			`Are you sure you want to delete "%1$s - %2$s" variant of "%3$s" from the DragBlock\'s font library?`,
			'dragblock'
		),
		fontToDelete?.weight,
		fontToDelete?.style,
		fontToDelete?.fontFamily
	);

	const deleteFontFamilyMessage = sprintf(

		__(
			`Are you sure you want to delete "%s" from the DragBlock\'s font library?`,
			'dragblock'
		),
		fontToDelete?.fontFamily
	);

	return (
		<ConfirmDialog
			isOpen={ isOpen }
			onConfirm={ onConfirm }
			onCancel={ onCancel }
		>
			{ fontToDelete?.weight !== undefined &&
			fontToDelete.style !== undefined ? (
				<h3>{ deleteFontFaceMessage }</h3>
			) : (
				<h3>{ deleteFontFamilyMessage }</h3>
			) }
			<p>
				{ __(
					'This action will delete the font definition and the font file assets from the DragBlock\'s font library',
					'dragblock'
				) }
			</p>
		</ConfirmDialog>
	);
}

export default ConfirmDeleteModal;
