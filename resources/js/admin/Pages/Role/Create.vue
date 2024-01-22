<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Container from '@/Components/Container.vue';
import Card from '@/Components/Card/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/Button.vue';
import Permissions from './Permissions.vue';

const props = defineProps({
    edit: {
        type: Boolean,
        default: () => false
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
    permissions: {
        type: Array,
        default: () => []
    },
});

const { routeResourceName } = props;

const form = useForm({
    name: props.item?.name ?? "",
});

const submit = () => {
    props.edit
        ? form.put(route(`admin.${routeResourceName}.update`, { id: props.item.id }))
        : form.post(route(`admin.${routeResourceName}.store`));
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
                    <div>
                        <InputLabel value="Name" />

                        <TextInput type="text" class="mt-1 block w-full" v-model="form.name" />

                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <Button :disabled="form.processing">
                            {{ form.processing ? 'Saving...' : 'Save' }}
                        </Button>
                    </div>
                </form>
            </Card>
        </Container>
        <Permissions v-if="edit"
                     class="mt-6"
                     :role="item"
                     :permissions="permissions" />
    </AuthenticatedLayout>
</template>