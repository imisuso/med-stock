import{B as w,a as z}from"./Guest.c81dffe5.js";import{w as v,E as V,o as m,c,Z as C,k as L,l as r,d as s,t as E,i as f,a,h as F,e as _,n as N,x as U,F as q,b as h}from"./app.b3e5434e.js";import{_ as b}from"./_plugin-vue_export-helper.cdc0426e.js";import{B as H,a as I,b as P}from"./ValidationErrors.410afc9b.js";const R={emits:["update:checked"],props:{checked:{type:[Array,Boolean],default:!1},value:{default:null}},computed:{proxyChecked:{get(){return this.checked},set(i){this.$emit("update:checked",i)}}}},S=["value"];function D(i,e,n,k,o,l){return v((m(),c("input",{type:"checkbox",value:n.value,"onUpdate:modelValue":e[0]||(e[0]=d=>l.proxyChecked=d),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"},null,8,S)),[[V,l.proxyChecked]])}const M=b(R,[["render",D]]),j={layout:w,components:{BreezeButton:z,BreezeCheckbox:M,BreezeInput:H,BreezeLabel:I,BreezeValidationErrors:P,Head:C,Link:L},props:{canResetPassword:Boolean,status:String},data(){return{form:this.$inertia.form({email:"",password:"",remember:!1})}},methods:{submit(){this.form.post(this.route("login"),{onFinish:()=>this.form.reset("password")})}}},A={key:0,class:"mb-4 font-medium text-sm text-green-600"},G={class:"mt-4"},T={class:"block mt-4"},Z={class:"flex items-center"},J=a("span",{class:"ml-2 text-sm text-gray-600"},"Remember me",-1),K={class:"flex items-center justify-end mt-4"};function O(i,e,n,k,o,l){const d=r("Head"),B=r("BreezeValidationErrors"),u=r("BreezeLabel"),p=r("BreezeInput"),x=r("BreezeCheckbox"),g=r("Link"),y=r("BreezeButton");return m(),c(q,null,[s(d,{title:"Login"}),s(B,{class:"mb-4"}),n.status?(m(),c("div",A,E(n.status),1)):f("",!0),a("form",{onSubmit:e[3]||(e[3]=U((...t)=>l.submit&&l.submit(...t),["prevent"]))},[a("div",null,[s(u,{for:"email",value:"Email"}),s(p,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:o.form.email,"onUpdate:modelValue":e[0]||(e[0]=t=>o.form.email=t),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"])]),a("div",G,[s(u,{for:"password",value:"Password"}),s(p,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o.form.password,"onUpdate:modelValue":e[1]||(e[1]=t=>o.form.password=t),required:"",autocomplete:"current-password"},null,8,["modelValue"])]),a("div",T,[a("label",Z,[s(x,{name:"remember",checked:o.form.remember,"onUpdate:checked":e[2]||(e[2]=t=>o.form.remember=t)},null,8,["checked"]),J])]),a("div",K,[n.canResetPassword?(m(),F(g,{key:0,href:i.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900"},{default:_(()=>[h(" Forgot your password? ")]),_:1},8,["href"])):f("",!0),s(y,{class:N(["ml-4",{"opacity-25":o.form.processing}]),disabled:o.form.processing},{default:_(()=>[h(" Log in ")]),_:1},8,["class","disabled"])])],32)],64)}const $=b(j,[["render",O]]);export{$ as default};
