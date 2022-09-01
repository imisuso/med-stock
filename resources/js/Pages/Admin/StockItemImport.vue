<template>
    <AppLayout>
        <div class=" w-full p-4 flex-col justify-center bg-blue-100 rounded-md ">
            <div class=" text-center text-lg font-bold ">
                <p class=" my-2 ">Import Excel Stock Item</p> 
            </div>
            
               <!-- {{ $page.props.unit }}

               {{ $page.props.stocks }} -->
            <div class=" w-full  bg-blue-100 p-2 rounded-md ">
                <div class="bg-blue-800 text-white text-xl text-center ">
                    {{$page.props.unit.unitname}}
                </div>
                <div class="mt-3" >
                    <label for="">เลือกคลังพัสดุที่ต้องการเพิ่มพัสดุ</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.unit_id"
                >
                    <option v-for="(stock) in  stocks" :key=stock.id :value="stock.id">{{stock.stockname}}</option>
                </select>
                <div class="mt-3" >
                    <label for="">เลือกประเภทการจัดซื้อพัสดุ</label> 
                </div>
                <select name="" id="" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    v-model="form.stock_item_status"
                >
                    <option v-for="(stock_item_types) in  stock_item_types" :key=stock_item_types.type_id :value="stock_item_types.type_id">{{stock_item_types.type_name}}</option>
                </select>
           
            </div>
            <div class=" text-center">
                    <!-- @if(session('status'))
                        <div class=" alert alert-success">
                            {{ session('status')}}
                        </div>
                    @endif -->
                    <!-- <form action="" method="post" enctype="multipart/form-data"> -->
                        <div class="">
                            <input type="file" name="file" id="" @change="onChangeFile">
                            <button type="submit" 
                                class="  inline-flex text-sm ml-3 bg-green-500 hover:bg-green-700 text-white py-1 px-4 border border-green-500 rounded"
                                @click="ImportStockItem()"
                                >
                                Import
                            </button>
                        </div>
                    <!-- </form> -->
            </div>
        </div>
        <div>
            {{stock_item_import}}
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
    unit:Object,
    //stock_item_import: {type:Array, default:[]},
    
})

const stock_item_types=[{'type_id':'1','type_name':'ใบสัญญาสั่งซื้อ'},
                      {'type_id':'2','type_name':'ใบสั่งซื้อ'}
                     ]


const form = useForm({
    file_stock_item: File,
    unit_id:0,
    stock_item_status:0,
})

const onChangeFile=((e)=>{
    console.log(e.target.files[0])
    form.file_stock_item = e.target.files[0];
})

// const getStockItemFromExcel = () => {
//     console.log('getListPurchase');


//     Inertia.get(route('purchase-order-list'), { year: form.year_selected }, {
//         preserveState: true,
//         replace: true
//     })
//    // forceUpdate();
// }

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