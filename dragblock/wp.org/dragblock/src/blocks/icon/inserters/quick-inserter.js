/**
 * External dependencies
 */
import classnames from 'classnames';
import { isEmpty } from 'lodash';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button, Popover, SearchControl } from '@wordpress/components';
import { renderToString, useState } from '@wordpress/element';
import { Icon, blockDefault } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import getIcons from './../icons';
import parseIcon from './../utils/parse-icon';
import { flattenIconsArray } from './../utils/icon-functions';

export function QuickInserterPopover( props ) {
	const [ searchInput, setSearchInput ] = useState( '' );
	const {
		setInserterOpen,
		isQuickInserterOpen,
		setQuickInserterOpen,
		setAttributes,
	} = props;

	if ( ! isQuickInserterOpen ) {
		return null;
	}

	

	const iconsByType = getIcons();
	const iconsAll = flattenIconsArray( iconsByType );



	const iconsOfDefaultType =
		iconsByType.filter( ( t ) => t.isDefault )[ 0 ]?.icons ?? iconsAll;

	let shownIcons = [];

	if ( searchInput ) {
		shownIcons = iconsAll.filter( ( icon ) => {
			const input = searchInput.toLowerCase();
			const iconName = icon.title.toLowerCase();


			if ( iconName.includes( input ) ) {
				return true;
			}


			if ( icon?.keywords && ! isEmpty( icon?.keywords ) ) {
				const keywordMatches = icon.keywords.filter( ( keyword ) =>
					keyword.includes( input )
				);

				return ! isEmpty( keywordMatches );
			}

			return false;
		} );
	}

	if ( ! searchInput ) {

		const defaultIcons =
			iconsOfDefaultType.filter( ( i ) => i.isDefault ) ?? [];


		const nonDefaultIcons =
			iconsOfDefaultType.filter( ( i ) => ! i.isDefault ) ?? [];


		shownIcons = shownIcons.concat( defaultIcons, nonDefaultIcons );
	}


	shownIcons = shownIcons.slice( 0, 6 );

	const searchResults = (
		<div className="block-editor-inserter__panel-content">
			<div className="icons-list">
				{ shownIcons.map( ( icon, _i ) => {
					let renderedIcon = icon.icon;

					if ( typeof renderedIcon === 'string' ) {
						renderedIcon = parseIcon( renderedIcon );
					}

					return (
						<Button
							key={ _i }
							label={ __( 'Insert Icon', 'dragblock' ) }
							className='icons-list__item'
							onClick={ () => {
								
								setAttributes( {
									icon: renderToString(icon.icon)									
								} );
								setInserterOpen( false );								
								setQuickInserterOpen( false );
								setSearchInput( '' );
							} }
						>
							<span className="icons-list__item-icon">
								<Icon icon={ renderedIcon } />
							</span>
							<span className="icons-list__item-title">
								{ icon.title }
							</span>
						</Button>
					);
				} ) }
			</div>
		</div>
	);

	const noResults = (
		<div className="block-editor-inserter__no-results">
			<Icon
				icon={ blockDefault }
				className="block-editor-inserter__no-results-icon"
			/>
			<p>{ __( 'No results found.', 'block-icon' ) }</p>
		</div>
	);

	return (
		<Popover
			className="wp-block-dragBlock-icon-inserter__quick-inserter block-editor-inserter__popover is-quick"
			onClose={ () => setQuickInserterOpen( false ) }
			position="bottom right"
		>
			<div className="block-editor-inserter__quick-inserter">
				<SearchControl
					className="block-editor-inserter__search"
					label={ __( 'Search icons', 'dragblock' ) }
					hideLabelFromVision={ true }
					value={ searchInput }
					onChange={ ( value ) => setSearchInput( value ) }
				/>
				<div className="block-editor-inserter__quick-inserter-results">
					{ isEmpty( shownIcons ) ? noResults : searchResults}
				</div>
				<Button
					className="block-editor-inserter__quick-inserter-expand"
					onClick={ () => {
						setInserterOpen( true );
						setQuickInserterOpen( false );
						setSearchInput( '' );
					} }
				>
					{ __( 'Browse all', 'dragblock' ) }
				</Button>
			</div>
		</Popover>
	);
}
