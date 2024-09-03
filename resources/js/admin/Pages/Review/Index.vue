<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import { computed, reactive, ref } from 'vue';
import Paginate from '@/admin/Components/Paginate.vue';
const { generalSettings, sitePages, all_category } = usePage().props;
import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";
import Actions from '@/admin/Components/Table/Actions.vue';
const baseUrl = import.meta.env.VITE_APP_URL;
import Trash from '@/admin/Components/Icons/Trash.vue';

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
    showDeleteModal, deleteModel, closeModal, itemToDelete, isDeleting,
} = useDeleteItem({
    routeResourceName: props.routeResourceName,
});

const review = ref({});

const approveReview = (id) => {
    router.post(route('admin.reviews.approve'), {
        approve: id
    })
};


const handleDeleteItem = () => {
    router.post(route(`admin.reviews.destroy`, { delete: itemToDelete.value.id }), {
            preserveScroll: true,
            preserveState: true,
        }, {
            onSuccess: () => {
                deleteModel.value = false;
            }
        });
};

const viewReview = (id) => {
    review.value = props.data.data.find(row => row.id == id);

    $('.view-review-modal').modal('show');
};

</script>

<template>

    <Head :title="title" />

    <BackendLayout>

        <BreadCrumb :breadcrumb='breadcrumb' :title="`All Reviews`" :active='`All Reviews`'>
        </BreadCrumb>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in data.data" :key="row.id">
                            <td>{{ row.id }}</td>
                            <td>{{ row.product_name }}</td>
                            <td>{{ row.name }}</td>
                            <td>{{ row.rating }}</td>
                            <td>
                                <span v-if="row.approved == 1" class="badge badge-info">Approved</span>
                                <button v-else class="btn btn-success btn-sm"
                                    @click="approveReview(row.id)">Approve</button>
                                <small v-if="row.hide_by_admin == 1" class="text-danger d-block">Hidden by admin</small>
                            </td>
                            <td>

                                <Actions :edit-link="route(`admin.${routeResourceName}.edit`, { id: row.id })"
                                    @deleteClicked="showDeleteModal(row)">

                                    <button class="btn btn-info btn-sm" @click="viewReview(row.id)"><i
                                            class="fa fa-eye"></i></button>
                                </Actions>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginate v-if="data.from != data.last_page" :pagination="data"></Paginate>
            </div> <!-- /.card-body -->
        </div>
        <div class="modal view-review-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span><b>Product : </b> {{ review?.product_name }}</span><br>
                        <span><b>User : </b> {{ review?.name }}</span><br><br>
                        <h4>{{ review?.title }}</h4>
                        <p>{{ review?.desc }}</p>
                    </div>
                </div>
            </div>
        </div>

    </BackendLayout>
    <Modal :show="deleteModel" @close="closeModal" @handle-delete-item="handleDeleteItem" :item-to-delete="itemToDelete"
        :is-deleting="isDeleting" needed-delete="Review" field-name="title"> </Modal>

</template>
