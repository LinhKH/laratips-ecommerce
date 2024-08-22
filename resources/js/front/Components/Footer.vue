<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const baseUrl = import.meta.env.VITE_APP_URL;

const { generalSettings, sitePages, all_category } = usePage().props;


</script>
<template>
    <div class="footer-widget">
        <div class="container-xl container-fluid">
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
                                {{ generalSettings.copyright }} by
                                <a target="_blank" href="https://news-portal.shop/">
                                    Linh Dev
                                </a>
                                .
                            </strong>
                            All rights reserved
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>