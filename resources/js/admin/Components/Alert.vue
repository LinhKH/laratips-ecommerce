<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch, onMounted } from "vue";
const message = ref("");


watch(
    () => usePage().props.flash?.success,
    (successMessage) => message.value = successMessage,
    {
        immediate: true
    }
);

onMounted(() => {
    setTimeout(() => {
        message.value = null
    }, 3000)
});

</script>

<template>
    <div v-if="message" class="bg-green-600 text-white rounded fixed right-0 top-0 px-4 py-2 mr-4 mt-4 z-10">{{ message }}
    </div>
</template>
