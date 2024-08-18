<script setup>
import { Link, usePage } from '@inertiajs/vue3';

// const { latest_products } = usePage().props;

const latest_products = computed(() => {
    return usePage().props.latest_products
})

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import ProductGrid from './ProductGrid.vue';
import { computed } from 'vue';
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

<section v-if="latest_products.length > 0" id="product_box" class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="title">Lastest Product</h2>
                    <Link class="btn btn-primary text-white" href='/search'>Show All</Link>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-12'>
                <Carousel v-bind="settings" :breakpoints="breakpoints" class="owl-theme product-carousel">
                    <slide v-for="latest_product in latest_products" :key="latest_product.id">
                        <div class="item">
                            <ProductGrid :key="latest_product.id" :product="latest_product" />
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