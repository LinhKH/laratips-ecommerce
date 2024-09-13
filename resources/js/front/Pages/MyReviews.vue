<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';

import Paginate from '../Components/Paginate.vue';

const { reviews } = usePage().props;


</script>

<template>

    <Head title="My Reviews"></Head>
    <FrontLayout>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Đánh giá của bạn</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Trang chủ</Link>
                            </li>
                            <li class="breadcrumb-item active">Đánh giá của bạn</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-xl container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div v-for="row in reviews.data" class="card mb-4" :key="row.id">
                            <h5 class="card-header">{{ row.product_name }}</h5>
                            <div class="card-body">
                                <h5>{{ row.title }}</h5>
                                <p>{{ row.desc }}</p>
                                <ul class="show-review-rating mb-2">

                                    <li v-for="(value, index) in Array.from({ length: 5 })" key="index" :class="[(index < row.rating) ? 'fa fa-star' : 'far fa-star']"></li>

                                </ul>

                                <div v-if="row.hide_by_admin == '1'"
                                    class="alert alert-danger p-2 py-0 m-0 d-inline-block">
                                    Đã ẩn bởi Admin
                                </div>

                                <div v-if="row.approved == '0'" class="alert alert-danger p-2 py-0 m-0 d-inline-block">
                                    Đang phê duyệt
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <Paginate v-if="reviews.from != reviews.last_page" :pagination="reviews"></Paginate>
                
            </div>
        </div>
    </FrontLayout>

</template>