<template>
    
  <section class="  md:h-screen">
    <div class="px-6 h-full text-gray-800">
      <div
        class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full "
      >
     
        <div 
          class="w-full md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mt-8 md:mt-0 mb-12 md:mb-0 "
        >
          <div class=" flex justify-center text-xl ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
            </svg>
            <label class=" my-2 " >ข่าวประชาสัมพันธ์</label>
          </div>
       
    
          <div class=" flex flex-col p-2 bg-purple-200 rounded-md shadow-md">
             <label class=" font-bold py-2">  สวัสดี,วันที่ {{dayjs(new Date()).locale('th').format('D MMM BBBB HH:mm')}} น. </label>
            <!-- <label for="">วันนี้อากาศแจ่มใส </label> -->
            <p class="p-2"><label for="">ขอเชิญทดลองใช้ระบบพัสดุในการตัดสต๊อก</label></p>
            <p class="  p-2 underline underline-offset-1">
              <!-- {{doc_division_filename}}-- -->
            <!-- <a :href=" '../../../../../storage/docs/'+doc_division_filename " target="_blank"> -->
            <!-- <a href="../../../../docs/poster_teacher_ios.pdf" target="_blank">  -->
            <!-- <a :href="doc_division_filename" target="_blank">  -->
              <a href="../../../../docs/poster_division_med_stock.pdf" target="_blank">
              1.คู่มือสำหรับเจ้าหน้าที่สาขาบันทึกตัดสต๊อกพัสดุ
            </a>
            </p>
            <!-- <label class="py-4">- ทดสอบฝ่ายสารสนเทศคณะฯปิดปรับปรุงเครื่องแม่ข่ายวันที่ 31 ธันวาคม 2565 เวลา 23.59 ถึง 00.00 น. ส่งผลให้ไม่สามารถเข้าใช้งานระบบนี้ได้ในช่วงเวลาดังกล่าว ขออภัยในความไม่สะดวก</label>
            <label class="py-4">- ทดสอบฝ่ายสารสนเทศคณะฯปิดปรับปรุงเครื่องแม่ข่ายวันที่ 31 ธันวาคม 2565 เวลา 23.59 ถึง 00.00 น. ส่งผลให้ไม่สามารถเข้าใช้งานระบบนี้ได้ในช่วงเวลาดังกล่าว ขออภัยในความไม่สะดวก</label>
            <label class="py-4">- ทดสอบฝ่ายสารสนเทศคณะฯปิดปรับปรุงเครื่องแม่ข่ายวันที่ 31 ธันวาคม 2565 เวลา 23.59 ถึง 00.00 น. ส่งผลให้ไม่สามารถเข้าใช้งานระบบนี้ได้ในช่วงเวลาดังกล่าว ขออภัยในความไม่สะดวก ขออภัยในความไม่สะดวก ขออภัยในความไม่สะดวก ขออภัยในความไม่สะดวก ขออภัยในความไม่สะดวก</label> -->
            <!-- <label class="py-4">- officer.hemato,officer.chest,officer.endocrine</label>
            <label class="py-4">- officer.id,officer.nephro,admin_med_stock.stockmed,admin_it.itmed</label> -->
         
          </div>
          <div v-for="(annouce,key) in annouces" :key="annouce.id" 
                class="flex flex-col my-2 p-2 bg-red-200 rounded-md shadow-md  "
                    >
                    <p class=" underline underline-offset-2 ">  ข่าวที่ {{key+1}}.</p>
                    <p class=" ">   {{annouce.message}}</p>
                    <p class=" mt-6 text-sm text-red-800">  [วันที่ประกาศ: {{ dayjs(annouce.updated_at).locale('th').format('D MMM BBBB HH:mm')}} น.]</p>
          </div>
       
        
        
        </div>
        <div class=" xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12  md:mb-0">
        
            <div class=" flex justify-center ">
              <!-- <img src="../../../../public/storage/images/logo_med_tranparent.gif"  > -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
              </svg>
              <label class=" p-4 text-xl">ระบบพัสดุ (MED-STOCK)</label>
            </div>

            <div class="my-4 text-md text-gray-800  ">
              <p class="underline underline-offset-1"> Login ด้วย Siriraj AD  (ใช้ User ID และ Password เดี่ยวกับระบบ e-Document)</p>
            </div>

         

            <!-- Email input -->
            <div class="mb-6">
              <input
                type="text"
                placeholder="ชื่อ.นามสกุล 3 ตัว (ภาษาอังกฤษ)"
                class="form-control block w-full px-4 py-2 text-md font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                v-model="form.username"
              />
            </div>

            <!-- Password input -->
            <div class="mb-6">
              <input
                type="password"
                class="form-control block w-full px-4 py-2 text-md font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                v-model="form.password"
              />
            </div>

            <div  v-if="$page.props.flash.status"
             class=" bg-red-500 text-white p-2 my-2 ">
              {{$page.props.flash.msg}}
            </div>

            <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" 
                v-on:click="authAD">
              เข้าสู่ระบบ
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" 
                  href="https://si-eservice3.si.mahidol.ac.th/selfservice/"
                  target="_blank">
              ลืม Password?
            </a>
          </div>
     
        </div>
      </div>
    </div>
  </section>

</template>
<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import 'dayjs/locale/th'
import buddhistEra from 'dayjs/plugin/buddhistEra'
dayjs.extend(buddhistEra)

const props =defineProps({
  status:{type:String},
  annouces:{type:Object},
  //doc_division_filename:{type:String}
})

const form = useForm({
  username:'',
  password:''

})

const authAD=()=>{

    // console.log(form.order_id);
      // console.log('----------authAD------');
      form.post(route('login'), {
        preserveState: false,
        preserveScroll: true,
        onSuccess: page => { //console.log('success');
        },
        onError: errors => { 
            console.log('error');
        },
        onFinish: visit => { //console.log('finish');
        },
    })
}



</script>