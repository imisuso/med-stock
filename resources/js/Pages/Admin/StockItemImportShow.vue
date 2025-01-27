<template>
    <AppLayout>

        <div v-if="!validate_input"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >

            <!-- {{msg_validate_row}} -->
            <li v-for="(msg_validate,index) in msg_validate_row" :key="index">
                {{msg_validate}}


            </li>

            <button type="submit"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="backImportExcel()"
                        >
                        กลับ
             </button>
        </div>

        <div v-if="!validate_row_excel"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >
            <!-- {{msg_validate_row}} -->
            <li v-for="(msg_validate,index) in msg_validate_row" :key="index">
                รายการวัสดุแถวที่:{{index}}
                <div v-for="(msg,index_msg) in msg_validate" :key="index_msg"
                 class="mx-5 text-sm "
                >
                    - {{msg[0]}}
                </div>

            </li>
            <button type="submit"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="backImportExcel()"
                        >
                        กลับ
             </button>
        </div>
        <div v-if="!validate_excel"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >

            <label for="">{{msg_validate_excel}}</label>
            <li v-for="(header_false,index) in header_diff" :key="index">
                {{header_false}}
            </li>
            <p  v-if="validate_excel">ในไฟล์นี้พบว่ามี {{stock_item_import_count}} รายการ</p>
            <button type="submit"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="backImportExcel()"
                        >
                        กลับ
             </button>
        </div>
        <div v-if="stock_item_import_count===0"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >

            <label for="">{{msg_validate_excel}}</label>
            <li v-for="(header_false,index) in header_diff" :key="index">
                {{header_false}}
            </li>
            <p for="" v-if="validate_excel">ในไฟล์นี้พบว่ามี {{stock_item_import_count}} รายการ</p>
            <button type="submit"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="backImportExcel()"
                        >
                        กลับ
             </button>
        </div>


        <div v-if="validate_excel && validate_row_excel && validate_input && stock_item_import_count>0"
            class=" w-full p-4   text-lg font-bold bg-blue-100 rounded-md "
            >
            <div class=" ">
                <p class="  ">นำเข้ารายการวัสดุจากไฟล์ Excel</p>
            </div>
            <div>
                <label for="">{{stock_name}}</label>
            </div>
            <div>
                <label for="" v-if="stock_item_status==1">ประเภทใบสัญญาสั่งซื้อ</label>
                <label for="" v-else>ประเภทใบสั่งซื้อ</label>
            </div>

            <div>
                <label for="">จำนวนวัสดุจากไฟล์มี : {{stock_item_import_count}} รายการ</label>
            </div>
        </div>

        <div>


        </div>
        <div v-if="validate_excel && validate_row_excel && validate_input && stock_item_import_count>0" class=" mt-2">
            <button
            class="  w-full flex justify-center py-2  text-md   font-bold bg-green-300 hover:bg-green-200 focus:outline-none"
            @click="CheckInToStockItem()"
            >
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    ยืนยันการเพิ่มวัสดุ
            </button>

            <button type="submit"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="backImportExcel()"
                        >
                        กลับ
             </button>
        </div>


        <ModalUpToYou :isModalOpen="show_alert_msg_import_success" >
            <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">กรุณาอ่าน: </p>

            </template>
            <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium ">
                    <div for="">
                    <!-- {{ $page.props.flash.status }}:{{ $page.props.flash.msg }}  -->
                    <label for="">บันทึกข้อมูลวัสดุลงคลังสำเร็จ</label>
                    </div>
            </div>
            </template>

            <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                    <button
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="closeAlertEdit"
                    >
                    ตกลง
                    </button>

            </div>
            </template>
        </ModalUpToYou>
    </AppLayout>
 </template>
 <script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'

const props =defineProps({
    stock_id:{type:Number},
    stock_name:{type:String},
    stock_item_status:{type:Number},
    stock_item_import: {type:Array, default:[]},
    stock_item_import_count:{type:Number},
    validate_excel:{type:Boolean,default:true},
    msg_validate_excel:{type:String},
    header_diff:{type:Array},
    validate_row_excel:{type:Boolean,default:true},
    validate_input:{type:Boolean,default:true},
    msg_validate_row:{type:Object}

})

const show_alert_msg_import_success=ref(false);

const form = useForm({
    stock_id:props.stock_id ? props.stock_id : 0,
    stock_item_status:props.stock_item_status ? props.stock_item_status : 0,
    import_items: props.stock_item_import ? props.stock_item_import : '',
   // date_receive: props.date_receive ? props.date_receive : 0,
})


const CheckInToStockItem=(()=>{

    form.post(route('import-checkin-to-stock'), {
        preserveState: true,
        preserveScroll: true,

    })
})
const backImportExcel=(()=>{

    form.get(route('stock-item-import'), {
        preserveState: true,
        preserveScroll: true,

    })

})

</script>
