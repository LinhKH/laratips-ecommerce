<script setup>
import Checkbox from "@/admin/Components/Checkbox.vue";
import InputLabel from "@/admin/Components/InputLabel.vue";
import InputError from "@/admin/Components/InputError.vue";

defineProps({
    value: {},
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
        <InputLabel>
            <Checkbox :value="value" @update:checked="$emit('update:checked', $event)" v-bind="$attrs" />
            {{ label }}
        </InputLabel>

        <InputError v-if="errorMessage" class="mt-1" :message="errorMessage" />
    </div>
</template>