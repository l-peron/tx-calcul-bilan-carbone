import { createRouter, createWebHistory } from "vue-router";
import ListDonneesView from "./pages/donnees/ListDonneesView.vue";
import EditBilanUtilisateurView from "./pages/bilans/utilisateur/EditBilanUtilisateurView.vue";
import ListBilansUtilisateurView from "./pages/bilans/utilisateur/ListBilansUtilisateurView.vue";
import ListBilansAdminView from "./pages/bilans/admin/ListBilansAdminView.vue";
import AccueilUtilisateurView from "./pages/accueil/AccueilUtilisateurView.vue";
import RecapitulatifBilanView from "./pages/recapitulatif/RecapitulatifBilanView.vue";
import ListFormulairesView from "./pages/formulaires/ListFormulairesView.vue";
import EditFormulaireView from "./pages/formulaires/EditFormulaireView.vue";

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
        component: EditBilanUtilisateurView
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
    },
    {
        path: "/admin/formulaires",
        component: ListFormulairesView
    },
    {
        path: "/admin/formulaires/:id/edit",
        component: EditFormulaireView
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
