<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import { onMounted, watch, computed, ref } from "vue";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
const baseUrl = import.meta.env.VITE_APP_URL;

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
});
const form = useForm({
    site_logo: null,
    old_logo: props.data.site_logo ?? "",
    site_name: props.data.site_name ?? "",
    site_title: props.data.site_title ?? "",
    theme_color: props.data.theme_color ?? "",
    copyright: props.data.copyright ?? "",
    currency: props.data.currency ?? "",
    phone: props.data.phone ?? "",
    email: props.data.email ?? "",
    address: props.data.address ?? "",
    description: props.data.description ?? "",
});


const submit = () => {
    form.post(route(`admin.general_settings.index`), {
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
let url = ref(`${baseUrl}/site/default.png`);
const previewImage = (e) => {
    const file = e.target.files[0];
    url.value = URL.createObjectURL(file);
}

const photo_or_blank_image = computed(() => {
    return props.data.site_logo ? `${baseUrl}/site/${props.data.site_logo}` : url.value;
});


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
                                    <h3 class="card-title">General Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Site Logo</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="hidden" class="custom-file-input" name="old_logo" :value="form.old_logo" />
                                                        <input type="file" class="form-control" @input="form.site_logo = $event.target.files[0]" name="site_logo" @change="previewImage">
                                                    </div>
                                                    <div class="col-md-2">

                                                        <img v-if="form.site_logo && url" id="image" :src="url" alt="" width="150px">
                                                        <img v-else id="image" :src="photo_or_blank_image" alt="" width="150px">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Site Name</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="site_name" v-model="form.site_name"  placeholder="Enter Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Site Title</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="site_title" v-model="form.site_title"  placeholder="Enter Title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Theme Color</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="color" class="form-control" name="theme_color" v-model="form.theme_color">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Site Copyright</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="copyright" v-model="form.copyright">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Currency Format</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="currency" v-model="form.currency">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Description</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control" name="description" v-model="form.description" cols="30" rows="2">{{form.description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Contact Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Phone</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="number" class="form-control" name="phone" v-model="form.phone">
                                                        <small>(If you want to hide this on frontend leave empty)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Email</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="email" class="form-control" name="email" v-model="form.email">
                                                        <small>(If you want to hide this on frontend leave empty)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <span>Address</span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="address" v-model="form.address">
                                                        <small>(If you want to hide this on frontend leave empty)</small>
                                                    </div>
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