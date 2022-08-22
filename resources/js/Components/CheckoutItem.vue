<template>
    <div  class="w-full bg-pink-100 mt-3 border-2 border-pink-300   rounded-lg lg:max-w-full lg:flex">
        <div
            class="flex flex-col bg-pink-200 items-center overflow-hidden text-center  bg-cover rounded-t lg:h-auto lg:w-36 lg:rounded-t-none lg:rounded-l"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
            
            <div
             class="w-full  leading-normal  border-b border-l border-r border-gray-200 rounded-b lg:border-l-0 lg:border-t lg:border-gray-200 lg:rounded-b-none lg:rounded-r"
             >
                <div class=" mb-2">
                
                    <div class="p-2 text-md font-bold text-gray-900">
                        {{itemIndex+1}}.
                        SAP:{{stockItem.item_code}}
                        <label for="" class="text-blue-600">{{stockItem.item_name}}</label>
                        (หน่วย: {{stockItem.unit_count.countname}})
                        <Link :href="route('list-stock-item',stockItem)">
                        <span
                            class="inline-flex text-md font-semibold leading-5 text-green-800 bg-green-200 rounded-lg"
                        >
                            ประวัติการรับเข้าและเบิกออก
                        </span>
                        </Link>
                    </div>
                
                
                    <div class="flex flex-col lg:flex-col mb-2 text-md font-bold text-gray-900">
                        <div class=" flex ml-2"> จำนวนที่มี : 
                            <p class=" ml-2 text-red-600" >
                             <span  
                                class="inline-flex px-2  text-lg font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            {{stockItem.item_sum}}
                            </span>
                            </p> 
                        </div>
                        <div class="flex ml-2"> วันหมดอายุ : 
                            <p class=" ml-2 text-blue-600">{{stockItem.checkin_last.date_expire}}</p> 
                        </div>
                        <div class="flex ml-2"> วันที่รับเข้า : 
                            <p class=" ml-2 text-blue-600">{{stockItem.checkin_last.date_action}}</p> 
                        </div>
                        <div class="flex ml-2"> Cat.No/Lot.No : 
                            <p class=" ml-2 text-blue-600">{{stockItem.checkin_last.profile['catalog_number']}} /{{stockItem.checkin_last.profile['lot_number']}}</p> 
                        </div>
                      
                    </div>
                
                
                    <div v-if="canAbility.checkout_item && stockItem.item_sum!=0" class="flex flex-col lg:flex-row mb-2 text-md font-bold text-gray-900">
                        <div class=" m-2">
                             <div  class="flex justify-start " >
                                <svg xmlns="http://www.w3.org/2000/svg" v-if="date_alert" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                 <label for="">วันที่เบิก:</label>
                            </div>
                            <div>
                                <input type="date" name="" id=""
                                    v-model="form.date_checkout"
                                    class="w-full px-12 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                  :class="[date_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                                >
                            </div>
                           
                        </div>
                        <div class=" m-2">
                             <div  class="flex justify-start " >
                                <svg xmlns="http://www.w3.org/2000/svg" v-if="unitcheckout_alert" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                 <label for="">จำนวน:</label>
                            </div>
                            <div>
                                <input type="number" name="" id="" 
                                    v-model="form.unit_checkout"
                                    class="w-full px-12 py- border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                    :class="[unitcheckout_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                                >
                            </div>
                          
                        </div>
                    
                        
                    </div>

                    <div v-if="canAbility.checkout_item && stockItem.item_sum!=0" class="flex flex-col lg:flex-row px-2 py-2  ">
                      
                        <button
                            class=" flex justify-center px-4 py-1   text-sm  text-white bg-green-600 rounded-md hover:bg-green-400 focus:outline-none"
                            v-on:click="confirmCheckout(stockItem)"
                        >
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg> -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            บันทึกการเบิก
                        </button>
                    </div>
                </div>        
            </div>
        
    </div>

         <ModalUpToYou :isModalOpen="confirm_checkout" >

            <template v-slot:header>
                <!-- <div class="text-gray-900 text-xl font-medium dark:text-white">
                    คุณต้องการลบข้อมูลบุคคลากร
                </div> -->
                <p class="text-md font-bold text-red-600 ">คุณต้องการบันทึกการเบิกพัสดุรายการนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                    <p class="mt-2">{{form.confirm_item_name}} เบิกใช้วันที่ {{ form.confirm_item_date}} จำนวน {{form.confirm_item_count}} ชิ้น</p>   
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okConfirmCheckout"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelConfirmCheckout"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>
</template>
<script setup>
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';
const props = defineProps({
    itemIndex:{type:Number,required:true},
    stockItem:{type:Object,required:true},
    canAbility:{type:Object,required:true},
})
const confirm_checkout=ref(false);
const date_alert=ref(false);
const unitcheckout_alert=ref(false);
const msg_alert=ref('');

const form = useForm({
    unit_checkout:0,
    date_checkout:'',
    // item_balance:0,
   // confirm_checkout:0,
    confirm_item_name:'',
    confirm_item_slug:'',
    confirm_item_date:'',
    confirm_item_count:'',
   // stock_item_sum:[], //เอาตัวแปร จาก props มาใช้
})
const confirmCheckout=(stock_item)=>{
    console.log('confirmCheckout');
   // console.log(form.date_checkout[index]);
    if(form.date_checkout.length==0){
        date_alert.value=true
        msg_alert.value="กรุณาระบุวันที่เบิก";
      //  console.log('กรุณาระบุวันที่เบิก');
      //  document.getElementById("order_in").focus();
        return false;
    }else{
        date_alert.value=false;
    }

    if(form.unit_checkout==0){
        unitcheckout_alert.value=true
        msg_alert.value="กรุณาระบุจำนวน";
       // console.log('กรุณาระบุจำนวน');
      //  document.getElementById("order_in").focus();
        return false;
    }else{
        unitcheckout_alert.value=false;
    }
    
    confirm_checkout.value = true;
    form.confirm_item_slug = stock_item.slug;
    form.confirm_item_name = stock_item.item_name;
    form.confirm_item_date = form.date_checkout;
    form.confirm_item_count = form.unit_checkout;
       
}
const cancelConfirmCheckout = ()=>{
    confirm_checkout.value = false;
}

const okConfirmCheckout=()=>{
    confirm_checkout.value = false;
    //console.log('OK Confirm');
    form.post(route('checkout-stock-item'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
  
}

</script>
