import { createRouter, createWebHistory } from "vue-router";
import HomeView from "./pages/HomeView.vue";
import TestView from "./pages/TestView.vue";
import ListDonneesView from "./pages/donnees/ListDonneesView.vue";
import CreateBilanUtilisateurView from "./pages/bilans/utilisateur/EditBilanUtilisateurView.vue";
import ListBilansUtilisateurView from "./pages/bilans/utilisateur/ListBilansUtilisateurView.vue";
import ListBilansAdminView from "./pages/bilans/admin/ListBilansAdminView.vue";
import AccueilUtilisateurView from "./pages/accueil/AccueilUtilisateurView.vue";

const routes = [
    {
        path: "/assos/:asso",
        component: AccueilUtilisateurView,
    },
    {
        path: "/admin",
        component: HomeView,
    },
    {
        path: "/test",
        component: TestView,
    },
    {
        path: "/assos/:asso/bilans",
        component: ListBilansUtilisateurView
    },
    {
        path: "/assos/:asso/bilans/:id/edit",
        component: CreateBilanUtilisateurView
    },
    {
        path: "/admin/donnees",
        component: ListDonneesView
    },
    {
        path: "/admin/bilans",
        component: ListBilansAdminView
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
