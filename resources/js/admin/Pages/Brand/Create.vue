<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
const baseUrl = import.meta.env.VITE_APP_URL;
import Treeselect from 'vue3-treeselect'
import 'vue3-treeselect/dist/vue3-treeselect.css'

const { category } = usePage().props;

const props = defineProps({
    edit: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
    },
    item: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    breadcrumb: Object,
    category: Object,
});
const form = useForm({
    name: props.item.brand_name ?? "",
    brand_img: null,
    old_img: props.item.brand_img ?? "",
    brand_cat: props.item.brand_subcat?.split(",") ?? "",
});

const photo_or_blank_image = computed(() => {
    return props.item.brand_img ? `${baseUrl}/brand/${props.item.brand_img}` : `${baseUrl}/brand/default.png`;
});

const submit = () => {
    props.edit
        ? form.transform((data) => ({
            ...data,
            brand_cat: treeSelect,
        })).put(
            route(`admin.${props.routeResourceName}.update`, {
                id: props.item.id,
            }), {
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
            }
        )
        : form.transform((data) => ({
            ...data,
            brand_cat: treeSelect,
        })).post(route(`admin.${props.routeResourceName}.store`), {
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

// define options
let treeSelect = props.item.brand_subcat?.split(",").map(item => parseInt(item)) ?? null;

</script>

<template>
    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
            <template #add_btn>
                <Link :href="route('admin.brand.index')" class="align-top btn btn-sm btn-primary">Back</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Brand Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Tên</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.name" placeholder="Tên">
                                                <div v-show="$page.props.errors.name">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Logo</span>
                                            </div>
                                            <div class="custom-file col-md-7">
                                                <input type="hidden" class="custom-file-input" v-model="form.old_img" />
                                                <input type="file" class="custom-file-input" @input="form.brand_img = $event.target.files[0]" name="brand_img">
                                                <div v-show="$page.props.errors.brand_img">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.brand_img }}
                                                    </p>
                                                </div>
                                                <label class="custom-file-label">Chọn hình ảnh</label>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <img id="image" :src="photo_or_blank_image" alt="" width="150px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Thuộc danh mục</span>
                                            </div>
                                            <div class="col-md-10">
                                                <treeselect v-model="treeSelect" :multiple="true" :options="category" :flat="false"/>
                                                <div v-show="$page.props.errors.brand_cat">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.brand_cat }}
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
                            <input type="submit" class="btn btn-primary bg-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </BackendLayout>
</template>