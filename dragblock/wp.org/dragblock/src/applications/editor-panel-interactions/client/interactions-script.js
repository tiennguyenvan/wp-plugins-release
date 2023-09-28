
import { createHigherOrderComponent } from '@wordpress/compose';
import { useEffect, useState } from '@wordpress/element'
import {
	useSetting
} from '@wordpress/block-editor';
import { cloneDeep } from 'lodash';
import body from '@wordpress/components/build/panel/body';



const compileAction = (target, action, value) => {

	let trimedValue = value.replaceAll('.', '').replaceAll('#', '').trim();
	let compliedCode = '';
	switch (action) {
		case 'toggleClass':
			compliedCode += `${target}.classList.toggle('${trimedValue}');`;
			break;
		case 'toggleId':
			compliedCode += `if(${target}.id!=='${trimedValue}'){${target}.id='${trimedValue}'}else{${target}.id=''}`;
			break;

		case 'addClass':
			compliedCode += `${target}.classList.add('${trimedValue}');`;
			break;

		case 'addId':
			compliedCode += `${target}.id='${trimedValue}';`;
			break;


		case 'removeClass':
			compliedCode += `${target}.classList.remove('${trimedValue}');`;
			break;

		case 'removeId':
			compliedCode += `if(${target}.id!=='${trimedValue}'){${target}.id=''}`;
			break;

	}
	/**
	 * Atributes
	 */




	return compliedCode;
}

/**
 * 
 * @param {*} trigger 
 * @param {*} save_selector 
 * @returns 
 */
const compileTriggers = (trigger, save_selector) => {
	const {
		slug, // multiple triggers could have the same slug
		eventSource,
		conditions,
		thenActions,
		elseActions,









		disabled
	} = trigger


	const condName = conditions && conditions[0] && conditions[0].name ? conditions[0].name : '';
	const condValue = conditions && conditions[0] && conditions[0].value ? conditions[0].value : '';
	const condTarget = conditions && conditions[0] && conditions[0].target ? conditions[0].target : '';

	const thenActName = thenActions && thenActions[0] && thenActions[0].name ? thenActions[0].name : '';
	const thenActValue = thenActions && thenActions[0] && thenActions[0].value ? thenActions[0].value : '';
	const thenActTarget = thenActions && thenActions[0] && thenActions[0].target ? thenActions[0].target : '';

	const elseActName = elseActions && elseActions[0] && elseActions[0].name ? elseActions[0].name : '';
	const elseActValue = elseActions && elseActions[0] && elseActions[0].value ? elseActions[0].value : '';
	const elseActTarget = elseActions && elseActions[0] && elseActions[0].target ? elseActions[0].target : '';


	let eventSourceSelector = (eventSource || save_selector);
	let condTarget1Selector = (condTarget || save_selector);
	let thenActTargetSelector = (thenActTarget || save_selector);
	let elseActTargetSelector = (elseActTarget || save_selector);

	let saveCode = '';
	let condCode = '';
	let thenActCode = '';
	let elseActCode = '';


	if (condName && condName === 'is' && condValue) {
		let target = 'this';
		if (condTarget1Selector !== eventSourceSelector) {
			target = 'condTarget';
			condCode += `let ${target}=document.querySelector('${condTarget1Selector}');`;
		}
		condCode += `if(${target}&&${target}.matches('${condValue}')`;

	}


	if (thenActName && thenActValue) {
		let target = 'this';
		if (thenActTargetSelector !== eventSourceSelector) {
			target = 'thenActTarget';
			thenActCode += `let ${target}=document.querySelector('${thenActTargetSelector}');`;
			thenActCode += `if(${target}){`;

		}

		thenActCode += compileAction(target, thenActName, thenActValue);

		if (target !== 'this') {
			thenActCode += '}';
		}


	}


	if (elseActName && elseActValue) {
		let target = 'this';
		if (elseActTargetSelector !== eventSourceSelector) {
			target = 'elseActTarget';
			elseActCode += `let ${target}=document.querySelector('${elseActTargetSelector}');`;
			elseActCode += `if(${target}){`;

		}

		elseActCode += compileAction(target, elseActName, elseActValue);

		if (target !== 'this') {
			elseActCode += '}';
		}


	}



	if (condCode) saveCode += condCode + '{' + thenActCode + '}'
	else saveCode += thenActCode
	if (condCode && elseActCode) saveCode += 'else {' + elseActCode + '}';

	return saveCode;
}


/**
 * 
 * @param {*} props 
 * @returns 
 */
export function dragBlockInteractionsJS(props) {
	const { attributes, setAttributes, isSelected, clientId, name } = props;
	let { dragBlockScripts, dragBlockClientId, dragBlockJS } = attributes;

	if (name === 'core/navigation-link') {
		console.log('dragBlockScripts', dragBlockScripts);
	}

	let compiledJS = '';


	if (dragBlockScripts && dragBlockScripts.length > 0) {
		let save_selector = `[data-dragblock-client-id="${dragBlockClientId}"]`;
		let savedTriggers = {}


		let elementSelectorObj = `window['${dragBlockClientId}']`;


		for (let trigger of dragBlockScripts) {
			if (!trigger['slug'] || trigger['disabled']) continue;

			if (!savedTriggers[trigger['slug']]) savedTriggers[trigger['slug']] = '';

			savedTriggers[trigger['slug']] += compileTriggers(trigger, save_selector);
		}

		for (let slug in savedTriggers) {
			if (!savedTriggers[slug]) continue;
			compiledJS += `${elementSelectorObj}=document.querySelector('${save_selector}');`;

			compiledJS += `${elementSelectorObj}.addEventListener('${slug}',function(){${savedTriggers[slug]}});`;
		}






	}

	useEffect(() => {
		if (name === 'core/navigation-link') {
		}
		if (compiledJS !== dragBlockJS) {
			setAttributes({ dragBlockJS: compiledJS })
		}
	});








	return props;
}


/**
 * https://wordpress.org/support/topic/remove-block-editor-inner-blocks-and-block-editor-block-list__layout/#post-16582721
 * @info Add setting controls to the Inspector Panels or the Toolbar
 */
const dragBlockInteractionsScript = createHigherOrderComponent((BlockEdit) => {
	return (props) => {

		dragBlockInteractionsJS(props);
		return (
			<>
				<BlockEdit {...props} />
				{/* <img onLoad={onload} src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style={...{display: none}}/> */}
			</>
		);
	};
}, 'dragBlockInteractionsScript');

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'dragblock/interactions-script',
	dragBlockInteractionsScript
);
