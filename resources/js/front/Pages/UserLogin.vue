<script setup>
import { usePage, Link, useForm, Head } from "@inertiajs/vue3";

import Preloader from "../Components/Preloader.vue";
const baseUrl = import.meta.env.VITE_APP_URL;

const { flash } = usePage().props;

const data = useForm({
    username: "mr.linh1090@gmail.com",
    password: "123456",
});

function handleSubmit(e) {

    data.post(baseUrl + "/user_login", {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (response) => {
            if (response.props.flash.success) {
                Swal.fire({
                    title: "Loggedin Successfully.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
                setTimeout(() => {
                    window.location.href = document.referrer;
                    // window.location.href = "/";
                }, 1000);
            }
        },
    });
}

</script>
<template>

    <Head title="Login page" />
    <div id="site-content" class="py-5">
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>Login</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link :href="baseUrl">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3">
                    <div class="signup-form">
                        <Preloader v-if="data.processing" />
                        <form class="form-horizontal mb-3" @submit.prevent="handleSubmit" autoComplete="off">
                            <h4 class="user-heading">Login</h4>
                            <input type="hidden" class="url" :value="`${baseUrl}`" />
                            <div class="form-group">
                                <input type="email" name="username" class="form-control" placeholder="Email Address"
                                    v-model="data.username" />

                                <div v-if="data.errors.username" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.username }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    v-model="data.password" />
                                <div v-if="data.errors.password" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.password }}
                                </div>
                            </div>

                            <div class="d-flex flex-row justify-content-between">
                                <input type="submit" :disabled="data.processing" name="save"
                                    class="btn btn-primary login-btn" value="Login" required />
                                <Link :href="`${baseUrl}/forgot-password`" class="forgot-password align-self-center">
                                forgot password
                                </Link>
                            </div>

                            <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert">
                                {{ $page.props.flash.error }}
                            </div>

                            <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert">
                                {{ $page.props.flash.success }}
                            </div>
                        </form>
                        <span class="signup-link">
                            <Link :href="`${baseUrl}/signup`">
                            Create Account
                            </Link>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>