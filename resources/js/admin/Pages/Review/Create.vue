<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";
import { computed, onMounted, ref } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

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
});

const form = useForm({
    id: props.item.id ?? "",
    product_name: props.item.product_name ?? "",
    name: props.item.name ?? "",
    title: props.item.title ?? "",
    desc: props.item.desc ?? "",
    rating: props.item.rating ?? "",
    status: props.item.hide_by_admin ?? "",
});


const submit = () => {
    router.post(
        route(`admin.${props.routeResourceName}.update`, {
            id: props.item.id,
        }), { ...form, _method: "PUT" }, {
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Review</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row form-group">
                                        <div class="col-md-2">Product </div>
                                        <div class="col-md-10">{{ form.product_name }}</div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">User </div>
                                        <div class="col-md-10">{{ form.name }}</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Title</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.title"
                                                    placeholder="Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Description</span>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea v-model="form.desc" class="form-control"
                                                    required>{{ form.desc }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">Rating </div>
                                        <div class="col-md-10">{{ form.rating }}</div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-2">Status </div>
                                        <div class="col-md-10">
                                            <select v-model="form.status" class="form-control">
                                                <option value="1">Hide</option>
                                                <option value="0">Show</option>
                                            </select>
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>