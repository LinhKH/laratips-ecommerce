<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import BackendLayout from '../Layouts/BackendLayout.vue';

const { generalSettings, sitePages, all_category } = usePage().props;

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
})

</script>

<template>
    <Head title="Dashboard" />

    <BackendLayout>
          
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data.today_orders }}</h3>
                                <p>Today Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <Link :href="route('admin.orders.index')" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></Link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ data.products }}</h3>
                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <Link :href="route('admin.products.index')" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></Link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ data.users }}</h3>
                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <Link :href="route('admin.users.index')" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></Link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ data.total_saled }}</h3>

                                <p>Product Quantity Saled</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <Link :href="route('admin.product_sale.index')" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></Link>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>{{ data.total_stock }}</h3>
                                <p>Product Stock</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <Link :href="route('admin.product_stock.index')" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></Link>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-indigo">
                            <div class="inner">
                                <h3>{{generalSettings.currency}}{{ data.total_sold }}</h3>

                                <p>Total Amount Sold</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="javascript:;" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
           
    </BackendLayout>
</template>
