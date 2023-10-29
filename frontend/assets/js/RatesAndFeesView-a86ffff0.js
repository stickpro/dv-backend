import{d as h,f as m,k as v,_ as f,r as c,o,c as u,a as s,t as a,h as i,i as p,e as _,w as d,j as S,l as k,m as C,n as R}from"./flag-icons.min-86ec5348.js";import{U as w}from"./UiButtonLoading-8a0e711d.js";import{U as B}from"./UiSelect-ea4bca5c.js";import{U as L}from"./UiTable-55d04511.js";import{U}from"./UiSkeletonBox-7e5f2b59.js";import"./UiPagination-4e2c3226.js";import"./UiLoading-237702fa.js";const V=h({components:{UiButtonLoading:w,UiSelect:B},data(){return{rateSourceSelect:"",rateScaleSelect:"",rateScaleOptions:[{title:this.$t("Do not modify"),value:"0"},{title:"-0.5 %",value:"0.5"},{title:"-1 %",value:"1"},{title:"-2 %",value:"2"},{title:"-3 %",value:"3"}],buttonLoading:!1}},computed:{...m("dictionaries",{rateSources:"rateSources"}),...m("rates",{rateSource:"rateSource",rateScale:"rateScale"})},watch:{rateSource(){this.syncDataFromVuex()}},async created(){this.rateSource&&this.$store.commit("app/setProgressBar","stop"),await this.loadRateSource(),this.$store.commit("app/setProgressBar","stop")},mounted(){this.syncDataFromVuex()},methods:{syncDataFromVuex(){this.rateSourceSelect=this.rateSource,this.rateScaleSelect=this.rateScale},async updateRateSettings(){try{this.buttonLoading=!0,await this.updateRateSource({rateSource:this.rateSourceSelect,rateScale:this.rateScaleSelect}),this.buttonLoading=!1,this.$toast.success(this.$t("Rate source successfully updated"))}catch{this.buttonLoading=!1}},...v("rates",["loadRateSource","updateRateSource"])}});const P={class:"card common-wrapper"},A={class:"text-2xl mb-6"},D={class:"form-group"},F={for:"ratesSelect",class:"self-start"},G={class:"form-group"},x={for:"ratesSelect",class:"self-start"};function M(e,r,g,$,y,b){const n=c("ui-select"),l=c("ui-button-loading");return o(),u("div",P,[s("div",A,a(e.$t("Rates")),1),s("form",{class:"form",onSubmit:r[2]||(r[2]=k((...t)=>e.updateRateSettings&&e.updateRateSettings(...t),["prevent"]))},[s("div",D,[s("label",F,a(e.$t("Preferred Price Source")),1),e.rateSources.length&&e.rateSource?(o(),i(n,{key:0,class:"h-40px",id:"ratesSelect",modelValue:e.rateSourceSelect,"onUpdate:modelValue":r[0]||(r[0]=t=>e.rateSourceSelect=t),options:e.rateSources},null,8,["modelValue","options"])):p("",!0)]),s("div",G,[s("label",x,a(e.$t("Modify Rate Scale"))+" % ",1),e.rateSource?(o(),i(n,{key:0,class:"h-40px",id:"ratesSelect",modelValue:e.rateScaleSelect,"onUpdate:modelValue":r[1]||(r[1]=t=>e.rateScaleSelect=t),options:e.rateScaleOptions},null,8,["modelValue","options"])):p("",!0)]),_(l,{class:"button button-primary py-2 px-4 self-start",type:"submit",loading:e.buttonLoading},{default:d(()=>[S(a(e.$t("Save")),1)]),_:1},8,["loading"])],32)])}const N=f(V,[["render",M],["__scopeId","data-v-ae01a4f4"]]),I=h({components:{UiTable:L,UiSkeletonBox:U},data(){return{skeletonLoading:!1,tableColumns:[{label:"Currency Pair",field:"pair",textAlign:"text-left"},{label:"Rate",field:"rate",textAlign:"text-center"},{label:"Last Update",field:"lastUpdate",textAlign:"text-right"}]}},computed:{...C("currency",{getRatesBinance:"getRatesBinance",getRatesCoinGate:"getRatesCoinGate"}),...m("currency",{ratesLoaded:"ratesLoaded"})},async created(){this.ratesLoaded||(this.skeletonLoading=!0),this.getRatesBinance.length&&this.$store.commit("app/setProgressBar","stop"),await this.loadData(),this.$store.commit("app/setProgressBar","stop")},methods:{...v("currency",["loadCurrencyRates"]),async loadData(){try{await this.loadCurrencyRates(),this.skeletonLoading=!1}catch{this.skeletonLoading=!1}}}}),O={class:"page-title mb-6"},T={class:"flex gap-4 <desktop:flex-col <desktop:gap-6"},j={key:1,class:"card"},z={class:"card-title mb-4"},E={key:3,class:"card"},q={class:"card-title mb-4"};function H(e,r,g,$,y,b){const n=c("ui-skeleton-box"),l=c("ui-table");return o(),u("div",null,[s("div",O,a(e.$t("Currency Rates")),1),s("div",T,[e.skeletonLoading?(o(),i(n,{key:0,width:"100%",height:"240px"})):(o(),u("div",j,[s("div",z,a(e.$t("Rates from Binance")),1),e.getRatesBinance.length?(o(),i(l,{key:0,columns:e.tableColumns,data:e.getRatesBinance},{"cell-pair":d(({row:t})=>[S(a(t.to)+"/"+a(t.from),1)]),"cell-lastUpdate":d(({row:t})=>[s("span",{class:R([t.fiveMinutesPast?"error-status":"success-status"])},a(t.lastUpdate),3)]),_:1},8,["columns","data"])):p("",!0)])),e.skeletonLoading?(o(),i(n,{key:2,width:"100%",height:"240px"})):(o(),u("div",E,[s("div",q,a(e.$t("Rates from CoinGate")),1),e.getRatesCoinGate.length?(o(),i(l,{key:0,columns:e.tableColumns,data:e.getRatesCoinGate},{"cell-pair":d(({row:t})=>[S(a(t.to)+"/"+a(t.from),1)]),"cell-lastUpdate":d(({row:t})=>[s("span",{class:R([t.fiveMinutesPast?"error-status":"success-status"])},a(t.lastUpdate),3)]),_:1},8,["columns","data"])):p("",!0)]))])])}const J=f(I,[["render",H]]),K=h({components:{RatesSourceAndScale:N,CurrencyRates:J}});const Q={class:"page-title mb-6"},W={class:"flex flex-col gap-8"};function X(e,r,g,$,y,b){const n=c("rates-source-and-scale"),l=c("currency-rates");return o(),u("div",null,[s("div",Q,a(e.$t("Rates & Fees")),1),s("div",W,[_(n),_(l)])])}const re=f(K,[["render",X],["__scopeId","data-v-0573a15b"]]);export{re as default};