/**
 * External dependencies
 */
import { isEmpty } from 'lodash';


export function getIconTypes( icons ) {
	const iconTypes = [];

	icons.forEach( ( type ) => {
		const iconType = type?.type;
		const typeTitle = type?.title ?? type?.type;
		const isDefault = type?.isDefault ?? false;

		if ( ! isEmpty( iconType ) ) {
			iconTypes.push( {
				type: iconType,
				title: typeTitle,
				isDefault,
			} );
		}
	} );

	return iconTypes;
}


export function flattenIconsArray( icons ) {
	let allIcons = [];

	icons.forEach( ( type ) => {
		const iconType = type?.type;
		const iconsOfType = type?.icons;

		if ( ! isEmpty( iconsOfType ) ) {

			iconsOfType.forEach( ( icon ) => {

				if ( ! icon.name.includes( iconType + '-' ) ) {
					icon.name = iconType + '-' + icon.name;
				}
				icon.type = iconType;
			} );


			iconsOfType.sort( function ( a, b ) {
				return a.name.localeCompare( b.name );
			} );

			allIcons = allIcons.concat( iconsOfType );
		}
	} );

	return allIcons;
}


export function simplifyCategories( categories ) {
	const simplifiedCategories = [];

	categories.forEach( ( category ) => {
		if ( category?.name ) {
			simplifiedCategories.push( category.name );
		}
	} );

	return simplifiedCategories;
}
