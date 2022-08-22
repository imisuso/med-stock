<template>
   <AppLayout>
       <div class=" flex w-full h-52 justify-center bg-blue-100 rounded-md ">
           <p class=" my-2 ">ข่าวประชาสัมพันธ์</p> 
              {{ $page.props.flash.user_abilities }}
       </div>
  
       <!-- <div>
        <Card>
            <template #title>
                Advanced Card
            </template>
            <template #content>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt
                quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse, cupiditate neque quas!
            </template>
            <template #footer>
                <Button icon="pi pi-check" label="Save" />
                <Button icon="pi pi-times" label="Cancel" class="p-button-secondary" style="margin-left: .5em" />
            </template>
        </Card>
      </div> -->
   </AppLayout>
</template>

<script>
//import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    components: {
        AppLayout
    },
    props: {
       // user_name: { type: String, required: true },
       // can_abilities: { type: Object, required: true },
       // mainMenuLinks:{type: Object, required: true},
    },
    setup() {

    },
}
</script>