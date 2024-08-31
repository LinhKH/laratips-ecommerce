<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
import { ref, computed, onMounted } from 'vue';

const baseUrl = import.meta.env.VITE_APP_URL;
const { generalSettings, sitePages, all_category, auth } = usePage().props;

let menuOpen = ref(false);

const handleClick = () => {
    menuOpen.value = !menuOpen.value
};

let activeClass = ref(menuOpen.value || (route().current('admin.products.*') || route().current('admin.category.*') || route().current('admin.colors.*') || route().current('admin.brand.*')
    || route().current('admin.attribute.*') || route().current('admin.attribute-values.*') || route().current('admin.flash-deals.*')));

const classObject = computed(() => ({
    'menu-is-opening': activeClass.value,
    'menu-open': menuOpen.value
}));

onMounted(() => {
    if (activeClass.value) {
        menuOpen.value = true;
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
                    <li class="nav-item has-treeview" :class="classObject">
                        <a @click="handleClick" href="javascript:;" class="nav-link">
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
                        <a href="{{ url('admin/orders') }}"
                            class="nav-link {{ Request::path() == 'admin/orders' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item has-treeview {{ Request::path() == 'admin/countries' || Request::path() == 'admin/states' || Request::path() == 'admin/cities' ? 'menu-open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-shipping-fast"></i>
                            <p>Shipping <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('admin/countries') }}"
                                    class="nav-link {{ Request::path() == 'admin/countries' ? 'active bg-primary' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Available Countries</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/states') }}"
                                    class="nav-link {{ Request::path() == 'admin/states' ? 'active bg-primary' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Available States</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/cities') }}"
                                    class="nav-link {{ Request::path() == 'admin/cities' ? 'active bg-primary' : '' }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>Available Cities</p>
                                </a>
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

<style scoped></style>