import{d as a,_ as n,r as p,o,c,h as r,n as l}from"./flag-icons.min-86ec5348.js";const d=a({props:{textToCopy:{type:String,required:!0},hoverHint:{type:Boolean,default:!1},size:{type:String,default:"16"}},data(){return{timer:0,check:!1,hoverText:"Copy to clipboard"}},methods:{clickHandler(){this.$copyText.toClipboard(this.textToCopy),this.hoverText="Copied",this.check=!0,this.timer=setTimeout(()=>{this.hoverText="Copy to clipboard",this.check=!1},1e3)}},beforeUnmount(){clearTimeout(this.timer)}});const h=["data-tooltip"];function y(e,t,u,_,m,f){const i=p("feather-icon");return o(),c("div",{"aria-hidden":"true",class:l(["copy",{hoverhint:e.hoverHint}]),"data-tooltip":e.hoverText,onClick:t[0]||(t[0]=(...s)=>e.clickHandler&&e.clickHandler(...s))},[e.check?(o(),r(i,{key:0,type:"check",size:e.size},null,8,["size"])):(o(),r(i,{key:1,type:"copy",size:e.size},null,8,["size"]))],10,h)}const C=n(d,[["render",y],["__scopeId","data-v-bddbe79a"]]);export{C as U};
