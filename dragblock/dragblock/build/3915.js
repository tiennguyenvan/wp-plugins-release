"use strict";(self.webpackChunkdragblock=self.webpackChunkdragblock||[]).push([[3915],{3915:function(t,e,s){s.r(e),s.d(e,{cmap:function(){return S}});var r=s(2592),n=s(3478);class o extends n.j{constructor(t,e,s){super(t),this.plaformID=e,this.encodingID=s}}class i extends o{constructor(t,e,s){super(t,e,s),this.format=0,this.length=t.uint16,this.language=t.uint16,this.glyphIdArray=[...new Array(256)].map((e=>t.uint8))}supports(t){return t.charCodeAt&&(t=-1,console.warn("supports(character) not implemented for cmap subtable format 0. only supports(id) is implemented.")),0<=t&&t<=255}reverse(t){return console.warn("reverse not implemented for cmap subtable format 0"),{}}getSupportedCharCodes(){return[{start:1,end:256}]}}var a=s(7047);class u extends o{constructor(t,e,s){super(t,e,s),this.format=2,this.length=t.uint16,this.language=t.uint16,this.subHeaderKeys=[...new Array(256)].map((e=>t.uint16));const r=Math.max(...this.subHeaderKeys),n=t.currentPosition;(0,a.Z)(this,"subHeaders",(()=>(t.currentPosition=n,[...new Array(r)].map((e=>new h(t))))));const o=n+8*r;(0,a.Z)(this,"glyphIndexArray",(()=>(t.currentPosition=o,[...new Array(r)].map((e=>t.uint16)))))}supports(t){t.charCodeAt&&(t=-1,console.warn("supports(character) not implemented for cmap subtable format 2. only supports(id) is implemented."));const e=t&&255,s=t&&65280,r=this.subHeaders[s],n=this.subHeaders[r],o=n.firstCode,i=o+n.entryCount;return o<=e&&e<=i}reverse(t){return console.warn("reverse not implemented for cmap subtable format 2"),{}}getSupportedCharCodes(t=!1){return t?this.subHeaders.map((t=>({firstCode:t.firstCode,lastCode:t.lastCode}))):this.subHeaders.map((t=>({start:t.firstCode,end:t.lastCode})))}}class h{constructor(t){this.firstCode=t.uint16,this.entryCount=t.uint16,this.lastCode=this.first+this.entryCount,this.idDelta=t.int16,this.idRangeOffset=t.uint16}}class d extends o{constructor(t,e,s){super(t,e,s),this.format=4,this.length=t.uint16,this.language=t.uint16,this.segCountX2=t.uint16,this.segCount=this.segCountX2/2,this.searchRange=t.uint16,this.entrySelector=t.uint16,this.rangeShift=t.uint16;const r=t.currentPosition;(0,a.Z)(this,"endCode",(()=>t.readBytes(this.segCount,r,16)));const n=r+2+this.segCountX2;(0,a.Z)(this,"startCode",(()=>t.readBytes(this.segCount,n,16)));const o=n+this.segCountX2;(0,a.Z)(this,"idDelta",(()=>t.readBytes(this.segCount,o,16,!0)));const i=o+this.segCountX2;(0,a.Z)(this,"idRangeOffset",(()=>t.readBytes(this.segCount,i,16)));const u=i+this.segCountX2,h=this.length-(u-this.tableStart);(0,a.Z)(this,"glyphIdArray",(()=>t.readBytes(h,u,16))),(0,a.Z)(this,"segments",(()=>this.buildSegments(i,u,t)))}buildSegments(t,e,s){return[...new Array(this.segCount)].map(((e,r)=>{let n=this.startCode[r],o=this.endCode[r],i=this.idDelta[r],a=this.idRangeOffset[r],u=t+2*r,h=[];if(0===a)for(let t=n+i,e=o+i;t<=e;t++)h.push(t);else for(let t=0,e=o-n;t<=e;t++)s.currentPosition=u+a+2*t,h.push(s.uint16);return{startCode:n,endCode:o,idDelta:i,idRangeOffset:a,glyphIDs:h}}))}reverse(t){let e=this.segments.find((e=>e.glyphIDs.includes(t)));if(!e)return{};const s=e.startCode+e.glyphIDs.indexOf(t);return{code:s,unicode:String.fromCodePoint(s)}}getGlyphId(t){if(t.charCodeAt&&(t=t.charCodeAt(0)),55296<=t&&t<=57343)return 0;if(65534==(65534&t)||65535==(65535&t))return 0;let e=this.segments.find((e=>e.startCode<=t&&t<=e.endCode));return e?e.glyphIDs[t-e.startCode]:0}supports(t){return 0!==this.getGlyphId(t)}getSupportedCharCodes(t=!1){return t?this.segments:this.segments.map((t=>({start:t.startCode,end:t.endCode})))}}class p extends o{constructor(t,e,s){super(t,e,s),this.format=6,this.length=t.uint16,this.language=t.uint16,this.firstCode=t.uint16,this.entryCount=t.uint16,this.lastCode=this.firstCode+this.entryCount-1,(0,a.Z)(this,"glyphIdArray",(()=>[...new Array(this.entryCount)].map((e=>t.uint16))))}supports(t){if(t.charCodeAt&&(t=-1,console.warn("supports(character) not implemented for cmap subtable format 6. only supports(id) is implemented.")),t<this.firstCode)return{};if(t>this.firstCode+this.entryCount)return{};const e=t-this.firstCode;return{code:e,unicode:String.fromCodePoint(e)}}reverse(t){let e=this.glyphIdArray.indexOf(t);if(e>-1)return this.firstCode+e}getSupportedCharCodes(t=!1){return t?[{firstCode:this.firstCode,lastCode:this.lastCode}]:[{start:this.firstCode,end:this.lastCode}]}}class c extends o{constructor(t,e,s){super(t,e,s),this.format=8,t.uint16,this.length=t.uint32,this.language=t.uint32,this.is32=[...new Array(8192)].map((e=>t.uint8)),this.numGroups=t.uint32,(0,a.Z)(this,"groups",(()=>[...new Array(this.numGroups)].map((e=>new l(t)))))}supports(t){return t.charCodeAt&&(t=-1,console.warn("supports(character) not implemented for cmap subtable format 8. only supports(id) is implemented.")),-1!==this.groups.findIndex((e=>e.startcharCode<=t&&t<=e.endcharCode))}reverse(t){return console.warn("reverse not implemented for cmap subtable format 8"),{}}getSupportedCharCodes(t=!1){return t?this.groups:this.groups.map((t=>({start:t.startcharCode,end:t.endcharCode})))}}class l{constructor(t){this.startcharCode=t.uint32,this.endcharCode=t.uint32,this.startGlyphID=t.uint32}}class C extends o{constructor(t,e,s){super(t,e,s),this.format=10,t.uint16,this.length=t.uint32,this.language=t.uint32,this.startCharCode=t.uint32,this.numChars=t.uint32,this.endCharCode=this.startCharCode+this.numChars,(0,a.Z)(this,"glyphs",(()=>[...new Array(this.numChars)].map((e=>t.uint16))))}supports(t){return t.charCodeAt&&(t=-1,console.warn("supports(character) not implemented for cmap subtable format 10. only supports(id) is implemented.")),!(t<this.startCharCode)&&!(t>this.startCharCode+this.numChars)&&t-this.startCharCode}reverse(t){return console.warn("reverse not implemented for cmap subtable format 10"),{}}getSupportedCharCodes(t=!1){return t?[{startCharCode:this.startCharCode,endCharCode:this.endCharCode}]:[{start:this.startCharCode,end:this.endCharCode}]}}class m extends o{constructor(t,e,s){super(t,e,s),this.format=12,t.uint16,this.length=t.uint32,this.language=t.uint32,this.numGroups=t.uint32,(0,a.Z)(this,"groups",(()=>[...new Array(this.numGroups)].map((e=>new g(t)))))}supports(t){return t.charCodeAt&&(t=t.charCodeAt(0)),55296<=t&&t<=57343||65534==(65534&t)||65535==(65535&t)?0:-1!==this.groups.findIndex((e=>e.startCharCode<=t&&t<=e.endCharCode))}reverse(t){for(let e of this.groups){let s=e.startGlyphID;if(s>t)continue;if(s===t)return e.startCharCode;if(s+(e.endCharCode-e.startCharCode)<t)continue;const r=e.startCharCode+(t-s);return{code:r,unicode:String.fromCodePoint(r)}}return{}}getSupportedCharCodes(t=!1){return t?this.groups:this.groups.map((t=>({start:t.startCharCode,end:t.endCharCode})))}}class g{constructor(t){this.startCharCode=t.uint32,this.endCharCode=t.uint32,this.startGlyphID=t.uint32}}class f extends o{constructor(t,e,s){super(t,e,s),this.format=13,t.uint16,this.length=t.uint32,this.language=t.uint32,this.numGroups=t.uint32;const r=[...new Array(this.numGroups)].map((e=>new b(t)));(0,a.Z)(this,"groups",r)}supports(t){return t.charCodeAt&&(t=t.charCodeAt(0)),-1!==this.groups.findIndex((e=>e.startCharCode<=t&&t<=e.endCharCode))}reverse(t){return console.warn("reverse not implemented for cmap subtable format 13"),{}}getSupportedCharCodes(t=!1){return t?this.groups:this.groups.map((t=>({start:t.startCharCode,end:t.endCharCode})))}}class b{constructor(t){this.startCharCode=t.uint32,this.endCharCode=t.uint32,this.glyphID=t.uint32}}class y extends o{constructor(t,e,s){super(t,e,s),this.subTableStart=t.currentPosition,this.format=14,this.length=t.uint32,this.numVarSelectorRecords=t.uint32,(0,a.Z)(this,"varSelectors",(()=>[...new Array(this.numVarSelectorRecords)].map((e=>new w(t)))))}supports(){return console.warn("supports not implemented for cmap subtable format 14"),0}getSupportedCharCodes(){return console.warn("getSupportedCharCodes not implemented for cmap subtable format 14"),[]}reverse(t){return console.warn("reverse not implemented for cmap subtable format 14"),{}}supportsVariation(t){return this.varSelector.find((e=>e.varSelector===t))||!1}getSupportedVariations(){return this.varSelectors.map((t=>t.varSelector))}}class w{constructor(t){this.varSelector=t.uint24,this.defaultUVSOffset=t.Offset32,this.nonDefaultUVSOffset=t.Offset32}}class S extends r.x{constructor(t,e){const{p:s}=super(t,e);this.version=s.uint16,this.numTables=s.uint16,this.encodingRecords=[...new Array(this.numTables)].map((t=>new I(s,this.tableStart)))}getSubTable(t){return this.encodingRecords[t].table}getSupportedEncodings(){return this.encodingRecords.map((t=>({platformID:t.platformID,encodingId:t.encodingID})))}getSupportedCharCodes(t,e){const s=this.encodingRecords.findIndex((s=>s.platformID===t&&s.encodingID===e));return-1!==s&&this.getSubTable(s).getSupportedCharCodes()}reverse(t){for(let e=0;e<this.numTables;e++){let s=this.getSubTable(e).reverse(t);if(s)return s}}getGlyphId(t){let e=0;return this.encodingRecords.some(((s,r)=>{let n=this.getSubTable(r);return!!n.getGlyphId&&(e=n.getGlyphId(t),0!==e)})),e}supports(t){return this.encodingRecords.some(((e,s)=>{const r=this.getSubTable(s);return r.supports&&!1!==r.supports(t)}))}supportsVariation(t){return this.encodingRecords.some(((e,s)=>{const r=this.getSubTable(s);return r.supportsVariation&&!1!==r.supportsVariation(t)}))}}class I{constructor(t,e){const s=this.platformID=t.uint16,r=this.encodingID=t.uint16,n=this.offset=t.Offset32;(0,a.Z)(this,"table",(()=>(t.currentPosition=e+n,function(t,e,s){const r=t.uint16;return 0===r?new i(t,e,s):2===r?new u(t,e,s):4===r?new d(t,e,s):6===r?new p(t,e,s):8===r?new c(t,e,s):10===r?new C(t,e,s):12===r?new m(t,e,s):13===r?new f(t,e,s):14===r?new y(t,e,s):{}}(t,s,r))))}}}}]);