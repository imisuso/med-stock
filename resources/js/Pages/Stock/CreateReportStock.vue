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
        <div v-if="stock_id !=0"  class=" w-full text-center font-bold text-lg">
            <label for="">  {{stocks[stock_id-1].stockname}} </label>
        </div>    
        <div  class=" w-full py-3 text-center font-bold text-lg border-b-4 border-gray-300">
            <label for="">ข้อมูลการตัดสต๊อกของเดือน {{month_thai[form.month_selected]}} ปี {{form.year_selected}}</label>
        </div>    
        <div v-if="item_trans.length==0" class=" w-full text-center">
            <label for="">ไม่พบข้อมูล</label>
        </div>    
      
      <div  class="w-full mt-3 p-2  ">
  
        <div v-for="(item_tran,key) in item_trans" :key=item_tran.id
            class="w-full bg-blue-100 my-3  border-b-2 border-gray-300 shadow-md ">
            <!-- {{item_tran}} -->
            <div class=" mx-2" >
                 {{key+1}}.SAP:
                 <label class=" font-bold">
                     {{item_tran.stock_item['item_code']}} 
                 </label>
                 ชื่อพัสดุ:
                 <label class=" font-bold">{{item_tran.stock_item['item_name']}}</label>
                <!-- <span  
                    class="inline-flex px-2  text-lg font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    {{item_tran.stock_item['item_sum']}}
                </span> -->
                
            </div>   
            <div class="flex flex-row  mx-2">
                <div>
                    วันที่เบิก:
                    <label class=" font-bold">{{item_tran.date_action}}</label>
                </div>
                <div class=" ml-5">
                     จำนวนที่เบิก:
                    <label class=" font-bold">{{item_tran.item_count}} ชิ้น</label>
                </div>
            </div>  
            <div class=" mx-2 mb-3">
                ผู้เบิก:
                <label class=" font-bold">{{item_tran.user['name']}}</label>
            </div>      
        </div>
      </div>


    <div v-if="item_trans.length !=0"   class=" mt-6 flex flex-col  ">
        <!-- <button
            class=" flex justify-center mt-3 px-8 py-1   text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
        >
         
            พิมพ์รายงาน
        </button> -->
        <button
            class=" flex justify-center mt-3 px-8 py-1   text-md  text-white bg-green-700 rounded-sm shadow-md hover:bg-green-400 focus:outline-none"
            >
            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg> -->
            export excel 
        </button>
    </div>

     

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';
import { onMounted } from '@vue/runtime-core';

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

// onMounted(() => {
//     console.log('onMounted');
//       stock_all.value = usePage().props.value.stocks;
//      console.log(stock_all);
// });

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
//             console.log('hi');
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
