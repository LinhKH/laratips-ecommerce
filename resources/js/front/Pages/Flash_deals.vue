<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const baseUrl = import.meta.env.VITE_APP_URL;

const { flash_deals } = usePage().props;

const deals = flash_deals.filter((deal) => {
    const datetime = deal.flash_date_range.split("-");
    const currentDatetime = new Date();

    let startDatetime = "";
    let endDatetime = "";

    if (deal.flash_date_range !== "") {
        startDatetime = new Date(datetime[0]);
        endDatetime = new Date(datetime[1]);
    }

    if (
        currentDatetime >= startDatetime &&
        currentDatetime <= endDatetime
    ) {
        return deal;
    }
    return null;

});

</script>

<template>
    <section id="flash-deals" class="py-4">
        <div class="container-xl container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2 class="title">Ưu đãi</h2>
                        <Link class="btn btn-primary text-white" :href="`${baseUrl}/all-flash-deals`">
                        Tất cả
                        </Link>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-for="flash_deal in deals" class="col-lg-4 col-md-6 col-sm-6 mb-5 text-center" :key="`${flash_deal.id}`">
                    <div class="banner-inner">
                        <Link :href="`${baseUrl}/flash-products/${flash_deal.flash_slug}`" >
                        <img :width='225' :height='225' :src="`${baseUrl}/flash-deals/${flash_deal.flash_image.split(',')[0]} `" :alt="`${flash_deal.flash_slug}`" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped></style>