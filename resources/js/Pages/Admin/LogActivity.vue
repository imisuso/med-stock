<template>
    <AppLayout>
        <div class=" my-3 bg-blue-800 text-white text-xl text-center ">
            {{$page.props.unit.unitname}}
        </div>
        <div class=" w-full   p-2 rounded-md ">
            <div class="mt-3 font-bold" >
                <label for="">เลือกหัวข้อ</label> 
                <label v-if="msg_validate_stock" class=" text-red-600">   !กรุณาเลือกหัวข้อ</label>
            </div>
            <select name="" id="" v-model="form.function_selected"
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                v-on:change="setFunctionName"
                >
                <option v-for="(function_name) in  function_name_all" v-bind:key=function_name.id v-bind:value="function_name.function_name">{{function_name.function_name}}</option>
            </select>
           
        <!-- {{$page.props.stock_items}} -->
        </div>
        <!-- {{//}} -->
        <!-- {{stock_items}} -->
        <!-- <h4  class=" mt-3 text-center text-lg">ระบุปีและเดือน ที่ต้องการดูรายงานการเบิกใช้พัสดุ</h4> -->
       <!-- {{year_has}} -->
        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ปี พ.ศ.</label>
                <label v-if="msg_validate_year" class=" text-red-600">   !กรุณาเลือกปี พ.ศ.</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>
            <div  class=" m-2">
                <label for="">เดือน</label>
                <label v-if="msg_validate_month" class=" text-red-600">   !กรุณาเลือกเดือน</label>
                <select name="" id="" v-model="form.month_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(month) in  months" :key=month.id v-bind:value="month.id">{{month.name}}</option>
                </select>
                
            </div>  
            
        </div>
        <div class="flex flex-col  ">
            <!-- <button
                class="px-3 py-1  text-sm text-gray-700 bg-gray-400 rounded-md hover:bg-gray-300 focus:outline-none"
            >
                Cancel
            </button> -->
            <button v-on:click="getReportLogActivity()"
                class=" flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
            >
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg> -->
                ดูข้อมูล
            </button>
        </div>

 
    <!-- {{stocks}}-->
    
        <div  class=" w-full py-3 text-center font-bold text-lg ">
            <label for="">ข้อมูลการใช้งานระบบ</label>
        </div>  
        <div   class=" w-full text-center font-bold text-lg">
            <label for="">  
                ฟังก์ชัน:{{form.function_selected}}
            </label>
        </div>    
        <div  class=" w-full py-3 text-center font-bold text-lg ">
            <label for=""> เดือน {{month_thai[form.month_selected]}} ปี {{year_thai(form.year_selected)}}</label>
        </div>    
        <!-- <div v-if="item_trans.length==0" class=" w-full text-center">
            <label for="">ไม่พบข้อมูล</label>
        </div>  -->
        
        <div>
           
            <!-- <div 
                class="w-full my-3  border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                <div class="flex flex-col  lg:flex-row lg:justify-between  mx-2"  >
                    
                    <div class=" lg:w-2/12  ">
                        วันที่เบิก:
                    </div>
                
                    <div class=" lg:w-2/12 ">
                        ผู้เบิก:
                    </div>
                    <div class=" lg:w-4/12 ">
                        SAP-ชื่อพัสดุ:
                    </div>
                    <div class=" lg:w-2/12 ">
                        วันที่หมดอายุ:
                    </div>
                    <div class=" lg:w-1/12 ">
                        จำนวนที่เบิก:
                    </div>
                    <div class=" lg:w-1/12 ">
                        จำนวนคงเหลือปัจจุบัน:
                    </div>
                </div>     
            </div> -->
        </div>
        <!-- body table -->
        <div v-if="item_trans">
            <paginateMe :pagination="item_trans" />
            <div v-for="(item_tran,key) in item_trans.data" :key=item_tran.id
                    class="w-full border-b-2   border-gray-500 shadow-sm ">
                    {{item_trans.from + key}}. {{item_tran}}
            </div>  
        </div>
        <div v-else
            class=" flex justify-center content-center "
            >
                <label for="">ไม่พบข้อมูล</label>
        </div>
        <!-- <div  class="w-full mt-3  ">
  
            <div v-for="(item_tran,key) in item_trans.data" :key=item_tran.id
                class="w-full border-b-2   border-gray-500 shadow-sm ">
              
                <div class="flex flex-col  lg:flex-row   "  >
                    
                    <div class=" bg-blue-100 lg:bg-transparent lg:w-2/12  ">
                        <label for="" class="  ">  {{item_trans.from + key}}. </label>
                        <label for="" class="  lg:hidden">วันที่เบิก:</label>
                        <label class=" font-bold">
                         
                            {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}}
                        </label>
                    </div>
                
                    <div class=" lg:w-2/12  lg:text-xs ">
                        <label for="" class="   lg:hidden">ผู้เบิก:</label>
                        <label class=" font-bold">{{item_tran.user['name']}}</label>
                    </div>
                    <div class="   lg:w-4/12 lg:text-xs ">
                        <label for="" class="   lg:hidden">SAP:</label>
                        <label class=" font-bold">
                            {{item_tran.stock_item['item_code']}} - {{item_tran.stock_item['item_name']}}
                        </label>
                    
                    </div>
                    <div class=" lg:w-2/12  ">
                        <label for="" class="  lg:hidden">วันที่หมดอายุ:</label>
                        <label class=" font-bold">
                            {{dayjs(item_tran.date_expire_last).locale('th').format('D MMM BBBB')}}
                        </label>
                    </div>
                    <div class="  lg:w-1/12 ">
                        <label for="" class="  lg:hidden">จำนวนที่เบิก:</label>
                        <label class=" font-bold">{{item_tran.item_count}} </label>
                    </div>
                    <div class="  lg:w-1/12 ">
                        <label for="" class="  lg:hidden">จำนวนคงเหลือปัจจุบัน:</label>
                        <label class=" font-bold">  {{item_tran.stock_item['item_sum']}}</label>
                    </div>
                </div>     
            </div>
        </div> -->
   

   
     

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props=defineProps({
    function_name_all:{type:Object},
    years:{type:Array},
  
    item_trans:{type:Object},
    function_name_selected:{type:String},
    year_selected:{type:String},
    month_selected:{type:String},
   
})
const form = useForm({
    function_selected:props.function_name_selected ? props.function_name_selected :'',
    year_selected:props.year_selected ? props.year_selected :'',
    month_selected:props.month_selected ? props.month_selected :'',
    //id:usePage().props.value.auth.user.//id ? usePage().props.value.auth.user.//id :0,
    
})
//const  demo_show_stock_items=ref(false);
const month_thai=ref([
        '',
        'มกราคม' ,
        'กุมภาพันธ์',	
        'มีนาคม' ,
        'เมษายน' ,	
        'พฤษภาคม',	
        'มิถุนายน' ,	
        'กรกฎาคม',	
        'สิงหาคม' ,	
        'กันยายน' ,	
        'ตุลาคม' ,
        'พฤศจิกายน',	
        'ธันวาคม',
])
const months=ref([
        {id:1,name:'มกราคม' },
        {id:2,name:'กุมภาพันธ์' },	
        {id:3,name:'มีนาคม' },	
        {id:4,name:'เมษายน' },	
        {id:5,name:'พฤษภาคม' },	
        {id:6,name:'มิถุนายน' },	
        {id:7,name:'กรกฎาคม' },	
        {id:8,name:'สิงหาคม' },	
        {id:9,name:'กันยายน' },	
        {id:10,name:'ตุลาคม' },	
        {id:11,name:'พฤศจิกายน' },	
        {id:12,name:'ธันวาคม' },
])

//const   years=ref([2023,2022,2021,2020,2019,2018])
//const item_trans=ref('')
//const stock_all=ref(Object);
const function_name=ref(0);

const msg_validate_stock=ref(false);
const msg_validate_year=ref(false);
const msg_validate_month=ref(false);

const year_thai = (year_select)=>{
   // console.log('year_select=')
   // console.log(year_select)
    if(year_select.length==0)
         return '';
    else
         return year_select+543;
}



const setFunctionName=()=>{
  console.log('setFunctionName');
  //function_name.value =form.function_name_selected;
     console.log(form.function_selected);
}

const  getReportLogActivity=()=>{
           console.log('getReportLogActivity');
   
   // demo_show_stock_items.value=true;
//    msg_validate_stock.value = false
//    msg_validate_year.value = false
//    msg_validate_month.value = false
    if(form.function_selected.length==0){
     msg_validate_stock.value = true
     return false;
    }else{
        msg_validate_stock.value = false;
    }

    if(form.year_selected.length==0){
        msg_validate_year.value = true
        return false;
    }else{
        msg_validate_year.value = false
    }

    if(form.month_selected.length==0){
        msg_validate_month.value = true
        return false;
    }else{
        msg_validate_month.value = false
    }

    console.log(form.function_selected);
     console.log(form.year_selected);
    console.log(form.month_selected);
   //report-checkout-item

   form.post(route('get-log'),{
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { 
            //console.log('success');
        },
        onError: errors => { 
           // console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })

  
}




</script>
