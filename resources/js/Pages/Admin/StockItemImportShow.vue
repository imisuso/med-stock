<template>
    <AppLayout>
        <div class=" w-full p-4  text-center text-lg font-bold bg-blue-100 rounded-md ">
            <div class=" ">
                <p class=" my-2 ">Import Excel Stock Item</p> 
            </div>
            <div>
                <label for="">{{stocks}}</label> 
            </div>
            <div>
                <label for="" v-if="stock_item_status==1">จากใบสัญญาสั่งซื้อ</label>
                <label for="" v-else>จากใบสั่งซื้อ</label>
            </div>
        </div>  
 
        <div>
            <!-- <div class=" w-full flex   bg-blue-900 text-white ">
                    <div class="  ">
                       # รหัสพัสดุ
                    </div >
                    <div class=" pl-16 ">
                       <label for=""  class="  text-left">ชื่อพัสดุ </label> 
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

            <div class=" border p-1 " 
                v-for="(item_import,index) in stock_item_import"
                :key="index"
            >
                <div class=" w-full flex-row md:flex md:justify-between ">
                    <div class="  ">
                        {{index+1}}.  {{item_import.item_code}}
                    </div >
                    <div class="  ">
                       <label for=""  class=" text-sm">{{item_import.item_name}} </label> 
                    </div>
                    <div class=" ">
                         จำนวน {{item_import.item_receive}} {{item_import.unit_count}}  
                    </div>
                    <div>
                        ราคา/หน่วย {{item_import.price}} บาท
                    </div>
                    <div>
                        ({{item_import.catalog_number}}-{{item_import.lot_number}})
                    </div>
                                
                </div>
            </div>
            
        </div> 
        <div class=" mt-2">
            <button
            class="  w-full flex justify-center py-2  text-md   font-bold bg-green-300 hover:bg-green-200 focus:outline-none"
            
            >
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    เพิ่มพัสดุทั้งหมด
            </button>
        </div>
        <div class=" w-full  mt-2">
                <label class=" text-red-600">***ถ้าเป็นพัสดุใหม่ รหัสพัสดุต้องไม่ซ้ำกับพัสดุที่มีอยู่แล้ว ถ้ารหัสพัสดุซ้ำระบบจะนำจำนวนสั่งซื้อครั้งนี้ไปบวกเพิ่มให้อัตโนมัติ 
                    และปรับปรุงข้อมูลราคาให้อัตโนมัติ
                    แต่ถ้าเป็นรหัสพัสดุใหม่ระบบจะเพิ่มรายการพัสดุเป็นรายการใหม่
                </label>
        </div>
        <div class=" w-full  mt-2">
                <label for="">
                    คำถาม ถ้าใบสัญญาสั่งซื้อจะเป็นพัสดุเดิมที่เคยมีในคลังพัสดุอยู่แล้ว เท่านั้นใช่หรือไม่
                </label>
        </div>
    </AppLayout>
 </template>
 <script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props =defineProps({
    stocks:{type:String},
    stock_item_status:{type:Number},
    stock_item_import: {type:Array, default:[]},
    
})

const stock_item_types=[{'type_id':'1','type_name':'ใบสัญญาสั่งซื้อ'},
                      {'type_id':'2','type_name':'ใบสั่งซื้อ'}
                     ]


const form = useForm({
    file_stock_item: File,
    unit_id:0,
    stock_item_status:0,
})





const ImportStockItem=(()=>{
    console.log('----------Import Stock------')
    console.log(form.unit_id);
    console.log(form.file_stock_item);
    console.log(form.stock_item_status);
    form.post(route('stock-item-import-show'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { 
            console.log('finish');
           // import_stock_items.value = res.data.stock_item_import;   
        },
    })
})
  
</script>