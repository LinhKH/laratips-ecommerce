<script setup>
import { usePage, Link, router } from "@inertiajs/vue3";
import ProductRating from "./ProductRating.vue";
import { computed } from "vue";
const baseUrl = import.meta.env.VITE_APP_URL;

const { userSession, generalSettings } = usePage().props;

const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
});

const auth = computed(() => usePage().props.auth.user)

const checkWishList = (product_id) => {
    let wishlist_items = auth.value.wishlist;
    let wishlist = wishlist_items.split(',');

    return wishlist.includes(product_id.toString()) ? true : false;
}

const productName =
    props.product.product_name.length > 25
        ? props.product.product_name.substring(0, 25) + "..."
        : props.product.product_name;


const handleAddWishlist = (product_id) => {
    
    router.post(
        route('add_wishlist'),
        { id: product_id },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (response) => {
            if (response.props.flash.success) {
                Swal.fire({
                    title: "Item Added to Wishlist",
                    showConfirmButton: false,
                    timer: 1000,
                    icon: "success",
                    showCancelButton: true,
                });
            }
        },
        }
    );

};

function handleRemoveFromWishlist(product_id) {
    router.post(
        route('remove_wishlist'),
        { id: product_id },
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: (response) => {
                if (response.props.flash.success) {
                    Swal.fire({
                        title: "Removed Successfully.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                }
            },
        }
    );
}

</script>

<template>

    <div class="product-grid" :key="product.id">
        <div class="product-image">
            <Link :href="`${baseUrl}/product/${product.slug}`" class="image">
            <img class="pic-1" :src="`${baseUrl}/products/${product.thumbnail_img.split(',')[0]}`" :alt="`${product.product_name}`" />
            </Link>
            <span v-if="product.discount != '0'" class="product-discount-label">
                {{ product.discount_percent }} off
            </span>
            <!-- <span class="product-sale-label">sale</span> -->
            <Link class="quick-view" :href="`${baseUrl}/product/${product.slug}`">
            quick view
            </Link>
        </div>
        <div class="product-content">
            <span class="category">
                <span>{{ product.brand_name }}</span>
            </span>
            <h3 class="title">
                <Link :href="`${baseUrl}/product/${product.slug}`">
                {{ productName }}
                </Link>
            </h3>
            <ProductRating :rating_col="product.rating_col" :rating_sum="product.rating_sum" />

            <span v-if="product.discount != '0'" class="old-price">
                {{ generalSettings.currency }}
                {{ product.taxable_price }}
            </span>
            <span v-if="product.discount != '0'" class="price">
                {{ generalSettings.currency }}
                {{ product.taxable_price - product.discount }}
            </span>

            <span v-else class="price">
                {{ generalSettings.currency }}
                {{ product.taxable_price }}
            </span>
            <ul className="product-links">
                <li>
                    <Link
                        :href="`${baseUrl}/product/${product.slug}`"
                        data-id="product.id"
                    >
                        Add to cart
                    </Link>
                </li>
                <li v-if="userSession && !checkWishList(product.id) " >
                    <Link
                        href="#"
                        data-tip="Add To Wishlist"
                        data-id="product.id"
                        @click="handleAddWishlist(product.id)"
                    >
                        <i class="far fa-heart"></i>
                    </Link>
                </li>
                <li v-else-if="!userSession" >
                    <Link
                        :href="`${baseUrl}/user_login`"
                        data-tip="Add To Wishlist"
                        data-id="product.id"
                    >
                        <i class="far fa-heart"></i>
                    </Link>
                </li>
            </ul>
            <button v-if="userSession && checkWishList(product.id)"
                type="button"
                class="btn btn-danger btn-sm mt-2"
                data-id="product.id"
                @click="handleRemoveFromWishlist(product.id)"
            >
                Remove from wishlist
            </button>

        </div>
    </div>
</template>