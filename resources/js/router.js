import { createRouter, createWebHistory } from "vue-router";
import MainPage from "./components/pages/mainPage/MainPage.vue";
import ManufacturersPage from "./components/pages/manufacturers/ManufacturersPage.vue";
import CatalogPage from "./components/pages/catalog/CatalogPage.vue";
import SubCatalogPage from "./components/pages/subCatalog/SubCatalogPage.vue";
import ProductPage from "./components/pages/productPage/ProductPage.vue";
import BacketPage from "./components/pages/basket/BasketPage.vue";
import ThanksPage from "./components/pages/thanks/ThanksPage.vue";
import AboutPage from "./components/pages/about/AboutPage.vue";
import ContactsPage from "./components/pages/contacts/ContactsPage.vue";
import FaqPage from "./components/pages/faq/FaqPage.vue";
import NotFound from "./NotFound.vue";
import SearchPage from "./components/pages/search/SearchPage.vue";
import ShippingPage from "./components/pages/shipping/ShippingPage.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      name: "mainpage",
      path: "/",
      component: MainPage,
    },
    {
      path: "/manufacturers",
      component: ManufacturersPage,
    },
    {
      name: "manufacturer",
      path: "/manufacturers/:manufacturer",
      component: CatalogPage,
    },
    {
      name: "category",
      path: "/manufacturers/:manufacturer/:submanufacturer",
      component: SubCatalogPage,
    },
    {
      name : "product",
      path: "/manufacturers/:manufacturer/:submanufacturer/:product",
      component: ProductPage,
    },
    {
      name: "basket",
      path: "/basket",
      component: BacketPage,
    },
    {
      name: "thanks",
      path: "/thanks",
      component: ThanksPage,
    },
    {
      name: "/about",
      path: "/about",
      component: AboutPage,
    },
    {
      name: "contacts",
      path: "/contacts",
      component: ContactsPage,
    },
    {
      name: 'faq',
      path: "/faq",
      component: FaqPage,
    },
    {
      name: 'shipping',
      path: "/shipping",
      component: ShippingPage,
    },
    {
      name: "search",
      path: "/search",
      component: SearchPage,
    },
    {
      path: "/:pathMatch(.*)*",
      name: NotFound,
      component: NotFound,
    },
  ],
});
export default router;