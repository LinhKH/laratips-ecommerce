<script setup>
import { usePage } from '@inertiajs/vue3';


const {
    attributes,
    attrvalues,
} = usePage().props;


const props = defineProps({
    product: {
        type: Object
    }
})

const values = props.product.attrvalues.split(",");

</script>

<template>
    <ul>
        <template v-for='row in attributes'>
            <template v-for="item in values">
                <li :key="row.id" v-if="row.id == item.split(':')[0] && item.split(':')[0]">
                    <b>{{ row.title }} : </b> {{ attrvalues.find(item1 => item1.id == item.split(':')[1])['value'] ?? null }}
                </li>
            </template>
        </template>

    </ul>

</template>