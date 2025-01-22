<template>
    <AppLayout>


        <!-- {{stock_budgets}} -->
        <div class="p-2">
            <h1 class=" text-center font-bold text-lg">รายการข่าวประชาสัมพันธ์</h1>
            <p>เพิ่มข่าว</p>
            <textarea v-model="form.message"
                    class=" my-4 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 ">
            </textarea>
            <button
                    class=" w-full flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-green-700 rounded-md hover:bg-green-400 focus:outline-none"
                    @click="addAnnouce()"
                >
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg> -->
                    บันทึกข่าว
                </button>
        </div>
        <div class=" ">

            <p v-if="!annouces" class=" text-center font-bold text-lg"> ไม่พบข้อมูลข่าวประชาสัมพันธ์</p>
            <!-- {{annouces}}  -->
            <paginateMe :pagination="annouces" />
            <Annouce
                v-for="(annouce,key) in annouces.data" :key="annouce.id"
                :annouceFrom="annouces.from"
                :annouceIndex="key"
                :annouce="annouce"
                :annouce_status_list = "annouce_status_list"
                />
        </div>

    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Annouce from '@/Components/Annouce.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
  //years:{type:Object,required:true},
  annouces:{type:Object,required:true},
  annouce_status_list:{type:Object,required:true}
})

const form=useForm({
    message:'',
})


const addAnnouce=()=>{

     form.post(route('add-annouce-new'), {
            preserveState: false,
            preserveScroll: true,
    })
}


</script>
