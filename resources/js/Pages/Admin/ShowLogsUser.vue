<template>
    <AppLayout>
   
        <div class=" text-blue-700 underline underline-offset-1">
           ประวัติการเปลี่ยนแปลงข้อมูลของ {{user_name}}
        </div>
        <div class="w-full hidden lg:flex border-b-2 my-2 bg-blue-100  border-gray-500 shadow-sm ">
            <div class=" w-2/12">
                   <p>วันที่บันทึก/แก้ไข</p>
            </div>
            <div class=" w-3/12"><p>ผู้กระทำ</p></div>
            <div class=" w-2/12">การกระทำ</div>
            <div class=" w-5/12">รายละเอียดข้อมูลที่แก้ไข</div>
        </div>
        <div v-for="(user_log,index_user) in  user_change_logs" :key=index_user :value="user_log.id"
                    class="w-full lg:flex border-b-2 my-2  border-gray-500 shadow-sm "
                >
                
                <div class=" lg:w-2/12">
                 {{index_user+1}}.   {{ dayjs(user_log.created_at).locale('th').format('D MMM BBBB HH:mm')}} น.
                </div>
                <div class="lg:w-3/12 text-sm ">{{user_log.user.name}}</div>
                <div class="lg:w-2/12 text-sm ">{{user_log.action}}</div>
                <div v-if=" user_log.action=='add_user' " class="lg:w-5/12 ">-</div>
                <div v-else class="lg:w-5/12 ">
                    <div v-for="(old,index) in user_log.old_value" :key="index" :value="old.id">
                       <p class=" font-bold ">{{index+1}}. column:[{{old.column}}] </p>   
                       <p v-if="old.column=='status'" class=" text-gray-500">
                            ข้อมูลเดิม:[{{status_desc(old.old)}}]    ข้อมูลใหม่:[{{status_desc(old.new)}}] 
                        </p>
                        <p v-else class=" text-gray-500">
                            ข้อมูลเดิม:[{{old.old}}]    ข้อมูลใหม่:[{{old.new}}] 
                        </p>
  
                    </div>
                    <!-- {{user_log.old_value}} -->
                </div>
        </div>  
       
  
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)


const props =defineProps({

    user_change_logs:{type:Array,required:true},
    user_name:{type:String},
    
})

const status_desc =(status)=>{
   // console.log(status)
   if(status==1)
     return  'ปกติ';
   else
    return 'ยกเลิก';
};
// const confirm_edit_user=ref(false);



// const status_desc_selectd =(status)=>{
//    // console.log(status)
//     return  props.user_status_list[status-1].desc;
// };

// const role_desc_selectd =(role_id)=>{
//     // console.log('role_id='+role_id)
//     // console.log('role_desc='+props.roles[0].label)
//     // console.log('==>'+props.roles[role_id].label)
//     return  props.roles[role_id].label;
// };

// const getRolename = () => {
//    // console.log('getRolename')
//     let role = {}
//     role = props.roles.find( item => item.id === form.role_id) // เอาค่าแรกที่เจอค่าเดียว
//   //  console.log(unit)
//     form.role_name = role.name
//     return role.label
// }



// const  cancelEditUser=()=>{
//     confirm_edit_user.value = false;
// }

// const form = useForm({
//    // unit:props.stock.unit_id,
//     user_id:props.user.id,
//     unit_id:props.user.unitid,
//     role_id:props.user.roles[0]['id'],
//     role_name:props.user.roles[0]['label'],
//     user_name_thai:props.user.username ? props.user.name : '',
//    // user_name_en:props.user.userengname ? props.user.userengname : '',
//     user_status:props.user.status ? props.user.status : 0,
    
// })

// const getUnitname = () => {
//    // console.log('getUnitname')
//     let unit = {}
//     unit = props.units.find( item => item.unitid === form.unit_id) // เอาค่าแรกที่เจอค่าเดียว
//   //  console.log(unit)
//     return unit.unitname
// }

// const confirmEditUser=(()=>{
//   //console.log('----------confirmAddStock------');

//   confirm_edit_user.value = true;
// })

// const okconfirmEditUser=()=>{
//     confirm_edit_user.value = false;
//     // console.log(form.order_id);
//      //  console.log('----------okconfirmEditUser------');
//       form.post(route('update-user',form.user_id), {
//         preserveState: false,
//         preserveScroll: true,
//         onSuccess: page => { console.log('success');},
//         onError: errors => { 
//             console.log('error');
//         },
//         onFinish: visit => { console.log('finish');},
//     })
// }


  
</script>