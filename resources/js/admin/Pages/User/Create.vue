<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card/Card.vue";
import Button from "@/Components/Button.vue";
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';


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
    roles: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.item.name ?? "",
    email: props.item.email ?? "",
    password: "",
    passwordConfirmation: "",
    roleId: props.edit ? (props.item.roles[0]?.id ?? "") : "",
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

                        <div>
                            <InputLabel value="Name" />

                            <TextInput type="text" class="mt-1 block w-full" v-model="form.name" />

                            <InputError class="mt-1" :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel value="Email" />

                            <TextInput type="email" class="mt-1 block w-full" v-model="form.email" />

                            <InputError class="mt-1" :message="form.errors.email" />
                        </div>
                        <div>
                            <InputLabel value="Password" />

                            <TextInput type="password" class="mt-1 block w-full" v-model="form.password" />

                            <InputError class="mt-1" :message="form.errors.password" />
                        </div>
                        <div>
                            <InputLabel value="Confirm Password" />

                            <TextInput type="password" class="mt-1 block w-full" v-model="form.passwordConfirmation" />

                            <InputError class="mt-1" :message="form.errors.passwordConfirmation" />
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
