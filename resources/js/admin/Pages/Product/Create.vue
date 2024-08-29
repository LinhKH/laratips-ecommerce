<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";
import { computed, onMounted, ref } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;
import Vue3TagsInput from 'vue3-tags-input';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import { Plus } from '@element-plus/icons-vue';

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
    category: {
        type: Object,
        default: () => ({}),
    },
    brand: {
        type: Object,
        default: () => ({}),
    },
    colors: {
        type: Object,
        default: () => ({}),
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
    product_name: props.item.product_name ?? "",
    category: props.item.category ?? "",
    brand: props.item.brand ?? "",
    unit: props.item.unit ?? "",
    unit_price: props.item.unit_price ?? "",
    shipping_charges: props.item.shipping_charges ?? "free",
    tags: props.item.tags ?? [],
    refundable: props.item.refundable ?? "",
    thumbnail_img: props.item.thumbnail_img ?? "",
    gallery: props.item.gallery ?? [],
    old_img: props.item.flash_image ?? "",
    datetimes: props.item.flash_date_range ?? "",
    flash_status: props.item.status ?? 1,
    products: props.flash_products ?? [],
});

const productImages = ref([])
const dialogVisible = ref(false)
const dialogImageUrl = ref('')
const handleFileChange = (file) => {
    productImages.value.push(file)
}
console.log(productImages.value)

const handleRemove = (file) => {
    console.log(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogVisible.value = true
}
let url = ref(`${baseUrl}/products/default.png`);
const previewImage = (e) => {
    const file = e.target.files[0];
    url.value = URL.createObjectURL(file);
}

// onMounted(() => {
//     const startDate = new Date(props.item.flash_date_range?.split("-")[0]);
//     const endDate = new Date(props.item.flash_date_range?.split("-")[1]);
//     form.datetimes = [startDate, endDate];
// })

const handleChangeTag = (tags) => {
    form.tags = tags;
}

const photo_or_blank_image = computed(() => {
    return props.item.thumbnail_img ? `${baseUrl}/products/${props.item.thumbnail_img}` : url.value;
});

let arrCategories = [];

for (let item of props.category) {
    arrCategories.push(item);
    if (item.children_categories) {
        for (let item1 of item.children_categories) {
           if(item1.level == 1) {
                item1.category_name = '-- '+item1.category_name;
           }
            arrCategories.push(item1);
            if (item1.categories) {
                for (let item2 of item1.categories) {
                    if(item2.level == 2) {
                        item2.category_name = '---- '+item2.category_name;
                    }
                    arrCategories.push(item2);
                }
            }
        }
    }
}

const submit = () => {

    for (const image of productImages.value) {
        form.gallery.push(image.raw);
    }

    console.log(form)
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
                <Link :href="route('admin.products.index')" class="align-top btn btn-sm btn-primary">Back</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" @submit.prevent="submit" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Product Name</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" :class="{'border border-danger' : $page.props.errors.product_name}" class="form-control" v-model="form.product_name"
                                                    placeholder="Product Name">
                                                    <div v-show="$page.props.errors.product_name">
                                                        <p class="text-sm text-red-600">
                                                            {{ $page.props.errors.product_name }}
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Category</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <VueMultiselect :class="{'border border-danger' : $page.props.errors.category}"
                                                    v-model="form.category"
                                                    :options="arrCategories"
                                                    :multiple="false"
                                                    :close-on-select="true"
                                                    placeholder="Select Category"
                                                    label="category_name"
                                                    track-by="id"
                                                />
                                                <div v-show="$page.props.errors.category">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.category }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Brand</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="form.brand">
                                                    <option value="" selected disabled>Select Brand</option>
                                                    <option v-for="item in brand" :key="item.id" :value="item.id">{{ item.brand_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Unit</span>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="form.unit"
                                                    placeholder="Unit (VD:  Cái, hộp, bịch ...)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Tags</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <vue3-tags-input :tags="form.tags" :class="{'border border-danger' : $page.props.errors.tags}"
                                                        placeholder="Type and hit enter to add a tag"
                                                        @on-tags-changed="handleChangeTag"/>
                                                <div v-show="$page.props.errors.tags">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.tags }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Refundable</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="checkbox1" v-model="form.refundable">
                                                    <label for="checkbox1"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Images</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Gallery Images</span><br />
                                                <small>Images must be square in size (e.g. 800x800)</small>
                                            </div>
                                            <div class="col-md-9">
                                                <el-upload v-model:file-list="productImages" list-type="picture-card" multiple action="#" :auto-upload="false"
                                                    :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change="handleFileChange">
                                                    <el-icon><Plus /></el-icon>
                                                </el-upload>
                                                <el-dialog v-model="dialogVisible">
                                                    <img w-full :src="dialogImageUrl" alt="Preview Image" />
                                                </el-dialog>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Thumbnail Image</span><br />
                                                <small>Image must be square in size (e.g. 800x800)</small>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="file" class="custom-file-input" @input="form.thumbnail_img = $event.target.files[0]" @change="previewImage" name="thumbnail_img"/>
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                            <div class="col-md-2">
                                                <img id="image" :src="url"
                                                    alt="" width="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Variation</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Colors</span>
                                            </div>
                                            <div class="col-md-9">
                                                <VueMultiselect :class="{'border border-danger' : $page.props.errors.color}"
                                                    v-model="form.color"
                                                    :options="colors"
                                                    :multiple="true"
                                                    :close-on-select="true"
                                                    placeholder="Select color"
                                                    label="color_name"
                                                    track-by="id"
                                                />
                                                <div v-show="$page.props.errors.color">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.color }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                                <th>Attribute</th>
                                                <th>Attribute value</th>
                                                <th><a href="javascript:;" class="btn btn-info">+</a></th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control attribute-select">
                                                            <option value="">Select an Attribute</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control attrvalue-select select2">

                                                        </select>
                                                    </td>
                                                    <td><a href="javascript:;" class="btn btn-danger deleteRow">-</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Price</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Unit Price</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control unit-price" :class="{'border border-danger' : $page.props.errors.unit_price}" v-model="form.unit_price" min="0"
                                                    placeholder="Unit Price">
                                                    <div v-show="$page.props.errors.unit_price">
                                                        <p class="text-sm text-red-600">
                                                            {{ $page.props.errors.unit_price }}
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Quantity</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" :class="{'border border-danger' : $page.props.errors.quantity}" v-model="form.quantity"
                                                    placeholder="Quantity">
                                                    <div v-show="$page.props.errors.quantity">
                                                        <p class="text-sm text-red-600">
                                                            {{ $page.props.errors.quantity }}
                                                        </p>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Discount Date Range</span>
                                            </div>
                                            <div class="col-md-9">
                                                <VueDatePicker v-model="form.datefilter" range :multi-calendars="{ solo: true }" :enable-time-picker="false" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span>Discount</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="number" class="form-control" v-model="form.discount" min="0"
                                                            placeholder="Discount" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" v-model="form.discount_type" id="">
                                                    <option value="flat">Flat</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Description</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Description</span>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea v-model="form.description" id="summernote" class="form-control" cols="30" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">SEO Meta Tags</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Meta Title</span>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="form.meta_title"
                                                    placeholder="Meta Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Meta Description</span>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control" v-model="form.meta_desc" placeholder="Meta Description" id="" cols="30"
                                                    rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Status</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="form.product_status" style="width: 100%;">
                                                    <option value="1" selected>Published</option>
                                                    <option value="0">Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Today Deal</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span>Status</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="checkbox5" v-model="form.today_deal">
                                                    <label for="checkbox5"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Shipping Configuration</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Shipping Charges</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" :class="{'border border-danger' : $page.props.errors.shipping_charges}" v-model="form.shipping_charges" id="">
                                                    <option value="" disabled selected>Select Shipping Charges</option>
                                                    <option value="free">Free Shipping</option>
                                                    <option value="area">Area Wise</option>
                                                </select>
                                                <div v-show="$page.props.errors.shipping_charges">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.shipping_charges }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Shipping Days</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control" :class="{'border border-danger' : $page.props.errors.shipping_days}" v-model="form.shipping_days" min="0"
                                                    placeholder="Shipping Days">
                                                    <div v-show="$page.props.errors.shipping_days">
                                                        <p class="text-sm text-red-600">
                                                            {{ $page.props.errors.shipping_days }}
                                                        </p>
                                                    </div>
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