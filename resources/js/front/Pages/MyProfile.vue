<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const {
    user,
    city,
    state,
    country,
    userSession,
    flash,
} = usePage().props;

const photo_or_blank_image = computed(() => {
    return user.user_img ? `${baseUrl}/users/${user.user_img}` : `${baseUrl}/public/users/default.png'`;
});

const data = useForm({
    name: user.name || '',
    img: '',
    phone: user.phone || '',
    country: user.country != null ? user.country : '',
    state: user.state != null ? user.state : '',
    city: user.city != null ? user.city : '',
    address: user.address || '',
    code: user.pin_code || '',
})

function handleSubmit(e) {
    data.post(route('my_profile.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => data.reset('img'),
    });
}

</script>
<template>
    <Head title="My Profile"></Head>
    <div id="site-content">
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>My Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link :href="`${baseUrl}`">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container-xl container-fluid">
            <form class="row" @submit.prevent="handleSubmit" method="post" style="width: '100%'">
                <Preloader v-if="data.processing" />
                <div class="col-md-3">
                    <div class="content-box">
                        <img id="image" class="mb-2 w-100"
                            :src="photo_or_blank_image"
                            :alt="`${user.user_img}`" />
                        <div>
                            <input type="file" class="form-control" name="img"
                                @input="data.img = $event.target.files[0]" width="100%" />
                            <div v-if="data.errors.user_img" class="alert alert-danger mt-2" role="alert">{{
                                data.errors.user_img }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="content-box">
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-sm-5 col-form-label">Full Name : </label>
                            <div class="col-lg-5 col-sm-7">
                                <input type="text" class="form-control" name="name" v-model="data.name"
                                    onChange={handleChange} />
                                <div v-if="data.errors.name" class="alert alert-danger mt-2" role="alert">{{
                                    data.errors.name }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone" class="col-lg-3 col-sm-5 col-form-label">Phone No :
                            </label>
                            <div class="col-lg-5 col-sm-7">
                                <input type="number" class="form-control" name="phone" v-model="data.phone" />
                                <div v-if="data.errors.phone" class="alert alert-danger mt-2" role="alert">{{
                                    data.errors.phone }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone" class="col-lg-3 col-sm-5 col-form-label">Country : </label>
                            <div class="col-lg-5 col-sm-7">
                                <select class="form-control select-country" name="country" v-model="data.country">
                                    <option value="">Select Country</option>
                                    <option v-for="country in country" :key="country.id" :value="country.id">
                                        {{ country.country_name }}
                                    </option>
                                </select>
                                <div v-if="data.errors.country" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.country }}</div>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone select-state"
                                class="col-lg-3 col-sm-5 col-form-label">Province/City :</label>
                            <div class="col-lg-5 col-sm-7">
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
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone" class="col-lg-3 col-sm-5 col-form-label">District :</label>
                            <div class="col-lg-5 col-sm-7">
                                <select class="form-control" name="city" id="city" v-model="data.city"
                                    onChange={handleChange}>
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
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone" class="col-lg-3 col-sm-5 col-form-label">Address :</label>
                            <div class="col-lg-5 col-sm-7">
                                <input type="text" class="form-control" name="address" v-model="data.address" />
                                <div v-if="data.errors.address" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.address }}</div>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label htmlFor="staticphone" class="col-lg-3 col-sm-5 col-form-label">Pin Code :</label>
                            <div class="col-lg-5 col-sm-7">
                                <input type="number" class="form-control" name="code" v-model="data.code" />
                                <div v-if="data.errors.pincode" class="alert alert-danger mt-2" role="alert">
                                    {{ data.errors.pincode }}</div>
                            </div>
                        </div>
                        <button type="submit" :disabled="data.processing" class="btn btn-primary mb-2">
                            UPDATE
                        </button>
                    </div>
                </div>

                <div v-if="$page.props.flash.error" class="alert alert-danger mt-2" role="alert">
                    {{ $page.props.flash.error }}
                </div>

                <div v-if="$page.props.flash.success" class="alert alert-success mt-2" role="alert">
                    {{ $page.props.flash.success }}
                </div>
            </form>
        </div>
    </div>
</template>