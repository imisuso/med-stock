import{B,a as b}from"./Guest-CRCh1Ymv.js";import{B as _,a as w,b as z}from"./ValidationErrors-CVUyTp-h.js";import{x as y,y as t,c as m,d as o,a as r,t as x,j as g,e as V,n as k,z as v,F as E,o as i,b as F}from"./app-D0dg4ktR.js";import{_ as L}from"./_plugin-vue_export-helper-DlAUqK2U.js";const N={layout:B,components:{BreezeButton:b,BreezeInput:_,BreezeLabel:w,BreezeValidationErrors:z,Head:y},props:{status:String},data(){return{form:this.$inertia.form({email:""})}},methods:{submit(){this.form.post(this.route("password.email"))}}},C={key:0,class:"mb-4 font-medium text-sm text-green-600"},h={class:"flex items-center justify-end mt-4"};function H(I,e,n,P,s,l){const u=t("Head"),d=t("BreezeValidationErrors"),p=t("BreezeLabel"),c=t("BreezeInput"),f=t("BreezeButton");return i(),m(E,null,[o(u,{title:"Forgot Password"}),e[3]||(e[3]=r("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1)),n.status?(i(),m("div",C,x(n.status),1)):g("",!0),o(d,{class:"mb-4"}),r("form",{onSubmit:e[1]||(e[1]=v((...a)=>l.submit&&l.submit(...a),["prevent"]))},[r("div",null,[o(p,{for:"email",value:"Email"}),o(c,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s.form.email,"onUpdate:modelValue":e[0]||(e[0]=a=>s.form.email=a),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"])]),r("div",h,[o(f,{class:k({"opacity-25":s.form.processing}),disabled:s.form.processing},{default:V(()=>e[2]||(e[2]=[F(" Email Password Reset Link ")])),_:1},8,["class","disabled"])])],32)],64)}const G=L(N,[["render",H]]);export{G as default};
