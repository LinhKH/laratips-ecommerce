<script setup>
import { usePage, Link, useForm, Head } from "@inertiajs/vue3";

import Preloader from "../Components/Preloader.vue";
const baseUrl = import.meta.env.VITE_APP_URL;


const { userSession, flash } = usePage().props;

const data = useForm({
    name: "",
    email: "",
    phone: "",
    password: "",
    con_password: "",
});

function handleSubmit(e) {
    if (data.password == data.con_password) {
        if (data != "") {
            data.post(baseUrl + "/signup", {
                preserveScroll: true,
                onSuccess: (response) => {
                if (response.props.flash.success) {
                    Swal.fire({
                        title: "Register Successfully.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    setTimeout(() => {
                        window.location.href = "/user_login";
                    }, 1000);
                }
            },
            });
        } else {
            window.location.href = "/";
        }
    } else {
        Swal.fire({
            title: "Enter Correct Confirm Password",
            icon: "warning",
        });
    }
}

</script>
<template>
    <Head title="Sign up page" />
    <div id="site-content" class="py-5">
    <div id="banner" class="d-flex flex-row justify-content-center">
    <div class="align-self-center">
        <h2>Signup</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center p-0">
                <li class="breadcrumb-item">
                    <Link :href="`${baseUrl}`">Home</Link>
                </li>
                <li class="breadcrumb-item active">Signup</li>
            </ol>
        </nav>
    </div>
    </div>
    <div class="container">
    <div class="row">
        <div class="offset-lg-3 col-lg-6 col-md-8 offset-md-2">
            <div class="signup-form">
                <Preloader v-if="data.processing"/>
                <form
                    class="form-horizontal mb-3"
                    @submit.prevent="handleSubmit"
                    method="post"
                    autoComplete="off"
                >
                    <h4 class="user-heading">Sign Up</h4>
                    <input
                        type="hidden"
                        class="url"
                        :value="route('signup')"
                    />
                    <input
                        type="hidden"
                        class="url-login"
                        :value="route('user_login')"
                    />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="data.name"
                                />
                                <div v-if="data.errors.name"
                                    class="alert alert-danger mt-2"
                                    role="alert"
                                >
                                    {{ data.errors.name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Email"
                                    v-model="data.email"
                                />
                                <div v-if="data.errors.email"
                                    class="alert alert-danger mt-2"
                                    role="alert"
                                >
                                    {{ data.errors.email }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input
                                    type="number"
                                    name="phone"
                                    class="form-control"
                                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                    placeholder="Phone"
                                    v-model="data.phone"
                                />
                                <div v-if="data.errors.phone"
                                    class="alert alert-danger mt-2"
                                    role="alert"
                                >
                                    {{ data.errors.phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Password"
                                    v-model="data.password"
                                />
                                <div v-if="data.errors.password"
                                    class="alert alert-danger mt-2"
                                    role="alert"
                                >
                                    {{ data.errors.password }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input
                                    type="password"
                                    name="con_password"
                                    class="form-control"
                                    placeholder="Confirm Password"
                                    v-model="data.con_password"
                                />
                                <div v-if="data.errors.con_password"
                                    class="alert alert-danger mt-2"
                                    role="alert"
                                >
                                    {{ data.errors.con_password }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input
                        type="submit"
                        :disabled="data.processing"
                        name="save"
                        class="btn btn-primary"
                        value="Signup"
                        required
                    />
                    <div v-if="flash.error"
                        class="alert alert-danger mt-2"
                        role="alert"
                    >
                        {{ flash.error }}
                    </div>

                    <div v-if="flash.success"
                        class="alert alert-success mt-2"
                        role="alert"
                    >
                        {{ flash.success }}
                    </div>
                </form>
                <span class="login-link">
                    Already have an account 
                    <Link href="user_login">Login</Link>
                </span>
            </div>
        </div>
    </div>
    </div>
    </div>
</template>