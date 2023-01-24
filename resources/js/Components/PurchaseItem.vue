<template>
    <div class=" my-2 p-2 bg-blue-100 rounded-md ">
        <div class=" w-full flex  justify-between ">
                <label class=" text-lg font-bold text-red-600" >เพิ่มรายการวัสดุให้ครบก่อนกดปุ่มบันทึกใบสั่งซื้อ:</label>
                <button 
                        class="  flex  p-2 justify-center mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="openSearchItem"
                        >
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        ค้นหาวัสดุ
                </button>
        </div>
        <div class=" w-full block "> 
                 <!-- <svg xmlns="http://www.w3.org/2000/svg" v-if="business_alert" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg> -->
                <label >ชื่อบริษัทผู้ขาย:</label>
                <input type="text" name="" id=""
                        v-model="form.business"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[business_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
                <label >รายการ:</label>
                <input type="text" name="" id=""
                        v-model="form.item"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[item_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
                <label >Material:</label>
                <input type="text" name="" id=""
                        v-model="form.material"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[material_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
                <label >จำนวน:</label>
                <input type="number" name="" id=""
                        v-model="form.unit_purchase"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[unit_purchase_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
                <label >หน่วย:</label>
                <input type="text" name="" id=""
                        v-model="form.unit_count"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[unit_count_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
                    <label >ราคา/หน่วย:</label>
                <input type="number" name="" id=""
                        v-model="form.unit_price"
                        class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                        :class="[unit_price_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                    >
        </div>
        <div class=" m-2 p-2">
                    
            <button
                class="w-full flex  p-2 justify-center text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
                @click="addOrder"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              เพิ่มรายการ
            </button>
        </div>   

             <ModalUpToYou :isModalOpen="show_search_item" modalSize="large" >
                        <template v-slot:header>
                                <p class="text-md font-bold text-blue-800 ">ค้นหาวัสดุ </p> 
                                <!-- <p class="text-sm font-bold text-red-600 ">***พิมพ์ชื่อวัสดุอย่างน้อย 3 ตัวอักษร</p>  -->
                        </template>
                        <template v-slot:body>
                         <p class="text-sm font-bold text-red-600 ">***พิมพ์ชื่อวัสดุอย่างน้อย 3 ตัวอักษร</p> 
                        <div class="w-full flex  text-gray-900 text-md font-medium ">
                               <div class=" w-3/4">
                                                  <!-- {{ $page.props.flash.status }}:{{ $page.props.flash.msg }}  -->
                                        <input type="text" v-model="form.item_name_search" name="" id="" 
                                                placeholder="พิมพ์ชื่อวัสดุอย่างน้อย 3 ตัวอักษร"
                                                class="w-full  py-2 rounded-md appearance-none focus:border-indigo-600 "
                                                :class="[item_name_search_alert ? 'border-red-500 border-2 ' : 'border-gray-500' ]"
                                        >
                               </div>
                               <div class="  w-1/4 ml-2">
                                        <button
                                                class="w-full flex  p-2 justify-center text-sm  text-white bg-blue-600 rounded-md hover:bg-blue-400 focus:outline-none"
                                                @click="searchStockItem"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                         ค้นหา
                                        </button>
                               </div>       
                        </div>
                        <div class=" bg-blue-50">
                                <div v-if="form.stock_items.length == 0">
                                        <p>ไม่พบชื่อวัสดุที่ต้องการค้นหา</p>
                                </div>
                                <div v-else>
                                        <div class="w-full  justify-between mt-2 border-b-2 border-blue-800"
                                                v-for="(item,index) in  form.stock_items" :key=item.id  
                                        >
                                                {{index+1}}. {{item.item_name}} ({{item.item_code}}) 
                                                ราคา {{item.price}} / {{item.unit_count.countname}} 
                                                <label v-if="!item.profile"> [ไม่พบข้อมูลชื่อบริษัท]</label>
                                                <label v-else>[{{item.profile.business_name}}]</label>
                                                <button
                                                        class=" mx-2 px-2  justify-center text-sm  text-white bg-green-700 rounded-md hover:bg-green-400 focus:outline-none"
                                                        @click="fillItemToForm(item)"
                                                        >
                                                        เลือก
                                                </button>
                                        </div>
                                </div>
                              
                               
                        </div>
                        </template>
                
                        <template v-slot:footer>
                        <div class=" w-full  text-center  md:block">
                                <button 
                                class="mx-4 md:mb-0 bg-blue-700 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                                v-on:click="closeSearchItem"
                                >
                                ปิด
                                </button>
                        
                        </div>
                        </template>
                </ModalUpToYou>
        
    </div>

</template>
<script setup>
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/vue3';
import { ref } from "vue";
//const { useForm }=require("@inertiajs/inertia-vue3");
//const { ref }=require("@vue/reactivity");


const emits = defineEmits(['previewOrder'])
const form = useForm({
//     item:' Mannitol Salt Agar',
//     material:380022546,
//     business:'บจ. เมดิคอล ทดสอบ จำกัด',
//     unit_purchase:5,
//     unit_count:'pack',
//     unit_price:2000.0,

    // item:'',
    // material:'',
    // business:'',
    // unit_purchase:0,
    // unit_count:'',
    // unit_price:0.0,
    item_name_search :'',
    stock_items:Array,
    preview_orders: Array,
})

// defineProps({
//    stock_items:{type:Object},
// })


// const search_items=[
//                 {item_name:"item nameeeeeeeeeeeeeeeeeee1" ,code:"300112331",price:"1501",unit:"pack",business:'business name a'},
//                 {item_name:"item name2" ,code:"300112332",price:"1502",unit:"ขวด",business:'business name b'},
//                 {item_name:"item name3" ,code:"300112333",price:"1503",unit:"ชิ้น",business:'business name c'},
//                 {item_name:"item name4" ,code:"300112334",price:"1504",unit:"ลัง",business:'business name d'},
//         ];

const total_bath= ref(0);
const business_alert=ref(false);
const item_alert=ref(false);
const material_alert=ref(false);
const unit_count_alert=ref(false);
const unit_price_alert=ref(false);
const unit_purchase_alert=ref(false);
const item_name_search_alert = ref(false);
const show_search_item=ref(false);

const openSearchItem=()=>{
        form.item_name_search = '';
         form.stock_items = '';
        show_search_item.value = true;
}
const  closeSearchItem=()=>{
    // console.log('close alert');
    show_search_item.value = false;
}
const searchStockItem=()=>{
       // console.log(form.item_name_search);
        if(form.item_name_search.length <3){
                item_name_search_alert.value = true;
                return false;

        }
        axios.get(route('search-stock-item',
                         {item_name_search:form.item_name_search }
                    )).then(res => {
               // console.log(res.data);
                form.stock_items = res.data.items;

        });
     
       
}

const fillItemToForm=(item)=>{
        //console.log(item);
        //console.log(item.profile);
        form.item = item.item_name;
        form.material= item.item_code;
        if(item.profile != null){
               form.business= item.profile.business_name;
        }else{
                form.business='';
        }
       
        form.unit_price= item.price;
        form.unit_count = item.unit_count.countname;
        form.unit_purchase = 0;
        show_search_item.value = false;
}

const addOrder=()=>{
    //validate

    if(form.business.length==0){
            business_alert.value = true;
            return false;
    }else{
            business_alert.value = false;
    }

    if(form.item.length==0){
            item_alert.value = true;
            return false;
    }else{
            item_alert.value = false;
    }

    if(form.material.length==0){
            material_alert.value = true;
            return false;
    }else{
            material_alert.value = false;
    }
    if(form.unit_purchase==0){
            unit_purchase_alert.value = true;
            return false;
    }else{
            unit_purchase_alert.value = false;
    }
    if(form.unit_count.length==0){
            unit_count_alert.value = true;
            return false;
    }else{
            unit_count_alert.value = false;
    }
    if(form.unit_price==0){
            unit_price_alert.value = true;
            return false;
    }else{
            unit_price_alert.value = false;
    }

    //end validate
    form.preview_orders=[]
    total_bath.value = form.unit_purchase * form.unit_price;
    let show_total_bath =  total_bath.value.toFixed(2);
   // console.log('show_total_bath=='+show_total_bath);
   // return show_total_bath.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    form.preview_orders.push({
                                item_name:form.item,
                                material:form.material,
                                order_input:form.unit_purchase,
                                unit_count:form.unit_count,
                                price:form.unit_price,
                                business_name:form.business,
                                total:show_total_bath,
                            });
    //console.log(form.preview_orders)
    emits('previewOrder',  form.preview_orders);
}
</script>
