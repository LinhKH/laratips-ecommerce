import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../../vendor/tightenco/ziggy/dist/vue.m';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName = import.meta.env.VITE_APP_NAME || 'Yahoo Shop';

createInertiaApp({
    title: title => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
                    .use(plugin)
                    .use(ZiggyVue)
                    .use(VueSweetalert2)
                    
            app.config.globalProperties.$filters = {
                formatNumber(number) {
                    return Intl.NumberFormat().format(number);
                },
                formatDate(date) {
                    var d = new Date(date), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
                
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                
                    return [day , month , year].join('-');
                }
            }

            app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
