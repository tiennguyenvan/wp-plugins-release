!function(){"use strict";var e=window.wp.blocks,t=window.wp.element,l=(window.wp.i18n,window.wp.blockEditor),o=(window.wp.hooks,window.wp.data,window.lodash),n=JSON.parse('{"u2":"dragblock/select"}');(0,e.registerBlockType)(n.u2,{edit:function(e){const{attributes:n,setAttributes:a,clientId:r,name:s}=e;let{dragBlockAttrs:c,dragBlockClientId:u}=n;if(!c){const e=[{slug:"name",value:u||r}];a({dragBlockAttrs:(0,o.cloneDeep)(e)}),c=e}const d=(0,l.useBlockProps)(),i=(0,l.useInnerBlocksProps)(d,{allowedBlocks:["dragblock/option"],template:[["dragblock/option",{dragBlockText:[{slug:"en_US",value:"Select an Option"}],dragBlockAttrs:[{slug:"value",value:""}]}],["dragblock/option",{dragBlockText:[{slug:"en_US",value:"Value 01 Label"}],dragBlockAttrs:[{slug:"value",value:"value-01"}]}],["dragblock/option",{dragBlockText:[{slug:"en_US",value:"Value 02 Label"}],dragBlockAttrs:[{slug:"value",value:"value-02"}]}]],orientation:"vertical",renderAppender:!1,templateInsertUpdatesSelection:!1});return(0,t.createElement)("select",{...i,onChange:()=>{}})},save:function(e){const{attributes:o}=e;let n=l.useBlockProps.save();return(0,t.createElement)("select",{...n},(0,t.createElement)(l.InnerBlocks.Content,null))}})}();