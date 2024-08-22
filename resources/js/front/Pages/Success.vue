<template>
    <Head title="Payment Successful"></Head>
    <FrontLayout>
        <div class="successfull-page py-5 text-center">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Payment Successful</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item"><Link href="/">Home</Link></li>
                            <li class="breadcrumb-item active">Success</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row m-0">
                <div class="offset-md-4 col-md-4">
                    <div class="success-message">
                        <div class="icon h2">
                            <i class="fas fa-check-circle" style="color: #059473;"</i>
                        </div>
                        <h4 class="mb-2">Your Order is Confirmed!</h4>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-12">
                    <div class="booking-btn text-center">
                        <Link :href="route('my_orders')" class="btn btn-primary text-center">My Orders</Link>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';

</script>

<style lang="scss" scoped>

</style>