<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';

const data = useForm({
    password: '',
    new_pass: '',
    re_pass: '',
})

function handleSubmit(e) {
    data.post(route('my_profile.change_password'), {
        preserveScroll: true,
    });
}
</script>
<template>
    <Head title="Change Password"></Head>
    <FrontLayout>
        <div id="user-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Thay đổi mật khẩu</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Trang chủ</Link>
                            </li>
                            <li class="breadcrumb-item active">Thay đổi mật khẩu</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6">
                        <div class="signup-form">
                            <form class="form-horizontal" @submit.prevent="handleSubmit" autocomplete="off">
                                <div class="form-group">
                                    <label>Mật khẩu cũ</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Mật khẩu cũ" v-model="data.password" />
                                    <div v-if="data.errors.password" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.password }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" name="new_pass" class="form-control" id="new-pass"
                                        placeholder="Mật khẩu mới" v-model="data.new_pass" />
                                    <div v-if="data.errors.new_pass" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.new_pass }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu mới</label>
                                    <input type="password" name="re_pass" class="form-control"
                                        placeholder="Nhập lại mật khẩu mới" v-model="data.re_pass" />
                                    <div v-if="data.errors.re_pass" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.re_pass }}</div>
                                </div>
                                <input type="submit" :disabled="data.processing" name="save" class="btn btn-primary"
                                    value="Cập nhập" required />

                                <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert">{{
                                    $page.props.flash.error }} </div>

                                <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert"> {{
                                    $page.props.flash.success }} </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>