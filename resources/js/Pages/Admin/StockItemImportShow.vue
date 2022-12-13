<template>
    <AppLayout>
     
        <div v-if="!validate_input"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >
      
            <!-- {{msg_validate_row}} -->
            <li v-for="(msg_validate,index) in msg_validate_row" :key="index">
                {{msg_validate}} 
              
         
            </li>
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
        </div>
        <div v-if="!validate_excel"
            class=" w-full p-4   text-lg font-bold bg-red-200 rounded-md "
        >
      
            <label for="">{{msg_validate_excel}}</label>
            <li v-for="(header_false,index) in header_diff" :key="index">
                {{header_false}}
            </li>
            <p for="" v-if="validate_excel">ในไฟล์นี้พบว่ามี {{stock_item_import_count}} รายการ</p>
            <!-- {{header_diff}} -->
        </div>
       
        <div v-if="validate_excel && validate_row_excel && validate_input"
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
            <!-- <div>
                <label>วันที่ตรวจรับ:{{date_receive}}</label>
            </div> -->
            <div>
                <label for="">จำนวนวัสดุจากไฟล์มี : {{stock_item_import_count}} รายการ</label>
            </div>
        </div>  
 
        <div>
            <!-- <div class=" w-full flex   bg-blue-900 text-white ">
                    <div class="  ">
                       # รหัสวัสดุ
                    </div >
                    <div class=" pl-16 ">
                       <label for=""  class="  text-left">ชื่อวัสดุ </label> 
                    </div>
                    <div class=" pl-40">
                         จำนวนที่สั้งซื้อ 
                    </div>
                    <div class=" pl-5 ">
                         ราคา/หน่วย (บาท)
                    </div>
                    <div class=" pl-5 ">
                        catalog_number-lot_number
                    </div>
                                
                </div> -->

            <!-- <div class=" border p-1 " 
                v-for="(item_import,index) in stock_item_import"
                :key="index"
             >
                <div class=" w-full flex-row md:flex md:justify-between ">
                    <div class="  ">
                        {{index+1}}.  {{item_import.item_code}}:{{item_import.item_name}}
                    </div >
                    <div class=" ">
                         จำนวน {{item_import.item_receive}} {{item_import.unit_count}}  
                    </div>
                    <div>
                        ราคา/หน่วย {{item_import.price}} บาท
                    </div>
                    <div>
                        ({{item_import.catalog_number}}-{{item_import.lot_number}})
                    </div>
                    <div>
                        วันที่รับเข้า:{{item_import.date_receive}} วันที่หมดอายุ:{{item_import.date_expire}}
                    </div>
                                
                </div>
            </div> -->
            
        </div> 
        <div v-if="validate_excel && validate_row_excel && validate_input" class=" mt-2">
            <button
            class="  w-full flex justify-center py-2  text-md   font-bold bg-green-300 hover:bg-green-200 focus:outline-none"
            @click="CheckInToStockItem()"
            >
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    ยืนยันการเพิ่มวัสดุ
            </button>
        </div>
        <!-- <div class=" w-full  mt-2">
                <label class=" text-red-600">-ถ้าเป็นวัสดุใหม่ รหัสวัสดุต้องไม่ซ้ำกับวัสดุที่มีอยู่แล้ว ถ้ารหัสวัสดุซ้ำระบบจะนำจำนวนสั่งซื้อครั้งนี้ไปบวกเพิ่มให้อัตโนมัติ 
                    และปรับปรุงข้อมูลราคาให้อัตโนมัติ
                    แต่ถ้าเป็นรหัสวัสดุใหม่ระบบจะเพิ่มรายการวัสดุเป็นรายการใหม่
                </label>
        </div> -->
        <!-- <div class=" w-full  mt-2 text-red-600">
                <label for="">
                    - ถ้าใบสัญญาสั่งซื้อจะเป็นวัสดุเดิมที่เคยมีในคลังวัสดุอยู่แล้ว เท่านั้นใช่หรือไม่
                </label>
        </div> -->

        <ModalUpToYou :isModalOpen="show_alert_msg_import_success" >
            <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">กรุณาอ่าน: </p> 
                                    
            </template>
            <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium dark:text-white">
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
import { useForm } from '@inertiajs/inertia-vue3';
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
    msg_validate_row:{type:Array}
   // date_receive:{type:String},
    
})

const stock_item_types=[{'type_id':'1','type_name':'ใบสัญญาสั่งซื้อ'},
                      {'type_id':'2','type_name':'ใบสั่งซื้อ'}
                     ];

const show_alert_msg_import_success=ref(false);

const form = useForm({
    stock_id:props.stock_id ? props.stock_id : 0,
    stock_item_status:props.stock_item_status ? props.stock_item_status : 0,
    import_items: props.stock_item_import ? props.stock_item_import : '',
   // date_receive: props.date_receive ? props.date_receive : 0,
})





const CheckInToStockItem=(()=>{
   // console.log('----------CheckInToStockItem------')
   // console.log(form.stock_id);
   // console.log(form.stock_item_status);
   // console.log(form.import_items);
   // console.log(form.date_receive);
    form.post(route('import-checkin-to-stock'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('msg error');
        },
        onFinish: visit => { 
            console.log('msg finish');
          //  show_alert_msg_import_success.value = true;
           // import_stock_items.value = res.data.stock_item_import;   
        },
    })
})
  
</script>