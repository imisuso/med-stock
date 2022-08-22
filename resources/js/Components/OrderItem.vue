<template>
    <div class="w-full  p-2  ">
        <div 
                class="w-full  bg-indigo-100 border-2 border-indigo-300 mt-3  rounded-lg lg:max-w-full lg:flex lg:flex-col">
                 <div class="flex ml-2"> {{itemIndex+1}}. 
                    <p class=" ml-2 ">  {{form.item.item_code}}:{{form.item.item_name}}</p> 
                    <p class=" ml-2 text-red-600" >
                             <span  
                                class="inline-flex px-2  text-lg font-semibold leading-5  rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            {{form.item.item_sum}}
                            </span>
                    </p> 
                </div>
            
                <div  class="flex ml-6">
                    <div class="flex justify-end  w-1/4 py-2 px-2 "> 
                        <div v-if="order_alert" class=" text-red-600" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                        </div>
                        <div> จำนวนสั่งซื้อ:</div> 
                    </div>
                    <!-- <div class=" w-1/4 py-2 px-2 text-right"> จำนวนสั่งซื้อ:</div> -->
                    <div class=" w-3/4 ">
                    <input type="number"   placeholder="จำนวนสั่งซื้อ"   
                        class="block w-full mt-1  rounded-md "
                        :class="[order_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                        v-model="form.order_input"
                        >
                    </div>
                    
                </div>
             
                <div class="flex ml-6">
                    <div class=" w-1/4 py-2 px-2 text-right"> Cat.No:</div>
                    <div class=" w-3/4 ">
                      <input type="text"  v-model="form.item.checkin_last.profile['catalog_number']" 
                            class="block w-full mt-1   border-gray-400 rounded-md "
                            >
                    </div>
                </div>
                <div class="flex ml-6">
                    <div class=" w-1/4 py-2 px-2 text-right"> Lot.No:</div>
                    <div class=" w-3/4 ">
                      <input type="text"  v-model="form.item.checkin_last.profile['lot_number']" 
                            class="block w-full mt-1   border-gray-400 rounded-md "
                            >
                    </div>
                </div>
                <div class="flex ml-6">
                    <div class=" w-1/4 py-2 px-2 text-right"> ราคาต่อหน่วย:</div>
                        <div class=" w-3/4 ">
                        <input type="number"  v-model="form.item.price" 
                                class="block w-full mt-1  border-gray-400 rounded-md ">
                        </div>
                </div>
                <div class="flex ml-6 mt-2">
                   
                    <div class="flex justify-end  w-1/4 py-2 px-2 "> 
                        <div v-if="business_alert" class=" text-red-600" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                        </div>
                        <div> บริษัทผู้ขาย:</div> 
                    </div>
                    <div class=" w-3/4 ">
                        <select id="business_input"
                            class="block appearance-none w-full  bg-white border hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight "
                            :class="[business_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                            v-model="form.business_input" 
                            >
                            <option v-for="(business) in  businesses" :key="business.id" 
                                :value="business.id+'-'+business.business_name" 
                                >
                                {{business.business_name}}
                            </option>
                        </select>
                    </div>
                </div>
                <!-- <div v-if="order_alert || business_alert" class="  bg-red-200 py-2 px-2 h-auto ">
                        <label for="" class=" px-10 text-sm text-red-700" >{{msg_alert}}</label>
                </div> -->
                <div class=" m-2">
                    
                        <button
                            class="w-full flex justify-center text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
                            @click="addOrder"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8  " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        ใส่ตะกร้า
                        </button>
                </div>   
        </div>
    </div>

  
</template>
<script setup>
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import {  useForm, usePage } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';

const emits = defineEmits(['previewOrder'])
const props = defineProps({
    businesses:{type:Object ,required:true},
    itemIndex:{type:Number , required:true},
    itemStock: { type: Object ,required:true },

})

const form = useForm({
    item:[],
    business_input:[],
    order_input:0,
    preview_orders: Array,
   })

form.item = props.itemStock
const total_bath=ref(0);
const business_alert=ref(false);
const order_alert=ref(false);
const msg_alert=ref('');
// console.log('item==>')
// console.log(form.item)

const closeAlert=()=>{ open_alert.value=false};

const addOrder=()=>{
    // console.log('child add order item==>')
    // console.log(form.item)
    // console.log('add order order_input==>')
    // console.log(form.order_input)
    // console.log('add order business_input==>')
    // console.log(form.business_input);
    // console.log(form.business_input.length);
     if(form.order_input==0){
        order_alert.value=true
         msg_alert.value="กรุณาระบุจำนวนสั่งซื้อ";
      //  document.getElementById("order_in").focus();
        return false;
    }else{
          order_alert.value=false;
    }
    
    if(form.business_input.length==0){
        business_alert.value=true
        // console.log('business_alert=====>'+business_alert.value)
        msg_alert.value="กรุณาระบุบริษัทผู้ขาย";
       // document.getElementById("business_input").focus();
       return false;
    }else{
         business_alert.value=false;
    }
   

   
    const business_input_array = form.business_input.split("-");
    // console.log(business_input_array[0])
    // console.log(business_input_array[1])
    form.preview_orders=[]
    total_bath.value = form.order_input * form.item.price;
    let show_total_bath =  total_bath.value.toFixed(2);
   // console.log('sum_pay=='+show_sum_pay);
   // return show_total_bath.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    form.preview_orders.push({
                                stock_id:form.item.stock_id,
                                id:form.item.id,
                                sap:form.item.item_code,
                                item_name:form.item.item_name,
                                order_input:form.order_input,
                                price:form.item.price,
                                business_id:business_input_array[0],
                                business_name:business_input_array[1],
                                total:show_total_bath,
                                catalog_number:form.item.checkin_last.profile.catalog_number,
                                lot_number:form.item.checkin_last.profile.lot_number,
                            });
    //console.log(form.preview_orders)
    emits('previewOrder',  form.preview_orders);

}
</script>
