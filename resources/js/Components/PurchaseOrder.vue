<template>
    <div >
        <label for=""  class=" px-6">
           {{orderIndex+1}}. วันที่สั่งซื้อ: {{orderItem.date_order}} 
            เป็นเงิน:{{approve_budget}} บาท
        </label>
       
    </div>
    <!-- <div class=" px-8">
         คงเหลือ {{balance_budget}} บาท
    </div> -->
</template>
<script setup>
const { ref }=require("@vue/reactivity")
const { onMounted }=require("@vue/runtime-core")

const props = defineProps({
    orderIndex:{type:Number,required:true},
    orderItem:{type:Object,required:true},
    
})

const approve_budget = ref(0);

onMounted(() => {
   // console.log('Component BudgetOrder');
   // console.log(props.orderItem.timeline['approve_budget'])
    approve_budget.value = props.orderItem['budget'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
   //  console.log(approve_budget.value)
})

// const balance=ref(0);


</script>
