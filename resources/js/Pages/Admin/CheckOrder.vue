<template>
    <AppLayout>
        <!--Header Alert-->
        <div v-if="$page.props.flash.status=='success'" 
            class="alert-banner  fixed  right-0 m-2 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>

       <!-- <h4   class=" mt-3 text-center text-red-600">ระบุปีและเดือน ที่ต้องการดูรายงาน</h4>
        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ปี พ.ศ.</label>
                <select name="" id="" v-model="year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>
            <div  class=" m-2">
                <label for="">เดือน</label>
                <select name="" id="" v-model="month_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                    <option v-for="(month) in  months" :key=month.id v-bind:value="month.id">{{month.name}}</option>
                </select>
                
            </div>  
            
        </div> -->
        <!-- <div class="flex flex-col  ">
          
            <button 
                class=" flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
            >
                ค้นหา
            </button>
        </div> -->

     
     
        <!-- show order lists -->
         <!-- <h1 class="p-2 mt-3 text-center" >รายการใบสั่งซื้อพัสดุจากสาขา/หน่วย</h1>
         <h1 class=" text-center" >(ณ เดือนปีปัจจุบัน)</h1> -->
        <div class=" flex justify-between my-2 ">
            <div class=" font-bold" >รายการใบสั่งซื้อพัสดุ จากสาขา/หน่วย</div>
            <div >
                <select name="" id=""
                    class=" w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow  focus:outline-none focus:shadow-outline"
                >
                    <option value="">รายการทั้งหมด</option>
                    <option value="">รายการที่ยังไม่ส่งมาภาคฯ</option>
                    <option value="">รายการที่ยังไม่ได้อนุมัติ</option>
                    <option value="">รายการที่อนุมัติแล้ว</option>
                    <option value="">รายการที่ถูกตรวจรับพัสดุแล้ว</option>
                </select>
            </div>
        </div>

        <div v-if="order_lists.length==0"
            class=" flex justify-center text-red-600"
            >
            <label for="">ไม่พบรายการใบสั่งซื้อพัสดุ</label>
        </div>

        <OrderDetail v-for="(order_list,key) in order_lists" :key=order_list.id 
            :orderIndex="key" 
            :orderList="order_list" 
        >
            <template v-slot:stockname>
                <p class="text-md font-bold text-red-600 ">{{order_list.stock['stockname']}}</p> 
                                        
            </template>
            <template v-slot:messagesuggest>
                <span v-if="order_list.status == 'created'" class=" text-sm text-red-500">รอสาขา/หน่วยกดปุ่มส่งเอกสารสั่งซื้อ และส่งเอกสารตัวจริงมาที่ภาควิชาฯ </span>
                <span v-if="order_list.status == 'send'" class=" text-sm text-red-500">เมื่อหัวหน้าภาควิชาฯ เซ็นอนุมัติแล้ว ให้กดปุ่มอนุมัติ</span>
                <span v-if="order_list.status == 'approve'" class=" text-sm text-red-500">
                    รอสาขา/หน่วย ตรวจรับพัสดุ ภายใน 7 วันทำการ นับจากวันที่ได้รับอนุมัติ    
                </span>
            </template>
            <template v-slot:buttongroup>
                     <a :href="route('print-checkin',order_list.id)" v-if="order_list.status == 'checkin'" target="blank">
                                <span
                                    class="flex flex-row text-sm py-1 px-2 leading-5 text-white bg-yellow-500 rounded-md"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                    </svg>
                                    เอกสารตรวจรับพัสดุ
                                </span>
                            </a>
                             <a :href="route('print-checkin',order_list.id)" v-if="order_list.status == 'checkin'" target="blank">
                                <span
                                    class="flex flex-row text-sm ml-2 py-1 px-2 leading-5 text-white bg-green-600 rounded-md"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                </svg>
                                    บันทึกข้อมูลลงระบบ SAP แล้ว
                                </span>
                            </a>
                            
                            <button v-if="order_list.status == 'send'"
                                v-on:click="confirmApproveOrder(order_list)"
                                class=" inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white py-1 px-4 border border-green-500 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                อนุมัติ
                            </button>
            </template>

        </OrderDetail>
<!-- {{order_lists}} -->
        <ModalUpToYou :isModalOpen="confirm_approve_order" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการอนุมัติใบสัญญาสั่งซื้อพัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                    <label 
                            class="  flex  justify-start w-full text-sm text-red-900">
                        ใบสั่งซื้อเลขที่:{{confirm_order_no}}/{{form.confirm_order_year}} ของ {{form.confirm_stockname_order}}
                    
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okConfirmApproveOrder"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelApproveOrder"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
    </ModalUpToYou>


    

        <!-- Modal show checkin order -->
        <!-- {{show_view_checkin}} -->
        <!-- <div >
            <div v-for="(item) in view_checkin" :key=item.stock_item_id>
                    {{item}}
            </div>
             
        </div> -->
      

    </AppLayout>
</template>
<script setup>
//import { ref } from 'vue';
//import { usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import OrderDetail from '@/Components/OrderDetail.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import { ref } from '@vue/reactivity';

defineProps({
        order_lists:Array,
        view_checkin:Array,
        years:[2022,2021,2020,2019,2018],
})

const confirm_approve_order=ref(false)
const confirm_order_no=ref(0);

const form = useForm({
    confirm_order_id:0,
    confirm_order_year:0,
    confirm_stockname_order:'',
})

const confirmApproveOrder=(order)=>{
    // console.log('confirmApproveOrder');
        // console.log(order);
        // console.log(order.id);
        // console.log(order.stock['stockname']);
    
    confirm_approve_order.value = true;
    confirm_order_no.value = order.order_no;
    form.confirm_order_id = order.id;
    form.confirm_order_year = order.year;
    form.confirm_stockname_order = order.stock['stockname'];
          
}

const cancelApproveOrder=()=>{
    confirm_approve_order.value = false;
}

const okConfirmApproveOrder=()=>{
    confirm_approve_order.value = false;
    // console.log('OK ApproveOrder');
    // console.log(form.confirm_order_id);
    
    form.post(route('approve-order'), {
            preserveState: false,
            preserveScroll: true,
            onSuccess: page => { 
                console.log('success');
                },
            onError: errors => { 
                console.log('error');
            },
            onFinish: visit => { console.log('finish');},
    })
            // Inertia.post(route('approve-order'), 
            //                  { 
            //                      order_id:this.confirm_order_id,
            //                   },
            //                   {
            //                       preserveState: false,
            //                     //   preserveScroll: true
            //                   }
            //                  );
}
/*************Old Script**********************/
// export default {
//     components: {
//         AppLayout,
//         Link,
//     },
//     props:{
//         // stocks:Array,
//         // unit:Array,
//         order_lists:Array,
//         view_checkin:Array,
//     },
//     data(){
//         return{
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
//             confirm_approve_order:0,
//             confirm_stockname_order:'',
//             confirm_order_id:0,
//             confirm_order_year:0,
//             show_view_checkin:0,
//             view_items:Array,
//             view_order:0,
//         }
//     },
//     methods:{
//         confirmApproveOrder(order){
//              console.log('confirmApproveOrder');
//              console.log(order);
//              console.log(order.id);
//              console.log(order.stock['stockname']);
          
//             this.confirm_approve_order = 1;
//             this.confirm_order_id = order.id;
//             this.confirm_order_year = order.year;
//             this.confirm_stockname_order = order.stock['stockname'];
          
//         },
//         cancelSendOrder(){
//             this.confirm_approve_order = 0;
//         },
//         okConfirmApproveOrder(){
//             this.confirm_approve_order = 0;
//             console.log('OK ApproveOrder');
//             console.log(this.confirm_order_id);
//             Inertia.post(route('approve-order'), 
//                              { 
//                                  order_id:this.confirm_order_id,
//                               },
//                               {
//                                   preserveState: false,
//                                 //   preserveScroll: true
//                               }
//                              );
//         },
//         viewCheckinOrder(order_id){
//             console.log(order_id);
//             this.show_view_checkin=1;
//               console.log(this.show_view_checkin);
//             Inertia.get(route('view-checkin-order',order_id), 
//                               {
//                                   preserveState: false,
//                                 //   preserveScroll: true
//                               },
//                               { only: ['view_checkin'] }
//                              );

//         },
//         viewDetailItem(index,items){
//             // console.log(index);
//             // console.log(items);
//             this.view_items=items;
//             this.view_order=index;
//         }
//     }

// }

</script>
