<template>
    <AppLayout>

        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ระบุปีงบประมาณ:</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline" 
                    @Change="getListBudget"
                    >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>
            
        </div>
          <!-- {{stock_budgets}} -->
        <div>
            <h1 class=" text-center font-bold text-lg">รายการงบประมาณแต่ละสาขา</h1>
            <h1 v-if="form.year_selected" class=" text-center font-bold text-lg">ประจำปีงบประมาณ {{form.year_selected + 543}}</h1>
          
            <StockBudget v-for="(stock,key) in stock_budgets" :key="stock.id" 
                :stockIndex="key"
                :stockBudget="stock" 
                :budgetYear="form.year_selected"
                />
        </div>
     
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StockBudget from '@/Components/StockBudget.vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import {  ref } from '@vue/reactivity';


defineProps({
  years:{type:Object,required:true},
})

//const years=ref([2021,2022])
//const balance_budget = ref(0);
//const sum_order = ref(0);
//const stock_order = ref('');
const stock_budgets = ref('');
const rerender=ref(true);

const form=useForm({
    year_selected:'',
})


const getListBudget=()=>{
    //console.log('getListBudget');

    // form.get(route('get-list-budget'), {
    //         preserveState: false,
    //         preserveScroll: true,
    //         onSuccess: page => { 
    //             console.log('success');
    //             },
    //         onError: errors => { 
    //             console.log('error');
    //         },
    //         onFinish: visit => { console.log('finish');},
    // })
  

    axios.get(route('get-list-budget',{year:form.year_selected})).then(res => {
       // console.log(res.data.stocks);
        stock_budgets.value = res.data.stocks;   
    });
   // forceUpdate();
}

</script>
