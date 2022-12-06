<template>
    <AppLayout>
     <!-- {{user}} -->
        <div class=" flex-col p-2 w-full justify-center bg-red-50  ">
             <!-- <div>
                 <p class=" my-2 text-center font-bold text-md text-blue-800 ">ข้อตกลง</p> 
             </div> -->
             <label class=" font-bold text-md ">{{agreements.title}}</label>
             <p v-for="(detail,key) in agreements.contents['detail']" :key="detail.id" 
                 class=" flex-col py-2 text-blue-900 text-md  rounded-md  "
                     >
                    {{detail}}
                     <!-- <p class=" underline underline-offset-2 ">  ข่าวที่ {{key+1}}.</p>
                     <p class=" ">   {{agreement.title}}</p>
                     <p class=" mt-6 text-sm text-green-700">  [วันที่ประกาศ: {{ dayjs(agreements.date_effected).locale('th').format('D MMM BBBB HH:mm')}} น.]</p> -->
            </p>
        </div>
        <div class="w-full flex justify-center my-2 mx-10  text-red-600 ">
                <label for="">ท่านรับทราบและตกลงตามนโยบายการคุ้มครองข้อมูลส่วนบุคคลข้างต้น</label>
        </div>
        <div  class="flex flex-col lg:flex-row px-2 py-2  ">
                      
                      <button
                          class=" w-full flex justify-center px-4 py-1   text-sm  text-white bg-green-600 rounded-md hover:bg-green-400 focus:outline-none"
                          v-on:click="AcceptAgreement()"
                      >
                   
                          รับทราบ
                      </button>
        </div>
    </AppLayout>
 </template>
 
 <script setup>
 //import { ref } from 'vue'
 import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
 import dayjs from 'dayjs';
 import 'dayjs/locale/th'
 import buddhistEra from 'dayjs/plugin/buddhistEra'
 dayjs.extend(buddhistEra)
 
 const props=defineProps({
   //years:{type:Object,required:true},
   agreements:{type:Object,required:true},
 })

 const form = useForm({
    agreement_id:props.agreements.id,
 })
 
 const AcceptAgreement=()=>{
    //console.log(form.agreement_id);
    form.post(route('accept-agreement'), {
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