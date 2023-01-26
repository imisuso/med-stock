<template>
    <AppLayout>
         <!--Header Alert-->
         <!-- {{status}} -->
        <!-- {{$page.props.flash.status}} -->
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
        
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">แก้ไขข้อมูลผู้ใช้งาน</p> 
            </div>
            
            <!-- {{user}}-- -->
           
            <!-- {{count(stocks_unit)}} -->

            <div >
                <div class=" w-full  bg-blue-100 rounded-md ">
               
                    <div class="mt-3" >
                        <label for="">ชื่อเจ้าหน้าที่:{{user.name}}</label> 
                    </div>
                    <!-- <label for=""> {{user.name}}</label> -->
                </div>
                <div class="mt-3" >
                        <label for="">ระบุหน่วยงานที่สังกัด:</label> 
                    </div>
                    <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                        v-model="form.unit_id"
                    
                    >
                        <option v-for="(unit) in  units" :key=unit.id :value="unit.unitid">{{unit.unitname}}</option>
                    </select>
                 <div class=" w-full  bg-blue-100  rounded-md ">
                    <div class=" w-full  bg-blue-100  rounded-md ">
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
                <div class="mt-3" >
                        <label for="">ระบุสถานะผู้ใช้งาน:</label> 
                    </div>
                        <div v-for="(status) in user_status_list" :key=status.id 
                            class="form-check">
                            <input type="radio" id="one"  :value="status.id" v-model="form.user_status" 
                                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                            />
                            <label for="one">{{status.desc}}</label>
                        </div>    
                </div>
                <div class="mt-3" >
                        <label for="">ชื่อผู้เพิ่มข้อมูล:{{user.profile['user_name_in']}}</label> 
                </div>
                <div class="  ">
                    <button type="submit" 
                        class=" w-full flex justify-center py-2  text-md  bg-green-500 hover:bg-green-700 text-white  border border-green-500 rounded"
                        @click="confirmEditUser()"
                        >
                        แก้ไข
                    </button>
                    <Link :href="route('user-add')"
                        class=" w-full flex justify-center my-2 py-2  text-md  bg-blue-500 hover:bg-blue-700 text-white  border border-blue-500 rounded"
                     >
                         กลับ
                    </Link>
                   
                </div>
                

            </div>
           
        </div>

        <ModalUpToYou :isModalOpen="confirm_edit_user" >
            <template v-slot:header>
                <p class="text-md font-bold text-red-600 ">คุณต้องการแก้ไขข้อมูลผู้ใช้งานใช่หรือไม่?</p> 
                                        
            </template>

            <template v-slot:body>
                <div class="text-gray-900 text-md font-medium ">
                  
                    <label  class="  flex  justify-start w-full text-sm ">
                        ชื่อ: {{user.name}} 
                    </label>
                    <label  class="  flex  justify-start w-full text-sm ">
                        หน่วย/สาขา:   {{getUnitname()}}
                    </label>
                    <label  class="  flex  justify-start w-full text-sm ">
                        สิทธิการใช้งานระบบ:   {{getRolename()}}
                    </label>
                    <label  class="  flex  justify-start w-full text-sm ">
                        สถานะ:   {{status_desc_selectd(form.user_status)}} 
                    </label>
                  
                </div>
            </template>

            <template v-slot:footer>
                <div class=" w-full  text-center  md:block">
                    <button 
                        class="mx-4 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                        v-on:click="okconfirmEditUser"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mx-4 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelEditUser"
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
import { useForm,Link } from '@inertiajs/vue3';
import { ref ,computed} from 'vue';


const props =defineProps({
    user:Array,
    user_status_list:{type:Array,required:true},
    units:Object,
    roles:Object,
    
})


const confirm_edit_user=ref(false);



const status_desc_selectd =(status)=>{
   // console.log(status)
    return  props.user_status_list[status-1].desc;
};

const role_desc_selectd =(role_id)=>{
    // console.log('role_id='+role_id)
    // console.log('role_desc='+props.roles[0].label)
    // console.log('==>'+props.roles[role_id].label)
    return  props.roles[role_id].label;
};

const getRolename = () => {
   // console.log('getRolename')
    let role = {}
    role = props.roles.find( item => item.id === form.role_id) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    form.role_name = role.name
    return role.label
}



const  cancelEditUser=()=>{
    confirm_edit_user.value = false;
}

const form = useForm({
   // unit:props.stock.unit_id,
    user_id:props.user.id,
    unit_id:props.user.unitid,
    role_id:props.user.roles[0]['id'],
    role_name:props.user.roles[0]['label'],
    user_name_thai:props.user.username ? props.user.name : '',
   // user_name_en:props.user.userengname ? props.user.userengname : '',
    user_status:props.user.status ? props.user.status : 0,
    
})

const getUnitname = () => {
   // console.log('getUnitname')
    let unit = {}
    unit = props.units.find( item => item.unitid === form.unit_id) // เอาค่าแรกที่เจอค่าเดียว
  //  console.log(unit)
    return unit.unitname
}

const confirmEditUser=(()=>{
  //console.log('----------confirmAddStock------');

  confirm_edit_user.value = true;
})

const okconfirmEditUser=()=>{
    confirm_edit_user.value = false;
    // console.log(form.order_id);
     //  console.log('----------okconfirmEditUser------');
      form.post(route('update-user',form.user_id), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
}
const getListUser=(()=>{
    // console.log('----------getListUser------')
    // console.log(form.unit);

    form.get(route('user-add'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { 
            console.log('success');
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { console.log('finish');},
    })
   
})

  
</script>