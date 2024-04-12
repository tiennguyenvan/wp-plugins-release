!function(){var e={4184:function(e,t){var r;!function(){"use strict";var o={}.hasOwnProperty;function a(){for(var e=[],t=0;t<arguments.length;t++){var r=arguments[t];if(r){var l=typeof r;if("string"===l||"number"===l)e.push(r);else if(Array.isArray(r)){if(r.length){var n=a.apply(null,r);n&&e.push(n)}}else if("object"===l){if(r.toString!==Object.prototype.toString&&!r.toString.toString().includes("[native code]")){e.push(r.toString());continue}for(var c in r)o.call(r,c)&&r[c]&&e.push(c)}}}return e.join(" ")}e.exports?(a.default=a,e.exports=a):void 0===(r=function(){return a}.apply(t,[]))||(e.exports=r)}()}},t={};function r(o){var a=t[o];if(void 0!==a)return a.exports;var l=t[o]={exports:{}};return e[o](l,l.exports,r),l.exports}r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,{a:t}),t},r.d=function(e,t){for(var o in t)r.o(t,o)&&!r.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){"use strict";var e=window.wp.blocks,t=window.wp.element,o=window.wp.i18n,a=window.wp.richText,l=window.wp.blockEditor,n=(window.wp.hooks,window.wp.components),c=window.lodash,s=r(4184),i=r.n(s);function d({placeholder:e,onSelect:r,className:a,popOverClassName:l,icon:c,label:s,text:d,showTrigger:g,position:u,toolbarButton:b,suggestions:p}){const[k,_]=(0,t.useState)(0),[h,m]=(0,t.useState)(""),[B,f]=(0,t.useState)({}),[D,v]=(0,t.useState)(!1),[w,y]=(0,t.useState)(!1),[E,S]=(0,t.useState)([]),[T,N]=(0,t.useState)(null),[C,P]=(0,t.useState)(!1),x=()=>{v(!1)},j=()=>{let e={};for(let t in p){if(Object.keys(e).length>12)break;e[t]=p[t]}f(e),v(!0)},O=e=>{r(e),f({}),m(""),x()};let L=null,R="";if(p){if("string"==typeof p){if(R=p,p={},E&&E.length)for(let e of E)p[e.value]={label:e.label,note:e.note};switch(R){case"categories":p["[dragblock.post.cat.id]"]={label:(0,o.__)("Post Category ID"),note:(0,o.__)("Current Post Category ID")};break;case"tags":p["[dragblock.post.tag.id]"]={label:(0,o.__)("Post Tag ID"),note:(0,o.__)("Current Post Tag ID")};break;case"authors":p["[dragblock.post.author.id]"]={label:(0,o.__)("Post Author ID"),note:(0,o.__)("Current Post Author ID")}}}}else p={};const I=e=>{if(!e||!p||0===p.length)return void f({});let t=e.toLowerCase().trim().replace(/-/gi," ").split(" ").map((e=>e.trim())),r=t.join("").replace(/ /gi,""),o={},a=0;for(let e in p){let l="string"==typeof p[e]?p[e].toLowerCase():Object.values(p[e]).join(" ").toLowerCase(),n=!0;if(-1===l.replace(/ /gi,"").replace(/-/gi,"").indexOf(r))for(let e of t)if(-1===l.indexOf(e)){n=!1;break}if(n&&(o[e]=p[e],++a>=12))break}f(o)};return(0,t.createElement)("div",{className:i()("dragblock-autocomplete-search-box"+(a?" "+a:""),{"show-trigger":g})},b?(0,t.createElement)(n.ToolbarButton,{icon:c,iconSize:"24",label:s,className:"fake-search-button",variant:"secondary",onClick:()=>{C?P(!1):j()}}):(0,t.createElement)(n.Button,{icon:c,iconSize:"24",label:s,className:"fake-search-button",variant:"secondary",onClick:()=>{C?P(!1):j()}},d||(c?"":e)),D?(0,t.createElement)(n.Popover,{position:u||"bottom center",onFocusOutside:()=>{x()},onMouseMove:e=>{null!==L||(L={X:e.clientX,Y:e.clientY})},onClose:()=>{x()},onMouseLeave:e=>{null!==L&&L.X!==e.clientX&&L.Y!==e.clientY&&x()},className:i()("dragblock-autocomplete-search-box-popover"+(l?" "+l:""),{"show-trigger":g})},(0,t.createElement)(n.SearchControl,{onKeyDown:e=>{if("ArrowUp"===e.key)_(0===k?Object.keys(B).length-1:k-1);else if("ArrowDown"===e.key)k>=Object.keys(B).length-1?_(0):_(k+1);else if("Enter"===e.key){let e=Object.keys(B);if(k<0||e.length-1<k)return;let t=e[k];O(t),P(!0),x()}},placeholder:e,value:h,onChange:e=>{R?(y(!0),f([]),T&&clearTimeout(T),N(setTimeout((()=>{((e,t)=>{if(!e||!t)return void S([]);const r=new URLSearchParams({search:e,per_page:12,_locale:"users"});wp.apiFetch({path:`/wp/v2/${t}?${r.toString()}`}).then((r=>{S(r.map((e=>({label:e.name,value:e.id,note:e.description})))),r.map((e=>{p[e.id]={label:e.name,note:e.description}})),((e,t)=>{window["dragblock-query-objects"]||(window["dragblock-query-objects"]=new Object),window["dragblock-query-objects"][e]||(window["dragblock-query-objects"][e]=new Object);for(let r of t)r&&r.id&&(window["dragblock-query-objects"][e][r.id]=r)})(t,r),I(e),y(!1)})).catch((e=>{y(!1),S([])}))})(e,R)}),1e3))):I(e),m(e)}}),R&&h&&(0,t.createElement)("div",{className:"results"},!0===w?(0,t.createElement)(t.Fragment,null,(0,o.__)("Fetching...","dragblock")):(0,t.createElement)(t.Fragment,null,0===Object.keys(p).length&&(0,t.createElement)(t.Fragment,null,(0,o.__)("Not found any","dragblock")))),0!==Object.entries(B).length&&(0,t.createElement)("div",{className:"results"},Object.entries(B).map((([e,r],o)=>{let a=e,l=e;return"string"==typeof r?l=r:(r.note?a=r.note:r.label&&(a=r.label),r.label&&(l=r.label)),(0,t.createElement)("div",{key:o,className:"item",onMouseEnter:()=>{_(o)}},(0,t.createElement)("a",{className:i()("item-link",{active:k===o}),onClick:()=>{O(e)}},(0,t.createElement)("code",null,l)))})))):null)}const g={"[dragblock.home.url]":{label:(0,o.__)("Home URL","dragblock"),note:(0,o.__)("Home URL","dragblock"),render:e=>{}},"[dragblock.form.message.error]":{label:(0,o.__)("Form Submission Error Message","dragblock"),note:(0,o.__)("Error message after submitting form","dragblock"),placeholder:(0,o.__)("DragBlock Form Error: There is an uknown server error.","dragblock"),render:e=>{}},"[dragblock.post.title]":{label:(0,o.__)("Post Title","dragblock"),note:(0,o.__)("The parsed post's Title","dragblock"),placeholder:(0,o.__)("The DragBlock Post Title","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.title)return _DragBlockDB.post.title}},"[dragblock.post.url]":{label:(0,o.__)("Post URL","dragblock"),note:(0,o.__)("The parsed post's url","dragblock"),render:e=>{}},"[dragblock.post.image.src]":{label:(0,o.__)("Post Image Thumbnail SRC","dragblock"),note:(0,o.__)("the parsed post's image src","dragblock"),render:e=>_DragBlockDB.post&&_DragBlockDB.post.image_src?_DragBlockDB.post.image_src:""},"[dragblock.post.author.url]":{label:(0,o.__)("Post Author URL","dragblock"),note:(0,o.__)("the parsed post's author page url","dragblock"),render:e=>{}},"[dragblock.post.author.name]":{label:(0,o.__)("Post Author Name","dragblock"),note:(0,o.__)("The parsed post's author name","dragblock"),placeholder:(0,o.__)("Author Name","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_name)return _DragBlockDB.post.author_name}},"[dragblock.post.author.avatar.src]":{label:(0,o.__)("Post Author Avatar SRC","dragblock"),note:(0,o.__)("The parsed post's author's avatar SRC","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_avatar_src)return _DragBlockDB.post.author_avatar_src}},"[dragblock.post.author.bio]":{label:(0,o.__)("Post Author Bio","dragblock"),note:(0,o.__)("The parsed post's author's biography/description","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_bio)return _DragBlockDB.post.author_bio}},"[dragblock.post.date]":{label:(0,o.__)("Post Date Name","dragblock"),note:(0,o.__)("The parsed post's date","dragblock"),placeholder:(0,o.__)("July 01, 2086","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.date)return _DragBlockDB.post.date}},"[dragblock.post.comment.number]":{label:(0,o.__)("Post Comment Number","dragblock"),note:(0,o.__)("The parsed post's comment number","dragblock"),placeholder:"0",render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.comment_number)return _DragBlockDB.post.comment_number}},"[dragblock.post.snippet]":{label:(0,o.__)("Post Snippet","dragblock"),note:(0,o.__)("The parsed post's snippet","dragblock"),placeholder:(0,o.__)("Get the first paragraph of the post content. If the post excerpt, a custom summary of the post that author manually inputted when composing the post content, exists, use that instead","dragblock"),render:e=>{if(!_DragBlockDB.post||!_DragBlockDB.post.snippet)return;let t=_DragBlockDB.post.snippet;if(e&&e.len&&!isNaN(e.len)&&t.length>Number(e.len)){let r="",o=Number(e.len);t.split(" ").map((e=>{r.length<o?r+=(r?" ":"")+e:e.endsWith(",")||e.endsWith("!")||e.endsWith(".")||e.endsWith(":")||e.endsWith("?")||e.endsWith(";")||(r+=(r?" ":"")+e)})),t=t.substring(0,Number(e.len))}return t}},"[dragblock.post.cat.name]":{label:(0,o.__)("Post Category Name","dragblock"),placeholder:(0,o.__)("Category Name","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.cat_name)return _DragBlockDB.post.cat_name}},"[dragblock.post.cat.url]":{label:(0,o.__)("Post Category URL","dragblock"),render:e=>{}},"[dragblock.post.tag.name]":{label:(0,o.__)("Post Tag Name","dragblock"),placeholder:(0,o.__)("Tag Name","dragblock"),render:e=>{}},"[dragblock.post.tag.url]":{label:(0,o.__)("Post Tag URL","dragblock"),render:e=>{}},"[dragblock.share.url.twitter]":{label:(0,o.__)("Twitter Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.facebook]":{label:(0,o.__)("Facebook Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.whatsapp]":{label:(0,o.__)("Whatsapp Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.telegram]":{label:(0,o.__)("Telegram Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.tumblr]":{label:(0,o.__)("Tumblr Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.reddit]":{label:(0,o.__)("Reddit Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.linkedin]":{label:(0,o.__)("LinkedIn Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.gmail]":{label:(0,o.__)("Gmail Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.navigator]":{label:(0,o.__)("Navigator Share URL","dragblock"),render:e=>{}}};function u(e){const t=e.match(/(\w+)=(['"]?)([^\s'"]+)\2/g);if(!t)return{};const r={};return t.forEach((e=>{const[t,o]=e.split("=");r[t]=o.replace(/['"]/g,"")})),r}(0,a.registerFormatType)("dragblock/richtext-shortcode-inserter",{title:"Insert Icon",tagName:"span",className:"dragblock-shortcode",edit:e=>{const{isActive:r,onChange:a,value:n}=e;return(0,t.createElement)(l.BlockControls,null,(0,t.createElement)(d,{toolbarButton:!0,position:"bottom right",note:(0,o.__)("Shortcodes","dragblock"),className:"dragblock-insert-shortcodes-box",popOverClassName:"dragblock-toolbar-popover",placeholder:(0,o.__)("Search a shortcode"),icon:dragBlockIcons?.iconShortcode,label:(0,o.__)("Insert a shortcode"),showTrigger:!0,onSelect:e=>{const t=wp.richText.insert(n,e,n.start);a(t)},suggestions:g}))}});var b=JSON.parse('{"u2":"dragblock/text"}');(0,e.registerBlockType)(b.u2,{edit:function(e){const[r,a]=(0,t.useState)("undefined"!=typeof dragBlockEditorInit?dragBlockEditorInit.siteLocale:""),{attributes:s,setAttributes:i,isSelected:d}=e;let{dragBlockText:b,dragBlockClientId:p,className:k,dragBlockTagName:_}=s,h=(0,l.useBlockProps)();b||(b=[]),_||(_="span");let m=-1,B=-1,f=-1,D=-1;for(let e=0;e<b.length;e++){const{disabled:t,value:o,slug:a}=b[e];if(!t&&(a===r&&(D=e),o)){if(a===r){f=e;break}"en_US"!==r?m=e:B=e}}let v=-1;v=-1!==f?f:-1!==B?B:m;let w="";-1!==v?w=b[v].value:-1===D?(b.unshift({slug:r,value:""}),v=0):v=D,d||w.includes("[")&&w.includes("]")&&(w=function(e,t=null){if(t&&!_DragBlockDB.contentBlocks[t]&&_DragBlockDB.curParseId&&(_DragBlockDB.contentBlocks[t]=_DragBlockDB.curParseId),!_DragBlockDB.contentBlocks[t])return e;let r=_DragBlockDB.parseItemBlocks[_DragBlockDB.contentBlocks[t]];if(!r||!_DragBlockDB.posts[r])return e;_DragBlockDB.post=_DragBlockDB.posts[r];let o=function(e){const t=/\[([^\]]+)\]/g,r=[];let o;for(;null!==(o=t.exec(e));)r.push(o[1]);return r}(e);for(let t of o){let r=t.indexOf(" "),o=t,a="";if(-1!==r&&(o=t.substring(0,r),a=t.substring(r).trim()),g[`[${o}]`]){a&&(a=u(a));let r=g[`[${o}]`].render(a);if(!r)continue;e=e.split(`[${t}]`).join(r)}}return e}(w,p));0===w.indexOf('<span class="inner">')&&(w=w.substring(20),w=w.substring(0,w.length-7));const y=(0,t.createElement)(t.Fragment,null,(0,t.createElement)(l.RichText,{tagName:"span",value:w,allowedFormats:["core/bold","core/underline","core/italic","core/code","core/image","core/strikethrough","core/text-color","core/subscript","core/superscript","core/keyboard","dragblock/richtext-shortcode-inserter"],onChange:e=>{let t=(0,c.cloneDeep)(b);t[v].value=e,i({dragBlockText:t})},placeholder:(0,o.__)("Type a Text","dragblock")})),E=React.createElement(_||"span",{...h},y);return(0,t.createElement)(t.Fragment,null,d&&(0,t.createElement)(t.Fragment,null,(0,t.createElement)(l.InspectorControls,{group:"advanced"},(0,t.createElement)(n.SelectControl,{label:(0,o.__)("Tag Name","dragblock"),value:_,onChange:e=>{i({dragBlockTagName:e})},options:[{value:"span",label:"span"},{value:"button",label:"button"},{value:"p",label:"p"},{value:"h1",label:"H1"},{value:"h2",label:"H2"},{value:"h3",label:"H3"},{value:"h4",label:"H4"},{value:"h5",label:"H5"},{value:"h6",label:"H6"},{value:"label",label:"label"},{value:"div",label:"div"}]}))),E)},save:function(e){const{attributes:r}=e;let{dragBlockText:o,dragBlockTagName:a}=r,n=l.useBlockProps.save();return(0,t.createElement)(t.Fragment,null,("span"===a||!a)&&(0,t.createElement)("span",{...n}),"button"===a&&(0,t.createElement)("button",{...n}),"p"===a&&(0,t.createElement)("p",{...n}),"h1"===a&&(0,t.createElement)("h1",{...n}),"h2"===a&&(0,t.createElement)("h2",{...n}),"h3"===a&&(0,t.createElement)("h3",{...n}),"h4"===a&&(0,t.createElement)("h4",{...n}),"h5"===a&&(0,t.createElement)("h5",{...n}),"h6"===a&&(0,t.createElement)("h6",{...n}),"label"===a&&(0,t.createElement)("label",{...n}),"div"===a&&(0,t.createElement)("div",{...n}))}})}()}();