import { createApp } from "vue";
import App from "./App.vue";
import clickOutside from "./directives/clickOutside";
import router from "./router";
import VueTheMask from "vue-the-mask";
import "./assets/css/style.css";
import TawkMessengerVue from '@tawk.to/tawk-messenger-vue-3';

window.addEventListener("load", () => {
  document.documentElement.style.setProperty(
    "--scrollbar-width",
    window.innerWidth - document.documentElement.clientWidth + "px"
  );
});

createApp(App)
    .use(VueTheMask)
    .use(router)
    .use(TawkMessengerVue, {
      propertyId : import.meta.env.VITE_TAWK_PROPERTY_ID,
      widgetId : import.meta.env.VITE_TAWK_WIDGET_ID
    })
    .directive("clickOutside", clickOutside)
    .mount("#app");