<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";

const baseUrl = import.meta.env.VITE_APP_URL;

</script>

<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        </ul>
        <ul class="navbar-nav">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Admin
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <Link class="dropdown-item" :href="route('admin.profile_settings.index')">My Profile</Link>
                    
                    <Link class="dropdown-item logout" :href="route('admin.logout')" method="post" as="button">Log Out</Link>
                </div>
            </div>
        </ul>
    </nav>
    <!-- /.navbar -->
</template>

<style scoped></style>