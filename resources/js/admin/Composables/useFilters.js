import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import pickBy from "lodash/pickBy";

export default function useFilters(params) {
    const { filters: defaultFilters, routeResourceName } = params;

    const filters = ref(defaultFilters);

    const isFilled = computed(() => {

        return Object.values(filters.value).some(
            (v) => !["", null, undefined].includes(v)
        );
    });


    const fetchItemsHandler = ref(null);
    const isLoading = ref(false);
    const fetchItems = () => {
        router.get(
            route(`admin.${routeResourceName}.index`),
            pickBy(filters.value),
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                onBefore: () => (isLoading.value = true),
                onFinish: () => (isLoading.value = false),
            }
        );
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
        isLoading,
        fetchItems,
        isFilled
    };
}
