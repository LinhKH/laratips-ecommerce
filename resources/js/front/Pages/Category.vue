<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
const baseUrl = import.meta.env.VITE_APP_URL;

import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'

const {
    all_category
} = usePage().props;

const settings = {
    itemsToShow: 1,
    snapAlign: 'center',
};
const breakpoints = {
    0: {
        itemsToShow: 5,
        snapAlign: 'center',
    },
    600: {
        itemsToShow: 8,
        snapAlign: 'start',
    },
    1000: {
        itemsToShow: 12,
        snapAlign: 'start',
    },
};

</script>
<template>
    <section id="category" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <Carousel v-bind="settings" :breakpoints="breakpoints">
                        <slide v-for="category in all_category" :key="category.id">
                            <div class="item">
                                <div class="category-grid text-center">
                                    <h4>
                                        <Link :href="`${baseUrl}/search?category=${category.category_slug}`">
                                            {{ category.category_name }}
                                        </Link>
                                    </h4>
                                </div>
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
<style scoped>

@media only screen and (max-width: 770px) {
    .category-grid h4 a {
        background: var(--main-color);
        font-size: 10px;
        font-weight: 200;
        width: 60px;
        height: 60px;
    }
}
</style>