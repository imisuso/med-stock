<template>
    <div  class="mt-5">
        <div class="w-full mt-4 lg:max-w-full lg:flex">
            <div
                class="w-full flex flex-col justify-between p-4 leading-normal bg-blue-50 border rounded-md shadow-lg   "
                >
                <div class=" text-sm font-bold ">
                           <slot name="stockname"></slot>
                </div>
                <div class=" flex justify-between border-b-2 border-blue-500  py-1 mb-2">
                    <p  class="flex items-center font-bold  ">
                        {{orderIndex+1}}.เลขที่ใบสัญญาสั่งซื้อ:{{orderList.create_no}}/{{orderList.year}}
                    </p>
                    <p v-if="orderList.status == 'approved' || orderList.status == 'checkin'" class=" font-bold  ">
                         ใช้งบไป: {{orderList.timeline.approve_budget}}  บาท
                    </p>
                    <Link >
                            <span
                                class="inline-flex px-2 text-sm font-semibold leading-5 text-red-900 bg-red-200 rounded-md"
                            >
                               <span v-if="orderList.status=='created'" >ยังไม่ส่งไปภาคฯ</span>
                                <span v-if="orderList.status=='sended'" >รอภาคฯอนุมัติ</span>
                                <span v-if="orderList.status=='approved'" >ภาคฯอนุมัติแล้ว</span>
                                <span v-if="orderList.status=='checkin'"  >ตรวจรับพัสดุแล้ว</span>
                            </span>
                    </Link>
                </div>
                <div class=" flex flex-row ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                     <span class="inline-block w-1/3  font-bold">วันที่สร้างเอกสาร</span> {{orderList.created_at_format}} 
                </div>
                <div v-if="orderList.status != 'created'  " >
                    <!-- arrow1 -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                    </svg>
                </div>
                <div v-if="orderList.status != 'created'  " class=" flex flex-row ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                   
                    <span class="inline-block w-1/3  font-bold">วันที่ส่งใบสัญญาสั่งซื้อ</span>
                    <span v-if="orderList.order_no" class=" px-1" >
                        <span class=" ">{{orderList.timeline['send_datetime']}}</span>
                    </span>
                </div>
                 <div v-if="orderList.status == 'approved' || orderList.status == 'checkin'">
                    <!-- arrow2 -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                    </svg>
                </div>
                 <div v-if="orderList.status == 'approved' || orderList.status == 'checkin'" class=" flex flex-row ">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                     <span class="inline-block w-1/3  font-bold">วันที่อนุมัติ</span> {{orderList.timeline['approve_datetime']}}
                </div>
                 <div v-if=" orderList.status == 'checkin'">
                    <!-- arrow3 -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3" />
                    </svg>
                </div>
                 <div v-if=" orderList.status == 'checkin'" class=" flex flex-row ">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                     <span class="inline-block w-1/3  font-bold">วันที่ตรวจรับพัสดุ</span> {{orderList.timeline['checkin_datetime']}}
                </div>
                
                <div>
                        
                    <div>
                        <label class=" text-red-500 font-bold ">คำแนะนำ:</label>
                         <slot name="messagesuggest"></slot>
                    </div>
                    <div class="flex flex-col ">
                        <div class="flex flex-row">
                            <span class="  font-bold">รายละเอียด</span>
                             <button
                                class=" flex justify-center px-2  text-white rounded-md hover:bg-blue-200 focus:outline-none"
                                v-on:click="viewDetailItem(orderList.items)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            </button>
                        </div>
                    </div>
                    <div v-if="view_order">
                        <div v-for="(item,index) in view_items" :key=item.id>
                                <span   class=" px-1" >
                                     {{index+1}}.{{item[0].sap}}:{{item[0].item_name}} จำนวน {{item[0].order_input}} ชิ้น ราคาชิ้นละ {{item[0].price}} บาท 
                                     <!-- stock_item_id({{item[0].id}}) -->
                                </span>
                        </div>
                    </div>
                    
                    <div class=" flex justify-center">
                         <slot name="buttongroup"></slot>
                    </div>
                    
                </div>
              
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm">
                    <p class="leading-none text-gray-900">{{orderList.user['name']}}</p>
                    <p class="text-gray-600">ผู้สร้างเอกสาร</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { ref } from '@vue/reactivity';
const props = defineProps({
    orderIndex:{type:Number,required:true},
    orderList:{type:Object,required:true},
})

const view_items=ref(Array);
const view_order=ref(false);


const form = useForm({
    //confirm_order_id:0,
})

const  viewDetailItem=(items)=>{
    // console.log('viewDetailItem==>');
    // console.log(items);
    view_items.value=items;
    // console.log('before==>'+view_order.value);
    view_order.value=!view_order.value;
    // console.log('after==>'+view_order.value);
}

</script>
