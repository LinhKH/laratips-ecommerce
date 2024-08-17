<script setup>
import { usePage, Link, useForm, router  } from "@inertiajs/vue3";

const baseUrl = import.meta.env.VITE_APP_URL;

import ChildHeader from "./ChildHeader.vue"
import { onMounted } from "vue";
// import Swal from 'sweetalert2';

const {
        generalSettings,
        sitePages,
        userSession,
        userWishlist,
        userCart,
        all_category,
        flash,
    } = usePage().props;

    if (flash.success == "logout") {
        Swal.fire({
            title: "Logged out Successfully.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    const data = useForm({
        keyword: new URL(window.location.href).searchParams.get("keyword")
            ? new URL(window.location.href).searchParams.get("keyword")
            : "",
        category: new URL(window.location.href).searchParams.get("category")
            ? new URL(window.location.href).searchParams.get("category")
            : "all",
    });

    function handleSubmit(e) {
        // e.preventDefault();
        router.get(baseUrl + "/search", data);
    };
    
</script>

<template>
    <div id="wrapper">
           
            <header id="header">
                <div class="top-header d-lg-block">
                    <div class="container-xl container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="top-address">
                                    
                                    <li v-if="generalSettings.email">
                                        <i class="fa fa-envelope"></i>
                                        {{generalSettings.email}}
                                    </li>
                                
                                    <li v-if="generalSettings.phone">
                                        <i class="fa fa-phone"></i>
                                        {{generalSettings.phone}}
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="top-right-menu text-end">
                                    <li>
                                        <span class="welcome-message">
                                            welcome to our store!
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-xl container-fluid">
                    <div class="row my-2">
                        <div class="col-lg-3 col-md-4 col-sm-12 align-self-center">
                            <div class="logo">
                                <Link href="/">
                                    <img
                                        :src="`${baseUrl}/site/${generalSettings.site_logo}`"
                                        :alt="generalSettings.site_logo"
                                    />
                                </Link>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-8 col-sm-12">
                            <div class="searchbox position-relative my-3">
                                <form @submit.prevent="handleSubmit"
                                    method="GET"
                                    class="search-form rounded-0 d-flex"
                                >
                                    <input
                                        type="text"
                                        class="form-control rounded-0"
                                        name="keyword"
                                        v-model="data.keyword"
                                        placeholder="Search Product Here..."
                                    />
                                    <select
                                        class="form-select search-categories"
                                        v-model="data.category"
                                        name="category"
                                        aria-label="Default select example"
                                    >
                                            <option value="all">
                                                All Categories
                                            </option>
                                            <template v-for="item in all_category" key="item.id">
                                                <option v-if="item.parent_category == '0'" :value="item['category_slug']"  
                                                >
                                                   {{ item.category_name }}
                                                </option>
                                                <ChildHeader :children="item.id" />
                                            </template>
                                    </select>
                                    <button
                                        type="submit"
                                        class="btn btn-primary rounded-0"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </form>
                                <div class="search-content position-absolute"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <ul class="header-as ml-auto mr-0 text-lg-right text-center">
                                <li v-if="userSession">
                                    <div class="dropdown">
                                        <a
                                            href="#"
                                            class="dropdown-toggle"
                                            id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                        >
                                            <i class="far fa-user"></i>
                                            Hello, {{ userSession.user_name.substring(
                                                0,
                                                10
                                            ) + "..." }}
                                        </a>
                                        <div
                                            class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton"
                                        >
                                            <Link
                                                class="dropdown-item"
                                                href=""
                                            >
                                                My Profile
                                            </Link>
                                            <Link
                                                class="dropdown-item"
                                                href=""
                                            >
                                                My Cart
                                            </Link>
                                            <Link
                                                class="dropdown-item"
                                                href=""
                                            >
                                                My Orders
                                            </Link>
                                            <Link
                                                class="dropdown-item"
                                                href=""
                                            >
                                                My Reviews
                                            </Link>
                                            <Link
                                                class="dropdown-item"
                                                href=""
                                            >
                                                Change Password
                                            </Link>
                                            <Link
                                                class="dropdown-item"
                                                :href="route('user_logout')"
                                            >
                                                Log Out
                                            </Link>
                                        </div>
                                    </div>
                                </li>
                                
                                <li v-else>
                                    <Link
                                        :href="route('user_login')"
                                    >
                                        <i class="far fa-user"></i>
                                        My Account
                                    </Link>
                                </li>
                                   
                           
                                <li>
                                    <Link :href="route('user_login')">
                                        <i class="far fa-heart"></i>
                                        Wishlist
                                    </Link>
                                    <span class="wishlist-count">
                                        {{ userWishlist }}
                                    </span>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fas fa-shopping-cart"></i>
                                        Cart
                                    </a>
                                    <span class="cartlist">{{ userCart }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <nav class="navbar navbar-expand-lg">
                <div class="container-xl container-fluid">
                    <div class="navbar-brand" href="#">
                        <div class="nav-item dropdown">
                            <Link
                                class="nav-a dropdown-toggle"
                                href="#"
                                id="navbarDropdownMenua"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Shopping By Categories
                            </Link>
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdownMenua"
                            >
                                <template v-for="cat_menu in all_category" :key="cat_menu.id">
                                    <li v-if="cat_menu.parent_category == '0'">
                                        <Link
                                            class="dropdown-item"
                                            href=""
                                        >
                                        {{ cat_menu.category_name }}
                                        </Link>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div
                        class="collapse navbar-collapse"
                        id="navbarNavDropdown"
                    >
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <Link
                                    class="nav-a active"
                                    aria-current="page"
                                    :href="`${baseUrl}`"
                                >
                                    Home
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-a active"
                                    aria-current="page"
                                    href=""
                                >
                                    Shop
                                </Link>
                            </li>
                            <template v-for="page in sitePages">
                                <li v-if="page.show_in_header == '1'"
                                    class="nav-item"
                                    key="page.page_id"
                                >
                                    <Link
                                        href=""
                                        class="nav-a active"
                                        aria-current="page"
                                    >
                                    {{ page.page_title }}
                                    </Link>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
</template>