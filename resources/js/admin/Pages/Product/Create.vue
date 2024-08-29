<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";
import { computed, onMounted, ref } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

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
    allProducts: {
        type: Object,
        default: () => [],
    },
    flash_products: {
        type: Object,
        default: () => [],
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    breadcrumb: Object,
    attribute: Object,
});

const form = useForm({
    flash_id: props.item.id ?? "",
    title: props.item.flash_title ?? "",
    img: null,
    old_img: props.item.flash_image ?? "",
    datetimes: props.item.flash_date_range ?? "",
    flash_status: props.item.status ?? 1,
    products: props.flash_products ?? [],
});

onMounted(() => {
    const startDate = new Date(props.item.flash_date_range?.split("-")[0]);
    const endDate = new Date(props.item.flash_date_range?.split("-")[1]);
    form.datetimes = [startDate, endDate];
})

const startTime = ref({ hours: 0, minutes: 0 });

const photo_or_blank_image = computed(() => {
    return props.item.flash_image ? `${baseUrl}/flash-deals/${props.item.flash_image}` : `${baseUrl}/flash-deals/default.png`;
});

const submit = () => {
    props.edit
        ? form.put(
            route(`admin.${props.routeResourceName}.update`, {
                id: props.item.id,
            }), {
                onSuccess: page => {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title: page.props.flash.success
                    })
                },
            }
        )
        : form.post(route(`admin.${props.routeResourceName}.store`), {
            onSuccess: page => {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        title: page.props.flash.success
                    })
                },
        });
};

</script>

<template>

    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
            <template #add_btn>
                <Link :href="route('admin.flash-deals.index')" class="align-top btn btn-sm btn-primary">Back</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Attribute Values Details</h3>
                                </div>
                                <div class="card-body">
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary bg-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </BackendLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>