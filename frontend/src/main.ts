import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/router/router.js';
import 'bootstrap/dist/css/bootstrap.css';
import axios from 'axios';
import "toastify-js/src/toastify.css"
import "flatpickr/dist/flatpickr.css";
import flatpickr from "flatpickr";
import flatpickrLangPt from "flatpickr/dist/l10n/pt.js";
// frontend/node_modules/flatpickr/dist/l10n/pt.js

window.flatpickr = flatpickr;
window.flatpickr.l10ns = flatpickrLangPt

axios.interceptors.request.use(config => {
    const token = localStorage.getItem("jwt");
    config.headers["Authorization"] = `Bearer ${token}`;
    return config;
  });

createApp(App).use(router).mount('#app');
