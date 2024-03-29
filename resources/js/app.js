import './bootstrap';

import { createApp } from 'vue';

import App from './component/app.vue';
import router from './router/index';

const app = createApp(App).use(router);

app.mount('#app');