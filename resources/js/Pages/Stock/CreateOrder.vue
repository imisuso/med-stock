<template>
    <AppLayout>

          <!--Header Alert-->
            <div v-if="$page.props.flash.status=='success'" 
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
            </div>

    
        <div class=" w-full  bg-blue-100 p-2 rounded-md ">
            <div class="bg-blue-800 text-white text-xl text-center ">
                {{unit.unitname}}
            </div>
            <div class="mt-3" >
                <label for="">เลือกคลังพัสดุ</label> 
            </div>
            <select name="" id="" 
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                 v-model="form.unit_id"
            >
                <option v-for="(stock) in  stocks" :key=stock.id :value="stock.id" >{{stock.stockname}}</option>
            </select>
           
       
        </div>
      
    <h1 class=" m-3 text-center text-lg font-bold" >สร้างเอกสารใบสัญญาสั่งซื้อพัสดุ </h1>

    <h1 class=" m-3 text-center text-lg font-bold" >ข้อมูลจำนวนคงเหลือ ณ วันที่ปัจจุบัน {{sysdate_thai}}</h1>

    <!-- item order -->
  
    <div class=" flex text-right px-6 justify-end  ">
     
        <div class="flex ">
            <!-- <p class=" text-sm py-2 text-green-800 font-bold"> กดที่ตะกร้าเพื่อสั่งซื้อ</p> -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div >
        <div  class="">
            <button v-if="form.preview_orders.length>0"
                 class="transition duration-500 ease-in-out bg-red-600 hover:bg-red-400 transform hover:-translate-y-1 hover:scale-110 inline-flex px-2   text-lg font-semibold leading-5 text-white  rounded-full"
                 v-on:click="showPreorder"
                 >
                {{form.preview_orders.length}}
            </button>
              
        </div>    
    </div>


      <!--Toast-->
    <div v-if="show_preorder" 
        class="alert-banner fixed z-20  top-60 ml-10 shadow-lg w-3/4 lg:ml-96 lg:w-2/5  ">
        
        <label for="previeworder" class=" flex items-start justify-between w-full p-1 bg-yellow-200  shadow-lg text-yellow-900 font-bold" 
            title="close" >
            รายการพัสดุที่ต้องการสั่งซื้อ
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </label>

        <input type="checkbox" class="hidden" id="previeworder" v-on:click="closePreviewOrder">

        <label v-for="(preview_order,index) in form.preview_orders" :key=preview_order.id
            class="close cursor-pointer flex items-start justify-between  w-full pt-4 px-2 bg-yellow-100 shadow-lg text-sm text-yellow-900" 
            title="close" for="previeworder">
            <!-- {{preview_order[0]}} -->
            {{index+1}}.{{preview_order[0].item_name}} จำนวน {{preview_order[0].order_input}} x {{preview_order[0].price}}  
            เป็นเงิน {{preview_order[0].total}} บาท 
            <!-- <p class=" ml-4 px-2 text-red-800 font-bold bg-red-300 rounded-md">ลบ</p>  -->
             <Link  class=" ml-4 px-2 text-red-800 font-bold bg-red-300 rounded-md">ลบ</Link>
           
        </label>
        <label for="" class=" flex items-start justify-between w-full p-1 bg-yellow-100  shadow-lg text-yellow-800 font-bold">
             รวม  {{sum_pay}} บาท </label>
         <button
            class="  w-full flex justify-center py-2  text-sm  text-yellow-900 font-bold bg-yellow-300 hover:bg-yellow-200 focus:outline-none"
            v-on:click="createOrder()"
            >
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    สร้างใบสั่งซื้อ
        </button>
     
    </div>
    <!-- test -->
    <!-- display card -->

      <!-- <div>
        preview_orders--
         count array-{{form.preview_orders.length}}
         DETAIL-{{form.preview_orders}} 
     </div> -->
    <OrderItem v-for="(item,index) in stock_items" 
        :key="item.id"
        :itemIndex="index" 
        :itemStock="item" 
        :businesses="businesses"
        @previewOrder="getOrder"
     >
     </OrderItem>
  

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import OrderItem from '@/Components/OrderItem.vue'
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import { computed, onMounted, ref } from '@vue/runtime-core';

defineProps({
    stocks:Array,
    stock_items:Array,
    unit:Object,
    businesses:Array,
    sysdate_thai:String,
    sysdate:String,
})



const show_preorder=ref(false);
const total_bath=ref(0);
const sum_pay = ref(0);

const form = useForm({
    preview_orders:[],
    unit_id:0,
})

 onMounted(() => {
  //  console.log('onMounted');
    //console.log('stock_item======'+usePage().props.value.stock_items);
    form.items = usePage().props.value.stock_items;
    form.unit_id = usePage().props.value.unit.unitid;
     
})

const getOrder=(value)=>{
    // console.log('Parent getOrder  item----->')
    form.preview_orders.push(value);
    // console.log('after preview_orders----->')
    // console.log(form.preview_orders.length)   
    
}


const  showPreorder=()=>{
            show_preorder.value=true;
    sum_pay.value = 0;
    let tmp_total = 0.0;
    let tmp_sum_pay = 0.0;
    
    form.preview_orders.forEach(item => {       
               // console.log('total=='+item[0].total);    
                tmp_total = parseFloat(item[0].total);
               // console.log('tmp_total==>'+tmp_total);
                tmp_sum_pay = tmp_sum_pay + tmp_total;
               // console.log('tmp_sum_pay===>'+tmp_sum_pay);
                //console.log('sum_pay==>'+sum_pay.value);
            })
   
   sum_pay.value = tmp_sum_pay.toFixed(2);
    //sum_pay.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
   // console.log('show_sum_pay==>'+show_sum_pay);
}
const closePreviewOrder=()=>{
            show_preorder.value=false;
}



const createOrder=(()=>{
            //    console.log('create order');
            // console.log(form.preview_orders);
            //  console.log(form.preview_orders[0]);
   form.post(route('add-order'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
               
})

</script>

