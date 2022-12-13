<template>
    <AppLayout>
         <!--Header Alert-->
         <!-- {{$page.props.flash.status}}--{{status}} -->
         <div v-if="status=='success'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="status=='warning'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-yellow-800 font-bold" title="close" for="banneralert">
                {{ msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="status=='error'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                {{ msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">จัดการข้อมูลคลังวัสดุ</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
                <!-- {{units}} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <!-- <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.auth.user.profile.division_name}}
                </div> -->
                <div class="mt-3" >
                    <label for="">กรุณาเลือกหน่วยงานที่ต้องการเพิ่ม/แก้ไข คลัง:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit"
                    @change="getListStockUnit(unit)"
                >
                    <option v-for="(unit) in  units" :key=unit.id :value="unit.unitid">{{unit.unitname}}</option>
                </select>
            </div>
            <!-- **{{form.unit}} -->
           <!-- count- {{props.list_stock_unit.length}}
            {{form.stocks_unit}} -->
            <div v-if="props.list_stock_unit.length>0"
                class="w-full   text-sm   my-2 rounded-md"
                >
                <label for="">รายชื่อคลังที่มีอยู่แล้วในหน่วย/สาขา นี้:</label>
                <div v-for="(stock,index) in  form.stocks_unit" :key=index :value="stock.id"
                    class=" bg-white p-2 my-2  lg:flex lg:justify-between border-b-2  border-gray-300 "
                >
                    <div class=" flex flex-col lg:flex-row ">
                        <div>
                            {{index+1}}. {{stock.stockname}}({{stock.stockengname}})
                        </div>
                        <div>
                            <label class=" p-2 text-blue-600">สถานะ:</label>
                            <label class=" bg-red-100">{{stock.status_name}}</label>
                            
                        </div>
                        <div class="">
                                <label  class=" mx-2  text-xs ">
                                    แก้ไขล่าสุดเมื่อ: 
                                    {{dayjs(stock.updated_at).locale('th').format('D MMM BBBB H:mm')}}
                                    น.
                                </label>
                        </div>
                       
                        <!-- <label for="" v-if="stock.status==1" class=" ml-4 "> สถานะ:ใช้งาน</label> -->
                    </div>
                    <div v-if="$page.props.auth.user.roles[0].name == 'admin_med_stock'"
                        class="flex  justify-center bg-yellow-200 px-2 rounded-md shadow-md " >
                        
                        <a :href="route('show-detail-stock',stock)"  >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                     
                        <!-- <button type="submit" 
                            class="   ml-4 px-2 text-md  bg-red-500 hover:bg-red-700 text-white  border border-red-500  rounded-md shadow-md"
                            @click="confirmDeleteStock()"
                            >
                            ลบ
                        </button> -->
                    </div>
                   
                </div>
                <div class=" my-2 ">
                    <button type="submit" 
                         v-if="$page.props.auth.user.roles[0].name=='admin_med_stock'"
                        class=" w-full flex justify-center py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="showFormAddStock()"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        เพิ่มคลังวัสดุ
                    </button>
                </div>
            </div>  
            <div v-if="props.list_stock_unit.length==0 && props.unit_search "
                class="w-full   p-2 my-2 rounded-md"
                >
                <label for="">ไม่พบรายชื่อคลังในหน่วย/สาขา นี้</label>
                <div class=" my-2 " v-if="$page.props.auth.user.roles[0].name == 'admin_med_stock'">
                    <button type="submit" 
                        class=" w-full flex justify-center py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                        @click="showFormAddStock()"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                            เพิ่มคลังวัสดุ
                    </button>
                </div>
            </div>

            <div v-if="show_form_add_stock">
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

           
              
                <div class="  ">
                    <button type="submit" 
                        class=" w-full flex justify-center py-2  text-md  bg-green-500 hover:bg-green-700 text-white  border border-green-500 rounded"
                        @click="confirmAddStock()"
                        >
                        บันทึก
                    </button>
                </div>
    
            
            </div>
           

         
        </div>

        <ModalUpToYou :isModalOpen="confirm_add_stock" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการเพิ่มคลังวัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                     <label for=""
                     class="  flex  justify-start w-full text-sm "
                     >
                            หน่วย/สาขา:
                            {{getUnitname()}}
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

       
  
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)


const props =defineProps({
    //stocks:Array,
    units:Object,
    status:String,
    msg:String,
    unit_search : {type:Number},
    list_stock_unit: {type:Array, default:[]},
    
})

const form = useForm({
    unit_selected:props.unit_search ? props.unit_search : '',
    unit:props.unit_search ? props.unit_search : 0,
    stock_name_thai:'',
    stock_name_en:'',
    stocks_unit:props.list_stock_unit ? props.list_stock_unit : ''
    //unit_name:'',
   // stock_item_status:0,
  //  date_receive:0,
})


//console.log(dayjs().format())
//const stocks_unit = ref('');


const stocks_unit_count = ref();

const confirm_add_stock=ref(false);

const unit_name = ref('');
const show_form_add_stock=ref(false);

const showFormAddStock=()=>{
    show_form_add_stock.value=true
}

const  cancelAddStock=()=>{
    confirm_add_stock.value = false;
}



const getUnitname = () => {
    // console.log('getUnitname')
    // console.log(form.unit)
    // console.log(props.units)
    props.units.find( item => console.log(item.unitid ))
    let unit = {}
    unit = props.units.find( item => item.unitid == form.unit) // เอาค่าแรกที่เจอค่าเดียว
  
  // console.log(unit)
   // return 'xxxx'
    return unit.unitname
}

const getListStockUnit=(()=>{
    // console.log('----------getListStockUnit------')
    //console.log(unit);


    form.get(route('stock-add'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
            // console.log(props.list_stock_unit.length);
            // stocks_unit_count.value = props.list_stock_unit.length;
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
})


const confirmAddStock=(()=>{
//   console.log('----------confirmAddStock------');
//   console.log(form.unit);
//   console.log(form.stock_name_thai);
 // console.log(unit_name);
 // console.log(getUnitname());

  confirm_add_stock.value = true;
})

const okconfirmAddStock=()=>{
    confirm_add_stock.value = false;
    // console.log(form.order_id);
   //    console.log('----------okconfirmAddStock------');
 
    
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

  
</script>