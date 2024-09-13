<script setup>
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
import Paginate from '../Components/Paginate.vue';
import { computed, ref, watch, watchEffect } from 'vue';
import OrderProducts from '../Components/OrderProducts.vue';
import Preloader from '../Components/Preloader.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const { my_orders, reviews } = usePage().props;

let orderDetail = ref(null)
const props = defineProps({
    order_detail: {
        type: Object,
    },
    order_products: {
        type: Object,
    },
});

let isLoading = ref(false)

// Watch for changes in props.myProp
watch(() => props.order_detail, (newValue, oldValue) => {
    // React to prop changes
    orderDetail.value = { order: newValue, order_products: props.order_products }; // Update the value in the ref if needed
});


const handleShowDetails = (id) => {
    router.post(route('my_orders.store'),
        { id: id },
        {
            preserveScroll: true,
            preserveState: true,
            onBefore: () => {
                isLoading.value = true;
            },
            onFinish: () => {
                isLoading.value = false;
            }
            // replace: true,
            // only : ['order_detail','order_products'],
        }
    );
};

</script>

<template>
    <Preloader v-if="isLoading" />
    <Head title="Đơn hàng"></Head>
    <FrontLayout>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Đơn hàng của bạn</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Trang chủ</Link>
                            </li>
                            <li class="breadcrumb-item active">
                                Đơn hàng của bạn
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-xl container-fluid">
                <div class="row">
                    <div :class="[orderDetail ? 'col-md-8' : 'col-md-12']">
                        <table v-if="!my_orders.isEmpty" class="table table-bordered table-striped">
                            <thead>
                                <th>Số đơn hàng</th>
                                <th>Sản phẩm</th>
                                <th>Tạo lúc</th>
                                <th>Xem</th>
                            </thead>
                            <tbody class="cart-data">
                             
                                <tr v-for="order in my_orders" class="active" :key="order.id">
                                    <td>
                                        <a class="show-product" href="javascript:;">
                                            ODR00{{ order.id }}
                                        </a>
                                    </td>
                                    <td>
                                        <ul>
                                            <li v-for="names in order.names?.split('|||')" :key="names" class="mb-2">
                                                {{ names }}
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $filters.formatDate(order.created_at) }}
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            @click="handleShowDetails(order.id)"
                                        >
                                            <i v-if="orderDetail?.order?.id == order.id" class="fa fa-eye-slash"></i>
                                            <i v-else class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <div v-else class="content-box text-center">
                            <p class="m-0">Hiện tại chưa có đơn hàng nào</p>
                        </div>
                    </div>
                    <div class="col-md-4 show-product-content">
                        <OrderProducts v-if="orderDetail != null"
                            :order_detail="orderDetail"
                            :reviews="reviews"
                            :key="orderDetail.order.id"
                        />
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>

<style scoped>

</style>