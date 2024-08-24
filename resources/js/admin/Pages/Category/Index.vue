<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import { computed, reactive, ref } from 'vue';
import Paginate from '@/admin/Components/Paginate.vue';
import Filters from './Filters.vue';

const { generalSettings, sitePages, all_category } = usePage().props;

import useFilters from "@/admin/Composables/useFilters.js";

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
    rootCategories: Array,
});
const { filters, isLoading, isFilled } = useFilters({
    filters: props.filters,
    routeResourceName: props.routeResourceName,
});
</script>

<template>

    <Head :title="title" />

    <BackendLayout>
        <div class="content-wrapper">

            <BreadCrumb :breadcrumb='breadcrumb' :title="`All Category`" :active='`All Category`'>
                <template #add_btn>
                    <Link :href="route('admin.category.create')" class="align-top btn btn-sm btn-primary">Add New</Link>
                </template>
            </BreadCrumb>
            <section class="content">
                <div class="container-fluid">
                    <Filters v-model="filters" :categories="rootCategories" />
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Name</th>
                                        <th>Parent Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in data.data" :key="row.user_id">
                                        <td>{{ row.id }}</td>
                                        <td>
                                            <Link v-if="row?.children_categories.length > 0"
                                                :href="route(`admin.${routeResourceName}.index`, { parentId: row.id })">
                                                {{ row.category_name }}({{ row.children_categories.length }})
                                            </Link>
                                            <span v-else>{{ row.category_name }}({{ row?.children_categories.length }})</span>
                                        </td>
                                        <td>{{ row.parent_name }}</td>
                                        <td>
                                            <span v-if="row.status == '1'" class="badge badge-success">Active</span>
                                            <span v-else class="badge badge-danger">Inactive</span>
                                        </td>
                                        <td>
                                            <Link :href="route('admin.category.edit', row.id)" class="btn btn-success btn-sm">
                                            Edit</Link>
                                            <Link :href="route('admin.category.destroy', row.id)" class="btn btn-danger btn-sm">
                                            Delete
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S No</th>
                                        <th>Name</th>
                                        <th>Parent Category</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
        
                            <Paginate v-if="data.from != data.last_page" :pagination="data"></Paginate>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </section>

        </div>
    </BackendLayout>


</template>
