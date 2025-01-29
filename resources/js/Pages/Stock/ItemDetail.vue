<template>
     <AppLayout>
        <div v-if="$page.props.flash.status==='success'"
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">

                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

        <div v-if="$page.props.flash.status==='error'"
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">

                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-300 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

        <div v-if="$page.props.flash.status==='Warnning'"
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">

                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>
        <button @click="goBack()"
          class=" flex text-gray-600 font-bold"
         >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>

           กลับ
         </button>
        <div  v-if="checkin_last" class=" mt-2 bg-blue-800 text-white text-xl text-center ">
                {{$page.props.stock.stockname}}
        </div>

    <!-- Item Detail -->
     <!-- {{$page.props.checkin_last}} -->
        <div class="w-full mt-2 p-2  ">

            <div
                    class="w-full bg-purple-100  mt-3 border-2 border-purple-300 rounded-lg lg:max-w-full lg:flex">

                <div class="w-full  leading-normal  border-b border-l border-r border-gray-200 rounded-b lg:border-l-0 lg:border-t lg:border-gray-200 lg:rounded-b-none lg:rounded-r"
                >
                    <div class=" mb-2">
                        <div class="p-2 text-md font-bold text-gray-900">
                            SAP:{{stock_item.item_code}}
                            <label for="" class="text-blue-600">{{stock_item.item_name}}</label>
                            (หน่วย: {{count_name}})

                        </div>


                        <div  v-if="checkin_last"
                            class="flex flex-col lg:flex-col mb-2 text-md font-bold text-gray-900">
                            <div class="flex ml-2"> จำนวนคงเหลือ :
                                <p class=" ml-2 text-red-600">{{number_format_show(item_balance)}}</p>
                            </div>
                            <div class="flex ml-2"> Pur.Order :
                                    <p class=" ml-2 text-blue-600">{{checkin_last.pur_order}}</p>
                            </div>
                            <!-- <div class="flex ml-2"> ชื่อบริษัท :
                                <p class=" ml-2 text-blue-600">{{stock_item.business_name}}</p>
                            </div> -->
                            <div class="flex ml-2" v-if="checkin_last"> วันหมดอายุ :
                                <p class=" ml-2 text-blue-600">
                                        <!-- {{checkin_last.date_expire}} -->
                                        {{dayjs(checkin_last.date_expire).locale('th').format('D MMMM BBBB')}}
                                    </p>
                            </div>

                            <div class="flex ml-2"  v-if="checkin_last"> วันที่รับเข้า :
                                <p class=" ml-2 text-blue-600">
                                    <!-- {{checkin_last.date_action}} -->
                                    {{dayjs(checkin_last.date_action).locale('th').format('D MMMM BBBB')}}
                                </p>
                            </div>

                            <!-- <div class="flex ml-2"> Cat.No/Lot.No :
                                <p class=" ml-2 text-blue-600">{{$page.props.checkin_last.profile['catalog_number']}}/{{$page.props.checkin_last.profile['lot_number']}}</p>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END Item Detail -->
 <!-- {{$page.props.item_trans}}  -->
    <!-- start Table -->
    <label for="" class=" text-red-600 text-sm" >  *ลบได้เฉพาะผู้ที่บันทึกรายการนี้เท่านั้น</label>
    <div class="flex">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-green-800 bg-green-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        <label for="" class="text-sm" > ข้อมูลการรับวัสดุเข้าคลัง</label>
    </div>
    <div class="flex">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-red-800 bg-red-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
        </svg>
        <label for="" class="text-sm" > ข้อมูลการเบิกวัสดุ</label>
    </div>


    <div v-if="item_trans">
                <paginateMe :pagination="item_trans" />
    </div>
    <table  class="min-w-full border-collapse block  md:table md:rounded-md">
		<thead class="block  md:table-header-group">
			<tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th class=" bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">
                        วันที่[Pur.Order]</th>
                <th class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">
                    จำนวน[ราคาต่อหน่วย]</th>
                <th class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">
                    บริษัท</th>
                <th class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">
                    ผู้ปฎิบัติ</th>
                 <th  class="bg-blue-300 p-2 text-black font-bold md:border md:border-grey-300 text-left block md:table-cell md:rounded-lg">
                    ::</th>
			</tr>
		</thead>
		<tbody class="block md:table-row-group">
			<tr v-for="(item_tran) in item_trans.data" :key=item_tran.id
                class="bg-white my-2 p-2 mb-2 border-2 rounded-md border-gray-500 block md:border-none   md:table-row ">
				<td class="text-left  block md:table-cell   md:border-b-2 md:border-gray-300 "><span class="inline-block w-1/3 md:hidden font-bold">วันที่</span>
                    <span
                       class="inline-flex px-2  text-lg font-semibold leading-5  ">
                        <svg  v-if="item_tran.action === 'checkin'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-green-800 bg-green-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                         <svg  v-if="item_tran.action === 'checkout'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-red-800 bg-red-100 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>

                    </span>
                      <!-- {{item_tran.date_action}} -->
                      {{dayjs(item_tran.date_action).locale('th').format('D MMM BBBB')}}
                      <label v-if="item_tran.action === 'checkin'">   [{{item_tran.pur_order}}]</label>

                </td>

                <td class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 ">
                    <span class="inline-block w-1/3 md:hidden font-bold">จำนวน[ราคาต่อหน่วย]</span>
                    {{item_tran.item_count}}
                    <label v-if="item_tran.action === 'checkin'">   [{{number_format_show(item_tran.price)}}]</label>
                    <button v-if="item_tran.status !== 'canceled' &&
                                  item_tran.action === 'checkin' &&
                                  item_tran.user_id === $page.props.auth.user.id
                                "
                        v-on:click="edit_price(item_tran.id,item_tran.price)"
                        class=" ml-3  bg-green-300  hover:bg-green-200 border border-green-600 text-green-800 font-bold py-1 px-2  rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                    </button>
                </td>
                <td class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 ">
                    <span class="inline-block w-1/3 md:hidden font-bold">บริษัท</span>

                    <label v-if="item_tran.action === 'checkin'" class=" text-sm">   {{item_tran.business_name}}</label>
                </td>
                <td class="text-left  block md:table-cell  md:border-b-2 md:border-gray-300 "><span class="inline-block w-1/3 md:hidden font-bold">ผู้ปฎิบัติ</span>{{item_tran.user.name}}</td>
                <td
                    class="text-left text-sm  block md:table-cell  md:border-b-2 md:border-gray-300 ">
                    <span class="inline-block w-1/3 md:hidden font-bold">::</span>
                    <!-- {{ $page.props.can }} -->
                    <label for=""  v-if="item_tran.status !== 'active'">
                        <!-- {{item_tran.status}} -->ยกเลิกเมื่อ
                        {{ dayjs(item_tran.updated_at).locale('th').format('D MMM BBBB HH:mm')}} น.
                    </label>

                    <button v-if="item_tran.status !== 'canceled' &&
                                  item_tran.action !== 'checkin' &&
                                  item_tran.user_id === $page.props.auth.user.id
                                "
                        v-on:click="cancel_checkout(item_tran.id)"
                        class=" ml-3 bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <button v-if="item_tran.status !== 'canceled' &&
                                  item_tran.action === 'checkin' &&
                                  item_tran.user_id === $page.props.auth.user.id
                                "
                        v-on:click="confirm_cancel_checkin_item(item_tran.id,$page.props.stock_item.item_name,item_tran.pur_order)"
                        class=" ml-3 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 border border-yellow-500 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                </td>
            </tr>

		</tbody>
	</table>
    <!-- END table -->

    <button @click="goBack()"
         class="w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
        >
         กลับ
    </button>
     <ModalUpToYou :isModalOpen="confirm_delete_checkout" >
         <template v-slot:header>
             <p class="text-md font-bold text-blue-700 "> ยืนยันการลบ</p>

         </template>

         <template v-slot:body>
             <div class="text-gray-900 text-md font-medium ">

                 <label  class="  flex  justify-start w-full text-md ">
                    คุณต้องการลบข้อมูลการตัดสต๊อกวัสดุนี้ใช่หรือไม่?
                 </label>

             </div>
         </template>

         <template v-slot:footer>
             <div class=" w-full  text-center  md:block">
                 <button
                     class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                     v-on:click="okconfirmDeleteCheckout"
                 >
                     ตกลง
                 </button>
                 <button
                     class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                     v-on:click="cancelDeleteCheckout"
                 >
                     ยกเลิก
                 </button>
             </div>
         </template>
     </ModalUpToYou>
    <ModalUpToYou :isModalOpen="confirm_delete_item" >
            <template v-slot:header>
                <p class="text-md font-bold text-blue-700 ">คุณต้องการลบวัสดุนี้ออกจากข้อมูลคลังวัสดุใช่หรือไม่?</p>

            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">

                    <label  class="  flex  justify-start w-full text-md ">
                        ชื่อวัสดุ:{{confirm_delete_item_name}}
                    </label>
                    <label  class="  flex  justify-start w-full text-md ">
                        Pur.Order:{{confirm_delete_item_pur_order}}
                    </label>
                    <label  class="flex mt-4 text-red-600  justify-start w-full text-sm ">
                        ***คำเตือน:หากลบรายการวัสดุนี้ ข้อมูลการตัดสต๊อกของวัสดุนี้จะถูกลบไปโดยอัตโนมัติด้วย
                    </label>


                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmDeleteItem"
                        >
                        ตกลง
                    </button>
                    <button
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelDeleteItem"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
    </ModalUpToYou>

    <ModalUpToYou :isModalOpen="show_edit_price" >
            <template v-slot:header>
                <p class="text-md font-bold text-blue-700 ">แก้ไขราคาวัสดุ</p>

            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">
                    <label  class="  flex  justify-start w-full text-md ">
                        ราคาปัจจุบัน:{{number_format_show(price_data)}} บาท / หน่วย
                    </label>
                    <label  class="  flex  justify-start w-full text-md ">
                        ระบุราคาที่ต้องการแก้ไข:
                    </label>
                    <input type="number"
                      v-model="form.price_edit_new"
                      class="w-full px-12 py- border-2 border-blue-600 rounded-md appearance-none focus:border-blue-700 focus:ring focus:ring-opacity-40 focus:ring-blue-500"
                    >

                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmEditPrice"
                        >
                        ตกลง
                    </button>
                    <button
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelEditPrice"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
    </ModalUpToYou>

     </AppLayout>
</template>
<script setup>

import {useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import PaginateMe from '@/Components/PaginateMe.vue';
import {ref} from 'vue';

import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'

dayjs.extend(buddhistEra)

const props =defineProps({
        stock_item:{ type: Object, required: true },
        stock:{ type: Object, required: true },
        item_trans:{ type: Object },
        checkin_last:{ type: Object },
        item_balance:{ type: Number },
        count_name:String,
        can_abilities: { type: Object, required: true },
        can: { type: Object, required: true },
})
const form = useForm({
    item_tran_id:0,
    price_edit_new:0,
    update_item:'',
})
const confirm_delete_item=ref(false);
const confirm_delete_item_name=ref('');
const confirm_delete_item_pur_order=ref('');

const confirm_delete_checkout=ref(false);
const confirm_delete_checkout_name=ref('');
const number_format_show=(item)=>{
    return item.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

const show_edit_price=ref(false);
const price_data=ref('');
const edit_price=(item_tran_id,price)=>{

    show_edit_price.value = true;
    price_data.value = price;
    form.item_tran_id = item_tran_id;
}
const  cancelEditPrice=()=>{
   // console.log('cancelDeleteItem');
   show_edit_price.value= false;
}

const okconfirmEditPrice=()=>{

    form.update_item = "price";

    form.post(route('edit-price-item'), {
        preserveState: false,
        preserveScroll: true,

    })
}

const cancel_checkout=(item_tran_id)=>{
    confirm_delete_checkout.value = true;
    confirm_delete_checkout_name.value = item_tran_id;

   form.item_tran_id = item_tran_id;

}
const okconfirmDeleteCheckout=()=>{

    confirm_delete_checkout.value = false;

     form.post(route('cancel-checkout-stock-item'), {
           preserveState: false,
           preserveScroll: true,

       })
}

const  cancelDeleteCheckout=()=>{

    confirm_delete_checkout.value= false;
}
const confirm_cancel_checkin_item=(stock_item_id,item_name,pur_order)=>{

    confirm_delete_item.value = true;
    confirm_delete_item_name.value = item_name;
    confirm_delete_item_pur_order.value = pur_order;
    form.item_tran_id = stock_item_id;
}

const okconfirmDeleteItem=()=>{

    confirm_delete_item.value = false;

    form.post(route('cancel-checkin-stock-item'), {
        preserveState: false,
        preserveScroll: true,

    })
}

const  cancelDeleteItem=()=>{

    confirm_delete_item.value= false;
}

const goBack=()=>{
    history.back();
}


</script>
