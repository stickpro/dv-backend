import{d as _,f as y,m as B,g as k,k as v,_ as U,r as c,o as r,c as u,a as t,t as l,j as m,i as d,e as i,w as g,l as $,h as p,F as P,q as A}from"./flag-icons.min-86ec5348.js";import{U as F}from"./UiSwitcher-bf0903c2.js";import{U as T}from"./UiSelect-ea4bca5c.js";import{U as O}from"./UiButtonLoading-8a0e711d.js";import{U as L}from"./UiExpand-e56b18da.js";import{U as M}from"./UiInput-de72e1ee.js";import{U as D}from"./UiTable-55d04511.js";import{U as H}from"./UiCopyToClipboard-54d0ebb6.js";import"./UiPagination-4e2c3226.js";import"./UiLoading-237702fa.js";const N=_({components:{UiSwitcher:F,UiSelect:T,UiButtonLoading:O,UiExpand:L,UiInput:M,UiTable:D,UiCopyToClipboard:H},data(){return{address:"",enabledWithdrawals:!1,minBalance:"",intervalSelected:0,buttonLoading:!1,enabledExchange:!1,exchangeSelected:"",currencyFromSelected:"",currencyToSelected:"",exchangeCurrenciesPair:{},exchangeColdWalletIsEnabled:!1,coldWalletAddresses:[],exchangeColdWalletMinBalance:"",selectedChain:"",tableColumns:[{label:"Address",field:"address",textAlign:"text-left"},{label:"Chain",field:"chain",textAlign:"text-center"},{label:"Min Balance",field:"withdrawalMinBalance",textAlign:"text-center"}]}},computed:{walletId(){return this.$route.params.wallet_id},showExchangeSettings(){return!(this.withdrawalsSettings.enableAutomaticExchange===null||this.withdrawalsSettings.enableAutomaticExchange===void 0)},showIfBitcoin(){return this.withdrawalsSettings.blockchain==="Bitcoin"},exchangeSelectedCurrencies(){return this.getExchangeCurrencies.filter(e=>e.slug===this.exchangeSelected)},currenciesFromOptions(){return Object.keys(this.exchangeSelectedCurrencies[0].currencies).map(e=>({title:e.split(".")[0],value:e}))},currencyFromSelectedComp:{get(){return this.currenciesFromOptions.find(e=>e.value===this.currencyFromSelected)?this.currencyFromSelected:this.currenciesFromOptions[0].value},set(e){this.currencyFromSelected=e}},currenciesToOptions(){return this.exchangeSelectedCurrencies[0].currencies[this.currencyFromSelectedComp]?this.exchangeSelectedCurrencies[0].currencies[this.currencyFromSelectedComp].map(e=>({title:e.split(".")[0],value:e})):this.exchangeSelectedCurrencies[0].currencies[this.currenciesFromOptions[0].value].map(e=>({title:`${e.split(".")[0]} (${e.split(".")[1]})`,value:e}))},currencyToSelectedComp:{get(){return this.currenciesToOptions.find(e=>e.value===this.currencyToSelected)?this.currencyToSelected:this.currenciesToOptions[0].value},set(e){this.currencyToSelected=e}},addCurrencyPairValidator(){return this.exchangeCurrenciesPair[this.exchangeSelected]?!!this.exchangeCurrenciesPair[this.exchangeSelected].find(e=>e.fromCurrencyId===this.currencyFromSelectedComp.split(".")[0].toLowerCase()):!1},saveBtnValidator(){return this.enabledExchange?this.exchangeCurrenciesPair[this.exchangeSelected]?!this.exchangeCurrenciesPair[this.exchangeSelected].length:!0:!1},coldAddressWalletValidator(){return this.exchangeColdWalletIsEnabled?!this.coldWalletAddresses:!1},selectedChainComp:{get(){return this.selectedChain?this.selectedChain:this.withdrawalsSettings.exchangeChain?this.withdrawalsSettings.exchangeChain:this.chainOptions[0].value},set(e){this.selectedChain=e}},chainOptions(){return this.chain.map(e=>({title:e==="erc20usdt"?"USDT (ERC20)":e==="trc20usdt"?"USDT (TRC20)":e,value:e}))},withdrawalIntervals(){return this.withdrawalIntervalsValue.map(e=>({title:this.$t(e.value),value:e.value}))},...y("wallets",{withdrawalsSettings:"withdrawalsSettings"}),...B("dictionaries",{exchangesOptions:"exchangesOptions",cryptoCurrencies:"cryptoCurrencies",getExchangeCurrencies:"getExchangeCurrencies"}),...y("dictionaries",{exchangeCurrencies:"exchangeCurrencies",withdrawalIntervalsValue:"withdrawalIntervals",chain:"chain"})},watch:{withdrawalsSettings(){this.syncDataFromVuex()}},created(){this.loadWithdrawalsSettings(this.walletId),Object.keys(this.withdrawalsSettings).length&&this.syncDataFromVuex()},unmounted(){this.clearWithdrawalsSettings()},methods:{async updateWithdrawalsHandler(){var e,a,o;this.buttonLoading=!0;try{await this.updateExchangeSettings({walletId:this.walletId,payload:{address:this.address,withdrawalEnabled:this.enabledWithdrawals,enableAutomaticExchange:this.enabledWithdrawals&&this.showIfBitcoin?this.enabledExchange:!1,withdrawalMinBalance:Number(this.minBalance),withdrawalIntervalCron:this.intervalSelected,exchange:this.exchangeSelected,exchangeCurrenciesFrom:(e=this.exchangeCurrenciesPair[this.exchangeSelected][0])!=null&&e.fromCurrencyId?this.exchangeCurrenciesPair[this.exchangeSelected][0].fromCurrencyId:null,exchangeCurrenciesTo:(a=this.exchangeCurrenciesPair[this.exchangeSelected][0])!=null&&a.toCurrencyId?this.exchangeCurrenciesPair[this.exchangeSelected][0].toCurrencyId:null,exchangeColdWalletAddress:this.coldWalletAddresses.map(h=>({...h,isWithdrawalEnabled:this.exchangeColdWalletIsEnabled})),exchangeColdWalletMinBalance:(o=this.coldWalletAddresses)!=null&&o.length?this.coldWalletAddresses[0].withdrawalMinBalance:0}}),await this.loadWithdrawalsSettings(this.walletId),this.buttonLoading=!1,this.$toast.success(this.$t("Withdrawals settings successfully updated"))}catch{this.buttonLoading=!1}},switchHandler(){this.enabledWithdrawals=!this.enabledWithdrawals},switchEnabledExchange(){this.enabledExchange=!this.enabledExchange},switchExchangeColdWalletIsEnabled(){this.exchangeColdWalletIsEnabled=!this.exchangeColdWalletIsEnabled},addCurrencyPairHandler(e){e.preventDefault(),this.exchangeCurrenciesPair[this.exchangeSelected]?this.exchangeCurrenciesPair[this.exchangeSelected].push({fromCurrencyId:this.currencyFromSelectedComp.split(".")[0].toLowerCase(),toCurrencyId:this.currencyToSelectedComp.split(".")[0].toLowerCase()}):this.exchangeCurrenciesPair[this.exchangeSelected]=[{fromCurrencyId:this.currencyFromSelectedComp.split(".")[0].toLowerCase(),toCurrencyId:this.currencyToSelectedComp.split(".")[0].toLowerCase()}]},deleteCurrencyPairHandler(e,a){e.preventDefault(),this.exchangeCurrenciesPair[this.exchangeSelected]=this.exchangeCurrenciesPair[this.exchangeSelected].filter((o,h)=>h!==a)},syncDataFromVuex(){var e,a,o;this.address=this.withdrawalsSettings.address,this.enabledWithdrawals=this.withdrawalsSettings.enabled,this.minBalance=this.withdrawalsSettings.minBalance,this.intervalSelected=this.withdrawalsSettings.withdrawalIntervalCron?this.withdrawalsSettings.withdrawalIntervalCron:(e=this.withdrawalIntervals[0])==null?void 0:e.value,this.enabledExchange=this.withdrawalsSettings.enableAutomaticExchange,this.exchangeSelected=this.withdrawalsSettings.exchange?this.withdrawalsSettings.exchange.toLowerCase():(a=this.exchangesOptions[0])==null?void 0:a.value,this.withdrawalsSettings.exchange&&(this.exchangeCurrenciesPair={[this.withdrawalsSettings.exchange.toLowerCase()]:[...this.withdrawalsSettings.exchangeCurrencies]}),this.exchangeColdWalletIsEnabled=(o=this.withdrawalsSettings.exchangeColdWalletAddresses)!=null&&o.length?this.withdrawalsSettings.exchangeColdWalletAddresses.every(h=>h.isWithdrawalEnabled):!1,this.coldWalletAddresses=this.withdrawalsSettings.exchangeColdWalletAddresses,this.exchangeColdWalletMinBalance=this.withdrawalsSettings.exchangeColdWalletMinBalance},...k("wallets",["clearWithdrawalsSettings"]),...v("wallets",["loadWithdrawalsSettings","updateWithdrawalsSettings"]),...v("exchanges",["updateExchangeSettings"])}});const j={class:"card common-wrapper"},z={class:"page-title font-600 mb-6"},q={class:"form-group"},R={for:"address",class:"self-start"},G={key:0,class:"font-600"},J={class:"flex flex-col gap-8"},K={class:"form-group"},Q={for:"withdrawalsSwitcher",class:"self-start"},X={class:"form-group"},Y={for:"intervalSelect",class:"self-start"},Z={key:0,class:"flex flex-col gap-8"},ee={class:"form-group"},te={for:"exchangeSwitcher",class:"self-start"},ae={class:"form-group"},se={for:"exchangeSelect",class:"self-start"},le={class:"flex flex-col gap-3"},ne={class:"font-600"},ie={class:"flex gap-2 items-end"},re={class:"form-group"},de={for:"exchangeSelect",class:"self-start"},ce={class:"form-group"},oe={for:"exchangeSelect",class:"self-start"},he={key:0,class:"flex flex-col gap-2"},ue={class:"border bg-gray-200 flex w-180px h-32px items-center pl-2"},ge=["onClick"],pe={class:"form-group"},we={for:"exchangeColdWalletSwitcher",class:"self-start"},me={class:"flex items-center gap-2"};function Ce(e,a,o,h,Se,xe){const f=c("ui-input"),C=c("ui-switcher"),w=c("ui-select"),S=c("ui-expand"),x=c("feather-icon"),W=c("ui-copy-to-clipboard"),E=c("ui-table"),I=c("ui-button-loading");return r(),u("div",j,[t("div",z,l(e.$t("Withdrawals Settings")),1),t("form",{class:"form",onSubmit:a[7]||(a[7]=$((...n)=>e.updateWithdrawalsHandler&&e.updateWithdrawalsHandler(...n),["prevent"]))},[t("div",q,[t("label",R,[m(l(e.$t("Address"))+" ",1),e.withdrawalsSettings.blockchain?(r(),u("span",G," ("+l(e.withdrawalsSettings.blockchain)+") ",1)):d("",!0)]),i(f,{required:"",modelValue:e.address,"onUpdate:modelValue":a[0]||(a[0]=n=>e.address=n),type:"text",id:"address"},null,8,["modelValue"])]),t("div",J,[t("div",K,[t("label",Q,l(e.$t("Enable automatic withdrawals")),1),i(C,{id:"withdrawalsSwitcher",checked:e.enabledWithdrawals,onSwitched:e.switchHandler},null,8,["checked","onSwitched"])]),i(S,{class:"flex flex-col gap-6","is-expanded":e.enabledWithdrawals},{default:g(()=>[i(f,{modelValue:e.minBalance,"onUpdate:modelValue":a[1]||(a[1]=n=>e.minBalance=n),class:"max-w-200px",type:"number",id:"minBalance",label:e.$t("Balance (USD) more than")},null,8,["modelValue","label"]),t("div",X,[t("label",Y,l(e.$t("Interval")),1),e.withdrawalIntervals.length?(r(),p(w,{key:0,id:"intervalSelect",class:"max-w-200px h-42px",modelValue:e.intervalSelected,"onUpdate:modelValue":a[2]||(a[2]=n=>e.intervalSelected=n),options:e.withdrawalIntervals},null,8,["modelValue","options"])):d("",!0)])]),_:1},8,["is-expanded"])]),e.showExchangeSettings&&e.enabledWithdrawals&&e.showIfBitcoin?(r(),u("div",Z,[t("div",ee,[t("label",te,l(e.$t("Enable automatic exchange")),1),i(C,{id:"exchangeSwitcher",checked:e.enabledExchange,onSwitched:e.switchEnabledExchange},null,8,["checked","onSwitched"])]),i(S,{class:"flex flex-col gap-6","is-expanded":e.enabledExchange},{default:g(()=>{var n;return[t("div",ae,[t("label",se,l(e.$t("Exchange")),1),e.exchangesOptions.length?(r(),p(w,{key:0,id:"exchangeSelect",class:"max-w-200px h-42px",modelValue:e.exchangeSelected,"onUpdate:modelValue":a[3]||(a[3]=s=>e.exchangeSelected=s),options:e.exchangesOptions},null,8,["modelValue","options"])):d("",!0)]),t("div",le,[t("div",ne,l(e.$t("Exchange Direction")),1),t("div",ie,[t("div",re,[t("label",de,l(e.$t("From")),1),e.cryptoCurrencies.length?(r(),p(w,{key:0,id:"exchangeSelect",class:"max-w-200px h-42px",modelValue:e.currencyFromSelectedComp,"onUpdate:modelValue":a[4]||(a[4]=s=>e.currencyFromSelectedComp=s),options:e.currenciesFromOptions},null,8,["modelValue","options"])):d("",!0)]),i(x,{type:"arrow-right",size:"18",class:"mb-12px"}),t("div",ce,[t("label",oe,l(e.$t("To")),1),e.cryptoCurrencies.length?(r(),p(w,{key:0,id:"exchangeSelect",class:"max-w-200px h-42px",modelValue:e.currencyToSelectedComp,"onUpdate:modelValue":a[5]||(a[5]=s=>e.currencyToSelectedComp=s),options:e.currenciesToOptions},null,8,["modelValue","options"])):d("",!0)]),e.addCurrencyPairValidator?d("",!0):(r(),u("button",{key:0,class:"button button-success px-4 h-42px flex items-center ml-2",onClick:a[6]||(a[6]=(...s)=>e.addCurrencyPairHandler&&e.addCurrencyPairHandler(...s))},[i(x,{type:"plus",size:"24"})]))])]),(n=e.exchangeCurrenciesPair[e.exchangeSelected])!=null&&n.length?(r(),u("div",he,[(r(!0),u(P,null,A(e.exchangeCurrenciesPair[e.exchangeSelected],(s,b)=>(r(),u("div",{key:b,class:"flex items-center gap-2"},[t("span",null,l(e.$t("Currency Pair"))+": ",1),t("span",ue,l(s.fromCurrencyId.split(".")[0].toUpperCase())+" / "+l(s.toCurrencyId.split(".")[0].toUpperCase()),1),t("button",{class:"button button-error flex items-center px-2 h-32px",onClick:V=>e.deleteCurrencyPairHandler(V,b)},[i(x,{type:"trash-2",size:"18"})],8,ge)]))),128))])):d("",!0)]}),_:1},8,["is-expanded"]),t("div",pe,[t("label",we,l(e.$t("Enable withdrawal to cold wallet")),1),i(C,{id:"exchangeColdWalletSwitcher",checked:e.exchangeColdWalletIsEnabled,onSwitched:e.switchExchangeColdWalletIsEnabled},null,8,["checked","onSwitched"])]),i(S,{class:"flex flex-col gap-6","is-expanded":e.exchangeColdWalletIsEnabled},{default:g(()=>{var n;return[(n=e.coldWalletAddresses)!=null&&n.length?(r(),p(E,{key:0,columns:e.tableColumns,data:e.coldWalletAddresses},{"cell-address":g(({row:s})=>[t("div",me,[t("span",null,l(`${s.address.slice(0,7)}...${s.address.slice(-5)}`),1),i(W,{"text-to-copy":s.address},null,8,["text-to-copy"])])]),"cell-chain":g(({row:s})=>[m(l(s.chain.toUpperCase()),1)]),"cell-withdrawalMinBalance":g(({row:s})=>[m(l(s.withdrawalMinBalance)+" $ ",1)]),_:1},8,["columns","data"])):d("",!0)]}),_:1},8,["is-expanded"])])):d("",!0),i(I,{class:"button button-primary py-2 px-4 self-start",type:"submit",loading:e.buttonLoading,disabled:e.saveBtnValidator||e.coldAddressWalletValidator},{default:g(()=>[m(l(e.$t("Save")),1)]),_:1},8,["loading","disabled"])],32)])}const ke=U(N,[["render",Ce],["__scopeId","data-v-6ca2f1b0"]]);export{ke as default};
