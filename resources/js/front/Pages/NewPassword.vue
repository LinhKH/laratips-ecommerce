<script setup>
import { Head } from '@inertiajs/vue3';

</script>

<template>

    <Head title="Password Reset Successfully" />
    <div class="successfull-page text-center my-4">
        <div class="row m-0">
            <div class="offset-md-2 col-md-8">
                <div class="alert alert-success" role="alert">
                    Your password has been changed! Login with new password
                </div>
            </div>
            <div class="col-md-12">
                <a :href="route('user_login')" class="btn btn-primary text-center">Login</a>
            </div>
        </div>
    </div>
</template>
