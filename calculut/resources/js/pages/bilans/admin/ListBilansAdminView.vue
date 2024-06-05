<script setup>
    import Button from "primevue/button";
    import DataTable from "primevue/datatable";
    import Column from 'primevue/column';
    import InputText from 'primevue/inputtext';
    import IconField from "primevue/iconfield";
    import InputIcon from "primevue/inputicon";
    import { ref, onMounted } from 'vue';
    import {FilterMatchMode} from "primevue/api";
    import {BilanService} from "../../../services/BilanService.ts";

    const bilanService = new BilanService();

    // Liste des données
    const bilans = ref();

    const filters = ref({
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    });

    async function recupererBilans() {
        bilanService.getBilans().then(data => {
            bilans.value = data;
        });
    }

    onMounted(async() => {
        await recupererBilans();
    });

    function parseDate(timestamp) {
        const date = new Date(timestamp * 1000);
        return date.toLocaleString("fr").split(" ")[0]
    }
</script>

<template>
    <div class="m-8 p-4 border border-solid border-emerald-800 rounded-2xl">
        <DataTable :value="bilans" :filters="filters" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows tableStyle="min-width: 50rem">
            <template #header>
                <div>
                    <h1 class="text-xl font-bold my-2">Liste des bilans</h1>
                    <div class="flex flex-row items-center justify-between">
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Rechercher un bilan..." id="search_donnee"/>
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="intitule" header="Nom" />
            <Column header="Début">
                <template #body="{ data }">
                    <span>{{ parseDate(data.evenement.debut) }}</span>
                </template>
            </Column>
            <Column header="Fin">
                <template #body="{ data }">
                    <span>{{ parseDate(data.evenement.fin) }}</span>
                </template>
            </Column>
            <Column field="asso" header="Association"></Column>
            <Column field="auteur" header="Auteur"></Column>
            <Column header="État">
                <template #body="{ data }">
                    <span v-if="data.enregistrement_finalises.length">Finalisé</span>
                    <span v-else>En cours</span>
                </template>
            </Column>
            <Column header="Exporter">
                <template #body="{ data }">
                    <Button icon="pi pi-download" outlined :disabled="!data.enregistrement_finalises.length"/>
                </template>
            </Column>
            <Column header="Action">
                <template #body="{ data }">
                    <router-link :to="'/assos/' + asso +'/bilans/'+ data.id + '/finalises'" target="_blank" rel="noopener" v-if="data.enregistrement_finalises.length">
                        <Button label="Consulter" icon="pi pi-eye" outlined class="mr-2" severity="secondary"/>
                    </router-link>
                    <router-link :to="'/assos/' + asso +'/bilans/'+ data.id + '/edit'" target="_blank" rel="noopener">
                        <Button label="Éditer" icon="pi pi-pencil" outlined class="mr-2"/>
                    </router-link>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

