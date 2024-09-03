<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Attribute from './Attribute.vue';
const baseUrl = import.meta.env.VITE_APP_URL;


const { generalSettings, color } = usePage().props;
const props = defineProps({
    order_detail: {
        type: Object,
        required: true
    },
    reviews: {
        type: Object,
    }
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
</script>

<template>
    <table class="table table-bordered">
        <tr>
            <td>Order No : ODR00{{ props.order_detail.order.id }}</td>
        </tr>
    </table>
    <div class="d-flex flex-row mb-3" v-for="value in order_detail.order_products" :key="value.id">
        <img :src="`${baseUrl}/products/${value.thumbnail_img.split(',')[0]}`" class="mr-2" width="110px" />
        <div>
            <h6>{{ value.product_name }}</h6>
            <ul>
                <li><b>Qty :</b> {{ value.product_qty }}</li>
                <li>
                    <template v-for="item in color" key="item.id">
                        <span v-if="value.product_color == item.id"><b>Color : </b>{{ item.color_name }}</span>
                    </template>
                </li>
                <Attribute :product="value" :is-order="true"/>
                <li>
                    <b>Amount : </b>
                    {{ $filters.formatNumber(value.product_amount) }} {{ generalSettings.currency }}
                </li>
                <template v-if="value.product_delivery == '0'">
                    <li><b>Delivery :</b> Pending </li>
                    <li>
                        <b>Expected Delivery : </b>
                        {{calculateDate(
                            order_detail.order.created_at,
                            value.shipping_days
                        )}}
                    </li>
                </template>
                <template v-else>
                    <li><b>Delivery : </b>Delivered</li>
                    <li>
                        <b>Delivered On : </b>
                        {{new Date(
                            order_detail.order.updated_at
                        ).toLocaleDateString()}}
                    </li>
                    <li v-if="!reviews.includes(value.id)">
                        <Link
                            :href="route('review.create', value.product_id)"
                            className="btn btn-primary btn-sm"
                        >
                            Write a product review
                        </Link>
                    </li>
                </template>
            </ul>
        </div>
    </div>
    <table className="table table-bordered">
        <tr>
            <td>Total Products</td>
            <td>{{ order_detail.order.qty }}</td>
        </tr>
        <tr>
            <td>Total Amount</td>
            <th>
                {{ $filters.formatNumber(order_detail.order.amount) }} {{ generalSettings.currency }}
            </th>
        </tr>
    </table>
</template>

<style scoped>

</style>