<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import Paginate from '@/admin/Components/Paginate.vue';

import Filters from './Filters.vue';
import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";
import Actions from '@/admin/Components/Table/Actions.vue';

import Modal from "@/admin/Components/Modal.vue";

const baseUrl = import.meta.env.VITE_APP_URL;

const { generalSettings } = usePage().props;

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
                                    <th>ORDER No</th>
                                    <th>Product Details</th>
                                    <th>Total Amount</th>
                                    <th>Thanh toán qua</th>
                                    <th>Thanh toán</th>
                                    <th>Customer Details</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in data.data" :key="row.id">
                                    <td>
                                        ODR00{{ row.id }}
                                        <template v-if="row.delivery.includes(0)">
                                            <br><span class="text-danger">(Pending)</span>
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="row.p_id">
                                            <li v-for="item in row.p_id.split('|||')">PDR00{{ item }}</li>
                                        </template>
                                    </td>
                                    <td>
                                        {{ $filters.formatNumber(row.amount) }} {{ generalSettings.currency }}
                                    </td>
                                    <td>{{ row.pay_method }}</td>
                                    <td>
                                        <span v-if="row.pay_status == 1" class="badge badge-primary">Paid</span>
                                        <span v-else class="badge badge-danger">Unpaid</span>

                                    </td>
                                    <td>
                                        <ul>
                                            <li><b>Name: </b> {{ row.name }}</li>          
                                            <li><b>Address: </b> {{ row.address }}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        {{ row.formatted_created }}
                                    </td>
                                    <td>
                                        <!-- <Actions :edit-link="route(`admin.${routeResourceName}.edit`, { id: row.id })"
                                            @deleteClicked="showDeleteModal(row)" /> -->

                                        <Link :href="route('admin.view_order', row.id)" class="btn btn-success btn-sm">View</Link>
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
    <Modal :show="deleteModel" @close="closeModal" @handle-delete-item="handleDeleteItem" :item-to-delete="itemToDelete"
    :is-deleting="isDeleting" needed-delete="Order" field-name="id"> </Modal>
</template>

<style scoped>

</style>