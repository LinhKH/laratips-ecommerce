<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import { onMounted, watch } from "vue";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
});
const form = useForm({
    instagram: props.data.instagram ?? "",
    twitter: props.data.twitter ?? "",
    facebook: props.data.facebook ?? "",
    zalo: props.data.zalo ?? "",
    tiktok: props.data.tiktok ?? "",
});


const submit = () => {
    form.post(route(`admin.${props.routeResourceName}.index`), {
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
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Social Links Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <input type="url" class="form-control" name="instagram" placeholder="Enter Instagram Url" v-model="form.instagram">
                                        <small>Để trống nếu không muốn hiện trên trang web của bạn</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter</label>
                                        <input type="url" class="form-control" name="twitter" placeholder="Enter Twitter Url" v-model="form.twitter">
                                        <small>Để trống nếu không muốn hiện trên trang web của bạn</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="url" class="form-control" name="facebook" placeholder="Enter Facebook Url" v-model="form.facebook">
                                        <small>Để trống nếu không muốn hiện trên trang web của bạn</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Zalo</label>
                                        <input type="url" class="form-control" name="zalo" placeholder="Enter Zalo Url" v-model="form.zalo">
                                        <small>Để trống nếu không muốn hiện trên trang web của bạn</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Tiktok</label>
                                        <input type="url" class="form-control" name="tiktok" placeholder="Enter Tiktok Url" v-model="form.tiktok">
                                        <small>Để trống nếu không muốn hiện trên trang web của bạn</small>
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