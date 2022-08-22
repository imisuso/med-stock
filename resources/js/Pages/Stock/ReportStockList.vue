<template>
    <AppLayout>
        <div class=" w-full  bg-blue-100 p-2 rounded-md ">
            <div class="bg-blue-800 text-white text-xl text-center ">
                {{unit.unitname}}
            </div>
            <div class="mt-3" >
                <label for="">เลือกคลังพัสดุ</label> 
            </div>
            <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                <option v-for="(stock) in  stocks" :key=stock.id value="{{stock.id}}">{{stock.stockname}}</option>
            </select>
           
        <!-- {{$page.props.stock_items}} -->
        </div>
        <!-- show stock items -->
        <!-- <div class="w-full mt-3 p-2 bg-blue-400 rounded-md">
            <div  v-for="(stock_item) in  $page.props.stock_items" :key=stock_item.id
            class=" mt-2 bg-green-50 rounded-sm">
                    {{stock_item.item_code}} {{stock_item.item_name}}
            </div>
            
        </div> -->

     
        <!-- show order lists -->
         <h1 class="p-2 m-4 text-center" >รายงานการเบิกพัสดุ</h1>
        <table class="min-w-full border-collapse block  md:table">
		<thead class="block  md:table-header-group">
			<tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
				<th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">ปี พ.ศ.</th>
				<th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">เดือน</th>
				<th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">::</th>
			</tr>
		</thead>
		<tbody class="block md:table-row-group">
			<tr v-for="(report_stock_list) in report_stock_lists" :key=report_stock_list.id
                class="bg-white p-2 mb-2 border-2 border-gray-500 md:border-none block md:table-row">
				<td class="text-left  block md:table-cell md:border-b md:border-gray-400 md:rounded-l-lg"><span class="inline-block w-1/3 md:hidden font-bold">ปี พ.ศ.</span>{{report_stock_list.year+543}}</td>
				<td class="text-left  block md:table-cell md:border md:border-gray-400"><span class="inline-block w-1/3 md:hidden font-bold">เดือน</span>{{report_stock_list.month}}</td>
				<td class="text-left  block md:table-cell md:border-b md:border-gray-400 md:rounded-r-lg">
					<span class="inline-block w-1/3 md:hidden font-bold">สถานะ</span>
                    <!-- {{report_stock_list.status}} -->
                   
					<button 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded"
                        @click="getCheckoutItem(report_stock_list.year,report_stock_list.month)"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                        </svg>
                    </button>
					
                    <!-- <button v-if="report_stock_list.status == 'สร้างรายงาน'"
                        class=" ml-3 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <button v-if="report_stock_list.status == 'สร้างรายงาน'"
                        class=" ml-3 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-500 rounded">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button> -->
                  
				</td>
			</tr>
			
		</tbody>
	</table>

      
        

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';

defineProps({
    stocks:Object,
    unit:Object,
    report_stock_lists:Object,
})

const months=ref(
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
        {id:11,name:'ฟฤศจิกายน' },	
        {id:12,name:'ธันวาคม' },	
)

const getCheckoutItem=(year,month)=>{
    console.log('year='+year);
   console.log('year='+month);
}
// export default {
//     components: {
//         AppLayout,
//         Link,
//     },
//     props:{
//         stocks:Array,
//         unit:Array,
//         report_stock_lists:Array,
//     },
//     data(){
//         return{
           
//            months:[
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
//                 {id:11,name:'ฟฤศจิกายน' },	
//                 {id:12,name:'ธันวาคม' },		
// 			],
//         }
//     },

//}

</script>
