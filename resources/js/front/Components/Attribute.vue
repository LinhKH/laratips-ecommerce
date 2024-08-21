<script setup>
import { usePage } from '@inertiajs/vue3';


const {
    attributes,
    attrvalues,
} = usePage().props;


const props = defineProps({
    product: {
        type: Object
    },
    isOrder: {
        type: Boolean,
        default: false
    }
})

const isCheckAttr = (item) => item.split(':')

const attr_values = !props.isOrder ? props.product.attrvalues?.split(",") : props.product.product_attr?.split(",");

</script>

<template>
    <template v-for='row in attributes'>
        <template v-for="item in attr_values">
            <li :key="row.id" v-if="row.id == isCheckAttr(item)[0] && isCheckAttr(item)[0]">
                <b>{{ row.title }} : </b> {{ attrvalues.find(item1 => item1.id == isCheckAttr(item)[1])['value'] ?? null }}
            </li>
        </template>
    </template>
</template>