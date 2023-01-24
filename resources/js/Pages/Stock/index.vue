<template>
    <AppLayout>
   {{ $page.props.flash.status }}
        <div v-if="$page.props.flash.status=='success'" 
                class="alert-banner  fixed  right-0 m-2 w-5/6 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

        <div v-if="$page.props.flash.status=='error'" 
                class="alert-banner  fixed right-0 mt-8 w-2/3 md:w-full max-w-sm ">
                <input type="checkbox" class="hidden" id="banneralert">
                
                <label 
                    class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-700 font-bold text-2xl border-2 border-red-500" 
                    title="close" for="banneralert">
                 {{ $page.props.flash.msg }}
                   <svg class="fill-current text-red-700 w-8 h-8 " xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
        </div>

      
        <div v-if="stock_status=='close'">
            <div class=" w-full flex justify-center  bg-blue-100 p-2 rounded-md ">
                คลัง{{$page.props.auth.user.profile.division_name}} ถูกปิดการใช้งาน
            </div>  
        </div>
        <div v-else>

       
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.unit.unitname}}
                </div>
                <div class="mt-3" >
                    <label for="">เลือกคลังวัสดุ</label> 
                </div>
                <!-- {{stocks}} -->
                <select name="" id="" 
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.stock_id"
                    @change="getListStockItem()"
                    >
                    <option v-for="(stock) in  $page.props.stocks" :key=stock.id :value="stock.id">{{stock.stockname}}</option>
                </select>
            
            </div>
          
            <!-- <div >
                <input type="text" placeholder="พิมพ์ชื่อวัสดุหรือชื่อบริษัทที่ต้องการค้นหา อย่างน้อย 3 ตัวอักษร"
                    @keyup="purchase_filter" v-model="search" 
                    class="mt-2 border-green-600 border-2 block w-full shadow-sm sm:text-sm  rounded-md"
                    >
            </div> -->
            <div class="w-full">
                            <input type="text" placeholder="พิมพ์รหัสวัสดุ หรือชื่อวัสดุ หรือชื่อบริษัท ที่ต้องการค้นหา"
                                 v-model="search" 
                                class="mt-2 border-green-600 border-2 block w-full shadow-sm sm:text-sm  rounded-md"
                            >
            </div>
            <div class=" w-full flex mt-2  text-sm   rounded-md ">
                        <div class=" w-full flex">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-500 ">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                </svg>
                            <label for="">เตือนเมื่อวัสดุมีน้อยกว่า 6 ชิ้น </label> 
                            </div>
                       
                  
            </div>

            <div class="w-full  p-2  ">
                <paginateMe :pagination="stock_items" />
        
                <!-- <CheckoutItem v-for="(stock_item,key) in stock_items" :key=stock_item.id
                    :itemIndex="key"
                    :stockItem="stock_item"
                    :canAbility="can"
                /> -->
            
                <div v-for="(stock_item,key) in stock_items.data" :key="stock_item.id"
                    class=" m-2 p-2"
                    >
                    <CheckoutItem 
                        :itemIndex="key"
                        :stockItem="stock_item"
                        :canAbility="can"
                    />
                
                </div>
           
                <paginateMe :pagination="stock_items" />
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import CheckoutItem from '@/Components/CheckoutItem.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import PaginateMe from '@/Components/PaginateMe.vue';
import { router } from '@inertiajs/vue3'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { ref ,watch} from 'vue';
//import { onBeforeMount, onMounted, ref,watch } from '@vue/runtime-core';
const props = defineProps({
    stocks:Array,
    stock_items:Object,
    unit:Object,
    errors: Object,
    can: { type: Object, required: true },
    stock_status:{type:String},
    filters: { type: Object },
})


let search = ref(props.filters.search)

const form = useForm({
    filter_key:'',
    stock_id:usePage().props.auth.user.unitid ? usePage().props.auth.user.unitid : 0,
})

watch( search, value => {
   
   // if(value.length >= 3){
      //  console.log('key search=' + value)
      router.get(route('stock'), { search: value }, {
            preserveState: true,
            replace: true
        })
  //  }
})

const getListStockItem=(()=>{
    // console.log('----------getListStockItem------')
    // console.log(form.stock_id);


    form.get(route('stock'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
            // console.log(props.list_stock_unit.length);
            // stocks_unit_count.value = props.list_stock_unit.length;
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
})

</script>
 