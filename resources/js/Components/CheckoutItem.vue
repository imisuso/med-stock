<template>
    <div  class="w-full  mt-2 border-2 border-gray-500   rounded-lg ">


        <div v-if="stockItem.status == 1"
            class="flex  bg-pink-200  overflow-hidden text-center  bg-cover rounded-t  "
        >

            <div>
                <label  >สัญญาซื้อ</label>
            </div>

        </div>
         <div v-else
            class="flex  bg-blue-200 items-center overflow-hidden text-center  bg-cover rounded-t "
         >

                <div>
                    <label  >ใบสั่งซื้อ</label>
                </div>
        </div>


            <div
             class="w-full  leading-normal  border-b border-l border-r border-gray-200 rounded-b lg:border-l-0 lg:border-t lg:border-gray-200 lg:rounded-b-none lg:rounded-r"
             >
                <div class=" mb-2">

                    <div class="p-2 text-md font-bold text-gray-900">
                        {{itemIndex+1}}.
                        รหัสวัสดุ:{{stockItem.item_code}}
                        <label for="" class="text-blue-600">{{stockItem.item_name}}</label>
                        (หน่วย: {{stockItem.unit_count}})
                        <Link :href="route('list-stock-item',stockItem)">
                        <span
                            class="inline-flex text-md font-semibold leading-5 text-green-800 bg-green-200 rounded-lg"
                        >
                            ประวัติการรับเข้าและเบิกออก
                        </span>
                        </Link>
                    </div>


                    <div class="flex flex-col lg:flex-col mb-2 text-md font-bold text-gray-900">
                        <div class=" flex ml-2"> จำนวนที่มี :
                            <p class=" ml-2 text-red-600" >
                                <span
                                    class="inline-flex px-2  text-lg font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <!-- {{stockItem.item_sum}} -->
                                {{price_format(stockItem.item_balance)}}
                                </span>
                            </p>
                            <svg v-if="stockItem.item_balance < 6"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6 text-red-500 "

                                >
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                        </div>
                        <div class="flex ml-2"> ราคาต่อหน่วย :
                            <p class=" ml-2 text-blue-600">
                                <!-- {{stockItem.price}} -->
                                {{price_format(stockItem.checkin_last.price)}} บาท
                            </p>
                        </div>
                        <div class="flex ml-2"> Pur.Order :
                            <p class=" ml-2 text-blue-600">{{stockItem.checkin_last.pur_order}}</p>
                        </div>
                        <div class="flex ml-2"> ชื่อบริษัท :
                            <p class=" ml-2 text-blue-600">{{stockItem.checkin_last.business_name}}</p>
                        </div>
                        <div class="flex ml-2"> วันหมดอายุ(Lot. ล่าสุด) :
                            <p class=" ml-2 text-blue-600">
                                {{dayjs(stockItem.checkin_last.date_expire).locale('th').format('D MMMM BBBB')}}
                            </p>
                        </div>
                        <div class="flex ml-2"> วันที่รับเข้า(Lot. ล่าสุด) :
                            <p class=" ml-2 text-blue-600">{{dayjs(stockItem.checkin_last.date_action).locale('th').format('D MMMM BBBB')}}</p>
                        </div>



                    </div>

<!--                    <div class="flex ml-2">-->
<!--                            <p class=" ml-2 text-red-600 text-xs"> *คลิ๊กที่ icon รูปปฎิทินเพื่อเลือกวันที่เบิก</p>-->
<!--                        </div>-->
                    <div v-if="canAbility.checkout_item && stockItem.item_balance!=0" class="flex flex-col lg:flex-row mb-2 text-md font-bold text-gray-900">
                        <div class=" m-2">
                             <div  class="flex justify-start " >
                                <svg xmlns="http://www.w3.org/2000/svg" v-if="date_alert" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                 <label >วันที่เบิก:</label>
                                 <!-- <label class="text-red-600 text-sm " >(ให้คลิ๊กที่ icon รูปปฎิทิน):</label> -->

                            </div>
                           <!--  :min="stockItem.checkin_last.date_action" เอาออกเนื่องจากอาจต้องการระบุวันที่ที่เก่ากว่า วันที่รับเข้าล่าสุด-->
                            <div>

                                <input type="date" id="dateCheckout"
                                    v-model="form.date_checkout"
                                    class="w-full bg-gray-300 px-12 py-2 border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                    :class="[date_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                                    @keydown="checkKeydown" readonly
                                >


                            </div>

                        </div>
                        <div class=" m-2">
                             <div  class="flex justify-start " >
                                <svg xmlns="http://www.w3.org/2000/svg" v-if="unitcheckout_alert" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                 <label for="">จำนวน:</label>
                            </div>
                            <div>
                                <input type="number" name="" id=""
                                    :min="0"
                                    :max="stockItem.item_balance"
                                    pattern = "[0-9]"
                                    v-model="form.unit_checkout"
                                    class="w-full px-12 py- border-2 rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                                    :class="[unitcheckout_alert ? 'border-red-500 border-2 ' : 'border-gray-400' ]"
                                >

                            </div>

                        </div>


                    </div>
                    <div class="mx-2 text-center bg-red-600 text-sm text-white">
                        <label v-if="date_alert" >!!! {{msg_alert}} !!!</label>
                        <label v-if="unitcheckout_alert">!!! {{msg_alert}} !!!</label>
                    </div>
                    <div v-if="canAbility.checkout_item && stockItem.item_balance!=0" class="flex flex-col lg:flex-row px-2 py-2  ">

                        <button
                            class=" flex justify-center px-4 py-1   text-sm  text-white bg-green-600 rounded-md hover:bg-green-400 focus:outline-none"
                            v-on:click="confirmCheckout(stockItem)"
                        >
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg> -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            บันทึกการเบิก
                        </button>
                    </div>
                </div>
            </div>

    </div>

         <ModalUpToYou :isModalOpen="confirm_checkout" >

            <template v-slot:header>

                <p class="text-md font-bold text-red-600 ">คุณต้องการบันทึกการเบิกวัสดุรายการนี้ใช่หรือไม่?</p>

            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">
                    <p class="mt-2">{{form.confirm_item_name}} เบิกใช้วันที่ {{ form.confirm_item_date}} จำนวน {{form.confirm_item_count}} ชิ้น</p>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okConfirmCheckout"
                        >
                        ตกลง
                    </button>
                    <button
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelConfirmCheckout"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>
</template>
<script setup>
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'

dayjs.extend(buddhistEra)

const props = defineProps({
   itemIndex:{type:Number},
    stockItem:{type:Object,required:true},
    canAbility:{type:Object,required:true},
})
const confirm_checkout=ref(false);
const date_alert=ref(false);
const unitcheckout_alert=ref(false);
const msg_alert=ref('');
const msg_alert_checkout=ref(false);

const form = useForm({
    unit_checkout:0,
   // date_checkout:'',
    date_checkout : dayjs(new Date()).locale('th').format('YYYY-MM-DD'),
    // item_balance:0,
   // confirm_checkout:0,
    confirm_item_name:'',
    confirm_item_slug:'',
    confirm_item_date:'',
    confirm_item_count:'',
   // stock_item_sum:[], //เอาตัวแปร จาก props มาใช้
})

const price_format=(price)=>{
   // console.log(price)
   let  price_show = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    return price_show;
  // return '1,200.5';
}
const confirmCheckout=(stock_item)=>{
  // console.log('confirmCheckout');
   // console.log(form.date_checkout);
  //  let date =  new Date().getFullYear();
  //  console.log(date);
    if(form.date_checkout.length==0){
        date_alert.value=true
        msg_alert.value="กรุณาระบุวันที่เบิก";

        return false;
    }else{
        date_alert.value=false;
    }

    if(form.unit_checkout==0){
        unitcheckout_alert.value=true
        msg_alert.value="กรุณาระบุจำนวน";
       // console.log('กรุณาระบุจำนวน');
      //  document.getElementById("order_in").focus();
        return false;
    }else{
        unitcheckout_alert.value=false;
    }


    // Number.isInteger(form.unit_checkout)
    // console.log(Number.isInteger(form.unit_checkout));
    if(!Number.isInteger(form.unit_checkout)){
        unitcheckout_alert.value=true
        msg_alert.value="กรุณาระบุจำนวนที่เบิกวัสดุเป็นจำนวนเต็ม";
       // console.log('กรุณาระบุจำนวน');
      //  document.getElementById("order_in").focus();
        return false;
    }else{
        unitcheckout_alert.value=false;
    }

    if(form.unit_checkout > stock_item.item_balance){
        unitcheckout_alert.value=true
        msg_alert_checkout.value=true
        msg_alert.value="จำนวนที่เบิกต้องไม่มากกว่าจำนวนคงเหลือ";
        return false;
    }else{
        unitcheckout_alert.value=false
        msg_alert_checkout.value=false
    }

    //if(document.getElementById('budget_add').value < 0)
    if(form.unit_checkout <0)
    {
        unitcheckout_alert.value=true
        msg_alert_checkout.value=true
        msg_alert.value="จำนวนที่เบิกต้องไม่เป็นจำนวนติดลบ";
        //document.getElementById("budget_add").focus();
        return false;
   }else{

        unitcheckout_alert.value=false
        msg_alert_checkout.value=false
   }

    confirm_checkout.value = true;
    form.confirm_item_slug = stock_item.slug;
    form.confirm_item_name = stock_item.item_name;
    form.confirm_item_date = form.date_checkout;
    form.confirm_item_count = form.unit_checkout;

}
const cancelConfirmCheckout = ()=>{
    confirm_checkout.value = false;
}

const okConfirmCheckout=()=>{
    confirm_checkout.value = false;
    //console.log('OK Confirm');
    form.post(route('checkout-stock-item'), {
        preserveState: false,
        preserveScroll: true,
        //onSuccess: page => { console.log('success');},
        onError: errors => {
            console.log('error');
        },
      //  onFinish: visit => { console.log('finish');},
    })

}
const checkKeydown=()=>{
    date_alert.value=true
    msg_alert.value="กรุณาระบุวันที่โดยคลิ๊กที่รูปปฎิทิน";
    document.getElementById("dateCheckout").value = "";
    return false;
}


</script>
