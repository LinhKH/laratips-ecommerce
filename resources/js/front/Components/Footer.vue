<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import Social from "./Social.vue";
import { ref } from "vue";

const baseUrl = import.meta.env.VITE_APP_URL;

const isShow = ref(false);

const { generalSettings, socialLinks, sitePages, all_category } = usePage().props;


</script>
<template>
    <div class="footer-widget">
        <div class="container-xl container-fluid" style="margin-bottom: 25px;">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="site-info-widget">
                        <div class="footer-logo">
                            <Link :href="`${baseUrl}`">
                            <h6>{{ generalSettings.site_name }}</h6>
                            </Link>
                        </div>
                        <p>{{ generalSettings.description }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="widget-box">
                        <h6 class="widget-title">Categories</h6>
                        <ul class="widget-list">
                            <template v-for="cat_menu in all_category" :key="cat_menu.id">
                                <li v-if="cat_menu.parent_category == '0'">
                                    <Link :href="`${baseUrl}/search?category=${cat_menu.category_slug}`">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    {{ cat_menu.category_name }}
                                    </Link>
                                </li>
                            </template>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="widget-box">
                        <h6 class="widget-title">Links</h6>
                        <ul class="widget-list">
                            <template v-for="page in sitePages" key="page.page_id">
                                <li v-if="page.show_in_footer == '1'">
                                    <Link :href="`${baseUrl}/${page.page_slug}`">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    {{ page.page_title }}
                                    </Link>
                                </li>
                            </template>
                            <li>
                                <Link :href="`${baseUrl}/contact_us`">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                Contact us
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex justify-content-left justify-content-lg-center">
                    <div class="contact-widget">
                        <h6 class="widget-title">Contact Us</h6>
                        <ul class="contact-list">
                            <li v-if="generalSettings.address">
                                <span class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <span>
                                    <b>Address: </b>
                                    {{ generalSettings.address }}
                                </span>
                            </li>
                            <li v-if="generalSettings.email">
                                <span class="icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span>
                                    <b>Email: </b>
                                    {{ generalSettings.email }}
                                </span>
                            </li>
                            <li v-if="generalSettings.phone">
                                <span class="icon">
                                    <i class="fas fa-phone-alt"></i>
                                </span>
                                <span>
                                    <b>Contact Us: </b>
                                    {{ generalSettings.phone }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="support-online a" @mouseenter="isShow = true" @mouseleave="isShow = false">
                        <div class="support-content social-button" :style="{'display' : isShow ? 'block' : 'none'}">
                            <a href="tel:18006749" class="call-now"><i class="fa fa-phone"
                                    aria-hidden="true"></i><span>Hotline: {{ generalSettings.phone }}</span>
                                <div class="animated infinite zoomIn kenit-alo-circle"></div>
                                <div class="animated infinite pulse kenit-alo-circle-fill"></div>
                            </a>
                            <a class="zalo" :href="socialLinks.zalo" target="_blank"
                                rel="nofollow"><img :src="`${baseUrl}/site/icon-zalo-circle.png`"
                                    alt="Zalo"><span>Zalo OA yahooshop.vn</span>
                            </a>
                            <a :href="socialLinks.facebook" target="_blank" class="fb" rel="nofollow"><i class="fab fa-facebook-messenger"
                                    aria-hidden="true"></i><span>Nhắn tin Facebook</span>
                            </a>
                        </div><a class="btn-support"><i class="fa fa-user-circle" aria-hidden="true"></i>
                            <div class="animated infinite zoomIn kenit-alo-circle"></div>
                            <div class="animated infinite pulse kenit-alo-circle-fill"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12 align-self-center">
                        <input type="hidden" class="demo" :value="baseUrl"></input>
                        <span>
                            <strong>
                                Copyright {{ new Date().getFullYear() }} by
                                <a target="_blank" href="https://news-portal.shop/">
                                    Linh Dev
                                </a>
                                .
                            </strong>
                            All rights reserved
                        </span>
                    </div>
                    <div class="col-md-6 col-12">
                        <Social />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.footer-bottom {
    width: 100%;
    position: fixed;
    bottom: 0;
    background-color: #f8f8f8;
}

.support-online {
    position: fixed;
    z-index: 9999999;
    right: 2px;
    bottom: 65px
}

.support-online a {
    position: relative;
    margin: 15px 20px;
    text-align: left;
    width: 40px;
    height: 40px
}

.support-online a {
    display: block
}

.support-online .btn-support {
    cursor: pointer
}

.button-call i,
.button-call-mobile i,
.support-online i {
    width: 40px;
    height: 40px;
    background: #43a1f3;
    color: #fff;
    border-radius: 100%;
    font-size: 20px;
    text-align: center;
    line-height: 1.9;
    position: relative;
    z-index: 999
}

.button-call i,
.button-call-mobile i {
    background: #dd0202 !important
}

@-webkit-keyframes zoomIn {
    0% {
        opacity: 0;
        -webkit-transform: scale3d(.3, .3, .3);
        transform: scale3d(.3, .3, .3)
    }

    50% {
        opacity: 1
    }
}

@keyframes zoomIn {
    0% {
        opacity: 0;
        -webkit-transform: scale3d(.3, .3, .3);
        transform: scale3d(.3, .3, .3)
    }

    50% {
        opacity: 1
    }
}

.zoomIn {
    -webkit-animation-name: zoomIn;
    animation-name: zoomIn
}

.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both
}

.animated.infinite {
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite
}

@-webkit-keyframes pulse {
    0% {
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1)
    }

    50% {
        -webkit-transform: scale3d(1.05, 1.05, 1.05);
        transform: scale3d(1.05, 1.05, 1.05)
    }

    100% {
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1)
    }
}

@keyframes pulse {
    0% {
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1)
    }

    50% {
        -webkit-transform: scale3d(1.05, 1.05, 1.05);
        transform: scale3d(1.05, 1.05, 1.05)
    }

    100% {
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1)
    }
}

.pulse {
    -webkit-animation-name: pulse;
    animation-name: pulse
}

.kenit-alo-circle {
    width: 50px;
    height: 50px;
    top: -5px;
    right: -5px;
    position: absolute;
    background-color: transparent;
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
    border: 2px solid rgba(17, 130, 252, .8);
    opacity: .1;
    border-color: #1182fc;
    opacity: .5
}

.kenit-alo-circle-fill {
    width: 60px;
    height: 60px;
    top: -10px;
    position: absolute;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -ms-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
    border: 2px solid transparent;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    -o-transition: all .5s;
    transition: all .5s;
    background-color: rgba(17, 130, 252, .45);
    opacity: .75;
    right: -10px
}

.background-color-call {
    background-color: rgba(221, 2, 2, .45) !important
}

.background-border-call {
    border: 2px solid rgba(221, 2, 2, .8) !important;
    border-color: #dd0202
}

.sms i {
    background: red
}

.mes i {
    background: orange
}

.fb i {
    background: #139cf8
}

.call-now i {
    background: green
}

.social-button a span {
    border-radius: 2px;
    text-align: center;
    background: #ff9000;
    padding: 9px;
    display: none;
    width: 161px;
    margin-left: 10px;
    position: absolute;
    color: #fff;
    z-index: 999;
    top: 0;
    right: 58px;
    transition: all .2s ease-in-out 0s;
    -moz-animation: headerAnimation .7s 1;
    -webkit-animation: headerAnimation .7s 1;
    -o-animation: headerAnimation .7s 1;
    animation: headerAnimation .7s 1
}

@-webkit-keyframes headerAnimation {
    0% {
        margin-top: -70px
    }

    100% {
        margin-top: 0
    }
}

@keyframes headerAnimation {
    0% {
        margin-top: -70px
    }

    100% {
        margin-top: 0
    }
}

.social-button a span:before {
    content: "";
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 10px 0 10px 10px;
    border-color: transparent #ff9000 transparent transparent;
    position: absolute;
    right: 10px;
    top: 10px
}

.button-call {
    position: fixed;
    left: 25px;
    bottom: 27px;
    z-index: 1001
}

.phone-bar {
    position: fixed;
    left: 38px;
    bottom: 32px;
    padding: 5px 15px 5px 45px;
    background-color: #dd0202;
    border-radius: 20px;
    z-index: 1000
}

.phone-bar a .text-phone {
    color: #fff;
    font-weight: 700
}

.content-box-chat {
    position: absolute;
    white-space: nowrap;
    right: 78px;
    top: -55px;
    background-color: #43a1f3;
    color: #fff;
    padding: 8px 12px;
    font-size: 13px;
    border-radius: 6px
}

.content-box-chat:before {
    display: inline-block;
    font-family: "Font Awesome 5 Free";
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    content: "";
    font-weight: 900;
    margin-right: 8px;
    font-size: 16px
}

.content-box-chat:after {
    content: "" !important;
    width: 0 !important;
    height: 0 !important;
    right: -7px !important;
    top: 12px !important;
    position: absolute !important;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-left: 7px solid #43a1f3
}

.social-button a:hover span {
    display: block
}
</style>