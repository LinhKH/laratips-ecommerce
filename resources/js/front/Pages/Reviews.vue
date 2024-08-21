<script setup>
import { usePage, Link, useForm, Head } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const { product, generalSettings, user } = usePage().props;
const  data = useForm({
    user: user,
    product: product.id,
    star: "",
    title: "",
    review: "",
});

function handleSubmit(e) {
    data.post(route('review.store'), {
        preserveScroll: true,
    });
}


</script>

<template>
    <Head title="Write Reviews"></Head>
    <FrontLayout>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Write Reviews</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">
                                Write Reviews
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-xl container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="handleSubmit" method="POST">
                                    <Preloader v-if="data.processing" />
                                    <div class="form-group">
                                        <label for="">Add a Headline</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="title"
                                            v-model="data.title"
                                        />
                                        <div v-if="data.errors.title"
                                            class="alert alert-danger mt-2"
                                            role="alert"
                                        >
                                            {{ data.errors.title }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Write your review</label>
                                        <textarea
                                            name="review"
                                            v-model="data.review"
                                            class="form-control"
                                        ></textarea>
                                        <div v-if="data.errors.review"
                                            class="alert alert-danger mt-2"
                                            role="alert"
                                        >
                                            {{ data.errors.review }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Overall Raing</label>
                                        <ul class="review-rating">
                                            <li v-for="(value, index) in Array.from({ length: 5 })" :key="index" >
                                                <input
                                                    class="star"
                                                    :value="index + 1"
                                                    :id="index + 1"
                                                    type="radio"
                                                    name="star"
                                                    v-model="data.star"
                                                />
                                                <label
                                                    class="star" :for="index + 1"
                                                ></label>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <input
                                        type="submit"
                                        :disabled="data.processing"
                                        class="btn btn-sm btn-primary"
                                        name="submit-review"
                                        value="Submit"
                                    />
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-row">
                            <img
                                :src="`${baseUrl}/products/${product.thumbnail_img}`"
                                class="img-thumbnail"
                                :alt="product.product_name"
                                width="250px"
                            />
                            <div class="text-left px-3">
                                <h6>{{ product.product_name }}</h6>
                                <span>
                                    {{ generalSettings.currency }}
                                    {{ product.taxable_price }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>

<style scoped>

</style>