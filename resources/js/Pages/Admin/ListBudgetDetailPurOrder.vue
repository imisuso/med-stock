<template>
    <AppLayout>
        <!-- {{order_item_trans}} -->
        <div class="">
            <div class="w-full flex flex-col items-center bg-blue-100">
                <label for="">  {{order_item_trans[0].stock.stockname}}</label>
                <label for="">  เลขที่ใบสั่งซื้อ {{order_item_trans[0].pur_order}}</label>
                <label for="">  ประเภท {{order_item_trans[0].order_type_name}}</label>
                <label for=""> ผู้นำเข้าข้อมูลใบสั่งซื้อนี้ {{order_item_trans[0].user.name}}</label>
                <label for=""> วันที่นำเข้าใบสั่งซื้อนี้ {{dayjs(order_item_trans[0].created_at).locale('th').format('D MMM BBBB HH:ss')}} น.</label>
            </div>

            <div class="w-full flex flex-col  bg-blue-200">
                <label for="">  รายการวัสดุที่สั่งซื้อมีดังนี้</label>
            </div>
        </div>

        <!-- table -->
        <div class="">
           
            <div 
                class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                    <div class="flex flex-col font-bold text-md  lg:flex-row lg:justify-between  mx-2"  >
                        
                        <div class=" lg:w-4/12  ">
                            SAP:ชื่อวัสดุ
                        </div>
                        <div class=" lg:w-1/12  ">
                            จำนวน
                        </div>
                    
                        <!-- <div class=" lg:w-1/12 ">
                            หน่วยนับ
                        </div> -->

                        <div class=" lg:w-1/12 ">
                            ราคา
                        </div>

                        <div class=" lg:w-2/12 ">
                            Invoice Number
                        </div>

                        <div class=" lg:w-3/12 ">
                            บริษัท
                        </div>
                        <div class=" lg:w-2/12 ">
                            วันที่ตรวจรับ
                        </div>
                    
                    </div>     
            </div>
        </div>
        
        <div  class="w-full mt-3  ">

            <div v-for="(order,key) in order_item_trans" :key=order.id
                class="w-full p-2 border-b-2   border-gray-500 shadow-sm ">
                
                <div class="flex flex-col text-sm  lg:flex-row   "  >
                    <div class=" hidden lg:block">{{key+1}}.</div>
                    <div class=" bg-blue-100 lg:bg-transparent lg:w-4/12  ">
                        <label for="" class="  lg:hidden">{{key+1}}.SAP:ชื่อวัสดุ:</label>
                        <!-- <p for="" class="  "> {{key+1}}.</p> -->
                        <label class=" font-bold ">
                        {{order.stock_item['item_code']}}: {{order.stock_item['item_name']}}
                            <!-- {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}} -->
                        </label>
                    </div>
                    <div class="  lg:w-1/12    ">
                        <label for="" class="  lg:hidden">จำนวน:</label>
                        <label class=" font-bold">
                            {{order.item_count}}   {{order.stock_item['unit_count']}}
                        </label>
                    </div>
                    <div class=" lg:w-1/12   ">
                        <label for="" class="   lg:hidden">ราคา:</label>
                        <label class=" font-bold">  
                            <!-- {{order.price}} -->
                        {{price_format(order.price)}}
                        </label>
                    </div>
                    <div class=" lg:w-2/12   ">
                        <label for="" class="   lg:hidden">Invoice Number:</label>
                        <label class=" font-bold"> {{order.invoice_number}}</label>
                    </div>
                    <div class=" lg:w-3/12   ">
                        <label for="" class="   lg:hidden">บริษัท:</label>
                        <label class=" font-bold"> {{order.business_name}}</label>
                    </div>
                    <div class=" flex lg:w-2/12   ">
                        <label for="" class="   lg:hidden">วันที่ตรวจรับ:</label>
                        <label class=" font-bold"> {{dayjs(order.date_action).locale('th').format('D MMM BBBB')}}</label>
                    </div>
                 
                </div>     
            </div>

            <div class="my-2 p-2 bg-blue-200">
                <label for="">รวมเป็นเงิน {{order_budget_used}} บาท</label> 
            </div>
            <!-- {{year_budget}} -{{year}} -->
           
            <!-- {{$page.props.stock_budget}} -->
            <!-- route('get-list-order'),{stock_id:'13',year:'2023'} -->
            <!-- route('get-list-budget') -->
            <Link :href="route('get-list-order',{stock_id:stock_id,year:year})"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded-md"
                      
                        >
                        กลับ
            </Link>
        </div>
    </AppLayout>
    
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props =defineProps({
    order_item_trans:{type:Array},
    order_budget_used:{type:String},
    year_budget:'',
    stock_id:'',
})
const year = props.year_budget-543;
const price_format=(price)=>{
   // console.log(price)
   let  price_show = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    return price_show;
}
</script>