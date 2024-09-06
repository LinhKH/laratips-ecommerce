<script setup>
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import Preloader from "./Preloader.vue";
import Attribute from "./Attribute.vue";
import { ref, computed } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;

let activeStep = ref(1);

const handleStep = (step) => {
    activeStep.value = step;
};

const {
    generalSettings,
    user,
    products,
    payment_method,
    cities,
    razorkey,
} = usePage().props;

const charges = user.city != null ? cities.filter((city) => city.id == user.city)[0].cost_city : null;

const calculateTotal = () => {
    let t = 0;
    products.map((item) =>
        item.shipping_charges != "free" ? (t += parseInt(item.taxable_price) * item.qty + parseInt(charges)) : (t += parseInt(item.taxable_price) * item.qty)
    );
    return t;
};

const data = useForm({
    pay_method: "",
    amount: calculateTotal(),
});

const handleSubmit = (e) => {
    if (data.pay_method == "razorpay") {
        const razorpay = window.Razorpay({
            key: razorkey,
            amount: data.amount * 100,
            name: generalSettings.site_name,
            order_id: "",
            handler: async (transaction) => {
                const tr = transaction.razorpay_payment_id;
                get(
                    baseUrl +
                    `/pay-with-razorpay/${data.amount}/${tr}?` +
                    data
                );
            },
        });

        razorpay.open();
    } else if (data.pay_method == "paypal") {
        const urlParams = new URLSearchParams(
            window.location.href.split("?")[1]
        ).toString();
        window.location.href =
            baseUrl +
            "/pay-with-paypal/" +
            data.amount +
            "?" +
            urlParams +
            "&" +
            new URLSearchParams(data).toString();

            // router.get(`${baseUrl}/pay-with-paypal/${data.amount}?${urlParams}&amount=${data.amount}&pay_method=${data.pay_method}`);
    } else if (data.pay_method == "cod") {
        const urlParams = new URLSearchParams(
            window.location.href.split("?")[1]
        ).toString();
        // window.location.href =
        //     baseUrl +
        //     "/pay-with-cod/" +
        //     data.amount +
        //     "?" +
        //     urlParams +
        //     "&" +
        //     new URLSearchParams(data).toString();

            router.get(`${baseUrl}/pay-with-cod/${data.amount}?${urlParams}&amount=${data.amount}&pay_method=${data.pay_method}`);
    }
};

</script>

<template>
    <Preloader v-if="data.processing" />
    <Head :title="`Checkout - Step ${activeStep}`"></Head>
    <form @submit.prevent="handleSubmit" method="POST">
        <ul class="d-flex justify-content-around">
            <li>
                <button type="button" class="btn btn-primary" @click="handleStep(1)"
                    :disabled="activeStep == 1 ? false : true">
                    Step 1
                </button>
            </li>
            <li>
                <button type="button" class="btn btn-primary" @click="handleStep(2)"
                    :disabled="activeStep == 2 ? false : true">
                    Step 2
                </button>
            </li>
            <li>
                <button type="button" class="btn btn-primary" @click="handleStep(3)"
                    :disabled="activeStep == 3 ? false : true">
                    Step 3
                </button>
            </li>
        </ul>
        <div class="multi-content">
            <div v-if="activeStep == 1" id="Step1" class="row py-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Delivery Details</th>
                            <th>
                                <Link :href="route('my_profile')" class="btn btn-primary">
                                Change
                                </Link>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Name :</th>
                            <td>{{ user.name }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number :</th>
                            <td>{{ user.phone }}</td>
                        </tr>
                        <tr>
                            <th>Address :</th>
                            <td>
                                {{ user.address }} - 
                                {{ user.city_name }}, {{ user.state_name }},
                                {{ user.country_name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="activeStep == 2" id="Step1" class="py-3">
                <table class="table table-bordered">
                    <thead>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </thead>
                    <tbody>

                        <tr v-for="product in products" key={product.id}>
                            <td class="d-flex flex-row">
                                <img class="pic-1" :src="`${baseUrl}/products/${product.thumbnail_img}`"
                                    :alt="product.product_name" width="100px" />
                                <div class="ml-2">
                                    {{ product.product_name }}
                                    <div v-if="product.color_code" class="d-flex">
                                        <b>Color : </b>
                                        <label :style="{
                                            backgroundColor: product.color_code, marginLeft: '10px', borderRadius: '50%', border: '1px solid', cursor: 'auto', height: '20px', width: '20px', display: 'inline-block',
                                        }"></label>
                                    </div>
                                    <ul>
                                        <Attribute :product="product" />
                                    </ul>

                                    <span v-if="product.shipping_charges == 'free'">Free Delivery</span>

                                    <span v-else>
                                        Delivery Charges :{{ generalSettings.currency }}{{ charges }}
                                    </span>

                                </div>
                            </td>
                            <td>
                                {{ $filters.formatNumber( product.taxable_price) }} {{ generalSettings.currency }}
                            </td>
                            <td>
                                {{ product.qty }}
                            </td>
                            <td>
                                <span class="product-total">
                                    {{ 
                                        product.shipping_charges == 'free' 
                                        ? $filters.formatNumber( parseInt(product.taxable_price) * product.qty )
                                        : $filters.formatNumber( parseInt(product.taxable_price) * product.qty + parseInt(charges) )
                                    }}
                                </span>
                                {{ generalSettings.currency }}
                            </td>
                        </tr>

                        <tr>
                            <td colSpan="3" align="right">
                                <b>Total Amount</b>
                            </td>
                            <td class="">
                                <span>{{ $filters.formatNumber( calculateTotal() ) }}</span>
                                {{ generalSettings.currency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="activeStep == 3" id="Step1" class="py-3">
                <div class="card">
                    <div class="card-header"> Payment </div>
                    <div class="card-body">
                        <ul class="list-group">

                            <li v-for="payButton in payment_method" class="list-group-item" :key="payButton.id">

                                <template v-if="payButton.payment_name == 'Paypal' && payButton.payment_status == '1'">
                                    <input type="radio" name="pay_method" v-model="data.pay_method" value="paypal" required />
                                    <img :src="`${baseUrl}/images/paypal.png`" alt="" height="20px" />
                                </template>
                                <template v-if="payButton.payment_name == 'COD' && payButton.payment_status == '1'">
                                    <input type="radio" name="pay_method" v-model="data.pay_method" value="cod" required />
                                    <img :src="`${baseUrl}/images/cod.png`" alt="" height="20px" />
                                </template>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="multi-footer">
            <ul class="d-flex justify-content-end">

                <li v-if="activeStep > 1" class="ml-2">
                    <button type="button" class="btn btn-primary" @click="handleStep(activeStep - 1)">
                        Prev
                    </button>
                </li>

                <li v-if="activeStep > 0 && activeStep < 3" class="ml-2">
                    <button type="button" class="btn btn-primary" @click="handleStep(activeStep + 1)">
                        Next
                    </button>
                </li>
                <li v-if="activeStep > 2" class="ml-2">
                    <input type="submit" :disabled="data.processing" class="btn btn-primary" value="Complete Order" />
                </li>
            </ul>
        </div>
    </form>
</template>


<style scoped></style>