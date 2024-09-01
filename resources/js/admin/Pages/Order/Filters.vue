<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from 'vue';

import ChildHeader from "@/front/Components/ChildHeader.vue";

const {
        all_category,
    } = usePage().props;

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    show: {
        type: Boolean,
        default: false,
    }
});

const emits = defineEmits(["update:modelValue"]);

const filters = ref({ ...props.modelValue });
filters.category = 'all';
const showFilters = ref(props.show ?? false);

watch(
    filters,
    () => {
        emits("update:modelValue", filters.value);
    },
    {
        deep: true
    }
);
</script>

<template>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" @click="showFilters = !showFilters">
                    <i class="fas fa-minus" :class="{'fa-minus': showFilters, 'fa-plus' : !showFilters}"></i>
                </button>
            </div>
        </div>

        <div class="card-body" :style="{'display': showFilters ? 'block' : 'none'}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group" >
                        <label>Name</label>
                        <input v-model="filters.name" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" >
                        
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn bg-danger" @click="filters = {}" >Clear Filter</button>
            </div>

        </div>

    </div>
</template>

<style scoped></style>