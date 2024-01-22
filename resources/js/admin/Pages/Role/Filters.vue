<script setup>
import { ref, watch } from 'vue';
import Card from '@/Components/Card/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    },
});

const filters = ref({ ...props.filters });

const emits = defineEmits(['update:modelValue']);

watch(filters, () => {
    emits('update:modelValue', filters.value);
}, {
    deep: true
})

</script>

<template>
    <Card class="mb-4">
        <template #header>
            Filters
        </template>
        <form class="grid grid-cols-4 gap-8">
            <div>
                <InputLabel value="Name" />

                <TextInput type="text" class="mt-1 block w-full" v-model="filters.name" />
            </div>
        </form>
    </Card>
</template>