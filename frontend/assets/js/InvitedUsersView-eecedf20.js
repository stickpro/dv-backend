import{d as y,f as k,m as b,k as _,_ as I,r as d,o as s,c as o,a as n,t as a,e as c,w as r,h as u,i as $,n as U,F as C,q as P,j as w}from"./flag-icons.min-86ec5348.js";import{U as x}from"./UiTable-55d04511.js";import{U as S}from"./UiCopyToClipboard-54d0ebb6.js";import"./UiSelect-ea4bca5c.js";import"./UiPagination-4e2c3226.js";import"./UiLoading-237702fa.js";const A=y({components:{UiTable:x,UiCopyToClipboard:S},data(){return{tableColumns:[{label:"Email",field:"email",textAlign:"text-left"},{label:"Invite date",field:"created_at",textAlign:"text-center"},{label:"Role by invite",field:"role",textAlign:"text-center"},{label:"Invite accepted",field:"accept",textAlign:"text-center"},{label:"Roles",field:"roles",textAlign:"text-center"},{label:"Invitation link",field:"token",textAlign:"text-center"},{label:"Actions",field:"actions",textAlign:"text-right"}],loading:!1,currentPage:"1",perPageDefault:"25"}},computed:{...k("invite",{isInvitedUsersLoaded:"isInvitedUsersLoaded",pagination:"pagination"}),...b("invite",{invitedUsers:"getInvitedUsers"}),invitationLink(){return e=>`${window.location.origin}/invite?token=${e}`}},async created(){this.invitedUsers.length&&this.$store.commit("app/setProgressBar","stop"),await this.loadInvitedUsersData(this.currentPage,this.perPageDefault),this.$store.commit("app/setProgressBar","stop")},methods:{..._("invite",["loadInvitedUsers","sendInvite"]),async loadInvitedUsersData(e,i){try{const l={page:e,perPage:i};await this.loadInvitedUsers(l),this.loading=!1}catch{this.$store.commit("app/setProgressBar","stop"),this.loading=!1}},perPageSelectHandler(e,i){this.loading=!0,this.loadInvitedUsersData(e,i)},pageChangeHandler(e,i){this.loading=!0,this.loadInvitedUsersData(e,i)},async reSendInviteHandler(e,i){try{this.loading=!0,await this.sendInvite({email:e,role:i}),this.loading=!1,this.$toast.success(this.$t("Invite has been sent"))}catch{this.loading=!1}}}}),L={class:"mb-6"},D={class:"flex items-center justify-between gap-2"},B={class:"page-title"},H={key:0,class:"card"},j={class:"text-gray-600 px-2 py-1 rounded bg-gray-200"},N={key:0,class:"flex items-center justify-center gap-2"},V={key:1,class:"text-gray-600"},R={class:"flex items-center gap-2 justify-center"},T=["href"],z={class:"flex justify-end gap-4"},E=["onClick"],F={key:1,class:"text-gray-600"};function q(e,i,l,G,Y,J){const h=d("feather-icon"),p=d("router-link"),v=d("ui-copy-to-clipboard"),f=d("ui-table");return s(),o("div",null,[n("div",L,[n("div",D,[n("div",B,a(e.$t("Invited Users")),1),c(p,{class:"button button-primary px-6 py-3 flex items-center gap-2",to:{name:"invited-users-invite"}},{default:r(()=>[c(h,{type:"plus",size:"18"}),n("span",null,a(e.$t("Invite User")),1)]),_:1})])]),e.isInvitedUsersLoaded?(s(),o("div",H,[e.invitedUsers.length?(s(),u(f,{key:0,columns:e.tableColumns,data:e.invitedUsers,paginationable:"",loading:e.loading,"per-page-default":e.perPageDefault,"total-entries":e.pagination.total,onPerPageSelectChanged:e.perPageSelectHandler,onPageChanged:e.pageChangeHandler},{"cell-role":r(({row:t})=>[n("span",j,a(t.role),1)]),"cell-accept":r(({row:t})=>[n("span",{class:U([t.accept?"success-status":"error-status"])},a(t.accept?e.$t("Yes"):e.$t("No")),3)]),"cell-roles":r(({row:t})=>[t.roles?(s(),o("div",N,[(s(!0),o(C,null,P(t.roles,(g,m)=>(s(),o("span",{key:m,class:"text-gray-600 px-2 py-1 rounded bg-gray-200"},a(g),1))),128))])):(s(),o("div",V,a(e.$t("Roles are not set yet")),1))]),"cell-token":r(({row:t})=>[n("div",R,[n("a",{href:e.invitationLink(t.token),target:"_blank",class:"link"},a(`${e.invitationLink(t.token).slice(0,20)}...${e.invitationLink(t.token).slice(-7)}`),9,T),c(v,{"text-to-copy":e.invitationLink(t.token)},null,8,["text-to-copy"])])]),"cell-actions":r(({row:t})=>[n("div",z,[t.accept?(s(),u(p,{key:1,to:{name:"invited-users-user",params:{id:t.id}},class:"button button-primary py-1 px-2"},{default:r(()=>[w(a(e.$t("Settings")),1)]),_:2},1032,["to"])):(s(),o("button",{key:0,class:"button button-secondary py-1 px-2",onClick:g=>e.reSendInviteHandler(t.email,t.role)},a(e.$t("Re-Send Invite")),9,E))])]),_:1},8,["columns","data","loading","per-page-default","total-entries","onPerPageSelectChanged","onPageChanged"])):(s(),o("div",F,a(e.$t("There are no invited users.")),1))])):$("",!0)])}const Z=I(A,[["render",q]]);export{Z as default};
