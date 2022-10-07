<template>
    <AppLayout>
        <div class=" my-3 bg-blue-800 text-white text-xl text-center ">
                {{$page.props.unit.unitname}}
        </div>
        <div class=" w-full   p-2 rounded-md ">
            
            <div class="mt-3 font-bold" >
                <label for="">เลือกคลังพัสดุ</label> 
            </div>
            <select name="" id="" v-model="form.unit_selected"
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                v-on:change="setStockID"
                >
                <option v-for="(stock) in  stocks" v-bind:key=stock.id v-bind:value="stock.id">{{stock.stockname}}</option>
            </select>
           
        <!-- {{$page.props.stock_items}} -->
        </div>
        <!-- {{unit}} -->
        <!-- {{stock_items}} -->
        <!-- <h4  class=" mt-3 text-center text-lg">ระบุปีและเดือน ที่ต้องการดูรายงานการเบิกใช้พัสดุ</h4> -->
        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ปี พ.ศ.</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>
            <div  class=" m-2">
                <label for="">เดือน</label>
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
            <button v-on:click="getReportStock(form.unit_selected,form.year_selected,form.month_selected)"
                class=" flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
            >
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg> -->
                ดูข้อมูลการเบิก
            </button>
        </div>

    <!-- {{item_trans}} -->
    <!-- {{stocks}}-->
        <!-- {{stock_id}} -->
        <div  class=" w-full py-3 text-center font-bold text-lg ">
            <label for="">รายงานบันทึกตัดสต๊อก</label>
        </div>  
        <div v-if="stock_id !=0"  class=" w-full text-center font-bold text-lg">
            <label for="">  {{stocks[stock_id-1].stockname}} </label>
        </div>    
        <div  class=" w-full py-3 text-center font-bold text-lg border-b-4 border-gray-300">
            <label for=""> {{month_thai[form.month_selected]}} ปี {{year_thai(form.year_selected)}}</label>
        </div>    
        <div v-if="item_trans.length==0" class=" w-full text-center">
            <label for="">ไม่พบข้อมูล</label>
        </div> 
        
        <div>
            <div 
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
            </div>
        </div>
      
        <div  class="w-full mt-3  ">
  
            <div v-for="(item_tran,key) in item_trans" :key=item_tran.id
                class="w-full border-b-2   border-gray-500 shadow-sm ">
              
                <div class="flex flex-col  lg:flex-row   "  >
                    
                    <div class=" bg-blue-100 lg:bg-transparent lg:w-2/12  ">
                        <label for="" class="  lg:hidden">{{key+1}}.วันที่เบิก:</label>
                        <label class=" font-bold">
                            <!-- {{date_action_thai(item_tran.date_action)}} -->
                            {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}}
                        </label>
                    </div>
                
                    <div class=" lg:w-2/12   ">
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
        </div>
   

    <div v-if="item_trans.length !=0"   class=" mt-6 flex flex-col  ">
 
        <!-- {{item_trans}} -->
         <a class="flex justify-center mt-3 px-8 py-1   text-md  text-white bg-blue-700 rounded-sm shadow-md hover:bg-yellow-200 focus:outline-none" 
            :href="route('export-checkout-item', {stock_id:form.unit_selected, year:form.year_selected, month:form.month_selected })">
            Export Excel
        </a>

        <!-- <a class="flex justify-center mt-3 px-8 py-1   text-md  text-white bg-yellow-600 rounded-sm shadow-md hover:bg-yellow-200 focus:outline-none" 
            :href="route('export-checkout-item-test', {checkout_items:item_trans })">
            Export Excel Test
        </a> -->

        <!-- <a :href="route('print-purchase-order-item',purchaseOrder.id)"  target="blank" -->
            <a :href="route('print-cutstock-pdf',{stock_id:form.unit_selected, year:form.year_selected, month:form.month_selected })"  target="blank"
                class="flex justify-center mt-3 px-8 py-1   text-md  text-white bg-purple-500 rounded-sm shadow-md hover:bg-purple-200 focus:outline-none"
                >
            <div class="flex items-center" >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                    พิมพ์รายงานตัดสต๊อกพัสดุ
            </div>
        </a>
    </div>

     

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

defineProps({
    stocks:Object,
   // stock_items:Object,
    unit:Object, 
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

const   years=ref([2022,2021,2020,2019,2018])
const item_trans=ref('')
//const stock_all=ref(Object);
const stock_id=ref(0);

const year_thai = (year_select)=>{
    return year_select+543;
}

const form = useForm({
    unit_selected:'',
    year_selected:'',
    month_selected:'',
   // item_trans:{type:Object},
})

const setStockID=()=>{
  //  console.log('set stock ID');
    stock_id.value =form.unit_selected;
  //   console.log(stock_id);
}

const  getReportStock=(stock_id,year,month)=>{
           console.log('getReportStock');
    // console.log(stock_id);
    // console.log(year);
    // console.log(month);
   // demo_show_stock_items.value=true;

    axios.get(route('get-checkout-item',
                         {stock_id:form.unit_selected , year:form.year_selected , month:form.month_selected}
                    )).then(res => {
        // console.log(res.data);
        item_trans.value = res.data.item_trans;

    });
  
}




</script>
