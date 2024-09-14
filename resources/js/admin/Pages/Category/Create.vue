<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { onMounted, watch } from "vue";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import InputGroup from "../../Components/InputGroup.vue";
import ChildCategory from "../../Components/ChildCategory.vue";
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
    attributes: {
        type: Array,
        default: () => ({}),
    },
    category: {
        type: Object,
        required: true,
    },
    breadcrumb: Object,
});
const form = useForm({
    name: props.item.category_name ?? "",
    active: props.item.active ?? true,
    parent: props.item.parent_category ?? 0,
    status: props.item.status == 0 ? false : true,
    meta_title: props.item.meta_title ?? "",
    meta_desc: props.item.meta_desc ?? "",
    // cat_attributes: props.item.filter_attr ?? [],
});

// onMounted(() => {
//     jQuery(".select2").select2({
//     }).on('select2:change', (e) => {
//         this.form.cat_attributes = e.params.data.id;
//     });
// });

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
                <Link :href="route('admin.category.index')" class="align-top btn btn-sm btn-primary">Quay lại</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <!-- form start -->
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Chi tiết danh mục</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Tên danh mục</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.name" name="name" placeholder="Tên">
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
                                                <span>Danh mục cha (chọn No parent nếu muốn nó là danh mục cha)</span>
                                            </div>
                                            <div class="col-md-10">
                                                <select name="parent" v-model="form.parent" class="form-control">
                                                    <option value="0" selected>No Parent</option>
                                                        <template v-for="list in category" :key="list.id">
                                                            <option :value="list.id">{{list.category_name}}</option>
                                                            <template v-for="childCategory in list.children_categories" key="child_category.id" >
                                                                <ChildCategory :child_category="childCategory" />
                                                            </template>
                                                        </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Tiêu đề Meta</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.meta_title" name="meta_title" placeholder="Tiêu đề Meta">
                                                <div v-show="$page.props.errors.meta_title">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.meta_title }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Chi tiết Meta</span>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control" v-model="form.meta_desc" name="meta_desc" placeholder="Chi tiết Meta" id="" cols="30" rows="2"></textarea>
                                                <div v-show="$page.props.errors.meta_desc">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.meta_desc }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Thuộc thương hiệu</span>
                                            </div>
                                            <div class="col-md-10">
                                                <VueMultiselect
                                                    v-model="form.cat_attributes"
                                                    :options="attributes"
                                                    :multiple="true"
                                                    :close-on-select="true"
                                                    placeholder="Chọn 1 hoặc nhiều"
                                                    label="title"
                                                    track-by="id"
                                                />
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                
                                            </div>
                                            <div class="col-md-10">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="status" v-model="form.status">
                                                    <label for="status" class="custom-control-label">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
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