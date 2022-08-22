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
        <div v-if="$page.props.errors.error" 
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-700 shadow rounded-md text-white font-bold" title="close" for="banneralert">
                 {{ $page.props.errors.error }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

        <div class=" w-full  bg-blue-100 p-2 rounded-md ">
            <div class="bg-blue-800 text-white text-xl text-center ">
                {{$page.props.unit.unitname}}
            </div>
            <div class="mt-3" >
                <label for="">เลือกคลังพัสดุ</label> 
            </div>
            <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
                <option v-for="(stock) in  $page.props.stocks" :key=stock.id value="{{stock.id}}">{{stock.stockname}}</option>
            </select>
           
        <!-- {{$page.props.stock_items}} -->
        </div>
       
<!-- {{$page.props.order_lists}} -->
     
    <!-- show order lists -->
    <div class=" flex justify-between my-2 ">
            <div class=" font-bold" >รายการใบสัญญาสั่งซื้อพัสดุ</div>
            <div >
                <select name="" id=""
                    class=" w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow  focus:outline-none focus:shadow-outline"
                >
                    <option value="">รายการทั้งหมด</option>
                    <option value="">รายการที่ยังไม่ส่งไปภาคฯ</option>
                    <option value="">รายการที่รอภาคฯอนุมัติ</option>
                    <option value="">รายการที่ภาคฯอนุมัติแล้ว</option>
                    <option value="">รายการที่ตรวจรับพัสดุแล้ว</option>
                </select>
            </div>
    </div>

    <div v-if="order_lists.length==0"
        class=" flex justify-center text-red-600"
        >
        <label for="">ไม่พบรายการใบสัญญาสั่งซื้อพัสดุ</label>
    </div>
    <OrderDetail v-for="(order_list,key) in order_lists" :key=order_list.id 
        :orderIndex="key" 
        :orderList="order_list" 
    >
        <template v-slot:messagesuggest>
            <span v-if="order_list.status == 'created'" class=" text-sm text-red-500">กดปุ่มพิมพ์และเซ็นเอกสาร แล้วส่งเอกสารตัวจริงไปที่ภาควิชาฯ แล้วกดปุ่มส่ง</span>
            <span v-if="order_list.status == 'sended'" class=" text-sm text-red-500">รออนุมัติการสั่งซื้อ จากภาควิชาฯ</span>
            <span v-if="order_list.status == 'approved'" class=" text-sm text-red-500">
                รีบดำเนินการให้บริษัทเซ็นใบสั่งซื้อ+ส่งของ+ตรวจรับ ภายใน 7 วันทำการ นับจากวันที่ได้รับอนุมัติ เมื่อตรวจรับพัสดุตามเอกสารสั่งซื้อแล้ว ให้กดปุ่มตรวจรับพัสดุ แล้วกดปุ่มพิมพ์เอกสารตรวจรับพัสดุและเซ็นเอกสาร แล้วส่งเอกสารตัวจริงไปที่ภาควิชาฯ   
            </span>
        </template>
        <template v-slot:buttongroup>
             <a :href="route('print-order',order_list.id)"  target="blank">
                            <span
                                class="inline-flex text-sm py-1 px-2  leading-5 text-white bg-blue-500 rounded-md"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                </svg>
                                    พิมพ์ใบสั่งซื้อ
                            </span>
                        </a>
                        <a :href="route('print-checkin',order_list.id)" v-if="order_list.status == 'checkin'" target="self">
                            <span
                                class="flex flex-row text-sm py-1 px-2 ml-3 leading-5 text-white bg-yellow-500 rounded-md"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                </svg>
                                เอกสารตรวจรับพัสดุ
                            </span>
                        </a>
                        
                    
                        <button v-if="order_list.status == 'created'"
                            v-on:click="confirmSendOrder(order_list)"
                            class=" inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white  py-1 px-2 border border-green-500 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            ส่งเอกสารสั่งซื้อ
                        </button>
                        <a :href="route('receive-order',order_list)" v-if="order_list.status == 'approved'" >
                            <span
                                class="flex flex-row text-sm py-1 px-2 ml-3  leading-5 text-white bg-green-500 hover:bg-green-700 rounded"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                            </svg>
                            ตรวจรับพัสดุ
                            </span>
                        </a>
                        <button v-if="order_list.status == 'created'"
                            class="flex ml-3 bg-red-500 hover:bg-red-700 text-white d py-1 px-8 text-sm border border-red-500 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            ลบ
                        </button>
        </template>
    </OrderDetail>

    
    <ModalUpToYou :isModalOpen="confirm_send_order" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">คุณต้องการส่งเอกสารการสั่งซื้อพัสดุนี้ใช่หรือไม่?</p> 
                                    
        </template>

        <template v-slot:body>
            <div class="text-gray-900 text-md font-medium dark:text-white">
                 <label v-for="(confirm_item,index) in confirm_items" :key=confirm_item.id
                        class="  flex  justify-start w-full bg-red-100 text-sm text-red-900">
                    {{index+1}}.{{confirm_item[0].item_name}} จำนวน {{confirm_item[0].order_input}} x {{confirm_item[0].price}}  เป็นเงิน {{confirm_item[0].total}} บาท
                
                </label>
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="okConfirmSendOrder"
                    >
                    ตกลง
                </button>
                <button 
                    class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    v-on:click="cancelSendOrder"
                >
                    ยกเลิก
                </button>
            </div>
        </template>
    </ModalUpToYou>
        

    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import OrderDetail from '@/Components/OrderDetail.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';
import { ref } from '@vue/reactivity';

defineProps({
        stocks:Object,
        unit:Object,
        order_lists:Object,
})

// const view_items=ref(Array);
// const view_order=ref(0);
const confirm_send_order=ref(false);
const confirm_items=ref(Array);
//const confirm_order_id=ref(0);

const form = useForm({
    confirm_order_id:0,
})

// const  viewDetailItem=(index,items)=>{
//     // console.log(index);
//     // console.log(items);
//     view_items.value=items;
//     view_order.value=index
// }

const confirmSendOrder=(order)=>{
  //  console.log(order);
    confirm_send_order.value = true;
    confirm_items.value = order.items;
    form.confirm_order_id = order.id;
           
}

const  cancelSendOrder=()=>{
    confirm_send_order.value = false;
}

const okConfirmSendOrder=()=>{
    confirm_send_order.value = false;
    // console.log(form.confirm_order_id);
    form.post(route('send-order'), {
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
