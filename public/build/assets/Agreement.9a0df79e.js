import{A as u}from"./AppLayout.124f4623.js";import{u as m,o as s,j as f,e as p,a as e,t as a,c as n,f as g,F as x,k as y}from"./app.cccaf2cb.js";import{d as b,b as h}from"./buddhistEra.e3d797a8.js";import"./_plugin-vue_export-helper.cdc0426e.js";const _={class:"flex-col p-2 w-full justify-center bg-red-50"},v={class:"font-bold text-md"},k={key:0},j=e("div",{class:"w-full flex justify-center my-2 mx-10 text-red-600"},[e("label",{for:""},"\u0E17\u0E48\u0E32\u0E19\u0E23\u0E31\u0E1A\u0E17\u0E23\u0E32\u0E1A\u0E41\u0E25\u0E30\u0E15\u0E01\u0E25\u0E07\u0E15\u0E32\u0E21\u0E19\u0E42\u0E22\u0E1A\u0E32\u0E22\u0E01\u0E32\u0E23\u0E04\u0E38\u0E49\u0E21\u0E04\u0E23\u0E2D\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2A\u0E48\u0E27\u0E19\u0E1A\u0E38\u0E04\u0E04\u0E25\u0E02\u0E49\u0E32\u0E07\u0E15\u0E49\u0E19")],-1),w={class:"flex flex-col lg:flex-row px-2 py-2"},E={name:"Agreement",props:{agreements:{type:Object,required:!0},user_agreement:{type:Boolean}},setup(t){const c=t;b.extend(h);const i=m({agreement_id:c.agreements.id}),d=()=>{i.post(route("accept-agreement"),{preserveState:!1,preserveScroll:!0,onSuccess:o=>{console.log("success")},onError:o=>{console.log("error")},onFinish:o=>{console.log("finish")}})};return(o,l)=>(s(),f(u,null,{default:p(()=>[e("div",_,[e("label",v,a(t.agreements.title),1),(s(!0),n(x,null,g(t.agreements.contents.detail,(r,A)=>(s(),n("p",{key:r.id,class:"flex-col py-2 text-blue-900 text-md rounded-md"},a(r),1))),128))]),t.user_agreement?(s(),n("div",k,[j,e("div",w,[e("button",{class:"w-full flex justify-center px-4 py-1 text-sm text-white bg-green-600 rounded-md hover:bg-green-400 focus:outline-none",onClick:l[0]||(l[0]=r=>d())}," \u0E23\u0E31\u0E1A\u0E17\u0E23\u0E32\u0E1A ")])])):y("",!0)]),_:1}))}};export{E as default};
