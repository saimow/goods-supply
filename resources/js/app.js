import './bootstrap';
import 'laravel-datatables-vite';

import {createApp} from 'vue/dist/vue.esm-bundler.js';

import Toast from "vue-toastification";

import ProductCreate from './layouts/Product/ProductCreate.vue'
import ProductUpdate from './layouts/Product/ProductUpdate.vue'
import ProductShow from './layouts/Product/ProductShow.vue'

const app = createApp({})


app.component('product-create', ProductCreate)
app.component('product-update', ProductUpdate)
app.component('product-show', ProductShow)

import '@vueform/multiselect/themes/default.css'
import "vue-toastification/dist/index.css";
import 'vue-loading-overlay/dist/css/index.css';

app.use(Toast)
app.mount('#app')