"use strict";(self.webpackChunkdragblock=self.webpackChunkdragblock||[]).push([[7905],{7905:function(t,s,n){n.r(s),n.d(s,{DSIG:function(){return e}});var r=n(2592);class e extends r.x{constructor(t,s){const{p:n}=super(t,s);this.version=n.uint32,this.numSignatures=n.uint16,this.flags=n.uint16,this.signatureRecords=[...new Array(this.numSignatures)].map((t=>new i(n)))}getData(t){const s=this.signatureRecords[t];return this.parser.currentPosition=this.tableStart+s.offset,new u(this.parser)}}class i{constructor(t){this.format=t.uint32,this.length=t.uint32,this.offset=t.Offset32}}class u{constructor(t){t.uint16,t.uint16,this.signatureLength=t.uint32,this.signature=t.readBytes(this.signatureLength)}}}}]);