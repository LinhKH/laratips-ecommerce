<script setup>
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
import { computed, ref } from 'vue';
import Preloader from '../Components/Preloader.vue';
import Sidebar from '../Components/Sidebar.vue';
import ProductGrid from './ProductGrid.vue';
import Paginate from '../Components/Paginate.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const {
    slug,
    cat_detail,

    breadcrumb,
    links,
    keyword,
    url_search,
} = usePage().props;

const products = computed(() => {
    return usePage().props.products
})


const change = ref(false);

let data = useForm({
    sort: "latest",
    brand: [],
    min_price: "0",
    max_price: "100000",
});

const handleFilter = () => {
    data.get(
        url_search,
        {
            preserveState: true,
            preserveScroll: true,
            onBefore: (visit) => {
                change.value = true;
            },
            onSuccess: (res) => {
                change.value = false;
            },
        }
    );
};

const sortOptions = [
    { name: 'Latest', value: 'latest' },
    { name: 'Oldest', value: 'oldest' },
    { name: 'Price:Low to High', value: 'l-h' },
    { name: 'Price:High to Low', value: 'h-l' },
];

</script>

<template>

    <Head :title="cat_detail?.category_name ?? 'All Products'"></Head>
    <Preloader v-if="change" />
    <FrontLayout>
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">

                <h2 v-if="keyword != null">Search : "{{ keyword }}"</h2>

                <h2 v-else-if="cat_detail != null">{{ cat_detail.category_name }}</h2>

                <h2 v-else>All Products</h2>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <template v-if="breadcrumb != null">
                            <template v-for="value in breadcrumb" :key="value.id">
                                <li v-if="value.id == cat_detail.id" class="breadcrumb-item active">
                                    {{ value.category_name }}
                                </li>
                                <li v-else class="breadcrumb-item">
                                    <Link :href="`${baseUrl}/c/${value.category_slug}`">
                                    {{ value.category_name }}
                                    </Link>
                                </li>
                            </template>
                        </template>
                        <li class="breadcrumb-item" v-else>
                            All Products
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <form @submit.prevent="handleFilter">
            <div class="container-xl container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <Sidebar v-model="data" @handle-submit="handleFilter" />
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content-box">
                                    <div class="row">
                                        <div class="col-md-4 d-flex flex-row align-items-center">
                                            <h5 class="title">
                                                {{ slug }}
                                            </h5>
                                            <p class="result-count" v-if="products.from != products.last_page && products.data.length > 0">
                                                Showing {{ products.from }} to
                                                {{ products.to }} of
                                                {{ products.total }}
                                            </p>
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div
                                            class="col-md-4 d-flex flex-row justify-content-between align-items-center">
                                            <label for="" class="text-nowrap my-auto mr-2">
                                                Sort By
                                            </label>
                                            <select name="sort" class="form-control" v-model="data.sort"
                                                @change="handleFilter">
                                                <option :value="item.value" v-for="item in sortOptions" :key="item.value">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-for="product in products.data" v-if="products.data.length > 0" :key="product.id"
                                class="col-lg-4 col-md-6 col-sm-6 mb-5">
                                <ProductGrid :product="product" />
                            </div>
                            <div v-else class="col-12 mb-5">
                                <div class="text-center">
                                    No Products Found
                                </div>
                            </div>
                            <Paginate v-if="products.from != products.last_page && products.data.length > 0"
                                :pagination="products"></Paginate>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </FrontLayout>
</template>