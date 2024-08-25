<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const message = ref("");
const timeoutHandler = ref(null);

watch([ () => usePage().props.flash?.error, () => usePage().props.flash?.success ], ( [errorMessage, successMessage] ) => {
//   console.log(`x is ${errorMessage} and y is ${successMessage}`)
    if (errorMessage) {
        message.value = errorMessage;
    } else if (successMessage) {
        message.value = successMessage;
    }
    clearTimeout(timeoutHandler.value);
    timeoutHandler.value = setTimeout(() => {
        message.value = null;
        usePage().props.flash.error = null;
    }, 3000)

})

</script>

<template>
    <div v-if="message" :class="{'bg-green-600' : usePage().props.flash?.success, 'bg-danger-600': usePage().props.flash?.error}" class="text-white rounded fixed right-0 top-0 px-4 py-2 mr-4 mt-4 z-10" style="z-index: 9999;">{{ message }}
    </div>
</template>
