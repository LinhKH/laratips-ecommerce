<script setup>
import { computed } from 'vue';

const props = defineProps({
    child_category: Object
})

const value = computed(() => {
    let value = '';
    for (let i = 0; i < props.child_category.level; i++) {
        value += '--';
    }
    return value
})
</script>

<template>
    <option :value="child_category.id">{{ value + ' ' + child_category.category_name }}</option>
    <template v-if="child_category.categories">
        <ChildCategory v-for="childCategory in child_category.categories" :key="childCategory.id"
            :child_category="childCategory" />
    </template>
</template>

<style scoped></style>