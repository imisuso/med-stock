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
                <p class=" my-2 ">เพิ่มคลังพัสดุใหม่</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
          
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <!-- <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.auth.user.profile.division_name}}
                </div> -->
                <div class="mt-3" >
                    <label for="">เลือกหน่วยงาน:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit"
                    @change="getListStockUnit(unit)"
                >
                    <option v-for="(unit) in  units" :key=unit.id :value="unit.unitid">{{unit.unitname}}</option>
                </select>
            </div>
            <!-- {{count(stocks_unit)}} -->
            <div v-if="stocks_unit_count>0"
                class="w-full  bg-green-100 p-2 my-2 rounded-md"
                >
                <label for="">รายชื่อคลังในหน่วย/สาขา นี้:</label>
                <li v-for="(stock) in  stocks_unit" :key=stock.id :value="stock.id"
                
                >
                {{stock.stockname}}({{stock.stockengname}})
                </li>
            </div>  
            <div v-else
                class="w-full  bg-yellow-100 p-2 my-2 rounded-md"
                >
                <label for="">ไม่พบรายชื่อคลังในหน่วย/สาขา นี้:</label>
            </div>
           

            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                 
                </div>
                <div class="mt-3" >
                    <label for="">ระบุชื่อคลังพัสดุ(ภาษาไทย):</label> 
                </div>
                <input type="text" class="w-full  py-2 rounded-md "
                     v-model="form.stock_name_thai"
                >
                
            </div>
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                 
                </div>
                <div class="mt-3" >
                    <label for="">ระบุชื่อคลังพัสดุ(ภาษาอังกฤษ):</label> 
                </div>
                <input type="text" class="w-full  py-2 rounded-md "
                     v-model="form.stock_name_en"
                >
                
            </div>

            <div class=" text-center">
              
                        <div>
                            <button type="submit" 
                                class="  inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white py-1 px-6 border border-green-500 rounded"
                                @click="confirmAddStock()"
                                >
                                ตกลง
                            </button>
                        </div>
                    <!-- </form> -->
            </div>

         
        </div>

        <ModalUpToYou :isModalOpen="confirm_add_stock" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการเพิ่มคลังพัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                     <label for=""
                     class="  flex  justify-start w-full text-sm "
                     >
                            หน่วย/สาขา:{{getUnitname()}}
                        </label>
                    <label 
                            class="  flex  justify-start w-full text-sm ">
                        <!-- ใบสั่งซื้อเลขที่:{{confirm_order_no}}/{{form.confirm_order_year}} ของ {{form.confirm_stockname_order}} -->
                        ชื่อคลัง: {{form.stock_name_thai}} ({{form.stock_name_en}})
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmAddStock"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelAddStock"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>
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
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';


const props =defineProps({
    //stocks:Array,
    units:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

const stocks_unit = ref('');
const stocks_unit_count = ref(0);

const confirm_add_stock=ref(false);
 const unit_name = ref('');
// const unit_name = computed(()=>{
// });
const  cancelAddStock=()=>{
    confirm_add_stock.value = false;
}

const form = useForm({
    unit:'',
    stock_name_thai:'',
    stock_name_en:'',
    //unit_name:'',
   // stock_item_status:0,
  //  date_receive:0,
})

const getUnitname = () => {
    console.log('getUnitname')
    let unit = {}
    unit = props.units.find( item => item.unitid === form.unit) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    return unit.unitname
}

const getListStockUnit=(()=>{
     console.log('----------getListStockUnit------')
    //console.log(unit);
   


    axios.get(route('get-list-stock-unit',{unit_id:form.unit})).then(res => {
        console.log(res.data.list_stock_unit.length);
       stocks_unit.value = res.data.list_stock_unit;   
       stocks_unit_count.value = res.data.list_stock_unit.length;
       //console.log(stocks_unit.count());
    });
})


const confirmAddStock=(()=>{
  console.log('----------confirmAddStock------');
  //console.log(form.unit);
  //console.log(form.stock_name_thai);
  //console.log(unit_name);
 // console.log(getUnitname());

  confirm_add_stock.value = true;
})

const okconfirmAddStock=()=>{
    confirm_add_stock.value = false;
    // console.log(form.order_id);
       console.log('----------okconfirmAddStock------');
 
    
      form.post(route('stock-add-confirm'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
}





// const setUnitName=((unit)=>{
//     console.log('----------setUnitName------');
//    // unit_name = unit_name;
// })


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