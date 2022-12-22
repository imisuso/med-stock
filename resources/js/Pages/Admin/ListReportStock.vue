<template>
    <AppLayout>

        <div v-if="$page.props.flash.status=='error'" 
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-300 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

       <h4   
            class=" mt-3 text-center text-black">ระบุชื่อคลังวัสดุที่ต้องการดูรายงาน</h4>
        <div  
            class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
             <div class="m-2" >
                <label for="">เลือกชื่อคลังวัสดุ</label> 
                <label v-if="msg_validate_stock" class=" text-red-600">   !กรุณาเลือกคลังวัสดุ</label>
                <select name="" id="" v-model="form.stock_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(stock) in  stocks" :key=stock.id :value=stock.id >{{stock.stockname}}</option>
                </select>
            </div>
         
            
        </div>
        <div 
            class="flex flex-col  ">
          
                <button 
                    class=" w-full flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
                    @click="getStockReport()"
                >
                 
                    ค้นหา
                </button>
            <!-- </Link> -->
        </div>
        <!-- {{$page.props.//}} -->
      <!-- {{form.stock_selected}}
      {{stock_items_count}} -->
        <!-- show order lists -->
        <h1 v-if="stock_items_count==0" class="p-2 mt-3 text-center text-red-600 font-bold" >ไม่พบข้อมูลวัสดุในคลังที่ต้องการดูรายงาน </h1>
         <h1 v-if="stock_items_count!=0" class="p-2 mt-3 text-center font-bold" >รายงานจำนวนคงเหลือในคลังวัสดุ </h1>
          <h1 class="p-2 mt-1 text-center font-bold" >{{form.stock_selected.text}}</h1>
          <h1 v-if="stock_selected_name" class="p-2  text-center font-bold" >{{stock_selected_name.stockname}}</h1>


        <div v-if="stock_items_count!=0" class="w-full">
            <input type="text" placeholder="พิมพ์รหัสวัสดุ หรือชื่อวัสดุ หรือชื่อบริษัท ที่ต้องการค้นหา อย่างน้อย 3 ตัวอักษร"
                    v-model="search" 
                class="mt-2 border-green-600 border-2 block w-full shadow-sm sm:text-sm  rounded-md"
            >
        </div>
    <div v-if="stock_items_count!=0" class="w-full  p-2   ">
        
        <div>
            <div v-if="stock_items">
                <paginateMe :pagination="stock_items" />
            </div>
            
            <div 
                class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                <div class="flex flex-col text-xs  lg:flex-row lg:justify-between  mx-2"  >
                    
                    <div class=" lg:w-2/12  ">
                        SAP-ชื่อวัสดุ
                    </div>
                
                    <div class=" lg:w-1/12 ">
                        จำนวนคงเหลือ
                    </div>
                    <div class=" lg:w-1/12 ">
                        ราคา
                    </div>
                    <div class=" lg:w-3/12 ">
                        ชื่อบริษัท
                    </div>
                    <div class=" lg:w-2/12 ">
                        Pur.Order
                    </div>
                    <div class=" lg:w-1/12 ">
                        Invoice Number
                    </div>
                    <div class=" lg:w-1/12 ">
                        วันที่รับเข้า
                    </div>
                    <!-- <div class=" lg:w-1/12 ">
                        วันที่หมดอายุ
                    </div> -->
                   
                    <div class=" lg:w-1/12 text-xs ">
                        ประวัติรับเข้า-เบิกออก
                    </div>
                </div>     
            </div>
        </div>

        <!--re-design-->
        <!-- ##{{stocks}} -->
      

 

        <div  class="w-full mt-3  ">
           
            <div v-for="(stock_item,key) in stock_items.data" :key=stock_item.index
                class="w-full border-b-2   border-gray-500 shadow-sm ">
                
                <div class="flex flex-col  lg:flex-row   "  >
                    
                    <div class=" bg-blue-100 lg:bg-transparent lg:w-2/12 lg:text-xs  ">
                     
                        <label for="" class="  ">  {{stock_items.from + key}}. </label>
                        <label class=" font-bold">
                        
                            {{stock_item.item_code}}
                            <label for="" class="text-blue-600">-{{stock_item.item_name}}</label>
                         
                        </label>
                       
                       
                    </div>
                
                    <div class=" lg:w-1/12   ">
                        <label for="" class="   lg:hidden">จำนวนคงเหลือ:</label> 
                        <span 
                                class="inline-flex px-2  text-lg font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <!-- {{stock_itebalance}} -->
                            {{price_format(stock_item.item_balance)}}
                        </span>
                      
                    </div>
                    <div class="   lg:w-1/12  ">
                        <label for="" class="   lg:hidden">ราคา:</label>
                  
                        <label class=" ml-2 " >
                            <!-- {{stock_item.price}} -->
                            {{price_format(stock_item.price_last)}}
                        </label> 
                    </div>
                    <div class="   lg:w-3/12 lg:text-xs  ">
                        <label for="" class="   lg:hidden">ชื่อบริษัท:</label>
                  
                        <label class=" ml-2 " >
                            {{stock_item.business_name}}
                        </label> 
                    </div>
                    <div class="   lg:w-2/12 lg:text-xs  ">
                       
                        <label for="" class="   lg:hidden">Pur.Order:</label>
                  
                        <label for="" v-if="stock_item.status == 1" class=" text-xs text-green-700 ">สัญญาซื้อ</label>
                        <label for="" v-else  class=" text-xs text-yellow-600 ">ใบสั่งซื้อ</label>
                        
                        <label class=" ml-2 " >
                            {{stock_item.pur_order}}
                        </label> 
                    </div>
                    <div class="  lg:w-1/12 lg:text-xs ">
                        <label for="" class="  lg:hidden">Invoice Number:</label>
                        <label class=" ml-2 " >{{stock_item.invoice_number}}</label>
                     
                    </div>
                    <div class="   lg:w-1/12 lg:text-xs  ">
                        <label for="" class="   lg:hidden">วันที่รับเข้า:</label>
                  
                        <label class=" ml-2 " >
                            {{dayjs(stock_item.checkin_last).locale('th').format('D MMM BBBB')}}
                        </label> 
                    </div>
              
                  
                    <div class="  lg:w-1/12 ">
                        <label for="" class="  hidden"> ประวัติรับเข้า-เบิกออก</label>
                       
                        <Link :href="route('list-stock-item',stock_item)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                      
                        </Link>
                        <!-- <Link :href="route('list-stock-item',stock_item)">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-red-700">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>

                      
                        </Link> -->

                        <!-- <button 
                            v-on:click="cancel_stock_item(stock_item.id)"
                            class=" ml-3 bg-red-700 hover:bg-red-500 text-white font-bold py-1 px-2 border border-red-500 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button> -->
                    </div>
                </div>     
            </div>
        </div>

        <!--end re-design-->
  
   
    </div>

    <!-- end display card -->

        
    <!-- test display report table -->

   

      
        

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from '@vue/reactivity';
import {computed, watch} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

 const props=defineProps({
    stocks:{type:Object,required:false},
    stock_items:Object,
    stock_items_count:{type:Number},
    stock_selected:{type:Number},
    stock_selected_name:{type:Object,required:false},
    filters: { type: Object },
})

let search = ref(props.filters.search)
const msg_validate_stock=ref(false);

const form = useForm({
            stock_selected:props.stock_selected ? props.stock_selected :0,
            // year_selected:'',
            // month_selected:'',
            unitid:usePage().props.value.auth.user.unitid ? usePage().props.value.auth.user.unitid :0,
        //    unitid:props.auth.user.unitid ? props.auth.user.unitid :0 ,
})

const price_format=(price)=>{
   // console.log(price)
   let  price_show = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    return price_show;
  // return '1,200.5';
}

watch( search, value => {
   
   if(value.length >= 3){
     //  console.log('key search=' + value)
       Inertia.get(route('report-list',form.unitid), { search: value ,stock_selected: form.stock_selected}, {
           preserveState: true,
           replace: true
       })
   }
})
const getStockReport=()=>{
    //console.log('aaaaaaaaaa');
  
    //console.log(usePage().props.value.auth.user.unitid);
   
    msg_validate_stock.value = false

   if(form.stock_selected.length==0){
     msg_validate_stock.value = true
     return false;
   }
    form.get(route('report-list',form.unitid),{
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { 
            //console.log('success');
        },
        onError: errors => { 
           // console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })

    
}

const cancel_stock_item=(stock_item_id)=>{

console.log('cancel stock_item_id='+item_tran_id);
//form.item_tran_id = item_tran_id;
// form.post(route('cancel-checkout-stock-item'), {
//      preserveState: false,
//      preserveScroll: true,
//      onSuccess: page => { //console.log('success');
//      },
//      onError: errors => { 
//          console.log('error');
//      },
//      onFinish: visit => { //console.log('finish');
//      },
//  })
}




</script>
