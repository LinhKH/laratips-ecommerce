<template>
    <ul class="pagination">
        <span style="margin-right: 10px;">
            Showing
            <span>{{ pagination.from }}-{{ pagination.to }}</span>
            of
            <span>{{ pagination.total }}</span>
        </span>
        <template v-for="(link, key) in pagination.links" :key="link.label">
            <li v-if="link.url" class="page-item" :class="{ 'active': link.active }">
                <Link class="page-link" v-html="link.label.replace(' Previous', '').replace('Next ', '')" preserveScroll
                    :href="link.url ?? ''">
                </Link>
            </li>
            <li v-else class="page-item disabled" :class="{ 'active disabled': link.active }">
                <Link class="page-link" v-html="link.label.replace(' Previous', '').replace('Next ', '')" preserveScroll
                    :href="link.url">
                </Link>
            </li>

        </template>
    </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    pagination: Object
})
</script>

<style scoped>
.active {
    font-weight: bold;
}
</style>