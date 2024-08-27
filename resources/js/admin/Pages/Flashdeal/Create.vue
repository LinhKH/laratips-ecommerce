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
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Title</span>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" v-model="form.title"
                                                    placeholder="Title">
                                                <div v-show="$page.props.errors.title">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.title }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <span class="col-md-2">Image </span>
                                        <div class="custom-file col-md-7">
                                            <input type="hidden" class="custom-file-input" name="old_img" v-model="form.old_img" />
                                            <input type="file" class="custom-file-input" name="img"
                                                @input="form.img = $event.target.files[0]">
                                            <label class="custom-file-label">Choose file</label>
                                            <div v-show="$page.props.errors.img">
                                                <p class="text-sm text-red-600">
                                                    {{ $page.props.errors.img }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <img id="image" :src="photo_or_blank_image" alt="" width="150px">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Discount Date Range</span>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <!-- <VueDatePicker v-model="form.datetimes" range></VueDatePicker> -->
                                                    <VueDatePicker v-model="form.datetimes" range :multi-calendars="{ solo: true }" :enable-time-picker="false" />
                                                </div>
                                                <div v-show="$page.props.errors.datetimes">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.datetimes }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Products</span>
                                            </div>
                                            <div class="col-md-10">
                                                <VueMultiselect v-model="form.products" :options="allProducts"
                                                    :multiple="true" :close-on-select="true" placeholder="Pick some"
                                                    label="product_name" track-by="id" />
                                                <div v-show="$page.props.errors.products">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.products }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="selected-products">
                                                    <table class="table table-bordered mt-3">
                                                        <tbody>
                                                            <tr v-for="row in form.products" :key="row.id">
                                                                <td>
                                                                    <img :src="`${baseUrl}/products/${row.thumbnail_img}`"
                                                                        width="80px">
                                                                </td>
                                                                <td>
                                                                    <span><b>Product Name :</b> {{ row.product_name
                                                                        }}</span><br>
                                                                    <span><b>Product Price :</b> {{ row.taxable_price
                                                                        }}</span>
                                                                </td>
                                                                <td>
                                                                    <span><b>Discount :</b></span>
                                                                    <input v-if="!edit" type="number" class="form-control"
                                                                        v-model="row.discount" placeholder="Discount"
                                                                        value="0" min="1" required>
                                                                    <input v-else type="number" class="form-control"
                                                                        v-model="row.product_discount" placeholder="Discount"
                                                                        value="0" min="1" required>
                                                                </td>
                                                                <td>
                                                                    <span><b>Discount Type :</b></span>
                                                                    <select v-if="!edit" class="form-control"
                                                                        v-model="row.discount_type" required>
                                                                        <option value="percent" selected>Percent
                                                                        </option>
                                                                        <option value="flat">Flat</option>
                                                                    </select>
                                                                    <select v-else class="form-control"
                                                                        v-model="row.product_discount_type" required>
                                                                        <option value="percent" selected>Percent
                                                                        </option>
                                                                        <option value="flat">Flat</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span>Status</span>
                                            </div>
                                            <div class="col-md-10">
                                                <select class="form-control" v-model="form.flash_status">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

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