<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card/Card.vue";
import Button from "@/Components/Button.vue";
import InputGroup from "@/Components/InputGroup.vue";
import SelectGroup from "@/Components/SelectGroup.vue";

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
    roleId: props.edit ? props.item.roles[0]?.id ?? "" : "",
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
                        <InputGroup v-model="form.name" label="Name" :error-message="form.errors.name" />

                        <InputGroup type="email" v-model="form.email" label="Email" :error-message="form.errors.email" />

                        <InputGroup type="password" v-model="form.password" label="Password"
                            :error-message="form.errors.password" />

                        <InputGroup type="password" v-model="form.passwordConfirmation" label="Confirm Password"
                            :error-message="form.errors.passwordConfirmation" />

                        <SelectGroup label="Role" v-model="form.roleId" :items="roles" :error-message="form.errors.roleId" />
                    </div>

                    <div class="mt-4">
                        <Button :disabled="form.processing">
                            {{ form.processing ? "Saving..." : "Save" }}
                        </Button>
                    </div>
                </form>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
