import{d as l,_ as n,r as i,o as s,c as t,a as r,t as p,i as a,h}from"./flag-icons.min-86ec5348.js";const k=l({props:{id:{type:String},label:{type:String},modelValue:{type:Boolean},disabled:{type:Boolean,default:!1}},emits:["checked","update:modelValue"],methods:{checkboxHandler(e){const o=e.target.checked;this.$emit("update:modelValue",o),this.$emit("checked")}}});const m={class:"checkbox-wrapper"},u=["id","checked","disabled"],_=["for"];function b(e,o,f,y,V,B){const c=i("feather-icon");return s(),t("div",m,[r("input",{id:e.id,checked:e.modelValue,class:"checkbox",type:"checkbox",onInput:o[0]||(o[0]=(...d)=>e.checkboxHandler&&e.checkboxHandler(...d)),disabled:e.disabled},null,40,u),e.label?(s(),t("label",{key:0,for:e.id,class:"ml-4"},p(e.label),9,_)):a("",!0),e.modelValue?(s(),h(c,{key:1,type:"check",size:"16","stroke-width":"3",class:"check-icon"})):a("",!0)])}const g=n(k,[["render",b],["__scopeId","data-v-779f6f05"]]);export{g as U};
