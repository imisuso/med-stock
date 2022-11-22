<template>
   <AppLayout>
    <!-- {{user}} -->
       <div class=" flex-col w-full justify-center  ">
            <div>
                <p class=" my-2 text-center font-bold text-lg text-blue-800 ">ข่าวประชาสัมพันธ์</p> 
            </div>
          
            <div v-for="(annouce,key) in annouces" :key="annouce.id" 
                class=" flex-col text-blue-900 text-lg bg-blue-50 p-4 border-b-2 m-4 border-blue-300  rounded-md  "
                    >
                    <p class=" underline underline-offset-2 ">  ข่าวที่ {{key+1}}.</p>
                    <p class=" ">   {{annouce.message}}</p>
                    <p class=" mt-6 text-sm text-green-700">  [วันที่ประกาศ: {{ dayjs(annouce.updated_at).locale('th').format('D MMM BBBB HH:mm')}} น.]</p>
            </div>
       </div>
    
   </AppLayout>
</template>

<script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

defineProps({
  //years:{type:Object,required:true},
  annouces:{type:Object,required:true},
})



</script>