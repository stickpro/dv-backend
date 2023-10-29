import{d as p,k as u,_ as m,r as n,o as c,c as v,a as o,t as i,l as f,e as l,w as _,j as b}from"./flag-icons.min-86ec5348.js";import{U as h}from"./UiSelect-ea4bca5c.js";import{U as I}from"./UiButtonLoading-8a0e711d.js";import{U as g}from"./UiInput-de72e1ee.js";const $=p({components:{UiSelect:h,UiButtonLoading:I,UiInput:g},data(){return{emailForInvite:"",roleSelected:"support",rolesOptions:[{title:"Suppport",value:"support"}],buttonLoading:!1}},methods:{...u("invite",["sendInvite"]),async inviteHandler(){try{this.buttonLoading=!0,await this.sendInvite({email:this.emailForInvite,role:this.roleSelected}),this.buttonLoading=!1,this.$toast.success(this.$t("Invite has been sent"))}catch{this.buttonLoading=!1}}}});const S={class:"page-title mb-6"},U={class:"card common-wrapper"},V={class:"text-2xl mb-6"},y={class:"form-group"},w={for:"rolesSelect",class:"self-start"};function F(e,t,L,B,k,C){const a=n("ui-input"),r=n("ui-select"),d=n("ui-button-loading");return c(),v("div",null,[o("div",S,i(e.$t("Invite User")),1),o("div",U,[o("div",V,i(e.$t("Invite")),1),o("form",{class:"form",onSubmit:t[2]||(t[2]=f((...s)=>e.inviteHandler&&e.inviteHandler(...s),["prevent"]))},[l(a,{required:"",modelValue:e.emailForInvite,"onUpdate:modelValue":t[0]||(t[0]=s=>e.emailForInvite=s),type:"email",id:"emailForInvite",placeholder:e.$t("Email"),label:e.$t("Email For Invite")},null,8,["modelValue","placeholder","label"]),o("div",y,[o("label",w,i(e.$t("Role")),1),l(r,{id:"rolesSelect",class:"max-w-120px h-40px",modelValue:e.roleSelected,"onUpdate:modelValue":t[1]||(t[1]=s=>e.roleSelected=s),options:e.rolesOptions},null,8,["modelValue","options"])]),l(d,{class:"button button-primary py-2 px-4 self-start mt-2",type:"submit",loading:e.buttonLoading},{default:_(()=>[b(i(e.$t("Send Invite")),1)]),_:1},8,["loading"])],32)])])}const j=m($,[["render",F],["__scopeId","data-v-5c2cf521"]]);export{j as default};
