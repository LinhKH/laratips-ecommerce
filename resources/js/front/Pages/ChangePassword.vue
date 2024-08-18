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
                    <h2>Change Password</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link href="/">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">Change Password</li>
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
                                    <label>Old Password</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Old Password" v-model="data.password" />
                                    <div v-if="data.errors.password" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.password }}</div>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_pass" class="form-control" id="new-pass"
                                        placeholder="New Password" v-model="data.new_pass" />
                                    <div v-if="data.errors.new_pass" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.new_pass }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Re-enter New Password</label>
                                    <input type="password" name="re_pass" class="form-control"
                                        placeholder="Re-enter New Password" v-model="data.re_pass" />
                                    <div v-if="data.errors.re_pass" class="alert alert-danger mt-2" role="alert">{{
                                        data.errors.re_pass }}</div>
                                </div>
                                <input type="submit" :disabled="data.processing" name="save" class="btn btn-primary"
                                    value="Update" required />

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