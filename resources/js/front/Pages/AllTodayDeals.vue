<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import ProductGrid from './ProductGrid.vue';

import Paginate from '../Components/Paginate.vue';
import FrontLayout from '../Layouts/FrontLayout.vue';

const { today_deal_products } = usePage().props;


</script>

<template>
    <FrontLayout>
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>Today Deals</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">
                            Today Deals
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <section id="product_box" class="py-3">
            <div class="container-xl container-fluid">
                <div class="row">
                    <div v-for="item in today_deal_products.data" class="col-lg-3 col-md-4 col-sm-6" :key="item.id">
                        <ProductGrid :product="item" />
                    </div>
                </div>

                <Paginate v-if="today_deal_products.from != today_deal_products.last_page" :pagination="today_deal_products"></Paginate>

            </div>
        </section>
    </FrontLayout>
</template>