import{r as $,T as B,h as M,e as c,o as d,c as a,a as e,b as h,t as r,i as m,w as b,j as g,u as i,f as _,F as p,C as V,d as w,k as C}from"./app.b3e5434e.js";import{A as E}from"./AppLayout.89311563.js";import{_ as S}from"./ModalUpToYou.8811a7fa.js";import"./_plugin-vue_export-helper.cdc0426e.js";import"./Navbar.6bd72f65.js";const A={key:0,class:"alert-banner fixed right-0 m-4 w-2/3 md:w-full max-w-sm"},N=e("input",{type:"checkbox",class:"hidden",id:"banneralert"},null,-1),O={class:"close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold",title:"close",for:"banneralert"},z=e("svg",{class:"fill-current text-white",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 18 18"},[e("path",{d:"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"})],-1),F={key:1,class:"alert-banner fixed right-0 m-4 w-2/3 md:w-full max-w-sm"},D=e("input",{type:"checkbox",class:"hidden",id:"banneralert"},null,-1),R={class:"close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-yellow-800 font-bold",title:"close",for:"banneralert"},T=e("svg",{class:"fill-current text-red",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 18 18"},[e("path",{d:"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"})],-1),q={key:2,class:"alert-banner fixed right-0 m-4 w-2/3 md:w-full max-w-sm"},G=e("input",{type:"checkbox",class:"hidden",id:"banneralert"},null,-1),H={class:"close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-800 font-bold",title:"close",for:"banneralert"},I=e("svg",{class:"fill-current text-red",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 18 18"},[e("path",{d:"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"})],-1),J={class:"w-full p-4 flex-col justify-center bg-blue-100 rounded-md"},K=e("div",{class:"text-center text-lg font-bold"},[e("p",{class:"my-2"},"\u0E41\u0E01\u0E49\u0E44\u0E02\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1C\u0E39\u0E49\u0E43\u0E0A\u0E49\u0E07\u0E32\u0E19")],-1),P={class:"w-full bg-blue-100 rounded-md"},Q={class:"mt-3"},W={for:""},X=e("div",{class:"mt-3"},[e("label",{for:""},"\u0E23\u0E30\u0E1A\u0E38\u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19\u0E17\u0E35\u0E48\u0E2A\u0E31\u0E07\u0E01\u0E31\u0E14:")],-1),Y=["value"],Z={class:"w-full bg-blue-100 rounded-md"},ee={class:"w-full bg-blue-100 rounded-md"},te=e("div",{class:"bg-blue-800 text-white text-xl text-center"},null,-1),se=e("div",{class:"mt-3"},[e("label",{for:""},"\u0E23\u0E30\u0E1A\u0E38\u0E2A\u0E34\u0E17\u0E18\u0E34\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49\u0E07\u0E32\u0E19\u0E23\u0E30\u0E1A\u0E1A:")],-1),oe=["value"],le=e("div",{class:"mt-3"},[e("label",{for:""},"\u0E23\u0E30\u0E1A\u0E38\u0E2A\u0E16\u0E32\u0E19\u0E30\u0E1C\u0E39\u0E49\u0E43\u0E0A\u0E49\u0E07\u0E32\u0E19:")],-1),re=["value"],ne={for:"one"},de={class:"mt-3"},ae={for:""},ie={class:""},ue=e("p",{class:"text-md font-bold text-red-600"},"\u0E04\u0E38\u0E13\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E41\u0E01\u0E49\u0E44\u0E02\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1C\u0E39\u0E49\u0E43\u0E0A\u0E49\u0E07\u0E32\u0E19\u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48?",-1),ce={class:"text-gray-900 text-md font-medium"},fe={class:"flex justify-start w-full text-sm"},he={class:"flex justify-start w-full text-sm"},me={class:"flex justify-start w-full text-sm"},be={class:"flex justify-start w-full text-sm"},ve={__name:"EditUser",props:{user:Array,user_status_list:{type:Array,required:!0},units:Object,roles:Object},setup(u){const n=u,f=$(!1),x=t=>n.user_status_list[t-1].desc,v=()=>{let t={};return t=n.roles.find(l=>l.id===o.role_id),o.role_name=t.name,t.label},y=()=>{f.value=!1},o=B({user_id:n.user.id,unit_id:n.user.unitid,role_id:n.user.roles[0].id,role_name:n.user.roles[0].label,user_name_thai:n.user.username?n.user.name:"",user_status:n.user.status?n.user.status:0}),k=()=>{let t={};return t=n.units.find(l=>l.unitid===o.unit_id),t.unitname},j=()=>{f.value=!0},L=()=>{f.value=!1,o.post(route("update-user",o.user_id),{preserveState:!1,preserveScroll:!0,onSuccess:t=>{console.log("success")},onError:t=>{console.log("error")},onFinish:t=>{console.log("finish")}})};return(t,l)=>(d(),M(E,null,{default:c(()=>[t.$page.props.flash.status=="success"?(d(),a("div",A,[N,e("label",O,[h(r(t.$page.props.flash.msg)+" ",1),z])])):m("",!0),t.$page.props.flash.status=="warning"?(d(),a("div",F,[D,e("label",R,[h(r(t.$page.props.flash.msg)+" ",1),T])])):m("",!0),t.$page.props.flash.status=="error"?(d(),a("div",q,[G,e("label",H,[h(r(t.$page.props.flash.msg)+" ",1),I])])):m("",!0),e("div",J,[K,e("div",null,[e("div",P,[e("div",Q,[e("label",W,"\u0E0A\u0E37\u0E48\u0E2D\u0E40\u0E08\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E17\u0E35\u0E48:"+r(u.user.name),1)])]),X,b(e("select",{name:"",id:"",class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline","onUpdate:modelValue":l[0]||(l[0]=s=>i(o).unit_id=s)},[(d(!0),a(p,null,_(u.units,s=>(d(),a("option",{key:s.id,value:s.unitid},r(s.unitname),9,Y))),128))],512),[[g,i(o).unit_id]]),e("div",Z,[e("div",ee,[te,se,b(e("select",{name:"",id:"",class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline","onUpdate:modelValue":l[1]||(l[1]=s=>i(o).role_id=s)},[(d(!0),a(p,null,_(u.roles,s=>(d(),a("option",{key:s.id,value:s.id},r(s.label),9,oe))),128))],512),[[g,i(o).role_id]])]),le,(d(!0),a(p,null,_(u.user_status_list,s=>(d(),a("div",{key:s.id,class:"form-check"},[b(e("input",{type:"radio",id:"one",value:s.id,"onUpdate:modelValue":l[2]||(l[2]=U=>i(o).user_status=U),class:"form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"},null,8,re),[[V,i(o).user_status]]),e("label",ne,r(s.desc),1)]))),128))]),e("div",de,[e("label",ae,"\u0E0A\u0E37\u0E48\u0E2D\u0E1C\u0E39\u0E49\u0E40\u0E1E\u0E34\u0E48\u0E21\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25:"+r(u.user.profile.user_name_in),1)]),e("div",ie,[e("button",{type:"submit",class:"w-full flex justify-center py-2 text-md bg-green-500 hover:bg-green-700 text-white border border-green-500 rounded",onClick:l[3]||(l[3]=s=>j())}," \u0E41\u0E01\u0E49\u0E44\u0E02 "),w(i(C),{href:t.route("user-add"),class:"w-full flex justify-center my-2 py-2 text-md bg-blue-500 hover:bg-blue-700 text-white border border-blue-500 rounded"},{default:c(()=>[h(" \u0E01\u0E25\u0E31\u0E1A ")]),_:1},8,["href"])])])]),w(S,{isModalOpen:f.value},{header:c(()=>[ue]),body:c(()=>[e("div",ce,[e("label",fe," \u0E0A\u0E37\u0E48\u0E2D: "+r(u.user.name),1),e("label",he," \u0E2B\u0E19\u0E48\u0E27\u0E22/\u0E2A\u0E32\u0E02\u0E32: "+r(k()),1),e("label",me," \u0E2A\u0E34\u0E17\u0E18\u0E34\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49\u0E07\u0E32\u0E19\u0E23\u0E30\u0E1A\u0E1A: "+r(v()),1),e("label",be," \u0E2A\u0E16\u0E32\u0E19\u0E30: "+r(x(i(o).user_status)),1)])]),footer:c(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:L}," \u0E15\u0E01\u0E25\u0E07 "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:y}," \u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 ")])]),_:1},8,["isModalOpen"])]),_:1}))}};export{ve as default};
