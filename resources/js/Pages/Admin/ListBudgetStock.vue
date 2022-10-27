<template>
    <AppLayout>
        <!-- {{all_orders}}
    {{stock_budget}}
    {{year_budget}}
   {{budget_balance}} -->
    <div>
        <div class="w-full flex flex-col items-center bg-yellow-100">
            <label for="">  {{stock_budget.stock.stockname}}</label>
            <label for="">  ปีงบประมาณ {{year_budget}}</label>
            <label for=""> ได้รับการจัดสรรงบ {{stock_budget.budget_add}} บาท</label>
        </div>
        <div class="w-full flex flex-col  bg-yellow-200">
            <label for="">  รายการใบสั่งซื้อมีดังนี้</label>
        </div>
        <div 
            class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                <div class="flex flex-col  lg:flex-row lg:justify-between  mx-2"  >
                    
                    <div class=" lg:w-2/6  ">
                        เลขที่ใบสั่งซื้อ:
                    </div>
                
                    <div class=" lg:w-2/6 ">
                        งบประมาณที่ใช้:
                    </div>

                    <div class=" lg:w-2/6 ">
                        ::
                    </div>
                  
                </div>     
         </div>
    </div>
      
    <div  class="w-full mt-3  ">

        <div v-for="(order,key) in all_orders" :key=order.id
            class="w-full border-b-2   border-gray-500 shadow-sm ">
            
            <div class="flex flex-col  lg:flex-row   "  >
                
                <div class=" bg-blue-100 lg:bg-transparent lg:w-2/6  ">
                    <label for="" class="  lg:hidden">{{key+1}}.เลขที่ใบสั่งซื้อ:</label>
                    <label class=" font-bold">
                        {{order.pur_order}}
                        <!-- {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}} -->
                    </label>
                </div>
            
                <div class=" lg:w-2/6   ">
                    <label for="" class="   lg:hidden">งบประมาณที่ใช้:</label>
                    <label class=" font-bold">  {{order.sum_price}}</label>
                </div>
                
            </div>     
        </div>

        <div class="my-2 bg-yellow-200">
            <label for="">รวมใช้งบประมาณไปแล้ว {{budget_used}} บาท</label>
        </div>
        <div class="my-2 bg-green-800 text-white">
            <label for="">คงเหลืองบประมาณ {{budget_balance}} บาท</label>
        </div>
    </div>
    
    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    all_orders:{type:Object,required:true},
    stock_budget:{type:Object,required:true},
    year_budget:{type:Number,required:true},
    budget_used:{type:Number,required:true},
    budget_balance:{type:Number,required:true},
})

// const sumPrice = () => {
//     console.log('sumPrice')
//     let unit = {}
//     unit = props.units.find( item => item.unitid === form.unit_id) // เอาค่าแรกที่เจอค่าเดียว
//   //  console.log(unit)
//     return unit.unitname
// }

</script>