import { createRouter, createWebHistory } from "vue-router";
import HomeView from "./pages/HomeView.vue";
import TestView from "./pages/TestView.vue";
import ListDonneesView from "./pages/donnees/ListDonneesView.vue";
import ListBilansView from "./pages/bilans/admin/ListBilansView.vue";

const routes = [
    {
        path: "/",
        component: HomeView,
    },
    {
        path: "/test",
        component: TestView,
    },
    {
        path: "/admin/donnees",
        component: ListDonneesView
    },
    {
        path: "/admin/bilans",
        component: ListBilansView
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
