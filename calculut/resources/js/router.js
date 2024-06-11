import { createRouter, createWebHistory } from "vue-router";
import ListDonneesView from "./pages/donnees/ListDonneesView.vue";
import CreateBilanUtilisateurView from "./pages/bilans/utilisateur/EditBilanUtilisateurView.vue";
import ListBilansUtilisateurView from "./pages/bilans/utilisateur/ListBilansUtilisateurView.vue";
import ListBilansAdminView from "./pages/bilans/admin/ListBilansAdminView.vue";
import AccueilUtilisateurView from "./pages/accueil/AccueilUtilisateurView.vue";
import RecapitulatifBilanView from "./pages/recapitulatif/RecapitulatifBilanView.vue";

const routes = [
    {
        path: "/assos/:asso",
        component: AccueilUtilisateurView,
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
        path: "/assos/:asso/bilans/:id/finalises",
        component: RecapitulatifBilanView,
    },
    {
        path: "/admin",
        component: AccueilUtilisateurView,
    },
    {
        path: "/admin/donnees",
        component: ListDonneesView
    },
    {
        path: "/admin/bilans",
        component: ListBilansAdminView
    },
    {
        path: "/:pathMatch(.*)*",
        component: AccueilUtilisateurView,
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
