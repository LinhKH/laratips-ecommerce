<template>
    <div class="row">
        <div class="col-12 mb-5 mt-5">
            <ul class="pagination align-items-center float-right">
                <span style="margin-right: 10px;">
                    Đang hiển thị
                    <b>{{ pagination.from }}-{{ pagination.to }}</b>
                    của
                    <b>{{ pagination.total }}</b>
                </span>
                <template v-for="(link, key) in pagination.links" :key="link.label">
                    <li v-if="link.url" class="page-item" :class="{ 'active': link.active }">
                        <Link class="page-link" v-html="link.label.replace(' Previous', '').replace('Next ', '')" preserveScroll
                            :href="link.url ?? ''">
                        </Link>
                    </li>
                    <li v-else class="page-item disabled" :class="{ 'active disabled': link.active }">
                        <Link class="page-link" v-html="link.label.replace(' Previous', '').replace('Next ', '')" preserveScroll
                            :href="link.url ?? ''">
                        </Link>
                    </li>
        
                </template>
            </ul>
        </div>
    </div>
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