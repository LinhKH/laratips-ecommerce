<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BackendLayout from "@/admin/Layouts/BackendLayout.vue";
import BreadCrumb from "../../Components/BreadCrumb.vue";
import VueMultiselect from "vue-multiselect";
import { computed, onMounted, ref } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;
import Vue3TagsInput from 'vue3-tags-input';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import EditorGroup from "@/admin/Components/EditorGroup.vue";

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
    attrvalues: Object,
});

const form = useForm({
    product_name: props.item.product_name ?? "",
    category: props.item.category ?? "",
    color: props.item.color ?? "",
    brand: props.item.brand ?? "",
    unit: props.item.unit ?? "",
    quantity: props.item.quantity ?? "",
    unit_price: props.item.unit_price ?? "",
    shipping_charges: props.item.shipping_charges ?? "free",
    tags: props.item?.tags?.split(',') ?? [],
    refundable: props.item.refundable == 1 ? true : false,
    shipping_days: props.item.shipping_days ?? "",
    thumbnail_img: null,
    gallery: [],
    old_gallery: props.item.gallery_img?.split(',') ?? [],
    old_img: props.item.thumbnail_img ?? "",
    datetimes: props.item.date_range ?? "",
    product_status: props.item.product_status ?? 1,
    today_deal: props.item.today_deal == 1 ? true : false,
    attributes: props.item.attributes ?? [],
    description: props.item.description ?? "",
    meta_desc: props.item.meta_desc ?? "",
    meta_title: props.item.meta_title ?? "",
    discount: props.item.discount ?? "",
    discount_type: props.item.discount_type ?? "",
});

const addAttribute = () => {
    form.attributes.push({});
};

let arrAttrvalues = [...props.attrvalues];


const setAttr = (index, item) => {
    form.attributes[index].value = "";
    arrAttrvalues = props.attrvalues.filter(value => value.attribute == item);
};

const removeAttribute = (index) => {
    form.attributes.splice(index,1);
};

const productImages = ref([])
const dialogVisible = ref(false)
const dialogImageUrl = ref('')
const handleFileChange = (file) => {
    productImages.value.push(file)
}

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

onMounted(() => {
    const startDate = new Date(props.item.date_range?.split("-")[0]);
    const endDate = new Date(props.item.date_range?.split("-")[1]);
    form.datetimes = [startDate, endDate];
})
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

const deleteImage = async (product_id,pimage, index) => {
    try {
        await router.delete(`/admin/products/${product_id}/image/${pimage}`, {
            onSuccess: (page) => {
                form.old_gallery.splice(index, 1);
            }
        })
    } catch (err) {
        console.log(err);
    }
}

const submit = () => {

    for (const image of productImages.value) {
        form.gallery.push(image.raw);
    }

    if (props.edit) {
        router.post(route(`admin.${props.routeResourceName}.update`, {
                id: props.item.id,
            }), {...form, _method: "PUT"}, {
            onSuccess: (page) => {
                dialogVisible.value = false;
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    title: page.props.flash.success
                });
            }
        })
    } else {
        form.post(route(`admin.${props.routeResourceName}.store`), {
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
    }
};

</script>

<template>

    <Head :title="title" />
    <BackendLayout>
        <BreadCrumb :breadcrumb='breadcrumb' :title="title" :active='title'>
            <template #add_btn>
                <Link :href="route('admin.products.index')" class="align-top btn btn-sm btn-primary">Quay lại</Link>
            </template>
        </BreadCrumb>
        <section class="content card">
            <div class="container-fluid card-body">
                <form class="form-horizontal" @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin sản phẩm</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Tên sản phẩm</span> <small class="text-danger">*</small>
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
                                                <span>Danh mục</span> <small class="text-danger">*</small>
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
                                                <span>Thương hiệu</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="form.brand">
                                                    <option value="" selected disabled>chọn thương hiệu</option>
                                                    <option v-for="item in brand" :key="item.id" :value="item.id">{{ item.brand_name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Đơn vị</span>
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
                                                <span>Thẻ tag</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <vue3-tags-input :tags="form.tags" :class="{'border border-danger' : $page.props.errors.tags}"
                                                        placeholder="Nhập và nhấn enter để thêm 1 thẻ mới"
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
                                                <span>Cho phép đổi trả</span>
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
                                    <h3 class="card-title">Hình ảnh</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Thư viện hình</span><br />
                                                <small>Hình nên có kích thước (800x800)</small>
                                            </div>
                                            <div class="col-md-9">
                                                <el-upload v-model:file-list="productImages" list-type="picture-card" multiple :auto-upload="false"
                                                    :on-preview="handlePictureCardPreview" :on-remove="handleRemove" :on-change.prevent="handleFileChange">
                                                    <el-icon><Plus /></el-icon>
                                                </el-upload>
                                                <el-dialog v-model="dialogVisible">
                                                    <img w-full :src="dialogImageUrl" alt="Preview Image" />
                                                </el-dialog>
                                            </div>
                                        </div>
                                        <div class="row mt-2" v-if="props.edit">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                <ul class="el-upload-list el-upload-list--picture-card">
                                                    <li class="el-upload-list__item is-success" v-for="(pimage,index) in form.old_gallery" :key="pimage" style="width: auto;">
                                                        <img class="h-146 rounded" :src="`${baseUrl}/products/${pimage}`" :alt="pimage" style="width: 146px;">
                                                        <span
                                                            class="absolute top-2 right-0 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                                                            <button @click.prevent="deleteImage(props.item.id,pimage,index)"
                                                                class="text-white text-xs font-bold absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">x</button>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Hình ảnh chính</span><small class="text-danger">*</small><br />
                                                <small>Hình nên có kích thước (800x800)</small>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="hidden" class="custom-file-input" name="old_img" :value="form.thumbnail_img" />
                                                <input type="file" class="custom-file-input" :class="{'border border-danger' : $page.props.errors.thumbnail_img}" @input="form.thumbnail_img = $event.target.files[0]" @change="previewImage" name="thumbnail_img"/>
                                                <label class="custom-file-label">Choose file</label>
                                                <div v-if="$page.props.errors.thumbnail_img">
                                                    <p class="text-sm text-red-600">
                                                        {{ $page.props.errors.thumbnail_img }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <img v-if="form.thumbnail_img && url" id="image" :src="url"
                                                    alt="" width="100px">
                                                <img v-else id="image" :src="photo_or_blank_image"
                                                    alt="" width="100px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Các thuộc tính của sản phẩm (VD: Màu sắc, kích thước, chất liệu, bộ nhớ, ....)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Màu sắc</span>
                                            </div>
                                            <div class="col-md-9">
                                                <VueMultiselect
                                                    v-model="form.color"
                                                    :options="colors"
                                                    :multiple="true"
                                                    :close-on-select="true"
                                                    placeholder="Select color"
                                                    label="color_name"
                                                    track-by="id"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                                <th>Thuộc tính</th>
                                                <th>Giá trị của thuộc tính</th>
                                                <th><a href="javascript:;" @click="addAttribute" class="btn btn-info">+</a></th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(attr, index) in form.attributes" :key="index">
                                                    <td>
                                                        <select class="form-control attribute-select" :class="{'border border-danger' : $page.props.errors[`attributes.${index}.id`]}" v-model="attr.id" @change="setAttr(index, attr.id)">
                                                            <option v-for="(item,key) in attribute" :key="item.id" :value="item.id">{{ item.title }}</option>
                                                        </select>
                                                        <div v-if="`$page.props.errors.attributes.${index}.id`">
                                                            <p class="text-sm text-red-600">
                                                               {{ $page.props.errors[`attributes.${index}.id`] }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <VueMultiselect
                                                            v-model="attr.value"
                                                            :options="arrAttrvalues"
                                                            :multiple="true"
                                                            :close-on-select="true"
                                                            placeholder="Select Value"
                                                            label="value"
                                                            track-by="id"
                                                        />
                                                    </td>
                                                    <td><a href="javascript:;" class="btn btn-danger" @click="removeAttribute(index)">-</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Giá sản phẩm</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Giá</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control unit-price" :class="{'border border-danger' : $page.props.errors.unit_price}" v-model="form.unit_price" min="0"
                                                    placeholder="Giá">
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
                                                <span>Số lượng</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" :class="{'border border-danger' : $page.props.errors.quantity}" v-model="form.quantity"
                                                    placeholder="Số lượng">
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
                                                <span>Thời gian giảm giá</span>
                                            </div>
                                            <div class="col-md-9">
                                                <VueDatePicker v-model="form.datetimes" range :multi-calendars="{ solo: true }" :enable-time-picker="false" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span>Giảm giá</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="number" class="form-control" v-model="form.discount" min="0"
                                                            placeholder="Giảm giá" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" v-model="form.discount_type" id="">
                                                    <option value="flat">Cố định</option>
                                                    <option value="percent">Phần trăm</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Chi tiết sản phẩm</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Chi tiết</span>
                                            </div>
                                            <div class="col-md-9">
                                                <EditorGroup label="Chi tiết" v-model="form.description" :error-message="form.errors.description" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">SEO Meta Tags (Phần dành cho SEO Web, không cần nhập cũng được)</h3>
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
                            
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Ưu đãi hôm nay</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span>Trạng thái</span>
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
                                    <h3 class="card-title">Cấu hình vận chuyển</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Phí vận chuyển</span> <small class="text-danger">*</small>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" :class="{'border border-danger' : $page.props.errors.shipping_charges}" v-model="form.shipping_charges" id="">
                                                    <option value="" disabled selected>chọn phí vận chuyển</option>
                                                    <option value="free">Miễn phí</option>
                                                    <option value="area">Theo khu vực</option>
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
                                                <span>Số ngày vận chuyển</span> <small class="text-danger">*</small>
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Trạng thái</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span>Trạng thái</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" v-model="form.product_status" style="width: 100%;">
                                                    <option value="1" selected>Hiển thị</option>
                                                    <option value="0">Không hiển thị</option>
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
                            <input type="submit" class="btn btn-primary bg-primary" value="Nhấn gửi">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </BackendLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>