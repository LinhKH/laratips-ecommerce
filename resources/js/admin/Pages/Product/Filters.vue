<script setup>

import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    brands: {
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

const showFilters = ref(props.show ?? false);

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
                        <label>Brands</label>
                        <section class="form-group" >
                            <select v-model="filters.brand" class="form-control">
                                <option value="">Select brand</option>
                                <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.brand_name }}</option>
                            </select>
                        </section>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" >
                        <label>Today Deals</label>
                        <section class="form-group" >
                            <select v-model="filters.today_deal" class="form-control">
                                <option value="">Select today deal</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </section>
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