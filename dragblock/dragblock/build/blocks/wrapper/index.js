!function(){"use strict";var e=window.wp.blocks,l=window.wp.element,t=window.wp.i18n,n=window.wp.components,a=window.wp.data,r=window.wp.blockEditor;window.wp.hooks;var c=JSON.parse('{"u2":"dragblock/wrapper"}');(0,e.registerBlockType)(c.u2,{usesContext:["dragblockParentStyles"],edit:function(e){const{attributes:c,setAttributes:o,clientId:m,isSelected:u}=e;let{dragBlockTagName:d}=c;const s=(0,a.useSelect)((e=>e("core/block-editor").getBlockOrder(m)));let E=(0,r.useBlockProps)();const b=(0,r.useInnerBlocksProps)(E,{orientation:"horizontal",renderAppender:!1,templateInsertUpdatesSelection:!1}),i=(0,l.createElement)(l.Fragment,null,("div"===d||!d)&&(0,l.createElement)("div",{...b,"data-content-length":s.length}),"section"===d&&(0,l.createElement)("section",{...b}),"header"===d&&(0,l.createElement)("header",{...b}),"footer"===d&&(0,l.createElement)("footer",{...b}),"main"===d&&(0,l.createElement)("main",{...b}),"article"===d&&(0,l.createElement)("article",{...b}),"aside"===d&&(0,l.createElement)("aside",{...b}),"nav"===d&&(0,l.createElement)("nav",{...b}),"button"===d&&(0,l.createElement)("button",{...b}),"ul"===d&&(0,l.createElement)("ul",{...b}),"li"===d&&(0,l.createElement)("li",{...b}),"blockquote"===d&&(0,l.createElement)("blockquote",{...b}),"pre"===d&&(0,l.createElement)("pre",{...b}),"h1"===d&&(0,l.createElement)("h1",{...b}),"h2"===d&&(0,l.createElement)("h2",{...b}),"h3"===d&&(0,l.createElement)("h3",{...b}),"h4"===d&&(0,l.createElement)("h4",{...b}),"h5"===d&&(0,l.createElement)("h5",{...b}),"h6"===d&&(0,l.createElement)("h6",{...b}),"label"===d&&(0,l.createElement)("label",{...b}),"fieldset"===d&&(0,l.createElement)("fieldset",{...b}),"legend"===d&&(0,l.createElement)("legend",{...b}));return(0,l.createElement)(l.Fragment,null,(0,l.createElement)(r.InspectorControls,{__experimentalGroup:"advanced"},(0,l.createElement)(n.SelectControl,{label:(0,t.__)("Tag Name","dragblock"),value:d,onChange:e=>{o({dragBlockTagName:e})},options:[{value:"div",label:(0,t.__)("<div> (Default)","dragblock")},{value:"button",label:(0,t.__)("<button>","dragblock")},{value:"h1",label:(0,t.__)("<h1>","dragblock")},{value:"h2",label:(0,t.__)("<h2>","dragblock")},{value:"h3",label:(0,t.__)("<h3>","dragblock")},{value:"h4",label:(0,t.__)("<h4>","dragblock")},{value:"h5",label:(0,t.__)("<h5>","dragblock")},{value:"h6",label:(0,t.__)("<h6>","dragblock")},{value:"ul",label:(0,t.__)("<ul>","dragblock")},{value:"li",label:(0,t.__)("<li>","dragblock")},{value:"blockquote",label:(0,t.__)("<blockquote>","dragblock")},{value:"section",label:(0,t.__)("<footer>","dragblock")},{value:"header",label:(0,t.__)("<header>","dragblock")},{value:"footer",label:(0,t.__)("<footer>","dragblock")},{value:"main",label:(0,t.__)("<main>","dragblock")},{value:"article",label:(0,t.__)("<article>","dragblock")},{value:"aside",label:(0,t.__)("<aside>","dragblock")},{value:"nav",label:(0,t.__)("<nav>","dragblock")},{value:"pre",label:(0,t.__)("<pre>","dragblock")},{value:"label",label:(0,t.__)("<label>","dragblock")},{value:"fieldset",label:(0,t.__)("<fieldset>","dragblock")},{value:"legend",label:(0,t.__)("<legend>","dragblock")}]})),i)},save:function(e){const{attributes:t}=e,{dragBlockTagName:n}=t;let a=r.useBlockProps.save();const c=(0,l.createElement)(l.Fragment,null,("div"===n||!n)&&(0,l.createElement)("div",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"section"===n&&(0,l.createElement)("section",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"header"===n&&(0,l.createElement)("header",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"footer"===n&&(0,l.createElement)("footer",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"main"===n&&(0,l.createElement)("main",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"article"===n&&(0,l.createElement)("article",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"aside"===n&&(0,l.createElement)("aside",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"nav"===n&&(0,l.createElement)("nav",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"button"===n&&(0,l.createElement)("button",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"ul"===n&&(0,l.createElement)("ul",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"li"===n&&(0,l.createElement)("li",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"blockquote"===n&&(0,l.createElement)("blockquote",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"pre"===n&&(0,l.createElement)("pre",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h1"===n&&(0,l.createElement)("h1",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h2"===n&&(0,l.createElement)("h2",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h3"===n&&(0,l.createElement)("h3",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h4"===n&&(0,l.createElement)("h4",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h5"===n&&(0,l.createElement)("h5",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"h6"===n&&(0,l.createElement)("h6",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"label"===n&&(0,l.createElement)("label",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"fieldset"===n&&(0,l.createElement)("fieldset",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)),"legend"===n&&(0,l.createElement)("legend",{...a},(0,l.createElement)(r.InnerBlocks.Content,null)));return(0,l.createElement)(l.Fragment,null,c)}})}();