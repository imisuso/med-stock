<template>
    <AppLayout>
         <!--Header Alert-->
         <div v-if="$page.props.flash.status==='success'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-green-300 shadow rounded-md text-green-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status==='warning'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-yellow-200 shadow rounded-md text-yellow-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <div v-if="$page.props.flash.status==='error'"
            class="alert-banner  fixed  right-0 m-4 w-2/3 md:w-full max-w-sm ">
            <input type="checkbox" class="hidden" id="banneralert">

            <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-200 shadow rounded-md text-red-800 font-bold" title="close" for="banneralert">
                {{ $page.props.flash.msg }}
                <svg class="fill-current text-red " xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
        <!-- sap test:  10032608 , โลหิต 10003133 ,หายใจ 10016895 ,วัสดุ 10019699 10030727 -->
        <div class=" w-full text-sm p-4 my-2  justify-center bg-red-100">
            <p  class=" underline underline-offset-1 " >คำแนะนำการเพิ่มผู้ใช้งาน</p>
            <p >1.ระบุรหัสเจ้าหน้าที่ แล้วกดปุ่มตรวจสอบสถานะ แล้วตรวจสอบข้อมูลว่าเป็นบุคคลที่ต้องการเพิ่มเป็นผู้ใช้งานระบบนี้หรือไม่</p>
            <p >2.ระบุหน่วยงานภายในภาควิชาฯที่บุคคลนี้สังกัด ซึ่งหากสังกัดหน่วยงานใดก็จะมีสิทธิเข้าถึงคลังวัสดุของหน่วยงานนั้นเท่านั้น </p>
            <p >3.ระบุสิทธิการใช้งานระบบ (หากเป็นเจ้าหน้าที่สาขาที่ทำหน้าที่บันทึกตัดสต๊อก ให้ระบุสิทธิเป็น เจ้าหน้าที่)</p>
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
                        <div v-if="employeeStatus==='found_user_med_stock'"
                             class=" flex flex-col  text-red-600  text-center"
                         >
                           <label for=""> สถานะ:พบรหัสเจ้าหน้าที่ตามที่ระบุในฐานข้อมูลผู้ใช้งานระบบวัสดุแล้ว </label>

                        </div>
                        <label for="" v-if="employeeStatus==='not_found'" class="  text-red-600">
                            สถานะ:ไม่พบรหัสเจ้าหน้าที่ตามที่ระบุ
                        </label>
                        <label for="" v-if="employeeStatus==='withdrawn'" class="  text-red-600">
                            สถานะ: {{employeeAccountName}} เจ้าหน้าที่นี้ลาออกแล้ว
                        </label>
                        <label for="" v-if="employeeStatus==='error'" class="  text-red-600">
                            สถานะ: error check username -->[{{ employeeAccountName }}]
                        </label>
                        <label for="" v-if="employeeStatus==='error_sap'" class="  text-red-600">
                            สถานะ: error -->[{{ employeeAccountName }}]
                        </label>
                    </div>
                </div>
            </div>

            <div v-if="employeeStatus==='active'">
                <div class=" bg-red-100 border-2 border-red-400 p-4 text-sm">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-600">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                        </svg>
                        <p class=" text-red-500 font-bold text-lg">กรุณาตรวจสอบความถูกต้องก่อนเพิ่มผู้ใช้งาน</p>
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

        <div>
            <div class="w-full   my-2 text-center">
                <label class=" text-lg font-bold  text-blue-700 ">รายชื่อผู้ใช้งานทั้งหมด </label>
            </div>
            <paginateMe :pagination="users" />
            <div
                class="w-full   border-b-4 border-gray-500 shadow-sm hidden lg:block ">
                <div class="flex flex-col  lg:flex-row"  >

                    <div class=" lg:w-3/12  ">
                       ชื่อ
                    </div>

                    <div class=" lg:w-3/12 ">
                        หน่วยงาน/สาขา
                    </div>
                    <div class=" lg:w-1/12 ">
                        สถานะ
                    </div>
                    <div class=" lg:w-3/12 ">
                        วันที่แก้ไขข้อมูลล่าสุด
                    </div>
                    <div class=" lg:w-2/12 ">
                        ::
                    </div>

                </div>
            </div>
        </div>
        <!-- end head table -->

        <div class=" " >

                <div v-for="(user,index_user) in  users.data" :key=index_user :value="user.id"
                    class="w-full border-b-2 my-2  border-gray-500 shadow-sm "
                >

                    <div class="flex flex-col  lg:flex-row   "  >

                        <div class=" bg-green-50 lg:bg-transparent lg:w-3/12 ">

                            <div >
                                <!-- {{row_start(users.from,index_user)}}.  -->
                                {{users.from+index_user}}.
                               {{user.name}}
                            </div>

                        </div>

                        <div class=" bg-green-50 lg:bg-transparent lg:w-3/12 lg:text-xs">
                            <label class="">{{user.unit.unitname}}</label>
                        </div>

                        <div class=" bg-green-50 lg:bg-transparent lg:w-1/12 ">
                            <label for="" class="   lg:hidden">สถานะ:</label>
                            <label class="">{{user.status_name}}</label>
                        </div>

                        <div class=" bg-green-50 lg:bg-transparent lg:w-3/12 lg:text-xs">
                            <label for="" class="   lg:hidden">วันที่แก้ไขข้อมูลล่าสุด:</label>
                            <label  class=" mx-2  text-xs ">
                                {{dayjs(user.updated_at).locale('th').format('D MMM BBBB H:mm')}}
                                    น.
                            </label>
                        </div>
                        <div class=" flex  bg-green-50 lg:bg-transparent lg:w-2/12 " >

                            <a :href="route('show-detail-user',user.slug)" class="  rounded-md shadow-md bg-yellow-200" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 bg-yellow-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>

                             <a :href="route('get-user-log',user)" class=" mx-2  rounded-md shadow-md bg-blue-300" >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </a>

                        </div>

                    </div>
                </div>

            </div>

        <ModalUpToYou :isModalOpen="confirm_add_user" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการเพิ่มผู้ใช้งานนี้ใช่หรือไม่?</p>

            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">
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
import { useForm } from '@inertiajs/vue3';
import ModalUpToYou from '@/Components/ModalUpToYou.vue'
import PaginateMe from '@/Components/PaginateMe.vue';
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
    user_change_logs:{type:Array},

    //stock_item_import: {type:Array, default:[]},

})
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
  confirm_add_user.value = true;
})

const  cancelAddUser=()=>{
    confirm_add_user.value = false;
}

const getRolename = () => {
    let role = {}
    role = props.roles.find( item => item.id === form.role_id) // เอาค่าแรกที่เจอค่าเดียว
    return role.label
}

const getUnitname = () => {
    let unit = {}
    unit = props.units.find( item => item.unitid === form.unit_id) // เอาค่าแรกที่เจอค่าเดียว
    return unit.unitname
}



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

                employeeStatus.value =  res.data.status;
                employeeAccountName.value = res.data.login
                if(res.data.status === 'error_sap')
                {
                    employeeAccountName.value = res.data.msg_error
                }
                if(res.data.status === 'active')
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

    form.post(route('add-user'), {
        preserveState: false,
        preserveScroll: true,

    })

})

</script>
