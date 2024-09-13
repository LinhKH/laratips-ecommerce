<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
import { ref, computed, onMounted } from 'vue';

const baseUrl = import.meta.env.VITE_APP_URL;
const { generalSettings, sitePages, all_category, auth } = usePage().props;

let menuOpenPro = ref(false);
let menuOpenReport = ref(false);
let menuOpenSetting = ref(false);

let activeClassProduct = ref(menuOpenPro.value || (route().current('admin.products.*') || route().current('admin.category.*') || route().current('admin.colors.*') || route().current('admin.brand.*')
    || route().current('admin.attribute.*') || route().current('admin.attribute-values.*') || route().current('admin.flash-deals.*')));

let activeClassReport = ref( menuOpenReport.value || ( route().current('admin.product_sale.*') || route().current('admin.product_stock.*') ) );

let activeClassSetting = ref( menuOpenSetting.value || ( route().current('admin.general_settings.*') || route().current('admin.social_settings.*') || route().current('admin.profile_settings.*') ) );

const classObjectReport = computed(() => ({
    'menu-is-opening': activeClassReport.value,
    'menu-open': menuOpenReport.value
}));

const classObjectProduct = computed(() => ({
    'menu-is-opening': activeClassProduct.value,
    'menu-open': menuOpenPro.value
}));
const classObjecSetting = computed(() => ({
    'menu-is-opening': activeClassSetting.value,
    'menu-open': menuOpenSetting.value
}));

onMounted(() => {
    if (activeClassProduct.value) {
        menuOpenPro.value = true;
    }

    if (activeClassReport.value) {
        menuOpenReport.value = true;
    }
    if (activeClassSetting.value) {
        menuOpenSetting.value = true;
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
                            Bảng điều khiển
                        </p>
                        </Link>
                    </li>
                    <li class="nav-item has-treeview" :class="classObjectProduct">
                        <a @click="menuOpenPro = !menuOpenPro" href="javascript:;" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Sản phẩm <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.products.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.products.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.products.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Tất cả sản phẩm</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.category.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.category.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.category.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Danh mục sản phẩm</p>
                                </Link>
                            </li>

                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.brand.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.brand.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.brand.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Thương hiệu</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.colors.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.colors.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.colors.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Màu sắc</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.attribute.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.attribute.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.attribute.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Đặt thuộc tính</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.attribute-values.index')" class="nav-link"
                                    :class="{ 'active bg-primary': route().current('admin.attribute-values.*') }">
                                <i class="nav-icon" :class="[ route().current('admin.attribute-values.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Giá trị của thuộc tính</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link preserve-scroll :href="route('admin.flash-deals.index')"
                                    :class="['nav-link', route().current('admin.flash-deals.*') ? 'active bg-primary' : '']">
                                <i class="nav-icon" :class="[ route().current('admin.flash-deals.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                <p>Ưu đãi</p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('admin.orders.index')"
                            :class="['nav-link', (route().current('admin.orders.*') || route().current('admin.view_order') || route().current('admin.order_delivered')) ? 'active bg-primary' : '']">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Đơn hàng
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item has-treeview" :class="classObjectReport">
                        <a @click="menuOpenReport = !menuOpenReport" href="javascript:;" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>Thống kê <i :class="['fas rightCustom', !menuOpenReport ? 'fa-angle-left' : 'fa-angle-down']"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link :href="route('admin.product_sale.index')"
                                    :class="['nav-link', route().current('admin.product_sale.*') ? 'active bg-primary' : '']">
                                    <i class="nav-icon" :class="[ route().current('admin.product_sale.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Sản phẩm đã bán</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.product_stock.index')"
                                    :class="['nav-link', route().current('admin.product_stock.*') ? 'active bg-primary' : '']">
                                    <i class="nav-icon" :class="[ route().current('admin.product_stock.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Sản phẩm còn hàng</p>
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('admin.reviews.index')" class="nav-link"
                            :class="['nav-link', route().current('admin.reviews.*') ? 'active bg-primary' : '']">
                            <i class="nav-icon fas fa-star"></i>
                            <p>
                                Đánh giá
                            </p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('admin.users.index')" class="nav-link"
                            :class="{ 'active': route().current('admin.users.*') }">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Người dùng
                        </p>
                        </Link>
                    </li>
                    <li class="nav-item has-treeview" :class="classObjecSetting">
                        <a @click="menuOpenSetting = !menuOpenSetting" href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Thiết lập <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <Link :href="route('admin.general_settings.index')"
                                    class="nav-link" :class="{ 'active bg-primary': route().current('admin.general_settings.*') }">
                                    <i class="nav-icon" :class="[ route().current('admin.general_settings.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Chung</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.profile_settings.index')"
                                    class="nav-link" :class="{ 'active bg-primary': route().current('admin.profile_settings.*') }">
                                    <i class="nav-icon" :class="[ route().current('admin.profile_settings.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Trang cá nhân</p>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('admin.social_settings.index')"
                                    class="nav-link" :class="{ 'active bg-primary': route().current('admin.social_settings.*') }">
                                    <i class="nav-icon" :class="[ route().current('admin.social_settings.*') ? 'fa fa-check-circle' : 'far fa-circle' ]"></i>
                                    <p>Mạng xã hội</p>
                                </Link>
                            </li>
                        </ul>
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