<script setup>
import { ref, watch, onMounted } from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Container from '@/Components/Container.vue';
import Card from '@/Components/Card/Card.vue';
import Button from '@/Components/Button.vue';
import Table from '@/Components/Table/Table.vue';
import Td from "@/Components/Table/Td.vue";
import Actions from "@/Components/Table/Actions.vue";
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import Filters from './Filters.vue';

import useDeleteItem from "@/Composables/useDeleteItem.js";
import useFilters from "@/Composables/useFilters.js";

const props = defineProps({
    items: {
        type: Object,
        default: () => ({})
    },
    headers: {
        type: Array,
        default: () => []
    },
    title: {
        type: String,
        default: () => ""
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    can: Array
});

const {
    showDeleteModal, deleteModel, closeModal, itemToDelete, handleDeleteItem, isDeleting,
} = useDeleteItem({
    routeResourceName: props.routeResourceName,
});
const { filters, isLoading } = useFilters({
    filters: props.filters,
    routeResourceName: props.routeResourceName
});


</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>


        <Container>
            <Filters v-model="filters" />

            <Button v-if="can.create" :href="route(`admin.${routeResourceName}.create`)">Add New</Button>
            <Card class="mt-4" :is-loading="isLoading">
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>
                            {{ item.name }}
                        </Td>
                        <Td>
                            {{ item.created_at_formatted }}
                        </Td>
                        <Td>
                            <Actions :edit-link="route(`admin.${routeResourceName}.edit`, { id: item.id })"
                                :show-edit="item.can.edit" :show-delete="item.can.delete"
                                @deleteClicked="showDeleteModal(item)" />
                        </Td>
                    </template>

                </Table>
            </Card>
        </Container>

    </AuthenticatedLayout>

    <Modal :show="deleteModel" @close="closeModal" @handle-delete-item="handleDeleteItem" :item-to-delete="itemToDelete"
        :is-deleting="isDeleting" needed-delete="Role">
    </Modal>
</template>
