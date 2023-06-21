import{_ as i}from"./_plugin-vue_export-helper.cdc0426e.js";import{o as e,c as s,t as u,s as m,a as l,F as p,f,i as $}from"./app.b3e5434e.js";const h={props:["modelValue"],emits:["update:modelValue"],methods:{focus(){this.$refs.input.focus()}}},g=["value"];function y(r,o,t,c,d,n){return e(),s("input",{class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",value:t.modelValue,onInput:o[0]||(o[0]=a=>r.$emit("update:modelValue",a.target.value)),ref:"input"},null,40,g)}const L=i(h,[["render",y]]),k={props:["value"]},v={class:"block font-medium text-sm text-gray-700"},x={key:0},b={key:1};function B(r,o,t,c,d,n){return e(),s("label",v,[t.value?(e(),s("span",x,u(t.value),1)):(e(),s("span",b,[m(r.$slots,"default")]))])}const N=i(k,[["render",B]]),V={computed:{errors(){return this.$page.props.errors},hasErrors(){return Object.keys(this.errors).length>0}}},E={key:0},w=l("div",{class:"font-medium text-red-600"},"Whoops! Something went wrong.",-1),z={class:"mt-3 list-disc list-inside text-sm text-red-600"};function S(r,o,t,c,d,n){return n.hasErrors?(e(),s("div",E,[w,l("ul",z,[(e(!0),s(p,null,f(n.errors,(a,_)=>(e(),s("li",{key:_},u(a),1))),128))])])):$("",!0)}const j=i(V,[["render",S]]);export{L as B,N as a,j as b};
