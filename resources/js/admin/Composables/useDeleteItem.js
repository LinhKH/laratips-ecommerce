import { ref } from "vue";
import { router } from "@inertiajs/vue3";

export default function(params) {
    const { routeResourceName } = params;
    const deleteModel = ref(false);
    const isDeleting = ref(false);
    const itemToDelete = ref({});

    const showDeleteModal = (item) => {
        deleteModel.value = true;
        itemToDelete.value = item;
    };

    const handleDeleteItem = () => {
        router.delete(route(`admin.${routeResourceName}.destroy`, { id: itemToDelete.value.id }), {
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

    return {
        deleteModel,
        isDeleting,
        itemToDelete,
        showDeleteModal,
        handleDeleteItem,
        closeModal,
    }
}