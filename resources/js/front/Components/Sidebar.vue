<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import ChildCategory from './ChildCategory.vue';
import { ref, watch } from 'vue';

const { all_category, cat_detail, brands } = usePage().props;
const baseUrl = import.meta.env.VITE_APP_URL;

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
});

let filters = ref({ ...props.modelValue });

const handleChange = (e) => {
    if (e.target.name == "brand") {
        let { value, checked } = e.target;
        if (checked) {
            filters.value[e.target.name].push(value);
        } else {
            let index = filters.value[e.target.name].indexOf(value);
            if (index > -1) {
                filters.value[e.target.name].splice(index, 1);
            }
        }
        emits('handleSubmit');
    }
};

const emits = defineEmits(['handleSubmit','update:modelValue']);

watch(
    filters,
    () => {
        emits("update:modelValue", filters.value);
    },
    {
        deep: true,
    }
);

const handleFilter = () => {
    emits('handleSubmit');
}

</script>

<template>
    <div class="accordion" id="accordionExample1">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Product categories
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                <div class="accordion-body"
                    :style="{ border: '1px solid', boxShadow: '3px 3px #059473 , 0em 0 .4em olive' }">
                    <ChildCategory />
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                >
                    Filter By Price
                </button>
            </h2>
            <div
                id="collapseTwo"
                class="accordion-collapse collapse show"
                aria-labelledby="headingTwo"
                
            >
                <div class="accordion-body" :style="{border: '1px solid', boxShadow: '3px 3px #059473 , 0em 0 .4em olive'}">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="d-block">Min</span>
                            <input
                                type="number"
                                name="min_price"
                                min="0"
                                max="1000000"
                                class="price-range-field"
                                v-model="filters.min_price"
                            />
                        </div>
                        <div class="col-md-6">
                            <span class="d-block">Max</span>
                            <input
                                type="number"
                                name="max_price"
                                min="0"
                                max="1000000"
                                class="price-range-field"
                                v-model="filters.max_price"
                            />
                        </div>
                        <div class="col-md-12">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm mt-2"
                                @click="handleFilter"
                            >
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="brands && brands.length > 0" class="accordion-item">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="true"
                        aria-controls="collapseThree"
                    >
                        Brands
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" >
                    <div class="accordion-body" :style="{border: '1px solid', boxShadow: '3px 3px #059473 , 0em 0 .4em olive'}">
                        <div v-for="brand_item in brands" class="radio-button" :key="brand_item.id" >
                            <input
                                :id="brand_item.id"
                                type="checkbox"
                                class="brand"
                                name="brand"
                                @change="handleChange"
                                :value="brand_item.id"
                            />
                            <label
                                :for="brand_item.id"
                                class="ml-2"
                            >
                                {{ brand_item.brand_name }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>