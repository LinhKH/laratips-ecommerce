<template>
    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
    <div class="flex flex-col overflow-x-auto">
        <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <Th v-for="header in headers" :key="header.label" :class="`${header.classes} font-bold`">
                                    {{ header.label }}
                                </Th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b" v-for="item in items.data" :key="item.id">
                                <slot :item="item"></slot>
                            </tr>
                            <tr v-if="items.data.length === 0">
                                <Td :colspan="headers.length">
                                    No data available.
                                </Td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div v-if="items.meta.links.length > 3" class="py-4">
        <Pagination :links="items.meta.links" />
    </div>
</template>

<script setup>
import Th from '@/Components/Table/Th.vue';
import Td from '@/Components/Table/Td.vue';
import Pagination from "@/Components/Table/Pagination.vue";

defineProps({
    headers: {
        type: Array,
        default: () => []
    },
    items: {
        type: Object,
        default: () => ({}),
    },
});

</script>