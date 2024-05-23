import "./bootstrap";
import { createApp } from "vue";
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from "primevue/dialogservice";
import Tooltip from 'primevue/tooltip';
import router from "./router";
import '../../node_modules/primevue/resources/themes/aura-light-green/theme.css'
import '../../node_modules/primeicons/primeicons.css';
import '../css/app.css';

import App from "./App.vue";

const app = createApp(App);

// Vue routing
app.use(router);

// Primevue
app.use(PrimeVue);
app.use(ToastService);
app.directive('tooltip', Tooltip);
app.use(ConfirmationService);
app.use(DialogService);


app.mount("#app");
