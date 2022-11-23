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
                            v-on:click="deleteAnnouce"
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
                <div class="flex">
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
   
})

//const budget_add = ref(0);
//const budget_balance = ref(0);
const view_order=ref(false);
const confirm_add_budget=ref(false);
const budget_confirm_show = ref(0);
const show_alert_msg=ref(false);

const confirm_edit_budget=ref(false);


const form = useForm({
    annouce_id:props.annouce.id,
    annouce_status:{type:String}


})


const openAnnouce=()=>{
//     console.log('openAnnouce');
//    console.log(form.annouce_id);
   form.annouce_status = 'on';
   form.post(route('open-annouce'), {
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

const closeAnnouce=()=>{
    // console.log('closeAnnouce');
    // console.log(form.annouce_id);
    form.annouce_status = 'off';
    form.post(route('close-annouce'), {
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
const deleteAnnouce=()=>{
    // console.log('closeAnnouce');
    // console.log(form.annouce_id);
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
