<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card/Card.vue";
import Table from "@/Components/Table/Table.vue";
import Td from "@/Components/Table/Td.vue";
import Actions from "@/Components/Table/Actions.vue";
import Button from "@/Components/Button.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import Filters from "./Filters.vue";

import AddNew from "@/Components/AddNew.vue";

import useDeleteItem from "@/Composables/useDeleteItem.js";
import useFilters from "@/Composables/useFilters.js";
import { ref } from "vue";

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
    rootCategories: Array,
});

const {
    showDeleteModal, deleteModel, closeModal, itemToDelete, handleDeleteItem, isDeleting,
} = useDeleteItem({
    routeResourceName: props.routeResourceName,
});

const { filters, isLoading } = useFilters({
    filters: props.filters,
    routeResourceName: props.routeResourceName,
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
            <AddNew>
                <Button v-if="can.create" :href="route(`admin.${routeResourceName}.create`)">Add New</Button>

                <template #filters>
                    <Filters v-model="filters" :categories="rootCategories" />
                </template>
            </AddNew>

            <Card class="mt-4" :is-loading="isLoading" no-padding>
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>
                            {{ item.name }}
                        </Td>
                        <Td>
                            <Button v-if="item.children_count > 0"
                                :href="route(`admin.${routeResourceName}.index`, { parentId: item.id })" small>
                                {{ item.children_count }}
                            </Button>
                            <span v-else>{{ item.children_count }}</span>
                        </Td>
                        <Td>
                            <Button :color="item.active ? 'green' : 'red'" small>
                                {{ item.active ? 'Active' : 'Inactive' }}
                            </Button>
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
        :is-deleting="isDeleting" needed-delete="Category">

        <!-- <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Delete Category: {{ itemToDelete.name }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Are you sure you want to delete this item?
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-3" @click="handleDeleteItem" :disabled="isDeleting">
                    <span v-if="isDeleting">Deleting</span>
                    <span v-else>Delete</span>
                </DangerButton>
            </div>
        </div> -->
    </Modal>
</template>
