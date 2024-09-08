<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import FrontLayout from '../Layouts/FrontLayout.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const  {
    address,
    user,
    city,
    state,
    country,
} = usePage().props;

const data = useForm({
    name: address?.name || '',
    email: address?.email || '',
    phone: address?.phone || '',
    country: address?.country.id != null ? address?.country.id : '',
    state: address?.state.id != null ? address?.state.id : '',
    city: address?.city.id != null ? address?.city.id : '',
    address: address?.address || '',
    
})

function handleSubmit(e) {

    if(address) {
        data.transform((data) => ({
            ...data,
            _method: 'PUT',
        })).post(route('address.update', address.id), {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => data.reset(),
        });
    } else {
        data.post(route('address.store'), {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => data.reset(),
        });
    }
    
}

const titleHead = computed(() => {
    return address? 'Edit Address' : 'Add Address';
});

</script>
<template>
    <FrontLayout>
        <Head :title="titleHead"></Head>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>{{ titleHead }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link :href="`${baseUrl}`">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">{{ titleHead }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <form class="row" @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Họ và tên : </label>
                            <input type="text" class="form-control" name="name" v-model="data.name" />
                            <div v-if="$page.props.errors.name" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.name }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Email : </label>
                            <input type="text" class="form-control" name="name" v-model="data.email" />
                            <div v-if="$page.props.errors.email" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.email }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Số điện thoại : </label>
                            <input type="text" class="form-control" name="phone" v-model="data.phone" />
                            <div v-if="$page.props.errors.phone" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.phone }}
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
                            <div v-if="$page.props.errors.country" class="alert alert-danger mt-2" role="alert">
                                {{ $page.props.errors.country }}</div>
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
                            <div v-if="$page.props.errors.state" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.state }}
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
                            <div v-if="$page.props.errors.city" class="alert alert-danger mt-2" role="alert">{{
                                $page.props.errors.city }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-xl-6 col-md-6">
                            <label class="col-lg-3 col-sm-5 col-form-label">Địa chỉ chi tiết :</label>
                            <input type="text" class="form-control" name="address" v-model="data.address" />
                            <div v-if="$page.props.errors.address" class="alert alert-danger mt-2" role="alert">
                                {{ $page.props.errors.address }}</div>
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