<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const {
        all_category,
    } = usePage().props;

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    categories: Array,
});

const emits = defineEmits(["update:modelValue"]);

const filters = ref({ ...props.modelValue });

watch(
    filters,
    () => {
        emits("update:modelValue", filters.value);
    },
    {
        deep: true,
    }
);
</script>

<template>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body" style="display: block;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" >
                        <label>Name</label>
                        <input v-model="filters.name" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Root Category</label>
                        <select class="form-control" style="width: 100%;" v-model="filters.parentId">
                            <option value=''>Select</option>
                            <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.category_name }}</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>


<style scoped></style>