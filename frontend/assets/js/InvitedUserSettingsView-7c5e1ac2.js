import{d as U,f as u,k as L,_,r as p,o as t,c as i,a as o,t as a,h as d,l as $,F as v,q as f,e as g,w as y,j as b}from"./flag-icons.min-86ec5348.js";import{U as w}from"./UiCheckbox-fa9f1ce9.js";import{U as V}from"./UiButtonLoading-8a0e711d.js";import{U as x}from"./UiSkeletonBox-7e5f2b59.js";const I=U({components:{UiCheckbox:w,UiButtonLoading:V,UiSkeletonBox:x},data(){return{skeletonLoading:!0,selectedRoles:[],selectedStores:[],buttonLoading:!1}},computed:{...u("invite",{invitedUser:"invitedUser"}),...u("dictionaries",{allRoles:"roles"}),...u("stores",{storeList:"storeList"}),roles(){return this.allRoles.filter(e=>e!=="root")},id(){return this.$route.params.id}},watch:{invitedUser(){this.syncDataFromVuex()}},created(){this.loadUserData(),this.syncDataFromVuex()},methods:{...L("invite",["loadInvitedUser","sendInvite","updateInvitedUser"]),syncDataFromVuex(){this.selectedRoles=this.roles.map(e=>({title:e,value:e,checked:!!this.invitedUser.roles.find(n=>n===e)})),this.selectedStores=this.storeList.map(e=>({title:e.name,value:e.id,checked:!!this.invitedUser.stores.find(n=>n===e.id)}))},async loadUserData(){try{await this.loadInvitedUser(this.id),this.skeletonLoading=!1}catch{this.skeletonLoading=!1}},async saveHandler(){const e=this.selectedRoles.filter(l=>l.checked).map(l=>l.value),n=this.selectedStores.filter(l=>l.checked).map(l=>l.value);try{this.buttonLoading=!0,await this.updateInvitedUser({invitedId:this.id,payload:{roles:e,stores:n}}),this.buttonLoading=!1,this.$toast.success(this.$t("Settings successfully updated"))}catch{this.buttonLoading=!1}},async sendInviteHandler(){try{this.buttonLoading=!0,await this.sendInvite({email:this.invitedUser.email,role:this.invitedUser.role}),this.buttonLoading=!1,this.$toast.success(this.$t("Invite has been sent"))}catch{this.buttonLoading=!1}}}}),S={class:"page-title mb-6 flex items-center gap-2"},R={class:"card common-wrapper"},B={class:"card-title mb-4"},C={class:"mb-6"},D={key:1,class:"flex items-center gap-4"},F={class:"card-title mb-4"},H={key:0,class:"flex flex-col gap-4"},A={key:1,class:"flex flex-col gap-4"},N={class:"card-title mb-4"},E={key:0,class:"flex flex-col gap-4"},j={key:1,class:"flex flex-col gap-4"},q={key:1,class:"flex flex-col gap-8"},M={key:1,class:"text-red-500 font-600"};function T(e,n,l,z,G,J){const r=p("ui-skeleton-box"),m=p("ui-checkbox"),k=p("ui-button-loading");return t(),i("div",null,[o("div",S,[o("span",null,a(e.$t("Invited User")),1),o("span",null,a(e.invitedUser.email),1)]),o("div",R,[o("div",B,a(e.$t("User info")),1),o("div",C,[e.skeletonLoading?(t(),d(r,{key:0,width:"100%",height:"22px"})):(t(),i("div",D,[o("span",null,a(e.$t("Email"))+":",1),o("span",null,a(e.invitedUser.email),1)]))]),e.invitedUser.accept?(t(),i("form",{key:0,onSubmit:n[0]||(n[0]=$((...s)=>e.saveHandler&&e.saveHandler(...s),["prevent"])),class:"flex flex-col gap-10"},[o("div",null,[o("div",F,a(e.$t("User roles")),1),e.skeletonLoading?(t(),i("div",H,[(t(),i(v,null,f(2,s=>g(r,{key:s,width:"100%",height:"20px"})),64))])):(t(),i("div",A,[(t(!0),i(v,null,f(e.selectedRoles,(s,c)=>(t(),d(m,{class:"self-start",key:c,id:s.value,label:s.title,modelValue:s.checked,"onUpdate:modelValue":h=>s.checked=h},null,8,["id","label","modelValue","onUpdate:modelValue"]))),128))]))]),o("div",null,[o("div",N,a(e.$t("Access to stores")),1),e.skeletonLoading?(t(),i("div",E,[g(r,{width:"100%",height:"20px"})])):(t(),i("div",j,[(t(!0),i(v,null,f(e.selectedStores,(s,c)=>(t(),d(m,{class:"self-start",key:c,id:s.value,label:s.title,modelValue:s.checked,"onUpdate:modelValue":h=>s.checked=h},null,8,["id","label","modelValue","onUpdate:modelValue"]))),128))]))]),e.skeletonLoading?(t(),d(r,{key:0,width:"100%",height:"36px"})):(t(),d(k,{key:1,class:"button button-primary py-2 px-4 self-start",type:"submit",loading:e.buttonLoading},{default:y(()=>[b(a(e.$t("Save")),1)]),_:1},8,["loading"]))],32)):(t(),i("div",q,[e.skeletonLoading?(t(),d(r,{key:0,width:"100%",height:"22px"})):(t(),i("div",M,a(e.$t("User has not accepted invite yet")),1)),e.skeletonLoading?(t(),d(r,{key:2,width:"100%",height:"36px"})):(t(),d(k,{key:3,class:"button button-primary py-2 px-4 self-start",loading:e.buttonLoading,onClick:e.sendInviteHandler},{default:y(()=>[b(a(e.$t("Re-Send Invite")),1)]),_:1},8,["loading","onClick"]))]))])])}const W=_(I,[["render",T]]);export{W as default};
