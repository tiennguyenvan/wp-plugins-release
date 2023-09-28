import { __ } from '@wordpress/i18n';

export const interactionsNames = {
	/**
	 * LINK
	 */
	'click': {
		keyword: 'mouse click',
		label: __('Click', 'dragblock'),
		note: __('Mouse Click', 'dragblock'),
		type: 'mouse'
	},
	'mouseenter': {
		keyword: 'mouse enter',
		label: __('MouseEnter', 'dragblock'),
		note: __('Mouse Enter an Element', 'dragblock'),
		type: 'mouse'
	},
	'mouseleave': {
		keyword: 'mouse leave',
		label: __('MouseLeave', 'dragblock'),
		note: __('Mouse Leave an Element', 'dragblock'),
		type: 'mouse'
	}
}

/**
 * @info register custom HTML interactions and supports features
 */
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'dragblock/interactions-register',
	function (settings, name) {

		settings = Object.assign({}, settings, {

			attributes: Object.assign({}, settings.attributes, {











				/**
				**** SUPER SIMPLE VERSIONS ********************************
				dragBlockScripts : [
					{						
						slug: 'onClick',						
						which: '', // right click, cltr+C, ...
						source: '',
						action: 'toggle'
						value: '.active',
						target: '',
						disabled: ''
					}
				]

				**** SIMPLE VERSIONS ********************************
				dragBlockScripts [
					{
						events: [
							{
								type: 'mouse'
								value: 'click'
							}							
						],
						actions: [
							{
								type: 'toggle',
								value: '.active'
							}
						],
						disabled: [
							'*'
						]
					}
				]

				**** COMPLICATEED
				dragBlockScripts: [
					{						
						name: 'Open Mobile Menu',
						id: 'unique-ID',						
						events: [
							{
								type: ['click', 'ctrl+m'],
								on: '.mobile-menu-toggle'
							},
							{
								type: ['and']
								events: [
									{																				
										'type': ['click', 'click+ctrl+p', 'onload'],
										'source': '.main-menu'
									},
								]
							}
						],
						conditions: [
							{
								type: 'isDevice',
								device: ['mobile']
							}
						],
						actions: [
							{
								type: 'toggleClass',
								class: '.active',
								apply-to: '.mobile-menu'
							}
						],
						else-actions: [

						]
						disabled: '' // f = disabled on front-end, b = disabled on back-end, * = disabled on all
					}
				]				
				 */
				
				dragBlockScripts: {type: 'array',default: '',},
				dragBlockJS: { type: 'string', default: '' },
				/*
				SHORT JAVASCRIPT				
				We think that the best way for users to develop complicated apps
				is to allow them to type the code with lots of support from our
				tools. This method offers them freedom, flexibility, and also allows
				us to parse the code easier.
				It's also very easy for users to copy/paste code to another blocks/projects
				You should consider of using this method for dragBlockStyles because out of
				the above benefits, developers could edit the code themselves 

				However, building this type of language would take time so we could stick with
				the same methods as dragBlockStyles or dragBlockAttrs, but then if we have more resources
				we could cover all dragBlockScripts intances into this SJS language.

				
				*/




			}),
		});





















































		return settings;
	}
);


