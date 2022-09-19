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
        
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">เพิ่มผู้ใช้งาน</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="mt-3" >
                    <label for="">ระบุรหัสเจ้าหน้าที่ 8 หลัก(SAP):</label> 
                </div>
                <input type="text" name="" class="w-full  py-2 rounded-md ">
            </div>
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <!-- <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.auth.user.profile.division_name}}
                </div> -->
                <div class="mt-3" >
                    <label for="">เลือกหน่วยงานที่สังกัด:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit_id"
                   @change="getListStockUnit()"
                >
                    <option v-for="(unit) in  units" :key=unit.id :value="unit.unitid">{{unit.unitname}}</option>
                </select>
            </div>
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                 
                </div>
                <div class="mt-3" >
                    <label for="">เลือกคลังพัสดุที่ต้องการให้บันทึกตัดสต๊อก:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    
                >
                    <option v-for="(stock) in  stocks_unit" :key=stock.id :value="stock.id">{{stock.stockname}}</option>
                </select>
                
            </div>

            <div class=" text-center">
              
                        <div>
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
        <!-- <div class=" w-full p-4 mt-2  justify-center bg-red-100">
            <p for="">คำแนะนำการนำเข้าพัสดุจากไฟล์ excel</p>
            <p for="">1.กรุณาตรวจสอบชื่อคอลัมน์และจำนวนคอลัมน์ให้ถูกต้องตามตัวอย่างไฟล์ excel</p>
            <p for="">2.กรุณาตรวจสอบจำนวนรายการพัสดุต้องไม่เกิน 50 รายการต่อ 1 ไฟล์ excel</p>
        </div>  -->
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props =defineProps({
    stocks:Array,
    units:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

const stocks_unit = ref('');


const form = useForm({
    unit_id:0,
   // stock_item_status:0,
  //  date_receive:0,
})

const getListStockUnit=(()=>{
    // console.log('----------getListStockUnit------')
    // console.log(form.unit_id);


    axios.get(route('get-list-stock-unit',{unit_id:form.unit_id})).then(res => {
       // console.log(res.data.stocks);
       stocks_unit.value = res.data.list_stock_unit;   
    });
})



// const ImportStockItem=(()=>{
//     // console.log('----------Import Stock------')
//     // console.log(form.unit_id);
//     // console.log(form.file_stock_item);
//     // console.log(form.stock_item_status);
//     // console.log(form.date_receive);
//     form.post(route('stock-item-import-show'), {
//         preserveState: true,
//         preserveScroll: true,
//         onSuccess: page => { console.log('success');},
//         onError: errors => { 
//             console.log('error');
//         },
//         onFinish: visit => { 
//             console.log('finish');
//            // import_stock_items.value = res.data.stock_item_import;   
//         },
//     })
// })
  
</script>