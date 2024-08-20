
<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import SubChildCategory from './SubChildCategory.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const { all_category, cat_detail, cat_array } = usePage().props;

</script>

<template>
    <ul class="category">
        <template v-if="cat_detail != null">
            <li class="category_name">
                <Link preserveScroll :href="`${baseUrl}/search?category=all`">
                    <strong>All Categories</strong>
                </Link>
            </li>
            <li class="category_name">
                <Link preserveScroll :href="`${baseUrl}/c/${cat_array.category_slug}`" >
                    
                    <i v-if="cat_detail.id == cat_array.id" class="fas fa-angle-right"></i>
                 
                    {{ cat_array.category_name }}
                </Link>
                <template v-if="cat_array.sub_category">
                    <SubChildCategory :subcategories="cat_array.sub_category" />
                </template>
            </li>
            <template v-for="item in all_category" :key="item.id">
                <li v-if="item.parent_category == '0' && item.id != cat_array.id">
                    <Link preserveScroll
                        :href="`${baseUrl}/c/${item.category_slug}`"
                    >
                        {{ item.category_name }}
                    </Link>
                </li>

            </template>
        </template>
        <template v-else v-for="item in all_category" :key="item.id">
            <li v-if="item.parent_category == '0'">
                <Link preserveScroll
                    :href="`${baseUrl}/c/${item.category_slug}`"
                >
                    {{ item.category_name }}
                </Link>
            </li>
        </template>
    </ul>
</template>

<style scoped>

</style>