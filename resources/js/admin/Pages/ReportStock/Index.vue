<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import Paginate from '@/admin/Components/Paginate.vue';

import Filters from './Filters.vue';
import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";

const baseUrl = import.meta.env.VITE_APP_URL;

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
});

const {
    showDeleteModal, deleteModel, closeModal, itemToDelete, handleDeleteItem, isDeleting,
} = useDeleteItem({
    routeResourceName: props.routeResourceName,
});
const { filters, isLoading, isFilled } = useFilters({
    filters: props.filters,
    routeResourceName: props.routeResourceName,
});
</script>

<template>
    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
            
        </BreadCrumb>
        <section class="content">
            <div class="container-fluid">
                <Filters v-model="filters" :show="isFilled" />
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in data.data" :key="row.id">
                                    <td>{{ row.id }}</td>
                                    <td>
                                        <img v-if="row.thumbnail_img" :src="`${baseUrl}/products/${row.thumbnail_img}`" width="80px" />
                                        <img v-else :src="`${baseUrl}/products/default.png`" width="80px" />
                                    </td>
                                    <td>
                                        {{ row.product_name }}
                                    </td>
                                    <td>
                                        {{ row.category.category_name }}
                                    </td>
                                    <td>
                                        {{ row.quantity }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
    
                        <Paginate v-if="data.from != data.last_page" :pagination="data"></Paginate>
                    </div>
                </div>
            </div>
        </section>
    </BackendLayout>
</template>

<style scoped>

</style>