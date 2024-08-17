<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
const baseUrl = import.meta.env.VITE_APP_URL;

const { today_deal_products } = usePage().props;

const {
    generalSettings,
    sitePages,
    userSession,
    userWishlist,
    userCart,
    all_category,
    flash,
} = usePage().props;



</script>

<template>
    this is today deals
</template>