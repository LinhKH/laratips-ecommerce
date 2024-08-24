<template>
    <Header />
    <Sidebar />
    <slot></slot>
    <Footer />
</template>

<script setup>
import { onMounted } from 'vue';
import Footer from '../Components/Footer.vue';
import Header from '../Components/Header.vue';
import Sidebar from '../Components/Sidebar.vue';

onMounted(() => {
    $('.select2').select2();

    $('#summernote').summernote({
        height: 200,
    });

    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate
                .format('MM/DD/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });

    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            locale: {
                format: 'M/DD/Y hh:mm A',
            }
        });
    });

})
</script>

<style lang="scss" scoped>

</style>