<script setup>
import { Head ,usePage, Link, router } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';
import { computed } from 'vue';

const baseUrl = import.meta.env.VITE_APP_URL;

// const {
//     addresses,
// } = usePage().props;

const addresses = computed(() => usePage().props.addresses);

const deleteAddress = (id) => {
    router.post(route('address.destroy', id), {_method: 'delete'})
}

</script>
<template>
    <FrontLayout>
        <Head title="My Address"></Head>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Địa chỉ</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link :href="`${baseUrl}`">Trang chủ</Link>
                            </li>
                            <li class="breadcrumb-item active">Địa chỉ</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <div>
                    <Link :href="route('address.create')" class="btn btn-primary mb-3">Tạo địa chỉ mới</Link>
                </div>
                <div class="row">
                    <div class="col-xl-3 mt-3" v-for="(address, index) in addresses">
                        <div class="wsus__dash_add_single">
                            <h4>Địa chỉ vận chuyển {{ index + 1 }}</h4>
                            <ul>
                                <li><strong>Tên :</strong> {{address.name}}</li>
                                <li><strong>SĐT :</strong> {{address.phone}}</li>
                                <li><strong>Email :</strong> {{address.email}}</li>
                                <li><strong>Quốc gia :</strong> {{address.country.country_name}}</li>
                                <li><strong>Tỉnh/thành phố :</strong> {{address.state.state_name}}</li>
                                <li><strong>Quận/huyện :</strong> {{address.city.city_name}}</li>
                                <li><strong>Số nhà/tên đường :</strong> {{address.address}}</li>
                            </ul>
                            <div class="wsus__address_btn pr-5">
                                <Link :href="route('address.edit', address.id)" class="edit pr-5"><i class="fa fa-edit"></i> Sửa</Link>
                                <a href="javascript:;" @click="deleteAddress(address.id)" class="del delete-item"><i class="fa fa-trash-alt"></i> Xóa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>