<template>
    <AppLayout>
         <!--Header Alert-->
         <div v-if="$page.props.flash.status=='success'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">แก้ไขข้อมูลคลังพัสดุ</p> 
            </div>
            
            <!-- {{stock}}--
            {{stock.unit}} -->
           
            <!-- {{count(stocks_unit)}} -->

            <div >
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">
               
                    <div class="mt-3" >
                        <label for="">หน่วยงาน/สาขา:</label> 
                    </div>
                    <label for=""> {{stock.unit['unitname']}}</label>
                </div>
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">
               
                    <div class="mt-3" >
                        <label for="">ระบุชื่อคลังพัสดุ(ภาษาไทย):</label> 
                    </div>
                    <input type="text" class="w-full  py-2 rounded-md "
                        v-model="form.stock_name_thai"
                    >
                
                </div>
                <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                
                    <div class="mt-3" >
                        <label for="">ระบุชื่อคลังพัสดุ(ภาษาอังกฤษ):</label> 
                    </div>
                    <input type="text" class="w-full  py-2 rounded-md "
                        v-model="form.stock_name_en"
                    >
                    
                </div>

           
              
                <div class="  ">
                    <button type="submit" 
                        class=" w-full flex justify-center py-2  text-md  bg-green-500 hover:bg-green-700 text-white  border border-green-500 rounded"
                        @click="confirmAddStock()"
                        >
                        แก้ไข
                    </button>
                </div>
    
            
            </div>
           

         
        </div>

        <ModalUpToYou :isModalOpen="confirm_add_stock" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการแก้ไขคลังพัสดุนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                     <label for=""
                     class="  flex  justify-start w-full text-sm "
                     >
                            หน่วย/สาขา:{{getUnitname()}}
                        </label>
                    <label 
                            class="  flex  justify-start w-full text-sm ">
                        <!-- ใบสั่งซื้อเลขที่:{{confirm_order_no}}/{{form.confirm_order_year}} ของ {{form.confirm_stockname_order}} -->
                        ชื่อคลัง: {{form.stock_name_thai}} ({{form.stock_name_en}})
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmAddStock"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelAddStock"
                    >
                        ยกเลิก
                    </button>
                </div>
            </template>
        </ModalUpToYou>

       
  
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';


const props =defineProps({
    stock:Array,
    unit:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

console.log(props.stock);
console.log(props.unit);

const confirm_add_stock=ref(false);


const show_form_add_stock=ref(false);

const showFormAddStock=()=>{
    show_form_add_stock.value=true
}

const  cancelAddStock=()=>{
    confirm_add_stock.value = false;
}

const form = useForm({
    unit:'',
    stock_name_thai:props.stock.stockname ? props.stock.stockname : '',
    stock_name_en:props.stock.stockengname ? props.stock.stockengname : '',

})

const getUnitname = () => {
    console.log('getUnitname')
    let unit = {}
    unit = props.units.find( item => item.unitid === form.unit) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    return unit.unitname
}




const confirmAddStock=(()=>{
  console.log('----------confirmAddStock------');
  //console.log(form.unit);
  //console.log(form.stock_name_thai);
  //console.log(unit_name);
 // console.log(getUnitname());

  confirm_add_stock.value = true;
})

const okconfirmAddStock=()=>{
    confirm_add_stock.value = false;
    // console.log(form.order_id);
       console.log('----------okconfirmAddStock------');
 
    
      form.post(route('stock-add-confirm'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
}


  
</script>