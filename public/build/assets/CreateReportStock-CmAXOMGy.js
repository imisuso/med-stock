import{C,h as k,r as c,i as D,e as N,o as d,a as e,t as a,c as n,j as f,w as y,k as x,u as o,f as m,F as b,d as A,b as E}from"./app-D0dg4ktR.js";import{A as H}from"./AppLayout-BJKdIcXC.js";import{_ as O}from"./PaginateMe-DQGCYBVW.js";import{d as w,b as z}from"./buddhistEra-DDBH1div.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Navbar-B_O4qWE3.js";const U={class:"my-3 bg-blue-800 text-white text-xl text-center"},$={class:"w-full p-2 rounded-md"},F={class:"mt-3 font-bold"},I={key:0,class:"text-red-600"},L=["value"],P={class:"flex flex-col mb-2 text-md font-bold text-gray-900"},R={class:"m-2"},T={key:0,class:"text-red-600"},q=["value"],G={class:"m-2"},J={key:0,class:"text-red-600"},K=["value"],Q={class:"flex flex-col"},W={key:0,class:"w-full text-center font-bold text-lg"},X={class:"w-full py-3 text-center font-bold text-lg"},Y={for:""},Z={key:1,class:"w-full text-center"},ee={class:"w-full mt-3"},te={class:"flex flex-col lg:flex-row"},le={class:"lg:w-5/12 lg:text-xs bg-blue-100 lg:bg-transparent"},se={for:"",class:""},oe={class:"font-bold"},de={class:"lg:w-2/12"},ae={class:"font-bold"},ne={class:"lg:w-2/12"},re={class:"font-bold"},ie={class:"lg:w-1/12"},ue={class:"font-bold"},ce={class:"lg:w-1/12"},fe={class:"font-bold"},me={class:"lg:w-2/12 lg:text-xs"},be={class:"font-bold"},_e={key:2,class:"mt-6 flex flex-col"},he=["href"],ge=["href"],Be={__name:"CreateReportStock",props:{stocks:Object,unit:Object,item_trans:{type:Object},unit_selected:{type:String},year_selected:{type:String},month_selected:{type:String},year_has:{type:Object}},setup(r){w.extend(z);const u=r,s=C({unit_selected:u.unit_selected?u.unit_selected:[],year_selected:u.year_selected?u.year_selected:[],month_selected:u.month_selected?u.month_selected:[],unitid:k().props.auth.user.unitid?k().props.auth.user.unitid:0,stock_id_selected:{type:Number}}),B=c(["","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"]),S=c([{id:1,name:"มกราคม"},{id:2,name:"กุมภาพันธ์"},{id:3,name:"มีนาคม"},{id:4,name:"เมษายน"},{id:5,name:"พฤษภาคม"},{id:6,name:"มิถุนายน"},{id:7,name:"กรกฎาคม"},{id:8,name:"สิงหาคม"},{id:9,name:"กันยายน"},{id:10,name:"ตุลาคม"},{id:11,name:"พฤศจิกายน"},{id:12,name:"ธันวาคม"}]),_=c(0),h=c(!1),g=c(!1),v=c(!1),j=i=>i==0?": กรุณาระบุปี":parseInt(i)+543,V=()=>{_.value=s.unit_selected,s.stock_id_selected=_.value},M=(i,t,l)=>{if(h.value=!1,g.value=!1,v.value=!1,i.length==0)return h.value=!0,!1;if(t.length==0)return g.value=!0,!1;if(l.length==0)return v.value=!0,!1;s.get(route("report-checkout-item",s.unitid),{preserveState:!0,preserveScroll:!0})};return(i,t)=>(d(),D(H,null,{default:N(()=>[e("div",U,a(i.$page.props.unit.unitname),1),e("div",$,[e("div",F,[t[4]||(t[4]=e("label",{for:""},"เลือกคลังวัสดุ",-1)),h.value?(d(),n("label",I," !กรุณาเลือกคลังวัสดุ")):f("",!0)]),y(e("select",{name:"",id:"","onUpdate:modelValue":t[0]||(t[0]=l=>o(s).unit_selected=l),class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline",onChange:V},[(d(!0),n(b,null,m(r.stocks,l=>(d(),n("option",{key:l.id,value:l.id},a(l.stockname),9,L))),128))],544),[[x,o(s).unit_selected]])]),e("div",P,[e("div",R,[t[5]||(t[5]=e("label",{for:""},"ปี พ.ศ. (ปีปฏิทิน ตามที่มีการบันทึกตัดสต๊อก)",-1)),g.value?(d(),n("label",T," !กรุณาเลือกปี พ.ศ.")):f("",!0),y(e("select",{name:"",id:"","onUpdate:modelValue":t[1]||(t[1]=l=>o(s).year_selected=l),class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline"},[(d(!0),n(b,null,m(r.year_has,(l,p)=>(d(),n("option",{key:p,value:l.year},a(l.year+543),9,q))),128))],512),[[x,o(s).year_selected]])]),e("div",G,[t[6]||(t[6]=e("label",{for:""},"เดือน",-1)),v.value?(d(),n("label",J," !กรุณาเลือกเดือน")):f("",!0),y(e("select",{name:"",id:"","onUpdate:modelValue":t[2]||(t[2]=l=>o(s).month_selected=l),class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline"},[(d(!0),n(b,null,m(S.value,l=>(d(),n("option",{key:l.id,value:l.id},a(l.name),9,K))),128))],512),[[x,o(s).month_selected]])])]),e("div",Q,[e("button",{onClick:t[3]||(t[3]=l=>M(o(s).unit_selected,o(s).year_selected,o(s).month_selected)),class:"flex justify-center px-8 py-2 mb-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"}," ดูข้อมูลการเบิก ")]),t[17]||(t[17]=e("div",{class:"w-full py-3 text-center font-bold text-lg"},[e("label",{for:""},"รายงานบันทึกตัดสต๊อก")],-1)),_.value!=0?(d(),n("div",W,t[7]||(t[7]=[e("label",{for:""},null,-1)]))):f("",!0),e("div",X,[e("label",Y,a(B.value[o(s).month_selected])+" ปี "+a(j(o(s).year_selected)),1)]),r.item_trans.length==0?(d(),n("div",Z,t[8]||(t[8]=[e("label",{for:""},"ไม่พบข้อมูล",-1)]))):f("",!0),e("div",null,[A(O,{pagination:r.item_trans},null,8,["pagination"]),t[9]||(t[9]=e("div",{class:"w-full my-3 border-b-4 border-gray-500 shadow-sm hidden lg:block"},[e("div",{class:"flex flex-col lg:flex-row lg:justify-between mx-2"},[e("div",{class:"lg:w-5/12"}," SAP-ชื่อวัสดุ: "),e("div",{class:"lg:w-2/12"}," วันที่หมดอายุ: "),e("div",{class:"lg:w-2/12"}," วันที่เบิก: "),e("div",{class:"lg:w-1/12"}," จำนวนที่เบิก: "),e("div",{class:"lg:w-1/12"}," จำนวนคงเหลือ: "),e("div",{class:"lg:w-2/12"}," ผู้เบิก: ")])],-1))]),e("div",ee,[(d(!0),n(b,null,m(r.item_trans.data,(l,p)=>(d(),n("div",{key:l.id,class:"w-full border-b-2 border-gray-500 shadow-sm"},[e("div",te,[e("div",le,[e("label",se,a(r.item_trans.from+p)+". ",1),t[10]||(t[10]=e("label",{for:"",class:"lg:hidden"},"SAP:",-1)),e("label",oe,a(l.stock_item.item_code)+" - "+a(l.stock_item.item_name),1)]),e("div",de,[t[11]||(t[11]=e("label",{for:"",class:"lg:hidden"},"วันที่หมดอายุ:",-1)),e("label",ae,a(o(w)(l.date_expire_last).locale("th").format("DD MMM BBBB")),1)]),e("div",ne,[t[12]||(t[12]=e("label",{for:"",class:"lg:hidden"},"วันที่เบิก:",-1)),e("label",re,a(o(w)(l.date_action).locale("th").format("DD MMM BBBB")),1)]),e("div",ie,[t[13]||(t[13]=e("label",{for:"",class:"lg:hidden"},"จำนวนที่เบิก:",-1)),e("label",ue,a(l.item_count),1)]),e("div",ce,[t[14]||(t[14]=e("label",{for:"",class:"lg:hidden"},"จำนวนคงเหลือ(ปัจจุบัน):",-1)),e("label",fe,a(l.item_balance),1)]),e("div",me,[t[15]||(t[15]=e("label",{for:"",class:"lg:hidden"},"ผู้เบิก:",-1)),e("label",be,a(l.user.name),1)])])]))),128))]),r.item_trans.length!=0?(d(),n("div",_e,[e("a",{class:"flex justify-center mt-3 px-8 py-1 text-md text-white bg-blue-700 rounded-sm shadow-md hover:bg-yellow-200 focus:outline-none",href:i.route("export-checkout-item",{stock_id:o(s).unit_selected,year:o(s).year_selected,month:o(s).month_selected})}," Export Excel ",8,he),e("a",{href:i.route("view-cutstockitem-pdf",{stock_id:o(s).unit_selected,year:o(s).year_selected,month:o(s).month_selected}),target:"blank",class:"flex justify-center mt-3 px-8 py-1 text-md text-white bg-purple-500 rounded-sm shadow-md hover:bg-purple-200 focus:outline-none"},t[16]||(t[16]=[e("div",{class:"flex items-center"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"h-6 w-6",viewBox:"0 0 20 20",fill:"currentColor"},[e("path",{"fill-rule":"evenodd",d:"M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z","clip-rule":"evenodd"})]),E(" พิมพ์รายงานตัดสต๊อกวัสดุ ")],-1)]),8,ge)])):f("",!0)]),_:1}))}};export{Be as default};
