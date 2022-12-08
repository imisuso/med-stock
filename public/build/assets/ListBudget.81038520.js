import{r as _,h as C,o as d,c as l,a as e,t as s,u as O,B as $,w as I,v as S,b as u,k as b,F as x,f as v,j as k,d as w,e as i,y as F,l as L}from"./app.cccaf2cb.js";import{A as U}from"./AppLayout.124f4623.js";import{_ as B}from"./ModalUpToYou.050ac120.js";import"./_plugin-vue_export-helper.cdc0426e.js";const D={for:"",class:"px-6"},P={name:"BudgetOrder",props:{orderIndex:{type:Number,required:!0},orderItem:{type:Object,required:!0}},setup(t){const r=t,n=_(0);return C(()=>{n.value=r.orderItem.timeline.approve_budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}),(f,h)=>(d(),l("div",null,[e("label",D,s(t.orderIndex+1)+". \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D("+s(t.orderItem.type)+"): "+s(t.orderItem.order_no)+"/"+s(t.orderItem.year)+" \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D: "+s(t.orderItem.date_order)+" \u0E40\u0E1B\u0E47\u0E19\u0E40\u0E07\u0E34\u0E19:"+s(n.value)+" \u0E1A\u0E32\u0E17 ",1)]))}},T={for:"",class:"px-6"},z={name:"PurchaseOrder",props:{orderIndex:{type:Number,required:!0},orderItem:{type:Object,required:!0}},setup(t){const r=t,n=_(0);return C(()=>{n.value=r.orderItem.budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}),(f,h)=>(d(),l("div",null,[e("label",T,s(t.orderIndex+1)+". \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D: "+s(t.orderItem.date_order)+" \u0E40\u0E1B\u0E47\u0E19\u0E40\u0E07\u0E34\u0E19:"+s(n.value)+" \u0E1A\u0E32\u0E17 ",1)]))}},G={class:"py-2 border-b-2 border-red-300"},H={class:"flex justify-between"},J={class:""},K={class:"font-bold"},Q={key:0,class:"flex justify-between px-3"},R=e("label",{class:""}," \u0E23\u0E30\u0E1A\u0E38\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13: ",-1),W={class:"p-2 mr-2"},X={key:1,class:"flex justify-between px-3"},Z={class:"px-3 text-green-600 font-bold"},ee={class:"flex px-2"},te={class:"px-3"},oe={key:0,class:"flex mr-2"},de=["href"],se={key:2},re={key:0},le=e("label",{class:"px-6 font-bold"},"\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E43\u0E1A\u0E2A\u0E31\u0E0D\u0E0D\u0E32\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D",-1),ne={key:1,class:"mt-2"},ue=e("label",{class:"px-6 font-bold"},"\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D",-1),ae=e("p",{class:"text-md font-bold text-red-600"},"\u0E04\u0E38\u0E13\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48?",-1),ce={class:"w-full flex flex-col text-gray-900 text-md font-medium dark:text-white"},ie={for:""},ge={for:""},me=e("p",{class:"text-md font-bold text-red-600"},"\u0E41\u0E01\u0E49\u0E44\u0E02\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13",-1),be={class:"w-full flex flex-col text-gray-900 text-md font-medium dark:text-white"},_e={for:""},fe={for:""},he=e("p",{class:"text-md font-bold text-red-600"},"\u0E01\u0E23\u0E38\u0E13\u0E32\u0E2D\u0E48\u0E32\u0E19 ",-1),xe={class:"w-full flex flex-col text-gray-900 text-md font-medium dark:text-white"},pe={for:""},ve={name:"StockBudget",props:{stockIndex:{type:Number,required:!0},stockBudget:{type:Object,required:!0},budgetYear:{type:Number,required:!0}},setup(t){const r=t,n=_(!1),f=_(!1),h=_(0),g=_(!1),a=_(!1),o=O({stock_id:{type:Number},stock_name:{type:String},budget_year:{type:Number},budget_input:{type:Number,defaulte:0},budget_edit:{type:Number,defaulte:0}}),j=$(()=>r.stockBudget.budget.budget_add.toString().replace(/\B(?=(\d{3})+(?!\d))/g,","));$(()=>r.stockBudget.budget.budget_add!=0?r.stockBudget.balance_budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g,","):"0");const N=c=>{f.value=!0,o.stock_id=r.stockBudget.id,o.stock_name=r.stockBudget.stockname,o.budget_year=r.budgetYear,h.value=o.budget_input.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")},M=()=>{f.value=!1},q=()=>{g.value=!1,F.Inertia.visit(route("budget-list"))},Y=()=>{f.value=!1,o.stock_id=r.stockBudget.id,o.budget_year=r.budgetYear,o.post(route("add-budget"),{preserveState:!0,preserveScroll:!0,onSuccess:c=>{console.log("success"),g.value=!0},onError:c=>{console.log("error"),g.value=!0},onFinish:c=>{console.log("finish")}})},A=()=>{console.log("edit budget"),o.stock_id=r.stockBudget.id,o.stock_name=r.stockBudget.stockname,o.budget_year=r.budgetYear,o.budget_edit=r.stockBudget.budget.budget_add,a.value=!0},E=()=>{a.value=!1,o.post(route("edit-budget"),{preserveState:!0,preserveScroll:!0,onSuccess:c=>{console.log("success"),g.value=!0,console.log(o.budget_year)},onError:c=>{console.log("error"),g.value=!0},onFinish:c=>{console.log("finish")}})},V=()=>{a.value=!1};return(c,p)=>(d(),l(x,null,[e("div",null,[e("div",G,[e("div",H,[e("div",J,[e("label",K,s(t.stockIndex+1)+". "+s(t.stockBudget.stockname),1)])]),t.stockBudget.budget.budget_add==0?(d(),l("div",Q,[e("div",null,[R,I(e("input",{type:"number",class:"rounded-md","onUpdate:modelValue":p[0]||(p[0]=m=>u(o).budget_input=m)},null,512),[[S,u(o).budget_input]])]),e("div",W,[c.$page.props.auth.user.roles[0].name=="admin_med_stock"?(d(),l("button",{key:0,class:"flex justify-center py-1 px-2 bg-green-200 text-green-900 rounded-md shadow-md hover:bg-green-300 focus:outline-none",onClick:N}," \u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01 ")):b("",!0)])])):b("",!0),t.stockBudget.budget.budget_add!=0?(d(),l("div",X,[e("div",null,[e("label",Z," \u0E44\u0E14\u0E49\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 "+s(u(j))+" \u0E1A\u0E32\u0E17 ",1)]),e("div",ee,[e("div",te,[c.$page.props.auth.user.roles[0].name=="admin_med_stock"?(d(),l("button",{key:0,class:"flex justify-center py-1 px-2 bg-yellow-200 text-yellow-900 rounded-md shadow-md hover:bg-yellow-300 focus:outline-none",onClick:A}," \u0E41\u0E01\u0E49\u0E44\u0E02 ")):b("",!0)]),t.stockBudget.count_import>0?(d(),l("div",oe,[e("a",{href:c.route("get-list-order",{stock_id:t.stockBudget.id,year:t.budgetYear}),class:"flex justify-center py-1 px-2 bg-blue-200 text-blue-900 rounded-md shadow-md hover:bg-blue-300 focus:outline-none"}," \u0E14\u0E39\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E17\u0E35\u0E48\u0E19\u0E33\u0E40\u0E02\u0E49\u0E32\u0E08\u0E32\u0E01Excel ",8,de)])):b("",!0)])])):b("",!0),n.value?(d(),l("div",se,[t.stockBudget.orders.length!=0?(d(),l("div",re,[le,(d(!0),l(x,null,v(t.stockBudget.orders,(m,y)=>(d(),k(P,{key:m.id,orderIndex:y,orderItem:m},null,8,["orderIndex","orderItem"]))),128))])):b("",!0),t.stockBudget.purchase_orders.length!=0?(d(),l("div",ne,[ue,(d(!0),l(x,null,v(t.stockBudget.purchase_orders,(m,y)=>(d(),k(z,{key:m.id,orderIndex:y,orderItem:m},null,8,["orderIndex","orderItem"]))),128))])):b("",!0)])):b("",!0)])]),w(B,{isModalOpen:f.value},{header:i(()=>[ae]),body:i(()=>[e("div",ce,[e("div",ie,s(u(o).stock_name),1),e("div",null," \u0E1B\u0E35\u0E07\u0E1A:"+s(u(o).budget_year+543),1),e("div",ge," \u0E08\u0E33\u0E19\u0E27\u0E19 "+s(h.value)+" \u0E1A\u0E32\u0E17 ",1)])]),footer:i(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:Y}," \u0E15\u0E01\u0E25\u0E07 "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:M}," \u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 ")])]),_:1},8,["isModalOpen"]),w(B,{isModalOpen:a.value},{header:i(()=>[me]),body:i(()=>[e("div",be,[e("div",_e,s(u(o).stock_name),1),e("div",null," \u0E1B\u0E35\u0E07\u0E1A:"+s(u(o).budget_year+543),1),e("div",fe,[I(e("input",{type:"number",class:"rounded-md","onUpdate:modelValue":p[1]||(p[1]=m=>u(o).budget_edit=m)},null,512),[[S,u(o).budget_edit]])])])]),footer:i(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:E}," \u0E15\u0E01\u0E25\u0E07 "),e("button",{class:"mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600",onClick:V}," \u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 ")])]),_:1},8,["isModalOpen"]),w(B,{isModalOpen:g.value},{header:i(()=>[he]),body:i(()=>[e("div",xe,[e("div",pe,s(c.$page.props.flash.status)+":"+s(c.$page.props.flash.msg),1)])]),footer:i(()=>[e("div",{class:"w-full text-center md:block"},[e("button",{class:"mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400",onClick:q}," \u0E15\u0E01\u0E25\u0E07 ")])]),_:1},8,["isModalOpen"])],64))}},ke={class:"flex flex-col mb-2 text-md font-bold text-gray-900"},ye={class:"m-2"},we=e("label",{for:""},"\u0E23\u0E30\u0E1A\u0E38\u0E1B\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13:",-1),Be=["value"],Ie=e("h1",{class:"text-center font-bold text-lg"},"\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E41\u0E15\u0E48\u0E25\u0E30\u0E2A\u0E32\u0E02\u0E32",-1),$e={key:0,class:"text-center font-bold text-lg"},Ne={name:"ListBudget",props:{years:{type:Object,required:!0}},setup(t){const r=_("");_(!0);const n=O({year_selected:""}),f=()=>{axios.get(route("get-list-budget",{year:n.year_selected})).then(h=>{r.value=h.data.stocks})};return(h,g)=>(d(),k(U,null,{default:i(()=>[e("div",ke,[e("div",ye,[we,I(e("select",{name:"",id:"","onUpdate:modelValue":g[0]||(g[0]=a=>u(n).year_selected=a),class:"block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline",onChange:f},[(d(!0),l(x,null,v(t.years,(a,o)=>(d(),l("option",{key:o,value:a},s(a+543),9,Be))),128))],544),[[L,u(n).year_selected]])])]),e("div",null,[Ie,u(n).year_selected?(d(),l("h1",$e,"\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13 "+s(u(n).year_selected+543),1)):b("",!0),(d(!0),l(x,null,v(r.value,(a,o)=>(d(),k(ve,{key:a.id,stockIndex:o,stockBudget:a,budgetYear:u(n).year_selected},null,8,["stockIndex","stockBudget","budgetYear"]))),128))])]),_:1}))}};export{Ne as default};
