<template>
 <div class=" py-2 font-bold"> {{purchaseOrder.stock['stockname']}}</div>
        <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:justify-between"> 
            <p class=" text-red-700 font-bold">วันที่สั่งซื้อ: {{date_purchase}}</p> 
            <!-- <p class=" bg-none md:bg-green-200  md:px-2  md:mx-4 text-red-700 font-bold rounded-md" >
                    สถานะ:{{purchaseOrder.status}}
            </p>
           -->
            <span
                class="inline-flex px-2 text-sm font-semibold leading-5 text-red-900 bg-red-200 rounded-md"
            >
                <span v-if="purchaseOrder.status=='created'" >ยังไม่ส่งไปภาคฯ</span>
                <span v-if="purchaseOrder.status=='sended'" >รอภาคฯอนุมัติ</span>
                <span v-if="purchaseOrder.status=='approved'" >ภาคฯอนุมัติแล้ว</span>
                <span v-if="purchaseOrder.status=='received'"  >ตรวจรับวัสดุแล้ว</span>
                <span v-if="purchaseOrder.status=='received' && purchaseOrder.timeline['create_by']=='admin'" > บันทึกข้อมูลย้อนหลัง</span>
            </span>
           
        </div>
        <div> ๑.ชื่อโครงการ:{{purchaseOrder.project_name}} จำนวน {{purchaseOrder.items.length}} รายการ</div>
        <div> ๒.วงเงินงบประมาณ:{{budget_show}} บาท</div>
        <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            <p class=" text-green-600 font-bold text-sm" > คุณ{{purchaseOrder.user.name}} ({{purchaseOrder.user.profile['division_name']}})</p>
            <p class=" px-2 text-gray-600 text-sm">ผู้บันทึกข้อมูล</p>
        </div>
        <div class=" flex flex-col space-y-2  md:flex-row md:space-y-0 ">
            <!-- <a :href="route('print-purchase-order',purchaseOrder.id)" 
                v-if="$page.props.auth.user.profile.division_id==purchaseOrder.unit_id"
                    target="blank">
                <span
                    class="inline-flex text-sm py-1 px-2  leading-5 text-white bg-blue-500 rounded-md"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                        พิมพ์แบบ บก.๐๖
                </span>
            </a> -->
            <a :href="route('print-purchase-order-item',purchaseOrder.id)"  target="blank"
                    class="inline-flex text-sm  md:ml-3   bg-blue-200 border hover:bg-blue-500  border-blue-500 py-1 px-2   rounded">
                <div class="flex items-center" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                        พิมพ์รายการวัสดุสั่งซื้อ
                </div>
            </a>

            <!-- for admin -->
            <button v-if="purchaseOrder.status == 'sended' &&  
                    $page.props.auth.user.profile.division_id==27"
                        v-on:click="confirmApprovePurchaseOrder(purchaseOrder)"
                class=" inline-flex text-sm md:ml-3 bg-green-200 hover:bg-green-500   py-1 px-2 border border-green-500 rounded">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                อนุมัติ
            </button>    
            <button v-if="purchaseOrder.status == 'sended' &&  
                    $page.props.auth.user.profile.division_id==27"
                        v-on:click="confirmReturnPurchaseOrder(purchaseOrder)"
                class=" inline-flex text-sm md:ml-3 bg-yellow-100 hover:bg-yellow-500   py-1 px-2 border border-yellow-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                ส่งคืนเพื่อแก้ไข
            </button>   

            <!-- for officer division -->
            <button v-if="purchaseOrder.status == 'created' &&  
                    $page.props.auth.user.profile.division_id==purchaseOrder.unit_id"
                        v-on:click="confirmSendOrder(purchaseOrder)"
                class=" inline-flex text-sm md:ml-3 bg-green-200 hover:bg-green-500   py-1 px-2 border border-green-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                ส่งเอกสารสั่งซื้อ
            </button>    

            <button v-if="purchaseOrder.status == 'created' &&  
                    $page.props.auth.user.profile.division_id==purchaseOrder.unit_id"
                class=" inline-flex text-sm md:ml-3 bg-yellow-200 hover:bg-yellow-700   py-1 px-2 border border-yellow-500 rounded"
                @click="editOrderPurchase(purchaseOrder.id)"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                แก้ไข
            </button>

            <button v-if="purchaseOrder.status == 'created' &&  
                    $page.props.auth.user.profile.division_id==purchaseOrder.unit_id"
                class=" inline-flex text-sm md:ml-3 bg-red-300 hover:bg-red-700   py-1 px-2 border border-red-500 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                ลบ
            </button>

          
            <a :href="route('receive-order-purchase',purchaseOrder)" 
                v-if="purchaseOrder.status == 'approved' &&  
                    $page.props.auth.user.profile.division_id==purchaseOrder.unit_id" >
                <span
                    class="flex flex-row text-sm py-1 px-2 ml-3  leading-5 text-white bg-green-500 hover:bg-green-700 rounded"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                </svg>
                ตรวจรับวัสดุ
                </span>
            </a>
        </div>

        <ModalUpToYou :isModalOpen="confirm_send_order" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการส่งเอกสารใบสั่งซื้อวัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                    <!-- <label v-for="(confirm_item,index) in confirm_items" :key=confirm_item.id
                            class="  flex  justify-start w-full bg-red-100 text-sm text-red-900">
                        {{index+1}}.{{confirm_item[0].item_name}} จำนวน {{confirm_item[0].order_input}} x {{confirm_item[0].price}}  เป็นเงิน {{confirm_item[0].total}} บาท
                    
                    </label> -->
                    <label for="">วงเงินงบประมาณ {{confirm_budget}} บาท</label>
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

        <ModalUpToYou :isModalOpen="confirm_approve_order" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการอนุมัติใบสั่งซื้อวัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                    <label 
                            class="  flex  justify-start w-full text-sm text-red-900">
                        <!-- ใบสั่งซื้อเลขที่:{{confirm_order_no}}/{{form.confirm_order_year}} ของ {{form.confirm_stockname_order}} -->
                        วงเงินงบประมาณ {{confirm_approve_budget}} บาท
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okConfirmApprovePurchaseOrder"
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

        <ModalUpToYou :isModalOpen="confirm_return_order" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการส่งคืนใบสั่งซื้อวัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                    <label 
                            class="  flex  justify-start w-full text-sm text-red-900">
                        <!-- ใบสั่งซื้อเลขที่:{{confirm_order_no}}/{{form.confirm_order_year}} ของ {{form.confirm_stockname_order}} -->
                        วงเงินงบประมาณ {{confirm_approve_budget}} บาท
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okConfirmReturnPurchaseOrder"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelReturnOrder"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>
  
</template>
<script setup>
import { router } from '@inertiajs/vue3';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref,computed } from "vue"
//const { onMounted, ref,computed }=require("@vue/runtime-core");

const props = defineProps({
      purchaseOrder:{type:Object,required:true},
})

const form = useForm({
    order_id:0,
    order_action:'',
})

const budget_show = ref(0);

const confirm_send_order=ref(false);
const confirm_budget=ref(0);
const confirm_approve_order=ref(false);
const confirm_approve_budget=ref(0);
const confirm_return_order=ref(false);

const confirmSendOrder=(order)=>{
    //console.log(order);
    confirm_send_order.value = true;
    confirm_budget.value = order.budget;
    form.order_id = order.id;
    form.order_action = 'sended';
           
}

const  cancelSendOrder=()=>{
    confirm_send_order.value = false;
}

const okConfirmSendOrder=(order)=>{
    confirm_send_order.value = false;
    // console.log(form.order_id);
       console.log(order);
 
    
      form.post(route('send-order-purchase',form.order_id), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
}

const confirmApprovePurchaseOrder=(order)=>{
    // console.log('confirmApproveOrder');
        // console.log(order);
        // console.log(order.id);
        // console.log(order.stock['stockname']);
    
    confirm_approve_order.value = true;
    confirm_approve_budget.value = order.budget;
    form.order_id = order.id;
    form.order_action = 'approved';
    // form.confirm_order_year = order.year;
    // form.confirm_stockname_order = order.stock['stockname'];
          
}
const cancelApproveOrder=()=>{
    confirm_approve_order.value = false;
}

const okConfirmApprovePurchaseOrder=()=>{
    confirm_approve_order.value = false;
    // console.log('OK ApproveOrder');
     console.log(form.order_id);
    console.log(form.order_action);
    
    form.post(route('approve-order-purchase',form.order_id), {
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
           
}

const confirmReturnPurchaseOrder=(order)=>{
     console.log('confirmReturnPurchaseOrder');
      
    confirm_return_order.value = true;
    confirm_approve_budget.value = order.budget;
    form.order_id = order.id; 
    form.order_action = 'created';
}
const cancelReturnOrder=()=>{
    confirm_return_order.value = false;
}
const okConfirmReturnPurchaseOrder=()=>{
    confirm_approve_order.value = false;
    // console.log('OK ApproveOrder');
     console.log(form.order_id);
    console.log(form.order_action);
    
    form.post(route('approve-order-purchase',form.order_id), {
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
           
}
onMounted(() => {
    budget_show.value = props.purchaseOrder['budget'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")

})

const editOrderPurchase=(purchase_order_id)=>{
    console.log('editOrderPurchase');
    console.log(purchase_order_id);

    Inertia.visit(route('get-edit-order-purchase'),{
       method: 'post',
        data: {
            id: purchase_order_id,
        },
   })
}

const date_purchase = computed(()=>{
    //console.log(props.stockBudget.budget)
    let thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    //let output = props.purchaseOrder.date_order.split('-').reverse().join('/');
    let date_arr = props.purchaseOrder.date_order.split('-');

    let month = thaimonth[parseInt(date_arr[1])];
    let year = parseInt(date_arr[0])+543;
    let output = parseInt(date_arr[2]) + ' ' + month + ' ' + year;
    return output;
})

// const confirmSendOrder=(order)=>{
//     console.log(order);
//     Inertia.visit(route('send-order-purchase'),{
//         method: 'post',
//         data: {
//             id: order.id,
//         },
//     })
           
// }

</script>
