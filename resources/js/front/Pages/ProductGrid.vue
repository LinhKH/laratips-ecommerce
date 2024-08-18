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
            <img class="pic-1" :src="`${baseUrl}/products/${product.thumbnail_img.split(',')[0]}`"
                :alt="`${product.product_name}`" />
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
                    <Link :href="`${baseUrl}/product/${product.slug}`" data-id="product.id">
                    Add to cart
                    </Link>
                </li>
                <li v-if="userSession">
                    <Link v-if="!checkWishList(product.id)" href="#" data-tip="Add To Wishlist" data-id="product.id"
                        @click="handleAddWishlist(product.id)">
                    <i class="far fa-heart"></i>
                    </Link>
                    <Link v-if="checkWishList(product.id)" href="#" data-tip="Remove From Wishlist" data-id="product.id"
                        @click="handleRemoveFromWishlist(product.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                    </svg>
                    </Link>
                </li>
                <li v-else>
                    <Link :href="`${baseUrl}/user_login`" data-tip="Add To Wishlist" data-id="product.id">
                    <i class="far fa-heart"></i>
                    </Link>
                </li>
            </ul>

        </div>
    </div>
</template>