<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import Paginate from '@/admin/Components/Paginate.vue';
import Filters from './Filters.vue';
import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";
import Actions from '@/admin/Components/Table/Actions.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

import Modal from "@/admin/Components/Modal.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
    brands: Object,
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
            <template #add_btn>
                <Link :href="route('admin.products.create')" class="align-top btn btn-sm btn-primary">Add New</Link>
            </template>
        </BreadCrumb>
        <section class="content">
            <div class="container-fluid">
                <Filters v-model="filters" :show="isFilled" :brands="brands" />
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Discount</th>
                                    <th>Today Deal</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="data.data.length > 0" v-for="row in data.data" :key="row.id">
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
                                        {{ $filters.formatNumber(row.discount) ?? 0 }} {{ row.discount_type == 'percent' ? '%' : 'vnd' }}
                                    </td>
                                    <td>
                                        <span v-if="row.today_deal == '1'" class="badge badge-success">Active</span>
                                        <span v-else class="badge badge-danger">Inactive</span>
                                    </td>
                                    <td>
                                        <span v-if="row.status == '1'" class="badge badge-success">Published</span>
                                        <span v-else class="badge badge-danger">Draft</span>
                                    </td>
                                    <td>
                                        <Actions :edit-link="route(`admin.${routeResourceName}.edit`, { id: row.id })"
                                            @deleteClicked="showDeleteModal(row)" />
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="5" class="text-center">No data ...</td>
                                </tr>
                            </tbody>
                        </table>
    
                        <Paginate v-if="data.from != data.last_page && data.total > 0" :pagination="data"></Paginate>
                    </div>
                </div>
            </div>
        </section>
    </BackendLayout>
    <Modal :show="deleteModel" @close="closeModal" @handle-delete-item="handleDeleteItem" :item-to-delete="itemToDelete"
    :is-deleting="isDeleting" needed-delete="Product" field-name="product_name"> </Modal>
</template>

<style scoped>

</style>