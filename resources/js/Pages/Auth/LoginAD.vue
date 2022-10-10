<template>
    <div class="w-full bg-repeat " style="background-image: url('/images/BrickWall.svg')">
        <!-- <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' transform='scale(2)'><rect x='0' y='0' width='100%' height='100%' fill='hsla(0,0%,100%,1)'/><path d='M0 22.5h30v15H0zm15-15h30v15H15m-30-15h30v15h-30zm15-15h30v15H0z'  stroke-width='1' stroke='hsla(258.5,59.4%,59.4%,1)' fill='none'/></svg> -->
       
    </div>
      <div class=" bg-blue-100 shadow-md rounded p-10 flex flex-col">
        
        <div class=" w-full flex justify-center text-3xl ">
            <label for="">ระบบพัสดุ</label>
        </div>
          <div class="my-4 text-lg text-gray-800 bg-gray-200">
           
              <p> Login ด้วย Siriraj AD  (ใช้ User ID และ Password เดี่ยวกับ SiIT Enterprise ปัจจุบัน)</p>
          </div>
          <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
              Username
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" 
              id="username" name="username" type="text" placeholder="ชื่อ.นามสกุล 3 ตัว (ภาษาอังกฤษ)">
          </div>
          <div class="mb-6">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
              Password
            </label>
            <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" 
              id="password" name="password" type="password" placeholder="******************">
          
          </div>

          <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="submit">
              เข้าสู่ระบบ
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" 
                  href="https://si-eservice3.si.mahidol.ac.th/selfservice/"
                  target="_blank">
              ลืม Password?
            </a>
          </div>
      </div>
</template>