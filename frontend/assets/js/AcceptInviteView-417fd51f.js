import{d as p,k as a,_ as u,r as d,o as c,c as m,a as s,t as n,l as h,e as r,w,j as f}from"./flag-icons.min-86ec5348.js";import{U as b}from"./UiButtonLoading-8a0e711d.js";import{U as g}from"./UiInput-de72e1ee.js";const v=p({components:{UiButtonLoading:b,UiInput:g},data(){return{password:"",confirmPassword:"",buttonLoading:!1}},computed:{token(){return this.$route.query.token}},methods:{...a("invite",["acceptInvite"]),...a("auth",["loginUser"]),...a("stores",["loadStores"]),...a("user",["loadUserInfo"]),async acceptInviteHandler(){try{this.buttonLoading=!0;const t=await this.acceptInvite({token:this.token,password:this.password,password_confirmation:this.confirmPassword});await this.loginUser({email:t,password:this.password}),await this.loadStores(),await this.loadUserInfo(),this.buttonLoading=!1,this.$router.push({name:"dashboard"})}catch{this.buttonLoading=!1}}}}),$={class:"card"},y={class:"text-3xl text-center"},I={class:"mt-1 mb-2 text-xl text-center"},U={class:"mt-1 mb-4 text-gray-600"};function V(t,e,k,_,C,L){const i=d("ui-input"),l=d("ui-button-loading");return c(),m("div",$,[s("div",null,[s("h2",y,n(t.$t("Merchant")),1),s("h3",I,n(t.$t("Invite")),1),s("p",U,n(t.$t("Create account to accept invite")),1),s("form",{onSubmit:e[2]||(e[2]=h((...o)=>t.acceptInviteHandler&&t.acceptInviteHandler(...o),["prevent"]))},[r(i,{required:"",modelValue:t.password,"onUpdate:modelValue":e[0]||(e[0]=o=>t.password=o),type:"password",class:"mb-6",placeholder:t.$t("Password")},null,8,["modelValue","placeholder"]),r(i,{required:"",modelValue:t.confirmPassword,"onUpdate:modelValue":e[1]||(e[1]=o=>t.confirmPassword=o),type:"password",class:"mb-6",placeholder:t.$t("Confirm password")},null,8,["modelValue","placeholder"]),r(l,{class:"button button-primary w-full my-4 p-2",type:"submit",loading:t.buttonLoading},{default:w(()=>[f(n(t.$t("Create account")),1)]),_:1},8,["loading"])],32)])])}const q=u(v,[["render",V]]);export{q as default};