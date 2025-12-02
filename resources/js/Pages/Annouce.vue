<template>
   <AppLayout>
    <!-- {{user}} -->
       <div class=" flex-col w-full justify-center  ">
            <div class=" flex justify-between text-sm ">
                <button class=" inline-flex text-sm ml-3 bg-green-800 hover:bg-green-500 text-white  py-1 px-1 rounded-full"
                       v-on:click="openNews()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                    </svg>
                    What's New
                </button>

                <Link :href="route('agreement')" class="underline">อ่านข้อตกลงและนโยบายการคุ้มครองข้อมูลส่วนบุคคล</Link>
            </div>
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

       <ModalUpToYou :isModalOpen="open_news" modalSize="large">
        <template v-slot:header>
            <p class="text-md font-bold text-blue-800 ">What's new in MED-STOCK</p>

        </template>

        <template v-slot:body>
            <div class="text-gray-900 text-xs font-medium ">
                 <li >15 มิถุนายน 2566 เพิ่ม Feature แก้ไขราคา โดยผู้ที่นำเข้าวัสดุรายการใด จะสามารถแก้ไขราคาวัสดุรายการนั้นได้ โดยเข้าไปที่หน้าจอแสดงประวัติการรับเข้าและเบิกออก
                     <a href="../../../../docs/poster_edit_price_item.pdf" target="_blank" class=" underline ">
                        (คู่มือ)
                     </a>
                 </li>
                <li >4 มีนาคม 2567 เพิ่ม Feature ให้ admin สามารถแก้ไขชื่อผู้ใช้งานระบบได้เอง เพื่อรองรับกรณีผู้ใช้งานเปลี่ยนชื่อหรือนามสกุล</li>
                <li >6 มีนาคม 2567 เพิ่มแสดงคอลัมจำนวนคงเหลือที่หน้ารายงานบันทึกตัดสต๊อก ,พิมพ์ PDF และ Export Excel File</li>
                <li >1 พฤษภาคม 2567 ให้หน่วยงบประมาณพัสดุเป็นผู้เพิ่มวัสดุหลังจากตรวจรับ และสาขาวิชาไม่สามารถตัดสต๊อคย้อนหลังได้</li>
                <li >27 มกราคม 2568 ปรับปรุงเวอร์ชัน Laravel Framework จากเวอร์ชัน 10 เป็นเวอร์ชัน 11 และ Library ต่างๆ ที่เรียกใช้งาน</li>
                <li >สิงหาคม 2568 เพิ่มแสดงจำนวนวันของสินค้าคงคลัง</li>
                <li >ธันวาคม 2568 ปรับปรุงเวอร์ชัน Laravel Framework จากเวอร์ชัน 11 เป็นเวอร์ชัน 12 และ Library ต่างๆ ที่เรียกใช้งาน</li>
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="closeNews"
                    >
                    ปิด
                </button>

            </div>
        </template>
    </ModalUpToYou>

   </AppLayout>
</template>

<script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
import { ref } from 'vue';
dayjs.extend(buddhistEra)

defineProps({
  //years:{type:Object,required:true},
  annouces:{type:Object,required:true},
})

const open_news=ref(false);

const openNews=()=>{
  //  console.log(order);
  open_news.value = true;

}

const closeNews=()=>{
  //  console.log(order);
  open_news.value = false;

}

</script>
