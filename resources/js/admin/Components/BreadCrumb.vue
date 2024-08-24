
<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    breadcrumb: Object,
    title: {
        type: String,
        default: '',
    },
    active: {
        type: String,
        default: '',
    },
});
    
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 mr-2 text-dark d-inline-block">{{ title }}</h1>
                    <slot name="add_btn"></slot>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li v-for="(value, key) in breadcrumb" class="breadcrumb-item">
                            <Link :href="route(value)">{{key}}</Link>
                        </li>
                        <li class="breadcrumb-item active">{{ active }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>