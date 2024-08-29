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
                <Link :href="route('admin.flash-deals.create')" class="align-top btn btn-sm btn-primary">Add New</Link>
            </template>
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
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Times</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in data.data" :key="row.id">
                                    <td>{{ row.id }}</td>
                                    <td>
                                        <img v-if="row.flash_image" :src="`${baseUrl}/flash-deals/${row.flash_image}`" width="80px" />
                                        <img v-else :src="`${baseUrl}/flash-deals/default.png`" width="80px" />
                                    </td>
                                    <td>
                                        {{ row.flash_title }}
                                    </td>
                                    <td>
                                        <span v-if="row.status == '1'" class="badge badge-success">Active</span>
                                        <span v-else class="badge badge-danger">Inactive</span>
                                    </td>
                                    <td>
                                        {{ row.flash_date_range }}
                                    </td>
                                    <td>
                                        <Actions :edit-link="route(`admin.${routeResourceName}.edit`, { id: row.id })"
                                            @deleteClicked="showDeleteModal(row)" />
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
    :is-deleting="isDeleting" needed-delete="Flash Deal" field-name="flash_title"> </Modal>
</template>

<style scoped>

</style>