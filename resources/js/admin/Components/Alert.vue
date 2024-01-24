<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const message = ref("");
const timeoutHandler = ref(null);


watch(
    () => usePage().props.flash?.success,
    (successMessage) => {
        message.value = successMessage;

        if (successMessage) {
            clearTimeout(timeoutHandler.value);
            timeoutHandler.value = setTimeout(() => {
                message.value = null;
                usePage().props.flash.success = null;
            }, 3000)
        }
    },
    {
        immediate: true,
        deep: true
    }
);

</script>

<template>
    <div v-if="message" class="bg-green-600 text-white rounded fixed right-0 top-0 px-4 py-2 mr-4 mt-4 z-10">{{ message }}
    </div>
</template>
