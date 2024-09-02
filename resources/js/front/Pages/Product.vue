<script setup>
import { usePage, Link, useForm, router, Head } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
import { computed, onMounted, ref, watch } from 'vue';
const baseUrl = import.meta.env.VITE_APP_URL;

import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css'
import ProductRating from './ProductRating.vue';
import { watchEffect } from 'vue';
import RelatedProducts from './RelatedProducts.vue';
let currentSlide = ref(0);

const c_check = (item) => item.id == data.color ? true : false;
const c_attr = (row, item1) => {
    return item1.id == data[row.title.toLowerCase()] ? true : false;
};

const checkValue = (row, item1) => {
    const value = row.attrvalues.split(",").filter((val) => val !== "");
    return value?.includes(item1.id.toString())
}

const slideTo = (val) => {
    currentSlide.value = val
};

const {
    generalSettings,
    userSession,
    product,
    colors,
    attributes,
    attrvalues,
    cities,
    reviews,
    cart,
    breadcrumb,
} = usePage().props;

const charges = ref(null);

const userCity = ref(userSession != null ? userSession.user_city : null)

const product_colors = product.colors ? product.colors.split(",") : '';

const show_shipping_charges = (shipping, user_city) => {
    if (shipping != "free") {
        if (user_city != null) {
            let city = cities.filter((city) => city.id == user_city);
            if (city[0].cost_city == "0") {
                charges.value = "free"
            } else {
                charges.value = generalSettings.currency + city[0].cost_city
            }
        }
    } else {
        charges.value = "free"
    }
};

const handleCityChange = (e) => {
    userCity.value = e.target.value
    show_shipping_charges(product.shipping_charges, e.target.value);
};

let selectedColor = ref(product_colors[0] || "")
let cart_list = ref(cart)

let data = useForm({
    product_id: product.id,
    color: selectedColor.value,
    location: userCity.value,
});

const handleSubmit = (e) => {
    if (userCity == null) {
        Swal.fire({
            title: "Select Location First",
            icon: "warning",
        });
    } else {
        router.post(route('save_cart'), { ...data }, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (response) => {
                Swal.fire({
                    title: "Added Successfully.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000,
                });
            },
        });
    }
};

const handleBuyNow = (e) => {
    if (userCity.value == null) {
        Swal.fire({
            title: "Select Location First",
            icon: "warning",
        });
    } else {
        // console.log(data);return false;
        data.transform((data) => ({
            ...data,
            ... objAttrValue
        })).get(route('checkout'));
    }
};

let objAttrValue = {};
const handleRadio = (e) => {

    objAttrValue[e.target.name] = e.target.value;

    // data.transform((data) => ({
    //     ...data,
    //     [e.target.name]: e.target.value,
    // }))


    console.log(objAttrValue);
}

watchEffect(() => {
    show_shipping_charges(product.shipping_charges, userCity.value);
    attributes.map((item) => {
            data = { ...data, [item.title.toLowerCase()]: item.attrvalues.split(",")[0] }
            objAttrValue[item.title.toLowerCase()] = item.attrvalues.split(",")[0]
        }
    );
});
  
</script>

<template>

    <Head :title="product.product_name"></Head>
    <FrontLayout>
        <section id="site-content" class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="content-box single-product">
                            <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide">
                                <Slide v-for="item in product.gallery_img && product.gallery_img.split(',')"
                                    :key="item.id">
                                    <div class="carousel__item">
                                        <img class="w-90" :src="`${baseUrl}/products/${item}`" />
                                    </div>
                                </Slide>
                            </Carousel>
                            <Carousel id="thumbnails" :items-to-show="4" :wrap-around="false" v-model="currentSlide"
                                ref="carousel">
                                <Slide v-for="(item, index) in product.gallery_img && product.gallery_img.split(',')"
                                    :key="index">

                                    <img @click="slideTo(index)" class="w-5" :src="`${baseUrl}/products/${item}`" />
                                </Slide>
                            </Carousel>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" @submit.prevent="handleSubmit" noValidate>
                            <div class="product-info">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb justify-content p-0 align-items-center">
                                        <li class="product-name">Category :</li>
                                        <template v-if="breadcrumb != null">
                                            <template v-for="value in breadcrumb" :key="value.id">

                                                <li class="breadcrumb-item">
                                                    <Link :href="`${baseUrl}/search?category=${value.category_slug}`">
                                                    {{ value.category_name }}
                                                    </Link>
                                                </li>
                                            </template>
                                        </template>
                                    </ol>
                                </nav>
                                <span class="brand-name">
                                    Brand: {{ product.brand_name }}
                                </span>
                                <p class="product-name">
                                    {{ product.product_name }}
                                </p>
                                <div v-if="product.discount != '0'" class="product-price">
                                    <span class="special-price">
                                        {{ generalSettings.currency }}
                                        {{ product.taxable_price -
                                            product.discount }}
                                    </span>
                                    <span class="old-price">
                                        {{ generalSettings.currency }}
                                        {{ product.taxable_price }}
                                    </span>
                                    <span class="discount-price">
                                        {{ product.discount_percent }} off
                                    </span>
                                </div>
                                <div v-else class="product-price">
                                    <span class="special-price">
                                        {{ generalSettings.currency }}
                                        {{ product.taxable_price }}
                                    </span>
                                </div>
                                <ProductRating :rating_col="product.rating_col" :rating_sum="product.rating_sum" />
                                <div class="product-color">
                                    <label>Color:</label>
                                    <ul class="option-list">
                                        <template v-for="item1 in colors" :key="item1.id">
                                            <li v-if="product.colors?.includes(item1.id)" class="radio-button">
                                                <input type="radio" name="color" :id="`color${item1.id}`"
                                                    :value="item1.id" v-model="data.color" :checked="c_check(item1)" />
                                                <label :for="`color${item1.id}`"
                                                    :style="{ backgroundColor: item1.color_code }"></label>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <template v-for="row in attributes" :key="row.id">
                                    <div class="product-attributes">
                                        <span>{{ row.title }}:</span>
                                        <template v-for="item1 in attrvalues" :key="item1.id">
                                            <template v-if="checkValue(row, item1)">
                                                <input type="hidden" name="product_attrvalues" :value="item1.id" />
                                                <input type="radio" class="attrvalue" :id="`attrvalue${item1.id}`" @click="handleRadio"
                                                    :name="row.title.toLowerCase()" :value="item1.id"
                                                    v-model="data[row.title.toLowerCase()]"
                                                    :checked="c_attr(row, item1)" />
                                                <label :for="`attrvalue${item1.id}`">
                                                    {{ item1.value }}
                                                </label>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                                <div class="product-shipping">
                                    <span class="shipping-head">
                                        Delivery:
                                    </span>
                                    <select class="form-control shipping" :value="userCity" name="shipping"
                                        @change="handleCityChange" required>
                                        <option value="" disabled>
                                            Select Location
                                        </option>
                                        <option v-for="city in cities" :key="city.id" :value="city.id"
                                            :data-p-ship="product.shipping_charges" :data-shipping="city.cost_city">
                                            {{ city.city_name }} ({{ city.state_name }})
                                        </option>
                                    </select>
                                </div>
                                <div v-if="charges != null" class="shipping-charges mb-2">
                                    Shipping Charges : {{ charges }}
                                </div>
                                <div class="product-btn">
                                    <template v-if="userSession != null">
                                        <Link v-if="cart_list?.includes(product.id)" :href="`${baseUrl}/cart`"
                                            class="btn btn-primary">
                                        Go to cart
                                        </Link>
                                        <template v-else>
                                            <input type="submit" class="btn btn-primary mr-2" name="save_cart"
                                                value="Add to Cart" />
                                            <button type="button" @click.prevent="handleBuyNow"
                                                class="btn btn-primary mr-2">
                                                Buy Now
                                            </button>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <Link :href="`${baseUrl}/user_login`" class="btn btn-primary me-2">
                                        Add to cart
                                        </Link>
                                        <a :href="`${baseUrl}/user_login`" class="btn btn-primary">
                                            Buy Now
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Description
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    aria-expanded="false" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p v-html="product.description"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Additional Information
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <tbody>
                                                <tr v-if="attributes.length > 0" v-for="row in attributes" :key="row.id"
                                                    class="product-attributes">
                                                    <th>{{ row.title }}</th>
                                                    <template v-for="item1 in attrvalues" :key="item1.id">
                                                        <td v-if="checkValue(row, item1)">
                                                            {{ item1.value }}
                                                        </td>
                                                    </template>
                                                </tr>
                                                <tr v-else>
                                                    <td class="col-md-6">
                                                        <span>
                                                            No Additional Information.
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Reviews
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div v-if="reviews.length > 0" class="col-md-6">
                                                <div class="product-reviews">
                                                    <div v-for="review in reviews" :key="review.id" class="review-item">
                                                        <h6>
                                                            <span class="bg-success">
                                                                <i class="fa fa-star"></i>
                                                                {{ review.rating }}
                                                            </span>
                                                            {{ review.title }}
                                                        </h6>
                                                        <p>
                                                            {{ review.desc }}
                                                        </p>
                                                        <span class="user">
                                                            {{ review.name }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="product.video_link !== ''" className="col-md-6"></div>
                                        </div>
                                        <div v-if="reviews.length == 0" className="col-md-6">
                                            <span>
                                                No Reviews Available.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div className="col-12">
                        <RelatedProducts />
                    </div>
                </div>
            </div>
        </section>
    </FrontLayout>
</template>

<style scoped></style>