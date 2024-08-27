
<script setup>
import { onMounted } from 'vue';
import Footer from '../Components/Footer.vue';
import Header from '../Components/Header.vue';
import Sidebar from '../Components/Sidebar.vue';
import Alert from '@/admin/Components/Alert.vue';

onMounted(() => {
    $('.select2').select2();

    $('#summernote').summernote({
        height: 200,
    });

})
</script>

<template>
    <Alert />
    <Header />
    <Sidebar />
    <div class="content-wrapper">
        <slot></slot>
    </div>
    <Footer />
</template>

<style lang="scss" scoped>

</style>