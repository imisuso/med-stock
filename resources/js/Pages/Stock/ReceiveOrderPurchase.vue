<template>
    <AppLayout>
  

        <div class=" bg-blue-50">
            <div class=" w-full flex justify-center font-bold  ">บันทึกการตรวจรับวัสดุจากใบสั่งซื้อ</div>
            <div class=" w-full flex justify-center font-bold  ">{{$page.props.auth.user.profile.division_name}}</div>
            <div class="w-full flex justify-center p-2 my-2  border-b-2 border-gray-600 " >
                <div class=" w-full  ">
                    <div>วันที่สั่งซื้อ: <label class=" text-blue-700 font-bold">{{date_thai}}</label></div>
                    <div>ชื่อโครงการ: <label class=" text-blue-700 font-bold">{{order.project_name}}</label></div>
                    <div>จำนวน:<label class=" text-blue-700 font-bold">{{order.items.length}}</label>  รายการ</div>
                    <div>วงเงินงบประมาณ:<label class=" text-blue-700 font-bold">{{approve_budget}}</label> บาท</div>
                </div>
                <div v-if="order.status == 'checkin'"
                    class=" flex justify-center text-green-700 text-lg"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    ตรวจรับวัสดุเรียบร้อยแล้ว
                </div>
               
            </div>
        </div>

         <!-- <ShowReceivePurchaseOrder /> -->
        <div v-for="(order,key) in order.items" :key="order.id"
                class=" m-2 p-2 border-b-2 border-blue-700  shadow-md"
                >
                <ShowReceivePurchaseOrder 
                    :item-index="key"
                    :purchase-order="order[0]"
                    :old-items-sum="old_items_sum"
                />
               
        </div>
        <!-- <div class=" bg-green-200">
            {{old_items_sum}}
        </div> -->
        <div class="w-full flex justify-center">
            <button
                 class=" flex justify-center px-4 py-1   text-sm  text-white bg-red-500 rounded-md hover:bg-green-400 focus:outline-hidden"
            >
            ตรวจรับทั้งหมด?
            </button>
        </div>


       
        
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ShowReceivePurchaseOrder from '@/Components/ShowReceivePurchaseOrder.vue';
import {ref, onMounted ,computed} from 'vue';

const props = defineProps({
      order :{type:Object , required:true},
      old_items_sum : {type:Array},
})
const approve_budget = ref(0);

onMounted(() => {
   // console.log('Component BudgetOrder');
   // console.log(props.orderItem.timeline['approve_budget'])
    approve_budget.value = props.order['budget'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
   //  console.log(approve_budget.value)
})

const date_thai = computed(()=>{
    //console.log(props.stockBudget.budget)
    let thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    //let output = props.purchaseOrder.date_order.split('-').reverse().join('/');
    let date_arr = props.order.date_order.split('-');

    let month = thaimonth[parseInt(date_arr[1])];
    let year = parseInt(date_arr[0])+543;
    let output = parseInt(date_arr[2]) + ' ' + month + ' ' + year;
    return output;
})
</script>