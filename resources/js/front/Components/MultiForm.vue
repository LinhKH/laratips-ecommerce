<script setup>
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import Preloader from "./Preloader.vue";
import Attribute from "./Attribute.vue";
import { ref, computed, reactive } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;

let activeStep = ref(1);
const isAdding = ref(false);

const handleStep = (step) => {
    if (!data.address) {
        Swal.fire({
            title: "Vui lòng chọn địa chỉ giao hàng. Nếu chưa có xin hãy tạo địa chị mới",
            icon: "warning",
        });
        return false;
    }
    activeStep.value = step;
};

const add_address = reactive({
    name: '',
    email: '',
    phone: '',
    country: '',
    state: '',
    city: '',
    address: '',
});

const handleAddAddress = () => {
    router.post(route('address.store'), {...add_address, __method:'post'}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            add_address.name = "";
            add_address.email = "";
            add_address.phone = "";
            add_address.country = "";
            add_address.state = "";
            add_address.city = "";
            add_address.address = "";
            isAdding.value = false;
        }
    });
}

const {
    generalSettings,
    user,
    country,
    state,
    city,
    products,
    payment_method,
    cities,
    razorkey,
} = usePage().props;

const addresses = computed(() => {
    return usePage().props.addresses
})

const charges = user.city != null ? cities.filter((city) => city.id == user.city)[0].cost_city : null;

const calculateTotal = () => {
    let t = 0;
    products.map((item) =>
        item.shipping_charges != "free" ? (t += parseInt(item.taxable_price - item.discount) * item.qty + parseInt(charges)) : (t += parseInt(item.taxable_price - item.discount) * item.qty)
    );
    return t;
};

const data = useForm({
    pay_method: "",
    address: "",
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

            router.get(`${baseUrl}/pay-with-cod/${data.amount}?${urlParams}&amount=${data.amount}&pay_method=${data.pay_method}&address=${data.address}`);
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
                <div>
                    Delivery Details
                </div>
                <div class="col-xl-3" v-for="(address, index) in addresses">
                    <div class="wsus__dash_add_single">
                        <h4>Billing Address {{ index + 1 }}</h4>
                        <ul>
                            <li><strong>Name :</strong> {{address.name}}</li>
                            <li><strong>Phone :</strong> {{address.phone}}</li>
                            <li><strong>Email :</strong> {{address.email}}</li>
                            <li><strong>Country :</strong> {{address.country.country_name}}</li>
                            <li><strong>State :</strong> {{address.state.state_name}}</li>
                            <li><strong>City :</strong> {{address.city.city_name}}</li>
                            <li><strong>Address Detail :</strong> {{address.address}}</li>
                        </ul>
                       
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" :id="`exampleRadios${index}`" v-model="data.address" :value="address.id" >
                        <label class="form-check-label" :for="`exampleRadios${index}`">
                            Choose
                        </label>
                    </div>

                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <a href="javacrtip:;" @click="isAdding = !isAdding" class="btn btn-primary">
                                    Add Address
                                </a>
                            </th>
                        </tr>
                    </thead>
                </table>
                <div class="container-xl container-fluid" v-if="isAdding">
                    <div class="row">
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Họ và tên : </label>
                            <input type="text" class="form-control" name="name" v-model="add_address.name" />
                            <div v-if="$page.props.errors.name" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.name }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Email : </label>
                            <input type="text" class="form-control" name="name" v-model="add_address.email" />
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Số điện thoại : </label>
                            <input type="text" class="form-control" name="phone" v-model="add_address.phone" />
                            <div v-if="$page.props.errors.phone" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.phone }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Quốc gia : </label>
                            <select class="form-control select-country" name="country" v-model="add_address.country">
                                <option value="">Select Country</option>
                                <option v-for="country in country" :key="country.id" :value="country.id">
                                    {{ country.country_name }}
                                </option>
                            </select>
                            <div v-if="$page.props.errors.country" class="alert alert-danger mt-2" role="alert">
                                {{ $page.props.errors.country }}</div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Tỉnh/Thành phố : </label>
                            <select class="form-control" name="state" id="state" v-model="add_address.state">
                                <option value="">First Select Country</option>
                                <template v-for="state in state" :key="state.id">
                                    <option v-if="state.country == add_address.country" :value="state.id">
                                        {{ state.state_name }}
                                    </option>
                                </template>
                            </select>
                            <div v-if="$page.props.errors.state" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.state }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Quận/Huyện : </label>
                            <select class="form-control" name="city" id="city" v-model="add_address.city">
                                <option value="">First Select State</option>
                                <template v-for="city in city" key="city.id">
                                    <option v-if="city.state == add_address.state" :value="city.id">
                                        {{ city.city_name }}
                                    </option>
                                </template>
                            </select>
                            <div v-if="$page.props.errors.city" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.city }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Địa chỉ chi tiết :</label>
                            <input type="text" class="form-control" name="address" v-model="add_address.address" />
                            <div v-if="$page.props.errors.address" class="alert alert-danger mt-2" role="alert">
                                {{ $page.props.errors.address }}</div>
                        </div>
                    </div>
                    <a @click.prevent="handleAddAddress" href="javascript:;" class="btn btn-primary mb-2">
                        Create a new address 
                    </a>
                </div>
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
                                {{ $filters.formatNumber( product.taxable_price - product.discount) }} {{ generalSettings.currency }}
                            </td>
                            <td>
                                {{ product.qty }}
                            </td>
                            <td>
                                <span class="product-total">
                                    {{ 
                                        product.shipping_charges == 'free' 
                                        ? $filters.formatNumber( parseInt(product.taxable_price - product.discount) * product.qty )
                                        : $filters.formatNumber( parseInt(product.taxable_price - product.discount) * product.qty + parseInt(charges) )
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