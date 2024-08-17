<script setup>
import { usePage, Link, useForm, Head } from "@inertiajs/vue3";

import Preloader from "../Components/Preloader.vue";
const baseUrl = import.meta.env.VITE_APP_URL;


const { email, token, } = usePage().props;

const data = useForm({
    email: email.email,
    token: token,
    password: '',
    password_confirmation: '',
})

function handleSubmit(e) {
    data.post(baseUrl + '/reset-password');
}

</script>

<template>

    <Head title="Reset password page" />
    <div id="site-content" class="py-5">
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>Reset Password</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">Reset Password</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <div class="signup-form">
                        <Preloader v-if="data.processing" />
                        <form class="form-horizontal" @submit.prevent="handleSubmit" autoComplete="off">
                            <h4 class="user-heading">Reset Password</h4>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email Address"
                                    readOnly v-model="data.email" />
                                <div v-if="data.errors.email" class="alert alert-danger mt-2" role="alert">
                                    {data.errors.email}</div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    v-model="data.password" />
                                <input type="text" hidden name="token" v-model="data.token" />
                                <div v-if="data.errors.password" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.password }}</div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirm Password" v-model="data.password_confirmation" />
                                <div v-if="data.errors.password_confirmation" class="alert alert-danger mt-2"
                                    role="alert">{data.errors.password_confirmation}</div>
                            </div>
                            <input type="submit" :disabled="data.processing" name="save" class="btn btn-primary"
                                value="Reset" required />

                            <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert"> {{
                                $page.props.flash.error }} </div>

                            <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert"> {{
                                $page.props.flash.success }} </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>