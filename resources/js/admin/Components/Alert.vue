<template>
    <div v-if="message" class="bg-green-600 text-white rounded fixed right-0 top-0 px-4 py-2 mr-4 mt-4 z-10">{{ message }}
    </div>
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
const message = ref(usePage().props.flash?.success);

onMounted(() => {
    setTimeout(() => {
        message.value = ""
    }, 3000);
});
</script>
