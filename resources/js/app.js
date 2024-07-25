import "./bootstrap";

import { createApp } from "vue";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";
import "primeicons/primeicons.css";
import App from "./App.vue";
import router from "./router/router";
import { createPinia } from "pinia";
import Ripple from "primevue/ripple";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
const app = createApp(App);
const pinia = createPinia();

app.directive("ripple", Ripple);

app.use(router);
app.use(pinia);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
    ripple: true,
});
app.use(ToastService);
app.use(ConfirmationService);
app.mount("#app");
