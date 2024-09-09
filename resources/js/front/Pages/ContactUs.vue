<script setup>
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import FrontLayout from '../Layouts/FrontLayout.vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const {
    title,
    generalSettings,
} = usePage().props;


const data = useForm({
    name: '',
    email: '',
    phone: '',
    description: '',
})

function handleSubmit(e) {
    data.post(route('contact_us.store'), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            Swal.fire({
                title: "Gửi thông tin thành công.",
                icon: "success",
                showConfirmButton: false,
                timer: 3000,
            });
        }
    });
}

</script>
<template>
    <FrontLayout>

        <Head :title="title"></Head>
        <div id="site-content">
            <div id="banner" class="d-flex flex-row justify-content-center">
                <div class="align-self-center">
                    <h2>Contact Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center p-0">
                            <li class="breadcrumb-item">
                                <Link :href="`${baseUrl}`">Home</Link>
                            </li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container-xl container-fluid">
                <div class="row align-items-start">
                    <form @submit.prevent="handleSubmit" class="row col-md-6 form-content position-relative" id="addContact" method="POST"
                        novalidate="novalidate">
                        <h3 class="mb-3 fw-bold">Thông tin liên hệ của bạn</h3>
                        <div class="col-md-12 form-group mb-3">
                            <input type="text" class="form-control" name="client" v-model="data.name" placeholder="Your Name">
                            <div v-if="$page.props.errors.name" class="text-danger">
                                {{ $page.props.errors.name }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <input type="email" class="form-control" name="email" v-model="data.email" placeholder="Your Email">
                            <div v-if="$page.props.errors.email" class="text-danger">
                                {{ $page.props.errors.email }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <input type="number" class="form-control" name="phone" v-model="data.phone" placeholder="Your Phone Number">
                            <div v-if="$page.props.errors.phone" class="text-danger">
                                {{ $page.props.errors.phone }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <textarea name="message" class="form-control" cols="20" rows="5" v-model="data.description"
                                placeholder="Message"></textarea>
                                <div v-if="$page.props.errors.description" class="text-danger">
                                    {{ $page.props.errors.description }}
                                </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        <div class="message mt-3"></div>
                    </form>
                    <div class="col-md-6">
                        <div class="contact-info">
                            <h5><i class="fa fa-map-marker-alt"></i> Address</h5>
                            <p>{{ generalSettings.address }}</p>
                        </div>
                        <div class="contact-info">
                            <h5><i class="fa fa-phone"></i> Phone</h5>
                            <p>{{ generalSettings.phone }}</p>
                        </div>
                        <div class="contact-info">
                            <h5><i class="far fa-envelope"></i> Email</h5>
                            <p>{{ generalSettings.email }}</p>
                        </div>
                        <div class="contact-info">
                            <h5><i class="fa fa-cube"></i> More Info</h5>
                            <p v-html="generalSettings.description"></p>
                        </div>
                        <div class="contact-info">
                            <h5><i class="far fa-map"></i> Location</h5>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.953708772132!2d106.7855312!3d10.8911227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d906aaa94aa7%3A0xaa660561b9f937b4!2zQ2h1bmcgQ8awIFBow7pjIMSQ4bqhdCBUb3dlcg!5e0!3m2!1svi!2s!4v1718087"
                                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontLayout>
</template>