<template>
    <AppLayout>
         <!--Header Alert-->
         <div v-if="$page.props.flash.status=='success'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status=='warning'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-yellow-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status=='error'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>

        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">แก้ไขข้อมูลคลังวัสดุ</p>
            </div>

            <!-- {{stock}}--
            {{stock.unit}} -->

            <!-- {{count(stocks_unit)}} -->

            <div >
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">

                    <div class="mt-3" >
                        <label for="">หน่วยงาน/สาขา:</label>
                    </div>
                    <label for=""> {{stock.unit['unitname']}}</label>
                </div>
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">

                    <div class="mt-3" >
                        <label for="">ระบุชื่อคลังวัสดุ(ภาษาไทย):</label>
                    </div>
                    <input type="text" class="w-full  py-2 rounded-md "
                        v-model="form.stock_name_thai"
                    >
                </div>
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                    <div class="mt-3" >
                        <label for="">ระบุชื่อคลังวัสดุ(ภาษาอังกฤษ):</label>
                    </div>
                    <input type="text" class="w-full  py-2 rounded-md "
                        v-model="form.stock_name_en"
                    >
                </div>
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                    <div class="mt-3" >
                        <label for="">ระบุสถานะคลังวัสดุ:</label>
                    </div>

                        <!-- <div>Status: {{ form.stock_status }}</div> -->
                        <div v-for="(status) in stock_status_list" :key=status.id
                            class="form-check">
                            <input type="radio"  :value="status.id" v-model="form.stock_status"
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                            />
                            <label for="one">{{status.desc}}</label>
                        </div>


                </div>


                <div class="  ">
                    <button type="submit"
                        v-if="$page.props.auth.user.roles[0].name=='admin_med_stock'"
                        class=" w-full flex justify-center py-2  text-md  bg-green-500 hover:bg-green-700 text-white  border border-green-500 rounded"
                        @click="confirmEditStock()"
                        >
                        แก้ไข
                    </button>

                    <Link :href="route('stock-add')" >
                        <div class="w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded">
                            <span class=" text-white ml-2">กลับ</span>
                        </div>
                    </Link>


                </div>

            </div>

        </div>

        <ModalUpToYou :isModalOpen="confirm_edit_stock" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการแก้ไขข้อมูลใช่หรือไม่?</p>

            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">

                    <label  class="  flex  justify-start w-full text-sm ">
                        ชื่อคลัง: {{form.stock_name_thai}} ({{form.stock_name_en}})
                    </label>
                    <label  class="  flex  justify-start w-full text-sm ">
                        สถานะ:   {{status_desc_selectd(form.stock_status)}}
                    </label>

                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmEditStock"
                        >
                        ตกลง
                    </button>
                    <button
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelEditStock"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>



    </AppLayout>
 </template>
 <script setup>

import AppLayout from '@/Layouts/AppLayout.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3'


const props =defineProps({
    stock:{type:Object},
    stock_status_list:{type:Array,required:true},


})

const confirm_edit_stock=ref(false);


const status_desc_selectd =(status)=>{
    return  props.stock_status_list[status-1].desc;
};



const  cancelEditStock=()=>{
    confirm_edit_stock.value = false;
}

const form = useForm({

    stock_id:props.stock.id,
    stock_name_thai:props.stock.stockname ? props.stock.stockname : '',
    stock_name_en:props.stock.stockengname ? props.stock.stockengname : '',
    stock_status:props.stock.status ? props.stock.status : 0,
    unit:props.stock.unit_id ? props.stock.unit_id : '',
})



const confirmEditStock=(()=>{
  confirm_edit_stock.value = true;
})

const okconfirmEditStock=()=>{
    confirm_edit_stock.value = false;

      form.post(route('update-stock',form.stock_id), {
        preserveState: false,
        preserveScroll: true,

    })
}



</script>
