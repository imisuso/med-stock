<template>
    <AppLayout>
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
        <div class=" w-full flex justify-center">
                <label class="text-lg font-bold">รายการใบสั่งซื้อ</label>
        </div>
        <div class=" w-full  bg-blue-100 p-2 rounded-md ">
            <div class="bg-blue-800 text-white text-xl text-center ">
                {{$page.props.auth.user.profile.division_name}}
            </div>
       
         
        </div>
        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ระบุปีงบประมาณ:</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    @Change="getListPurchase"
                    >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>
           
        </div>
        <div v-if="$page.props.auth.user.profile.division_id < 20" class="flex flex-col p-2 bg-yellow-100">
            <label class=" font-bold text-red-500">ขั้นตอน/คำแนะนำ:(ให้ user ยืนยันขั้นตอนการทำงาน)</label>
            <label >1.กดปุ่มส่งเอกสารสั่งซื้อ เพื่อส่งให้สำนักงานภาคฯ</label>
            <label >2.หลังจากหัวหน้าภาคฯอนุมัติแล้ว จึงจะเห็นปุ่มตรวจรับพัสดุ </label>
            <label >3.เมื่อได้รับพัสดุแล้ว จึงมากดปุ่มตรวจรับพัสดุ </label>
        </div>
        <!-- search word in data -->
         <!-- <div v-if="$page.props.auth.user.profile.division_id > 20">
                <input type="text" placeholder="พิมพ์คำที่ต้องการค้นหา จากชื่อคลังพัสดุ/วันที่สั่งซื้อ/ผู้บันทึกข้อมูล" 
                 @keyup="purchase_filter" v-model="filter_key" 
                    class="mt-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-500 rounded-md">
        </div> -->


        <!-- <div v-if="show_purchase_orders.length !=0" class=" w-full  py-4"> -->
            <div v-if="purchase_orders" class=" w-full  py-4">
              <paginateMe :pagination="purchase_orders" />
            <!-- <div v-for="(purchase_order) in show_purchase_orders.data" :key="purchase_order.id"
                class=" m-2 p-2 bg-pink-50 border-b-2 border-pink-600 rounded-md shadow-md"
                >
                <ShowPurchaseOrder 
                    :purchase-order="purchase_order"
                />
               
            </div> -->
            <div v-for="(purchase_order) in purchase_orders.data" :key="purchase_order.id"
                class=" m-2 p-2 bg-pink-50 border-b-2 border-pink-600 rounded-md shadow-md"
                >
                <ShowPurchaseOrder 
                    :purchase-order="purchase_order"
                />
               
            </div>
           
        </div>
     
     
        
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ShowPurchaseOrder from '@/Components/ShowPurchaseOrder.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';
const props = defineProps({
  years:{type:Object},
  year_selected : {type:Number},
  purchase_orders : {type:Object},
})
console.log('year_selected='+ props.year_selected);
const filter_key=ref('');
//const purchase_orders = ref([]);

const form = useForm({
    year_selected: props.year_selected ? props.year_selected : '',
})

//const show_purchase_orders = props.purchase_orders ? ref(props.purchase_orders) : ref([]);



const getListPurchase = () => {
    console.log('getListPurchase');


    Inertia.get(route('purchase-order-list'), { year: form.year_selected }, {
        preserveState: true,
        replace: true
    })
   // forceUpdate();
}

const purchase_filter = () => {
  console.log(filter_key.value)
 // purchaseOrder.stock['stockname']
  let filter_purchase = props.purchase_orders.data.filter( (elmt) => {

    if( elmt.stock['stockname'].match(filter_key.value) 
        || elmt.project_name.match(filter_key.value)   
        || elmt.user.name.match(filter_key.value) 
        || date_purchase_convert(elmt.date_order).match(filter_key.value)
        ) {
      return elmt
    }
  })

}

const date_purchase_convert = (date_order)=>{
    //console.log(props.stockBudget.budget)
    let thaimonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    //let output = props.purchaseOrder.date_order.split('-').reverse().join('/');
    let date_arr = date_order.split('-');

    let month = thaimonth[parseInt(date_arr[1])];
    let year = parseInt(date_arr[0])+543;
    let output = parseInt(date_arr[2]) + ' ' + month + ' ' + year;
    return output;
}

</script>