<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";

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
    attribute: Object,
});

const form = useForm({
    value: props.item.value ?? "",
    attribute: props.item.attribute ?? "",
});


const submit = () => {
    props.edit
        ? form.put(
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
        : form.post(route(`admin.${props.routeResourceName}.store`), {
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
            <template #add_btn>
                <Link :href="route('admin.attribute-values.index')" class="align-top btn btn-sm btn-primary">Back</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Attribute Values Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Attribute</span>
                                            </div>
                                            <div class="col-md-10">
                                                <select class="form-control" v-model="form.attribute" id="">
                                                    <option value="" disabled selected>Select Attribute</option>
                                                    <option v-for="item in attribute" :key="item.id" :value="item.id">{{item.title}}</option>
                                                </select>
                                                <div v-show="$page.props.errors.attribute">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.attribute }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Title</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.value" placeholder="Value">
                                                <div v-show="$page.props.errors.value">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.value }}
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>