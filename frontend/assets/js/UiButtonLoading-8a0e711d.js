import{d as n,_ as t,r as l,o,c as a,a as d,x as i,n as r,e as p,a7 as c,i as _}from"./flag-icons.min-86ec5348.js";const f=n({props:{loading:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},spinnerColor:{type:String,default:"#fff"}}});const u=["disabled"],m={key:0,class:"spinner"};function y(e,g,B,v,C,b){const s=l("feather-icon");return o(),a("button",{class:"relative",disabled:e.loading||e.disabled},[d("span",{class:r({"opacity-0":e.loading})},[i(e.$slots,"default",{},void 0,!0)],2),e.loading?(o(),a("span",m,[p(s,{class:"animate-spin mt-1px",type:"loader",size:"18",style:c({color:e.spinnerColor})},null,8,["style"])])):_("",!0)],8,u)}const $=t(f,[["render",y],["__scopeId","data-v-74d87373"]]);export{$ as U};
