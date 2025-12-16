<template>
    <AppLayout>
        <div class=" my-3 bg-blue-800 text-white text-xl text-center ">
                {{$page.props.unit.unitname}}
        </div>
        <div class=" w-full   p-2 rounded-md ">

            <div class="mt-3 font-bold" >
                <label for="">เลือกคลังวัสดุ</label>
                <label v-if="msg_validate_stock" class=" text-red-600">   !กรุณาเลือกคลังวัสดุ</label>
            </div>
            <select name="" id="" v-model="form.unit_selected"
                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded-xs shadow-xs leading-tight focus:outline-hidden focus:shadow-outline"
                v-on:change="setStockID"
                >
                <option v-for="(stock) in  stocks" v-bind:key=stock.id v-bind:value="stock.id">{{stock.stockname}}</option>
            </select>

        </div>

        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ปี พ.ศ. (ปีปฏิทิน ตามที่มีการบันทึกตัดสต๊อก)</label>
                <label v-if="msg_validate_year" class=" text-red-600">   !กรุณาเลือกปี พ.ศ.</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded-xs shadow-xs leading-tight focus:outline-hidden focus:shadow-outline" >
                    <option v-for="(year,index) in  year_has" :key=index v-bind:value="year.year">{{year.year+543}}</option>
                </select>
            </div>
            <div  class=" m-2">
                <label for="">เดือน</label>
                <label v-if="msg_validate_month" class=" text-red-600">   !กรุณาเลือกเดือน</label>
                <select name="" id="" v-model="form.month_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded-xs shadow-xs leading-tight focus:outline-hidden focus:shadow-outline" >
                    <option v-for="(month) in  months" :key=month.id v-bind:value="month.id">{{month.name}}</option>
                </select>

            </div>

        </div>
        <div class="flex flex-col  ">

            <button v-on:click="getReportStock(form.unit_selected,form.year_selected,form.month_selected)"
                class=" flex justify-center px-8 py-2 mb-2  text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-hidden"
            >
                ดูข้อมูลการเบิก
            </button>
        </div>

        <div  class=" w-full py-3 text-center font-bold text-lg ">
            <label for="">รายงานบันทึกตัดสต๊อก</label>
        </div>
        <div v-if="stock_id !=0"  class=" w-full text-center font-bold text-lg">
            <label for="">

            </label>
        </div>
        <div  class=" w-full py-3 text-center font-bold text-lg ">
            <label for=""> {{month_thai[form.month_selected]}} ปี {{year_thai(form.year_selected)}}</label>
        </div>
        <div v-if="item_trans.length==0" class=" w-full text-center">
            <label for="">ไม่พบข้อมูล</label>
        </div>

        <div>
            <paginateMe :pagination="item_trans" />
            <div
                class="w-full my-3  border-b-4 border-gray-500 shadow-xs hidden lg:block ">
                <div class="flex flex-col  lg:flex-row lg:justify-between  mx-2"  >

                    <div class=" lg:w-5/12 ">
                        SAP-ชื่อวัสดุ:
                    </div>
                    <div class=" lg:w-2/12 ">
                        วันที่หมดอายุ:
                    </div>
                    <div class=" lg:w-2/12  ">
                        วันที่เบิก:
                    </div>

                    <div class=" lg:w-1/12 ">
                        จำนวนที่เบิก:
                    </div>
                    <div class=" lg:w-1/12  ">
                        จำนวนคงเหลือ:
                    </div>
                    <div class=" lg:w-2/12 ">
                        ผู้เบิก:
                    </div>

                </div>
            </div>
        </div>

        <div  class="w-full mt-3  ">

            <div v-for="(item_tran,key) in item_trans.data" :key=item_tran.id
                class="w-full border-b-2   border-gray-500 shadow-xs ">

                <div class="flex flex-col  lg:flex-row   "  >
                    <div class="   lg:w-5/12 lg:text-xs bg-blue-100 lg:bg-transparent  ">
                        <label for="" class="  ">  {{item_trans.from + key}}. </label>
                        <label for="" class="   lg:hidden">SAP:</label>
                        <label class=" font-bold">
                            {{item_tran.stock_item['item_code']}} - {{item_tran.stock_item['item_name']}}
                        </label>

                    </div>
                    <div class=" lg:w-2/12  ">
                        <label for="" class="  lg:hidden">วันที่หมดอายุ:</label>
                        <label class=" font-bold">
                            {{dayjs(item_tran.date_expire_last).locale('th').format('DD MMM BBBB')}}
                        </label>
                    </div>
                    <div class="  lg:w-2/12  ">

                        <label for="" class="  lg:hidden">วันที่เบิก:</label>
                        <label class=" font-bold">
                            <!-- {{date_action_thai(item_tran.date_action)}} -->
                            {{dayjs(item_tran.date_action).locale('th').format('DD MMM BBBB')}}
                        </label>
                    </div>



                    <div class="  lg:w-1/12 ">
                        <label for="" class="  lg:hidden">จำนวนที่เบิก:</label>
                        <label class=" font-bold">{{item_tran.item_count}} </label>
                    </div>
                    <div class="  lg:w-1/12 ">
                        <label for="" class="  lg:hidden">จำนวนคงเหลือ(ปัจจุบัน):</label>
                        <label class=" font-bold">{{item_tran.item_balance}} </label>
                    </div>
                    <div class=" lg:w-2/12  lg:text-xs ">
                        <label for="" class="   lg:hidden">ผู้เบิก:</label>
                        <label class=" font-bold">{{item_tran.user['name']}}</label>
                    </div>

                </div>
            </div>
        </div>


    <div v-if="item_trans.length !=0"   class=" mt-6 flex flex-col  ">

        <!-- {{item_trans}} -->
         <a class="flex justify-center mt-3 px-8 py-1   text-md  text-white bg-blue-700 rounded-xs shadow-md hover:bg-yellow-200 focus:outline-hidden"
            :href="route('export-checkout-item', {stock_id:form.unit_selected, year:form.year_selected, month:form.month_selected })">
            Export Excel
        </a>

            <a  :href="route('view-cutstockitem-pdf',{stock_id:form.unit_selected, year:form.year_selected, month:form.month_selected })" target="blank"
                 class="flex justify-center mt-3 px-8 py-1   text-md  text-white bg-purple-500 rounded-xs shadow-md hover:bg-purple-200 focus:outline-hidden"
                >
                <div class=" flex items-center " >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                    </svg>
                    พิมพ์รายงานตัดสต๊อกวัสดุ
                </div>
            </a>

    </div>

    </AppLayout>
</template>
<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props=defineProps({
    stocks:Object,
    unit:Object,
    item_trans:{type:Object},
    unit_selected:{type:String},
    year_selected:{type:String},
    month_selected:{type:String},
    year_has:{type:Object},
})
const form = useForm({
    unit_selected:props.unit_selected ? props.unit_selected :[],
    year_selected:props.year_selected ? props.year_selected :[],
    month_selected:props.month_selected ? props.month_selected :[],
    unitid:usePage().props.auth.user.unitid ? usePage().props.auth.user.unitid :0,
    stock_id_selected:{type:Number},
})

const month_thai=ref([
        '',
        'มกราคม' ,
        'กุมภาพันธ์',
        'มีนาคม' ,
        'เมษายน' ,
        'พฤษภาคม',
        'มิถุนายน' ,
        'กรกฎาคม',
        'สิงหาคม' ,
        'กันยายน' ,
        'ตุลาคม' ,
        'พฤศจิกายน',
        'ธันวาคม',
])
const months=ref([
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
        {id:11,name:'พฤศจิกายน' },
        {id:12,name:'ธันวาคม' },
])

const stock_id=ref(0);

const msg_validate_stock=ref(false);
const msg_validate_year=ref(false);
const msg_validate_month=ref(false);


const year_thai = (year_select)=>{
    if(year_select==0)
         return ': กรุณาระบุปี';
    else
         return   parseInt(year_select)+543;
}



const setStockID=()=>{
    stock_id.value =form.unit_selected;
    form.stock_id_selected = stock_id.value

}

const  getReportStock=(stock_id,year,month)=>{
   msg_validate_stock.value = false
   msg_validate_year.value = false
   msg_validate_month.value = false
   if(stock_id.length==0){
     msg_validate_stock.value = true
     return false;
   }

   if(year.length==0){
     msg_validate_year.value = true
     return false;
   }

   if(month.length==0){
     msg_validate_month.value = true
     return false;
   }

   form.get(route('report-checkout-item',form.unitid),{
        preserveState: true,
        preserveScroll: true,
    })

}


</script>
