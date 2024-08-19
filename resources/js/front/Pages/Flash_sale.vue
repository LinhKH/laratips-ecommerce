<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
const baseUrl = import.meta.env.VITE_APP_URL;
const { flash_products } = usePage().props;

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

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import ProductGrid from './ProductGrid.vue';

const settings = {
    itemsToShow: 1,
    snapAlign: 'center',
};
const breakpoints = {
    0: {
        itemsToShow: 1,
        snapAlign: 'center',
    },
    600: {
        itemsToShow: 2,
        snapAlign: 'start',
    },
    1000: {
        itemsToShow: 4,
        snapAlign: 'start',
    },
};
</script>

<template>
    <section id="flash-sale" class="py-4">
        <div class="container-xl container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2 class="title">Flash Sale</h2>
                        <a :href="`${baseUrl}/flash-products`" class="btn btn-primary">
                            Show All
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-12'>
                    <Carousel v-bind="settings" :breakpoints="breakpoints" class="owl-theme product-carousel">
                        <slide v-for="product in products" :key="product.id">
                            <div class="item">
                                <ProductGrid :key="product.id" :product="product" />
                            </div>
                        </slide>
                        <template #addons>
                            <Navigation />
                        </template>
                    </Carousel>
                </div>
            </div>
        </div>
    </section>
</template>


<style scoped></style>