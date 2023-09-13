!function(){"use strict";var e,t={903:function(){var e=window.wp.element,t=window.wp.i18n,n=window.lodash,r=window.wp.primitives;function i(e,t,r=!1){let i="";if((0,n.isObject)(e)&&e.responseText&&e.statusText&&(i=e.statusText,e=e.responseText),(0,n.isString)(e)&&-1!==e.indexOf(" https://wordpress.org/documentation/article/faq-troubleshooting/"))return t(__("WordPress Server Error","sneeit-core")),!1;if(function(e){if(!(0,n.isString)(e))return!1;if(-1===e.indexOf("on line")||-1===e.indexOf(".php")||-1===e.indexOf(": "))return!1;let t=["Parse error","Warning","Notice","Fatal error"];for(let n of t)if(-1!==e.indexOf(n))return!0;return!1}(e))return t(i+" : "+(e=(e=e.split(": ")[1]).split("Stack trace:")[0])),!1;if(r)return t((0,n.isString)(e)?e:JSON.stringify(e)),!1;try{e=JSON.parse(e)}catch(n){return e.length>60&&(e=e.substring(0,60)+"..."),t("Invalid JSON: "+n+": "+e),!1}return e.error?(t(e.error),!1):e}function o(e){return(sneeitCore.isLocalhost?"http://localhost/sneeit/":"https://sneeit.com/")+"api/"+e}!function(t){const n=new URLSearchParams(location.search).get("page");if(!n)return;const r=document.querySelector("."+n);r&&window.addEventListener("load",(function(){void 0===e.createRoot?(0,e.render)(t,r):(0,e.createRoot)(r).render(t)}),!1)}((0,e.createElement)((function(){const{ajaxUrl:n,nonce:a,themeUrl:s,themeName:c,homeUrl:l,isLocalhost:u,sneeitLicenseUsername:d}=sneeitCore,f=new URLSearchParams(location.search),[v,p]=(0,e.useState)(d?"activated":"init"),[h,m]=(0,e.useState)(f.get("nonce")),[g,_]=(0,e.useState)(""),w=(0,e.createElement)(r.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,e.createElement)(r.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z"})),O={init:(0,t.__)('Activate "%s"',"sneeit-core"),redirecting:(0,t.__)('Redirecting to "%s"\'s host',"sneeit-core"),activating:(0,t.__)('Activating "%s"',"sneeit-core"),updating:(0,t.__)('Updating "%s"',"sneeit-core"),activated:(0,t.__)('"%s" is activated',"sneeit-core"),error:(0,t.__)('Failed to activate "%s"',"sneeit-core")},S={init:(0,t.__)('Please activate "%s" on your site to use premium features',"sneeit-core"),redirecting:(0,t.__)('Please activate "%s" on your site to use premium features',"sneeit-core"),activating:(0,t.__)('Please do not close or reload this tab when activating "%s"',"sneeit-core"),updating:(0,t.__)('Please do not close or reload this tab when updating "%s"!',"sneeit-core"),activated:(0,t.__)('The theme "%s" has been activated successfully on your site. Congratulation!',"sneeit-core"),error:g},b={init:(0,t.__)("Start to Activate","sneeit-core"),redirecting:(0,t.__)("Redirecting ...","sneeit-core"),activating:(0,t.__)("Activating ...","sneeit-core"),updating:(0,t.__)("Updating ...","sneeit-core"),activated:(0,t.__)("Refresh the Activation","sneeit-core"),error:(0,t.__)("Retry to Activate","sneeit-core")},x=!["init","error","activated"].includes(v);return h&&(p("activating"),m(""),jQuery.post(o("activation"),{nonce:h,item:c+" WordPress Theme",site:l}).fail((function(e){i(e,_,!0),p("error")})).done((function(e){!1!==(e=i(e,_))?(p("updating"),jQuery.post(n,{action:"sneeit_core_update_sneeit_license",data:e,nonce:a}).fail((function(e){i(e,_,!0),p("error")})).done((function(e){if(!1===(e=i(e,_)))return void p("error");p("activated");const t=new URL(location.href);t.searchParams.delete("nonce"),location.href=t.toString()}))):p("error")}))),(0,e.createElement)("div",{className:"inner"},(0,e.createElement)("a",{className:"screenshot"},(0,e.createElement)("img",{src:s+"/screenshot.png"}),(0,e.createElement)("span",null,c)),(0,e.createElement)("div",{className:"main"},(0,e.createElement)("div",{className:"details"},(0,e.createElement)("h1",{className:v},sprintf(O[v],c),"activated"===v&&w),(0,e.createElement)("p",{className:v},"error"===v?g:sprintf(S[v],c))),(0,e.createElement)("div",{className:"action"},(0,e.createElement)("a",{className:"button button-primary "+v+(x?" disabled":""),onClick:()=>{x||(p("redirecting"),location.href=o("nonce"))}},b[v]))))}),null))}},n={};function r(e){var i=n[e];if(void 0!==i)return i.exports;var o=n[e]={exports:{}};return t[e](o,o.exports,r),o.exports}r.m=t,e=[],r.O=function(t,n,i,o){if(!n){var a=1/0;for(u=0;u<e.length;u++){n=e[u][0],i=e[u][1],o=e[u][2];for(var s=!0,c=0;c<n.length;c++)(!1&o||a>=o)&&Object.keys(r.O).every((function(e){return r.O[e](n[c])}))?n.splice(c--,1):(s=!1,o<a&&(a=o));if(s){e.splice(u--,1);var l=i();void 0!==l&&(t=l)}}return t}o=o||0;for(var u=e.length;u>0&&e[u-1][2]>o;u--)e[u]=e[u-1];e[u]=[n,i,o]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={175:0,986:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var i,o,a=n[0],s=n[1],c=n[2],l=0;if(a.some((function(t){return 0!==e[t]}))){for(i in s)r.o(s,i)&&(r.m[i]=s[i]);if(c)var u=c(r)}for(t&&t(n);l<a.length;l++)o=a[l],r.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return r.O(u)},n=self.webpackChunksneeitcore=self.webpackChunksneeitcore||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var i=r.O(void 0,[986],(function(){return r(903)}));i=r.O(i)}();