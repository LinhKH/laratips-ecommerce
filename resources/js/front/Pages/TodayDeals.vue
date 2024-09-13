<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
const baseUrl = import.meta.env.VITE_APP_URL;

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import { computed } from "vue";

import ProductGrid from "./ProductGrid.vue";


const today_deal_products = computed(() => {
    return usePage().props.today_deal_products
});


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
    <section v-if="today_deal_products.length > 0" id="product_box" className="py-3">
        <div className="container">
            <div className="row">
                <div className="col-12">
                    <div className="section-heading">
                        <h2 className="title">Ưu đãi hôm nay</h2>
                        <Link className="btn btn-primary text-white" :href="`${baseUrl}/today-deals`">
                        Tất cả
                        </Link>
                    </div>
                </div>
            </div>
            <div className="row">
                <div className="col-12">
                    <Carousel v-bind="settings" :breakpoints="breakpoints" class="owl-theme product-carousel">
                        <slide v-for="today_deal in today_deal_products" :key="today_deal.id">
                            <div class="item">
                                <ProductGrid key="today_deal.id" :product="today_deal" />
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