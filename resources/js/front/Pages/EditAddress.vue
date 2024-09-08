<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import FrontLayout from '../Layouts/FrontLayout.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const {
    address,
    user,
    city,
    state,
    country,
} = usePage().props;

const data = useForm({
    name: address.name || '',
    email: address.email || '',
    img: '',
    phone: address.phone || '',
    country: address.country.id != null ? address.country.id : '',
    state: address.state.id != null ? address.state.id : '',
    city: address.city.id != null ? address.city.id : '',
    address: address.address || '',
    _method: 'PUT',
})

function handleSubmit(e) {
    data.post(route('address.update', address.id), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => data.reset(),
    });
}

</script>
<template>
    <FrontLayout>
        <Head title="Edit Address"></Head>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Edit Address</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link :href="`${baseUrl}`">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">Edit Address</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <form class="row" @submit.prevent="handleSubmit" method="post">
                    <div class="row">
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Họ và tên : </label>
                            <input type="text" class="form-control" name="name" v-model="data.name" />
                            <div v-if="data.errors.name" class="alert alert-danger mt-2" role="alert">{{
                                data.errors.name }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Email : </label>
                            <input type="text" class="form-control" name="name" v-model="data.email" />
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Số điện thoại : </label>
                            <input type="text" class="form-control" name="phone" v-model="data.phone" />
                            <div v-if="data.errors.phone" class="alert alert-danger mt-2" role="alert">{{
                                data.errors.phone }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Quốc gia : </label>
                            <select class="form-control select-country" name="country" v-model="data.country">
                                <option value="">Select Country</option>
                                <option v-for="country in country" :key="country.id" :value="country.id">
                                    {{ country.country_name }}
                                </option>
                            </select>
                            <div v-if="data.errors.country" class="alert alert-danger mt-2" role="alert">
                                {{ data.errors.country }}</div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Tỉnh/Thành phố : </label>
                            <select class="form-control" name="state" id="state" v-model="data.state">
                                <option value="">First Select Country</option>
                                <template v-for="state in state" :key="state.id">
                                    <option v-if="state.country == data.country" :value="state.id">
                                        {{ state.state_name }}
                                    </option>
                                </template>
                            </select>
                            <div v-if="data.errors.state" class="alert alert-danger mt-2" role="alert">{{
                                data.errors.state }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Quận/Huyện : </label>
                            <select class="form-control" name="city" id="city" v-model="data.city">
                                <option value="">First Select State</option>
                                <template v-for="city in city" key="city.id">
                                    <option v-if="city.state == data.state" :value="city.id">
                                        {{ city.city_name }}
                                    </option>
                                </template>
                            </select>
                            <div v-if="data.errors.city" class="alert alert-danger mt-2" role="alert">{{
                                data.errors.city }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Địa chỉ chi tiết :</label>
                            <input type="text" class="form-control" name="address" v-model="data.address" />
                            <div v-if="data.errors.address" class="alert alert-danger mt-2" role="alert">
                                {{ data.errors.address }}</div>
                        </div>
                    </div>
                    <button type="submit" :disabled="data.processing" class="btn btn-primary mb-2">
                        UPDATE
                    </button>
                </form>
            </div>
        </div>
    </FrontLayout>
</template>