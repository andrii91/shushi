import { createApp } from 'vue'
import './style.scss'
import App from '@/App.vue'
import i18n from "@/i18n.ts";
// @ts-ignore
import gtag from '@/plugins/gtag';
import { createHead } from '@vueuse/head';

const app = createApp(App);
const head = createHead()

app.use(gtag, { trackingId: 'G-LGHR7TRCSZ' })

app.use(i18n).use(head).mount('#app');
