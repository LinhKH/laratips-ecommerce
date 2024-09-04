<script setup>
import { Head, useForm, Link, router } from "@inertiajs/vue3";
import { onMounted, reactive, ref, watch } from "vue";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
});
const form = useForm('detail', {
    name: props.data.name ?? "",
    email: props.data.email ?? "",
    phone: props.data.phone ?? "",
});

const passData = reactive({
    password: "",
    new_pass: "",
    re_pass: "",
});

const submit = () => {
    form.post(route(`admin.profile_settings.index`), {
        onSuccess: page => {
            Swal.fire({
                toast: true,
                icon: 'success',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                title: page.props.flash.success
            });
        },
    });
};
const submitPass = () => {
    console.log('loading')
    router.post(route(`admin.profile_settings.change_password`), passData, {
        onSuccess: page => {
            Swal.fire({
                toast: true,
                icon: 'success',
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                title: page.props.flash.success
            })
        },
    });
};

</script>

<template>

    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" name="form1" @submit.prevent="submit" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Profile Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Admin Name</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="name" v-model="form.name"
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Admin Email</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="email" class="form-control" name="email"
                                                    v-model="form.email" placeholder="Enter Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Admin Phone</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" class="form-control" name="username"
                                                    v-model.number="form.phone" placeholder="Enter Phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary bg-primary" value="Update">
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" name="form2" @submit.prevent="submitPass" method="POST">
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Change Password</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Current Password</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" v-model="passData.password"
                                                    placeholder="Current Password">
                                                <div v-show="$page.props.errors.password">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.password }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>New Password</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" v-model="passData.new_pass"
                                                    placeholder="Enter New Password">
                                                <div v-show="$page.props.errors.new_pass">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.new_pass }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Re-enter New Password</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="password" class="form-control" v-model="passData.re_pass"
                                                    placeholder="Re-enter New Password">
                                                <div v-show="$page.props.errors.re_pass">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.re_pass }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary bg-primary" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </BackendLayout>
</template>