<template>
    <AppLayout>
        <!--Header Alert-->
        <div v-if="$page.props.flash.status=='success'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status=='error'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer text-white flex items-center justify-between w-full p-2 bg-red-800 shadow rounded-md font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <!-- {{all_orders}}
    {{stock_budget}}
    {{year_budget}}
   {{budget_balance}} -->
    <div class="">
        <div class="w-full flex flex-col items-center bg-yellow-100">
            <label for="">  {{stock_budget.stock.stockname}}</label>
            <label for="">  ปีงบประมาณ {{year_budget}}</label>
            <label for=""> ได้รับการจัดสรรงบ {{budget_receive}} บาท</label>
        </div>
        <div class="w-full mb-2 flex flex-col  bg-yellow-200">
            <label for="">  รายการใบสั่งซื้อมีดังนี้</label>
        </div>
        <div>
            <paginateMe :pagination="all_orders" />
        </div>
      
        <div 
            class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
           
                <div class="flex flex-col font-bold text-lg  lg:flex-row lg:justify-between  mx-2"  >
                    
                    <div class=" lg:w-3/12  ">
                        เลขที่ใบสั่งซื้อ
                    </div>
                    <div class=" lg:w-3/12  ">
                        ประเภท
                    </div>
                
                    <div class=" lg:w-3/12 ">
                        งบประมาณที่ใช้
                    </div>

                    <div class=" lg:w-2/12 ">
                        วันที่ตรวจรับ
                    </div>

                    <div class=" lg:w-1/12 ">
                        ::
                    </div>
                  
                </div>     
         </div>
    </div>
      
    <div  class="w-full mt-3  ">

        <div v-for="(order,key) in all_orders.data" :key=order.id
            class="w-full p-2 border-b-2   border-gray-500 shadow-sm ">
            
            <div class="flex flex-col text-sm  lg:flex-row   "  >
                <div class=" hidden lg:block">{{key+1}}.</div>
                <div class=" bg-blue-100 lg:bg-transparent lg:w-3/12  ">
                    <label for="" class="  lg:hidden">{{key+1}}.เลขที่ใบสั่งซื้อ:</label>
                    <!-- <p for="" class="  "> {{key+1}}.</p> -->
                    <label class=" font-bold">
                       {{order.pur_order}}
                        <!-- {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}} -->
                    </label>
                </div>
                <div class="  lg:w-3/12    ">
                    <label for="" class="  lg:hidden">ประเภท:</label>
                    <label class=" font-bold">
                        {{order.order_type_name}}
                    </label>
                </div>
                <div class=" lg:w-3/12   ">
                    <label for="" class="   lg:hidden">งบประมาณที่ใช้:</label>
                    <label class=" font-bold">  {{order.sum_price}}</label>
                </div>
                <div class=" lg:w-2/12   ">
                    <label for="" class="   lg:hidden">วันที่ตรวจรับ:</label>
                    <label class=" font-bold"> {{dayjs(order.date_action).locale('th').format('D MMM BBBB')}}</label>
                </div>
                <div class=" flex lg:w-1/12   ">
                    <label for="" class="   lg:hidden">::</label>
                    <!-- <label class=" font-bold">  ดูรายละเอียด</label> -->
                    <div>
                    <!-- <a :href="route('get-list-order',{stock_id:stockBudget.id,year:budgetYear})"> -->
                        <!-- <a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </a> -->

                        <button type="submit" 
                                class="  inline-flex text-sm ml-3 "
                                @click="getOrderDetail(order.pur_order,order.sum_price)"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                        </button>
                    </div>

                </div>
                
            </div>     
        </div>

        <div class="my-2 p-2 bg-yellow-200">
            <label for="">รวมใช้งบประมาณไปแล้ว {{budget_used}} บาท</label>
        </div>
        <div class="my-2 p-2 bg-green-200 ">
            <label for="">คงเหลืองบประมาณ {{budget_balance}} บาท</label>
        </div>
            <!-- :href="route('print-budget-order',{stock_id:stock_budget.stock.id,year:stock_budget.stock.year})" -->
        <a :href="route('print-budget-order-import',{stock_id:stock_budget.stock_id,year:stock_budget.year})"
            target="blank" class=" ">
            <span
                class="flex justify-center text-sm  py-2  leading-5 text-white bg-blue-500 rounded-md shadow-lg hover:bg-blue-700 "
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                พิมพ์
            </span>
        </a>
    </div>
    
    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)
const props=defineProps({
    all_orders:{type:Object,required:true},
    stock_budget:{type:Object,required:true},
    year_budget:{type:Number,required:true},
    budget_used:{type:Number,required:true},
    budget_balance:{type:Number,required:true},
    budget_receive:{type:Number,required:true},
})

const form = useForm({
    pur_order:'',
    order_budget_used: 0.0,
    // stock_item_status:props.stock_item_status ? props.stock_item_status : 0,

})

const getOrderDetail=(pur_order,sum_price)=>{
    console.log('getOrderDetail')
    console.log(pur_order)
    form.pur_order = pur_order;
    form.order_budget_used = sum_price;

    form.post(route('get-list-budget-detail'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { 
            console.log('finish');
           // import_stock_items.value = res.data.stock_item_import;   
        },
    })

}


</script>