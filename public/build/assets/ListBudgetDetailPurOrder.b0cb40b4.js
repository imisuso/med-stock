import{A as w}from"./AppLayout.1db3fb0e.js";import{o as a,j as v,e as i,a as e,d as _,b as d,L as h,t as s,c as b,f as x,F as y,g as f}from"./app.9692f9c1.js";import{d as c,b as k}from"./buddhistEra.f7210be8.js";import"./_plugin-vue_export-helper.cdc0426e.js";import"./Navbar.037f3b20.js";const B={class:""},p=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"})],-1),M=f(" \u0E01\u0E25\u0E31\u0E1A "),L={class:"w-full flex flex-col items-center bg-blue-100"},j={for:""},A={for:""},N={for:""},S={for:""},D={for:""},P=e("div",{class:"w-full flex flex-col bg-blue-200"},[e("label",{for:""}," \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E27\u0E31\u0E2A\u0E14\u0E38\u0E17\u0E35\u0E48\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E21\u0E35\u0E14\u0E31\u0E07\u0E19\u0E35\u0E49")],-1),V=e("div",{class:""},[e("div",{class:"w-full my-3 border-b-4 border-gray-500 shadow-sm hidden lg:block"},[e("div",{class:"flex flex-col font-bold text-md lg:flex-row lg:justify-between mx-2"},[e("div",{class:"lg:w-4/12"}," SAP:\u0E0A\u0E37\u0E48\u0E2D\u0E27\u0E31\u0E2A\u0E14\u0E38 "),e("div",{class:"lg:w-1/12"}," \u0E08\u0E33\u0E19\u0E27\u0E19 "),e("div",{class:"lg:w-1/12"}," \u0E23\u0E32\u0E04\u0E32 "),e("div",{class:"lg:w-2/12"}," Invoice Number "),e("div",{class:"lg:w-3/12"}," \u0E1A\u0E23\u0E34\u0E29\u0E31\u0E17 "),e("div",{class:"lg:w-2/12"}," \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E15\u0E23\u0E27\u0E08\u0E23\u0E31\u0E1A ")])])],-1),C={class:"w-full mt-3"},E={class:"flex flex-col text-sm lg:flex-row"},F={class:"hidden lg:block"},H={class:"bg-blue-100 lg:bg-transparent lg:w-4/12"},I={for:"",class:"lg:hidden"},O={class:"font-bold"},T={class:"lg:w-1/12"},q=e("label",{for:"",class:"lg:hidden"},"\u0E08\u0E33\u0E19\u0E27\u0E19:",-1),z={class:"font-bold"},G={class:"lg:w-1/12"},J=e("label",{for:"",class:"lg:hidden"},"\u0E23\u0E32\u0E04\u0E32:",-1),K={class:"font-bold"},Q={class:"lg:w-2/12"},R=e("label",{for:"",class:"lg:hidden"},"Invoice Number:",-1),U={class:"font-bold"},W={class:"lg:w-3/12"},X=e("label",{for:"",class:"lg:hidden"},"\u0E1A\u0E23\u0E34\u0E29\u0E31\u0E17:",-1),Y={class:"font-bold"},Z={class:"flex lg:w-2/12"},$=e("label",{for:"",class:"lg:hidden"},"\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E15\u0E23\u0E27\u0E08\u0E23\u0E31\u0E1A:",-1),ee={class:"font-bold"},se={class:"my-2 p-2 bg-blue-200"},te={for:""},oe=f(" \u0E01\u0E25\u0E31\u0E1A "),re={name:"ListBudgetDetailPurOrder",props:{order_item_trans:{type:Array},order_budget_used:{type:String},year_budget:"",stock_id:""},setup(t){const u=t;c.extend(k);const r=u.year_budget-543,g=l=>l.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");return(l,m)=>(a(),v(w,null,{default:i(()=>[e("div",B,[_(d(h),{href:l.route("get-list-order",{stock_id:t.stock_id,year:r}),class:"flex text-gray-600 font-bold"},{default:i(()=>[p,M]),_:1},8,["href"]),e("div",L,[e("label",j,s(t.order_item_trans[0].stock.stockname),1),e("label",A," \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D "+s(t.order_item_trans[0].pur_order),1),e("label",N," \u0E1B\u0E23\u0E30\u0E40\u0E20\u0E17 "+s(t.order_item_trans[0].order_type_name),1),e("label",S," \u0E1C\u0E39\u0E49\u0E19\u0E33\u0E40\u0E02\u0E49\u0E32\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E19\u0E35\u0E49 "+s(t.order_item_trans[0].user.name),1),e("label",D," \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E19\u0E33\u0E40\u0E02\u0E49\u0E32\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E19\u0E35\u0E49 "+s(d(c)(t.order_item_trans[0].created_at).locale("th").format("D MMM BBBB HH:ss"))+" \u0E19.",1)]),P]),V,e("div",C,[(a(!0),b(y,null,x(t.order_item_trans,(o,n)=>(a(),b("div",{key:o.id,class:"w-full p-2 border-b-2 border-gray-500 shadow-sm"},[e("div",E,[e("div",F,s(n+1)+".",1),e("div",H,[e("label",I,s(n+1)+".SAP:\u0E0A\u0E37\u0E48\u0E2D\u0E27\u0E31\u0E2A\u0E14\u0E38:",1),e("label",O,s(o.stock_item.item_code)+": "+s(o.stock_item.item_name),1)]),e("div",T,[q,e("label",z,s(o.item_count)+" "+s(o.stock_item.unit_count),1)]),e("div",G,[J,e("label",K,s(g(o.price)),1)]),e("div",Q,[R,e("label",U,s(o.invoice_number),1)]),e("div",W,[X,e("label",Y,s(o.business_name),1)]),e("div",Z,[$,e("label",ee,s(d(c)(o.date_action).locale("th").format("D MMM BBBB")),1)])])]))),128)),e("div",se,[e("label",te,"\u0E23\u0E27\u0E21\u0E40\u0E1B\u0E47\u0E19\u0E40\u0E07\u0E34\u0E19 "+s(t.order_budget_used)+" \u0E1A\u0E32\u0E17",1)]),_(d(h),{href:l.route("get-list-order",{stock_id:t.stock_id,year:r}),class:"w-full flex justify-center my-2 py-2 text-md bg-blue-500 hover:bg-blue-700 text-white border border-blue-500 rounded-md"},{default:i(()=>[oe]),_:1},8,["href"])])]),_:1}))}};export{re as default};