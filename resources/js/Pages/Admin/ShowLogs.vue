<template>
    <AppLayout>
        <!-- {{ user_change_logs.length }} -->
        <div v-if="logs.length !=0">
            <div class=" text-blue-700 underline underline-offset-1">
            ประวัติการเปลี่ยนแปลงข้อมูลของ {{title_name}} 
            </div>
            <div class="w-full hidden lg:flex border-b-2 my-2 bg-blue-100  border-gray-500 shadow-sm ">
                <div class=" w-2/12">
                    <p>วันที่บันทึก/แก้ไข</p>
                </div>
                <div class=" w-3/12"><p>ผู้กระทำ</p></div>
                <div class=" w-2/12">การกระทำ</div>
                <div class=" w-5/12">รายละเอียดข้อมูลที่แก้ไข</div>
            </div>
            <div v-for="(user_log,index_user) in  logs" :key=index_user :value="user_log.id"
                        class="w-full lg:flex border-b-2 my-2  border-gray-500 shadow-sm "
                    >
                    
                    <div class=" lg:w-2/12">
                    {{index_user+1}}.   {{ dayjs(user_log.timestamp).locale('th').format('D MMM BBBB HH:mm')}} น.
                    </div>
                    <div class="lg:w-3/12 text-sm ">{{user_log.user.name}}</div>
                    <div class="lg:w-2/12 text-sm ">{{user_log.action}}</div>
                    <div v-if=" user_log.action=='add_user' " class="lg:w-5/12 ">-</div>
                    <div v-else class="lg:w-5/12 ">
                        {{ user_log.log }}
                      
                    </div>
                
            </div> 
        </div> 
        <div v-else
           class="flex justify-center"
         >
                <label for="">ไม่พบข้อมูลการเปลี่ยนแปลง</label>
        </div>
       
        <div>
            <Link :href="route(back_url)" >
                        <div class="w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded">
                            <span class=" text-white ml-2">กลับ</span>
                        </div>
            </Link>

            <!-- <Link :href="route(route_back)" >
                        <div class="w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded">
                            <span class=" text-white ml-2">กลับ</span>
                        </div>
            </Link> -->
        </div>
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { useForm,Link } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props =defineProps({
    title_name : {type:String},
    logs:{type:Array,required:true},
    back_url:{type:String},
    
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


  
</script>