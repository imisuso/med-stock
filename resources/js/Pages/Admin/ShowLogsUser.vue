<template>
    <AppLayout>
   
        <div>
            {{user_change_logs}}
        </div>
       
  
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { useForm } from '@inertiajs/inertia-vue3';
import { ref ,computed} from 'vue';


const props =defineProps({

    user_change_logs:{type:Array,required:true},
    
})


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