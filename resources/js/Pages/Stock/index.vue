<template>
    <AppLayout>
    <!-- {{ $page.props.flash.mainMenuLinks }} -->
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
           
        </div>
     
  <!-- <div v-if="$page.props.flash.status=='success'" class="w-full mx-auto shadow-md rounded-md p-2 mt-2 text-black bg-green-200 border-white">
        <label for=""> {{ $page.props.flash.msg }}</label>
  </div> -->
  <!-- {{stock_item_sum}} -->
  <!-- {{$page.props.can_abilities}} -->
  <!-- {{$page.props.can}} -->
    <div class="w-full mt-3 p-2  ">
  
  
        <CheckoutItem v-for="(stock_item,key) in stock_items" :key=stock_item.id
            :itemIndex="key"
            :stockItem="stock_item"
            :canAbility="can"
         />
     

    
    
    </div>
   
    </AppLayout>
</template>
<script setup>
import CheckoutItem from '@/Components/CheckoutItem.vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
import { onBeforeMount, onMounted, ref } from '@vue/runtime-core';

defineProps({
    stocks:Array,
    stock_items:Array,
    unit:Object,
    errors: Object,
    //can_abilities: { type: Object, required: true },
    can: { type: Object, required: true },
});



</script>
 