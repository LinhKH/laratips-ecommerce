<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
const baseUrl = import.meta.env.VITE_APP_URL;
import FrontLayout from '../Layouts/FrontLayout.vue';

const { flash_deals } = usePage().props;

const isCheckShow = (flash_deal) => {
    const datetime = flash_deal.flash_date_range.split("-");
    const currentDatetime = new Date();

    let startDatetime = "";
    let endDatetime = "";

    if (flash_deal.flash_date_range !== "") {
        startDatetime = new Date(datetime[0]);
        endDatetime = new Date(datetime[1]);
    }
    if (
        flash_deal.status == "1" &&
        currentDatetime >= startDatetime &&
        currentDatetime <= endDatetime
    ) {
        return true;
    }
}
</script>

<template>

    <Head title="All Flash Deals"></Head>
    <FrontLayout>
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>All Flash Deals</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">
                            All Flash Deals
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <section id="flash-deals" class="py-4">
            <div class="container-xl container-fluid">
                <div class="row">
                    <template v-for="flash_deal in flash_deals.data" :key="`${flash_deal.id}`">
                        <div v-if="isCheckShow(flash_deal)" class="col-md-4 flash-deal-box">
                            <div class="banner-inner">
                                <Link :href="`${baseUrl}/flash-products/${flash_deal.flash_slug}`">
                                <img :width="225" :height="225"
                                    :src="`${baseUrl}/flash-deals/${flash_deal.flash_image.split(',')[0]}`" alt="" />
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </FrontLayout>
</template>

<style scoped></style>