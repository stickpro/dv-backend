import{U as b}from"./UiSelect-ea4bca5c.js";import{U as C}from"./UiPagination-4e2c3226.js";import{U as _}from"./UiLoading-237702fa.js";import{d as v,_ as $,r as i,o as r,c as n,a,F as p,q as g,x as m,e as u,t as o,i as U,n as c,j as S}from"./flag-icons.min-86ec5348.js";const q=v({components:{UiSelect:b,UiPagination:C,UiLoading:_},props:{columns:{type:Array,required:!0},data:{type:Array,required:!0},perPageOptions:{type:Array,required:!1,default:()=>[{title:"25",value:"25"},{title:"50",value:"50"},{title:"100",value:"100"},{title:"250",value:"250"}]},perPageDefault:{type:String,required:!1},totalEntries:{type:Number,required:!1},loading:{type:Boolean,required:!1,default:!1},paginationable:{type:Boolean,required:!1,default:!1}},emits:["perPageSelectChanged","pageChanged"],data(){return{perPage:"",currentPage:1}},computed:{perPageComp:{get(){return this.perPage?this.perPage:this.perPageDefault?this.perPageDefault:this.perPageOptions[0].value},set(e){this.perPage=e}},paginationPerPage(){return Number(this.perPageComp)}},methods:{perPageSelectHandler(){this.$emit("perPageSelectChanged",this.currentPage,this.perPageComp)},pageChangeHandler(e){this.currentPage=e,this.$emit("pageChanged",this.currentPage,this.perPageComp)}}});const V={class:"table-h-scroll"},k={class:"w-full"},N={class:"border-b border-gray-200"},w={key:0,class:"flex items-center justify-between mt-6"},A={class:"flex items-center gap-2 text-sm"};function B(e,d,D,H,E,O){const h=i("ui-loading"),P=i("ui-select"),f=i("ui-pagination");return r(),n("div",null,[a("div",V,[a("table",k,[a("thead",null,[a("tr",N,[(r(!0),n(p,null,g(e.columns,(t,l)=>(r(),n("th",{key:l,class:c(["text-gray-600 font-500 uppercase py-4 px-3 align-top text-12px",t.textAlign])},o(t.label?e.$t(t.label):""),3))),128))])]),a("tbody",null,[(r(!0),n(p,null,g(e.data,(t,l)=>(r(),n("tr",{key:l,class:"border-b border-gray-200"},[(r(!0),n(p,null,g(e.columns,(s,y)=>(r(),n("td",{key:y,class:c(["py-4 px-3",s.textAlign])},[m(e.$slots,"cell-"+s.field,{row:t},()=>[S(o(t[s.field]),1)],!0)],2))),128))]))),128))]),a("tfoot",null,[m(e.$slots,"tfoot",{},void 0,!0)])]),u(h,{loading:e.loading},null,8,["loading"])]),e.paginationable?(r(),n("div",w,[a("div",A,[a("span",null,o(e.$t("Show")),1),u(P,{class:"max-w-90px h-38px",modelValue:e.perPageComp,"onUpdate:modelValue":d[0]||(d[0]=t=>e.perPageComp=t),options:e.perPageOptions,onChange:e.perPageSelectHandler},null,8,["modelValue","options","onChange"]),a("span",null,o(e.$t("entries")),1)]),u(f,{current:e.currentPage,total:e.totalEntries,"per-page":e.paginationPerPage,onPageChange:e.pageChangeHandler},null,8,["current","total","per-page","onPageChange"])])):U("",!0)])}const x=$(q,[["render",B],["__scopeId","data-v-eb4480b1"]]);export{x as U};