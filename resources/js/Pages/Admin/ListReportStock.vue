<template>
    <AppLayout>
       <h4   class=" mt-3 text-center text-red-600">ระบุชื่อคลังพัสดุที่ต้องการดูรายงาน</h4>
        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
             <div class="m-2" >
                <label for="">ชื่อคลังพัสดุ</label> 
            
                <select name="" id="" v-model="form.stock_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(stock) in  stocks" :key=stock.id v-bind:value="{id:stock.slug , text:stock.stockname}" >{{stock.stockname}}</option>
                </select>
            </div>
         
            
        </div>
          <div class="flex flex-col  ">
            <!-- <button
                class="px-3 py-1  text-sm text-gray-700 bg-gray-400 rounded-md hover:bg-gray-300 focus:outline-none"
            >
                Cancel
            </button> -->
             <!-- <Link :href="route('admin-report-stock',{stock_slug:stock_selected,year:year_selected,month:month_selected})"> -->
                <button 
                    class=" w-full flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
                    @click="getStockReport(form.stock_selected)"
                >
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg> -->
                    ค้นหา
                </button>
            <!-- </Link> -->
        </div>
        <!-- {{$page.props.//}} -->
        <p v-if="item_trans.length==0"
        class="w-full  text-center "
        >
            ไม่พบข้อมูลการเบิกตามเงื่อนไขที่ระบุ
        </p>
        <!-- show order lists -->
         <h1 class="p-2 mt-3 text-center font-bold" >รายงานการเบิกพัสดุ </h1>
          <h1 class="p-2 mt-1 text-center font-bold" >{{form.stock_selected.text}}</h1>
         <button class=" mb-2 bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-500 rounded">
           Export EXCEL
        </button>
<!-- {{item_trans.length}} -->
    <!-- display card -->
    <!-- {{stock_items}} -->
    <div  class="w-full  p-2  ">
  
        <div v-for="(stock_item,key) in stock_items" :key=stock_item.index
            class="w-full bg-red-100  mt-3 border-2 border-red-300 rounded-lg lg:max-w-full lg:flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-2o" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
       

            <div
            class="w-full  leading-normal  border-b border-l border-r border-gray-200 rounded-b lg:border-l-0 lg:border-t lg:border-gray-200 lg:rounded-b-none lg:rounded-r"
            >   
                <div class=" mb-2">
                
                    <div class="p-2 text-md font-bold text-gray-900">
                        {{key+1}}.
                        SAP:{{stock_item.item_code}}
                        <label for="" class="text-blue-600">{{stock_item.item_name}}</label>
                        (หน่วย: {{stock_item.unit_count}})
                        <Link :href="route('list-stock-item',stock_item)">
                        <span
                            class="inline-flex text-md font-semibold underline leading-5 text-green-800 bg-green-200 rounded-lg"
                        >
                            ประวัติการรับเข้าและเบิกออก
                        </span>
                        </Link>
                    </div>
                
                
                    <div class="flex flex-col mb-2 text-md font-bold text-gray-900">
                        <div class=" flex ml-2"> จำนวนคงเหลือ : 
                            <span  
                                class="inline-flex px-2  text-lg font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            {{stock_item.item_sum}}
                            </span>
                        </div>
                        
                        <div class="flex ml-2"> วันหมดอายุ : 
                            <p class=" ml-2 text-blue-600" >
                            {{stock_item.checkin_last.date_expire}}
                            </p>
                        </div>
                        <!-- <div class=" ml-2 text-blue-600">{{stock_item.checkin_last.date_expire}}</div>  -->
                        <div class="flex ml-2"> วันที่รับเข้า : 
                            <p class=" ml-2 text-blue-600" >{{stock_item.checkin_last.date_action}}</p> 
                        </div>
                        
                        <div class="flex ml-2"> Cat.No/Lot.No : 
                            <p class=" ml-2 text-blue-600" >{{stock_item.checkin_last.profile['catalog_number']}} /{{stock_item.checkin_last.profile['lot_number']}}</p> 
                        </div>
                       
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <!-- end display card -->

        
    <!-- test display report table -->

   

      
        

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from '@vue/reactivity';

defineProps({
    stocks:{type:Object,required:true},
})

const stock_items=ref('');
const item_trans=ref('');

const form = useForm({
            stock_selected:'',
            year_selected:'',
            month_selected:'',
       
})

const getStockReport=(stock_selected)=>{
    // console.log('aaaaaaaaaa');
    //console.log(stock_selected);
  
        axios.get(route('admin-report-stock',{stock_slug:form.stock_selected})).then(res => {
           
            stock_items.value = res.data.stock_items;
            item_trans.value = res.data.item_tran;

            
        });
}

// export default {
//     components: {
//         AppLayout,
//         Link,

//     },
//     props:{
//         stocks:Array,
       
//     },
//     data(){
//         return{
//             stock_selected:'',
//             year_selected:'',
//             month_selected:'',
//             stock_items:[],
//             item_trans:[],
//             years:[2022,2021,2020,2019,2018],
//             months:[
// 				{id:1,name:'มกราคม' },
// 				{id:2,name:'กุมภาพันธ์' },	
// 				{id:3,name:'มีนาคม' },	
//                 {id:4,name:'เมษายน' },	
//                 {id:5,name:'พฤษภาคม' },	
//                 {id:6,name:'มิถุนายน' },	
//                 {id:7,name:'กรกฎาคม' },	
//                 {id:8,name:'สิงหาคม' },	
//                 {id:9,name:'กันยายน' },	
//                 {id:10,name:'ตุลาคม' },	
//                 {id:11,name:'พฤศจิกายน' },	
//                 {id:12,name:'ธันวาคม' },		
// 			],
//         }
//     },
// 
//     methods:{
//         // test_stock_selected(){
//         //     console.log('aaaaaaaaaa');
//         //     console.log(this.stock_selected);
//         // }
//         getStockReport(stock_selected){
//                 // console.log('aaaaaaaaaa');
//                 //console.log(stock_selected);
//                 // console.log(year_selected);
//                 // console.log(month_selected);
//                 // Inertia.get(route('admin-report-stock',{stock_slug:stock_selected,year:year_selected,month:month_selected}), 
//                 //              { replace: true });
//                 axios.get(route('admin-report-stock',{stock_slug:stock_selected})).then(res => {
//                 //    console.log(res.data.stock_items);
//                 //    console.log(res.data.item_tran);
//                    this.stock_items = res.data.stock_items;
//                    this.item_trans = res.data.item_tran;
//                 });
//         }
//     }

   
// }

</script>
