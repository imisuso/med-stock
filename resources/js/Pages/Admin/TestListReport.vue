<template>
    <AppLayout>
        ---->   {{stock_items.data.length}}
      

        <div  class="w-full  p-2  ">
      
        <div>
            <paginateMe :pagination="stock_items" />
            <div 
                class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                <div class="flex flex-col  lg:flex-row lg:justify-between  mx-2"  >
                    
                    <div class=" lg:w-2/12  ">
                        SAP-ชื่อพัสดุ
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
                        ประวัติการรับเข้าและเบิกออก
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
                     
                        <label for="" class="  ">{{key+1}}.</label>
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
                            {{stock_item.item_sum}}
                        </span>
                      
                    </div>
                    <div class="   lg:w-1/12  ">
                        <label for="" class="   lg:hidden">ราคา:</label>
                  
                        <label class=" ml-2 " >
                            {{stock_item.price}}
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
                            {{dayjs(stock_item.checkin_last.date_action).locale('th').format('D MMM BBBB')}}
                        </label> 
                    </div>
              
                  
                    <div class="  lg:w-1/12 ">
                        <label for="" class="  hidden">::</label>
                       
                        <Link :href="route('list-stock-item',stock_item)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                      
                        </Link>
                    </div>
                </div>     
            </div>
        </div>

        <!--end re-design-->
  
   
    </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)
defineProps({
    stocks:{type:Object,required:true},

    stock_items:{type:Array},
    item_trans:{type:Object},
})
</script>