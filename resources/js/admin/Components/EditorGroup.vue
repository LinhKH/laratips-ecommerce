<script setup>
import { ref } from "vue";
import Editor from "@tinymce/tinymce-vue";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
    modelValue: {},
    label: {
        type: String,
        default: "",
    },
    errorMessage: {
        type: String,
        default: "",
    },
});

const config = ref({
    height: 300,
});
</script>

<template>
    <div>
        <InputLabel v-if="label"
               :value="label" />
        <editor api-key="jpamoi4osp74tob1cw02x5sn5vu8g2hf8b77x8t16kew9tdk"
                :model-value="modelValue"
                @update:model-value="$emit('update:modelValue', $event)"
                :init="config"
                v-bind="$attrs" />
        <InputError v-if="errorMessage"
                    class="mt-1"
                    :message="errorMessage" />
    </div>
</template>