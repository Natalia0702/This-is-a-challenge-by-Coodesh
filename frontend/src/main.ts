import { createApp } from 'vue';

import App from '@/App.vue';
import router from '@/router/router.js';

import 'bootstrap/dist/css/bootstrap.css';
import axios from 'axios';
import "toastify-js/src/toastify.css"

axios.interceptors.request.use(config => {
    const token = localStorage.getItem("jwt");
    config.headers["Authorization"] = `Bearer ${token}`;
    return config;
  });

createApp(App).use(router).mount('#app');
