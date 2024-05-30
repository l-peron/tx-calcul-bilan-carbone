<script setup>
    import Button from "primevue/button";
    import DataTable from "primevue/datatable";
    import Column from 'primevue/column';
    import InputText from 'primevue/inputtext';
    import IconField from "primevue/iconfield";
    import InputIcon from "primevue/inputicon";
    import Dropdown from "primevue/dropdown";
    import { useToast } from "primevue/usetoast";
    import { ref, onMounted } from 'vue';
    import {FilterMatchMode} from "primevue/api";
    import {useConfirm} from "primevue/useconfirm";
    import {useDialog} from "primevue/usedialog";
    import {BilanService} from "../../../services/BilanService.ts";

    const toast = useToast();
    const confirm = useConfirm();
    const dialog = useDialog();

    const bilanService = new BilanService();

    // Liste des données
    const bilans = ref();
    const poles_search = ref([
        { name: 'PTE', code: 'PTE' },
        { name: 'PAE', code: 'PAE' },
        { name: 'PSEC', code: 'PSEC' },
        { name: 'PVDC', code: 'PVDC' },
        { name: 'Tous les pôles', code: null }
    ]);
    const filters = ref({
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
        'pole_asso': {value: null, matchMode: FilterMatchMode.EQUALS}
    });

    async function recupererBilans() {
        bilanService.getBilans().then(data => {
            bilans.value = data;
        });
    }

    onMounted(async() => {
        await recupererBilans();
    });
</script>

<template>
    <div class="m-8 p-4 border border-solid border-emerald-800 rounded-2xl h-full">
        <DataTable :value="bilans" :filters="filters" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows tableStyle="min-width: 50rem">
            <template #header>
                <div>
                    <h1 class="text-xl font-bold my-2">Liste des bilans</h1>
                    <div class="flex flex-row items-center justify-between">
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Rechercher un bilan..." id="search_donnee"/>
                        </IconField>
                        <Dropdown v-model="filters['pole_asso'].value" :options="poles_search" optionLabel="name" optionValue="code" placeholder="Sélectionner un pôle" class="w-full md:w-14rem" />
                    </div>
                </div>
            </template>
            <Column field="intitule" header="Nom" />
            <Column field="type" header="Type"></Column>
            <Column field="asso" header="Association"></Column>
            <Column field="pole_asso" header="Pôle" filter-field="pole_asso"></Column>
            <Column header="État">
                <template #body="{ data }">
                    <span v-if="data.enregistrement_finalises.length">Finalisé</span>
                    <span v-else>En cours</span>
                </template>
            </Column>
            <Column style="min-width:8rem" header="Exporter">
                <template #body="slotProps">
                    <Button icon="pi pi-download" outlined/>
                </template>
            </Column>
            <Column style="min-width:8rem" header="Action">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil" outlined rounded class="mr-2"/>
                    <Button icon="pi pi-trash" outlined rounded severity="danger"/>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

