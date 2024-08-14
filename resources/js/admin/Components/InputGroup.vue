<script setup>
import TextInput from "@/admin/Components/TextInput.vue";
import InputLabel from "@/admin/Components/InputLabel.vue";
import InputError from "@/admin/Components/InputError.vue";

defineProps({
    modelValue: {},
    type: {
        type: String,
        default: "text",
    },
    label: {
        type: String,
        default: "",
    },
    errorMessage: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div>
        <InputLabel v-if="label"
               :value="label" />
        <TextInput :type="type"
               class="mt-1 block w-full"
               :model-value="modelValue"
               @update:model-value="$emit('update:modelValue', $event)"
               v-bind="$attrs" />
        <InputError v-if="errorMessage"
                    class="mt-1"
                    :message="errorMessage" />
    </div>
</template>