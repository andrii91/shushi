import { createApp } from 'vue'
import './style.scss'
import App from './App.vue'
import i18n from "./i18n.ts";

createApp(App).use(i18n).mount('#app');
