/**
 * External dependencies
 */
import classnames from 'classnames';
import { isEmpty } from 'lodash';

/**
 * WordPress dependencies
 */
import { __, _n, sprintf } from '@wordpress/i18n';
import {
	Button,
	MenuGroup,
	MenuItem,
	Modal,
	RangeControl,
	SearchControl,
} from '@wordpress/components';
import { renderToString, useState } from '@wordpress/element';
import { Icon, blockDefault } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import getIcons from './../icons';
import parseIcon from './../utils/parse-icon';
import {
	flattenIconsArray,
	getIconTypes,
	simplifyCategories,
} from './../utils/icon-functions';

export default function InserterModal(props) {
	const { isInserterOpen, setInserterOpen, attributes, setAttributes } = props;
	const iconsByType = getIcons();
	const iconTypes = getIconTypes(iconsByType);


	let defaultType = iconTypes.filter((type) => type.isDefault);
	defaultType = defaultType.length !== 0 ? defaultType : [iconTypes[0]];

	const [searchInput, setSearchInput] = useState('');
	const [currentCategory, setCurrentCategory] = useState(
		'all__' + defaultType[0]?.type
	);
	const [iconSize, setIconSize] = useState(24);

	if (!isInserterOpen) {
		return null;
	}


	const iconsAll = flattenIconsArray(iconsByType);
	let shownIcons = [];


	if (searchInput) {
		shownIcons = iconsAll.filter((icon) => {
			const input = searchInput.toLowerCase();
			const iconName = icon.title.toLowerCase();


			if (iconName.includes(input)) {
				return true;
			}


			if (icon?.keywords && !isEmpty(icon?.keywords)) {
				const keywordMatches = icon.keywords.filter((keyword) =>
					keyword.includes(input)
				);

				return !isEmpty(keywordMatches);
			}

			return false;
		});
	}


	if (!searchInput) {

		if (currentCategory.startsWith('all__')) {
			const categoryType = currentCategory.replace('all__', '');
			const allIconsOfType =
				iconsByType.filter(
					(type) => type.type === categoryType
				)[0]?.icons ?? [];
			shownIcons = allIconsOfType;
		} else {
			shownIcons = iconsAll.filter((icon) => {
				const iconCategories = icon?.categories ?? [];


				if (iconCategories.includes(currentCategory)) {
					return true;
				}

				return false;
			});
		}
	}

	const preparedTypes = [];

	iconsByType.forEach((type) => {
		const title = type?.title ?? type.type;
		const categoriesFull = type?.categories ?? [];
		const categories = simplifyCategories(categoriesFull);
		const allCategory = 'all__' + type.type;
		const iconsOfType = type?.icons ?? [];


		if (!categories.includes(allCategory)) {
			categories.sort().unshift(allCategory);
			categoriesFull.unshift({
				name: allCategory,
				title: __('All', 'dragblock'),
			});
		}

		preparedTypes.push({
			type: type.type,
			title,
			categoriesFull,
			categories,
			count: iconsOfType.length,
		});
	});




	function onClickCategory(category) {
		setCurrentCategory(category);
	}

	function renderIconTypeCategories(type, key) {
		return (
			<MenuGroup
				key={key}
				className="icon-inserter__sidebar__category-type"
				label={type.title}
			>
				{type.categories.map((category, _i) => {
					const isActive = currentCategory
						? category === currentCategory
						: category === 'all__' + type.type;

					const categoryIcons = iconsAll.filter((icon) => {
						const iconCats = icon?.categories ?? [];
						return (
							icon.type === type.type &&
							iconCats.includes(category)
						);
					});

					const categoryTitle =
						type.categoriesFull.filter(
							(c) => c.name === category
						)[0]?.title ?? category;

					return (
						<MenuItem
							key={_i}
							className={classnames({
								'is-active': isActive,
							})}
							onClick={() => onClickCategory(category)}
							isPressed={isActive}
						>
							{categoryTitle}
							<span>
								{category === 'all__' + type.type
									? type.count
									: categoryIcons.length}
							</span>
						</MenuItem>
					);
				})}
			</MenuGroup>
		);
	}

	const searchResults = (
		<div className="icons-list">
			{shownIcons.map((icon, _i) => {
				let renderedIcon = icon.icon;


				if (typeof renderedIcon === 'string') {
					renderedIcon = parseIcon(renderedIcon);
				}



				return (
					<Button
						key={_i}
						className='icons-list__item'
						onClick={() => {							
							setAttributes({ icon: renderToString(icon.icon) });
							setInserterOpen(false);
						}}
					>
						<span className="icons-list__item-icon">
							<Icon icon={renderedIcon} size={iconSize} />
						</span>
						<span className="icons-list__item-title">
							{icon?.title ?? icon.name}
						</span>
					</Button>
				);
			})}
		</div>
	);

	const noResults = (
		<div className="block-editor-inserter__no-results">
			<Icon
				icon={blockDefault}
				className="block-editor-inserter__no-results-icon"
			/>
			<p>{__('No results found.', 'block-icon')}</p>
		</div>
	);


	return (
		<Modal
			className="wp-block-dragBlock-icon-inserter__modal"
			title={__('Icon Library', 'dragblock')}
			onRequestClose={() => setInserterOpen(false)}
			isFullScreen
		>
			<div
				className={classnames('icon-inserter', {
					'is-searching': searchInput,
				})}
			>
				<div className="icon-inserter__sidebar">
					<div className="icon-inserter__sidebar__search">
						<SearchControl
							value={searchInput}
							onChange={setSearchInput}
						/>
					</div>
					{preparedTypes.map((type, key) =>
						renderIconTypeCategories(type, key)
					)}
				</div>
				<div className="icon-inserter__content">
					<div className="icon-inserter__content-header">
						<div className="search-results">
							{searchInput &&
								sprintf(

									_n(
										'%1$s search result for "%2$s"',
										'%1$s search results for "%2$s"',
										shownIcons.length,
										'dragblock'
									),
									shownIcons.length,
									searchInput
								)}
						</div>
						<div className="icon-controls">
							<div className="icon-controls__size">
								<span>
									{__('Preview size', 'dragblock')}
								</span>
								<RangeControl
									min={24}
									max={72}
									initialPosition={24}
									withInputField={false}
									onChange={(value) =>
										setIconSize(value)
									}
								/>
							</div>
						</div>
					</div>
					<div className="icon-inserter__content-grid">
						{isEmpty(shownIcons) ? noResults : searchResults}

					</div>
				</div>
			</div>
		</Modal>
	);
}
