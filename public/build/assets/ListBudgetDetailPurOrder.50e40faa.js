import{A as b}from"./AppLayout.124f4623.js";import{d as o,b as h}from"./buddhistEra.e3d797a8.js";import{o as a,j as f,e as m,a as s,t as e,b as i,c as _,f as g,F as u}from"./app.cccaf2cb.js";import"./_plugin-vue_export-helper.cdc0426e.js";const v={class:""},w={class:"w-full flex flex-col items-center bg-blue-100"},x={for:""},B={for:""},p={for:""},y={for:""},k={for:""},M=s("div",{class:"w-full flex flex-col bg-blue-200"},[s("label",{for:""}," \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1E\u0E31\u0E2A\u0E14\u0E38\u0E17\u0E35\u0E48\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E21\u0E35\u0E14\u0E31\u0E07\u0E19\u0E35\u0E49")],-1),A=s("div",{class:""},[s("div",{class:"w-full my-3 border-b-4 border-gray-500 shadow-sm hidden lg:block"},[s("div",{class:"flex flex-col font-bold text-md lg:flex-row lg:justify-between mx-2"},[s("div",{class:"lg:w-4/12"}," SAP:\u0E0A\u0E37\u0E48\u0E2D\u0E1E\u0E31\u0E2A\u0E14\u0E38 "),s("div",{class:"lg:w-1/12"}," \u0E08\u0E33\u0E19\u0E27\u0E19 "),s("div",{class:"lg:w-1/12"}," \u0E23\u0E32\u0E04\u0E32 "),s("div",{class:"lg:w-2/12"}," Invoice Number "),s("div",{class:"lg:w-3/12"}," \u0E1A\u0E23\u0E34\u0E29\u0E31\u0E17 "),s("div",{class:"lg:w-2/12"}," \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E15\u0E23\u0E27\u0E08\u0E23\u0E31\u0E1A ")])])],-1),S={class:"w-full mt-3"},D={class:"flex flex-col text-sm lg:flex-row"},j={class:"hidden lg:block"},L={class:"bg-blue-100 lg:bg-transparent lg:w-4/12"},N={for:"",class:"lg:hidden"},P={class:"font-bold"},E={class:"lg:w-1/12"},F=s("label",{for:"",class:"lg:hidden"},"\u0E08\u0E33\u0E19\u0E27\u0E19:",-1),H={class:"font-bold"},I={class:"lg:w-1/12"},C=s("label",{for:"",class:"lg:hidden"},"\u0E23\u0E32\u0E04\u0E32:",-1),O={class:"font-bold"},V={class:"lg:w-2/12"},q=s("label",{for:"",class:"lg:hidden"},"Invoice Number:",-1),z={class:"font-bold"},G={class:"lg:w-3/12"},J=s("label",{for:"",class:"lg:hidden"},"\u0E1A\u0E23\u0E34\u0E29\u0E31\u0E17:",-1),K={class:"font-bold"},Q={class:"flex lg:w-2/12"},R=s("label",{for:"",class:"lg:hidden"},"\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E15\u0E23\u0E27\u0E08\u0E23\u0E31\u0E1A:",-1),T={class:"font-bold"},U={class:"my-2 p-2 bg-blue-200"},W={for:""},ss={name:"ListBudgetDetailPurOrder",props:{order_item_trans:{type:Array},order_budget_used:{type:String}},setup(l){o.extend(h);const n=d=>d.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");return(d,r)=>(a(),f(b,null,{default:m(()=>[s("div",v,[s("div",w,[s("label",x,e(l.order_item_trans[0].stock.stockname),1),s("label",B," \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D "+e(l.order_item_trans[0].pur_order),1),s("label",p," \u0E1B\u0E23\u0E30\u0E40\u0E20\u0E17 "+e(l.order_item_trans[0].order_type_name),1),s("label",y," \u0E1C\u0E39\u0E49\u0E19\u0E33\u0E40\u0E02\u0E49\u0E32\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E19\u0E35\u0E49 "+e(l.order_item_trans[0].user.name),1),s("label",k," \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E19\u0E33\u0E40\u0E02\u0E49\u0E32\u0E43\u0E1A\u0E2A\u0E31\u0E48\u0E07\u0E0B\u0E37\u0E49\u0E2D\u0E19\u0E35\u0E49 "+e(i(o)(l.order_item_trans[0].created_at).locale("th").format("D MMM BBBB HH:ss"))+" \u0E19.",1)]),M]),A,s("div",S,[(a(!0),_(u,null,g(l.order_item_trans,(t,c)=>(a(),_("div",{key:t.id,class:"w-full p-2 border-b-2 border-gray-500 shadow-sm"},[s("div",D,[s("div",j,e(c+1)+".",1),s("div",L,[s("label",N,e(c+1)+".SAP:\u0E0A\u0E37\u0E48\u0E2D\u0E1E\u0E31\u0E2A\u0E14\u0E38:",1),s("label",P,e(t.stock_item.item_code)+": "+e(t.stock_item.item_name),1)]),s("div",E,[F,s("label",H,e(t.item_count)+" "+e(t.stock_item.unit_count),1)]),s("div",I,[C,s("label",O,e(n(t.price)),1)]),s("div",V,[q,s("label",z,e(t.invoice_number),1)]),s("div",G,[J,s("label",K,e(t.business_name),1)]),s("div",Q,[R,s("label",T,e(i(o)(t.date_action).locale("th").format("D MMM BBBB")),1)])])]))),128)),s("div",U,[s("label",W,"\u0E23\u0E27\u0E21\u0E40\u0E1B\u0E47\u0E19\u0E40\u0E07\u0E34\u0E19 "+e(l.order_budget_used)+" \u0E1A\u0E32\u0E17",1)])])]),_:1}))}};export{ss as default};
