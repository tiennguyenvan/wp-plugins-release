!function(){var e={4184:function(e,t){var c;!function(){"use strict";var r={}.hasOwnProperty;function l(){for(var e=[],t=0;t<arguments.length;t++){var c=arguments[t];if(c){var n=typeof c;if("string"===n||"number"===n)e.push(c);else if(Array.isArray(c)){if(c.length){var a=l.apply(null,c);a&&e.push(a)}}else if("object"===n){if(c.toString!==Object.prototype.toString&&!c.toString.toString().includes("[native code]")){e.push(c.toString());continue}for(var o in c)r.call(c,o)&&c[o]&&e.push(o)}}}return e.join(" ")}e.exports?(l.default=l,e.exports=l):void 0===(c=function(){return l}.apply(t,[]))||(e.exports=c)}()}},t={};function c(r){var l=t[r];if(void 0!==l)return l.exports;var n=t[r]={exports:{}};return e[r](n,n.exports,c),n.exports}!function(){"use strict";var e=window.wp.blocks,t=window.wp.element,r=(window.wp.i18n,window.wp.blockEditor),l=(window.wp.hooks,window.wp.components,window.lodash);c(4184);var n=window.wp.primitives;(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M8.286 3.407A1.5 1.5 0 0 0 6 4.684v14.632a1.5 1.5 0 0 0 2.286 1.277l11.888-7.316a1.5 1.5 0 0 0 0-2.555L8.286 3.407z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 96 96",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M94.9936,44.6718C83.6788,27.7025,70.155,11.9989,48,11.9989S12.3212,27.7025,1.0064,44.6718a6.0063,6.0063,0,0,0,0,6.6564C12.3212,68.2975,25.845,84.0011,48,84.0011S83.6788,68.2975,94.9936,51.3282A6.0063,6.0063,0,0,0,94.9936,44.6718ZM48,72.0007C35.2672,72.0007,25.3294,65.21,13.2646,48,25.3294,30.7905,35.2672,23.9993,48,23.9993S70.6706,30.7905,82.7354,48C70.6706,65.21,60.7328,72.0007,48,72.0007Z"}),(0,t.createElement)(n.Path,{d:"M48,36A12,12,0,1,0,60,48,12.0161,12.0161,0,0,0,48,36Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{stroke:"#000000",strokeLinecap:"round",strokeLinejoin:"round",strokeWidth:"2",d:"M3 10a13.358 13.358 0 0 0 3 2.685M21 10a13.358 13.358 0 0 1-3 2.685m-8 1.624L9.5 16.5m.5-2.19a10.59 10.59 0 0 0 4 0m-4 0a11.275 11.275 0 0 1-4-1.625m8 1.624.5 2.191m-.5-2.19a11.275 11.275 0 0 0 4-1.625m0 0 1.5 1.815M6 12.685 4.5 14.5"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M7 11h10v2H7z"}),(0,t.createElement)(n.Path,{d:"M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M4 18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12z",fill:"#000000"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"}," ",(0,t.createElement)(n.Path,{d:"M21 5.75C21 4.23122 19.7688 3 18.25 3H5.75C4.23122 3 3 4.23122 3 5.75V18.25C3 19.7688 4.23122 21 5.75 21H18.25C19.7688 21 21 19.7688 21 18.25V5.75ZM5.75 4.5H18.25C18.9404 4.5 19.5 5.05964 19.5 5.75V18.25C19.5 18.9404 18.9404 19.5 18.25 19.5H5.75C5.05964 19.5 4.5 18.9404 4.5 18.25V5.75C4.5 5.05964 5.05964 4.5 5.75 4.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M6.23694 3.0004C7.20344 3.0004 7.98694 3.7839 7.98694 4.7504V19.2504C7.98694 20.2169 7.20344 21.0004 6.23694 21.0004H3.73694C2.77044 21.0004 1.98694 20.2169 1.98694 19.2504V4.7504C1.98694 3.83223 2.69405 3.07921 3.59341 3.0062L3.73694 3.0004H6.23694ZM20.263 3.0004C21.2295 3.0004 22.013 3.7839 22.013 4.7504V19.2504C22.013 20.2169 21.2295 21.0004 20.263 21.0004H17.763C16.7965 21.0004 16.013 20.2169 16.013 19.2504V4.7504C16.013 3.7839 16.7965 3.0004 17.763 3.0004H20.263ZM13.2369 2.99957C14.2034 2.99957 14.9869 3.78307 14.9869 4.74957V19.2496C14.9869 20.2161 14.2034 20.9996 13.2369 20.9996H10.7369C9.77044 20.9996 8.98694 20.2161 8.98694 19.2496V4.74957C8.98694 3.78307 9.77044 2.99957 10.7369 2.99957H13.2369Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 16 16",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M8 1a2 2 0 00-2 2v2a2 2 0 002 2h4a2 2 0 002-2h1.868l.003.003a.023.023 0 01.005.007v.007C15.728 6.38 15.5 8.75 15.5 10.5c0 1.75.228 4.12.376 5.483a.02.02 0 010 .005v.002a.023.023 0 01-.005.007l-.002.002h-.001l-.002.001H4.132l-.003-.003a.021.021 0 01-.004-.007v-.007c.147-1.362.375-3.732.375-5.483 0-1.75-.228-4.12-.376-5.483V5.01A.021.021 0 014.133 5H6V3H4.134a2.014 2.014 0 00-1.998 2.233C2.284 6.596 2.5 8.87 2.5 10.5c0 1.63-.216 3.904-.364 5.267A2.014 2.014 0 004.134 18h11.732a2.014 2.014 0 001.998-2.233c-.148-1.363-.364-3.636-.364-5.267 0-1.63.216-3.904.364-5.267A2.014 2.014 0 0015.866 3H14a2 2 0 00-2-2H8zm0 2h4v2H8V3zm1 7.5V9a1 1 0 012 0v1.5h1.5a1 1 0 110 2H11V14a1 1 0 11-2 0v-1.5H7.5a1 1 0 110-2H9z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M6 3a2 2 0 012-2h4a2 2 0 012 2h1.866a2.014 2.014 0 011.998 2.233C17.716 6.596 17.5 8.87 17.5 10.5c0 1.63.216 3.904.364 5.267A2.014 2.014 0 0115.866 18H4.134a2.014 2.014 0 01-1.998-2.233c.148-1.363.364-3.636.364-5.267 0-1.63-.216-3.904-.364-5.267A2.014 2.014 0 014.134 3H6v2H4.132l-.003.003a.02.02 0 00-.004.007v.007C4.271 6.38 4.5 8.75 4.5 10.5c0 1.75-.228 4.12-.376 5.483v.007a.021.021 0 00.008.01h11.736l.001-.001.002-.002a.023.023 0 00.005-.007v-.007c-.148-1.362-.376-3.732-.376-5.483 0-1.75.228-4.12.376-5.483a.02.02 0 000-.005V5.01a.023.023 0 00-.008-.01H14a2 2 0 01-2 2H8a2 2 0 01-2-2V3zm6 0H8v2h4V3zm2.097 6.717a1 1 0 10-1.394-1.434l-3.521 3.424-1.609-1.126a1 1 0 00-1.146 1.638l2.285 1.6a1 1 0 001.27-.102l4.115-4z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M6 3a2 2 0 012-2h4a2 2 0 012 2h1.866a2.014 2.014 0 011.998 2.233C17.716 6.596 17.5 8.87 17.5 10.5c0 1.63.216 3.904.364 5.267A2.014 2.014 0 0115.866 18H4.134a2.014 2.014 0 01-1.998-2.233c.148-1.363.364-3.636.364-5.267 0-1.63-.216-3.904-.364-5.267A2.014 2.014 0 014.134 3H6v2H4.132l-.003.003a.02.02 0 00-.004.007v.007C4.271 6.38 4.5 8.75 4.5 10.5c0 1.75-.228 4.12-.376 5.483v.007a.021.021 0 00.008.01h11.736l.001-.001.002-.002a.023.023 0 00.005-.007v-.007c-.148-1.362-.376-3.732-.376-5.483 0-1.75.228-4.12.376-5.483a.02.02 0 000-.005V5.01a.023.023 0 00-.008-.01H14a2 2 0 01-2 2H8a2 2 0 01-2-2V3zm6 0H8v2h4V3zm.5 7.5h-5a1 1 0 100 2h5a1 1 0 100-2z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 45.73 45.73"},(0,t.createElement)(n.Path,{d:"M21.368,21.057c-2.149-2.135-5.626-2.128-7.77,0.015c-2.148,2.151-2.148,5.636,0,7.786 c0.106,0.105,5.207,5.184,7.086,7.053c0.379,0.377,0.991,0.377,1.37,0c1.879-1.869,6.98-6.946,7.086-7.053 c2.15-2.149,2.15-5.635,0-7.786C26.995,18.929,23.521,18.922,21.368,21.057z"}),(0,t.createElement)(n.Path,{d:"M39.74,17.128c-0.308,0.182-0.631,0.338-0.979,0.437c-0.367,0.104-0.747,0.155-1.128,0.155 c-0.294,0-0.582-0.041-0.865-0.101l3.414,15.229c0.209,0.928,0.043,1.883-0.467,2.686c-0.511,0.805-1.302,1.363-2.23,1.57 l-24.675,5.533c-0.918,0.206-1.893,0.035-2.686-0.468c-0.804-0.511-1.362-1.302-1.569-2.229L4.023,19.724 c-0.43-1.917,0.78-3.826,2.697-4.256l20.833-4.671c-0.054-0.178-0.101-0.358-0.128-0.544c-0.137-0.908,0.039-1.824,0.473-2.616 L6.062,12.533c-3.535,0.792-5.767,4.313-4.974,7.849L5.62,40.597c0.384,1.714,1.412,3.173,2.894,4.112 c1.054,0.669,2.271,1.021,3.52,1.021c0.481,0,0.965-0.054,1.436-0.158l24.675-5.533c1.713-0.385,3.173-1.412,4.113-2.895 c0.938-1.481,1.245-3.242,0.86-4.955L39.74,17.128z"}),(0,t.createElement)(n.Path,{d:"M41.04,1.58C39.42,0.536,37.711,0,36.327,0c-1.13,0-2.044,0.358-2.515,1.088c-0.583,0.907-0.364,2.196,0.456,3.487 l-3.616,4.321c-0.211,0.253-0.304,0.584-0.255,0.911c0.051,0.324,0.237,0.614,0.514,0.792l1.411,0.909l-2.19,4.901 c-0.199,0.447-0.1,0.989,0.288,1.331c0.219,0.194,0.489,0.289,0.761,0.289c0.317,0,0.636-0.132,0.863-0.389l3.557-4.022 l1.411,0.911c0.187,0.12,0.402,0.182,0.622,0.182c0.104,0,0.209-0.014,0.312-0.043c0.317-0.089,0.579-0.312,0.725-0.607 l2.438-5.078c0.294,0.041,0.578,0.062,0.852,0.062c1.13,0,2.043-0.357,2.514-1.088C45.521,6.332,43.983,3.477,41.04,1.58z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 21.51 21.25",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M0,2.963v15.584h21.51V2.963H0z M15.722,3.511l-4.969,4.966L5.206,3.511H15.722z M2.912,5.993 l5.992,5.19l-5.992,4.589C2.912,15.772,2.912,5.993,2.912,5.993z M18.597,18.033H2.912v-1.41l6.403-4.926l1.438,1.438l1.507-1.438 l6.337,4.926V18.033z M18.597,15.772l-5.822-4.725l5.822-5.755V15.772z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 48 48",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M38.9,8.1A20.9,20.9,0,0,0,3.2,22.8,19.8,19.8,0,0,0,6,33.2L3,44l11.1-2.9a20.3,20.3,0,0,0,10,2.5A20.8,20.8,0,0,0,38.9,8.1Zm-14.8,32a17.1,17.1,0,0,1-9.5-2.8L8,39.1l1.8-6.4a17.9,17.9,0,0,1-3.1-9.9A17.4,17.4,0,1,1,24.1,40.1Z"}),(0,t.createElement)(n.Path,{d:"M33.6,27.2A29.2,29.2,0,0,0,30,25.5c-.4-.2-.8-.3-1.1.2s-1.4,1.7-1.7,2.1a.8.8,0,0,1-1.1.1,15.2,15.2,0,0,1-4.2-2.6A15,15,0,0,1,19,21.7a.7.7,0,0,1,.2-1l.8-1a3.5,3.5,0,0,0,.5-.8.9.9,0,0,0,0-.9c-.2-.3-1.2-2.8-1.6-3.9s-.9-.9-1.2-.9h-1a1.7,1.7,0,0,0-1.4.7,5.5,5.5,0,0,0-1.8,4.3,10.4,10.4,0,0,0,2.1,5.4c.3.3,3.7,5.6,8.9,7.8a16.4,16.4,0,0,0,3,1.1,6.4,6.4,0,0,0,3.3.2c1-.1,3.1-1.2,3.5-2.4s.5-2.3.3-2.5A2.1,2.1,0,0,0,33.6,27.2Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 32 32",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M23.446 18l0.889-5.791h-5.557v-3.758c0-1.584 0.776-3.129 3.265-3.129h2.526v-4.93c0 0-2.292-0.391-4.484-0.391-4.576 0-7.567 2.774-7.567 7.795v4.414h-5.087v5.791h5.087v14h6.26v-14z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M7 10H17C17.5523 10 18 10.3358 18 10.75C18 11.1297 17.6238 11.4435 17.1357 11.4932L17 11.5H7C6.44772 11.5 6 11.1642 6 10.75C6 10.3703 6.37621 10.0565 6.86431 10.0068L7 10Z"}),(0,t.createElement)(n.Path,{d:"M17 13H7L6.86431 13.0068C6.37621 13.0565 6 13.3703 6 13.75C6 14.1642 6.44772 14.5 7 14.5H17L17.1357 14.4932C17.6238 14.4435 18 14.1297 18 13.75C18 13.3358 17.5523 13 17 13Z"}),(0,t.createElement)(n.Path,{d:"M21 5.75C21 4.23122 19.7688 3 18.25 3H5.75C4.23122 3 3 4.23122 3 5.75V18.25C3 19.7688 4.23122 21 5.75 21H18.25C19.7688 21 21 19.7688 21 18.25V5.75ZM5.75 4.5H18.25C18.9404 4.5 19.5 5.05964 19.5 5.75V18.25C19.5 18.9404 18.9404 19.5 18.25 19.5H5.75C5.05964 19.5 4.5 18.9404 4.5 18.25V5.75C4.5 5.05964 5.05964 4.5 5.75 4.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M6.75 13.5H17.25C17.6642 13.5 18 13.8358 18 14.25C18 14.6297 17.7178 14.9435 17.3518 14.9932L17.25 15H6.75C6.33579 15 6 14.6642 6 14.25C6 13.8703 6.28215 13.5565 6.64823 13.5068L6.75 13.5Z"}),(0,t.createElement)(n.Path,{d:"M17.25 16.5H6.75L6.64823 16.5068C6.28215 16.5565 6 16.8703 6 17.25C6 17.6642 6.33579 18 6.75 18H17.25L17.3518 17.9932C17.7178 17.9435 18 17.6297 18 17.25C18 16.8358 17.6642 16.5 17.25 16.5Z"}),(0,t.createElement)(n.Path,{d:"M21 5.75C21 4.23122 19.7688 3 18.25 3H5.75C4.23122 3 3 4.23122 3 5.75V18.25C3 19.7688 4.23122 21 5.75 21H18.25C19.7688 21 21 19.7688 21 18.25V5.75ZM5.75 4.5H18.25C18.9404 4.5 19.5 5.05964 19.5 5.75V18.25C19.5 18.9404 18.9404 19.5 18.25 19.5H5.75C5.05964 19.5 4.5 18.9404 4.5 18.25V5.75C4.5 5.05964 5.05964 4.5 5.75 4.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M21 5.75C21 4.23122 19.7688 3 18.25 3H5.75C4.23122 3 3 4.23122 3 5.75V18.25C3 19.7688 4.23122 21 5.75 21H18.25C19.7688 21 21 19.7688 21 18.25V5.75ZM5.75 4.5H18.25C18.9404 4.5 19.5 5.05964 19.5 5.75V18.25C19.5 18.9404 18.9404 19.5 18.25 19.5H5.75C5.05964 19.5 4.5 18.9404 4.5 18.25V5.75C4.5 5.05964 5.05964 4.5 5.75 4.5ZM6.75 7.5H17.25C17.6642 7.5 18 7.83579 18 8.25C18 8.6297 17.7178 8.94349 17.3518 8.99315L17.25 9H6.75C6.33579 9 6 8.66421 6 8.25C6 7.8703 6.28215 7.55651 6.64823 7.50685L6.75 7.5ZM17.25 10.5H6.75L6.64823 10.5068C6.28215 10.5565 6 10.8703 6 11.25C6 11.6642 6.33579 12 6.75 12H17.25L17.3518 11.9932C17.7178 11.9435 18 11.6297 18 11.25C18 10.8358 17.6642 10.5 17.25 10.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",fill:"none"},(0,t.createElement)(n.Path,{d:"M18.75,3 C20.5449254,3 22,4.45507456 22,6.25 L22,17.75 C22,19.5449254 20.5449254,21 18.75,21 L5.25,21 C3.45507456,21 2,19.5449254 2,17.75 L2,6.25 C2,4.45507456 3.45507456,3 5.25,3 L18.75,3 Z M18.75,4.5 L5.25,4.5 C4.28350169,4.5 3.5,5.28350169 3.5,6.25 L3.5,17.75 C3.5,18.7164983 4.28350169,19.5 5.25,19.5 L18.75,19.5 C19.7164983,19.5 20.5,18.7164983 20.5,17.75 L20.5,6.25 C20.5,5.28350169 19.7164983,4.5 18.75,4.5 Z M6.74835407,6.5 L17.2543007,6.5 C17.6685143,6.5 18.0043007,6.83578644 18.0043007,7.25 C18.0043007,7.62969577 17.7221468,7.94349096 17.3560713,7.99315338 L17.2543007,8 L6.74835407,8 C6.33414051,8 5.99835407,7.66421356 5.99835407,7.25 C5.99835407,6.87030423 6.28050795,6.55650904 6.64658351,6.50684662 L6.74835407,6.5 L17.2543007,6.5 L6.74835407,6.5 Z"}," ")),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M5.1 19.25H16.9C18.4 19.25 19 18.61 19 17.02V15.98C19 14.39 18.4 13.75 16.9 13.75H5.1",fill:"none",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{d:"M5.1 5.25H11.9C13.4 5.25 14 5.89 14 7.48V8.52C14 10.11 13.4 10.75 11.9 10.75H5.1",fill:"none",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{d:"M5 1.98999V21.99",fill:"none",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"none",d:"M18.9 19.25H7.1C5.6 19.25 5 18.61 5 17.02V15.98C5 14.39 5.6 13.75 7.1 13.75H18.9",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M18.9 5.25H12.1C10.6 5.25 10 5.89 10 7.48V8.52C10 10.11 10.6 10.75 12.1 10.75H18.9",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M19 1.98999V21.99",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"none",d:"M17.4 19.25H6.6C5.1 19.25 4.5 18.61 4.5 17.02V15.98C4.5 14.39 5.1 13.75 6.6 13.75H17.4C18.9 13.75 19.5 14.39 19.5 15.98V17.02C19.5 18.61 18.9 19.25 17.4 19.25Z",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M15.4 10.75H8.6C7.1 10.75 6.5 10.11 6.5 8.52V7.48C6.5 5.89 7.1 5.25 8.6 5.25H15.4C16.9 5.25 17.5 5.89 17.5 7.48V8.52C17.5 10.11 16.9 10.75 15.4 10.75Z",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M12 22.0001V19.6001",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M12 13V11",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"})," ",(0,t.createElement)(n.Path,{d:"M12 2V4.69",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"none",d:"M17.4 19.25H6.6C5.1 19.25 4.5 18.61 4.5 17.02V15.98C4.5 14.39 5.1 13.75 6.6 13.75H17.4C18.9 13.75 19.5 14.39 19.5 15.98V17.02C19.5 18.61 18.9 19.25 17.4 19.25Z",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M15.4 10.75H8.6C7.1 10.75 6.5 10.11 6.5 8.52V7.48C6.5 5.89 7.1 5.25 8.6 5.25H15.4C16.9 5.25 17.5 5.89 17.5 7.48V8.52C17.5 10.11 16.9 10.75 15.4 10.75Z",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M2 1.98999V21.99",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M22 1.98999V21.99",stroke:"currentColor",strokeWidth:"1.5",strokeLinecap:"round",strokeLinejoin:"round"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"none",d:"M14 10C14.9319 10 15.3978 10 15.7654 9.84776C16.2554 9.64477 16.6448 9.25542 16.8478 8.76537C17 8.39782 17 7.93188 17 7C17 6.06812 17 5.60218 16.8478 5.23463C16.6448 4.74458 16.2554 4.35523 15.7654 4.15224C15.3978 4 14.9319 4 14 4L6 4C5.06812 4 4.60218 4 4.23463 4.15224C3.74458 4.35523 3.35523 4.74458 3.15224 5.23463C3 5.60218 3 6.06812 3 7C3 7.93188 3 8.39782 3.15224 8.76537C3.35523 9.25542 3.74458 9.64477 4.23463 9.84776C4.60218 10 5.06812 10 6 10L14 10Z",stroke:"currentColor",strokeWidth:"2",strokeLinecap:"round",strokeLinejoin:"round"}),(0,t.createElement)(n.Path,{fill:"none",d:"M18 20C18.9319 20 19.3978 20 19.7654 19.8478C20.2554 19.6448 20.6448 19.2554 20.8478 18.7654C21 18.3978 21 17.9319 21 17C21 16.0681 21 15.6022 20.8478 15.2346C20.6448 14.7446 20.2554 14.3552 19.7654 14.1522C19.3978 14 18.9319 14 18 14H6C5.06812 14 4.60218 14 4.23463 14.1522C3.74458 14.3552 3.35523 14.7446 3.15224 15.2346C3 15.6022 3 16.0681 3 17C3 17.9319 3 18.3978 3.15224 18.7654C3.35523 19.2554 3.74458 19.6448 4.23463 19.8478C4.60218 20 5.06812 20 6 20L18 20Z",stroke:"currentColor",strokeWidth:"2",strokeLinecap:"round",strokeLinejoin:"round"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{d:"M3.75 4C4.16421 4 4.5 4.3078 4.5 4.6875V6H11.25V4.6875C11.25 4.3078 11.5858 4 12 4C12.4142 4 12.75 4.3078 12.75 4.6875V6H19.5V4.6875C19.5 4.3078 19.8358 4 20.25 4C20.6642 4 21 4.3078 21 4.6875V8.8125C21 9.1922 20.6642 9.5 20.25 9.5C19.8358 9.5 19.5 9.1922 19.5 8.8125V7.5H12.75V8.8125C12.75 9.1922 12.4142 9.5 12 9.5C11.5858 9.5 11.25 9.1922 11.25 8.8125V7.5H4.5V8.8125C4.5 9.1922 4.16421 9.5 3.75 9.5C3.33579 9.5 3 9.1922 3 8.8125V4.6875C3 4.3078 3.33579 4 3.75 4Z"}),(0,t.createElement)(n.Path,{d:"M5.75 11C4.23122 11 3 12.2312 3 13.75V17.75C3 19.2688 4.23122 20.5 5.75 20.5H11.25V11H5.75Z"}),(0,t.createElement)(n.Path,{d:"M18.25 20.5H12.75V11H18.25C19.7688 11 21 12.2312 21 13.75V17.75C21 19.2688 19.7688 20.5 18.25 20.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"none",d:"M0 0h24v24H0z"})," ",(0,t.createElement)(n.Path,{d:"M21 3a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H9V3h12zM7 21H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4v18z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 512.002 512.002",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M472.863,512.001H39.138C17.558,512.001,0,494.443,0,472.864V345.895 c0-8.714,7.067-15.781,15.781-15.781s15.781,7.067,15.781,15.781v126.969c0,4.177,3.398,7.576,7.576,7.576h433.725 c4.177,0,7.576-3.398,7.576-7.576V39.139c0-4.177-3.398-7.576-7.576-7.576H39.138c-4.179,0-7.576,3.398-7.576,7.576v214.045 c0,8.714-7.067,15.781-15.781,15.781S0,261.899,0,253.185V39.139C0,17.559,17.558,0.001,39.138,0.001h433.725 c21.58,0,39.138,17.558,39.138,39.138v433.725C512,494.443,494.442,512.001,472.863,512.001z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M419.149,444.441H280.771c-8.714,0-15.781-7.067-15.781-15.781s7.067-15.781,15.781-15.781h132.106 V271.783H187.439c-8.714,0-15.781-7.067-15.781-15.781s7.067-15.781,15.781-15.781h241.22c8.714,0,15.781,7.067,15.781,15.781 v163.15C444.44,433.094,433.095,444.441,419.149,444.441z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M187.439,444.441H92.851c-13.946,0-25.289-11.343-25.289-25.289v-163.15 c0-8.714,7.067-15.781,15.781-15.781H187.44c8.714,0,15.781,7.067,15.781,15.781c0,8.714-7.067,15.781-15.781,15.781H99.124 v141.096h88.317c8.714,0,15.781,7.067,15.781,15.781S196.155,444.441,187.439,444.441z"}),(0,t.createElement)(n.Path,{fill:"#CFF09E",d:"M83.343,92.851v163.15h104.096h93.285h147.934V92.851c0-5.252-4.258-9.508-9.508-9.508H187.439 H92.851C87.599,83.343,83.343,87.601,83.343,92.851z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M428.659,271.783H83.343c-8.714,0-15.781-7.067-15.781-15.781V92.851 c0-13.946,11.345-25.289,25.289-25.289h326.3c13.944,0,25.289,11.343,25.289,25.289v163.15 C444.44,264.716,437.373,271.783,428.659,271.783z M99.124,240.221h313.754V99.124H99.124V240.221z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"},(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M472.862,512H39.14C17.558,512,0,494.442,0,472.862V345.893c0-8.714,7.065-15.781,15.781-15.781 s15.781,7.067,15.781,15.781v126.969c0,4.177,3.399,7.576,7.578,7.576h433.722c4.177,0,7.576-3.398,7.576-7.576V39.138 c0-4.177-3.398-7.576-7.576-7.576H39.14c-4.179,0-7.578,3.399-7.578,7.576v214.045c0,8.714-7.065,15.781-15.781,15.781 S0,261.897,0,253.183V39.138C0,17.558,17.558,0,39.14,0h433.722C494.442,0,512,17.558,512,39.138v433.723 C512,494.442,494.442,512,472.862,512z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M256,444.439H92.852c-13.944,0-25.289-11.343-25.289-25.289V280.771 c0-8.714,7.065-15.781,15.781-15.781s15.781,7.067,15.781,15.781v132.105h141.096V187.44c0-8.714,7.065-15.781,15.781-15.781 c8.714,0,15.781,7.067,15.781,15.781v241.218C271.781,437.374,264.716,444.439,256,444.439z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M256,203.221c-8.716,0-15.781-7.067-15.781-15.781V99.123H99.125v88.316 c0,8.714-7.065,15.781-15.781,15.781s-15.781-7.067-15.781-15.781V92.85c0-13.946,11.345-25.289,25.289-25.289H256 c8.714,0,15.781,7.067,15.781,15.781V187.44C271.781,196.154,264.716,203.221,256,203.221z"}),(0,t.createElement)(n.Path,{fill:"#CFF09E",d:"M419.15,83.342H192.87v345.315h226.28c5.252,0,9.508-4.258,9.508-9.508V187.438V92.85 C428.658,87.6,424.4,83.342,419.15,83.342z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M419.15,444.437H192.87c-8.716,0-15.781-7.067-15.781-15.781V83.342 c0-8.714,7.065-15.781,15.781-15.781h226.28c13.946,0,25.289,11.345,25.289,25.289v326.298 C444.439,433.092,433.095,444.437,419.15,444.437z M208.651,412.875h204.226V99.123H208.651V412.875z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"},(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M472.862,512H39.14C17.558,512,0,494.442,0,472.862V345.893c0-8.714,7.065-15.781,15.781-15.781 s15.781,7.067,15.781,15.781v126.969c0,4.177,3.399,7.576,7.578,7.576h433.722c4.177,0,7.576-3.398,7.576-7.576V39.138 c0-4.177-3.398-7.576-7.576-7.576H39.14c-4.179,0-7.578,3.399-7.578,7.576v214.045c0,8.714-7.065,15.781-15.781,15.781 S0,261.897,0,253.183V39.138C0,17.558,17.558,0,39.14,0h433.722C494.442,0,512,17.558,512,39.138v433.723 C512,494.442,494.442,512,472.862,512z"})," ",(0,t.createElement)(n.Path,{fill:"#CFF09E",d:"M428.658,187.438V92.85c0-5.252-4.258-9.508-9.508-9.508H92.852c-5.252,0-9.508,4.258-9.508,9.508 v94.588H428.658z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M428.658,203.221H83.344c-8.716,0-15.781-7.067-15.781-15.781V92.85 c0-13.944,11.345-25.289,25.289-25.289H419.15c13.944,0,25.289,11.345,25.289,25.289v94.588 C444.439,196.154,437.374,203.221,428.658,203.221z M99.125,171.659h313.752V99.123H99.125V171.659z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M256,444.439H92.852c-13.944,0-25.289-11.343-25.289-25.289V280.771 c0-8.714,7.065-15.781,15.781-15.781s15.781,7.067,15.781,15.781v132.105h141.096V203.221H83.344 c-8.716,0-15.781-7.067-15.781-15.781c0-8.714,7.065-15.781,15.781-15.781h172.658c8.714,0,15.781,7.067,15.781,15.781v241.218 C271.781,437.374,264.716,444.439,256,444.439z"}),(0,t.createElement)(n.Path,{fill:"#CFF09E",d:"M256,187.438v241.22h163.15c5.252,0,9.508-4.258,9.508-9.508V187.438H256z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M419.15,444.439H256c-8.716,0-15.781-7.067-15.781-15.781V187.44c0-8.714,7.065-15.781,15.781-15.781 h172.658c8.714,0,15.781,7.067,15.781,15.781v231.71C444.439,433.095,433.094,444.439,419.15,444.439z M271.781,412.877h141.096 V203.221H271.781L271.781,412.877L271.781,412.877z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512.002 512.002"},(0,t.createElement)(n.Path,{fill:"#CFF09E",d:"M419.15,83.345H92.852c-5.252,0-9.508,4.256-9.508,9.508v104.759h113.217v116.781H83.342v104.759 c0,5.252,4.258,9.508,9.508,9.508h111.604l0,0h214.693c5.252,0,9.508-4.256,9.508-9.508v-231.71V92.853 C428.658,87.601,424.4,83.345,419.15,83.345z"}),(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M419.15,444.439H92.85c-13.944,0-25.289-11.345-25.289-25.289V314.393 c0-8.716,7.065-15.781,15.781-15.781h97.436v-85.219H83.344c-8.716,0-15.781-7.065-15.781-15.781V92.853 c0-13.944,11.345-25.289,25.289-25.289h326.299c13.944,0,25.289,11.345,25.289,25.289v326.298 C444.439,433.095,433.094,444.439,419.15,444.439z M99.125,412.878h313.752V99.126H99.125v82.705h97.436 c8.716,0,15.781,7.065,15.781,15.781v116.781c0,8.716-7.065,15.781-15.781,15.781H99.125V412.878z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M472.862,512.001H39.14C17.558,512.001,0,494.443,0,472.862V345.894 c0-8.716,7.065-15.781,15.781-15.781s15.781,7.065,15.781,15.781v126.969c0,4.177,3.399,7.578,7.578,7.578h433.722 c4.177,0,7.578-3.399,7.578-7.578V39.141c0-4.177-3.399-7.578-7.578-7.578H39.14c-4.179,0-7.578,3.399-7.578,7.578v214.043 c0,8.716-7.065,15.781-15.781,15.781S0,261.9,0,253.184V39.141c0-21.582,17.558-39.14,39.14-39.14h433.722 c21.582,0,39.14,17.558,39.14,39.14v433.722C512,494.443,494.442,512.001,472.862,512.001z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M196.561,381.309c-8.716,0-15.781-7.065-15.781-15.781V83.345c0-8.716,7.065-15.781,15.781-15.781 s15.781,7.065,15.781,15.781v282.184C212.342,374.244,205.277,381.309,196.561,381.309z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M313.342,444.439c-8.716,0-15.781-7.065-15.781-15.781V146.473c0-8.716,7.065-15.781,15.781-15.781 c8.716,0,15.781,7.065,15.781,15.781v282.185C329.123,437.374,322.057,444.439,313.342,444.439z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M427.608,213.392H83.344c-8.716,0-15.781-7.065-15.781-15.781s7.065-15.781,15.781-15.781H427.61 c8.716,0,15.781,7.065,15.781,15.781C443.391,206.327,436.324,213.392,427.608,213.392z"})," ",(0,t.createElement)(n.Path,{fill:"#507C5C",d:"M427.608,330.173H83.873c-8.716,0-15.781-7.065-15.781-15.781c0-8.716,7.065-15.781,15.781-15.781 h343.736c8.716,0,15.781,7.065,15.781,15.781C443.389,323.108,436.324,330.173,427.608,330.173z"})),(0,t.createElement)(n.SVG,{fill:"#000000",viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/SVG"},(0,t.createElement)(n.Path,{d:"M18.44,3.06H5.56a2.507,2.507,0,0,0-2.5,2.5V18.44a2.514,2.514,0,0,0,2.5,2.5H18.44a2.514,2.514,0,0,0,2.5-2.5V5.56A2.507,2.507,0,0,0,18.44,3.06ZM8.67,19.94H5.56a1.511,1.511,0,0,1-1.5-1.5V5.56a1.5,1.5,0,0,1,1.5-1.5H8.67Zm1-15.88h4.66V19.94H9.67ZM19.94,18.44a1.511,1.511,0,0,1-1.5,1.5H15.33V4.06h3.11a1.5,1.5,0,0,1,1.5,1.5Z"})),(0,t.createElement)(n.SVG,{viewBox:"0 0 512.002 512.002",xmlns:"http://www.w3.org/2000/svg"},(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M472.863,512.001H39.138C17.558,512.001,0,494.443,0,472.864V345.895 c0-8.714,7.067-15.781,15.781-15.781s15.781,7.067,15.781,15.781v126.969c0,4.177,3.398,7.576,7.576,7.576h433.725 c4.177,0,7.576-3.398,7.576-7.576V39.139c0-4.177-3.398-7.576-7.576-7.576H39.138c-4.179,0-7.576,3.398-7.576,7.576v214.045 c0,8.714-7.067,15.781-15.781,15.781S0,261.899,0,253.185V39.139C0,17.559,17.558,0.001,39.138,0.001h433.725 c21.58,0,39.138,17.558,39.138,39.138v433.725C512,494.443,494.442,512.001,472.863,512.001z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M419.149,444.441H280.771c-8.714,0-15.781-7.067-15.781-15.781s7.067-15.781,15.781-15.781h132.106 V271.783H187.439c-8.714,0-15.781-7.067-15.781-15.781s7.067-15.781,15.781-15.781h241.22c8.714,0,15.781,7.067,15.781,15.781 v163.15C444.44,433.094,433.095,444.441,419.149,444.441z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M187.439,444.441H92.851c-13.946,0-25.289-11.343-25.289-25.289v-163.15 c0-8.714,7.067-15.781,15.781-15.781H187.44c8.714,0,15.781,7.067,15.781,15.781c0,8.714-7.067,15.781-15.781,15.781H99.124 v141.096h88.317c8.714,0,15.781,7.067,15.781,15.781S196.155,444.441,187.439,444.441z"}),(0,t.createElement)(n.Path,{fill:"#8ed1fc",d:"M83.343,92.851v163.15h104.096h93.285h147.934V92.851c0-5.252-4.258-9.508-9.508-9.508H187.439 H92.851C87.599,83.343,83.343,87.601,83.343,92.851z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M428.659,271.783H83.343c-8.714,0-15.781-7.067-15.781-15.781V92.851 c0-13.946,11.345-25.289,25.289-25.289h326.3c13.944,0,25.289,11.343,25.289,25.289v163.15 C444.44,264.716,437.373,271.783,428.659,271.783z M99.124,240.221h313.754V99.124H99.124V240.221z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"},(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M472.862,512H39.14C17.558,512,0,494.442,0,472.862V345.893c0-8.714,7.065-15.781,15.781-15.781 s15.781,7.067,15.781,15.781v126.969c0,4.177,3.399,7.576,7.578,7.576h433.722c4.177,0,7.576-3.398,7.576-7.576V39.138 c0-4.177-3.398-7.576-7.576-7.576H39.14c-4.179,0-7.578,3.399-7.578,7.576v214.045c0,8.714-7.065,15.781-15.781,15.781 S0,261.897,0,253.183V39.138C0,17.558,17.558,0,39.14,0h433.722C494.442,0,512,17.558,512,39.138v433.723 C512,494.442,494.442,512,472.862,512z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M256,444.439H92.852c-13.944,0-25.289-11.343-25.289-25.289V280.771 c0-8.714,7.065-15.781,15.781-15.781s15.781,7.067,15.781,15.781v132.105h141.096V187.44c0-8.714,7.065-15.781,15.781-15.781 c8.714,0,15.781,7.067,15.781,15.781v241.218C271.781,437.374,264.716,444.439,256,444.439z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M256,203.221c-8.716,0-15.781-7.067-15.781-15.781V99.123H99.125v88.316 c0,8.714-7.065,15.781-15.781,15.781s-15.781-7.067-15.781-15.781V92.85c0-13.946,11.345-25.289,25.289-25.289H256 c8.714,0,15.781,7.067,15.781,15.781V187.44C271.781,196.154,264.716,203.221,256,203.221z"}),(0,t.createElement)(n.Path,{fill:"#8ed1fc",d:"M419.15,83.342H192.87v345.315h226.28c5.252,0,9.508-4.258,9.508-9.508V187.438V92.85 C428.658,87.6,424.4,83.342,419.15,83.342z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M419.15,444.437H192.87c-8.716,0-15.781-7.067-15.781-15.781V83.342 c0-8.714,7.065-15.781,15.781-15.781h226.28c13.946,0,25.289,11.345,25.289,25.289v326.298 C444.439,433.092,433.095,444.437,419.15,444.437z M208.651,412.875h204.226V99.123H208.651V412.875z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512"},(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M472.862,512H39.14C17.558,512,0,494.442,0,472.862V345.893c0-8.714,7.065-15.781,15.781-15.781 s15.781,7.067,15.781,15.781v126.969c0,4.177,3.399,7.576,7.578,7.576h433.722c4.177,0,7.576-3.398,7.576-7.576V39.138 c0-4.177-3.398-7.576-7.576-7.576H39.14c-4.179,0-7.578,3.399-7.578,7.576v214.045c0,8.714-7.065,15.781-15.781,15.781 S0,261.897,0,253.183V39.138C0,17.558,17.558,0,39.14,0h433.722C494.442,0,512,17.558,512,39.138v433.723 C512,494.442,494.442,512,472.862,512z"}),(0,t.createElement)(n.Path,{fill:"#8ed1fc",d:"M428.658,187.438V92.85c0-5.252-4.258-9.508-9.508-9.508H92.852c-5.252,0-9.508,4.258-9.508,9.508 v94.588H428.658z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M428.658,203.221H83.344c-8.716,0-15.781-7.067-15.781-15.781V92.85 c0-13.944,11.345-25.289,25.289-25.289H419.15c13.944,0,25.289,11.345,25.289,25.289v94.588 C444.439,196.154,437.374,203.221,428.658,203.221z M99.125,171.659h313.752V99.123H99.125V171.659z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M256,444.439H92.852c-13.944,0-25.289-11.343-25.289-25.289V280.771 c0-8.714,7.065-15.781,15.781-15.781s15.781,7.067,15.781,15.781v132.105h141.096V203.221H83.344 c-8.716,0-15.781-7.067-15.781-15.781c0-8.714,7.065-15.781,15.781-15.781h172.658c8.714,0,15.781,7.067,15.781,15.781v241.218 C271.781,437.374,264.716,444.439,256,444.439z"}),(0,t.createElement)(n.Path,{fill:"#8ed1fc",d:"M256,187.438v241.22h163.15c5.252,0,9.508-4.258,9.508-9.508V187.438H256z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M419.15,444.439H256c-8.716,0-15.781-7.067-15.781-15.781V187.44c0-8.714,7.065-15.781,15.781-15.781 h172.658c8.714,0,15.781,7.067,15.781,15.781v231.71C444.439,433.095,433.094,444.439,419.15,444.439z M271.781,412.877h141.096 V203.221H271.781L271.781,412.877L271.781,412.877z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512.002 512.002"},(0,t.createElement)(n.Path,{fill:"#8ed1fc",d:"M419.15,83.345H92.852c-5.252,0-9.508,4.256-9.508,9.508v104.759h113.217v116.781H83.342v104.759 c0,5.252,4.258,9.508,9.508,9.508h111.604l0,0h214.693c5.252,0,9.508-4.256,9.508-9.508v-231.71V92.853 C428.658,87.601,424.4,83.345,419.15,83.345z"}),(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M419.15,444.439H92.85c-13.944,0-25.289-11.345-25.289-25.289V314.393 c0-8.716,7.065-15.781,15.781-15.781h97.436v-85.219H83.344c-8.716,0-15.781-7.065-15.781-15.781V92.853 c0-13.944,11.345-25.289,25.289-25.289h326.299c13.944,0,25.289,11.345,25.289,25.289v326.298 C444.439,433.095,433.094,444.439,419.15,444.439z M99.125,412.878h313.752V99.126H99.125v82.705h97.436 c8.716,0,15.781,7.065,15.781,15.781v116.781c0,8.716-7.065,15.781-15.781,15.781H99.125V412.878z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M472.862,512.001H39.14C17.558,512.001,0,494.443,0,472.862V345.894 c0-8.716,7.065-15.781,15.781-15.781s15.781,7.065,15.781,15.781v126.969c0,4.177,3.399,7.578,7.578,7.578h433.722 c4.177,0,7.578-3.399,7.578-7.578V39.141c0-4.177-3.399-7.578-7.578-7.578H39.14c-4.179,0-7.578,3.399-7.578,7.578v214.043 c0,8.716-7.065,15.781-15.781,15.781S0,261.9,0,253.184V39.141c0-21.582,17.558-39.14,39.14-39.14h433.722 c21.582,0,39.14,17.558,39.14,39.14v433.722C512,494.443,494.442,512.001,472.862,512.001z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M196.561,381.309c-8.716,0-15.781-7.065-15.781-15.781V83.345c0-8.716,7.065-15.781,15.781-15.781 s15.781,7.065,15.781,15.781v282.184C212.342,374.244,205.277,381.309,196.561,381.309z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M313.342,444.439c-8.716,0-15.781-7.065-15.781-15.781V146.473c0-8.716,7.065-15.781,15.781-15.781 c8.716,0,15.781,7.065,15.781,15.781v282.185C329.123,437.374,322.057,444.439,313.342,444.439z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M427.608,213.392H83.344c-8.716,0-15.781-7.065-15.781-15.781s7.065-15.781,15.781-15.781H427.61 c8.716,0,15.781,7.065,15.781,15.781C443.391,206.327,436.324,213.392,427.608,213.392z"})," ",(0,t.createElement)(n.Path,{fill:"#0693e3",d:"M427.608,330.173H83.873c-8.716,0-15.781-7.065-15.781-15.781c0-8.716,7.065-15.781,15.781-15.781 h343.736c8.716,0,15.781,7.065,15.781,15.781C443.389,323.108,436.324,330.173,427.608,330.173z"})),(0,t.createElement)(n.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 89.533 89.533"},(0,t.createElement)(n.Path,{d:"M88.083,77.293h-7.84V12.241h7.84c0.761,0,1.377-0.617,1.377-1.377c0-0.761-0.616-1.377-1.377-1.377h-8.106v-8.11 c0-0.76-0.617-1.377-1.377-1.377c-0.762,0-1.377,0.617-1.377,1.377v8.109H12.313V1.377c0-0.76-0.617-1.377-1.377-1.377 C10.175,0,9.56,0.617,9.56,1.377v8.109H1.451c-0.761,0-1.377,0.616-1.377,1.377c0,0.76,0.616,1.377,1.377,1.377H9.56v65.053H1.451 c-0.761,0-1.377,0.617-1.377,1.377c0,0.762,0.616,1.377,1.377,1.377H9.56v8.109c0,0.76,0.615,1.377,1.377,1.377 c0.76,0,1.377-0.617,1.377-1.377V80.17h64.909v7.986c0,0.76,0.615,1.377,1.377,1.377c0.76,0,1.377-0.617,1.377-1.377v-8.109h8.106 c0.761,0,1.377-0.615,1.377-1.377C89.459,77.91,88.843,77.293,88.083,77.293z M33.272,77.355H12.313V56.242h20.959V77.355z M33.272,55.324H12.313V34.272h20.959V55.324z M33.272,33.292H12.313V12.241h20.959V33.292z M55.304,77.355H34.19V56.242h21.114 V77.355z M55.304,55.324H34.19V34.272h21.114V55.324z M55.304,33.292H34.19V12.241h21.114V33.292z M77.335,77.355H56.222V56.242 h21.113V77.355z M77.335,55.324H56.222V34.272h21.113V55.324z M77.335,33.292H56.222V12.241h21.113V33.292z M75.673,53.434H58.341 V36.1h17.332V53.434z M53.433,53.434H36.101V36.1h17.333V53.434z M31.1,53.434H13.768V36.1H31.1V53.434z"}));var a=JSON.parse('{"u2":"dragblock/option"}');(0,e.registerBlockType)(a.u2,{edit:function(e){const{attributes:c,setAttributes:n,isSelected:a}=e;let{dragBlockText:o,dragBlockAttrs:h}=c,C=(0,r.useBlockProps)();if(o||(o=[]),!h){const e=[{slug:"value",value:""}];n({dragBlockAttrs:(0,l.cloneDeep)(e)}),h=e}return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("option",{...C},function(e){if(!(0,l.isArray)(e)||!e.length)return"";let t="",c="";for(let r of e)if(r.slug&&r.value&&!r.disable&&(t||(t=r.value),r.slug===dragBlockEditorInit.siteLocale)){c=r.value;break}return c||(c=t),c}(o)))},save:function(e){let c=r.useBlockProps.save();return(0,t.createElement)("option",{...c})}})}()}();