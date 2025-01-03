<template>
    <AppLayout>

        <div class="flex flex-col  mb-2 text-md font-bold text-gray-900 ">
            <div class=" m-2">
                <label for="">ระบุปีงบประมาณ:</label>
                <select name="" id="" v-model="form.year_selected"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-6 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        @change="getListBudget"
                    >
                    <option v-for="(year,index) in  years" :key=index v-bind:value="year">{{year+543}}</option>
                </select>
            </div>

        </div>
          <!-- {{stock_budgets}} -->
        <div>
            <h1 class=" text-center font-bold text-lg">รายการงบประมาณแต่ละสาขา</h1>
            <h1 v-if="year_search" class=" text-center font-bold text-lg">ประจำปีงบประมาณ {{year_search+ 543}}</h1>
          <!-- {{year_search}} -->
            <StockBudget v-for="(stock,key) in stock_budgets" :key="stock.id"
                :stockIndex="key"
                :stockBudget="stock"
                :budgetYear="year_search"
                />
        </div>

    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StockBudget from '@/Components/StockBudget.vue';
import { useForm,usePage  } from '@inertiajs/vue3';
import { ref } from 'vue';

const props =defineProps({
  years:{type:Object,required:true},
  stock_budgets:{type:Object},
  year_search:{type:Number},
})

const rerender=ref(true);
const form=useForm({
    year_selected:props.year_search ? props.year_search : '',
})


const getListBudget=()=>{
    // console.log('test');
    // console.log('getListBudget');

    form.get(route('get-list-budget'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => {
           // console.log('success');
        },
        onError: errors => {
            //console.log('error');
        },
        onFinish: visit => {
            //console.log('finish');
            },
    })

}

</script>
