<template>
    <AppLayout>
  

        <div class=" bg-pink-200">
            <div class=" w-full flex justify-center font-bold  ">บันทึกการตรวจรับพัสดุจากใบสั่งซื้อ</div>
            <div class=" w-full flex justify-center font-bold  ">{{$page.props.auth.user.profile.division_name}}</div>
            <div class="w-full flex justify-center p-2 my-2  border-b-2 border-gray-600 " >
                <div class=" w-full  ">
                    <div>ชื่อโครงการ:{{order.project_name}}</div>
                    <div>จำนวน {{order.items.length}} รายการ</div>
                </div>
                <div v-if="order.status == 'checkin'"
                    class=" flex justify-center text-green-700 text-lg"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    ตรวจรับพัสดุเรียบร้อยแล้ว
                </div>
               
            </div>
        </div>

        <div class=" bg-gray-200">
            {{order}}
        </div>

        <div class=" bg-green-200">
            {{old_items_sum}}
        </div>


       
        
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
      order :{type:Object , required:true},
      old_items_sum : {type:Array},
})
</script>