
import { createHigherOrderComponent } from '@wordpress/compose';
import {
	useSetting
} from '@wordpress/block-editor';
import { cloneDeep } from 'lodash';
import { useEffect } from '@wordpress/element';




export function dragBlockAppearanceCSS({ props, colors, contentSize, wideSize }) {
	const { attributes, setAttributes, isSelected, clientId, name } = props;
	let { dragBlockStyles, dragBlockClientId, dragBlockCSS } = attributes;



	let edit_css = '';
	let save_css = '';

	if (dragBlockStyles) {

		let edit_selector = '.wp-block-' + name.replace('core/', '').split('/').join('-') + '[data-dragblock-client-id="' + dragBlockClientId + '"]'; // already modify in BlockListBlock
		/**
		 * Override some specicial blocks that are overridden by load-styles of WordPress
		 */
		if (name === 'core/query-pagination') {
			edit_selector = '.wp-block-query-pagination.block-editor-block-list__layout' + edit_selector;
		}

		let save_selector = '[data-dragblock-client-id="' + dragBlockClientId + '"]';
		if (name === 'core/post-template') {
			save_selector = '.wp-block-post-template' + save_selector;
		}
		const default_self_selector_placeholder = '{default_self_selector}'
		let default_body_tag_selector_placeholder = '{default_body_selector}'
		let default_id_selector_placeholder = '{default_id_selector}';
		

		/**
		 * 
		style = {
			ALL: {// all devices
				selector : { // full selector including parent, parent states and self states. The default_self_selector will be replace later
					slug : value
				}
			}
		}
		 */
		let style = {
			'ALL': {

			}
		}



		let style_props = cloneDeep(dragBlockStyles);

		style_props.reverse();
		for (let prop of style_props) {





			if (
				prop['disabled'] ||
				prop['value'] === ''
			) continue;


			let devices = '';
			if (prop['devices']) {
				if (prop['devices'].indexOf('d') !== -1) devices += 'd';
				if (prop['devices'].indexOf('t') !== -1) devices += 't';
				if (prop['devices'].indexOf('m') !== -1) devices += 'm';
			}
			if (!devices || devices.length === 3) devices = 'ALL';





			let selectors = prop['selectors'] ? prop['selectors'].split(',').map(selector => {


				selector = selector.trim()





				if (selector.indexOf(':') === 0) {
					selector = default_self_selector_placeholder + selector;
				} else {

					if (selector.indexOf('&') !== -1) {



						selector = selector.replace('&', default_self_selector_placeholder);
					}

					else {
						selector = default_self_selector_placeholder + ' ' + selector;
					}
				}


				if (selector.indexOf(default_self_selector_placeholder) === 0) {
					if ((name === 'core/navigation-submenu' || name === 'core/navigation-link')) {
						selector = '.wp-block-navigation ' + selector;
					} else if (name === 'core/navigation') {
						selector = selector.replace(default_self_selector_placeholder, default_self_selector_placeholder + ' .wp-block-navigation__container');
					}
				}




				selector = default_body_tag_selector_placeholder + selector;
				return selector;
			}).join(',') : default_body_tag_selector_placeholder + (
				(((name === 'core/navigation-submenu' || name === 'core/navigation-link')
				) ?
					'.wp-block-navigation ' : ''
				) +


				default_self_selector_placeholder

				+ (
					name === 'core/navigation' ? ' .wp-block-navigation__container' : ''
				)
			) // if missing selector, select self: & 



			selectors = selectors.replaceAll('#', default_id_selector_placeholder);




			if (!style[devices]) style[devices] = {}

			if (!style[devices][selectors]) style[devices][selectors] = {};
			if (!style[devices][selectors][prop.slug]) {
				style[devices][selectors][prop.slug] = '';
			}


			prop.value = String(prop.value);

			if (prop.slug.indexOf('-shadow') !== -1 || prop.slug === 'background-img') {
				style[devices][selectors][prop.slug] += (style[devices][selectors][prop.slug] ? ',' : '') + prop.value;
			}

			else if (prop.slug === 'transform') {
				style[devices][selectors][prop.slug] += (style[devices][selectors][prop.slug] ? ' ' : '') + prop.value;
			}

			else {
				style[devices][selectors][prop.slug] = prop.value;
			}
		}




		/* media: 
			'' || len === 3 => no media
			d = desktop only => @media screen and (min-width: 1025px)
			t = tablet only => @media screen and (min-width: 768px) and (max-width: 1024px)
			m = mobile only => @media screen and (max-width: 767px)
			dt || td = desktop and tablet => @media screen and (min-width: 768px)
			dm || mt = desktop and mobile => @media screen and (min-width: 1025px), screen and (max-width: 767px)
			tm || tm = tablet and mobile => @media screen and (max-width: 1024px)
		*/
		for (let devices in style) {

			let inline_css = '';
			for (let selector in style[devices]) {
				inline_css += (
					selector + '{' +
					Object.entries(style[devices][selector]).map(([key, value]) => (key + ':' + value)).join(';')
					+ '}'
				)
			}
			if (devices === 'ALL') save_css += inline_css;
			if (devices === 'd') save_css += '@media screen and (min-width: 1025px) {' + inline_css + '}';
			if (devices === 't') save_css += '@media screen and (min-width: 768px) and (max-width: 1024px) {' + inline_css + '}';
			if (devices === 'm') save_css += '@media screen and (max-width: 767px) {' + inline_css + '}';
			if (devices === 'dt') save_css += '@media screen and (min-width: 768px) {' + inline_css + '}';
			if (devices === 'dm') save_css += '@media screen and (min-width: 1025px), screen and (max-width: 767px) {' + inline_css + '}';
			if (devices === 'tm') save_css += '@media screen and (max-width: 1024px) {' + inline_css + '}';
		}


		edit_css = save_css;

		for (let color of colors) {

			edit_css = edit_css.replaceAll('{c=' + color.slug + '}', color.color);


			edit_css = edit_css.replaceAll('{c=' + color.slug + '@}', color.color.substring(0, 7));
		}



		edit_css = edit_css.replaceAll(default_self_selector_placeholder, edit_selector)
		edit_css = edit_css.replaceAll(default_body_tag_selector_placeholder, '.editor-styles-wrapper ');
		edit_css = edit_css.replaceAll(default_id_selector_placeholder, '.dragblock-id-classname-placeholder--');



		save_css = save_css.replaceAll(default_self_selector_placeholder, save_selector)
		save_css = save_css.replaceAll(default_body_tag_selector_placeholder, '');
		save_css = save_css.replaceAll(default_id_selector_placeholder, '#');
	}

	useEffect(() => {
		if (dragBlockCSS !== save_css) {
			setAttributes({ dragBlockCSS: save_css });
		}
	});




	if (edit_css) return (
		<>
			<style>{edit_css}</style>
		</>
	)
	return (<></>)
}


/**
 * @info Add setting controls to the Inspector Panels or the Toolbar
 */
const dragBlockAppearanceStyle = createHigherOrderComponent((BlockEdit) => {
	return (props) => {

		const avaiColors = useSetting('color.palette.theme').concat(useSetting('color.palette.custom') || [])/*.concat(useSetting('color.palette.default'));;*/
		const contentSize = useSetting('layout.contentSize');
		const wideSize = useSetting('layout.wideSize');


		return (
			<>
				{/*props.name.indexOf('dragblock') !==-1 */ true && (
					<>
						{dragBlockAppearanceCSS({ props, colors: avaiColors, contentSize, wideSize })}
					</>
				)
				}
				<BlockEdit {...props} />

			</>
		);
	};
}, 'dragBlockAppearanceStyle');

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'dragblock/apperance-style',
	dragBlockAppearanceStyle
);
