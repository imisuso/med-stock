import{A as y}from"./AppLayout-BJKdIcXC.js";import{_ as C}from"./ModalUpToYou-BSkTNLAu.js";import{_ as L}from"./OrderDetail-CpZL_9jU.js";import{r as f,C as j,i as c,e as i,o as s,c as o,a as e,b as a,t as d,j as n,f as m,F as h,d as V}from"./app-D0dg4ktR.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Navbar-B_O4qWE3.js";const B={key:0,class:"alert-banner fixed right-0 m-2 w-2/3 md:w-full max-w-sm"},H={class:"close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold",title:"close",for:"banneralert"},M={key:1,class:"alert-banner fixed right-0 m-2 w-5/6 md:w-full max-w-sm"},z={class:"close cursor-pointer flex items-center justify-between w-full p-2 bg-red-700 shadow rounded-md text-white font-bold",title:"close",for:"banneralert"},O={class:"w-full bg-blue-100 p-2 rounded-md"},$={class:"bg-blue-800 text-white text-xl text-center"},_={name:"",id:"",class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline"},S={key:2,class:"flex justify-center text-red-600"},A={key:0,class:"text-sm text-red-500"},N={key:1,class:"text-sm text-red-500"},F={key:2,class:"text-sm text-red-500"},I=["href"],D=["href"],E=["onClick"],T=["href"],q={key:3,class:"flex ml-3 bg-red-500 hover:bg-red-700 text-white d py-1 px-8 text-sm border border-red-500 rounded"},G={class:"text-gray-900 text-md font-medium"},X={__name:"OrderList",props:{stocks:Object,unit:Object,order_lists:Object},setup(w){const u=f(!1),g=f(Array),v=j({confirm_order_id:0}),x=l=>{u.value=!0,g.value=l.items,v.confirm_order_id=l.id},b=()=>{u.value=!1},k=()=>{u.value=!1,v.post(route("send-order"),{preserveState:!1,preserveScroll:!0})};return(l,t)=>(s(),c(y,null,{default:i(()=>[l.$page.props.flash.status==="success"?(s(),o("div",B,[t[1]||(t[1]=e("input",{type:"checkbox",class:"hidden",id:"banneralert"},null,-1)),e("label",H,[a(d(l.$page.props.flash.msg)+" ",1),t[0]||(t[0]=e("svg",{class:"fill-current text-white",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 18 18"},[e("path",{d:"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"})],-1))])])):n("",!0),l.$page.props.errors.error?(s(),o("div",M,[t[3]||(t[3]=e("input",{type:"checkbox",class:"hidden",id:"banneralert"},null,-1)),e("label",z,[a(d(l.$page.props.errors.error)+" ",1),t[2]||(t[2]=e("svg",{class:"fill-current text-white",xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 18 18"},[e("path",{d:"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"})],-1))])])):n("",!0),e("div",O,[e("div",$,d(l.$page.props.unit.unitname),1),t[4]||(t[4]=e("div",{class:"mt-3"},[e("label",{for:""},"เลือกคลังวัสดุ")],-1)),e("select",_,[(s(!0),o(h,null,m(l.$page.props.stocks,r=>(s(),o("option",{key:r.id,value:"{{stock.id}}"},d(r.stockname),1))),128))])]),t[12]||(t[12]=e("div",{class:"flex justify-between my-2"},[e("div",{class:"font-bold"},"รายการใบสัญญาสั่งซื้อวัสดุ"),e("div",null,[e("select",{name:"",id:"",class:"w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow focus:outline-none focus:shadow-outline"},[e("option",{value:""},"รายการทั้งหมด"),e("option",{value:""},"รายการที่ยังไม่ส่งไปภาคฯ"),e("option",{value:""},"รายการที่รอภาคฯอนุมัติ"),e("option",{value:""},"รายการที่ภาคฯอนุมัติแล้ว"),e("option",{value:""},"รายการที่ตรวจรับวัสดุแล้ว")])])],-1)),w.order_lists.length===0?(s(),o("div",S,t[5]||(t[5]=[e("label",{for:""},"ไม่พบรายการใบสัญญาสั่งซื้อวัสดุ",-1)]))):n("",!0),(s(!0),o(h,null,m(w.order_lists,(r,p)=>(s(),c(L,{key:r.id,orderIndex:p,orderList:r},{messagesuggest:i(()=>[r.status==="created"?(s(),o("span",A,"กดปุ่มพิมพ์และเซ็นเอกสาร แล้วส่งเอกสารตัวจริงไปที่ภาควิชาฯ แล้วกดปุ่มส่ง")):n("",!0),r.status==="sended"?(s(),o("span",N,"รออนุมัติการสั่งซื้อ จากภาควิชาฯ")):n("",!0),r.status==="approved"?(s(),o("span",F," รีบดำเนินการให้บริษัทเซ็นใบสั่งซื้อ+ส่งของ+ตรวจรับ ภายใน 7 วันทำการ นับจากวันที่ได้รับอนุมัติ เมื่อตรวจรับวัสดุตามเอกสารสั่งซื้อแล้ว ให้กดปุ่มตรวจรับวัสดุ แล้วกดปุ่มพิมพ์เอกสารตรวจรับวัสดุและเซ็นเอกสาร แล้วส่งเอกสารตัวจริงไปที่ภาควิชาฯ ")):n("",!0)]),buttongroup:i(()=>[e("a",{href:l.route("print-order",r.id),target:"blank"},t[6]||(t[6]=[e("span",{class:"inline-flex text-sm py-1 px-2 leading-5 text-white bg-blue-500 rounded-md"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z","clip-rule":"evenodd"})]),a(" พิมพ์ใบสั่งซื้อ ")],-1)]),8,I),r.status==="checkin"?(s(),o("a",{key:0,href:l.route("print-checkin",r.id),target:"self"},t[7]||(t[7]=[e("span",{class:"flex flex-row text-sm py-1 px-2 ml-3 leading-5 text-white bg-yellow-500 rounded-md"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z","clip-rule":"evenodd"})]),a(" เอกสารตรวจรับวัสดุ ")],-1)]),8,D)):n("",!0),r.status==="created"?(s(),o("button",{key:1,onClick:J=>x(r),class:"inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white py-1 px-2 border border-green-500 rounded"},t[8]||(t[8]=[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 19l9 2-9-18-9 18 9-2zm0 0v-8"})],-1),a(" ส่งเอกสารสั่งซื้อ ")]),8,E)):n("",!0),r.status==="approved"?(s(),o("a",{key:2,href:l.route("receive-order",r)},t[9]||(t[9]=[e("span",{class:"flex flex-row text-sm py-1 px-2 ml-3 leading-5 text-white bg-green-500 hover:bg-green-700 rounded"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"})]),a(" ตรวจรับวัสดุ ")],-1)]),8,T)):n("",!0),r.status==="created"?(s(),o("button",q,t[10]||(t[10]=[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"})],-1),a(" ลบ ")]))):n("",!0)]),_:2},1032,["orderIndex","orderList"]))),128)),V(C,{isModalOpen:u.value},{header:i(()=>t[11]||(t[11]=[e("p",{class:"text-md font-bold text-red-600"},"คุณต้องการส่งเอกสารการสั่งซื้อวัสดุนี้ใช่หรือไม่?",-1)])),body:i(()=>[e("div",G,[(s(!0),o(h,null,m(g.value,(r,p)=>(s(),o("label",{key:r.id,class:"flex justify-start w-full bg-red-100 text-sm text-red-900"},d(p+1)+"."+d(r[0].item_name)+" จำนวน "+d(r[0].order_input)+" x "+d(r[0].price)+" เป็นเงิน "+d(r[0].total)+" บาท ",1))),128))])]),footer:i(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:k}," ตกลง "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:b}," ยกเลิก ")])]),_:1},8,["isModalOpen"])]),_:1}))}};export{X as default};
