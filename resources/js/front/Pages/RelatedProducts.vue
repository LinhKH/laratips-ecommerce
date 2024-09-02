
<script setup>
import { usePage } from '@inertiajs/vue3';

const { related } = usePage().props;
</script>

<template>
    <section id="product_box" className="py-3">
        <div className="row">
            <div className="col-12">
                <div className="section-heading">
                    <h2 className="title">Related Product</h2>
                </div>
            </div>
        </div>
        <div className="row">
            <div className='col-12'>
                <template v-for="value in related.data" :key="`${value.id}`">
                    <div class="col-lg-3 col-md-4 col-sm-6" >
                        <ProductGrid :product="value" />
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>



<style scoped>

</style>