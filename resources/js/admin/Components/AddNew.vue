<script setup>
import { ref, defineProps } from 'vue';
import Button from "@/Components/Button.vue";
import FilterIcon from "@/Components/Icons/FilterIcon.vue";
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    }
})
const showFilters = ref(props.show ?? false);
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <slot></slot>
            <Button color="white" @click="showFilters = !showFilters">
                <FilterIcon class="w-4 h-4" />
            </Button>

        </div>
        <div class="mt-4" v-if="showFilters">
            <slot name="filters" />
        </div>

    </div>
</template>