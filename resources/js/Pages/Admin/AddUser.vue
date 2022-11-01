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
        <div v-if="$page.props.flash.status=='warning'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-yellow-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status=='error'" 
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">
            
            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        sap test:  10032608 , โลหิต 10003133 ,หายใจ 10016895 ,พัสดุ 10019699 10030727
        <div class=" w-full text-sm p-4 my-2  justify-center bg-red-100">
            <p for="" class=" underline underline-offset-1 " >คำแนะนำการเพิ่มผู้ใช้งาน</p>
            <p for="">1.ระบุรหัสเจ้าหน้าที่ แล้วกดปุ่มตรวจสอบสถานะ แล้วตรวจสอบข้อมูลว่าเป็นบุคคลที่ต้องการเพิ่มเป็นผู้ใช้งานระบบนี้หรือไม่</p>
            <p for="">2.ระบุหน่วยงานภายในภาควิชาฯที่บุคคลนี้สังกัด ซึ่งหากสังกัดหน่วยงานใดก็จะมีสิทธิเข้าถึงคลังพัสดุของหน่วยงานนั้นเท่านั้น </p>
            <p for="">3.ระบุสิทธิการใช้งานระบบ (หากเป็นเจ้าหน้าที่สาขาที่ทำหน้าที่บันทึกตัดสต๊อก ให้ระบุสิทธิเป็น เจ้าหน้าที่)</p>
        </div> 
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">เพิ่ม/แก้ไข ผู้ใช้งาน</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="mt-3 " >
                    <label class=" text-lg font-bold text-green-600" >เพิ่มผู้ใช้งาน:</label> 
                    <label >ระบุรหัสเจ้าหน้าที่ 8 หลัก(SAP)</label> 
                    <button type="submit" 
                                class="  inline-flex text-sm ml-3 bg-blue-500 hover:bg-blue-700 text-white py-1 px-6 border border-blue-500 rounded"
                                @click="CheckEmployeeStatus()"
                                >
                                ตรวจสอบสถานะ
                            </button>
                </div>
                <div class="mt-3">
                    <input type="number" name="" class="w-full  py-2 rounded-md "   v-model="form.sap_id">
                    <!-- <label for="" v-if="employeeStatus=='active'" class=" p-4 text-green-600"> 
                        สถานะ:{{employeeStatus}}
                    </label> -->
                    <div class="mt-3">
                        <div v-if="employeeStatus=='found_user_med_stock'" 
                             class=" flex flex-col  text-red-600  text-center"
                         > 
                           <label for=""> สถานะ:พบรหัสเจ้าหน้าที่ตามที่ระบุในฐานข้อมูลผู้ใช้งานระบบพัสดุแล้ว </label>
                       
                        </div>
                        <label for="" v-if="employeeStatus=='not_found'" class="  text-red-600"> 
                            สถานะ:ไม่พบรหัสเจ้าหน้าที่ตามที่ระบุ
                        </label>
                        <label for="" v-if="employeeStatus=='withdrawn'" class="  text-red-600"> 
                            สถานะ: {{employeeAccountName}} เจ้าหน้าที่นี้ลาออกแล้ว
                        </label>
                    </div>
                </div>
            </div>

            <div v-if="employeeStatus=='active'">
                <div class=" bg-red-100 border-2 border-red-400 p-4 text-sm">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-600">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                        <p for="" class=" text-red-500 font-bold text-lg">กรุณาตรวจสอบความถูกต้องก่อนเพิ่มผู้ใช้งาน</p>
                    </div>
                
                    <label for="">ข้อมูลนี้ได้รับมาจากการเชื่อมโยงกับระบบของคณะฯ:</label>
                    <li>ชื่อ: {{form.employee_full_name}}</li>
                    <li>สังกัด: {{form.employee_division_name}}</li>
                    <li>ตำแหน่ง: {{form.employee_position_name}}</li>
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

                <div class=" mt-4 text-center">
                
                    <div>
                        <button type="submit" 
                            class=" w-full p-3 text-md  bg-green-500 hover:bg-green-700 text-white py-1 px-6 border border-green-500 rounded shadow-md"
                            @click="confirmAddUser()"
                            >
                            บันทึก
                        </button>
                    </div>
                        <!-- </form> -->
                </div>

            </div>
    
        </div>

        <!-- show all users-->
        <div 
                class="w-full   text-sm   my-2 rounded-md"
                >
                <label class=" text-lg font-bold ">รายชื่อผู้ใช้งานทั้งหมด:</label>
                <div v-for="(user,index_user) in  users" :key=index_user :value="user.id"
                    class=" bg-white p-2 my-2  lg:flex lg:justify-between border-b-2  border-gray-300 "
                >
                    <div class=" flex flex-col lg:flex-row ">
                        <div>
                            {{index_user+1}}. {{user.name}} ({{user.unit.unitname}})
                        </div>
                        <div>
                            <label class=" p-2 text-blue-600">สถานะ:</label>
                            <label class=" underline underline-offset-2">{{user.status_name}}</label>
                            
                        </div>
                        <!-- <div>
                            <label class=" p-2 text-blue-600">สิทธิ:</label>
                            <label class=" bg-red-100">{{user.unit.unitname}}</label>
                            
                        </div> -->
                        <div class="">
                                <label  class=" mx-2  text-xs ">
                                    แก้ไขล่าสุดเมื่อ: 
                                    {{dayjs(user.updated_at).locale('th').format('D MMM BBBB H:mm')}}
                                    น.
                                </label>
                        </div>
                       
                        <!-- <label for="" v-if="stock.status==1" class=" ml-4 "> สถานะ:ใช้งาน</label> -->
                    </div>
                    <div class="flex mx-2 justify-center   px-2  " >
                        
                        <a :href="route('show-detail-user',user.slug)" class=" px-4 mx-2 rounded-md shadow-md bg-yellow-200" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 bg-yellow-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>
                  
                        <a :href="route('show-log',user.slug)" class=" px-4 mx-2 rounded-md shadow-md bg-cyan-200" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  bg-cyan-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </a>
                        <!-- <button type="submit" 
                            class="   ml-4 px-2 text-md  bg-red-500 hover:bg-red-700 text-white  border border-red-500  rounded-md shadow-md"
                            @click="confirmDeleteStock()"
                            >
                            ลบ
                        </button> -->
                    </div>
                    <!-- <div class="flex mx-2 justify-center bg-cyan-200 px-2 rounded-md shadow-md " >
                        
                  
                        <a :href="route('show-log',user.slug)" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </a>
                   
                    </div> -->
                   
                </div>
  
            </div>
      

        <ModalUpToYou :isModalOpen="confirm_add_user" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการเพิ่มผู้ใช้งานนี้ใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium dark:text-white">
                     <label for="" class="  flex  justify-start w-full text-sm "
                     >
                         รหัสเจ้าหน้าที่: {{form.sap_id}} 
                        </label>
                    <label 
                            class="  flex  justify-start w-full text-sm ">
                            ชื่อเจ้าหน้าที่: {{form.employee_full_name}}
                    </label>
                    <label 
                            class="  flex  justify-start w-full text-sm ">
                            หน่วย/สาขา:{{getUnitname()}}
                    </label>
                    <label 
                            class="  flex  justify-start w-full text-sm ">
                            กำหนดสิทธิเป็น:{{getRolename()}}
                    </label>
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="addUser"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelAddUser"
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
import { useForm } from '@inertiajs/inertia-vue3';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import { ref } from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props =defineProps({
    stocks:Array,
    units:Object,
    roles:Object,
    users:Object,
 
    //stock_item_import: {type:Array, default:[]},
    
})



const stocks_unit = ref('');
const employeeStatus=ref('');
const employeeAccountName=ref('');
const confirm_add_user=ref(false);

const form = useForm({
    sap_id:'',
    unit_id:0,
    role_id:0,
    employee_full_name:'',
    employee_division_name:'',
    employee_division_id:'',
    employee_position_name:'',
    employee_account_name:'',
})

const confirmAddUser=(()=>{
  //console.log('----------confirmAddUser------');

  confirm_add_user.value = true;
})

const  cancelAddUser=()=>{
    confirm_add_user.value = false;
}

const getRolename = () => {
   // console.log('getRolename')
    let role = {}
    role = props.roles.find( item => item.id === form.role_id) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    return role.label
}

const getUnitname = () => {
  //  console.log('getUnitname')
    let unit = {}
    unit = props.units.find( item => item.unitid === form.unit_id) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    return unit.unitname
}




const getListStockUnit=(()=>{
    // console.log('----------getListStockUnit------')
    // console.log(form.unit_id);


    axios.get(route('get-list-stock-unit',{unit_id:form.unit_id})).then(res => {
       // console.log(res.data.stocks);
       stocks_unit.value = res.data.list_stock_unit;   
    });
})

const CheckEmployeeStatus=(()=>{


    form.unit_id=0
    form.role_id=0
    form.employee_full_name=''
    form.employee_division_name=''
    form.employee_division_id=''
    form.employee_position_name=''
    form.employee_account_name=''
    axios.get(route('check-employee-status',
                         {sap_id:form.sap_id }
                    )).then(res => {
                // console.log(res.data);
                // console.log(res.data.Status);
                employeeStatus.value =  res.data.status;
                employeeAccountName.value = res.data.login

                if(res.data.status == 'active')
                {
                    form.employee_full_name = res.data.full_name
                    form.employee_division_name = res.data.division_name
                    form.employee_division_id = res.data.division_id
                    form.employee_position_name = res.data.position_name
                    form.employee_account_name = res.data.login
                }

        });
})

const addUser=(()=>{
   // console.log('----------addUser------')
    // console.log(form.sap_id);
    // console.log(form.employee_account_name);
    // console.log(form.unit_id);
    // console.log(form.role_id);
    form.post(route('add-user'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
           
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { 
            console.log('finish add user');
            //add_user_success.value=true;
           // import_stock_items.value = res.data.stock_item_import;   
        },
    })

})
  
</script>