<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import ProductRating from './ProductRating.vue';
const baseUrl = import.meta.env.VITE_APP_URL;
const { rating } = usePage().props;

const {  generalSettings } = usePage().props;

</script>

<template>
    <div class="col-md-4 col-sm-6">
        <div class="section-heading">
            <h2 class="title">Top Đánh giá</h2>
        </div>
        <div v-for="(value, index) in rating" class="blog-grid d-flex flex-row" key="index">
            <Link :href="`${baseUrl}/product/${value.slug}`" class="blog-img">
            <img :src="`${baseUrl}/products/${value.thumbnail_img}`" :alt="value.product_name" />
            </Link>
            <div class="blog-content d-flex flex-column">
                <h4>
                    <Link :href="`${baseUrl}/product/${value.slug}`">
                    {{ value.product_name }}
                    </Link>
                </h4>
                <ProductRating :rating_col="value.rating_col" :rating_sum="value.rating_sum" />
                <div class="price">{{ $filters.formatNumber(value.unit_price) }} {{ generalSettings.currency }}</div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>