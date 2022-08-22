<template>
          <div 
                class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"  
                id="modal-id">
            <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
            <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
            <!--content-->
            <div class="">
                <!--body-->
                <div class="text-center p-5 flex-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                                <!-- <h2 class="text-xl font-bold py-3 ">Are you sure?</h2> -->
                                <p class="text-md font-bold text-red-600 py-3 px-8">คุณต้องการบันทึกการเบิกพัสดุรายการนี้ใช่หรือไม่?</p> 
                                <p class="mt-2">{{confirm_item_name}} วันที่ {{ confirm_item_date}} จำนวน {{confirm_item_count}}</p>   
                </div>
                <!--footer-->
                <div class="p-3  mt-2 text-center space-x-4 md:block">
                    <button 
                        class="mb-2 md:mb-0 bg-green-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-white rounded-full hover:shadow-lg hover:bg-green-400"
                         v-on:click="OKConfirmCheckout"
                        >
                        ตกลง
                    </button>
                    <button 
                        class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        v-on:click="cancelConfirmCheckout"
                      >
                        ยกเลิก
                    </button>
                </div>
            </div>
            </div>
        </div>
</template>
<script>
export default {
    props: {
        confirm_item_name:String,
        confirm_item_date:String,
        confirm_item_count:String,
    },
    data() {
        return {
           // confirm_checkout: 0,
            confirm_ok: 0,
            confirm_cancel: 0,
        }
    },
    methods :{
        cancelConfirmCheckout(){
            this.confirm_checkout = 0;
            this.confirm_cancel = 1;
        },
        OKConfirmCheckout(){
            this.confirm_checkout = 0;
            this.confirm_ok = 1;
        }
    }
}
</script>