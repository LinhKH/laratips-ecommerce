<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Container from '@/Components/Container.vue';
import Card from '@/Components/Card/Card.vue';
import Table from '@/Components/Table/Table.vue';
import Td from "@/Components/Table/Td.vue";
import Actions from "@/Components/Table/Actions.vue";


defineProps({
    items: {
        type: Object,
        default: () => ({})
    },
    headers: {
        type: Array,
        default: () => []
    }
});

</script>

<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
        </template>


        <Container>
            <Card class="mt-4">
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>
                            {{ item.name }}
                        </Td>
                        <Td>
                            {{ item.created_at_formatted }}
                        </Td>
                        <Td>
                            <Actions />
                        </Td>
                    </template>
                   
                </Table>
            </Card>
        </Container>

    </AuthenticatedLayout>
</template>
