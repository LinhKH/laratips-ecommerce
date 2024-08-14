<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { watch } from "vue";

import kebabCase from "lodash/kebabCase";
import replace from "lodash/replace";

import AuthenticatedLayout from "@/admin/Layouts/AuthenticatedLayout.vue";
import Container from "@/admin/Components/Container.vue";
import Card from "@/admin/Components/Card/Card.vue";
import Button from "@/admin/Components/Button.vue";
import InputGroup from "@/admin/Components/InputGroup.vue";
import SelectGroup from "@/admin/Components/SelectGroup.vue";
import CheckboxGroup from "@/admin/Components/CheckboxGroup.vue";

const props = defineProps({
    edit: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
    },
    item: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    rootCategories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.item.name ?? "",
    slug: props.item.slug ?? "",
    active: props.item.active ?? true,
    parentId: props.item.parent_id ?? "",
});


const submit = () => {
    props.edit
        ? form.put(
            route(`admin.${props.routeResourceName}.update`, {
                id: props.item.id,
            })
        )
        : form.post(route(`admin.${props.routeResourceName}.store`));
};
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>

        <Container>
            <Card>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-6">
                        <InputGroup label="Name" v-model="form.name" :error-message="form.errors.name" />

                        <!-- <InputGroup label="Slug" v-model="form.slug" :error-message="form.errors.slug" /> -->

                        <SelectGroup label="Parent Category" v-model="form.parentId" :items="rootCategories"
                            :error-message="form.errors.parentId" />

                        <div class="mt-6">
                            <CheckboxGroup label="Active" v-model:checked="form.active" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <Button :disabled="form.processing">
                            {{ form.processing ? 'Saving...' : 'Save' }}
                        </Button>
                    </div>
                </form>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
