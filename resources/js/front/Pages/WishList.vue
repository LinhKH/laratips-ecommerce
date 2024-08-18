<script setup>
import { usePage, Link, Head } from '@inertiajs/vue3';
import ProductGrid from './ProductGrid.vue';
import FrontLayout from '../Layouts/FrontLayout.vue';
import { computed } from 'vue';

const products = computed(() => {
    return usePage().props.products
})

</script>
<template>
    <Head title="Wishlist Page"></Head>
    <FrontLayout>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Wishlist</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">Wishlist</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <div class="row wishlist-data">

                    <div v-if="products.length > 0" v-for="product in products" :key="product.id"
                        class="col-lg-3 col-md-6 mb-5">
                        <ProductGrid :key="product.id" :product="product" />
                    </div>

                    <div v-else class="col-md-12 text-center">
                        <h4 class="mb-2">Your Wishlist is Empty</h4>
                        <Link href="/" class="btn btn-primary">Add Items to Wishlist</Link>
                    </div>

                </div>
            </div>
        </div>
    </FrontLayout>

</template>