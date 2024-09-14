<script setup>

import { ref, watch } from 'vue';

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
            <h3 class="card-title">Lọc</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" @click="showFilters = !showFilters">
                    <i class="fas fa-minus" :class="{'fa-minus': showFilters, 'fa-plus' : !showFilters}"></i>
                </button>
            </div>
        </div>

        <div class="card-body" :style="{'display': showFilters ? 'block' : 'none'}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" >
                        <label>Tên</label>
                        <input v-model="filters.name" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn bg-danger" @click="filters = {}" >Xóa lọc</button>
            </div>
        </div>


    </div>
</template>


<style scoped></style>