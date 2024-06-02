!function(){var e,t={1583:function(e,t,a){"use strict";var o=window.wp.element,l=a(4184),r=a.n(l),n=window.wp.i18n,s=window.lodash,c=window.wp.compose,i=window.wp.blockEditor,d=window.wp.components;const{colorVarV0Start:u,colorVarV0AlphaSep:p,colorVarV0End:g,colorVarV1Start:b,colorVarV1AlphaSep:h,colorVarV1BackupSep:m,colorVarV1End:_,gradientVarV1Start:k,gradientVarV1BackupSep:f,gradientVarV1End:v,colorVarV2Start:E,colorVarV2AlphaSep:w,colorVarV2BackupSep:y,colorVarV2End:D,gradientVarV2Start:B,gradientVarV2BackupSep:S,gradientVarV2End:C}=dragBlockEditorInit;function N({children:e,className:t,onClose:a,onAction:l,onMouseLeave:c,onMouseEnter:i,onKeyDown:u,actions:p,title:g,disabled:b,hidden:h,list:m,index:_,position:k}){let f=null;const v=(0,o.useRef)(null);return a||(a=()=>{}),c||(c=()=>{}),i||(i=()=>{}),u||(u=()=>{}),p=Object.assign({},{top:!0,bottom:!0,up:!0,down:!0,duplicate:!0,disable:!0,hidden:!0,delete:!0},p),(0,o.createElement)(o.Fragment,null,(0,o.createElement)(d.Popover,{focusOnMount:!1,position:k||"bottom center",className:"dragblock-property-popover"+(t?" "+t:""),onFocusOutside:()=>{a()},onClose:()=>{a()},onClick:e=>{f={X:e.clientX,Y:e.clientY}},onMouseMove:e=>{f={X:e.clientX,Y:e.clientY}},onMouseLeave:e=>{null!==f&&f.X!==e.clientX&&f.Y!==e.clientY&&c()},onKeyDown:e=>{"Escape"!==e.key&&"Enter"!==e.key||("Enter"!==e.key||-1===e.target.className.indexOf("components-search-control__input")&&-1===e.target.className.indexOf("dragblock-chosen-control-input-showing")&&-1===e.target.className.indexOf("components-select-control__input"))&&a()},ref:v},g?(0,o.createElement)("div",{className:"title"},g):null,e?(0,o.createElement)("div",{className:"content"},e):null,(0,o.createElement)("div",{className:"actions"},p.top?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Move Top","dragblock"),position:"top center"},(0,o.createElement)("a",{className:r()("action front",{disabled:0===_}),onClick:()=>{let e=null;if((0,s.isFunction)(p.top))e=p.top((0,s.cloneDeep)(m),_);else{if(0===_||!Array.isArray(m))return;e=(0,s.cloneDeep)(m);let t=(0,s.cloneDeep)(e[_]);e.splice(_,1),e.unshift(t)}l("top",e)}},(0,o.createElement)("svg",{style:{transform:"rotate(180deg)"},xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M2 12c0 3.6 2.4 5.5 6 5.5h.5V19l3-2.5-3-2.5v2H8c-2.5 0-4.5-1.5-4.5-4s2-4.5 4.5-4.5h3.5V6H8c-3.6 0-6 2.4-6 6zm19.5-1h-8v1.5h8V11zm0 5h-8v1.5h8V16zm0-10h-8v1.5h8V6z"})))):null,p.bottom?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Move Bottom","dragblock"),position:"top center"},(0,o.createElement)("a",{className:r()("action back",{disabled:_===m.length-1}),onClick:()=>{let e=null;if((0,s.isFunction)(p.bottom))e=p.bottom((0,s.cloneDeep)(m),_);else{if(_===m.length-1||!Array.isArray(m))return;e=(0,s.cloneDeep)(m);let t=(0,s.cloneDeep)(e[_]);e.splice(_,1),e.push(t)}l("bottom",e)}},(0,o.createElement)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M2 12c0 3.6 2.4 5.5 6 5.5h.5V19l3-2.5-3-2.5v2H8c-2.5 0-4.5-1.5-4.5-4s2-4.5 4.5-4.5h3.5V6H8c-3.6 0-6 2.4-6 6zm19.5-1h-8v1.5h8V11zm0 5h-8v1.5h8V16zm0-10h-8v1.5h8V6z"})))):null,p.up?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Move Up","dragblock"),position:"top center"},(0,o.createElement)("a",{className:r()("action up",{disabled:0===_}),onClick:()=>{let e=null;if((0,s.isFunction)(p.up))e=p.up((0,s.cloneDeep)(m),_);else{if(0===_||!Array.isArray(m))return;e=(0,s.cloneDeep)(m);let t=(0,s.cloneDeep)(e[_]);e[_]=e[_-1],e[_-1]=t}l("up",e)}},(0,o.createElement)("svg",{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M6.5 12.4L12 8l5.5 4.4-.9 1.2L12 10l-4.5 3.6-1-1.2z"})))):null,p.down?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Move Down","dragblock"),position:"top center"},(0,o.createElement)("a",{className:r()("action down",{disabled:_===m.length-1}),onClick:()=>{let e=null;if((0,s.isFunction)(p.down))e=p.down((0,s.cloneDeep)(m),_);else{if(_===m.length-1||!Array.isArray(m))return;e=(0,s.cloneDeep)(m);let t=(0,s.cloneDeep)(e[_]);e[_]=e[_+1],e[_+1]=t}l("down",e)}},(0,o.createElement)("svg",{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M17.5 11.6L12 16l-5.5-4.4.9-1.2L12 14l4.5-3.6 1 1.2z"})))):null,p.duplicate?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Duplicate","dragblock"),position:"top center"},(0,o.createElement)("a",{className:"action duplicate",onClick:()=>{let e=null;if((0,s.isFunction)(p.duplicate))e=p.duplicate((0,s.cloneDeep)(m),_);else{if(!Array.isArray(m))return;e=(0,s.cloneDeep)(m),e.splice(_,0,(0,s.cloneDeep)(e[_]))}l("duplicate",e)}},(0,o.createElement)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M7 13.8h6v-1.5H7v1.5zM18 16V4c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2zM5.5 16V4c0-.3.2-.5.5-.5h10c.3 0 .5.2.5.5v12c0 .3-.2.5-.5.5H6c-.3 0-.5-.2-.5-.5zM7 10.5h8V9H7v1.5zm0-3.3h8V5.8H7v1.4zM20.2 6v13c0 .7-.6 1.2-1.2 1.2H8v1.5h11c1.5 0 2.7-1.2 2.7-2.8V6h-1.5z"})))):null,p.disable?(0,o.createElement)(d.Tooltip,{delay:10,text:b?(0,n.__)("Enable","dragblock"):(0,n.__)("Disable","dragblock"),position:"top center"},(0,o.createElement)("a",{className:r()("action visibility",{disabled:!!b}),onClick:()=>{let e=null;if((0,s.isFunction)(p.disable))e=p.disable((0,s.cloneDeep)(m),_);else{if(!Array.isArray(m))return;e=(0,s.cloneDeep)(m)}l("disable",e)}},b?dragBlockIcons?.iconCircle:dragBlockIcons?.iconMinusCircle)):null,p.hidden?(0,o.createElement)(d.Tooltip,{delay:10,text:"*"===h?(0,n.__)("Show","dragblock"):(0,n.__)("Hide","dragblock"),position:"top center"},(0,o.createElement)("a",{className:"action",onClick:()=>{let e=null;if((0,s.isFunction)(p.hidden))e=p.hidden((0,s.cloneDeep)(m),_);else{if(!Array.isArray(m))return;e=(0,s.cloneDeep)(m)}l("hidden",e)}},"*"===h?dragBlockIcons?.iconEye:dragBlockIcons?.iconEyeClosed)):null,p.delete?(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Delete","dragblock"),position:"top center"},(0,o.createElement)("a",{className:"action delete",onClick:()=>{let e=null;(0,s.isFunction)(p.delete)?e=p.delete((0,s.cloneDeep)(m),_):(e=(0,s.cloneDeep)(m),(0,s.isArray)(m)?e.splice(_,1):"object"==typeof m&&delete e[_]),l("delete",e)}},(0,o.createElement)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M20 5h-5.7c0-1.3-1-2.3-2.3-2.3S9.7 3.7 9.7 5H4v2h1.5v.3l1.7 11.1c.1 1 1 1.7 2 1.7h5.7c1 0 1.8-.7 2-1.7l1.7-11.1V7H20V5zm-3.2 2l-1.7 11.1c0 .1-.1.2-.3.2H9.1c-.1 0-.3-.1-.3-.2L7.2 7h9.6z"})))):null,p.custom&&(0,o.createElement)(o.Fragment,null,Object.keys(p.custom).map(((e,t)=>(0,o.createElement)("span",{key:t},p.custom[e])))),(0,o.createElement)(d.Tooltip,{delay:10,text:(0,n.__)("Close","dragblock"),position:"top center"},(0,o.createElement)("a",{className:"action close",onClick:a},(0,o.createElement)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","aria-hidden":"true",focusable:"false"},(0,o.createElement)("path",{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"})))))))}function T({placeholder:e,onSelect:t,className:a,popOverClassName:l,icon:s,label:c,text:i,showTrigger:u,position:p,toolbarButton:g,suggestions:b}){const[h,m]=(0,o.useState)(0),[_,k]=(0,o.useState)(""),[f,v]=(0,o.useState)({}),[E,w]=(0,o.useState)(!1),[y,D]=(0,o.useState)(!1),[B,S]=(0,o.useState)([]),[C,N]=(0,o.useState)(null),[T,A]=(0,o.useState)(!1),L=()=>{w(!1)},O=()=>{let e={};for(let t in b){if(Object.keys(e).length>12)break;e[t]=b[t]}v(e),w(!0)},x=e=>{t(e),v({}),k(""),L()};let V=null,j="";if(b){if("string"==typeof b){if(j=b,b={},B&&B.length)for(let e of B)b[e.value]={label:e.label,note:e.note};switch(j){case"categories":b["[dragblock.post.cat.id]"]={label:(0,n.__)("Post Category ID"),note:(0,n.__)("Current Post Category ID")};break;case"tags":b["[dragblock.post.tag.id]"]={label:(0,n.__)("Post Tag ID"),note:(0,n.__)("Current Post Tag ID")};break;case"authors":b["[dragblock.post.author.id]"]={label:(0,n.__)("Post Author ID"),note:(0,n.__)("Current Post Author ID")}}}}else b={};const P=e=>{if(!e||!b||0===b.length)return void v({});let t=e.toLowerCase().trim().replace(/-/gi," ").split(" ").map((e=>e.trim())),a=t.join("").replace(/ /gi,""),o={},l=0;for(let e in b){let r="string"==typeof b[e]?b[e].toLowerCase():Object.values(b[e]).join(" ").toLowerCase(),n=!0;if(-1===r.replace(/ /gi,"").replace(/-/gi,"").indexOf(a))for(let e of t)if(-1===r.indexOf(e)){n=!1;break}if(n&&(o[e]=b[e],++l>=12))break}v(Object.fromEntries(Object.entries(o).sort(((e,t)=>e[0].length-t[0].length))))};return(0,o.createElement)("div",{className:r()("dragblock-autocomplete-search-box"+(a?" "+a:""),{"show-trigger":u})},g?(0,o.createElement)(d.ToolbarButton,{icon:s,iconSize:"24",label:c,className:"fake-search-button",variant:"secondary",onClick:()=>{T?A(!1):O()}}):(0,o.createElement)(d.Button,{icon:s,iconSize:"24",label:c,className:"fake-search-button",variant:"secondary",onClick:()=>{T?A(!1):O()}},i||(s?"":e)),E?(0,o.createElement)(d.Popover,{position:p||"bottom center",onFocusOutside:()=>{L()},onMouseMove:e=>{null!==V||(V={X:e.clientX,Y:e.clientY})},onClose:()=>{L()},onMouseLeave:e=>{null!==V&&V.X!==e.clientX&&V.Y!==e.clientY&&L()},className:r()("dragblock-autocomplete-search-box-popover"+(l?" "+l:""),{"show-trigger":u})},(0,o.createElement)(d.SearchControl,{onKeyDown:e=>{if("ArrowUp"===e.key)m(0===h?Object.keys(f).length-1:h-1);else if("ArrowDown"===e.key)h>=Object.keys(f).length-1?m(0):m(h+1);else if("Enter"===e.key){let e=Object.keys(f);if(h<0||e.length-1<h)return;let t=e[h];x(t),A(!0),L()}},placeholder:e,value:_,onChange:e=>{j?(D(!0),v([]),C&&clearTimeout(C),N(setTimeout((()=>{((e,t)=>{if(!e||!t)return void S([]);const a=new URLSearchParams({search:e,per_page:12,_locale:"users"});wp.apiFetch({path:`/wp/v2/${t}?${a.toString()}`}).then((a=>{S(a.map((e=>({label:e.name,value:e.id,note:e.description})))),a.map((e=>{b[e.id]={label:e.name,note:e.description}})),((e,t)=>{window["dragblock-query-objects"]||(window["dragblock-query-objects"]=new Object),window["dragblock-query-objects"][e]||(window["dragblock-query-objects"][e]=new Object);for(let a of t)a&&a.id&&(window["dragblock-query-objects"][e][a.id]=a)})(t,a),P(e),D(!1)})).catch((e=>{D(!1),S([])}))})(e,j)}),1e3))):P(e),k(e)}}),j&&_&&(0,o.createElement)("div",{className:"results"},!0===y?(0,o.createElement)(o.Fragment,null,(0,n.__)("Fetching...","dragblock")):(0,o.createElement)(o.Fragment,null,0===Object.keys(b).length&&(0,o.createElement)(o.Fragment,null,(0,n.__)("Not found any","dragblock")))),0!==Object.entries(f).length&&(0,o.createElement)("div",{className:"results"},Object.entries(f).map((([e,t],a)=>{let l=e,n=e;return"string"==typeof t?n=t:(t.note?l=t.note:t.label&&(l=t.label),t.label&&(n=t.label)),(0,o.createElement)("div",{key:a,className:"item",onMouseEnter:()=>{m(a)}},(0,o.createElement)("a",{className:r()("item-link",{active:h===a}),onClick:()=>{x(e)}},(0,o.createElement)("code",null,n)))})))):null)}function A({placeholder:e,onChange:t,onSelect:a,tabIndex:l,value:n,position:s,options:c}){const[i,d]=(0,o.useState)(0),[u,p]=(0,o.useState)({}),[g,b]=(0,o.useState)(null),[h,m]=(0,o.useState)(n||"");c||(c={}),s||(s="top"),l||(l=0);const _=()=>{d(0),p({})},k=e=>{if(!e)return void _();let t={},a=0,o=(e=e.trim().toLowerCase()).split(" "),l=o[o.length-1];if(e&&e.trim()){for(let r in c){let n=c[r].toLowerCase();if(n===l||n===e)continue;let s=r+" "+n,i=!0;for(let e of o)if(-1===s.indexOf(e)||n===e){i=!1;break}if(i&&(t[r]=c[r],++a>=6))break}0===a&&-1!==e.indexOf(" ")&&l?k(l):p({...t})}else{for(let e in c)if(t[e]=c[e],6==++a)break;p({...t})}};return(0,o.createElement)("div",{className:"dragblock-chosen-control "+s,onMouseLeave:_},(0,o.createElement)("div",{className:"components-base-control"},(0,o.createElement)("div",{className:"components-base-control__field"},(0,o.createElement)("input",{className:r()("components-text-control__input",{"dragblock-chosen-control-input-showing":Object.keys(u).length>0}),value:h,placeholder:e,onKeyDown:e=>{if("Tab"===e.key&&Object.keys(u).length&&e.preventDefault(),"ArrowUp"===e.key)d(i<=0?Object.keys(u).length-1:i-1);else if("ArrowDown"===e.key)i>=Object.keys(u).length-1?d(0):d(i+1);else if("Enter"===e.key||"Tab"===e.key){_();let e=Object.keys(u);if(e.length-1<i||i<0)return;let o=e[i],l=h.split(" ");l[l.length-1]=o,a?a(l.join(" ")):t(l.join(" ")),g&&(clearTimeout(g),b(null))}},onClick:()=>{k(h)},onFocus:()=>{k(h)},onChange:e=>{const{value:a}=e.target;k(a),(e=>{m(e),g&&clearTimeout(g),b(setTimeout((()=>{t(e),b(null)}),1e3))})(a)}}))),Object.keys(c).length>0&&Object.keys(u).length>0&&(0,o.createElement)("div",{className:"options",onMouseLeave:_},Object.entries(u).map((([e,l],n)=>(0,o.createElement)("a",{key:n,onClick:()=>{a?a(e):t(e),g&&(clearTimeout(g),b(null)),_()},className:r()("option",{active:i===n})},l)))))}window.wp.data;const L={"[dragblock.home.url]":{label:(0,n.__)("Home URL","dragblock"),note:(0,n.__)("Home URL","dragblock"),render:e=>{}},"[dragblock.blog.url]":{label:(0,n.__)("Latest Post URL","dragblock"),note:(0,n.__)("Blog URL with Latest Posts","dragblock"),render:e=>{}},"[dragblock.login.url]":{label:(0,n.__)("Login URL","dragblock"),note:(0,n.__)("Login URL","dragblock"),render:e=>{}},"[dragblock.form.message.error]":{label:(0,n.__)("Form Submission Error Message","dragblock"),note:(0,n.__)("Error message after submitting form","dragblock"),placeholder:(0,n.__)("DragBlock Form Error: There is an uknown server error.","dragblock"),render:e=>{}},"[dragblock.post.title]":{label:(0,n.__)("Post Title","dragblock"),note:(0,n.__)("The parsed post's Title","dragblock"),placeholder:(0,n.__)("The DragBlock Post Title","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.title)return _DragBlockDB.post.title}},"[dragblock.post.url]":{label:(0,n.__)("Post URL","dragblock"),note:(0,n.__)("The parsed post's url","dragblock"),render:e=>{}},"[dragblock.post.image.src]":{label:(0,n.__)("Post Image Thumbnail SRC","dragblock"),note:(0,n.__)("the parsed post's image src","dragblock"),render:e=>_DragBlockDB.post&&_DragBlockDB.post.image_src?_DragBlockDB.post.image_src:""},"[dragblock.post.author.url]":{label:(0,n.__)("Post Author URL","dragblock"),note:(0,n.__)("the parsed post's author page url","dragblock"),render:e=>{}},"[dragblock.post.author.name]":{label:(0,n.__)("Post Author Name","dragblock"),note:(0,n.__)("The parsed post's author name","dragblock"),placeholder:(0,n.__)("Author Name","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_name)return _DragBlockDB.post.author_name}},"[dragblock.post.author.avatar.src]":{label:(0,n.__)("Post Author Avatar SRC","dragblock"),note:(0,n.__)("The parsed post's author's avatar SRC","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_avatar_src)return _DragBlockDB.post.author_avatar_src}},"[dragblock.post.author.bio]":{label:(0,n.__)("Post Author Bio","dragblock"),note:(0,n.__)("The parsed post's author's biography/description","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.author_bio)return _DragBlockDB.post.author_bio}},"[dragblock.post.date]":{label:(0,n.__)("Post Date Name","dragblock"),note:(0,n.__)("The parsed post's date","dragblock"),placeholder:(0,n.__)("July 01, 2086","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.date)return _DragBlockDB.post.date}},"[dragblock.post.comment.number]":{label:(0,n.__)("Post Comment Number","dragblock"),note:(0,n.__)("The parsed post's comment number","dragblock"),placeholder:"0",render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.comment_number)return _DragBlockDB.post.comment_number}},"[dragblock.post.snippet]":{label:(0,n.__)("Post Snippet","dragblock"),note:(0,n.__)("The parsed post's snippet","dragblock"),placeholder:(0,n.__)("Get the first paragraph of the post content. If the post excerpt, a custom summary of the post that author manually inputted when composing the post content, exists, use that instead","dragblock"),render:e=>{if(!_DragBlockDB.post||!_DragBlockDB.post.snippet)return;let t=_DragBlockDB.post.snippet;if(e&&e.len&&!isNaN(e.len)&&t.length>Number(e.len)){let a="",o=Number(e.len);t.split(" ").map((e=>{a.length<o?a+=(a?" ":"")+e:e.endsWith(",")||e.endsWith("!")||e.endsWith(".")||e.endsWith(":")||e.endsWith("?")||e.endsWith(";")||(a+=(a?" ":"")+e)})),t=t.substring(0,Number(e.len))}return t}},"[dragblock.post.cat.name]":{label:(0,n.__)("Post Category Name","dragblock"),placeholder:(0,n.__)("Category Name","dragblock"),render:e=>{if(_DragBlockDB.post&&_DragBlockDB.post.cat_name)return _DragBlockDB.post.cat_name}},"[dragblock.post.cat.url]":{label:(0,n.__)("Post Category URL","dragblock"),render:e=>{}},"[dragblock.post.tag.name]":{label:(0,n.__)("Post Tag Name","dragblock"),placeholder:(0,n.__)("Tag Name","dragblock"),render:e=>{}},"[dragblock.post.tag.url]":{label:(0,n.__)("Post Tag URL","dragblock"),render:e=>{}},"[dragblock.share.url.twitter]":{label:(0,n.__)("Twitter Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.facebook]":{label:(0,n.__)("Facebook Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.whatsapp]":{label:(0,n.__)("Whatsapp Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.telegram]":{label:(0,n.__)("Telegram Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.tumblr]":{label:(0,n.__)("Tumblr Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.reddit]":{label:(0,n.__)("Reddit Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.linkedin]":{label:(0,n.__)("LinkedIn Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.gmail]":{label:(0,n.__)("Gmail Share URL","dragblock"),render:e=>{}},"[dragblock.share.url.navigator]":{label:(0,n.__)("Navigator Share URL","dragblock"),render:e=>{}}},O={en_US:"English (US)",en_GB:"English (UK)",af:"Afrikaans",ar:"العربية - Arabic",ary:"العربية المغربية - Afro-Asiatic",as:"অসমীয়া - Assamese",azb:"گؤنئی آذربایجان - South Azerbaijani",az:"Azərbaycan dili - Azerbaijani",bel:"Беларуская мова - Belarusian",bg_BG:"Български - Bulgarian",bn_BD:"বাংলা - Bengali (Bangladesh)",bo:"བོད་ཡིག - Tibetan",bs_BA:"Bosanski - Bosnian",ca:"Català - Catalan",ceb:"Cebuano - Cebuano",cs_CZ:"Čeština - Czech",cy:"Cymraeg - Welsh",da_DK:"Dansk - Danish",de_DE:"Deutsch - German",de_CH_informal:"Deutsch (Schweiz, Du) - German",de_AT:"Deutsch (Österreich) - German",de_CH:"Deutsch (Schweiz) - German",de_DE_formal:"Deutsch (Sie) - German",dsb:"Dolnoserbšćina - Lower Sorbian",dzo:"རྫོང་ཁ - Dzongkha",el:"Ελληνικά - Greek",en_ZA:"English (South Africa)",en_NZ:"English (New Zealand)",en_AU:"English (Australia)",en_CA:"English (Canada)",eo:"Esperanto - Esperanto",es_ES:"Español - Spanish",es_PE:"Español de Perú - Spanish",es_CR:"Español de Costa Rica - Spanish",es_AR:"Español de Argentina - Spanish",es_CL:"Español de Chile - Spanish",es_VE:"Español de Venezuela - Spanish",es_UY:"Español de Uruguay - Spanish",es_PR:"Español de Puerto Rico - Spanish",es_GT:"Español de Guatemala - Spanish",es_MX:"Español de México - Spanish",es_EC:"Español de Ecuador - Spanish",es_CO:"Español de Colombia - Spanish",et:"Eesti - Estonian",eu:"Euskara - Basque",fa_IR:"فارسی - Persian",fa_AF:"(فارسی (افغانستان - Persian",fi:"Suomi - Finnish",fr_BE:"Français de Belgique - French",fr_FR:"Français - French",fr_CA:"Français du Canada - French",fur:"Friulian",gd:"Gàidhlig - Scottish Gaelic",gl_ES:"Galego - Galician",gu:"ગુજરાતી - Gujarati",haz:"هزاره گی - Hazaragi",he_IL:"עִבְרִית - Hebrew",hi_IN:"हिन्दी - Hindi",hr:"Hrvatski - Croatian",hsb:"Hornjoserbšćina - Upper Sorbian",hu_HU:"Magyar - Hungarian",hy:"Հայերեն - Armenian",id_ID:"Bahasa Indonesia",is_IS:"Íslenska - Icelandic",it_IT:"Italiano",ja:"日本語 - Japanese",jv_ID:"Basa Jawa - Javanese",ka_GE:"ქართული - Georgian",kab:"Taqbaylit - Kabyle",kk:"Қазақ тілі - Kazakh",km:"ភាសាខ្មែរ - Khmer",kn:"ಕನ್ನಡ - Kannada",ko_KR:"한국어 - Korean",ckb:"كوردی - Central Kurdish",lo:"ພາສາລາວ - Lao",lt_LT:"Lietuvių kalba - Lithuanian",lv:"Latviešu valoda - Latvian",mk_MK:"Македонски јазик - Macedonian",ml_IN:"മലയാളം - Malayalam",mn:"Монгол - Mongolian",mr:"मराठी - Marathi",ms_MY:"Bahasa Melayu - Malay (Malaysia)",my_MM:"ဗမာစာ - Burmese",nb_NO:"Norsk bokmål - Norwegian",ne_NP:"नेपाली - Nepali",nl_NL_formal:"Nederlands (Formeel)",nl_BE:"Nederlands (België)",nl_NL:"Nederlands",nn_NO:"Norsk nynorsk",oci:"Occitan",pa_IN:"ਪੰਜਾਬੀ - Punjabi",pl_PL:"Polski - Polish",ps:"پښتو - Pashto",pt_BR:"Português do Brasil - Portuguese",pt_AO:"Português de Angola - Portuguese",pt_PT:"Português - Portuguese",rhg:"Ruáinga",ro_RO:"Română - Romanian",ru_RU:"Русский - Russian",sah:"Сахалыы - Sakha",snd:"سنڌي - Sindhi",si_LK:"සිංහල - Sinhala",sk_SK:"Slovenčina - Slovak",skr:"سرائیکی - Saraiki",sl_SI:"Slovenščina - Slovenian",sq:"Shqip - Albanian",sr_RS:"Српски језик - Serbian",sv_SE:"Svenska - Swedish",sw:"Kiswahili - Swahili",szl:"Ślōnskŏ gŏdka - Silesian",ta_IN:"தமிழ் - Tamil (India)",ta_LK:"தமிழ் - Tamil (Sri Lanka)",te:"తెలుగు - Telugu",th:"ไทย - Thai",tl:"Tagalog",tr_TR:"Türkçe - Turkish",tt_RU:"Татар теле - Tatar",tah:"Reo Tahiti",ug_CN:"ئۇيغۇرچە - Uyghur",uk:"Українська - Ukrainian",ur:"اردو - Urdu",uz_UZ:"O‘zbekcha - Uzbek",vi:"Tiếng Việt - Vietnamese",zh_HK:"香港中文 - Chinese (HK)",zh_TW:"繁體中文 - Chinese (Traditional)",zh_CN:"简体中文 - Chinese (Simplified)"},x=(0,c.createHigherOrderComponent)((e=>t=>{const{attributes:a,setAttributes:l,clientId:c,isSelected:u,isMultiSelected:p}=t;let{dragBlockText:g}=a;const[b,h]=(0,o.useState)(-1),[m,_]=(0,o.useState)(g&&g.length>0);return g||(g=[]),function(e,t=!0){const{clientId:a,isSelected:o,isMultiSelected:l,name:r,attributes:n}=e,{dragBlockRenderability:s}=n;return!o||l||["core/block"].includes(r)||t&&function(e){if(e&&e.length)for(let t of e)if(!t.disabled&&"render"===t.slug&&"never"===t.value)return!0;return!1}(s)}(t)||!["dragblock/text","dragblock/option"].includes(t.name)?(0,o.createElement)(o.Fragment,null,(0,o.createElement)(e,{...t})):(0,o.createElement)(o.Fragment,null,(0,o.createElement)(e,{...t}),(0,o.createElement)(i.InspectorControls,null,(0,o.createElement)(d.PanelBody,{className:"dragblock-inspector-controls content"+(g&&g.length?" has-properties":""),title:(0,n.__)("Content","dragblock"),icon:dragBlockIcons?.iconTranslate,opened:m,onToggle:()=>{_(!m)}},(0,o.createElement)(T,{placeholder:(0,n.__)("+ Add a Text","dragblock"),onSelect:e=>{let t=(0,s.cloneDeep)(g);t.unshift({value:"",slug:e}),l({dragBlockText:t}),h(0)},suggestions:O}),g&&0!==g.length&&(0,o.createElement)("div",{className:"properties"},g.map(((e,t)=>(0,o.createElement)("div",{key:t},(0,o.createElement)(d.Tooltip,{delay:10,text:O[e.slug],position:"middle left"},(0,o.createElement)("a",{className:r()("property",{disabled:!!e.disabled}),onClick:()=>{h(t)}},(0,o.createElement)("span",{className:r()("label",{active:e.slug===dragBlockEditorInit.siteLocale})},e.slug),(0,o.createElement)("span",{className:"separator"}," : "),(0,o.createElement)("span",{className:"value"},e.value))),b===t?(0,o.createElement)(N,{className:"dragblock-content-control-popover",onClose:()=>{h(-1)},onMouseLeave:()=>{h(-1)},onKeyDown:e=>{"Escape"!==e.key&&"Enter"!==e.key||h(-1)},actions:{hidden:!1},onAction:(e,a)=>{"disable"===e&&(a[t].disabled?delete a[t].disabled:a[t].disabled="*"),h(-1),l({dragBlockText:a})},title:O[e.slug],disabled:e.disabled,list:g,index:t},(0,o.createElement)("div",{className:"value"},(0,o.createElement)(d.SelectControl,{value:e.slug,options:Object.entries(O).map((([e,t])=>({value:e,label:t}))),onChange:e=>{let a=(0,s.cloneDeep)(g);a[t].slug=e,l({dragBlockText:a})}}),(0,o.createElement)(A,{options:Object.fromEntries(Object.entries(L).map((([e,t])=>[e,t.label]))),onChange:e=>{let a=(0,s.cloneDeep)(g);a[t].value=e,l({dragBlockText:a})},value:e.value,placeholder:(0,n.__)("Input Text Value","dragblock")}))):null)))))))}),"dragBlockContentControls");wp.hooks.addFilter("editor.BlockEdit","dragblock/content-controls",x)},4184:function(e,t){var a;!function(){"use strict";var o={}.hasOwnProperty;function l(){for(var e=[],t=0;t<arguments.length;t++){var a=arguments[t];if(a){var r=typeof a;if("string"===r||"number"===r)e.push(a);else if(Array.isArray(a)){if(a.length){var n=l.apply(null,a);n&&e.push(n)}}else if("object"===r){if(a.toString!==Object.prototype.toString&&!a.toString.toString().includes("[native code]")){e.push(a.toString());continue}for(var s in a)o.call(a,s)&&a[s]&&e.push(s)}}}return e.join(" ")}e.exports?(l.default=l,e.exports=l):void 0===(a=function(){return l}.apply(t,[]))||(e.exports=a)}()}},a={};function o(e){var l=a[e];if(void 0!==l)return l.exports;var r=a[e]={exports:{}};return t[e](r,r.exports,o),r.exports}o.m=t,e=[],o.O=function(t,a,l,r){if(!a){var n=1/0;for(d=0;d<e.length;d++){a=e[d][0],l=e[d][1],r=e[d][2];for(var s=!0,c=0;c<a.length;c++)(!1&r||n>=r)&&Object.keys(o.O).every((function(e){return o.O[e](a[c])}))?a.splice(c--,1):(s=!1,r<n&&(n=r));if(s){e.splice(d--,1);var i=l();void 0!==i&&(t=i)}}return t}r=r||0;for(var d=e.length;d>0&&e[d-1][2]>r;d--)e[d]=e[d-1];e[d]=[a,l,r]},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,{a:t}),t},o.d=function(e,t){for(var a in t)o.o(t,a)&&!o.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={2433:0,7463:0};o.O.j=function(t){return 0===e[t]};var t=function(t,a){var l,r,n=a[0],s=a[1],c=a[2],i=0;if(n.some((function(t){return 0!==e[t]}))){for(l in s)o.o(s,l)&&(o.m[l]=s[l]);if(c)var d=c(o)}for(t&&t(a);i<n.length;i++)r=n[i],o.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return o.O(d)},a=self.webpackChunkdragblock=self.webpackChunkdragblock||[];a.forEach(t.bind(null,0)),a.push=t.bind(null,a.push.bind(a))}();var l=o.O(void 0,[7463],(function(){return o(1583)}));l=o.O(l)}();