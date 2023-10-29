import{d as y,f as g,k as R,_ as v,r as o,o as t,c as i,a,t as s,h as w,w as h,e as u,j as L,F as B,q as S,i as f,l as T}from"./flag-icons.min-86ec5348.js";import{U as C}from"./UiCopyToClipboard-54d0ebb6.js";import{U as A}from"./UiTable-55d04511.js";import{U as I}from"./UiModal-af306091.js";import{U as x}from"./UiSkeletonBox-7e5f2b59.js";import{U as W}from"./UiInput-de72e1ee.js";import{U as H}from"./UiSelect-ea4bca5c.js";import{U as V}from"./UiButtonLoading-8a0e711d.js";import"./UiPagination-4e2c3226.js";import"./UiLoading-237702fa.js";const M=y({components:{UiCopyToClipboard:C,UiTable:A,UiModal:I,UiSkeletonBox:x},data(){return{skeletonLoading:!1,tableColumns:[{label:"Address",field:"address",textAlign:"text-left"},{label:"Blockchain",field:"blockchain",textAlign:"text-center"},{label:"Settings",field:"settings",textAlign:"text-right"},{label:"Actions",field:"actions",textAlign:"text-right"}],showModal:!1,address:"",modalLoading:!1,selectedBlockchain:"",disabledConfirm:!1}},computed:{...g("wallets",{wallets:"wallets",isWalletsLoaded:"isWalletsLoaded"}),currencyId(){return this.selectedBlockchain==="bitcoin"?"BTC.Bitcoin":this.selectedBlockchain==="tron"?"USDT.Tron":""}},created(){this.loadData()},methods:{...R("wallets",["loadAndCreateWallets","withdrawalsRequest"]),async loadData(){try{this.isWalletsLoaded||(this.skeletonLoading=!0),this.isWalletsLoaded&&this.$store.commit("app/setProgressBar","stop"),await this.loadAndCreateWallets(),this.$store.commit("app/setProgressBar","stop"),this.skeletonLoading=!1}catch{this.$store.commit("app/setProgressBar","stop"),this.skeletonLoading=!1}},showModalHandler(e,l){this.address="",this.selectedBlockchain="",this.showModal=!0,this.address=e,this.selectedBlockchain=l,this.disabledConfirm=!e},confirmModalHandler(){this.address?this.withdrawalHandler():this.showModal=!1},async withdrawalHandler(){try{this.modalLoading=!0,await this.withdrawalsRequest({currencyId:this.currencyId}),this.modalLoading=!1,this.$toast.success(this.$t("The request has been successfully sent")),this.showModal=!1}catch{this.modalLoading=!1}}}}),E={class:"card"},U={class:"card-title mb-4"},F={key:0,class:"flex items-center gap-2"},D={key:1,class:"text-gray-600"},O={class:"uppercase"},N=["onClick"],j={key:0,class:"flex flex-col gap-2 items-center"},q={class:"flex items-center gap-2 break-all"},K={class:"font-500"},P={key:1,class:"flex flex-col gap-2"};function z(e,l,_,$,k,b){const c=o("ui-skeleton-box"),r=o("ui-copy-to-clipboard"),p=o("router-link"),m=o("ui-table"),n=o("ui-modal");return t(),i("div",null,[a("div",E,[a("div",U,s(e.$t("Wallets for withdrawals")),1),e.skeletonLoading?(t(),w(c,{key:0,width:"100%",height:"167px"})):(t(),w(m,{key:1,columns:e.tableColumns,data:e.wallets},{"cell-address":h(({row:d})=>[d.address?(t(),i("div",F,[a("span",null,s(d.address),1),u(r,{"text-to-copy":d.address},null,8,["text-to-copy"])])):(t(),i("div",D,s(e.$t("Enter address in settings")),1))]),"cell-blockchain":h(({row:d})=>[a("span",O,s(d.blockchain),1)]),"cell-settings":h(({row:d})=>[u(p,{class:"cursor-pointer text-primary-500 hover:text-primary-600",to:{name:"wallets-withdrawals-settings",params:{wallet_id:d.id}}},{default:h(()=>[L(s(e.$t("Settings")),1)]),_:2},1032,["to"])]),"cell-actions":h(({row:d})=>[a("button",{class:"button button-primary py-1 px-2",onClick:Me=>e.showModalHandler(d.address,d.blockchain)},s(e.$t("Withdrawal")),9,N)]),_:1},8,["columns","data"]))]),u(n,{modelValue:e.showModal,"onUpdate:modelValue":l[0]||(l[0]=d=>e.showModal=d),loading:e.modalLoading,"disabled-confirm":e.disabledConfirm,onConfirm:e.confirmModalHandler},{title:h(()=>[L(s(e.$t("Request a withdrawal")),1)]),default:h(()=>[e.address?(t(),i("div",j,[a("div",null,s(e.$t("To Address"))+": ",1),a("div",q,[a("span",K,s(e.address),1),u(r,{"text-to-copy":e.address},null,8,["text-to-copy"])])])):(t(),i("div",P,[a("div",null,s(e.$t("Address is empty")),1),a("div",null,s(e.$t("First specify the address for withdrawal in the settings")),1)]))]),_:1},8,["modelValue","loading","disabled-confirm","onConfirm"])])}const G=v(M,[["render",z]]),J=y({components:{UiTable:A,UiSkeletonBox:x},data(){return{skeletonLoading:!1,tableColumns:[{label:"Exchange name",field:"exchange",textAlign:"text-left"},{label:"Api Keys",field:"keys",textAlign:"text-center"},{label:"Actions",field:"actions",textAlign:"text-right"}]}},computed:{showKeys(){return e=>this.listOfExchanges.filter(l=>l.exchange.toLowerCase()===e.toLowerCase())[0].keys.map(l=>l.value).some(l=>l)},...g("exchanges",{listOfExchanges:"listOfExchanges",isListOfExchangesLoaded:"isListOfExchangesLoaded"})},created(){this.loadData()},methods:{...R("exchanges",["loadListOfExchanges"]),async loadData(){try{this.isListOfExchangesLoaded||(this.skeletonLoading=!0),await this.loadListOfExchanges(),this.skeletonLoading=!1}catch{this.skeletonLoading=!1}}}}),Q={class:"card"},X={class:"card-title mb-4"},Y={key:1},Z={key:0,class:"flex flex-col gap-2"},ee={key:0,class:"flex gap-2 items-center justify-center"},te={key:1,class:"text-gray-600"},ae={class:"mt-6"};function se(e,l,_,$,k,b){const c=o("ui-skeleton-box"),r=o("router-link"),p=o("ui-table");return t(),i("div",Q,[a("div",X,s(e.$t("List of exchanges")),1),e.skeletonLoading?(t(),w(c,{key:0,width:"100%",height:"194px"})):(t(),i("div",Y,[u(p,{columns:e.tableColumns,data:e.listOfExchanges},{"cell-keys":h(({row:m})=>[e.showKeys(m.exchange)?(t(),i("div",Z,[(t(!0),i(B,null,S(m.keys,(n,d)=>(t(),i("div",{key:d,class:"flex justify-center"},[n.value?(t(),i("div",ee,[a("span",null,s(n.title)+": ",1),a("span",null,s(n.value),1)])):f("",!0)]))),128))])):(t(),i("div",te,s(e.$t("Enter keys in settings")),1))]),"cell-actions":h(({row:m})=>[u(r,{class:"cursor-pointer text-primary-500 hover:text-primary-600",to:{name:"withdrawals-exchange-1",params:{exchange_name:m.exchange.toLowerCase()}}},{default:h(()=>[L(s(e.$t("Settings")),1)]),_:2},1032,["to"])]),_:1},8,["columns","data"]),a("div",ae,s(e.$t("list_of_exchanges_help_text")),1)]))])}const le=v(J,[["render",se]]),ie=y({components:{UiSkeletonBox:x},emits:["showHideAccumulationRulesForm"],data(){return{skeletonLoading:!1}},computed:{...g("withdrawals",{withdrawalRules:"withdrawalRules",isWithdrawalRulesLoaded:"isWithdrawalRulesLoaded"}),...g("dictionaries",{withdrawalIntervalsValue:"withdrawalIntervals"}),withdrawalIntervals(){return this.withdrawalIntervalsValue.map(e=>({title:this.$t(e.value),value:e.value}))},withdrawalType(){return this.withdrawalRules.withdrawalRuleType?this.withdrawalRules.withdrawalRuleType:""},minBalance(){return this.withdrawalRules.withdrawalMinBalance?this.withdrawalRules.withdrawalMinBalance:0},interval(){var e;return this.withdrawalRules.withdrawalIntervalCron?this.withdrawalRules.withdrawalIntervalCron:(e=this.withdrawalIntervals[0])==null?void 0:e.value},showAmount(){return this.withdrawalType==="balance"||this.withdrawalType==="limitAndBalance"},showInterval(){return this.withdrawalType==="interval"||this.withdrawalType==="limitAndBalance"}},created(){this.loadData()},methods:{...R("withdrawals",["loadWithdrawalRules"]),async loadData(){try{this.isWithdrawalRulesLoaded||(this.skeletonLoading=!0),await this.loadWithdrawalRules(),this.skeletonLoading=!1}catch{this.skeletonLoading=!1}},editFormHandler(){this.$emit("showHideAccumulationRulesForm")}}}),oe={key:1,class:"flex flex-col gap-6"},ne={class:"grid gap-2 grid-cols-[170px,1fr] items-center"},de={class:"text-gray-600 font-500"},re={key:0,class:"grid gap-2 grid-cols-[170px,1fr] items-center"},ce={class:"text-gray-600 font-500"},he={key:1,class:"grid gap-2 grid-cols-[170px,1fr] items-center"},ue={class:"text-gray-600 font-500"};function we(e,l,_,$,k,b){const c=o("ui-skeleton-box");return t(),i("div",null,[e.skeletonLoading?(t(),w(c,{key:0,width:"100%",height:"21px"})):(t(),i("div",oe,[a("div",ne,[a("div",de,s(e.$t("Type")),1),a("div",null,s(e.$t(e.withdrawalType)),1)]),e.showAmount?(t(),i("div",re,[a("div",ce,s(e.$t("By amount")),1),a("div",null,s(e.minBalance)+" $ ",1)])):f("",!0),e.showInterval?(t(),i("div",he,[a("div",ue,s(e.$t("By time")),1),a("div",null,s(e.$t(e.interval)),1)])):f("",!0)])),e.skeletonLoading?(t(),w(c,{key:2,class:"mt-8",width:"100%",height:"21px"})):(t(),i("div",{key:3,"aria-hidden":"true",class:"mt-8 text-primary-500 hover:text-primary-600 cursor-pointer",onClick:l[0]||(l[0]=(...r)=>e.editFormHandler&&e.editFormHandler(...r))},s(e.$t("Change accumulation rules")),1))])}const me=v(ie,[["render",we]]),pe=y({components:{UiSelect:H,UiInput:W,UiButtonLoading:V,UiSkeletonBox:x},emits:["showHideAccumulationRulesForm"],data(){return{skeletonLoading:!1,withdrawalTypeSelected:"",minBalance:0,intervalSelected:"Never",buttonLoading:!1}},computed:{...g("dictionaries",{withdrawalIntervalsValue:"withdrawalIntervals"}),...g("withdrawals",{withdrawalRules:"withdrawalRules",isWithdrawalRulesLoaded:"isWithdrawalRulesLoaded"}),showAmountInput(){return this.withdrawalTypeSelected==="balance"||this.withdrawalTypeSelected==="limitAndBalance"},showIntervalSelect(){return this.withdrawalTypeSelected==="interval"||this.withdrawalTypeSelected==="limitAndBalance"},withdrawalIntervals(){return this.withdrawalIntervalsValue.map(e=>({title:this.$t(e.value),value:e.value}))},withdrawalTypeList(){return this.withdrawalRules.withdrawalTypeList.map(e=>({title:this.$t(e),value:e}))}},watch:{withdrawalRules(){this.syncData()}},created(){this.loadData(),Object.keys(this.withdrawalRules).length&&this.syncData()},methods:{...R("withdrawals",["loadWithdrawalRules","updateWithdrawalRules"]),syncData(){var e;this.minBalance=this.withdrawalRules.withdrawalMinBalance?this.withdrawalRules.withdrawalMinBalance:0,this.intervalSelected=this.withdrawalRules.withdrawalIntervalCron?this.withdrawalRules.withdrawalIntervalCron:(e=this.withdrawalIntervals[0])==null?void 0:e.value,this.withdrawalTypeSelected=this.withdrawalRules.withdrawalRuleType},async loadData(){try{this.isWithdrawalRulesLoaded||(this.skeletonLoading=!0),await this.loadWithdrawalRules(),this.skeletonLoading=!1}catch{this.skeletonLoading=!1}},async updateWithdrawalsAccumulationRules(){try{this.buttonLoading=!0;const e={};e.withdrawalRuleType=this.withdrawalTypeSelected,this.withdrawalTypeSelected==="balance"&&(e.withdrawalIntervalCron="EveryMinute",e.withdrawalMinBalance=this.minBalance),this.withdrawalTypeSelected==="interval"&&(e.withdrawalIntervalCron=this.intervalSelected,e.withdrawalMinBalance=0),this.withdrawalTypeSelected==="manual"&&(e.withdrawalIntervalCron="Never",e.withdrawalMinBalance=0),this.withdrawalTypeSelected==="limitAndBalance"&&(e.withdrawalIntervalCron=this.intervalSelected,e.withdrawalMinBalance=this.minBalance),await this.updateWithdrawalRules(e),await this.loadData(),this.buttonLoading=!1,this.$toast.success(this.$t("Settings successfully updated")),this.$emit("showHideAccumulationRulesForm")}catch{this.buttonLoading=!1}},cancelHandler(e){e.preventDefault(),this.$emit("showHideAccumulationRulesForm")}}}),fe={class:"flex flex-col gap-2"},ge={for:"withdrawalType",class:"self-start"},ye={key:0,class:"flex items-end gap-2"},ve=a("span",{class:"mb-9px font-600"},"USD",-1),_e={key:1,class:"flex flex-col gap-2"},$e={for:"intervalSelect",class:"self-start"},ke={class:"flex items-center gap-4 mt-2"};function be(e,l,_,$,k,b){const c=o("ui-skeleton-box"),r=o("ui-select"),p=o("ui-input"),m=o("ui-button-loading");return t(),i("div",null,[e.skeletonLoading?(t(),w(c,{key:0,width:"100%",height:"231px"})):(t(),i("form",{key:1,class:"flex flex-col gap-6",onSubmit:l[4]||(l[4]=T((...n)=>e.updateWithdrawalsAccumulationRules&&e.updateWithdrawalsAccumulationRules(...n),["prevent"]))},[a("div",fe,[a("label",ge,s(e.$t("Type")),1),e.withdrawalRules.withdrawalTypeList.length?(t(),w(r,{key:0,id:"withdrawalType",class:"max-w-380px h-42px",modelValue:e.withdrawalTypeSelected,"onUpdate:modelValue":l[0]||(l[0]=n=>e.withdrawalTypeSelected=n),options:e.withdrawalTypeList},null,8,["modelValue","options"])):f("",!0)]),e.showAmountInput?(t(),i("div",ye,[u(p,{class:"max-w-200px",type:"number",id:"minBalance",modelValue:e.minBalance,"onUpdate:modelValue":l[1]||(l[1]=n=>e.minBalance=n),label:e.$t("By amount")},null,8,["modelValue","label"]),ve])):f("",!0),e.showIntervalSelect?(t(),i("div",_e,[a("label",$e,s(e.$t("By time")),1),e.withdrawalIntervals.length?(t(),w(r,{key:0,id:"intervalSelect",class:"max-w-380px h-42px",modelValue:e.intervalSelected,"onUpdate:modelValue":l[2]||(l[2]=n=>e.intervalSelected=n),options:e.withdrawalIntervals},null,8,["modelValue","options"])):f("",!0)])):f("",!0),a("div",ke,[a("button",{class:"button button-error py-2 px-4",onClick:l[3]||(l[3]=(...n)=>e.cancelHandler&&e.cancelHandler(...n))},s(e.$t("Cancel")),1),u(m,{class:"button button-primary py-2 px-4",type:"submit",loading:e.buttonLoading},{default:h(()=>[L(s(e.$t("Save")),1)]),_:1},8,["loading"])])],32))])}const Le=v(pe,[["render",be]]),Re=y({components:{AccumulationRulesView:me,AccumulationRulesEdit:Le},data(){return{isEdit:!1}},methods:{showHideAccumulationRulesForm(){this.isEdit=!this.isEdit}}}),xe={class:"card"},Ae={class:"card-title mb-6"};function Be(e,l,_,$,k,b){const c=o("accumulation-rules-edit"),r=o("accumulation-rules-view");return t(),i("div",xe,[a("div",Ae,s(e.$t("Accumulation Rules")),1),e.isEdit?(t(),w(c,{key:0,onShowHideAccumulationRulesForm:e.showHideAccumulationRulesForm},null,8,["onShowHideAccumulationRulesForm"])):(t(),w(r,{key:1,onShowHideAccumulationRulesForm:e.showHideAccumulationRulesForm},null,8,["onShowHideAccumulationRulesForm"]))])}const Se=v(Re,[["render",Be]]),Te=y({components:{WalletsWithdrawals:G,ListExchanges:le,AccumulationRules:Se}}),Ce={class:"mb-6"},Ie={class:"flex items-center justify-between gap-2"},We={class:"page-title"},He={class:"flex flex-col gap-6"};function Ve(e,l,_,$,k,b){const c=o("list-exchanges"),r=o("accumulation-rules"),p=o("wallets-withdrawals");return t(),i("div",null,[a("div",Ce,[a("div",Ie,[a("div",We,s(e.$t("Withdrawal Rules")),1)])]),a("div",He,[u(c),u(r),u(p)])])}const ze=v(Te,[["render",Ve]]);export{ze as default};