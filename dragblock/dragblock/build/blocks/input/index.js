!function(){"use strict";var a=window.wp.blocks,r=window.wp.element,e=window.wp.i18n,t=window.wp.blockEditor,o=(window.wp.hooks,window.wp.components,window.lodash);window.wp.data,(0,e.__)("Href","dragblock"),(0,e.__)("Target","dragblock"),(0,e.__)("default","dragblock"),(0,e.__)("New Tab","dragblock"),(0,e.__)("Parent Tab","dragblock"),(0,e.__)("Same Tab","dragblock"),(0,e.__)("Out of Iframe","dragblock"),(0,e.__)("Rel","dragblock"),(0,e.__)("Tab Index","dragblock"),(0,e.__)("Src","dragblock"),(0,e.__)("Alt","dragblock"),(0,e.__)("Name","dragblock"),(0,e.__)("Placeholder","dragblock"),(0,e.__)("Title","dragblock"),(0,e.__)("Type","dragblock"),(0,e.__)("Value","dragblock"),(0,e.__)("Disabled","dragblock"),(0,e.__)("Required","dragblock"),(0,e.__)("Selected","dragblock"),(0,e.__)("Action","dragblock"),(0,e.__)("Method","dragblock"),(0,e.__)("For","dragblock"),(0,e.__)("Sizes","dragblock"),(0,e.__)("Loading","dragblock"),(0,e.__)("Loading immediately or wait viewport","dragblock"),(0,e.__)("Default","dragblock"),(0,e.__)("Lazy","dragblock"),(0,e.__)("Eager","dragblock"),wp.hooks.addFilter("blocks.registerBlockType","dragblock/attributes-register",(function(a,r){return a=Object.assign({},a,{attributes:Object.assign({},a.attributes,{dragBlockClientId:{type:"string"},anchor:{type:"string",source:"attribute",default:"",attribute:"id",selector:"*"},className:{type:"string",default:""},dragBlockAttrs:{type:"array",default:""}})}),-1!==r.indexOf("dragblock")&&(a=Object.assign({},a,{attributes:Object.assign({},a.attributes,{}),supports:Object.assign({},a.supports,{anchor:!0})})),a})),(0,e.__)("Form Submission Error Message","dragblock"),(0,e.__)("Error message after submitting form","dragblock"),(0,e.__)("DragBlock Form Error: There is an uknown server error.","dragblock"),(0,e.__)("Post Title","dragblock"),(0,e.__)("The parsed post's Title","dragblock"),(0,e.__)("The DragBlock Post Title","dragblock"),(0,e.__)("Post URL","dragblock"),(0,e.__)("The parsed post's url","dragblock"),(0,e.__)("Post Image Thumbnail SRC","dragblock"),(0,e.__)("the parsed post's image src","dragblock"),(0,e.__)("Post Author URL","dragblock"),(0,e.__)("the parsed post's author page url","dragblock"),(0,e.__)("Post Author Name","dragblock"),(0,e.__)("The parsed post's author name","dragblock"),(0,e.__)("Author Name","dragblock"),(0,e.__)("Post Author Avatar SRC","dragblock"),(0,e.__)("The parsed post's author's avatar SRC","dragblock"),(0,e.__)("Post Date Name","dragblock"),(0,e.__)("The parsed post's date","dragblock"),(0,e.__)("July 01, 2086","dragblock"),(0,e.__)("Post Comment Number","dragblock"),(0,e.__)("The parsed post's comment number","dragblock"),(0,e.__)("Post Snippet","dragblock"),(0,e.__)("The parsed post's snippet","dragblock"),(0,e.__)("Get the first paragraph of the post content. If the post excerpt, a custom summary of the post that author manually inputted when composing the post content, exists, use that instead","dragblock"),(0,e.__)("Post Category Name","dragblock"),(0,e.__)("Category Name","dragblock"),(0,e.__)("Post Category URL","dragblock"),(0,e.__)("Post Tag Name","dragblock"),(0,e.__)("Tag Name","dragblock"),(0,e.__)("Post Tag URL","dragblock"),(0,e.__)("Twitter Share URL","dragblock"),(0,e.__)("Facebook Share URL","dragblock"),(0,e.__)("Whatsapp Share URL","dragblock"),(0,e.__)("Telegram Share URL","dragblock"),(0,e.__)("Tumblr Share URL","dragblock"),(0,e.__)("Reddit Share URL","dragblock"),(0,e.__)("LinkedIn Share URL","dragblock"),(0,e.__)("Gmail Share URL","dragblock"),(0,e.__)("Navigator Share URL","dragblock");var _=JSON.parse('{"u2":"dragblock/input"}');(0,a.registerBlockType)(_.u2,{edit:function(a){const{attributes:e,setAttributes:_,isSelected:l,clientId:s}=a;let{dragBlockAttrs:d,dragBlockClientId:c}=e;if(!d){const a=[{slug:"name",value:c||s},{slug:"type",value:"text"},{slug:"placeholder",value:"Input a text",locale:"en_US"}];_({dragBlockAttrs:(0,o.cloneDeep)(a)}),d=a}let g=(0,t.useBlockProps)();return(0,r.createElement)("input",{...g,onChange:()=>{}})},save:function(a){const{attributes:e}=a;let o=t.useBlockProps.save();return(0,r.createElement)("input",{...o})}})}();