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
        <div class=" w-full p-4 mt-2  justify-center bg-red-100">
            <p class=" flex font-bold underline">กรุณาอ่าน:คำแนะนำการนำเข้าวัสดุจากไฟล์ excel</p>
            <p >1.ตรวจสอบชื่อคอลัมน์และจำนวนคอลัมน์ให้ถูกต้องตามตัวอย่างไฟล์ excel</p>
            <div class=" flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                </svg>
                <a href="../../../../docs/ตัวอย่างข้อมูลวัสดุที่จะนำเข้าระบบวัสดุ_UAT.xlsx" class=" underline underline-offset-2 font-extrabold text-green-700"> 
                    download ตัวอย่างไฟล์รายการวัสดุ
                </a>
            </div>
          
           
            <p >2.ตรวจสอบจำนวนรายการวัสดุต้องไม่เกิน 50 รายการต่อ 1 ไฟล์ excel</p>
            <p >3.ตรวจสอบ Format Cell ให้ตรงกับตัวอย่างไฟล์ excel ทุกคอลัมน์</p>
        </div> 
        <div class=" w-full p-4 mt-2 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" bg-blue-800 text-white text-center text-lg font-bold ">
                <p class=" my-2 ">นำเข้าข้อมูลวัสดุจากไฟล์ Excel ตรวจรับวัสดุ</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="  text-xl text-center ">
                    {{$page.props.unit.unitname}}
                </div>
                <div class="mt-3" >
                    <label for="">เลือกคลังวัสดุที่ต้องการเพิ่มวัสดุ</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit_id"
                >
                    <option v-for="(stock) in  stocks" :key=stock.id :value="stock.id">{{stock.stockname}}</option>
                </select>
                <div class="mt-3" >
                    <label for="">เลือกประเภทการจัดซื้อวัสดุ</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.stock_item_status"
                >
                    <option v-for="(stock_item_types) in  stock_item_types" :key=stock_item_types.type_id :value="stock_item_types.type_id">{{stock_item_types.type_name}}</option>
                </select>

              

                <!-- <div class="mt-3" >
                    <label for="">ระบุรหัสใบสั่งซื้อ</label> 
                </div>
                <input type="text" name="" class="w-full  py-2 rounded-md "   v-model="form.stock_po"> -->
                
                <!-- <div class="mt-3">
                    <label for="">วันที่ตรวจรับวัสดุ:</label>
                    <input type="date" name="" id=""
                        v-model="form.date_receive"
                        class="w-full px-12 py-2  rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500">
                </div> -->
           
            </div>
            <div class=" text-center">
                    <!-- @if(session('status'))
                        <div class=" alert alert-success">
                            {{ session('status')}}
                        </div>
                    @endif -->
                    <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                        <div class="">
                            เลือกไฟล์ excel รายการวัสดุที่ต้องการนำเข้าคลังสาขา
                            <input type="file" name="file" id="" @change="onChangeFile">
                           
                        </div>
                        <div class="p-2">
                            <button type="submit" 
                                class="  inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white py-1 px-6 border border-green-500 rounded"
                                @click="ImportStockItem()"
                                >
                                ตกลง
                            </button>
                        </div>
                    <!-- </form> -->
            </div>

         
        </div>
       
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props =defineProps({
    stocks:Array,
    unit:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

const stock_item_types=[{'type_id':'1','type_name':'ใบสัญญาสั่งซื้อ'},
                      {'type_id':'2','type_name':'ใบสั่งซื้อ'}
                     ]


const form = useForm({
    file_stock_item: File,
    unit_id:0,
    stock_item_status:0,
   // stock_po:'',
  //  date_receive:0,
})

const onChangeFile=((e)=>{
    console.log(e.target.files[0])
    form.file_stock_item = e.target.files[0];
})

// const getStockItemFromExcel = () => {
//     console.log('getListPurchase');


//     Inertia.get(route('purchase-order-list'), { year: form.year_selected }, {
//         preserveState: true,
//         replace: true
//     })
//    // forceUpdate();
// }

const ImportStockItem=(()=>{
    // console.log('----------Import Stock------')
    // console.log(form.unit_id);
    // console.log(form.file_stock_item);
    // console.log(form.stock_item_status);
    // console.log(form.date_receive);
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