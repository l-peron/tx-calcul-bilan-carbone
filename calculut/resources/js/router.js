import { createRouter, createWebHistory } from "vue-router";
import HomeView from "./pages/HomeView.vue";
import TestView from "./pages/TestView.vue";
import ListDonneesView from "./pages/donnees/ListDonneesView.vue";
import ListBilansView from "./pages/bilans/admin/ListBilansAdminView.vue";
import CreateBilanUtilisateurView from "./pages/bilans/utilisateur/CreateBilanUtilisateurView.vue";

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
        path: "/assos/bilans/edit/:id",
        component: CreateBilanUtilisateurView
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
