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
                <p class=" my-2 ">เพิ่มผู้ใช้งาน</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="mt-3" >
                    <label for="">ระบุรหัสเจ้าหน้าที่ 8 หลัก(SAP):</label> 
                    <button type="submit" 
                                class="  inline-flex text-sm ml-3 bg-blue-500 hover:bg-blue-700 text-white py-1 px-6 border border-blue-500 rounded"
                                @click="CheckEmployeeStatus()"
                                >
                                ตรวจสอบสถานะ
                            </button>
                </div>
                <input type="text" name="" class="w-full  py-2 rounded-md "   v-model="form.sap_id">
                 <label for="" v-if="employeeStatus=='Active'" class=" p-4 text-green-600"> 
                    สถานะ:{{employeeStatus}}
                 </label>
                 <label for="" v-else class=" text-red-600"> 
                    สถานะ:{{employeeStatus}} 
                </label>
            </div>

        <div v-if="employeeStatus=='Active'">
            <div class=" p-4 text-sm">
                <p for="" class=" text-red-500">กรุณาตรวจสอบความถูกต้องก่อนเพิ่มผู้ใช้งาน</p>
                <label for="">ข้อมูลที่ได้รับมาจากการเชื่อมโยงกับระบบของคณะฯ:</label>
                <li>ชื่อ: {{form.employee_full_name}}</li>
                <li>สังกัด: {{form.employee_division_name}}</li>
                <li>หมายเหตุ: {{form.employee_remark}}</li>
            </div>
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <!-- <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.auth.user.profile.division_name}}
                </div> -->
                <div class="mt-3" >
                    <label for="">ระบุหน่วยงานที่สังกัด:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit_id"
                
                >
                    <option v-for="(unit) in  units" :key=unit.id :value="unit.unitid">{{unit.unitname}}</option>
                </select>
            </div>
            <!-- <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                 
                </div>
                <div class="mt-3" >
                    <label for="">เลือกคลังพัสดุที่ต้องการให้บันทึกตัดสต๊อก:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    
                >
                    <option v-for="(stock) in  stocks_unit" :key=stock.id :value="stock.id">{{stock.stockname}}</option>
                </select>
                
            </div> -->

            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                 
                </div>
                <div class="mt-3" >
                    <label for="">ระบุสิทธิการใช้งานระบบ:</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                 v-model="form.role_id"
                >
                    <option v-for="(role) in  roles" :key=role.id :value="role.id">{{role.label}}</option>
                </select>
                
            </div>

            <div class=" text-center">
              
                        <div>
                            <button type="submit" 
                                class=" w-full text-sm  bg-green-500 hover:bg-green-700 text-white py-1 px-6 border border-green-500 rounded"
                              
                                >
                                ตกลง
                            </button>
                        </div>
                    <!-- </form> -->
            </div>

        </div>
           
         
        </div>
         sap test:  10032608 , โลหิต 10003133 ,หายใจ 10016895
        <div class=" w-full text-sm p-4 mt-2  justify-center bg-red-100">
            <p for="" class=" underline underline-offset-1 " >คำแนะนำการเพิ่มผู้ใช้งาน</p>
            <p for="">1.ระบุรหัสเจ้าหน้าที่ แล้วกดปุ่มตรวจสอบสถานะ หากสถานะเป็น Active ให้ตรวจสอบข้อมูลว่าเป็นบุคคลที่ต้องการเพิ่มเป็นผู้ใช้งานระบบนี้หรือไม่</p>
            <p for="">2.ระบุหน่วยงานภายในภาควิชาฯที่บุคคลนี้สังกัด ซึ่งหากสังกัดหน่วยงานใดก็จะมีสิทธิเข้าถึงคลังพัสดุของหน่วยงานนั้นเท่านั้น </p>
            <p for="">3.ระบุสิทธิการใช้งานระบบ (หากเป็นเจ้าหน้าที่สาขาทำหน้าที่บันทึกตัดสต๊อก ให้ระบุสิทธิเป็น เจ้าหน้าที่)</p>
        </div> 
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props =defineProps({
    stocks:Array,
    units:Object,
    roles:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

const stocks_unit = ref('');
const employeeStatus=ref('');
const employeeAccountName=ref('');




const form = useForm({
    sap_id:'10035479',
    unit_id:0,
    role_id:0,
    employee_full_name:'',
    employee_division_name:'',
    employee_division_id:'',
    employee_remark:'',
})

const getListStockUnit=(()=>{
    // console.log('----------getListStockUnit------')
    // console.log(form.unit_id);


    axios.get(route('get-list-stock-unit',{unit_id:form.unit_id})).then(res => {
       // console.log(res.data.stocks);
       stocks_unit.value = res.data.list_stock_unit;   
    });
})

const CheckEmployeeStatus=(()=>{

    axios.get(route('check-employee-status',
                         {sap_id:form.sap_id }
                    )).then(res => {
                // console.log(res.data);
                // console.log(res.data.Status);
                employeeStatus.value =  res.data.Status;
                employeeAccountName.value = res.data.AccountName

                if(res.data.Status == 'Active')
                {
                    form.employee_full_name = res.data.full_name
                    form.employee_division_name = res.data.division_name
                    form.employee_division_id = res.data.division_id
                    form.employee_remark = res.data.remark
                }

        });



})

// const ImportStockItem=(()=>{
//     // console.log('----------Import Stock------')
//     // console.log(form.unit_id);
//     // console.log(form.file_stock_item);
//     // console.log(form.stock_item_status);
//     // console.log(form.date_receive);
//     form.post(route('stock-item-import-show'), {
//         preserveState: true,
//         preserveScroll: true,
//         onSuccess: page => { console.log('success');},
//         onError: errors => { 
//             console.log('error');
//         },
//         onFinish: visit => { 
//             console.log('finish');
//            // import_stock_items.value = res.data.stock_item_import;   
//         },
//     })
// })
  
</script>