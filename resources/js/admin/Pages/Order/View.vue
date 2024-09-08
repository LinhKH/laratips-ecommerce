<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';

import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";
import Actions from '@/admin/Components/Table/Actions.vue';

import Modal from "@/admin/Components/Modal.vue";

import Attribute from '@/front//Components/Attribute.vue';

const baseUrl = import.meta.env.VITE_APP_URL;

const {
    generalSettings,
} = usePage().props;

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
    attributes: {
        type: Object,
        default: () => ({}),
    },
    attrvalues: {
        type: Object,
        default: () => ({}),
    },
    colors: {
        type: Object,
        default: () => ({}),
    },
    order: {
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

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [day , month , year].join('-');
}

const calculateDate = (date, days) => {
    const newDate = new Date(date);
    newDate.setDate(newDate.getDate() + parseInt(days));
    return formatDate(newDate);
};

const deliverConfirm = (product_qty, product_id, order_id) => {
    router.post(route('admin.order_delivered'), {
        product_id: product_id,
        order_id: order_id,
        qty: product_qty,
    }, {
        onSuccess: () => {

        }
    })
}

</script>

<template>

    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
            <template #add_btn>
                <Link :href="route('admin.orders.index')" class="align-top btn btn-sm btn-primary">Back</Link>
            </template>
        </BreadCrumb>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                    <address>
                        <strong>Đặt hàng bởi:</strong><br>
                        <b>Name:</b> {{order.user.name}}<br>
                        <b>Email: </b> {{order.user.email}}<br>
                        <b>Phone:</b> {{order.user.phone}}<br>
                        <b>Address:</b> {{order.user.address}},
                            {{order.user.city.city_name}}, {{order.user.state.state_name}},
                            {{order.user.country.country_name}}
                    </address>
                    </div>
                    <div class="col-md-6 text-md-right">
                    <address>
                        <strong>Nhận hàng bởi:</strong><br>
                            <b>Name:</b> {{order.order_address?.name}}<br>
                            <b>Email: </b> {{order.order_address?.email}}<br>
                            <b>Phone:</b> {{order.order_address?.phone}}<br>
                            <b>Address:</b> {{order.order_address?.address}},
                                {{order.order_address?.city.city_name}}, {{order.order_address?.state.state_name}},
                                {{order.order_address?.country.country_name}}
                    </address>
                    </div>
                </div>
                <div>
                    <h5><b>ORDER No. : ODR00{{ order.id }} </b></h5>
                    <b>Order Placed : {{ order.formatted_created }}</b>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th style="min-width: 305px !important;">Product Details</th>
                                <th>Sub Total</th>
                                <th>Dự kiến giao hàng</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="row in products" :key="row.id">
                                <td>
                                    <img class="img-thumbnail" :src="`${baseUrl}/products/${row.thumbnail_img}`" alt=""
                                        width="100px">
                                </td>
                                <td>
                                    <li><span><b>Product Code :</b> PDR00{{ row.id }}</span></li>
                                    <li><span><b>Product Name :</b> {{ row.product_name.substring(0,30) + '...' }}</span></li>
                                    <li>
                                        <template v-if="row.product_color != ''" v-for="color in colors">
                                            <template v-if="color.id == row.product_color">
                                                <span><b>Color : </b> {{color.color_name}}</span>
                                            </template>
                                        </template>
                                    </li>
    
                                    <Attribute :product="row" :is-order="true"/>
    
                                    <li><span><b>Qty : </b>{{row.product_qty}}</span></li>
                                </td>
                                <td>
                                    <b>Sub Total : {{ $filters.formatNumber(row.product_amount) }} {{ generalSettings.currency }}</b> 
                                </td>
                                <td>
                                    {{calculateDate(
                                        order.created_at,
                                        row.shipping_days
                                    )}}
                                </td>
                                <td>
                                    <span v-if="row.product_delivery == 1">Delivered</span>
                                    <button v-else class="btn btn-info btn-sm deliverConfirm" @click="deliverConfirm(row.product_qty,row.product_id, order.id)">Deliver</button>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    <b>Total Amount ({{ generalSettings.currency }}) : {{ $filters.formatNumber(order.amount) }} {{ generalSettings.currency }}</b>
                </div>
            </div>
        </section>
    </BackendLayout>
    <Modal :show="deleteModel" @close="closeModal" @handle-delete-item="handleDeleteItem" :item-to-delete="itemToDelete"
        :is-deleting="isDeleting" needed-delete="Order" field-name="id"> </Modal>
</template>

<style scoped>

</style>