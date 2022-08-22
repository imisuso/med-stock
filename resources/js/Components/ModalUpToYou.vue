<template>
<!-- :class="{'hidden' : !isModalOpen}" -->
    <div v-if="isModalOpen" class="flex overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center sm:h-full bg-gray-800 bg-opacity-25" id="mymodal">
        <div :class="{'max-w-md' : modalSize === 'small', 'max-w-lg' : !modalSize, 'max-w-4xl' : modalSize === 'large', 'max-w-7xl' : modalSize === 'elarge' }" class="relative w-full px-4 h-screen md:h-auto">
            <div class="bg-white rounded-lg shadow relative top-5 dark:bg-gray-700">
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <slot name="header"></slot>
                </div>
                <div class="p-6 space-y-2">
                    <slot name="body"></slot>
                </div>
                <div class="flex space-x-2 items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    modalSize: { type: String },
    isModalOpen: { type: Boolean, required: true }
})

</script>