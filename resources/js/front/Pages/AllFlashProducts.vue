<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
import Paginate from '../Components/Paginate.vue';
import ProductGrid from './ProductGrid.vue';
const baseUrl = import.meta.env.VITE_APP_URL;
const { flash_products } = usePage().props;

const isCheckShow = (flash_product) => {
    const datetime = flash_product.flash_date_range.split("-");
    const currentDatetime = new Date();

    let startDatetime = "";
    let endDatetime = "";

    if (flash_product.flash_date_range !== "") {
        startDatetime = new Date(datetime[0]);
        endDatetime = new Date(datetime[1]);
    }
    if (
        currentDatetime >= startDatetime &&
        currentDatetime <= endDatetime
    ) {
        return true;
    }
}
</script>

<template>

    <Head title="All Flash Products"></Head>
    <FrontLayout>
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>All Flash Products</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">
                            All Flash Products
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <section id="flash-sale" className="py-4">
            <div className="container-xl container-fluid">
                <div className="row">
                    <template v-for="flash_product in flash_products.data" :key="`${flash_product.id}`">
                        <div v-if="isCheckShow(flash_product)" class="col-lg-3 col-md-4 col-sm-6" >
                            <ProductGrid :product="flash_product" />
                        </div>
                    </template>
                </div>
                <Paginate v-if="flash_products.from != flash_products.last_page" :pagination="flash_products"></Paginate>
            </div>
        </section>

    </FrontLayout>
</template>

<style scoped></style>