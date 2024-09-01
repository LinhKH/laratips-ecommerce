<script setup>

import { Head, Link, router, usePage } from '@inertiajs/vue3';
import BackendLayout from '@/admin/Layouts/BackendLayout.vue';
import BreadCrumb from '../../Components/BreadCrumb.vue';
import { computed, reactive, ref } from 'vue';

const { generalSettings, sitePages, all_category } = usePage().props;

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    title: String,
    breadcrumb: Object,
});

const isLoading = ref(false);

const handleBlock = (item => {
    
    router.post(route('admin.users.block'), {
        uId: item.user_id,
        status: item.status == '1' ? '0' : '1',
    }, {
        onBefore: (visit) => {isLoading.value = true},
        onFinish: visit => {isLoading.value = false},
    })
})


</script>

<template>
    <Head :title="title" />

    <BackendLayout>
            
            <BreadCrumb :breadcrumb='breadcrumb' :title="`All Users`" :active='`All Users`' >
                <template #add_btn>
                    <Link :href="route('admin.users.create')" class="align-top btn btn-sm btn-primary">Thêm Mới</Link>
                </template>
            </BreadCrumb>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Quốc Gia</th>
                                <th>Thành Phố</th>
                                <th>Quận</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.user_id">
                                <td>{{ row.user_id }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.email }}</td>
                                <td>{{ row.phone }}</td>
                                <td>{{ row.country_name }}</td>
                                <td>{{ row.state_name }}</td>
                                <td>{{ row.city_name }}</td>
                                <td>
                                    <button :disabled="isLoading" v-if="row.status == '1'" class="btn btn-warning btn-sm" @click="handleBlock(row)">Block</button>
                                    <button :disabled="isLoading" v-else class="btn btn-success btn-sm" @click="handleBlock(row)">Unblock</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Quốc Gia</th>
                                <th>Thành Phố</th>
                                <th>Quận</th>
                                <th>Chức năng</th>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!-- /.card-body -->
            </div> 

    </BackendLayout>

    
</template>
