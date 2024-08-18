<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Attribute from './Attribute.vue';
import { computed } from 'vue';
import { parseInt } from 'lodash';
import FrontLayout from '../Layouts/FrontLayout.vue';

const baseUrl = import.meta.env.VITE_APP_URL;


const charges = computed(() => userSession.user_city != null ? city.filter((city) => city.id == userSession.user_city)[0].cost_city : 0);

const {
    generalSettings,
    userSession,
    city,
    attributes,
    attrvalues,
    cart,
    token,
    flash,
} = usePage().props;


const total = computed(() => {
     return usePage().props.products.reduce(function (acc, obj) { return acc + obj.taxable_price * obj.qty; }, 0) + parseInt(charges.value);
})

const products = computed(() => usePage().props.products)

const handleChangeQty = (e) => {
    let val = e.target.value;
    let id = e.target.id.replace("cart", "");
    console.log(val, id)
    router.post(
        route('update_cart_qty'),
        { id: id, qty: val },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};

function handleRemoveCart(cart_id) {
    router.post(
        route('remove_cart'),
        { id: cart_id },
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
}
</script>
<template>
    <FrontLayout>

    
    <Head title="My Cart Page"></Head>
    <div id="site-content">

        <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert">
            {{ $page.props.flash.error }}
        </div>


        <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert">
            {{ $page.props.flash.success }}
        </div>

        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>My Cart</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link :href="`${baseUrl}`">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">My Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-xl container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form v-if="products.length > 0" :action="route('checkout.store')">
                        <input type="hidden" name="_token" :value="token" />
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td class="d-flex flex-row">
                                        <input type="hidden" name="product_id[]" value="product.id" />
                                        <input type="hidden" name="product_attr[{{$product->id}}]"
                                            value="product.attrvalues" />
                                        <input type="hidden" name="product_color[{{$product->id}}]"
                                            value={product.color} />
                                        <img class="pic-1" :src="`${baseUrl}/products/${product.thumbnail_img}`
                                            " :alt="product.product_name" width="100px" />
                                        <div class="ml-2">
                                            {{ product.product_name }}
                                            <span v-if="product.color_code" class="d-flex">
                                                <b>Color : </b>
                                                <label class="border" :style="{
                                                    backgroundColor: product.color_code,
                                                    marginLeft: '10px',
                                                    borderRadius: '50%',
                                                    cursor: 'auto',
                                                    height: '25px',
                                                    width: '25px',
                                                }
                                                    "></label>
                                            </span>
                                            <Attribute :product="product" />

                                            <span v-if="product.shipping_charges == 'free'">
                                                Free Delivery
                                            </span>

                                            <span v-else>
                                                Delivery Charges : {{ generalSettings.currency }} {{ charges }}
                                            </span>

                                        </div>
                                    </td>
                                    <td>
                                        {{ generalSettings.currency }}
                                        {{ product.taxable_price }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" :name="`qty[${product.id}]`" min="1"
                                            style="width: '80px'" :defaultValue="product.qty"
                                            :id="`cart${product.cart_id}`" @change="handleChangeQty" />
                                        <input type="number" class="product-price" :name="`price[${product.id}]`"
                                            :defaultValue="product.taxable_price" hidden />
                                        <input type="number" class="product-shipping" :defaultValue="charges" hidden />
                                    </td>
                                    <td>
                                        {{ generalSettings.currency }}
                                        <span class="product-total" v-if="product.shipping_charges == 'free'">
                                            {{ parseInt(
                                                product.taxable_price *
                                                product.qty
                                            ) }}
                                        </span>
                                        <span v-else>
                                            {{ parseInt(
                                                product.taxable_price *
                                                product.qty
                                            ) +
                                                parseInt(charges) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" @click="handleRemoveCart(product.id)">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                                <tr>
                                    <td colSpan="3" align="right">
                                        <b>Total Amount</b>
                                    </td>
                                    <td class="">
                                        {{ generalSettings.currency }}
                                        <span>{{ total }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Link class="btn btn-primary" href="/">
                        Continue Shopping
                        </Link>
                        <Link class="btn btn-primary float-right" href="/checkout">
                        Proceed to Checkout
                        </Link>
                    </form>

                    <div v-else class="content-box text-center">
                        <p class="">No Products Found</p>
                        <Link href="/" class="btn btn-primary">
                        Shop Now
                        </Link>
                    </div>
                </div>
            </div>
        </div>

    </div>
</FrontLayout>
</template>