import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import pickBy from "lodash/pickBy";

export default function useFilters(params) {
    const { filters: defaultFilters, routeResourceName } = params;

    const filters = ref(defaultFilters);

    const isFilled = computed(() => {
        let { page, ...rest } = filters.value;
        return Object.values(rest).some(
            (v) => !["", null, undefined].includes(v)
        );
    });

    const fetchItemsHandler = ref(null);
    const isLoading = ref(false);

    const fetchItems = () => {
        router.get(
            route(`admin.${routeResourceName}.index`),
            pickBy({
                ...filters.value,
                page: 1,
            }),
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
        isFilled,
    };
}
