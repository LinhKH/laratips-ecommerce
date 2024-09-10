import{o as m,c as h,b1 as L,b2 as J,f as x,d as e,F as D,r as q,x as E,aG as R,aE as Z,t as V,e as P,l as $,bE as Q,h as z,p as T,k as X,am as Y,a7 as ee,T as te,m as M,aN as ne,s as se,a as w,u,w as O,Z as ie,i as ae,b as j,g as F,v as oe,bu as re}from"./app-ThaAqrzf.js";import{_ as le}from"./BackendLayout-NAc_AZ-L.js";import{_ as de}from"./BreadCrumb-ECVZKI4N.js";import{s as ce}from"./vue-multiselect.esm-6zVhof9i.js";import"./main-dccCKgaS.js";/* empty css                                                                 */import"./Alert-5IJVMm-7.js";var ue=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{};function me(t,i,n){return n={path:i,exports:{},require:function(a,r){return he(a,r??n.path)}},t(n,n.exports),n.exports}function he(){throw new Error("Dynamic requires are not currently supported by @rollup/plugin-commonjs")}var pe=me(function(t,i){(function(n,a){t.exports=a()})(ue,function(){var n="__v-click-outside",a=typeof window<"u",r=typeof navigator<"u",l=a&&("ontouchstart"in window||r&&navigator.msMaxTouchPoints>0)?["touchstart"]:["click"],C=function(d){var g=d.event,s=d.handler;(0,d.middleware)(g)&&s(g)},I=function(d,g){var s=function(p){var y=typeof p=="function";if(!y&&typeof p!="object")throw new Error("v-click-outside: Binding value must be a function or an object");return{handler:y?p:p.handler,middleware:p.middleware||function(b){return b},events:p.events||l,isActive:p.isActive!==!1,detectIframe:p.detectIframe!==!1,capture:!!p.capture}}(g.value),o=s.handler,_=s.middleware,S=s.detectIframe,c=s.capture;if(s.isActive){if(d[n]=s.events.map(function(p){return{event:p,srcTarget:document.documentElement,handler:function(y){return function(b){var N=b.el,k=b.event,A=b.handler,B=b.middleware,U=k.path||k.composedPath&&k.composedPath();(U?U.indexOf(N)<0:!N.contains(k.target))&&C({event:k,handler:A,middleware:B})}({el:d,event:y,handler:o,middleware:_})},capture:c}}),S){var W={event:"blur",srcTarget:window,handler:function(p){return function(y){var b=y.el,N=y.event,k=y.handler,A=y.middleware;setTimeout(function(){var B=document.activeElement;B&&B.tagName==="IFRAME"&&!b.contains(B)&&C({event:N,handler:k,middleware:A})},0)}({el:d,event:p,handler:o,middleware:_})},capture:c};d[n]=[].concat(d[n],[W])}d[n].forEach(function(p){var y=p.event,b=p.srcTarget,N=p.handler;return setTimeout(function(){d[n]&&b.addEventListener(y,N,c)},0)})}},f=function(d){(d[n]||[]).forEach(function(g){return g.srcTarget.removeEventListener(g.event,g.handler,g.capture)}),delete d[n]},v=a?{beforeMount:I,updated:function(d,g){var s=g.value,o=g.oldValue;JSON.stringify(s)!==JSON.stringify(o)&&(f(d),I(d,{value:s}))},unmounted:f}:{};return{install:function(d){d.directive("click-outside",v)},directive:v}})}),fe=pe;const ve={class:"v3ti-loader-wrapper"},ge=e("div",{class:"v3ti-loader"},null,-1),_e=e("span",null,"Loading",-1),ye=[ge,_e];function be(t,i){return m(),h("div",ve,ye)}function H(t,i){i===void 0&&(i={});var n=i.insertAt;if(!(!t||typeof document>"u")){var a=document.head||document.getElementsByTagName("head")[0],r=document.createElement("style");r.type="text/css",n==="top"&&a.firstChild?a.insertBefore(r,a.firstChild):a.appendChild(r),r.styleSheet?r.styleSheet.cssText=t:r.appendChild(document.createTextNode(t))}}var we=`.v3ti-loader-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #112B3C;
}
.v3ti-loader-wrapper .v3ti-loader {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: inline-block;
  border-top: 2px solid #112B3C;
  border-right: 2px solid transparent;
  box-sizing: border-box;
  animation: rotation 0.8s linear infinite;
  margin-right: 8px;
}
@keyframes rotation {
0% {
    transform: rotate(0deg);
}
100% {
    transform: rotate(360deg);
}
}`;H(we);const K={};K.render=be;var xe=K,G={name:"Vue3TagsInput",emits:["update:modelValue","update:tags","on-limit","on-tags-changed","on-remove","on-error","on-focus","on-blur","on-select","on-select-duplicate-tag","on-new-tag"],props:{readOnly:{type:Boolean,default:!1},modelValue:{type:String,default:""},validate:{type:[String,Function,Object],default:""},addTagOnKeys:{type:Array,default:function(){return[13,",",32]}},placeholder:{type:String,default:""},tags:{type:Array,default:()=>[]},loading:{type:Boolean,default:!1},limit:{type:Number,default:-1},allowDuplicates:{type:Boolean,default:!1},addTagOnBlur:{type:Boolean,default:!1},selectItems:{type:Array,default:()=>[]},select:{type:Boolean,default:!1},duplicateSelectItem:{type:Boolean,default:!0},uniqueSelectField:{type:String,default:"id"},addTagOnKeysWhenSelect:{type:Boolean,default:!1},isShowNoData:{type:Boolean,default:!0}},components:{Loading:xe},directives:{clickOutside:fe.directive},data(){return{isInputActive:!1,isError:!1,newTag:"",innerTags:[],multiple:!1}},computed:{isLimit(){const t=this.limit>0&&Number(this.limit)===this.innerTags.length;return t&&this.$emit("on-limit"),t},selectedItemsIds(){return this.duplicateSelectItem?[]:this.tags.map(t=>t[this.uniqueSelectField]||"")}},watch:{error(){this.isError=this.error},modelValue:{immediate:!0,handler(t){this.newTag=t}},tags:{deep:!0,immediate:!0,handler(t){this.innerTags=[...t]}}},methods:{isShot(t){return!!this.$slots[t]},makeItNormal(t){this.$emit("update:modelValue",t.target.value),this.$refs.inputTag.className="v3ti-new-tag",this.$refs.inputTag.style.textDecoration="none"},resetData(){this.innerTags=[]},resetInputValue(){this.newTag="",this.$emit("update:modelValue","")},setPosition(){const t=this.$refs.inputBox,i=this.$refs.contextMenu;if(t&&i){i.style.display="block";const n=t.clientHeight||32,a=3;i.style.top=n+a+"px"}},closeContextMenu(){this.$refs.contextMenu&&(this.$refs.contextMenu.style={display:"none"})},handleSelect(t){if(this.isShowCheckmark(t)){const i=this.tags.filter(n=>t.id!==n.id);this.$emit("update:tags",i),this.$emit("on-select-duplicate-tag",t),this.resetInputValue()}else this.$emit("on-select",t);this.$nextTick(()=>{this.closeContextMenu()})},isShowCheckmark(t){return this.duplicateSelectItem?!1:this.selectedItemsIds.includes(t[this.uniqueSelectField])},focusNewTag(){this.select&&!this.disabled&&this.setPosition(),!(this.readOnly||!this.$el.querySelector(".v3ti-new-tag"))&&this.$el.querySelector(".v3ti-new-tag").focus()},handleInputFocus(t){this.isInputActive=!0,this.$emit("on-focus",t)},handleInputBlur(t){this.isInputActive=!1,this.addNew(t),this.$emit("on-blur",t)},addNew(t){if(this.select&&!this.addTagOnKeysWhenSelect)return;const i=t?this.addTagOnKeys.indexOf(t.keyCode)!==-1||this.addTagOnKeys.indexOf(t.key)!==-1:!0,n=t&&t.type!=="blur";!i&&(n||!this.addTagOnBlur)||this.isLimit||(this.newTag&&(this.allowDuplicates||this.innerTags.indexOf(this.newTag)===-1)&&this.validateIfNeeded(this.newTag)?(this.innerTags.push(this.newTag),this.addTagOnKeysWhenSelect&&(this.$emit("on-new-tag",this.newTag),this.updatePositionContextMenu()),this.resetInputValue(),this.tagChange(),t&&t.preventDefault()):(this.validateIfNeeded(this.newTag)?this.makeItError(!0):this.makeItError(!1),t&&t.preventDefault()))},updatePositionContextMenu(){this.$nextTick(()=>{this.setPosition()})},makeItError(t){this.newTag!==""&&(this.$refs.inputTag.className="v3ti-new-tag v3ti-new-tag--error",this.$refs.inputTag.style.textDecoration="underline",this.$emit("on-error",t))},validateIfNeeded(t){return this.validate===""||this.validate===void 0?!0:typeof this.validate=="function"?this.validate(t):!0},removeLastTag(){this.newTag||(this.innerTags.pop(),this.tagChange(),this.updatePositionContextMenu())},remove(t){this.innerTags.splice(t,1),this.tagChange(),this.$emit("on-remove",t),this.updatePositionContextMenu()},tagChange(){this.$emit("on-tags-changed",this.innerTags)}}};const ke={key:1,class:"v3ti-tag-content"},Te=["onClick"],Ce=["placeholder","disabled"],Ie={key:0,class:"v3ti-loading"},Se={key:1,class:"v3ti-no-data"},Ne={key:1},$e={key:2},Be=["onClick"],Oe={class:"v3ti-context-item--label"},Ve={key:0,class:"v3ti-icon-selected-tag",width:"44",height:"44",viewBox:"0 0 24 24","stroke-width":"1.5",fill:"none","stroke-linecap":"round","stroke-linejoin":"round"},Ee=e("path",{stroke:"none",d:"M0 0h24v24H0z"},null,-1),Me=e("path",{d:"M5 12l5 5l10 -10"},null,-1),Pe=[Ee,Me];function De(t,i,n,a,r,l){const C=L("Loading"),I=J("click-outside");return x((m(),h("div",{onClick:i[6]||(i[6]=f=>l.focusNewTag()),class:T([{"v3ti--focus":r.isInputActive,"v3ti--error":r.isError},"v3ti"])},[e("div",{class:T(["v3ti-content",{"v3ti-content--select":n.select}]),ref:"inputBox"},[(m(!0),h(D,null,q(r.innerTags,(f,v)=>(m(),h("span",{key:v,class:"v3ti-tag"},[l.isShot("item")?E(t.$slots,"item",R(Z({key:0},{name:f,index:v,tag:f}))):(m(),h("span",ke,V(f),1)),n.readOnly?$("",!0):(m(),h("a",{key:2,onClick:P(d=>l.remove(v),["prevent","stop"]),class:"v3ti-remove-tag"},null,8,Te))]))),128)),x(e("input",{ref:"inputTag",placeholder:n.placeholder,"onUpdate:modelValue":i[0]||(i[0]=f=>r.newTag=f),onKeydown:[i[1]||(i[1]=Q(P(function(){return l.removeLastTag&&l.removeLastTag(...arguments)},["stop"]),["delete"])),i[2]||(i[2]=function(){return l.addNew&&l.addNew(...arguments)})],onBlur:i[3]||(i[3]=function(){return l.handleInputBlur&&l.handleInputBlur(...arguments)}),onFocus:i[4]||(i[4]=function(){return l.handleInputFocus&&l.handleInputFocus(...arguments)}),onInput:i[5]||(i[5]=function(){return l.makeItNormal&&l.makeItNormal(...arguments)}),class:"v3ti-new-tag",disabled:n.readOnly},null,40,Ce),[[z,r.newTag]])],2),n.select?(m(),h("section",{key:0,class:T(["v3ti-context-menu",{"v3ti-context-menu-no-data":!n.isShowNoData&&n.selectItems.length===0}]),ref:"contextMenu"},[n.loading?(m(),h("div",Ie,[l.isShot("loading")?E(t.$slots,"default",{key:0}):(m(),X(C,{key:1}))])):$("",!0),!n.loading&&n.selectItems.length===0&&n.isShowNoData?(m(),h("div",Se,[l.isShot("no-data")?E(t.$slots,"no-data",{key:0}):(m(),h("span",Ne," No data "))])):$("",!0),!n.loading&&n.selectItems.length>0?(m(),h("div",$e,[(m(!0),h(D,null,q(n.selectItems,(f,v)=>(m(),h("div",{key:v,class:T(["v3ti-context-item",{"v3ti-context-item--active":l.isShowCheckmark(f)}]),onClick:P(d=>l.handleSelect(f,v),["stop"])},[e("div",Oe,[E(t.$slots,"select-item",R(Y(f)))]),l.isShowCheckmark(f)?(m(),h("svg",Ve,Pe)):$("",!0)],10,Be))),128))])):$("",!0)],2)):$("",!0)],2)),[[I,l.closeContextMenu]])}var je=`.v3ti {
  border-radius: 5px;
  min-height: 32px;
  line-height: 1.4;
  background-color: #fff;
  border: 1px solid #9ca3af;
  cursor: text;
  text-align: left;
  -webkit-appearance: textfield;
  display: flex;
  flex-wrap: wrap;
  position: relative;
}
.v3ti .v3ti-icon-selected-tag {
  stroke: #19be6b;
  width: 1rem;
  height: 1rem;
  margin-left: 4px;
}
.v3ti--focus {
  outline: 0;
  border-color: #000000;
  box-shadow: 0 0 0 1px #000000;
}
.v3ti--error {
  border-color: #F56C6C;
}
.v3ti .v3ti-no-data {
  color: #d8d8d8;
  text-align: center;
  padding: 4px 7px;
}
.v3ti .v3ti-loading {
  padding: 4px 7px;
  text-align: center;
}
.v3ti .v3ti-context-menu {
  max-height: 150px;
  min-width: 150px;
  overflow: auto;
  display: none;
  outline: none;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  margin: 0;
  padding: 5px 0;
  background: #ffffff;
  z-index: 1050;
  color: #475569;
  box-shadow: 0 3px 8px 2px rgba(0, 0, 0, 0.1);
  border-radius: 0 0 6px 6px;
}
.v3ti .v3ti-context-menu .v3ti-context-item {
  padding: 4px 7px;
  display: flex;
  align-items: center;
}
.v3ti .v3ti-context-menu .v3ti-context-item:hover {
  background: #e8e8e8;
  cursor: pointer;
}
.v3ti .v3ti-context-menu .v3ti-context-item--label {
  flex: 1;
  min-width: 1px;
}
.v3ti .v3ti-context-menu .v3ti-context-item--active {
  color: #317CAF;
}
.v3ti .v3ti-context-menu-no-data {
  padding: 0;
}
.v3ti .v3ti-content {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
}
.v3ti .v3ti-content--select {
  padding-right: 30px;
}
.v3ti .v3ti-tag {
  display: flex;
  font-weight: 400;
  margin: 3px;
  padding: 0 5px;
  background: #317CAF;
  color: #ffffff;
  height: 27px;
  border-radius: 5px;
  align-items: center;
  max-width: calc(100% - 16px);
}
.v3ti .v3ti-tag .v3ti-tag-content {
  flex: 1;
  min-width: 1px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.v3ti .v3ti-tag .v3ti-remove-tag {
  color: #ffffff;
  transition: opacity 0.3s ease;
  opacity: 0.5;
  cursor: pointer;
  padding: 0 5px 0 7px;
}
.v3ti .v3ti-tag .v3ti-remove-tag::before {
  content: "x";
}
.v3ti .v3ti-tag .v3ti-remove-tag:hover {
  opacity: 1;
}
.v3ti .v3ti-new-tag {
  background: transparent;
  border: 0;
  font-weight: 400;
  margin: 3px;
  outline: none;
  padding: 0 4px;
  flex: 1;
  min-width: 60px;
  height: 27px;
}
.v3ti .v3ti-new-tag--error {
  color: #F56C6C;
}`;H(je);G.render=De;var Ae=(()=>{const t=G;return t.install=i=>{i.component("Vue3TagsInput",t)},t})();/*! Element Plus Icons Vue v2.3.1 */var Fe=ee({name:"Plus",__name:"plus",setup(t){return(i,n)=>(m(),h("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 1024 1024"},[e("path",{fill:"currentColor",d:"M480 480V128a32 32 0 0 1 64 0v352h352a32 32 0 1 1 0 64H544v352a32 32 0 1 1-64 0V544H128a32 32 0 0 1 0-64z"})]))}}),Le=Fe;const qe={class:"content card"},ze={class:"container-fluid card-body"},Ue={class:"row"},Re={class:"col-md-12"},He={class:"card"},Ke=e("div",{class:"card-header"},[e("h3",{class:"card-title"},"Product Information")],-1),Ge={class:"card-body"},We={class:"form-group"},Je={class:"row"},Ze=e("div",{class:"col-md-3"},[e("span",null,"Product Name"),j(),e("small",{class:"text-danger"},"*")],-1),Qe={class:"col-md-9"},Xe={class:"text-sm text-red-600"},Ye={class:"form-group"},et={class:"row"},tt=e("div",{class:"col-md-3"},[e("span",null,"Category"),j(),e("small",{class:"text-danger"},"*")],-1),nt={class:"col-md-9"},st={class:"text-sm text-red-600"},it={class:"form-group"},at={class:"row"},ot=e("div",{class:"col-md-3"},[e("span",null,"Brand")],-1),rt={class:"col-md-9"},lt=e("option",{value:"",selected:"",disabled:""},"Select Brand",-1),dt=["value"],ct={class:"form-group"},ut={class:"row"},mt=e("div",{class:"col-md-3"},[e("span",null,"Unit")],-1),ht={class:"col-md-9"},pt={class:"form-group"},ft={class:"row"},vt=e("div",{class:"col-md-3"},[e("span",null,"Tags"),j(),e("small",{class:"text-danger"},"*")],-1),gt={class:"col-md-9"},_t={class:"text-sm text-red-600"},yt={class:"form-group"},bt={class:"row"},wt=e("div",{class:"col-md-3"},[e("span",null,"Refundable")],-1),xt={class:"col-md-9"},kt={class:"checkbox"},Tt=e("label",{for:"checkbox1"},null,-1),Ct={class:"card"},It=e("div",{class:"card-header"},[e("h3",{class:"card-title"},"Product Images")],-1),St={class:"card-body"},Nt={class:"form-group"},$t={class:"row"},Bt=e("div",{class:"col-md-3"},[e("span",null,"Gallery Images"),e("br"),e("small",null,"Images must be square in size (e.g. 800x800)")],-1),Ot={class:"col-md-9"},Vt={class:"form-group"},Et={class:"row"},Mt=e("div",{class:"col-md-3"},[e("span",null,"Thumbnail Image"),e("br"),e("small",null,"Image must be square in size (e.g. 800x800)")],-1),Pt={class:"col-md-7"},Dt=e("label",{class:"custom-file-label"},"Choose file",-1),jt={class:"col-md-2"},At=["src"],Ft=e("div",{class:"row"},[e("div",{class:"col-12"},[e("input",{type:"submit",class:"btn btn-primary bg-primary",value:"Submit"})])],-1),Gt={__name:"Create",props:{edit:{type:Boolean,default:!1},title:{type:String},item:{type:Object,default:()=>({})},category:{type:Object,default:()=>({})},brand:{type:Object,default:()=>({})},flash_products:{type:Object,default:()=>[]},routeResourceName:{type:String,required:!0},breadcrumb:Object,attribute:Object},setup(t){const i="http://localhost:8000",n=t,a=te({product_name:n.item.product_name??"",brand:n.item.brand??"",unit:n.item.unit??"",tags:n.item.tags??[],refundable:n.item.refundable??"",thumbnail_img:null,old_img:n.item.flash_image??"",datetimes:n.item.flash_date_range??"",flash_status:n.item.status??1,products:n.flash_products??[]}),r=M([]),l=M(!1),C=M(""),I=s=>{r.value.push(s)},f=s=>{C.value=s.url,l.value=!0};ne(()=>{var _,S;const s=new Date((_=n.item.flash_date_range)==null?void 0:_.split("-")[0]),o=new Date((S=n.item.flash_date_range)==null?void 0:S.split("-")[1]);a.datetimes=[s,o]}),M({hours:0,minutes:0}),se(()=>n.item.flash_image?`${i}/flash-deals/${n.item.flash_image}`:`${i}/flash-deals/default.png`);let v=[];for(let s of n.category)if(v.push(s),s.children_categories){for(let o of s.children_categories)if(o.level==1&&(o.category_name="-- "+o.category_name),v.push(o),o.categories)for(let _ of o.categories)_.level==2&&(_.category_name="---- "+_.category_name),v.push(_)}const d=()=>{n.edit?a.put(route(`admin.${n.routeResourceName}.update`,{id:n.item.id}),{onSuccess:s=>{Swal.fire({toast:!0,icon:"success",position:"top-end",showConfirmButton:!1,timer:2e3,title:s.props.flash.success})}}):a.post(route(`admin.${n.routeResourceName}.store`),{onSuccess:s=>{Swal.fire({toast:!0,icon:"success",position:"top-end",showConfirmButton:!1,timer:2e3,title:s.props.flash.success})}})},g=s=>{a.tags=s};return(s,o)=>{const _=L("el-icon"),S=L("el-upload");return m(),h(D,null,[w(u(ie),{title:t.title},null,8,["title"]),w(le,null,{default:O(()=>[w(de,{breadcrumb:t.breadcrumb,title:t.title,active:t.title},{add_btn:O(()=>[w(u(ae),{href:s.route("admin.flash-deals.index"),class:"align-top btn btn-sm btn-primary"},{default:O(()=>[j("Back")]),_:1},8,["href"])]),_:1},8,["breadcrumb","title","active"]),e("section",qe,[e("div",ze,[e("form",{class:"form-horizontal",onSubmit:P(d,["prevent"]),method:"POST",enctype:"multipart/form-data"},[e("div",Ue,[e("div",Re,[e("div",He,[Ke,e("div",Ge,[e("div",We,[e("div",Je,[Ze,e("div",Qe,[x(e("input",{type:"text",class:T([{"border border-danger":s.$page.props.errors.product_name},"form-control"]),"onUpdate:modelValue":o[0]||(o[0]=c=>u(a).product_name=c),placeholder:"Product Name"},null,2),[[z,u(a).product_name]]),x(e("div",null,[e("p",Xe,V(s.$page.props.errors.product_name),1)],512),[[F,s.$page.props.errors.product_name]])])])]),e("div",Ye,[e("div",et,[tt,e("div",nt,[w(u(ce),{class:T({"border border-danger":s.$page.props.errors.category}),modelValue:u(a).category,"onUpdate:modelValue":o[1]||(o[1]=c=>u(a).category=c),options:u(v),multiple:!1,"close-on-select":!0,placeholder:"Select Category",label:"category_name","track-by":"id"},null,8,["class","modelValue","options"]),x(e("div",null,[e("p",st,V(s.$page.props.errors.category),1)],512),[[F,s.$page.props.errors.category]])])])]),e("div",it,[e("div",at,[ot,e("div",rt,[x(e("select",{class:"form-control","onUpdate:modelValue":o[2]||(o[2]=c=>u(a).brand=c)},[lt,(m(!0),h(D,null,q(t.brand,c=>(m(),h("option",{key:c.id,value:c.id},V(c.brand_name),9,dt))),128))],512),[[oe,u(a).brand]])])])]),e("div",ct,[e("div",ut,[mt,e("div",ht,[x(e("input",{type:"text",class:"form-control","onUpdate:modelValue":o[3]||(o[3]=c=>u(a).unit=c),placeholder:"Unit (VD:  Cái, hộp, bịch ...)"},null,512),[[z,u(a).unit]])])])]),e("div",pt,[e("div",ft,[vt,e("div",gt,[w(u(Ae),{tags:u(a).tags,class:T({"border border-danger":s.$page.props.errors.category}),placeholder:"Type and hit enter to add a tag",onOnTagsChanged:g},null,8,["tags","class"]),x(e("div",null,[e("p",_t,V(s.$page.props.errors.category),1)],512),[[F,s.$page.props.errors.category]])])])]),e("div",yt,[e("div",bt,[wt,e("div",xt,[e("div",kt,[x(e("input",{type:"checkbox",id:"checkbox1","onUpdate:modelValue":o[4]||(o[4]=c=>u(a).refundable=c)},null,512),[[re,u(a).refundable]]),Tt])])])])])]),e("div",Ct,[It,e("div",St,[e("div",Nt,[e("div",$t,[Bt,e("div",Ot,[w(S,{"file-list":r.value,"onUpdate:fileList":o[5]||(o[5]=c=>r.value=c),"list-type":"picture-card",multiple:"","on-preview":f,"on-remove":s.handleRemove,"on-change":I},{default:O(()=>[w(_,null,{default:O(()=>[w(u(Le))]),_:1})]),_:1},8,["file-list","on-remove"])])])]),e("div",Vt,[e("div",Et,[Mt,e("div",Pt,[e("input",{type:"file",class:"custom-file-input",onInput:o[6]||(o[6]=c=>u(a).thumbnail_img=s.event.target.value[0])},null,32),Dt]),e("div",jt,[e("img",{id:"image",src:`${u(i)}/products/default.png`,alt:"",width:"100px"},null,8,At)])])])])])])]),Ft],32)])])]),_:1})],64)}}};export{Gt as default};
