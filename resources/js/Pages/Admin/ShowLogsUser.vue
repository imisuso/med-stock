<template>
    <AppLayout>
   
        <div class=" text-blue-700 underline underline-offset-1">
           ประวัติการเปลี่ยนแปลงข้อมูลของ {{user_name}}
        </div>
        <div class="w-full hidden lg:flex border-b-2 my-2 bg-blue-100  border-gray-500 shadow-sm ">
            <div class=" w-2/12">
                   <p>วันที่บันทึก/แก้ไข</p>
            </div>
            <div class=" w-3/12"><p>ผู้กระทำ</p></div>
            <div class=" w-2/12">การกระทำ</div>
            <div class=" w-5/12">รายละเอียดข้อมูลที่แก้ไข</div>
        </div>
        <div v-for="(user_log,index_user) in  user_change_logs" :key=index_user :value="user_log.id"
                    class="w-full lg:flex border-b-2 my-2  border-gray-500 shadow-sm "
                >
                
                <div class=" lg:w-2/12">
                 {{index_user+1}}.   {{ dayjs(user_log.created_at).locale('th').format('D MMM BBBB HH:mm')}} น.
                </div>
                <div class="lg:w-3/12 text-sm ">{{user_log.user.name}}</div>
                <div class="lg:w-2/12 text-sm ">{{user_log.action}}</div>
                <div v-if=" user_log.action=='add_user' " class="lg:w-5/12 ">-</div>
                <div v-else class="lg:w-5/12 ">
                    <div v-for="(old,index) in user_log.old_value" :key="index" :value="old.id">
                       <p class=" font-bold ">{{index+1}}. column:[{{old.column}}] </p>   
                       <p v-if="old.column=='status'" class=" text-gray-500">
                            ข้อมูลเดิม:[{{status_desc(old.old)}}]    ข้อมูลใหม่:[{{status_desc(old.new)}}] 
                        </p>
                        <p v-else class=" text-gray-500">
                            ข้อมูลเดิม:[{{old.old}}]    ข้อมูลใหม่:[{{old.new}}] 
                        </p>
  
                    </div>
                    <!-- {{user_log.old_value}} -->
                </div>
               
        </div>  
       
        <div>
            <button type="submit" 
                                class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                                @click="getListUser()"
                                >
                                กลับ
            </button>
        </div>
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)


const props =defineProps({

    user_change_logs:{type:Array,required:true},
    user_name:{type:String},
    
})

const form = useForm({
  
    
})

const status_desc =(status)=>{
   // console.log(status)
   if(status==1)
     return  'ปกติ';
   else
    return 'ยกเลิก';
};
const getListUser=(()=>{
    // console.log('----------getListUser------')
    // console.log(form.unit);

    form.get(route('user-add'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
   
})


  
</script>