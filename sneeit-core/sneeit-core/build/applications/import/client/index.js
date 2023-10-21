!function(){"use strict";var e,t={888:function(){var e=window.wp.element,t=window.wp.i18n,n=window.lodash;function r(e){let t=(e=e.trim()).slice(-1);return"s"===t?e:"y"===t?e.slice(0,-1)+"ies":e+"s"}function i(e){return e.trim().replaceAll("-"," ").replaceAll("_"," ").replaceAll("/"," ").split(" ").map((e=>(0,n.capitalize)(e))).join(" ")}function s(e,t,r=!1){let i="";if((0,n.isObject)(e)&&e.responseText&&e.statusText&&(i=e.statusText,e=e.responseText),(0,n.isString)(e)&&-1!==e.indexOf(" https://wordpress.org/documentation/article/faq-troubleshooting/"))return t(__("WordPress Server Error","sneeit-core")),!1;if(function(e){if(!(0,n.isString)(e))return!1;if(-1===e.indexOf("on line")||-1===e.indexOf(".php")||-1===e.indexOf(": "))return!1;let t=["Parse error","Warning","Notice","Fatal error"];for(let n of t)if(-1!==e.indexOf(n))return!0;return!1}(e))return t(i+" : "+(e=(e=e.split(": ")[1]).split("Stack trace:")[0])),!1;if(r)return t((0,n.isString)(e)?e:JSON.stringify(e)),!1;try{e=JSON.parse(e)}catch(n){return t("Invalid JSON: "+n+": "+e),!1}return e.error?(t(e.error),!1):e}function a(n){const{app:r}=n,{setStage:i,setDemos:a,demoListUrl:l}=r,[o,c]=(0,e.useState)();return jQuery.post(sneeitCore.ajaxUrl,{action:"sneeit_core_demo_listing",url:l,nonce:sneeitCore.nonce}).done((function(e){if(!1===(e=s(e,c)))return;let t=l.split("/").map((e=>-1!==e.indexOf(".json")?"":e)).join("/");for(let n in e)e[n].info.screenshot||(e[n].info.screenshot=t+"/"+n+"-screenshot.png");i("listed"),a(e)})).fail((function(e){s(e,c,!0),i("error")})),(0,e.createElement)(e.Fragment,null,!o&&(0,e.createElement)("h2",null,(0,t.__)("Listing...","sneeit-core")),!!o&&(0,e.createElement)("div",{className:"error"},o))}function l(t){const{app:n}=t,{cat:r,setCat:i,cats:s}=n;return n.cats?(0,e.createElement)("div",{className:"filter"},(0,e.createElement)("div",{className:"cats"},Object.keys(s).map(((t,n)=>(0,e.createElement)("a",{key:n,className:t===r?"current":"",onClick:()=>{i(t)}},t)))),(0,e.createElement)("div",{className:"count"},s[r].length)):null}function o(n){const{app:r}=n,{demos:i,cats:s,cat:a,setSelectedDemo:l}=r;return(0,e.createElement)("div",{className:"items"},s[a].map(((n,r)=>{let s=i[n].info;return(0,e.createElement)("div",{key:r,className:"item",onClick:()=>{l(r)}},(0,e.createElement)("div",{className:"thumb"},(0,e.createElement)("img",{src:s.screenshot||sneeitCore.blankImgUrl}),(0,e.createElement)("button",null,(0,t.__)("Demo Details","sneeit-core"))),(0,e.createElement)("div",{className:"info"},(0,e.createElement)("div",{className:"name"},s.name)))})))}function c(t){const{app:n}=t;return(0,e.createElement)(e.Fragment,null,(0,e.createElement)(l,{app:n}),(0,e.createElement)(o,{app:n}))}var m=window.wp.primitives;const u=(0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,e.createElement)(m.Path,{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"})),p=((0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,e.createElement)(m.Path,{d:"M1.5 12c0-2.25 3.75-7.5 10.5-7.5S22.5 9.75 22.5 12s-3.75 7.5-10.5 7.5S1.5 14.25 1.5 12zM12 16.75a4.75 4.75 0 1 0 0-9.5 4.75 4.75 0 0 0 0 9.5zM14.7 12a2.7 2.7 0 1 1-5.4 0 2.7 2.7 0 0 1 5.4 0z"})),(0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,e.createElement)(m.Path,{d:"M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z"}))),d=(0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,e.createElement)(m.Path,{d:"M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z"})),f=(0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 32.055 32.055"},(0,e.createElement)(m.Path,{d:"M3.968,12.061C1.775,12.061,0,13.835,0,16.027c0,2.192,1.773,3.967,3.968,3.967c2.189,0,3.966-1.772,3.966-3.967 C7.934,13.835,6.157,12.061,3.968,12.061z M16.233,12.061c-2.188,0-3.968,1.773-3.968,3.965c0,2.192,1.778,3.967,3.968,3.967 s3.97-1.772,3.97-3.967C20.201,13.835,18.423,12.061,16.233,12.061z M28.09,12.061c-2.192,0-3.969,1.774-3.969,3.967 c0,2.19,1.774,3.965,3.969,3.965c2.188,0,3.965-1.772,3.965-3.965S30.278,12.061,28.09,12.061z"})),g=(0,e.createElement)(m.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 1024 1024"},(0,e.createElement)(m.Path,{d:"M351.605 663.268l481.761-481.761c28.677-28.677 75.171-28.677 103.847 0s28.677 75.171 0 103.847L455.452 767.115l.539.539-58.592 58.592c-24.994 24.994-65.516 24.994-90.51 0L85.507 604.864c-28.677-28.677-28.677-75.171 0-103.847s75.171-28.677 103.847 0l162.25 162.25z"}));function h(r){const{app:i,demo:a}=r,{demos:l,setDemos:o,demoListUrl:c}=i,[m,u]=(0,e.useState)("");if(!i.pointing&&!m){var p=c.split("/"),d=p.slice(0,p.length-1).join("/")+"/"+a.slug+".json";jQuery.post(sneeitCore.ajaxUrl,{action:"sneeit_core_demo_pointing",url:d,nonce:sneeitCore.nonce}).done((function(e){if(!1===(e=s(e=(e=e.replaceAll("{sneeit_demo_placeholder:home_url}",sneeitCore.homeUrl)).replaceAll("{sneeit_demo_placeholder:wp_upload_dir_url}",sneeitCore.uploadUrl),u)))return void i.setPointing(!1);e.info||(e.info=a.file.info),e.info.screenshot||(e.info.screenshot=a.file.info.screenshot),e.info.preview||(e.info.preview="https://demo.sneeit.com/"+a.slug);let t=(0,n.cloneDeep)(l);t[a.slug]=e,i.setDemos(t),e=function(e){const t={};for(let n in e){if("info"===n||"checked"===n)continue;if("posts"!==n){t[n]=!0;continue}let r=!1;for(let n in e.posts)"attachment"!==n?t[n]=!0:r=!0;r&&(t.attachment=!0)}return e.checked=t,e}(e),a.setStage("loaded"),a.setFile(e),i.setPointing(!1)})).fail((function(e){s(e,u,!0),setStage("error"),i.setPointing(!1)})),i.setPointing(!0)}return(0,e.createElement)(e.Fragment,null,!m&&(0,e.createElement)("h3",null,(0,t.__)("Reading Demo Details ...","sneeit-core")),!!m&&(0,e.createElement)("div",{className:"error"},m))}function v(s){const{app:a,demo:l}=s;let o=l.file.checked,c={all:!0};for(let e in o)if("posts"===e)for(let t in o.posts)c[t]=o[e][t];else c[e]=o[e];return c.all=function(e){if(!e.checked)return!0;let t=e.checked;for(let e in t)if(!t[e])return!1;return!0}(l.file),(0,e.createElement)(e.Fragment,null,Object.keys(c).map(((s,a)=>(0,e.createElement)("label",{className:s+" "+String("all"===s?c.all:!c.all),key:a},(0,e.createElement)("input",{type:"checkbox",checked:c[s],onChange:e=>{l.setFile(function(e,t,r){let i=(0,n.cloneDeep)(e),s=i.checked;if("all"===t)for(let e in s)s[e]=r;else s[t]=r;return i.checked=s,i}(l.file,s,e.target.checked))}}),(0,e.createElement)("span",null,(0,e.createElement)("strong",null,"all"===s?(0,t.__)("All","sneeit-core"):i(r(s).replaceAll("wp_",""))),"plugins"===s&&": "+Object.keys(l.file[s]).map((e=>i(r(e)))).join(", "),"terms"===s&&": "+Object.keys(l.file[s]).map((e=>i(r(e).replaceAll("wp_","")))).join(", "),"fonts"===s&&": "+Object.keys(l.file[s]).map((e=>i(e))).join(", "))))))}const E=["lorem","ipsum","dolor","sit","amet","consectetur","adipiscing","elit","suspendisse","tincidunt","ut","odio","et","pharetra","sed","fringilla","lacus","dictum","mauris","vestibulum","imperdiet","velit","blandit","integer","eget","rutrum","turpis","in","eros","id","nunc","convallis","praesent","sem","accumsan","libero","sollicitudin","interdum","erat","justo","maecenas","condimentum","tellus","felis","aliquam","rhoncus","nec","at","a","mi","cras","pellentesque","fermentum","tristique","non","sodales","eleifend","nibh","neque","venenatis","laoreet","vel","viverra","aliquet","ac","quam","malesuada","fames","ante","primis","faucibus","dignissim","arcu","consequat","ultrices","porttitor","metus","nulla","dapibus","posuere","morbi","est","vehicula","mattis","ligula","lacinia","maximus","curabitur","pretium","magna","porta","elementum","massa","urna","orci","suscipit","hendrerit","nisi","lobortis","purus","tortor","duis","iaculis","eu","euismod","efficitur","semper","donec","vitae","quis","sagittis","ex","leo","finibus","mollis","ultricies","diam","phasellus","ullamcorper","egestas","facilisis","cursus","congue","tempus","volutpat","nullam","sapien","pulvinar","proin","luctus","molestie","nisl","placerat","dui","bibendum","gravida","vulputate","enim","auctor","lectus","varius","natoque","penatibus","magnis","dis","parturient","montes","nascetur","ridiculus","mus","ornare","tempor","risus","etiam","vivamus","augue","fusce","commodo","feugiat","scelerisque","aenean","potenti","hac","habitasse","platea","dictumst","nam","quisque","class","aptent","taciti","sociosqu","ad","litora","torquent","per","conubia","nostra","inceptos","himenaeos","facilisi","cubilia","curae","habitant","senectus","netus"];function w(){return E[Math.floor(Math.random()*E.length)]}function b(e=999,t=!0,n=!1,r=null){null===r&&(r=Math.floor(15*Math.random()+5));let i=[],s=[];t&&(r>=10&&r<15?i.push(Math.floor(Math.random()*(r-2)+1)):r>=15&&(Math.floor(100*Math.random())<70?(i.push(Math.floor(Math.random()*(r/2)+1)),i.push(Math.floor(Math.random()*(r/2)+r/2-1))):s.push(Math.floor(6*Math.random()+r/2-3))));let a=[],l=0;for(let n=0;n<r;n++){let r=w();if(t&&(i.includes(n)&&(r+=","),s.includes(n)&&(r+=";")),l+r.length>e){-1===a[a.length-1].indexOf(";")&&-1===a[a.length-1].indexOf(",")||a.push(w());break}a.push(r),l+=r.length}return n&&(a=a.map((e=>e.substring(0,1).toUpperCase()+e.substring(1)))),a=a.join(" "),a=a.substring(0,1).toUpperCase()+a.substring(1),a}function _(){return"\x3c!-- wp:paragraph --\x3e\n    <p>"+function(e=null){null===e&&(e=Math.floor(5*Math.random()+1));let t=[];for(let n=0;n<e;n++)t.push(b());for(t=t.join(". ");t.length<280;)t+=". "+b();return t+=".",t}()+"</p>\n    \x3c!-- /wp:paragraph --\x3e"}function k(){return'\x3c!-- wp:heading --\x3e\n    <h2 class="wp-block-heading">'+b(25,!1,!0)+"</h2>\n    \x3c!-- /wp:heading --\x3e"}function y(){return'\x3c!-- wp:heading {"level":3} --\x3e\n    <h3 class="wp-block-heading">'+b(30,!1,!0)+"</h3>\n    \x3c!-- /wp:heading --\x3e"}function x(){return _()+k()+_()+'\x3c!-- wp:image {"sizeSlug":"large","linkDestination":"none"} --\x3e\n    <figure class="wp-block-image size-large"><img src="https://picsum.photos/1024/600" alt="Demo Image"/></figure>\n    \x3c!-- /wp:image --\x3e'+_()+k()+_()+y()+_()+function(e=3){return"\x3c!-- wp:list --\x3e\n    <ul>\n    "+new Array(e).fill("").map((e=>"\x3c!-- wp:list-item --\x3e\n    <li>"+b(70)+"</li>\n    \x3c!-- /wp:list-item --\x3e")).join("\n")+"\n    </ul>\n    \x3c!-- /wp:list --\x3e"}()+_()+y()+_()+'\x3c!-- wp:image {"sizeSlug":"large","linkDestination":"none"} --\x3e\n    <figure class="wp-block-image size-large"><img src="https://picsum.photos/1024/600" alt="Demo Image"/></figure>\n    \x3c!-- /wp:image --\x3e'+_()+k()+_()}function S(t){const{app:r,demo:i}=t,s=Object.keys(i.file.checked).filter((e=>i.file.checked[e])),a=(0,n.cloneDeep)(s),[l,o]=(0,e.useState)(a.shift()),[c,m]=(0,e.useState)(a);return(0,e.createElement)(e.Fragment,null,s.map(((t,n)=>{const r={type:t,importingType:l,setImportingType:o,importingQueue:c,setImportingQueue:m};return(0,e.createElement)(C,{demo:i,item:r,key:n})})))}function C(a){const{demo:l,item:o}=a,[c,m]=(0,e.useState)("waiting"),[u,p]=(0,e.useState)("waiting"),d={status:c,setStatus:m,message:u,setMessage:p};return"waiting"===c&&o.type===o.importingType&&function(e){const{demo:r,item:i,importer:a}=e;if("importing"===a.status)return;a.setStatus("importing");let l={},o=!1;r.file[i.type]?l=r.file[i.type]:r.file.posts[i.type]&&(o=!0,l=r.file.posts[i.type]),0==Object.keys(l).length&&(a.setStatus("error"),a.setMessage((0,t.__)("Empty Import Content","sneeit-core")));let c=(0,n.cloneDeep)(l);if("post"===i.type)for(let e in c)c[e].content=x();let m="",u=!1,p=[],d={},f=9999;"attachment"===i.type&&(f=1),"plugins"===i.type&&(f=5),"fonts"===i.type&&(f=5);for(let e in c)d[e]=c[e],Object.keys(d).length===f&&(p.push(d),d={});Object.keys(d).length&&p.push(d);let g={};const h=(e,t="")=>{if("object"!=typeof e||Array.isArray(e))g[t]="object"!=typeof e?e:e.join(", ");else for(let n in e)h(e[n],t+(t?"-":"")+n)};let v={action:"sneeit_core_demo_import_"+(o?"posts":i.type),nonce:sneeitCore.nonce};o&&(v.slug=i.type);let E=setInterval((()=>{if(u){if(Object.keys(g).length&&0===Math.floor(10*Math.random())){let e=Object.keys(g).shift(),t=e.split("-").map((e=>(0,n.capitalize)(e))).join(" ")+": ",r=g[e].length>30?"... "+g[e].slice(-30):g[e];delete g[e],a.setMessage(t+r)}}else if(u=!0,m||0===p.length)if(clearInterval(E),a.setMessage(m?"Error: "+m:(0,t.__)("Finished","sneeit-core")),m)a.setStatus("error"),r.setStage("error");else if(a.setStatus("finished"),i.importingQueue.length){let e=(0,n.cloneDeep)(i.importingQueue);i.setImportingType(e.shift()),i.setImportingQueue(e)}else r.setStage("imported");else v.data=p.shift(),g={},h(v.data),jQuery.post(sneeitCore.ajaxUrl,v).done((function(e){u=!1,!1!==(e=s(e,(function(e){m=e})))||m||(m=(0,t.__)("Unknown Server Error","sneeit-core"))}))}),100)}({demo:l,item:o,importer:d}),(0,e.createElement)("div",{className:"item "+c},(0,e.createElement)("div",{className:"icon"},"finished"===c?g:f),(0,e.createElement)("div",{className:"info"},(0,e.createElement)("span",{className:"name"},i(r(o.type.replace("wp_",""))),": "),!!u&&(0,e.createElement)("span",{className:"message "+c},u)))}function j(n){const{app:r,demo:i}=n;return(0,e.createElement)(e.Fragment,null,"loaded"===i.stage&&(0,e.createElement)("p",null,(0,t.__)("Please select the content you want to import","sneeit-core")),"importing"===i.stage&&(0,e.createElement)("h3",null,(0,t.__)("Importing! Do not close or reload this page.","sneeit-core")),"imported"===i.stage&&(0,e.createElement)("h3",{className:"finish-title"},(0,t.__)("Imported successfully. Congratulation!","sneeit-core")),"error"===i.stage&&(0,e.createElement)("h3",{className:"error"},(0,t.__)("Failed to Import!","sneeit-core")),"loaded"===i.stage&&(0,e.createElement)(v,{app:r,demo:i}),("importing"===i.stage||"imported"===i.stage||"error"===i.stage)&&(0,e.createElement)(S,{app:r,demo:i}))}function N(n){const{app:r}=n,{demos:i,cats:s,cat:a,selectedDemo:l,setSelectedDemo:o}=r,c=-1!=l?s[a][l]:"",[m,f]=(0,e.useState)(c?i[c]:null),g=!!m.checked,[v,E]=(0,e.useState)(g?"loaded":"loading"),w="importing"===v,b="imported"===v,_=function(e){if(!e.checked)return!1;let t=e.checked;for(let e in t)if(!0===t[e])return!0;return!1}(m),k={slug:c,file:m,setFile:f,stage:v,setStage:E},y=g&&!w&&!b&&_,x=()=>{o(-1),k.setStage(g?"loaded":"loading")},S=(0,e.createElement)("div",{className:"overlay",onClick:()=>{w||o(-1)}});document.addEventListener("keydown",(function(e){"Escape"!==e.key||w||x()})),"importing"!==k.stage&&document.querySelector("body").classList.remove("sneeit-core-importing-demo");const C=(0,e.createElement)(e.Fragment,null,!w&&(0,e.createElement)("div",{className:"nav"},(0,e.createElement)("div",{className:"left"},(0,e.createElement)("button",{className:String(l>0),onClick:()=>{if(w||l<=0)return;const e=s[a][l-1]||"";e&&i[e]&&(Object.keys(i[e]).length<2&&E("loading"),f(i[e]),o(l-1))}},p),(0,e.createElement)("button",{className:String(l<s[a].length-1),onClick:()=>{if(w||l>=s[a].length-1)return;const e=s[a][l+1]||"";e&&i[e]&&(Object.keys(i[e]).length<2&&E("loading"),f(i[e]),o(l+1))}},d)),(0,e.createElement)("div",{className:"right"},(0,e.createElement)("button",{onClick:()=>{w||x()}},u)))),N=(0,e.createElement)(e.Fragment,null,!w&&(0,e.createElement)("div",{className:"actions"},k.file.info&&k.file.info.preview&&(0,e.createElement)(e.Fragment,null,"imported"===v&&(0,e.createElement)(e.Fragment,null,(0,e.createElement)("a",{href:sneeitCore.homeUrl,target:"_blank",title:(0,t.__)("Check Live Website","sneeit-core"),className:"button button-secondary button-large"},(0,t.__)("View the Home Page","sneeit-core")),(0,e.createElement)("a",{href:`${sneeitCore.adminUrl}site-editor.php?postType=wp_template&canvas=edit&sneeit-core=tutorials&postId=${sneeitCore.themeSlug}%2F%2Ffront-page`,target:"_blank",title:(0,t.__)("Edit the Front Page Template","sneeit-core"),className:"button button-primary button-large"},(0,t.__)("Edit the Home Page","sneeit-core"))),"imported"!==v&&(0,e.createElement)("a",{href:k.file.info.preview,target:"_blank",title:(0,t.__)("Check Live Preview","sneeit-core"),className:"button button-secondary button-large"},(0,t.__)("Check Live Preview","sneeit-core"))),"imported"!==v&&(0,e.createElement)("button",{className:"import "+String(y),onClick:()=>{y&&confirm((0,t.__)("Your content could be overridden. Are you sure to import?","sneeit-core"))&&(k.setStage("importing"),document.querySelector("body").classList.add("sneeit-core-importing-demo"))}},(0,t.__)("Import Demo Data","sneeit-core"))));return null===m?null:(0,e.createElement)(e.Fragment,null,S,(0,e.createElement)("div",{className:"demo "+String(!w)},C,(0,e.createElement)("div",{className:"detail"},k.file.info&&k.file.info.preview?(0,e.createElement)("a",{className:"thumb",href:k.file.info.preview,target:"_blank",title:(0,t.__)("Check Live Preview Website","sneeit-core")},(0,e.createElement)("img",{src:k.file.info.screenshot||sneeitCore.blankImgUrl})):(0,e.createElement)("div",{className:"thumb"},(0,e.createElement)("img",{src:k.file.info.screenshot||sneeitCore.blankImgUrl})),(0,e.createElement)("div",{className:"desc"},(0,e.createElement)("h2",{className:"name"},k.file.info.name),"loading"===v&&(0,e.createElement)(h,{app:r,demo:k}),("loaded"===v||"importing"===v||"imported"===v||"error"===v)&&(0,e.createElement)(j,{app:r,demo:k}))),N))}!function(t){const n=new URLSearchParams(location.search).get("page");if(!n)return;const r=document.querySelector("."+n);r&&window.addEventListener("load",(function(){void 0===e.createRoot?(0,e.render)(t,r):(0,e.createRoot)(r).render(t)}),!1)}((0,e.createElement)((function(){const{ajaxUrl:n,nonce:r,imgUrl:i,blankImgUrl:l,themePath:o,themeUrl:m,themeUri:u,themeUpdateUri:p,themeName:d,themeSlug:f,homeUrl:g,uploadUrl:h,isLocalhost:v,sneeitLicenseUsername:E}=sneeitCore,[w,b]=(0,e.useState)("init"),[_,k]=(0,e.useState)(""),[y,x]=(0,e.useState)(""),[S,C]=(0,e.useState)(!1),[j,O]=(0,e.useState)(null),[M,U]=(0,e.useState)("All"),[D,L]=(0,e.useState)(null),[P,F]=(0,e.useState)(-1);null!==j&&null==D&&L(function(e){if(null==e)return null;let t={All:[]},n=[];for(let r in e){let i=e[r].info;i.categories?i.categories.split(",").map((e=>{e=e.trim(),t[e]?t[e].push(r):t[e]=[r]})):n.push(r),t.All.push(r)}return t.General?t.General.push(...n):t.General=n,t}(j));const I={stage:w,setStage:b,demos:j,setDemos:O,cat:M,setCat:U,cats:D,setCats:L,selectedDemo:P,setSelectedDemo:F,pointing:S,setPointing:C,demoListUrl:y};return!function(e){return e&&-1!==e.indexOf("://sneeit.com")&&!function(e){if(!e||-1==e.indexOf("://sneeit.com"))return"-free";let t=e.split("://sneeit.com")[1].split("/").join("");return t&&(t="-"+t),t}(e)}(p)||E?"init"===w&&(b("validating"),jQuery.post(function(e,t=""){let n=sneeitCore.homeUrl.split("\\").join("/"),r=sneeitCore.themePath.split("\\").join("/");return(sneeitCore.isLocalhost&&n.includes("://localhost/wordpress/test")&&r.includes("C:/xampp/htdocs/wordpress/wp-content/")?"http://localhost/sneeit/":"https://sneeit.com/")+"api/"+e+(t?"?referer="+encodeURIComponent(t):"")}("validation"),{get:"demo_list_url",user:E,item:d+" WordPress theme",uri:p,referer:location.href,home:g}).done((function(e){!1!==(e=s(e,k))?(b("listing"),x(e)):b("error")})).fail((function(e){s(e,k,!0),b("error")}))):"error"===w||_||(k((0,t.__)("Please activate the theme before importing demos. Thank you!","sneeit-core")),b("error")),(0,e.createElement)(e.Fragment,null,(0,e.createElement)("h1",null,(0,t.__)("Import Demos","sneeit-core")),("init"===w||"validating"===w)&&(0,t.__)("Validating","sneeit-core"),"listing"===w&&(0,e.createElement)(a,{app:I}),"listed"===w&&(0,e.createElement)(c,{app:I}),-1!=P&&(0,e.createElement)(N,{app:I}),"error"===w&&(0,e.createElement)("div",{className:"error"},_))}),null))}},n={};function r(e){var i=n[e];if(void 0!==i)return i.exports;var s=n[e]={exports:{}};return t[e](s,s.exports,r),s.exports}r.m=t,e=[],r.O=function(t,n,i,s){if(!n){var a=1/0;for(m=0;m<e.length;m++){n=e[m][0],i=e[m][1],s=e[m][2];for(var l=!0,o=0;o<n.length;o++)(!1&s||a>=s)&&Object.keys(r.O).every((function(e){return r.O[e](n[o])}))?n.splice(o--,1):(l=!1,s<a&&(a=s));if(l){e.splice(m--,1);var c=i();void 0!==c&&(t=c)}}return t}s=s||0;for(var m=e.length;m>0&&e[m-1][2]>s;m--)e[m]=e[m-1];e[m]=[n,i,s]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={283:0,971:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var i,s,a=n[0],l=n[1],o=n[2],c=0;if(a.some((function(t){return 0!==e[t]}))){for(i in l)r.o(l,i)&&(r.m[i]=l[i]);if(o)var m=o(r)}for(t&&t(n);c<a.length;c++)s=a[c],r.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return r.O(m)},n=self.webpackChunksneeitcore=self.webpackChunksneeitcore||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var i=r.O(void 0,[971],(function(){return r(888)}));i=r.O(i)}();