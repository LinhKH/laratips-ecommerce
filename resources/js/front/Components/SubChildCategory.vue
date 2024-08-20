<script setup>
import { Link, usePage } from '@inertiajs/vue3';
const baseUrl = import.meta.env.VITE_APP_URL;

const { cat_detail } = usePage().props;

const props = defineProps({
    subcategories: Array
});


</script>

<template>
    <ul class="subcategory-list pl-3">
        <li v-for="subCategory in subcategories" :key="subCategory.id">
            <Link preserveScroll :href="`${baseUrl}/c/${subCategory.category_slug}`">
                <i v-if="cat_detail !== null && cat_detail.id == subCategory.id" class="fas fa-angle-right"></i>
                {{ subCategory.category_name }}
            </Link>
            <SubChildCategory v-if="subCategory.sub_category" :subcategories="subCategory.sub_category" />
        </li>
    </ul>
</template>