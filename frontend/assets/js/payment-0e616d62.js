import{d as g,D as h,P as O,_ as b,r as E,o as P,h as A,w as L,e as T,y as C,L as _,M as u,N as D,O as $,Q as M,R as S,T as r,U as V,V as f,W as w,X as N,Y as j,B as R,C as k,E as B,S as I,G as Y,H,I as U,J as W,K as F}from"./flag-icons.min-86ec5348.js";const G=g({components:{DefaultLayout:h,PaymentLayout:O},computed:{resolveLayout(){return this.$route.meta.layout||"default-layout"}}});function J(o,t,n,i,a,l){const c=E("router-view");return P(),A(C(o.resolveLayout),null,{default:L(()=>[T(c)]),_:1})}const K=b(G,[["render",J]]),Q=[{path:"/invoices/:invoice_id",name:"invoice",component:()=>_(()=>import("./InvoicePaymentFormView-95c58698.js"),["assets/js/InvoicePaymentFormView-95c58698.js","assets/js/flag-icons.min-86ec5348.js","assets/css/flag-icons-372b6dc5.css","assets/js/UiButtonLoading-8a0e711d.js","assets/css/UiButtonLoading-3c9e19b2.css","assets/js/image-9977a1bb.js","assets/js/PaymentFormLocale-0a7fa924.js","assets/css/PaymentFormLocale-f9825572.css","assets/js/UiCopyToClipboard-54d0ebb6.js","assets/css/UiCopyToClipboard-0becc45a.css","assets/js/UiLoading-237702fa.js","assets/css/UiLoading-fa604bbe.css","assets/js/UiExpand-e56b18da.js","assets/css/UiExpand-daa72346.css","assets/js/UiSkeletonBox-7e5f2b59.js","assets/css/UiSkeletonBox-6efe2082.css","assets/css/InvoicePaymentFormView-50189d5d.css"]),meta:{layout:u.PAYMENT}},{path:"/invoices/payer/:payer_id",name:"payer",component:()=>_(()=>import("./PayerFormView-339ee207.js"),["assets/js/PayerFormView-339ee207.js","assets/js/flag-icons.min-86ec5348.js","assets/css/flag-icons-372b6dc5.css","assets/js/image-9977a1bb.js","assets/js/PaymentFormLocale-0a7fa924.js","assets/css/PaymentFormLocale-f9825572.css","assets/js/UiCopyToClipboard-54d0ebb6.js","assets/css/UiCopyToClipboard-0becc45a.css","assets/js/UiButtonLoading-8a0e711d.js","assets/css/UiButtonLoading-3c9e19b2.css","assets/js/UiSkeletonBox-7e5f2b59.js","assets/css/UiSkeletonBox-6efe2082.css","assets/css/PayerFormView-2463c318.css"]),meta:{middleware:[D,$],layout:u.PAYMENT}},{path:"/:pathMatch(.*)*",name:"page-not-found",component:()=>_(()=>import("./PageNotFoundView-53c0643a.js"),["assets/js/PageNotFoundView-53c0643a.js","assets/js/flag-icons.min-86ec5348.js","assets/css/flag-icons-372b6dc5.css"]),meta:{layout:u.DEFAULT}}],X=M({history:S("/"),routes:Q}),v={app:w,invoice:N,payer:j},y=r(v),q=V({modules:v,mutations:{resetStore(o){f(y,(t,n)=>{Object.assign(o[n],r(t.state))})},resetStoreExclude(o,t){f(y,(n,i)=>{var c;const a=Object.keys((t==null?void 0:t.states)||{}).find(s=>s===i),l=(c=t==null?void 0:t.modules)==null?void 0:c.find(s=>s===i);a?Object.keys(o[a]).forEach(s=>{var m;Object.values((t==null?void 0:t.states)||{}).map(p=>p.find(d=>d===s)).filter(p=>p)[0]?o[a][s]=r(o[a][s]):o[a][s]=r((m=n.state)==null?void 0:m[s])}):l||Object.assign(o[i],r(n.state))})}}}),z={transition:"Vue-Toastification__fade",timeout:3e3,draggable:!1,hideProgressBar:!0,icon:!1,toastClassName:"toast__class",bodyClassName:["toast__class-body"]},e=R(K);e.use(k);e.use(B,z);e.use(q);e.use(X);e.use(I);e.component("feather-icon",Y);e.directive("clickOut",H);e.directive("regexp-validate",U);e.mount("#app");e.config.globalProperties.$toast=W();e.config.globalProperties.$copyText=F();
