"use strict";(self.webpackChunkdragblock=self.webpackChunkdragblock||[]).push([[9132],{9132:function(t,n,s){s.r(n),s.d(n,{name:function(){return e}}),s(6770);var i=s(2592),r=s(7047);class e extends i.x{constructor(t,n){const{p:s}=super(t,n);this.format=s.uint16,this.count=s.uint16,this.stringOffset=s.Offset16,this.nameRecords=[...new Array(this.count)].map((t=>new a(s,this))),1===this.format&&(this.langTagCount=s.uint16,this.langTagRecords=[...new Array(this.langTagCount)].map((t=>new o(s.uint16,s.Offset16)))),this.stringStart=this.tableStart+this.stringOffset}get(t){let n=this.nameRecords.find((n=>n.nameID===t));if(n)return n.string}}class o{constructor(t,n){this.length=t,this.offset=n}}class a{constructor(t,n){this.platformID=t.uint16,this.encodingID=t.uint16,this.languageID=t.uint16,this.nameID=t.uint16,this.length=t.uint16,this.offset=t.Offset16,(0,r.Z)(this,"string",(()=>(t.currentPosition=n.stringStart+this.offset,function(t,n){const{platformID:s,length:i}=n;if(0===i)return"";if(0===s||3===s){const n=[];for(let s=0,r=i/2;s<r;s++)n[s]=String.fromCharCode(t.uint16);return n.join("")}const r=t.readBytes(i),e=[];return r.forEach((function(t,n){e[n]=String.fromCharCode(t)})),e.join("")}(t,this))))}}}}]);