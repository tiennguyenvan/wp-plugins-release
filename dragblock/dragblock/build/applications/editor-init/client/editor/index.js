!function(){var t={8546:function(){jQuery((function(){$=jQuery,$(document).on("click change","select[id*=inspector-select-control]",(function(){$(this).find('option[value="Arial, Helvetica, sans-serif"]').length&&($(this).find("option").each((function(){$(this).css("font-family",$(this).attr("value"))})),$(this).css("font-family",$(this).val()).css("font-size","20px"))}))}))}},e={};function i(l){var o=e[l];if(void 0!==o)return o.exports;var n=e[l]={exports:{}};return t[l](n,n.exports,i),n.exports}!function(){"use strict";i(8546);var t=window.lodash,e=window.wp.i18n;!function(i){i(document).on("mousedown mouseenter keydown",".edit-site-header-edit-mode__list-view-toggle, .edit-site-editor__list-view-panel-content, .block-editor-list-view-block-select-button",(function(){let t=setInterval((function(){i(document).find(".block-editor-list-view-block-select-button:not(.dragblock-list-view-optimized)").length&&(clearInterval(t),l(),o())}))}));let l=()=>{i(document).find(".block-editor-list-view-block-select-button").each((function(){var e;if(i(this).hasClass("dragblock-list-view-optimized"))return;let l=i(this).attr("href");if(!l||-1===l.indexOf("#block-"))return;l=l.split("#block-")[1],i(this).find(".block-editor-list-view-block-select-button__title .components-truncate").attr("data-blockClientId",l),i(this).find(".block-editor-list-view-block-select-button__anchor").attr("data-blockClientId",l),i(this).attr("title",i(this).find(".block-editor-list-view-block-select-button__title").text()),i(this).find(".block-editor-list-view-block-select-button__title .components-truncate").each((function(){i(this).attr("data-title",i(this).text())})),i(this).addClass("dragblock-list-view-optimized");let o=wp.data.select("core/block-editor").getBlockAttributes(l);if(!o)return;let n=o.className,c=null!==(e=o.dragBlockTagName)&&void 0!==e?e:"";if("div"===c&&(c=""),n)n="."+n.split(" ").join("."),i(this).find(".block-editor-list-view-block-select-button__title .components-truncate").text(c+n);else{let e=function(e){if(!(0,t.isArray)(e)||!e.length)return"";let i="",l="";for(let t of e)if(t.slug&&t.value&&!t.disable&&(i||(i=t.value),t.slug===dragBlockEditorInit.siteLocale)){l=t.value;break}return l||(l=i),l}(o.dragBlockText);e?(e.length>50&&(e=e.substring(0,20)+"..."),i(this).find(".block-editor-list-view-block-select-button__title .components-truncate").text('"'+e+'"')):c&&i(this).find(".block-editor-list-view-block-select-button__title .components-truncate").text(c)}}))},o=()=>{i(document).find(".block-editor-list-view-block-select-button").each((function(){let t=i(this).attr("href");if(!t||-1===t.indexOf("#block-"))return;t=t.split("#block-")[1];let e=wp.data.select("core/block-editor").getBlockAttributes(t);if(!e)return;const l="dragblock-has-queries",o=e.dragBlockQueries||null;if(o&&o.length){for(let t of o){const{slug:e,disabled:o}=t;if(!o&&"parse_item"!==e)return void i(this).addClass(l)}i(this).removeClass(l)}else i(this).removeClass(l)}))};i(document).on("dblclick",".block-editor-list-view-block-select-button__title .components-truncate",(function(l){let o=i(this).attr("data-blockClientId");if(!o)return;let n=wp.data.select("core/block-editor").getBlockAttributes(o);if(!n)return;let c=n.className,s=n.dragBlockTagName?n.dragBlockTagName:"";"div"===s&&(s="");{let l=prompt((0,e.__)("Please enter class names","dragblock"),c);if(null===l)return;return l=null===(r=l)?"":r.trim().split(" ").map((t=>function(t){return t.trim().toLowerCase().replace(/[^a-zA-Z0-9_-]/g,"-")}(t))).join(" "),void(l!==c&&(n.className=l,wp.data.dispatch("core/block-editor").updateBlockAttributes(o,(0,t.cloneDeep)(n)),l?i(this).text(s+"."+l.split(" ").join(".")):i(this).text(s+i(this).attr("data-title"))))}var r})),i(document).on("dblclick",".block-editor-list-view-block-select-button__anchor",(function(l){let o=i(this).attr("data-blockClientId");if(!o)return;let n=wp.data.select("core/block-editor").getBlockAttributes(o);if(!n)return;let c=n.anchor,s=prompt((0,e.__)("Please enter an anchor","dragblock"),c);null!==s&&s!==c&&(n.anchor=s,wp.data.dispatch("core/block-editor").updateBlockAttributes(o,(0,t.cloneDeep)(n)),s?i(this).html(s.split(" ").join("#")):i(this).html(""))}))}(jQuery)}()}();