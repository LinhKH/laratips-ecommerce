<template>
    <option v-for="item in childrens" :key="item.id" :value="item[field]"> {{ item.category_name }} </option>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const {
    all_category
} = usePage().props;

const props = defineProps({
    children: Number,
    field: {
        type: String,
        default: 'category_slug'
    }
});

let childrens = all_category.filter((cat) => cat.parent_category == props.children);
</script>
