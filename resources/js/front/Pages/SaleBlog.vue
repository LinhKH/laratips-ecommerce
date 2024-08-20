<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import ProductRating from './ProductRating.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const { flash_products, generalSettings } = usePage().props;

const products = flash_products.filter((product) => {
    const datetime = product.flash_date_range.split("-");
    const currentDatetime = new Date();

    let startDatetime = "";
    let endDatetime = "";

    if (product.flash_date_range !== "") {
        startDatetime = new Date(datetime[0]);
        endDatetime = new Date(datetime[1]);
    }

    if (
        currentDatetime >= startDatetime &&
        currentDatetime <= endDatetime
    ) {
        return product;
    }
    return null;
});

</script>

<template>
    <div class="col-md-4 col-sm-6">
        <div class="section-heading">
            <h2 class="title">On Sale</h2>
        </div>
        <div v-for="(flash_product, index) in products" class="blog-grid d-flex flex-row" :key="index">
            <Link :href="`${baseUrl}/product/${flash_product.slug}`" class="blog-img">
            <img :src="`${baseUrl}/products/${flash_product.thumbnail_img}`" :alt="flash_product.product_name" />
            </Link>
            <div class="blog-content d-flex flex-column">
                <h4>
                    <Link :href="`${baseUrl}/product/${flash_product.slug}`">
                    {{ flash_product.product_name }}
                    </Link>
                </h4>
                <ProductRating :rating_col="flash_product.rating_col" :rating_sum="flash_product.rating_sum" />

                <template v-if="flash_product.discount != '0'">
                    <div>
                        <span class="old-price">
                            {{ generalSettings.currency }}
                            {{ flash_product.taxable_price }}
                        </span>
                        <span class="price">
                            {{ generalSettings.currency }}
                            {{ flash_product.taxable_price -
                                flash_product.discount }}
                        </span>
                    </div>
                </template>
                <template v-else>
                    <span class="price">
                        {{ generalSettings.currency }}
                        {{ flash_product.taxable_price }}
                    </span>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped></style>