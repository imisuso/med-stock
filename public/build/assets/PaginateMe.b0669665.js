import{r as b,A as c,B as m,o as w,c as h,a as e,u as n,n as u,w as x,v as f,C as v,t as p,i as y,y as _,J as k}from"./app.9b9bfbb4.js";const C={class:"inline-flex text_sm justify-center md:justify-end items-center mb-2"},j={key:0,class:"flex space-x-1 items-top"},B=["disabled"],M=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M11 19l-7-7 7-7m8 14l-7-7 7-7"})],-1),$=[M],P=["disabled"],V=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M15 19l-7-7 7-7"})],-1),N=[V],S={class:"flex flex-col items-center space-y-2 md:flex-row md:space-y-0 md:items-center md:space-x-1"},D=e("div",{class:"px-2 text-gray-600 lg:text-sm"},"\u0E2B\u0E19\u0E49\u0E32 ",-1),J=["max"],K={class:"px-2 text-gray-600 lg:text-sm"},q=["disabled"],z=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M9 5l7 7-7 7"})],-1),A=[z],E=["disabled"],O=e("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-4 h-4 lg:h-3 lg:w-3",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M13 5l7 7-7 7M5 5l7 7-7 7"})],-1),T=[O],U={class:"ml-2 text-sm text-gray-800 border-b-2 border-gray-400 place-self-center hidden md:block"},G={name:"PaginateMe",props:{pagination:{type:Object,required:!0,default:{}}},setup(o){const i=o,l=b(i.pagination.current_page),r=g=>{_.get(k().url,{page:g},{preserveState:!0,preserveScroll:!0})},a=c(()=>i.pagination.current_page-1<=0),d=c(()=>i.pagination.current_page+1>i.pagination.last_page);return m(()=>i.pagination.current_page,(g,t)=>{l.value=g}),(g,t)=>(w(),h("div",C,[o.pagination.last_page>1?(w(),h("div",j,[e("button",{disabled:n(a),class:u([{"opacity-50":n(a)},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-200 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 lg:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[0]||(t[0]=s=>r(1))},$,10,B),e("button",{disabled:n(a),class:u([{"opacity-50":n(a)},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-200 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[1]||(t[1]=s=>r(o.pagination.current_page-1))},N,10,P),e("div",S,[D,x(e("input",{type:"number",onKeydown:t[2]||(t[2]=v(s=>r(l.value),["enter"])),onChange:t[3]||(t[3]=s=>r(l.value)),"onUpdate:modelValue":t[4]||(t[4]=s=>l.value=s),min:"1",max:o.pagination.last_page,class:"px-2 w-11 h-11 text-center rounded border border-gray-400 shadow-sm lg:h-9 lg:w-12 lg:text-sm focus:ring-blue-500 focus:border-blue-500"},null,40,J),[[f,l.value]]),e("div",K,"\u0E08\u0E32\u0E01 "+p(o.pagination.last_page),1)]),e("button",{disabled:n(d),class:u([{"opacity-50":n(d)},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-300 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[5]||(t[5]=s=>r(o.pagination.current_page+1))},A,10,q),e("button",{disabled:n(d),class:u([{"opacity-50":n(d)},"inline-flex justify-center items-center w-11 h-11 text-gray-700 bg-white rounded border border-gray-300 shadow-sm outline-none hover:bg-gray-50 lg:h-9 lg:w-9 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"]),onClick:t[6]||(t[6]=s=>r(o.pagination.last_page))},T,10,E)])):y("",!0),e("div",U,"\u0E23\u0E27\u0E21\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 "+p(o.pagination.total)+" \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23",1)]))}};export{G as _};