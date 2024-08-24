<script setup>

import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/admin/Layouts/AuthenticatedLayout.vue";
import Container from "@/admin/Components/Container.vue";
import SecondaryButton from "@/admin/Components/SecondaryButton.vue";
import DangerButton from "@/admin/Components/DangerButton.vue";
import Card from "@/admin/Components/Card/Card.vue";
import Table from "@/admin/Components/Table/Table.vue";
import Td from "@/admin/Components/Table/Td.vue";
import Actions from "@/admin/Components/Table/Actions.vue";
import Button from "@/admin/Components/Button.vue";
import Modal from "@/admin/Components/Modal.vue";
import Filters from "./Filters.vue";

import useDeleteItem from "@/admin/Composables/useDeleteItem.js";
import useFilters from "@/admin/Composables/useFilters.js";



const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    items: {
        type: Object,
        default: () => ({}),
    },
    headers: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    can: Object,
    // roles: Array,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <Container>
            <Filters v-model="filters" />

            <Button v-if="can.create" :href="route(`admin.${routeResourceName}.create`)">Add New</Button>

            <Card class="mt-4" :is-loading="isLoading" no-padding>
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>
                            {{ item.name }}
                        </Td>
                        <Td>
                            {{ item.email }}
                        </Td>
                        <!-- <Td>
                            <Button v-for="role in item.roles" :key="role.id" color="blue" small class="mx-2">
                                {{ role.name }}
                            </Button>
                        </Td> -->
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
        :is-deleting="isDeleting" needed-delete="User">
    </Modal>
</template>
