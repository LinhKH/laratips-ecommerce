<script setup>
import Header from "@/front/Components/Header.vue";
import Footer from "@/front/Components/Footer.vue";
</script>

<template>
    <div>
        <Header />
        <slot></slot>
        <Footer />
    </div>
</template>
