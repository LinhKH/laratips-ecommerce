
<script setup>
import { usePage, Link, useForm, router } from "@inertiajs/vue3";
const baseUrl = import.meta.env.VITE_APP_URL;

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';


const {
    banner,
    flash,
} = usePage().props;

if (flash.success == "logout") {
    this.$swal({
        title: "Logged out Successfully.",
        icon: "success",
        showConfirmButton: false,
        timer: 1500,
    });
}

const data = useForm({
    keyword: new URL(window.location.href).searchParams.get("keyword")
        ? new URL(window.location.href).searchParams.get("keyword")
        : "",
    category: new URL(window.location.href).searchParams.get("category")
        ? new URL(window.location.href).searchParams.get("category")
        : "all",
});

function handleSubmit() {
    router.get(baseUrl + "/search", data);
};

</script>
<template>
    <div id="bannerSlider">
        <Swiper>
            <template v-for="item in banner" key="item.id">
                <SwiperSlide ng-if="item.status == '1'">
                    <img className="w-100" :src="`${baseUrl}/banner/${item.banner_img}`" />
                </SwiperSlide>
            </template>

        </Swiper>
    </div>
</template>