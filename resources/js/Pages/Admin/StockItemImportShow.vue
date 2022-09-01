<template>
    <AppLayout>
        <div class=" w-full p-4  text-center text-lg font-bold bg-blue-100 rounded-md ">
            <div class=" ">
                <p class=" my-2 ">Import Excel Stock Item</p> 
            </div>
            <div>
                <label for="">{{stocks}}</label> 
            </div>
            <div>
                <label for="" v-if="stock_item_status==1">จากใบสัญญาสั่งซื้อ</label>
                <label for="" v-else>จากใบสั่งซื้อ</label>
            </div>
        </div>  
 
        <div>
            <div class=" border p-1 " 
                v-for="(item_import,index) in stock_item_import"
                :key="index"
            >
                {{item_import.item_code}}-{{item_import.item_name}}
            </div>
            
        </div> 
    </AppLayout>
 </template>
 <script setup>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props =defineProps({
    stocks:{type:String},
    stock_item_status:{type:Number},
    stock_item_import: {type:Array, default:[]},
    
})

const stock_item_types=[{'type_id':'1','type_name':'ใบสัญญาสั่งซื้อ'},
                      {'type_id':'2','type_name':'ใบสั่งซื้อ'}
                     ]


const form = useForm({
    file_stock_item: File,
    unit_id:0,
    stock_item_status:0,
})





const ImportStockItem=(()=>{
    console.log('----------Import Stock------')
    console.log(form.unit_id);
    console.log(form.file_stock_item);
    console.log(form.stock_item_status);
    form.post(route('stock-item-import-show'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => { console.log('success');},
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { 
            console.log('finish');
           // import_stock_items.value = res.data.stock_item_import;   
        },
    })
})
  
</script>