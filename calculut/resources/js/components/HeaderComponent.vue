<template>
    <div>
        <Menubar :model="items" class="bg-green-50 py-4 border-b border-b-emerald-800 rounded-none">
            <template #start>
                <h1 class="font-bold text-2xl text-emerald-800 mx-4">Calcul'UT</h1>
            </template>
            <template #item="{ item, props, hasSubmenu }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a v-ripple :href="href" v-bind="props.action" @click="navigate">
                        <span>{{ item.label }}</span>
                    </a>
                </router-link>
                <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                    <span>{{ item.label }}</span>
                    <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down ml-2" />
                </a>
            </template>
            <template #end>
                <div class="mr-4">
                    <span class="pi pi-user mr-1"/>
                    <span>Léo Péron</span>
                </div>
            </template>
        </Menubar>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';


const router = useRouter();

const items = ref([
    {
        label: 'Tableau de bord',
        icon: 'pi pi-palette',
        command: () => {
            router.push('/');
        }
    },
    {
        label: 'Bilans',
        icon: 'pi pi-link',
        command: () => {
            router.push('/admin/bilans');
        }
    },
    {
        label: 'Formulaires',
        icon: 'pi pi-home',
        command: () => {
            router.push('/test');
        }
    },
    {
        label: 'Données',
        icon: 'pi pi-home',
        command: () => {
            router.push('/admin/donnees');
        }
    },
    {
        label: 'Associations',
        icon: 'pi pi-home',
        items: [
            {
                label: 'Vue.js',
                url: 'https://vuejs.org/'
            },
            {
                label: 'Vite.js',
                url: 'https://vuejs.org/'
            }
        ]
    }
]);
</script>
