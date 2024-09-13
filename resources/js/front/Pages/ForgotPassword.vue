<script setup>
import { usePage, Link, useForm, Head } from "@inertiajs/vue3";

import Preloader from "../Components/Preloader.vue";
const baseUrl = import.meta.env.VITE_APP_URL;


const { flash } = usePage().props;

const data = useForm({
    email: ""
});

function handleSubmit(e) {
    data.post(route('user_forgot_password.store'), {
        onFinish: () => {
            data.reset();
        }
    });
}

</script>
<template>

    <Head title="Forget password page" />
    <div id="site-content" class="py-5">
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>Quên mật khẩu</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Trang chủ</Link>
                        </li>
                        <li class="breadcrumb-item active">Quên mật khẩu</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="signup-form">
                        <Preloader v-if="data.processing" />
                        <form class="form-horizontal mb-3" @submit.prevent="handleSubmit" autoComplete="off">
                            <h4 class="user-heading mb-4">Quên mật khẩu</h4>
                            <input type="hidden" class="url" value="/" />
                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="Địa chỉ email"
                                    v-model="data.email" />
                                <div v-if="data.errors.email" class="alert alert-danger mt-2" role="alert">{{
                                    data.errors.email }}</div>
                            </div>
                            <input type="submit" :disabled="data.processing" name="save" class="btn btn-primary"
                                value="Gửi link khôi phục mật khẩu" required />
                            <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert"> {{
                                $page.props.flash.error }} </div>
                            <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert"> {{
                                $page.props.flash.success }} </div>
                        </form>
                        <span class="login-link">
                            <Link :href="route('user_login')">Quay lại trang đăng nhập</Link>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>