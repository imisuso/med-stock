<template>
    <div class="leading-normal tracking-normal" id="main-body">
        
        <div class="flex flex-col  bg-green-300 ">
  
            <div class="w-full flex justify-between  py-6 px-6 bg-blue-200 ">
                
                <!-- <img src="/storage/images/hq_med_v3.png" class=""> -->
              
                <div class=" flex  text-md ">
                    <!-- <p class="font-semibold mt-2 text-2xl text-blue-400 "> -->
                        <a :href="route('annouce')"  >
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-6 h-6 font-semibold  text-2xl text-blue-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                          </svg>
                  
                      </a>  
                    <a :href="route('annouce')"  
                    class="font-semibold text-xl text-blue-700 "
                    >
                        ระบบพัสดุ
                    </a>  
                    <!-- </p> -->
                    
                </div>
            
            
                <div class=" flex  text-sm  ">
                        <!-- <img src="https://a7sas.net/wp-content/uploads/2019/07/4060.jpeg" class="w-12 h-12 rounded-full shadow-lg" @click="dropDownOpen = !dropDownOpen"> -->
                    
                    <div class="text-pink-400  ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    </div>
                  
                        {{$page.props.auth.user.name}}
                
                </div>

            </div>
  
            <div class="w-full bg-gray-100 pl-0 4 min-h-screen" id="main-content">
    
        
    
                <div class="  p-6   bg-white mb-20">
                    <!-- Page Content -->
                    <!-- <main> -->
                        <slot></slot>
                    <!-- </main> -->
                </div>
    
            <!-- <Footer /> -->
    
            </div>
        </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';

  import Navbar from '@/Layouts/Navbar.vue'
  export default {
      components: {
           Navbar,
      },
  
    //   setup() {
    //     const sideBarOpen = ref(false)
  
    //     const sideMenuShowHide = () => {
    //       sideBarOpen.value = !sideBarOpen.value
    //       //console.log(sideBarOpen.value)
    //     }
  
    //     return {
    //       sideBarOpen,
    //       sideMenuShowHide
    //     }
    //   },
  }
  </script>
  <style>
  
      /*Banner open/load animation*/
      .alert-banner {
          -webkit-animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                  animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
      }
  
      /*Banner close animation*/
      .alert-banner input:checked ~ * {
          -webkit-animation: slide-out-top 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
                  animation: slide-out-top 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;		
      }
  
      /*Footer open/load animation*/
      .alert-footer {
          -webkit-animation: slide-in-bottom 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                  animation: slide-in-bottom 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;	
      }
  
      /*Footer close animation*/
      .alert-footer input:checked ~ * {
          -webkit-animation: slide-out-bottom 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
                  animation: slide-out-bottom 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
      }
  
      /*Toast open/load animation*/
      .alert-toast {
          -webkit-animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                  animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
      }
  
      /*Toast close animation*/
      .alert-toast input:checked ~ * {
          -webkit-animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                  animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
      }
  
      /* -------------------------------------------------------------
       * Animations generated using Animista * w: http://animista.net, 
       * ---------------------------------------------------------- */
  
      @-webkit-keyframes slide-in-top{0%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-top{0%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@-webkit-keyframes slide-out-top{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}}@keyframes slide-out-top{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}}@-webkit-keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@-webkit-keyframes slide-out-bottom{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}}@keyframes slide-out-bottom{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}}@-webkit-keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}@keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}@-webkit-keyframes fade-out-right{0%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}100%{-webkit-transform:translateX(50px);transform:translateX(50px);opacity:0}}@keyframes fade-out-right{0%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}100%{-webkit-transform:translateX(50px);transform:translateX(50px);opacity:0}}
      
    </style>