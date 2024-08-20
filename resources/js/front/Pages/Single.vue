
<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import FrontLayout from '../Layouts/FrontLayout.vue';

    const { page } = usePage().props;
    
</script>
<template>
    <Head :title="page.page_title"</Head>
    <FrontLayout>
        <div id="banner" class="d-flex flex-row justify-content-center">
            <div class="align-self-center">
                <h2>{{ page.page_title }}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center p-0">
                        <li class="breadcrumb-item">
                            <Link href="/">Home</Link>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ page.page_title }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="product-box">
            <div class="message"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div v-html="page.description"></div>
                    </div>
                </div>
            </div>
        </div>

    </FrontLayout>
</template>


<style  scoped>

</style>