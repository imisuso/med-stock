<template>
    <AppLayout>
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
      
        <div v-if="$page.props.errors.error" 
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-700 shadow rounded-md text-white font-bold" title="close" for="banneralert">
                 {{ $page.props.errors.error }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

        <div class=" bg-pink-50">
            <div class=" w-full flex justify-center font-bold  ">บันทึกการตรวจรับพัสดุจากใบสัญญาสั่งซื้อ</div>
            <div class=" w-full flex justify-center font-bold">{{stockname}} </div>
            
            <div class="w-full flex justify-between p-2 my-2  border-b-2 border-gray-600 font-bold " >
                <div>เลขที่ใบสั่งซื้อ:{{order.order_no}}/{{order.year}}</div>
                <div v-if="order.status == 'checkin'"
                    class=" flex justify-center text-green-700 text-lg"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    ตรวจรับพัสดุเรียบร้อยแล้ว
                </div>
                <div>วันที่อนุมัติ:{{order.timeline['approve_datetime']}} น.</div>
            </div>
        </div>
          <!-- {{order}}       -->
        <div v-for="(item,key) in order.items" :key="key"
            class=" w-full flex flex-col p-2 my-2 space-y-2 bg-pink-100  border-2 border-gray-500 rounded "
            >
           
             <div class=" flex   ">
                <span class=" font-bold">  {{key+1}}. {{item[0].sap}}-{{item[0].item_name}}</span>
                <span class=" font-bold mx-2 "> จำนวนสั่งซื้อ: </span>
                <span class=" font-bold text-green-600 mx-4 "> {{item[0].order_input}}</span>
                <span class=" font-bold ">ชิ้น</span>
             </div>
            <div class=" flex flex-row   ">
                <span class=" font-bold "> จำนวนก่อนสั่งซื้อ: </span>
                <span class=" font-bold text-red-500 mx-4 "> {{order.timeline.item_sum_before_order[key]}} </span>
                <span class=" font-bold ">ชิ้น</span>
             </div>
             <div class=" flex flex-row   ">
                <span class=" font-bold "> จำนวนคงเหลือปัจจุบัน: </span>
                <span class=" font-bold text-green-600 mx-4 "> {{old_items_sum[key]}} </span>
                <span class=" font-bold ">ชิ้น</span>
             </div>
            <div v-if="order.status != 'checkin'" class=" flex flex-row   ">
                <span class=" font-bold "> จำนวนรวมหลังตรวจรับ: </span>
                <span class=" font-bold text-blue-600 mx-4 "> {{parseInt(item[0].order_input)+parseInt(old_items_sum[key])}} </span>
                <span class=" font-bold ">ชิ้น</span>
             </div>
             <div>
                  <span class="inline-block  font-bold"> บริษัทผู้ขาย:</span>  {{item[0].business_name}}
             
             </div>
              <div>
                  <span class="inline-block   font-bold"> Cat.No/Lot.No:</span> {{item[0].catalog_number}}/{{item[0].lot_number}}
             </div>

            <div v-if="order.status != 'checkin'"  class="flex flex-col lg:flex-row mb-2 text-md font-bold text-gray-900">
                <div class=" m-2">
                    <label for="">วันที่รับเข้า:</label>
                    <input type="date" name="" id=""
                        v-model="form.date_receive[item[0].id]"
                        class="w-full px-12 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500">
                </div>
                <div class=" m-2">
                    <label for="">วันที่หมดอายุ:</label>
                    <input type="date" name="" id="" 
                        v-model="form.date_expire[item[0].id]"
                    class="w-full px-12 py- border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500">
                </div>  
            </div>
          
        </div>
        <div v-if="order.status == 'approve' " 
            class=" w-full flex justify-center">
            <button 
                v-on:click="confirmCheckinOrder(order.id)"
                class="flex flex-row text-md py-1 px-6 ml-3 bg-green-500 hover:bg-green-700 text-white  text-center border border-green-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                ตรวจรับพัสดุ
            </button>
        </div>
       
        
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm,usePage  } from '@inertiajs/inertia-vue3';
import { onMounted } from '@vue/runtime-core';
const { ref }=require("@vue/reactivity");

defineProps({
      order :{type:Object , required:true},
      old_items_sum : {type:Object , required:true},
      stockname: { type: String, required: true }
});

// let date_receive=ref([]);
// let date_expire=ref([]);
 const form = useForm({
      date_receive:[],
      date_expire: [],
      order_id:null,
});

onMounted(() => {
 
      form.order_id = usePage().props.value.order.id;
     
});

const confirmCheckinOrder=()=>{
    console.log('CF order');
   // console.log(order);
    //form.order_id = order_id
    // console.log(form.date_receive);
    // console.log(form.date_expire);
    // console.log(form.order_id);
    form.post(route('checkin-order'), {
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
       
}

</script>



