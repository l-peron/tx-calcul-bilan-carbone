<script setup>
import {onMounted, ref} from "vue";
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';
import {HeaderService} from "../../services/HeaderService.ts";
import Button from "primevue/button";

const bdeAdminTAG = "BDE (Admin)"

const headerService = new HeaderService();
const router = useRouter();

const adminHeader = ref(false);
const fullName = ref("");

const adminItems = ref([
    {
        label: 'Tableau de bord',
        url: '/admin'
    },
    {
        label: 'Bilans',
        url: '/admin/bilans',
    },
    {
        label: 'Données',
        url: '/admin/donnees'
    }
]);

const userItems = ref([]);

onMounted(async () => {
    await headerService.getIdentity().then(identity => {

        fullName.value = identity.fullName;
        const userAssos = identity.assos;
        let currentAsso;
        const select = {
            label: "",
            items: []
        }

        if(router.currentRoute.value.path.includes("admin")) {
            // Administrateur HEADER
            adminHeader.value = true
            currentAsso = bdeAdminTAG
        } else {
            // Utilisateur HEADER
            currentAsso = router.currentRoute.value.path.split("/")[2]
            userItems.value = [
                {
                    label: 'Tableau de bord',
                    url: `/assos/${currentAsso}`,
                },
                {
                    label: 'Bilans',
                    url: `/assos/${currentAsso}/bilans`,
                },

            ]
        }

        select.label = currentAsso
        for(const userAsso of userAssos) {
            select.items.push({
                label: userAsso.shortname,
                url: `/assos/${userAsso.shortname}`,
            })

            if(userAsso.shortname === "BDE") {
                select.items.push({
                    label: bdeAdminTAG,
                    url: `/admin`
                })
            }
        }

        adminItems.value.push(select)
        userItems.value.push(select)
    });
})

const logoutUser = async () => {
    await headerService.logoutUser();
    window.location.reload();
};

</script>

<template>
    <div>
        <Menubar :model="adminHeader ? adminItems : userItems" class="bg-green-50 border-b border-b-emerald-800 rounded-none">
            <template #start>
                <h1 class="font-bold text-2xl text-emerald-800 mx-4">Calcul'UT</h1>
            </template>
            <template #item="{ item, props, hasSubmenu }">
                <a :href="item.url" :target="item.target" v-bind="props.action">
                    <span>{{ item.label }}</span>
                    <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down ml-2" />
                </a>
            </template>
            <template #end>
                <Button href="/logout" link>Se déconnecter</Button>
            </template>
        </Menubar>
    </div>
</template>
