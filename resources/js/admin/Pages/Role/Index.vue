<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Container from '@/Components/Container.vue';
import Card from '@/Components/Card/Card.vue';

</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
        </template>


        <Container>
            <Card class="mt-4">
                Roles
            </Card>
        </Container>

    </AuthenticatedLayout>
</template>
