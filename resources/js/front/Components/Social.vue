<script setup>
import { usePage } from '@inertiajs/vue3';

const { socialLinks } = usePage().props;
</script>

<template>
    <ul class="social-links">
        <li v-if="socialLinks.facebook">
            <a :href="socialLinks.facebook" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
        </li>
        <li v-if="socialLinks.tiktok">
            <a :href="socialLinks.tiktok" target="_blank" class="tiktok"><i class="fa-brands fa-tiktok"></i></a>
        </li>
        <li v-if="socialLinks.zalo">
            <a :href="socialLinks.zalo" target="_blank" class="zalo"><img width="30" height="30" src="https://img.icons8.com/color/100/zalo.png" alt="zalo"/></a>
        </li>

        <li v-if="socialLinks.twitter">
            <a :href="socialLinks.twitter" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
        </li>

        <li v-if="socialLinks.instagram">
            <a :href="socialLinks.instagram" target="_blank" class="instagram"><i class="fab fa-instagram"></i></a>
        </li>
    </ul>
</template>
<style scoped>
.social-links{
    text-align: right;
}

.social-links li{
    display: inline-block;
    margin-right: 6px;
}

.social-links li a{
    background: #e5e5e5;
    color: var(--main-color);
    text-align: center;
    line-height: 30px;
    width: 30px;
    height: 30px;
    display: inline-block;
    border-radius: 50%;
    transition: all 0.3s ease 0s;
}

.social-links li .facebook:hover{
    background: #395b98;
    color: #fff;
}
.social-links li .tiktok:hover{
    background: #cf56e7;
    color: #fff;
}
.social-links li .zalo:hover{
    background: #3633f3;
    color: #fff;
}

.social-links li .twitter:hover{
    background: #2ca7e0;
    color: #fff;
}

.social-links li .instagram:hover{
    background: linear-gradient(-45deg, #ffdc80, #e1306c 50%, #405de6);
    color: #fff;
}
</style>