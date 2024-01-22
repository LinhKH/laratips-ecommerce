import { ref, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

export default function useFilters(params) {
    const { filters: defaultFilters, routeResourceName } = params;

    const filters = ref(defaultFilters);

    const fetchItemsHandler = ref(null);
    const fetchItems = () => {
        router.get(route("admin.roles.index"), filters.value, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    };

    watch(
        filters,
        () => {
            clearTimeout(fetchItemsHandler.value);
            fetchItemsHandler.value = setTimeout(() => {
                fetchItems();
            }, 300);
        },
        {
            deep: true,
        }
    );

    return {
        filters,
        fetchItems,
    };
}
