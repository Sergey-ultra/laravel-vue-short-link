require('./bootstrap');
//import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createApp } from "vue";
import router from "./router/router";
import './src/style.css'



import App from './components/app.vue'
createApp(App).use(router).mount('#app')


