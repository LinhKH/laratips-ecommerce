<script setup>

const props = defineProps({
    rating_col: {
        type: Number
    },
    rating_sum: {
        type: [Number,String]
    },
})

let rating = 0;
if (props.rating_col > 0 && props.rating_sum != null) {
    rating = props.rating_sum / props.rating_col;
}
let star = "";
for (let i = 0; i < 5; i++) {
    if (i < rating) {
        star += '<li class="fa fa-star"></li>';
    } else {
        star += '<li class="far fa-star disable"></li>';
    }
}
star = star + " (" + (props.rating_col ?? 0) + " reviews)";
</script>
<template>
    <ul class="rating" v-html="star"></ul>
</template>