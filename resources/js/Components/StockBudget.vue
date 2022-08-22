<template>
          <div >
            <!--Header Alert-->
            <!-- <div v-if="$page.props.flash.status=='success'" 
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
            </div> -->
         
            <div 
                class="  py-2 border-b-2 border-red-300"
                >
                <div class="flex justify-between">
                    <div class="">
                        <label class=" font-bold"> {{stockIndex+1}}.  {{stockBudget.stockname}}   </label>   
                    </div>
                    <!-- <div v-if="stockBudget.budget['budget_add']==0" class=" px-3 bg-green-200 rounded-md">
                        บันทึก
                    </div>
                    <div v-else class=" px-3 bg-yellow-200  rounded-md">
                        แก้ไข
                    </div> -->
                </div>
                <!-- {{stockBudget}} -->
                <div v-if="stockBudget.budget['budget_add']==0" 
                    class="flex justify-between px-3 " >
                        <!-- <div class="px-3">
                            <label  class=" ">
                            ไม่พบข้อมูลงบประมาณ
                            </label>
                           
                        </div> -->
                        <div>
                             <label  class=" ">
                            ระบุงบประมาณ:
                            </label>
                             <input type="number" 
                                class=" rounded-md "
                                v-model="form.budget_input"
                                >
                        </div>
                        <div  class=" p-2 mr-2 ">
                            <!-- บันทึก -->
                              <button
                                class=" flex justify-center py-1 px-2 bg-green-200 text-green-900 rounded-md shadow-md hover:bg-green-300 focus:outline-none"
                                v-on:click="confirmAddBudget"
                                >
                                บันทึก
                            </button>
                        </div>
                </div>
                <!-- {{stockBudget.budget['budget_add']}} -->
                <div v-if="stockBudget.budget['budget_add']!=0"  
                    class="flex justify-between px-3 ">
                    <div>
                         <label class=" px-3 text-green-600 font-bold">
                        ได้อนุมัติ  {{budget_add}} บาท 
                        </label>
                    </div>
                    <div class="flex px-2 ">
                        <div v-if="stockBudget.budget['budget_add']!=0 && stockBudget.orders.length==0 &&  stockBudget.purchase_orders.length==0" 
                            class="px-3 ">
                             <button
                                class=" flex justify-center py-1 px-2 bg-yellow-200 text-yellow-900 rounded-md shadow-md hover:bg-yellow-300 focus:outline-none"
                                v-on:click="editBudget"
                                >
                                แก้ไข
                            </button>
                        </div>
                        <div v-if="stockBudget.orders.length>0 || stockBudget.purchase_orders.length>0  " class="flex mr-2">
                            <button
                                class=" flex justify-center py-1 px-2 bg-blue-200 text-blue-900 rounded-md shadow-md hover:bg-blue-300 focus:outline-none"
                                v-on:click="viewAllOrder()"
                                >
                                ดูรายการเบิก
                            </button>
                              <a :href="route('print-budget-order',{stock_id:stockBudget.id,year:budgetYear})"
                                v-if="stockBudget.budget['budget_add'] !=0"
                                target="blank" class=" ">
                                 <span
                                        class="inline-flex text-sm ml-2 py-1 px-3  leading-5 text-white bg-blue-500 rounded-md shadow-lg hover:bg-blue-700 "
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                                        </svg>
                                     พิมพ์
                                 </span>
                              </a>
                            <!-- <button
                                class=" flex justify-center px-2 ml-2 bg-blue-200 text-blue-900 rounded-md shadow-md hover:bg-blue-300 focus:outline-none"
                                >
                                เพิ่มงบประมาณ
                            </button> -->
                        </div>
                        
                    </div>
                    
                </div>
                <div v-if="view_order">
                    <!-- {{stockBudget.orders.length}} -->
                    <div v-if="stockBudget.orders.length!=0">
                         <label class=" px-6 font-bold">รายการใบสัญญาสั่งซื้อ</label>
                        <BudgetOrder  v-for="(order,index) in stockBudget.orders" :key="order.id" 
                            :orderIndex="index"
                            :orderItem="order"
                            >
                        </BudgetOrder>
                    </div>
                    <div v-if="stockBudget.purchase_orders.length!=0"
                        class="mt-2"
                        >
                         <label class=" px-6 font-bold">รายการใบสั่งซื้อ</label>
                        <PurchaseOrder v-for="(purchase_order,index2) in stockBudget.purchase_orders" :key="purchase_order.id"
                            :orderIndex="index2"
                            :orderItem="purchase_order"
                        />
                    </div>
                   
          
                </div>
                <div v-if="stockBudget.budget['budget_add']!=0" class=" px-3">
                    <label class=" px-3 text-red-600 font-bold"> 
                        คงเหลือ  {{budget_balance}}บาท
                    </label>
                </div>
            </div>
        </div>

        
    <ModalUpToYou :isModalOpen="confirm_add_budget" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">คุณต้องการบันทึกงบประมาณใช่หรือไม่?</p> 
                                    
        </template>
        <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium dark:text-white">
                <div for="">
                    {{form.stock_name}} 
                </div>
                <div>
                    ปีงบ:{{form.budget_year+543}} 
                </div>
                 <div for="">
                    จำนวน {{budget_confirm_show}} บาท
                </div>
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="okConfirmAddBudget"
                    >
                    ตกลง
                </button>
                <button 
                    class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    v-on:click="cancelAddBudget"
                >
                    ยกเลิก
                </button>
            </div>
        </template>
    </ModalUpToYou>

    <ModalUpToYou :isModalOpen="confirm_edit_budget" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">แก้ไขงบประมาณ</p> 
                                    
        </template>
        <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium dark:text-white">
                <div for="">
                    {{form.stock_name}} 
                </div>
                <div>
                    ปีงบ:{{form.budget_year+543}} 
                </div>
                 <div for="">
                     <input type="number"  class=" rounded-md " v-model="form.budget_edit">
                </div>
            </div>
        </template>

        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="okConfirmEditBudget"
                    >
                    ตกลง
                </button>
                <button 
                    class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                    v-on:click="cancelEditBudget"
                >
                    ยกเลิก
                </button>
            </div>
        </template>
    </ModalUpToYou>

    <ModalUpToYou :isModalOpen="show_alert_msg" >
        <template v-slot:header>
            <p class="text-md font-bold text-red-600 ">กรุณาอ่าน </p> 
                                    
        </template>
        <template v-slot:body>
            <div class="w-full flex flex-col text-gray-900 text-md font-medium dark:text-white">
                <div for="">
                 {{ $page.props.flash.status }}:{{ $page.props.flash.msg }} 
                
                </div>
            </div>
        </template>
 
        <template v-slot:footer>
            <div class=" w-full  text-center  md:block">
                <button 
                    class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                    v-on:click="closeAlert"
                    >
                    ตกลง
                </button>
              
            </div>
        </template>
    </ModalUpToYou>
    
</template>
<script setup>
import BudgetOrder from '@/Components/BudgetOrder.vue';
import PurchaseOrder from '@/Components/PurchaseOrder.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
const { ref, computed }=require("@vue/reactivity")
const { onMounted, watch }=require("@vue/runtime-core")

const props = defineProps({
    stockIndex:{type:Number,required:true},
    stockBudget:{type:Object,required:true},
    budgetYear:{type:Number,required:true},
})

//const budget_add = ref(0);
//const budget_balance = ref(0);
const view_order=ref(false);
const confirm_add_budget=ref(false);
const budget_confirm_show = ref(0);
const show_alert_msg=ref(false);

const confirm_edit_budget=ref(false);


const form = useForm({
    stock_id:{type:Number},
    stock_name:{type:String},
    budget_year:{type:Number},
    budget_input:{type:Number,defaulte:0},
    budget_edit:{type:Number,defaulte:0},
  //  budget_edit:{type:Object},

})


const budget_add = computed(()=>{
    //console.log(props.stockBudget.budget)
    return  props.stockBudget.budget['budget_add'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
})

const budget_balance = computed(()=>{
     if(props.stockBudget.budget['budget_add']!=0){
      //  console.log('balance_budget-->'+props.stockBudget.balance_budget);
       return  props.stockBudget.balance_budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
       // console.log(budget_balance.value);
    }else{
        return '0';
    }
})

const viewAllOrder=()=>{
    view_order.value=!view_order.value;
}

const confirmAddBudget=(order)=>{
  //  console.log(order);
    confirm_add_budget.value = true;
    form.stock_id = props.stockBudget.id;
    form.stock_name = props.stockBudget.stockname;
    form.budget_year = props.budgetYear;
    budget_confirm_show.value = form.budget_input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           
}

const  cancelAddBudget=()=>{
    confirm_add_budget.value = false;
}

const  closeAlert=()=>{
     console.log('close alert='+form.budget_year);
    show_alert_msg.value = false;
    Inertia.visit(route('budget-list'));
//    Inertia.visit(route('get-list-budget',{year:form.budget_year}),{
//        method: 'get',
//    })
    //  axios.get(route('get-list-budget',{year:form.year_selected})).then(res => {
    //    // console.log(res.data.stocks);
    //     stock_budgets.value = res.data.stocks;   
    // });
}

const okConfirmAddBudget=()=>{
    confirm_add_budget.value = false;
    form.stock_id = props.stockBudget.id;
    form.budget_year = props.budgetYear;
    form.post(route('add-budget'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: page => { 
                console.log('success');
                show_alert_msg.value = true;
                },
            onError: errors => { 
                console.log('error');
                  show_alert_msg.value = true;
            },
            onFinish: visit => { 
                console.log('finish');
            },
    })
    
}

const editBudget=()=>{
    console.log('edit budget');
    form.stock_id = props.stockBudget.id;
    form.stock_name = props.stockBudget.stockname;
    form.budget_year = props.budgetYear;
    form.budget_edit = props.stockBudget.budget['budget_add'];
    confirm_edit_budget.value = true;

    //form.budget_edit= props.stockBudget.budget;
    // Inertia.visit(route('edit-budget'),{
    //     method: 'get',
    //     data: {budget:props.stockBudget.budget},
    // });
}

const okConfirmEditBudget=()=>{
      confirm_edit_budget.value = false;
       form.post(route('edit-budget'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: page => { 
                console.log('success');
                show_alert_msg.value = true;
                console.log(form.budget_year);
                },
            onError: errors => { 
                console.log('error');
                  show_alert_msg.value = true;
            },
            onFinish: visit => { 
                console.log('finish');
            },
    })

}

const  cancelEditBudget=()=>{
    confirm_edit_budget.value = false;
}
   


</script>
