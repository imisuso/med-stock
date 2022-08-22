<template>
     <AppLayout>
  
    <div class="bg-blue-800 text-white text-xl text-center ">
            {{$page.props.stock.stockname}}
    </div>

    <!-- Item Detail -->
     <!-- {{$page.props.checkin_last}} -->
     <div class="w-full mt-3 p-2  ">
  
      <div 
            class="w-full bg-purple-100  mt-3 border-2 border-purple-300 rounded-lg lg:max-w-full lg:flex">
        <div
          class="flex flex-col  items-center overflow-hidden text-center  bg-cover rounded-t lg:h-auto lg:w-36 lg:rounded-t-none lg:rounded-l"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
       
        <div class="w-full  leading-normal  border-b border-l border-r border-gray-200 rounded-b lg:border-l-0 lg:border-t lg:border-gray-200 lg:rounded-b-none lg:rounded-r"
        >
            <div class=" mb-2">
                <div class="p-2 text-md font-bold text-gray-900">
                    SAP:{{$page.props.stock_item.item_code}}
                    <label for="" class="text-blue-600">{{$page.props.stock_item.item_name}}</label>
                    (หน่วย: {{$page.props.count_name}})
                   
                </div>
               
            
                <div class="flex flex-col lg:flex-col mb-2 text-md font-bold text-gray-900">
                    <div class="flex ml-2"> จำนวนคงเหลือ :
                        <p class=" ml-2 text-red-600">{{$page.props.stock_item.item_sum}}</p>     
                    </div>
                    <div class="flex ml-2"> วันหมดอายุ : 
                        <p class=" ml-2 text-blue-600">{{$page.props.checkin_last.date_expire}}</p> 
                    </div>
                    
                    <div class="flex ml-2"> วันที่รับเข้า : 
                         <p class=" ml-2 text-blue-600">{{$page.props.checkin_last.date_action}}</p> 
                    </div>
                   
                     <div class="flex ml-2"> Cat.No/Lot.No : 
                         <p class=" ml-2 text-blue-600">{{$page.props.checkin_last.profile['catalog_number']}}/{{$page.props.checkin_last.profile['lot_number']}}</p> 
                     </div>
                    
                </div>
            </div> 
        </div>
      </div>
    </div>
    <!-- END Item Detail -->
 <!-- {{$page.props.item_trans}}  -->
    <!-- start Table -->
    <table  class="min-w-full border-collapse block  md:table md:rounded-md">
		<thead class="block  md:table-header-group">
			<tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th class=" bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">วันที่</th>
                <th class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">จำนวน</th>
                <th class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">ผู้ปฎิบัติ</th>
                 <th v-if="can.checkout_item" class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">::</th>
			</tr>
		</thead>
		<tbody class="block md:table-row-group">
			<tr v-for="(item_tran) in $page.props.item_trans" :key=item_tran.id
                class="bg-white my-2 p-2 mb-2 border-2 rounded-md border-gray-500 block md:border-none   md:table-row ">
				<td class="text-left  block md:table-cell   md:border-b-2 md:border-gray-300 "><span class="inline-block w-1/3 md:hidden font-bold">วันที่</span>
                    <span  
                       class="inline-flex px-2  text-lg font-semibold leading-5  ">
                        <svg  v-if="item_tran.action == 'checkin'"
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-4 w-4 text-green-800 bg-green-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                         <svg  v-if="item_tran.action == 'checkout'"
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-4 w-4 text-red-800 bg-red-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                       
                    </span>
                      {{item_tran.date_action}}
                </td>
                <td class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 ">
                    <span class="inline-block w-1/3 md:hidden font-bold">จำนวน</span>
                    {{item_tran.item_count}}
                </td>
                <td class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 "><span class="inline-block w-1/3 md:hidden font-bold">ผู้ปฎิบัติ</span>{{item_tran.user.name}}</td>
                <td v-if="can.checkout_item"
                    class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 ">
                    <span class="inline-block w-1/3 md:hidden font-bold">::</span>
                    <!-- {{ $page.props.can }} -->
                    <label for=""  v-if="item_tran.status != 'active'">{{item_tran.status}}</label>
                    <!-- <button v-if="item_tran.status != 'canceled'"
                        class="  bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button> -->
                    <button v-if="item_tran.status != 'canceled' && item_tran.action != 'checkin' && can.checkout_item"
                        v-on:click="cancel_checkout(item_tran.id)"
                        class=" ml-3 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <label for="" class=" text-red-600 text-sm" >  *ลบได้ภายในวันนั้น</label>  

                </td>
            </tr>
			
		</tbody>
	</table>
    <!-- END table -->
     </AppLayout>
</template>
<script>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    components: {
        AppLayout,
    },
    props:{
        stock_item:Array,
        stock:Array,
        item_trans:Array,
        checkin_last:Array,
        count_name:String,
        can_abilities: { type: Object, required: true },
        can: { type: Object, required: true },
     },
    data(){
        return{
           
        //    stocks:[
		// 		{code:1,name:'aa' },
		// 		{code:2,name:'bb' },	
		// 		{code:3,name:'cc' },		
		// 	],
        }
    },
    methods:{
        cancel_checkout(item_tran_id){
            console.log('cancel checkout item='+item_tran_id);
        }
    }

    // setup() {
    
    //     return { };
    // },
}

</script>