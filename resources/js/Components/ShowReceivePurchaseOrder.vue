<template>
<!-- <div> {{purchaseOrder}}</div> -->
   
    <div class=" bg-blue-200 text-blue-800">
        <!-- <input type="checkbox" >  -->
        #{{itemIndex+1}} รหัส:{{purchaseOrder.material}} ชื่อ:{{purchaseOrder.item_name}} 
    </div>
    <div class=" px-2 text-sm">(ชื่อบริษัท/ร้านค้า:{{purchaseOrder.business_name}} )</div>
    <div class=" w-full md:flex  md:justify-between">
        <div><label for="" class=" px-4"> จำนวน {{purchaseOrder.order_input}} {{purchaseOrder.unit_count}} </label></div>
        <div><label for="" class=" px-4"> ราคา/หน่วย {{price_format}} บาท</label></div>
        <div><label for="" class=" px-4"> รวม {{total_format}} บาท</label></div>
    </div>
    <div class=" w-full md:flex  md:justify-between">
        <div class=" m-2">
            <div  class="flex justify-start " >
          
                    <label class=" text-red-600">จำนวนที่ตรวจรับ มีไม่ตรงกับใบสั่งซื้อหรือไม่?:</label>
            </div>
            <div>
                <input type="number" name="" id=""
                    class="w-full px-2 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    v-model="form.receive_unit"
                >
            </div>
        
        </div>
        <div class=" m-2">
            <div  class="flex justify-start " >
          
                    <label class=" text-red-600">วันที่ตรวจรับ มีโอกาสตรวจรับแต่ละรายการคนละวันไหม?:</label>
            </div>
            <div>
                <input type="date" name="" id=""
                    v-model="form.date_checkout"
                    class="w-full px-2 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    
                >
            </div>
        
        </div>
        <div class=" m-2">
            <div  class="flex justify-start " >
          
                    <label for="">วันที่หมดอายุ:</label>
            </div>
            <div>
                <input type="date" name="" id=""
                    v-model="form.date_checkout"
                    class="w-full px-2 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    
                >
            </div>
        
        </div>
    </div>
    <div class="w-full flex justify-center">
            <button
                 class=" flex justify-center px-4 py-1   text-sm  text-white bg-green-600 rounded-md hover:bg-green-400 focus:outline-none"
            >
            ตรวจรับรายการที่ {{itemIndex+1}}
            </button>
    </div>

    
    <!-- <div>{{oldItemsSum[itemIndex]}}</div> -->
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
const props = defineProps({
    itemIndex:{type:Number,required:true},
    purchaseOrder:{type:Object,required:true},
    oldItemsSum:{type:Array,required:true},
})

const form = useForm({
     date_checkout:'',
     receive_unit:0
})

form.receive_unit = props.purchaseOrder['order_input'];

const price_format = computed(()=>{
    //console.log(props.stockBudget.budget)
    let  price_show = props.purchaseOrder['price'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    return price_show;
})

const total_format = computed(()=>{
    //console.log(props.stockBudget.budget)
    let  total_show = props.purchaseOrder['total'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    return total_show;
})
</script>