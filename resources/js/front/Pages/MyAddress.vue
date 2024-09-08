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
                    <h2>My Address</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link :href="`${baseUrl}`">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">My Address</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <div class="row">
                    <div class="col-xl-3" v-for="(address, index) in addresses">
                        <div class="wsus__dash_add_single">
                            <h4>Billing Address {{ index + 1 }}</h4>
                            <ul>
                                <li><strong>Name :</strong> {{address.name}}</li>
                                <li><strong>Phone :</strong> {{address.phone}}</li>
                                <li><strong>Email :</strong> {{address.email}}</li>
                                <li><strong>Country :</strong> {{address.country.country_name}}</li>
                                <li><strong>State :</strong> {{address.state.state_name}}</li>
                                <li><strong>City :</strong> {{address.city.city_name}}</li>
                                <li><strong>Address Detail :</strong> {{address.address}}</li>
                            </ul>
                            <div class="wsus__address_btn pr-5">
                                <Link :href="route('address.edit', address.id)" class="edit pr-5"><i class="fa fa-edit"></i> edit</Link>
                                <a href="javascript:;" @click="deleteAddress(address.id)" class="del delete-item"><i class="fa fa-trash-alt"></i> delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>