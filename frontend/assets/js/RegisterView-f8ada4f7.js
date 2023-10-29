import{d as u,k as d,_ as h,r as n,o as c,c as f,a as e,t,l as V,e as i,w as l,j as m}from"./flag-icons.min-86ec5348.js";import{U as g}from"./UiButtonLoading-8a0e711d.js";import{U as P}from"./UiInput-de72e1ee.js";const $=u({components:{UiButtonLoading:g,UiInput:P},data(){return{email:"",password:"",confirmPassword:"",buttonLoading:!1,newPasswordRegex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,newPasswordValidationMsg:"",confirmPasswordValidationMsg:""}},computed:{newPasswordValid(){return this.newPasswordRegex.test(this.password)},confirmPasswordValid(){return this.password===this.confirmPassword},passwordsValid(){return this.newPasswordValid&&this.confirmPasswordValid}},methods:{async register(){try{this.buttonLoading=!0,await this.registerUser({email:this.email,password:this.password,password_confirmation:this.confirmPassword}),await this.loginUser({email:this.email,password:this.password}),await this.loadStores(),await this.loadUserInfo(),this.buttonLoading=!1,this.$router.push({name:"dashboard"})}catch{this.buttonLoading=!1}},newPasswordValidator(){this.password?this.newPasswordValidationMsg=this.newPasswordValid?"":`${this.$t("At least 8 characters")} A-z, 0-9 and @$!%*#?&`:this.newPasswordValidationMsg="",this.confirmPasswordValidationMsg=""},confirmPasswordValidator(){this.confirmPassword?this.confirmPasswordValidationMsg=this.confirmPasswordValid?"":this.$t("Passwords do not match"):this.confirmPasswordValidationMsg="",this.newPasswordValidationMsg=""},...d("auth",["registerUser","loginUser"]),...d("stores",["loadStores"]),...d("user",["loadUserInfo"])}});const b={class:"card"},v={class:"text-3xl text-center"},y={class:"mt-1 mb-4 text-xl text-center"},M={class:"flex items-center justify-center pt-4 text-center"},U={class:"text-sm"};function _(s,a,A,C,L,k){const r=n("ui-input"),w=n("ui-button-loading"),p=n("router-link");return c(),f("div",b,[e("div",null,[e("h2",v,t(s.$t("Merchant")),1),e("h3",y,t(s.$t("Create your account")),1),e("form",{onSubmit:a[3]||(a[3]=V((...o)=>s.register&&s.register(...o),["prevent"]))},[i(r,{required:"",modelValue:s.email,"onUpdate:modelValue":a[0]||(a[0]=o=>s.email=o),class:"mb-6",type:"email",name:"email",placeholder:s.$t("Email")},null,8,["modelValue","placeholder"]),i(r,{required:"",modelValue:s.password,"onUpdate:modelValue":a[1]||(a[1]=o=>s.password=o),class:"mb-6",type:"password",name:"password",placeholder:s.$t("Password"),"is-valid":!s.newPasswordValid&&!!s.password,"vatidate-msg":s.newPasswordValidationMsg,onOnValidate:s.newPasswordValidator},null,8,["modelValue","placeholder","is-valid","vatidate-msg","onOnValidate"]),i(r,{required:"",modelValue:s.confirmPassword,"onUpdate:modelValue":a[2]||(a[2]=o=>s.confirmPassword=o),class:"mb-6",type:"password",name:"confirmPassword",placeholder:s.$t("Confirm password"),"is-valid":!s.confirmPasswordValid&&!!s.confirmPassword,"vatidate-msg":s.confirmPasswordValidationMsg,onOnValidate:s.confirmPasswordValidator},null,8,["modelValue","placeholder","is-valid","vatidate-msg","onOnValidate"]),i(w,{class:"button button-primary w-full my-4 p-2",type:"submit",loading:s.buttonLoading},{default:l(()=>[m(t(s.$t("Create account")),1)]),_:1},8,["loading"])],32)]),e("div",M,[e("span",U,t(s.$t("Already using Merchant?")),1),i(p,{to:"/login",class:"mx-2 text-sm text-primary-500 hover:text-primary-600 cursor-pointer"},{default:l(()=>[m(t(s.$t("Sign in here")),1)]),_:1})])])}const O=h($,[["render",_],["__scopeId","data-v-89bc23d9"]]);export{O as default};
