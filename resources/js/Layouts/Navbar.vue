<template>
    <div class="sticky top-0 z-40">
            <div class="w-full  px-6 py-2 bg-gray-100 border-b flex items-center justify-between">

              <!-- left navbar -->
              <div class="flex">

                <!-- mobile hamburger -->
                <div class="inline-block lg:hidden items-center mr-4">
                  <button class="hover:text-blue-500 hover:border-white focus:outline-none navbar-burger" @click="$emit('toggleSidebar')">
                    <svg class="h-5 w-5" v-bind:style="{ fill: 'black' }" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                  </button>
                </div>

                <!-- search bar -->
                <!-- <div class="relative text-gray-600">
                  <input type="search" name="serch" placeholder="Search products..." class="bg-white h-10 w-full xl:w-64 px-5 rounded-lg border text-sm focus:outline-none">
                  <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                      <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                    </svg>
                  </button>
                </div> -->

                <!-- Greeting word -->
                <!-- <div class="text-pink-400">
                  สวัสดี, คุณเจ้าหน้าที่
                </div> -->
              </div>

              <!-- right navbar -->
              <div class="w-full flex justify-between ">
                
                     <!-- <img src="/storage/images/hq_med_v3.png" class=""> -->
                <div>
                    <p class="font-semibold mt-2 text-2xl text-blue-400 ">
                    ระบบพัสดุ
                  </p>
                 
                </div>
                
                
                <div class=" flex flex-row  mt-4 text-md ">
                      <!-- <img src="https://a7sas.net/wp-content/uploads/2019/07/4060.jpeg" class="w-12 h-12 rounded-full shadow-lg" @click="dropDownOpen = !dropDownOpen"> -->
                  
                    <div class="text-pink-400  ">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div>
                         คุณ{{ $page.props.auth.user['name'] }}
                    </div>
                </div>

              </div>
            
              <div class=" bg-red-700 rounded-md text-white shadow-md p-2 ml-4">
                <form @submit.prevent="submit">
                  <button type="submit">LOGOUT</button>
                </form>
              </div>

            </div>

            <!-- dropdown menu -->
            <div class="absolute bg-gray-100 border border-t-0 shadow-xl text-gray-700 rounded-b-lg w-48 bottom-50 right-0 mr-6" :class="dropDownOpen ? '' : 'hidden'">
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">Account</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">Settings</a>
                <a href="/logout" class="block px-4 py-2 hover:bg-gray-200">Logout</a>
            </div>
            <!-- dropdown menu end -->

    </div>
</template>

<script>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    emits: ['toggleSidebar'],
    setup() {
        const dropDownOpen = ref(false);

        const submit=()=>{
          Inertia.post('/logout')
        }

        return {
          dropDownOpen,
          submit,
        }
    },
}
</script>