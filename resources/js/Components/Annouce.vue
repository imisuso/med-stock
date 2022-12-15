<template>
    <div >
      <!--Header Alert-->
   
      <div 
          class=" mb-4  py-2 border-b-2 bg-blue-50 border-blue-700 rounded-md"
          >
            <div class="flex-col justify-between">
                <div class=" flex justify-between">
                        <label class=" underline underline-offset-2 text-green-900 text-lg"> 
                            ข่าวที่ {{annouceFrom+annouceIndex}} 
                        </label>   
                        <button 
                            class=" flex justify-center   text-red-700  rounded-md hover:bg-red-300 focus:outline-2"
                            v-on:click="confirmCancelAnnouce"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- ลบข่าว -->
                        </button>
                </div>
                <div class="">
                        <label class=" text-green-900 text-lg">   
                             {{annouce.message}}  
                        </label>   
                </div>
                <!-- <div class="flex">
                    <label class=" font-bold"> สถานะ:   {{annouce.status}}  </label>    
                        <button v-if="annouce.status=='on'"
                            class=" flex justify-center mx-2 px-2 bg-red-200 text-red-900 border-2  border-red-400 rounded-md shadow-md hover:bg-red-300 focus:outline-none"
                            v-on:click="closeAnnouce"
                            >
                            ปิดการแสดงผล
                        </button>
                        <button v-else
                            class=" flex justify-center mx-2 px-2 bg-green-200 text-green-900 border-2  border-green-400  rounded-md shadow-md hover:bg-green-300 focus:outline-none"
                            v-on:click="openAnnouce()"
                            >
                            เปิดการแสดงผล
                        </button>
                    
                </div> -->
                <!-- {{annouce_status_list}} -->
                <div class=" w-full   p-2 rounded-md ">
                    <div class="mt-3" >
                        <label for="">สถานะข่าว:</label> 
                    </div>
                 
                        <!-- <div>Status: {{ form.stock_status }}</div> -->
                        <div v-for="(status) in annouce_status_list" :key=status.id 
                            class="form-check">
                            <input type="radio" id="one"  :value="status.id" 
                                v-model="form.annouce_status" 
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                @change="confirmUpdateStatusAnnouce()"
                                />
                            <label for="one">{{status.desc}}</label>
                        </div>
                       
                      
                </div>

                <div>
                    <label class=" font-bold"> แสดงผลที่หน้าจอ:   {{annouce.show_on_page}}  </label>   
                </div>
                <div>
                    <label class=" font-bold"> ผู้บันทึก:   {{annouce.user['name']}}  </label>   
                </div>
                <div>
                    <label class=" font-bold"> วันที่บันทึก: {{ dayjs(annouce.updated_at).locale('th').format('D MMM BBBB HH:mm')}} น. </label>   
                </div>
            
            </div>
          <!-- {{stockBudget}} -->
 
      </div>

      <ModalUpToYou :isModalOpen="confirm_updatestatus" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">คุณต้องการแก้ไขสถานะข่าวนี้ใช่หรือไม่?</p> 
                                    
        </template>
        <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium ">
      
                <div>
                    {{alert_msg}} 
                </div>
                 <!-- <div for="">
                    จำนวน {{budget_confirm_show}} บาท
                </div> -->
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="okUpdateStatusAnnouce"
                    >
                    ตกลง
                </button>
                <button 
                    class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    v-on:click="cancelUpdateStatusAnnouce"
                >
                    ยกเลิก
                </button>
            </div>
        </template>
    </ModalUpToYou>

    <ModalUpToYou :isModalOpen="confirm_cancel_annouce" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">คุณต้องการแก้ไขสถานะข่าวนี้ใช่หรือไม่?</p> 
                                    
        </template>
        <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium ">
      
                <div>
                    {{alert_msg}} 
                </div>
                 <!-- <div for="">
                    จำนวน {{budget_confirm_show}} บาท
                </div> -->
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="deleteAnnouce"
                    >
                    ตกลง
                </button>
                <button 
                    class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    v-on:click="cancelCancelAnnouce"
                >
                    ยกเลิก
                </button>
            </div>
        </template>
    </ModalUpToYou>
  </div>

</template>
<script setup>
import BudgetOrder from '@/Components/BudgetOrder.vue';
import PurchaseOrder from '@/Components/PurchaseOrder.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import {ref,computed,onMounted, watch} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props = defineProps({
    annouceFrom:{type:Number,required:true},
    annouceIndex:{type:Number,required:true},
    annouce:{type:Object,required:true},
    annouce_status_list:{type:Object,required:true},
})





const confirm_updatestatus=ref(false);
const confirm_cancel_annouce=ref(false);
const alert_msg = ref('');

const form = useForm({
    annouce_id:props.annouce.id,
    annouce_status:props.annouce.status ? props.annouce.status :'',


})


// const openAnnouce=()=>{
// //     console.log('openAnnouce');
// //    console.log(form.annouce_id);
//    form.annouce_status = 'on';
//    form.post(route('open-annouce'), {
//         preserveState: true,
//         preserveScroll: true,
//         onSuccess: page => { 
//             console.log('success');
//             // show_alert_msg.value = true;
//             },
//         onError: errors => { 
//             console.log('error');
//             //  show_alert_msg.value = true;
//         },
//         onFinish: visit => { 
//             console.log('finish');
//         },
//     })
     
// }

const confirmCancelAnnouce=()=>{
  //  console.log(form.annouce_status);
    confirm_cancel_annouce.value = true
        alert_msg.value='ลบข่าว'
}

const  cancelCancelAnnouce=()=>{
    confirm_cancel_annouce.value = false;
}

const confirmUpdateStatusAnnouce=()=>{
    //console.log(form.annouce_status);
    confirm_updatestatus.value = true
    if(form.annouce_status=='off')
         alert_msg.value='ปิดการแสดงผล'
    else 
         alert_msg.value='เปิดการแสดงผล'
   
}

const  cancelUpdateStatusAnnouce=()=>{
    confirm_updatestatus.value = false;
}

const okUpdateStatusAnnouce=()=>{
     // console.log(form.annouce_id);
     // console.log(form.annouce_status);

      confirm_updatestatus.value = false

            form.post(route('update_status-annouce'), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: page => { 
                    console.log('success');
                    // show_alert_msg.value = true;
                    },
                onError: errors => { 
                    console.log('error');
                    //  show_alert_msg.value = true;
                },
                onFinish: visit => { 
                    console.log('finish');
                },
            })
           
}

// const closeAnnouce=()=>{
//     // console.log('closeAnnouce');
//     // console.log(form.annouce_id);
//     form.annouce_status = 'off';
//     form.post(route('close-annouce'), {
//         preserveState: true,
//         preserveScroll: true,
//         onSuccess: page => { 
//             console.log('success');
//             // show_alert_msg.value = true;
//             },
//         onError: errors => { 
//             console.log('error');
//             //  show_alert_msg.value = true;
//         },
//         onFinish: visit => { 
//             console.log('finish');
//         },
//     })
     
// }
const deleteAnnouce=()=>{
    // console.log('closeAnnouce');
    // console.log(form.annouce_id);
    confirm_cancel_annouce.value = false;
    form.annouce_status = 'canceled';
    form.post(route('delete-annouce'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
            // show_alert_msg.value = true;
            },
        onError: errors => { 
            console.log('error');
            //  show_alert_msg.value = true;
        },
        onFinish: visit => { 
            console.log('finish');
        },
    })
     
}




</script>
