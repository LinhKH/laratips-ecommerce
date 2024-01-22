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
import ModalCommon from "@/Components/ModalCommon.vue";
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';


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
});

onMounted(() => {
    filters.value = props.filters
});

const deleteModel = ref(false);
const isDeleting = ref(false);
const itemToDelete = ref({});

const showDeleteModal = (item) => {
    deleteModel.value = true;
    itemToDelete.value = item;
};

const handleDeleteItem = () => {
    router.delete(route('admin.roles.destroy', { id: itemToDelete.value.id }), {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => {
            isDeleting.value = true;
        },
        onSuccess: () => {
            deleteModel.value = false;
            itemToDelete.value = {};
            closeModal();
        },
        onFinish: () => {
            isDeleting.value = false;
        },
    });
};

const closeModal = () => {
    deleteModel.value = false;

};

const filters = ref({
    name: ""
});

const fetchItemsHandler = ref(null);
const fetchItems = () => {
    router.get(route('admin.roles.index'), filters.value, 
    {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
};

watch(filters, () => {
    clearTimeout(fetchItemsHandler.value);
    fetchItemsHandler.value = setTimeout(() => {
        fetchItems();
    }, 300)
},{
    deep: true
})

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>


        <Container>
            <Card class="mb-4">
                <template #header>
                    Filters
                </template>
                <form class="grid grid-cols-4 gap-8">
                    <div>
                        <InputLabel value="Name" />

                        <TextInput type="text" class="mt-1 block w-full" v-model="filters.name" />
                    </div>
                </form>
            </Card>

            <Button :href="route(`admin.roles.create`)">Add New</Button>
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
                            <Actions :edit-link="route(`admin.roles.edit`, { id: item.id })"
                                @deleteClicked="showDeleteModal(item)" />
                        </Td>
                    </template>

                </Table>
            </Card>
        </Container>

    </AuthenticatedLayout>

    <!-- <ModalCommon v-model="deleteModal" :title="`Delete ${itemToDelete.name}`">
        Are you sure you want to delete this item?

        <template #footer>
            <Button @click="handleDeleteItem" :disabled="isDeleting">
                <span v-if="isDeleting">Deleting</span>
                <span v-else>Delete</span>
            </Button>
        </template>
    </ModalCommon> -->

    <Modal :show="deleteModel" @close="closeModal">
        
        <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Delete {{ itemToDelete.name }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Are you sure you want to delete this item?
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton class="ms-3" @click="handleDeleteItem"
                            :disabled="isDeleting">
                        <span v-if="isDeleting">Deleting</span>
                        <span v-else>Delete</span>
                    </DangerButton>
                </div>
            </div>
    </Modal>

</template>
