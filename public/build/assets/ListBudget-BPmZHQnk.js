import{r as g,g as O,o as r,c as u,a as e,t as o,C as N,m as z,j as i,w as j,v as E,u as f,F as w,f as B,i as I,d as $,e as b,k as K}from"./app-CP6RF8In.js";import{A as P}from"./AppLayout-6jvfy5Lo.js";import{_ as C}from"./ModalUpToYou-Bop7fH5u.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Navbar-O2L6vFPL.js";const T={for:"",class:"px-6"},G={__name:"BudgetOrder",props:{orderIndex:{type:Number,required:!0},orderItem:{type:Object,required:!0}},setup(t){const s=t,m=g(0);return O(()=>{m.value=s.orderItem.timeline.approve_budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}),(p,_)=>(r(),u("div",null,[e("label",T,o(t.orderIndex+1)+". เลขที่ใบสั่งซื้อ("+o(t.orderItem.type)+"): "+o(t.orderItem.order_no)+"/"+o(t.orderItem.year)+" วันที่สั่งซื้อ: "+o(t.orderItem.date_order)+" เป็นเงิน:"+o(m.value)+" บาท ",1)]))}},H={for:"",class:"px-6"},J={__name:"PurchaseOrder",props:{orderIndex:{type:Number,required:!0},orderItem:{type:Object,required:!0}},setup(t){const s=t,m=g(0);return O(()=>{m.value=s.orderItem.budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}),(p,_)=>(r(),u("div",null,[e("label",H,o(t.orderIndex+1)+". วันที่สั่งซื้อ: "+o(t.orderItem.date_order)+" เป็นเงิน:"+o(m.value)+" บาท ",1)]))}},Q={class:"py-2 border-b-2 border-red-300"},R={class:"flex justify-between"},W={class:""},X={class:"font-bold"},Z={key:0,class:"flex justify-between px-3"},ee={key:0,class:"text-red-600"},te={key:1,class:"text-red-600"},de={class:"p-2 mr-2"},re={key:1,class:"flex justify-between px-3"},oe={class:"px-3 text-green-600 font-bold"},se={class:"flex px-2"},ue={class:"px-3"},le={key:0,class:"px-3"},ne=["href"],ae={key:1,class:"flex mr-2"},ie=["href"],ce={key:2},ge={key:0},me={key:1,class:"mt-2"},be={class:"w-full flex flex-col text-gray-900 text-md font-medium"},fe={class:"w-full flex flex-col text-gray-900 text-md font-medium"},ve={key:0,class:"text-red-600"},pe={class:"w-full flex flex-col text-gray-900 text-md font-medium"},_e={__name:"StockBudget",props:{stockIndex:{type:Number,required:!0},stockBudget:{type:Object,required:!0},budgetYear:{type:Number,required:!0}},setup(t){const s=t,m=g(!1),p=g(!1),_=g(0),a=g(!1),c=g(!1),x=g(!1),d=N({stock_id:{type:Number},stock_name:{type:String},budget_year:{type:Number},budget_input:s.stockBudget.budget.budget_add?s.stockBudget.budget.budget_add:0,budget_edit:{type:Number,defaulte:0},year_selected:{type:Number}}),M=z(()=>s.stockBudget.budget.budget_add.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")),Y=()=>{d.budget_input*100%1!==0?x.value=!0:x.value=!1},y=g(""),h=g(!1),k=g(!1),q=n=>{if(d.budget_input==0)return h.value=!0,y.value="กรุณาระบุงบประมาณก่อนกดปุ่มบันทึก",!1;if(h.value=!1,document.getElementById("budget_add").value<0)return h.value=!0,y.value="กรุณาระบุงบประมาณไม่เป็นจำนวนติดลบ",document.getElementById("budget_add").focus(),!1;k.value=!1,p.value=!0,d.stock_id=s.stockBudget.id,d.stock_name=s.stockBudget.stockname,d.budget_year=s.budgetYear,d.year_selected=s.budgetYear,_.value=d.budget_input.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")},A=()=>{p.value=!1},F=()=>{a.value=!1},V=()=>{p.value=!1,d.stock_id=s.stockBudget.id,d.budget_year=s.budgetYear,d.post(route("add-budget"),{preserveState:!0,preserveScroll:!0,onSuccess:n=>{a.value=!0},onError:n=>{a.value=!0},onFinish:n=>{}})},L=()=>{d.stock_id=s.stockBudget.id,d.stock_name=s.stockBudget.stockname,d.budget_year=s.budgetYear,d.budget_edit=s.stockBudget.budget.budget_add,d.year_selected=s.budgetYear,c.value=!0},U=()=>{if(document.getElementById("budget_edit").value=="")return k.value=!0,y.value="กรุณาระบุงบประมาณที่ต้องการแก้ไข",document.getElementById("budget_edit").focus(),!1;if(k.value=!1,document.getElementById("budget_edit").value<0)return k.value=!0,y.value="กรุณาระบุงบประมาณไม่เป็นจำนวนติดลบ",document.getElementById("budget_edit").focus(),!1;if(k.value=!1,d.budget_input==0)return h.value=!0,y.value="กรุณาระบุงบประมาณก่อนกดปุ่มบันทึก",!1;h.value=!1,c.value=!1,d.post(route("edit-budget"),{preserveState:!0,preserveScroll:!0,onSuccess:n=>{a.value=!0},onError:n=>{a.value=!0},onFinish:n=>{}})},D=()=>{c.value=!1,k.value=!1};return(n,l)=>(r(),u(w,null,[e("div",null,[e("div",Q,[e("div",R,[e("div",W,[e("label",X,o(t.stockIndex+1)+". "+o(t.stockBudget.stockname),1)])]),t.stockBudget.budget.budget_add===0&&n.$page.props.auth.user.roles[0].name==="admin_med_stock"?(r(),u("div",Z,[e("div",null,[h.value?(r(),u("div",ee,[e("label",null,o(y.value),1)])):i("",!0),l[2]||(l[2]=e("label",null," ระบุงบประมาณ: ",-1)),j(e("input",{type:"number",pattern:"^\\d*(\\.\\d{0,2})?$",id:"budget_add",class:"rounded-md","onUpdate:modelValue":l[0]||(l[0]=v=>f(d).budget_input=v),onKeyup:Y},null,544),[[E,f(d).budget_input]]),x.value?(r(),u("label",te," ระบุทศนิยมได้มากที่สุด 2 หลัก ")):i("",!0)]),e("div",de,[n.$page.props.auth.user.roles[0].name==="admin_med_stock"&&!x.value?(r(),u("button",{key:0,class:"flex justify-center py-1 px-2 bg-green-200 text-green-900 rounded-md shadow-md hover:bg-green-300 focus:outline-none",onClick:q}," บันทึก ")):i("",!0)])])):i("",!0),t.stockBudget.budget.budget_add!=0?(r(),u("div",re,[e("div",null,[e("label",oe," ได้อนุมัติ "+o(M.value)+" บาท ",1)]),e("div",se,[e("div",ue,[n.$page.props.auth.user.roles[0].name=="admin_med_stock"?(r(),u("button",{key:0,class:"flex justify-center py-1 px-2 bg-yellow-200 text-yellow-900 rounded-md shadow-md hover:bg-yellow-300 focus:outline-none",onClick:L}," แก้ไข ")):i("",!0)]),n.$page.props.auth.user.roles[0].name=="admin_it"?(r(),u("div",le,[e("a",{href:n.route("get-budget-log",t.stockBudget),class:"flex py-1 px-2 rounded-md shadow-md bg-blue-300"},l[3]||(l[3]=[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"})],-1)]),8,ne)])):i("",!0),t.stockBudget.count_import>0?(r(),u("div",ae,[e("a",{href:n.route("get-list-order",{stock_id:t.stockBudget.id,year:t.budgetYear}),class:"flex justify-center py-1 px-2 bg-pink-200 text-pink-900 rounded-md shadow-md hover:bg-pink-300 focus:outline-none"}," ดูใบสั่งซื้อที่นำเข้าจากExcel ",8,ie)])):i("",!0)])])):i("",!0),m.value?(r(),u("div",ce,[t.stockBudget.orders.length!=0?(r(),u("div",ge,[l[4]||(l[4]=e("label",{class:"px-6 font-bold"},"รายการใบสัญญาสั่งซื้อ",-1)),(r(!0),u(w,null,B(t.stockBudget.orders,(v,S)=>(r(),I(G,{key:v.id,orderIndex:S,orderItem:v},null,8,["orderIndex","orderItem"]))),128))])):i("",!0),t.stockBudget.purchase_orders.length!==0?(r(),u("div",me,[l[5]||(l[5]=e("label",{class:"px-6 font-bold"},"รายการใบสั่งซื้อ",-1)),(r(!0),u(w,null,B(t.stockBudget.purchase_orders,(v,S)=>(r(),I(J,{key:v.id,orderIndex:S,orderItem:v},null,8,["orderIndex","orderItem"]))),128))])):i("",!0)])):i("",!0)])]),$(C,{isModalOpen:p.value},{header:b(()=>l[6]||(l[6]=[e("p",{class:"text-md font-bold text-red-600"},"คุณต้องการบันทึกงบประมาณใช่หรือไม่?",-1)])),body:b(()=>[e("div",be,[e("div",null,o(f(d).stock_name),1),e("div",null," ปีงบ:"+o(f(d).budget_year+543),1),e("div",null," จำนวน "+o(_.value)+" บาท ",1)])]),footer:b(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:V}," ตกลง "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:A}," ยกเลิก ")])]),_:1},8,["isModalOpen"]),$(C,{isModalOpen:c.value},{header:b(()=>l[7]||(l[7]=[e("p",{class:"text-md font-bold text-red-600"},"แก้ไขงบประมาณ",-1)])),body:b(()=>[e("div",fe,[e("div",null,o(f(d).stock_name),1),e("div",null," ปีงบ:"+o(f(d).budget_year+543),1),e("div",null,[k.value?(r(),u("div",ve,[e("label",null,o(y.value),1)])):i("",!0),j(e("input",{type:"number",id:"budget_edit",class:"rounded-md",min:"0","onUpdate:modelValue":l[1]||(l[1]=v=>f(d).budget_edit=v)},null,512),[[E,f(d).budget_edit]])])])]),footer:b(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:U}," ตกลง "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:D}," ยกเลิก ")])]),_:1},8,["isModalOpen"]),$(C,{isModalOpen:a.value},{header:b(()=>l[8]||(l[8]=[e("p",{class:"text-md font-bold text-red-600"},"กรุณาอ่าน ",-1)])),body:b(()=>[e("div",pe,[e("div",null,o(n.$page.props.flash.status)+":"+o(n.$page.props.flash.msg),1)])]),footer:b(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:F}," ตกลง ")])]),_:1},8,["isModalOpen"])],64))}},xe={class:"flex flex-col mb-2 text-md font-bold text-gray-900"},ye={class:"m-2"},ke=["value"],he={key:0,class:"text-center font-bold text-lg"},Ce={__name:"ListBudget",props:{years:{type:Object,required:!0},stock_budgets:{type:Object},year_search:{type:Number}},setup(t){const s=t;g(!0);const m=N({year_selected:s.year_search?s.year_search:""}),p=()=>{m.get(route("get-list-budget"),{preserveState:!0,preserveScroll:!0,onSuccess:_=>{},onError:_=>{},onFinish:_=>{}})};return(_,a)=>(r(),I(P,null,{default:b(()=>[e("div",xe,[e("div",ye,[a[1]||(a[1]=e("label",{for:""},"ระบุปีงบประมาณ:",-1)),j(e("select",{name:"",id:"","onUpdate:modelValue":a[0]||(a[0]=c=>f(m).year_selected=c),class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline",onChange:p},[(r(!0),u(w,null,B(t.years,(c,x)=>(r(),u("option",{key:x,value:c},o(c+543),9,ke))),128))],544),[[K,f(m).year_selected]])])]),e("div",null,[a[2]||(a[2]=e("h1",{class:"text-center font-bold text-lg"},"รายการงบประมาณแต่ละสาขา",-1)),t.year_search?(r(),u("h1",he,"ประจำปีงบประมาณ "+o(t.year_search+543),1)):i("",!0),(r(!0),u(w,null,B(t.stock_budgets,(c,x)=>(r(),I(_e,{key:c.id,stockIndex:x,stockBudget:c,budgetYear:t.year_search},null,8,["stockIndex","stockBudget","budgetYear"]))),128))])]),_:1}))}};export{Ce as default};
