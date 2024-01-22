<template>
    <div class="flex items-center space-x-2">
        <button v-if="showEdit">
            <Link :href="editLink">
            <Edit />
            </Link>
        </button>
        <button v-if="showDelete" @click="$emit('deleteClicked', $event)">
            <Trash />
        </button>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import Edit from '../Icons/Edit.vue';
import Trash from '../Icons/Trash.vue';


defineProps({
    editLink: {
        type: String,
        default: () => ""
    },
    showEdit: {
        type: Boolean,
        default: () => true
    },
    showDelete: {
        type: Boolean,
        default: () => true
    },
})
</script>
