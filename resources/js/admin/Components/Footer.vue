<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const baseUrl = import.meta.env.VITE_APP_URL;

const { generalSettings, sitePages, all_category } = usePage().props;


</script>
<template>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright {{ new Date().getFullYear() }} by <a href="https://news-portal.shop/">Linh Dev</a>.</strong>
        All rights reserved
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</template>