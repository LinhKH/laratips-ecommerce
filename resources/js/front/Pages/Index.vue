<script setup>
import { Head } from '@inertiajs/vue3';

import FrontLayout from '@/front/Layouts/FrontLayout.vue';
import Banner from '@/front/Pages/Banner.vue';
import Category from '@/front/Pages/Category.vue';
import TodayDeals from '@/front/Pages/TodayDeals.vue';
import LastestProduct from '@/front/Pages/LastestProduct.vue';


</script>
<template>
    <Head title="Welcome to front page" />
    <FrontLayout>
        <!-- <Banner /> -->
        <Category />
        <TodayDeals />
        <LastestProduct />
        <!-- <Flash_deals />
        <Flash_sale />
        <div className="py-4">
            <div className="container">
                <div className="row">
                    <SellingBlog />
                    <SaleBlog />
                    <RatedBlog />
                </div>
            </div>
        </div> -->
    </FrontLayout>
</template>
