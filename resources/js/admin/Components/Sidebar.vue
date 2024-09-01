<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
import { ref, computed, onMounted } from 'vue';

const baseUrl = import.meta.env.VITE_APP_URL;
const { generalSettings, sitePages, all_category, auth } = usePage().props;

let menuOpenPro = ref(false);
let menuOpenReport = ref(false);

let activeClassProduct = ref(menuOpenPro.value || (route().current('admin.products.*') || route().current('admin.category.*') || route().current('admin.colors.*') || route().current('admin.brand.*')
    || route().current('admin.attribute.*') || route().current('admin.attribute-values.*') || route().current('admin.flash-deals.*')));

let activeClassReport = ref( menuOpenReport.value || ( route().current('admin.product_sale.*') || route().current('admin.product_stock.*') ) );

const classObjectReport = computed(() => ({
    'menu-is-opening': activeClassReport.value,
    'menu-open': menuOpenReport.value
}));

const classObjectProduct = computed(() => ({
    'menu-is-opening': activeClassProduct.value,
    'menu-open': menuOpenPro.value
}));

onMounted(() => {
    if (activeClassProduct.value) {
        menuOpenPro.value = true;
    }

    if (activeClassReport.value) {
        menuOpenReport.value = true;
    }
});

</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="javascript:void(0)" class="brand-link">

            <img v-if="generalSettings.site_logo" class="bg-white p-2" width="100%"
                :src="`${baseUrl}/site/${generalSettings.site_logo}`" :alt="generalSettings.site_name">

            <span v-else class="brand-text font-weight-light">{{ generalSettings.site_name }}</span>

        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <Link preserve-scroll :href="route('admin.dashboard')"
                            class="nav-link {{ Request::path() == 'admin/dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                        </Link>
                    </li>
                    <li class="nav-item has-treeview" :class="classObjectProduct">
                        <a @click="menuOpenPro = !menuOpenPro" href="javascript:;" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Products <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.products.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.products.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.products.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>All Products</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.category.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.category.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.category.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Category</p>
                                </Link>
                            </li>

                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.brand.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.brand.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.brand.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Brand</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.colors.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.colors.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.colors.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Colors</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.attribute.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.attribute.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.attribute.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Attribute Sets</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.attribute-values.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.attribute-values.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.attribute-values.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Attribute Values</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.flash-deals.index')"
                                    :class="['nav-link', route().current('admin.flash-deals.*') ? 'active bg-primary' : '']">
                                <i class="nav-icon" :class="[ route().current('admin.flash-deals.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Flash Deals</p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('admin.orders.index')"
                            :class="['nav-link', (route().current('admin.orders.*') || route().current('admin.view_order') || route().current('admin.order_delivered')) ? 'active bg-primary' : '']">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Orders
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item has-treeview" :class="classObjectReport">
                        <a @click="menuOpenReport = !menuOpenReport" href="javascript:;" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Reports <i :class="['fas rightCustom', !menuOpenReport ? 'fa-angle-left' : 'fa-angle-down']"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link :href="route('admin.product_sale.index')"
                                    :class="['nav-link', route().current('admin.product_sale.*') ? 'active bg-primary' : '']">
                                    <i class="nav-icon" :class="[ route().current('admin.product_sale.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Products Sold</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.product_stock.index')"
                                    :class="['nav-link', route().current('admin.product_stock.*') ? 'active bg-primary' : '']">
                                    <i class="nav-icon" :class="[ route().current('admin.product_stock.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Products Stock</p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('admin.users.index')" class="nav-link"
                            :class="{ 'active': route().current('admin.users.*') }">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                        </Link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

</template>
<style scoped>
.nav-sidebar .nav-link>.rightCustom,
.nav-sidebar .nav-link>p>.rightCustom {
    position: absolute;
    right: 1rem;
    top: .7rem;
}
</style>