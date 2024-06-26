<script setup>
    import Button from "primevue/button";
    import DataTable from "primevue/datatable";
    import Column from 'primevue/column';
    import InputText from 'primevue/inputtext';
    import IconField from "primevue/iconfield";
    import InputIcon from "primevue/inputicon";
    import { useToast } from "primevue/usetoast";
    import {DonneeService} from '../../services/DonneeService.ts';
    import { ref, onMounted } from 'vue';
    import {FilterMatchMode} from "primevue/api";
    import CreateDonneeModalView from "./DonneeModalView.vue";
    import {useConfirm} from "primevue/useconfirm";
    import {useDialog} from "primevue/usedialog";

    const toast = useToast();
    const confirm = useConfirm();
    const dialog = useDialog();

    const donneeService = new DonneeService();

    // Liste des données
    const donnees = ref();
    const filters = ref({
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    });

    async function recupererDonnees() {
        donneeService.getDonnees().then(data => {
            donnees.value = data;
        });
    }

    onMounted(async() => {
        await recupererDonnees();
    });
    function ouvrirModalDonnee(donnee = undefined) {
        dialog.open(CreateDonneeModalView, {
            props: { header: `${donnee === undefined ? 'Modifier': 'Ajouter'} une donnée`, modal: true},
            data: { donnee },
            onClose: () => {
                recupererDonnees();
            }
        });
    }

    function confirmDuplicateDonnee(donneeId) {
        confirm.require({
            message: 'Es-tu sûr de vouloir duppliquer la donnée ?',
            header: 'Dupliquer la donnée',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Dupliquer',
            accept: async function() {
                await donneeService.duplicateDonnee(donneeId);
                await recupererDonnees();
                toast.add({ severity: 'info', summary: 'Confirmation', detail: 'La donnée a bien été dupliquée', life: 3000 });
            },
        });
    }

    function confirmDeleteDonnee(donnee = undefined) {
        confirm.require({
            message: 'Es-tu sûr de vouloir supprimer la donnée ? (Pense aux questions associées !)',
            header: 'Supprimer la donnée',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Supprimer',
            accept: async function() {
                await donneeService.deleteDonnee(donnee);
                await recupererDonnees();
                toast.add({ severity: 'info', summary: 'Confirmation', detail: 'La donnée a été supprimée', life: 3000 });
            },
        });
    }
</script>

<template>
    <div class="m-8 p-4 border border-solid border-emerald-800 rounded-2xl">
        <DataTable :value="donnees" :filters="filters" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows tableStyle="min-width: 50rem">
            <template #header>
                <div>
                    <h1 class="text-xl font-bold my-2">Liste des données</h1>
                    <div class="flex flex-row items-center justify-between">
                        <Button label="Créer une donnée" severity="primary" @click="ouvrirModalDonnee"/>
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Rechercher une donnée..." id="search_donnee" class="w-80"/>
                        </IconField>
                    </div>
                </div>
            </template>
            <Column header="Nom">
                <template #body="{ data }">
                    <span v-tooltip="data.description">{{ data.intitule }}</span>
                </template>
            </Column>
            <Column field="valeur" header="Valeur"></Column>
            <Column field="unite" header="Unité"></Column>
            <Column field="metrique" header="Métrique"></Column>
            <Column field="source" header="Source"></Column>
            <Column header="Mis à jour le">
                <template #body="{ data }">
                    <span>{{ new Date(data.updated_at).toLocaleDateString() }}</span>
                </template>
            </Column>
            <Column  style="min-width:8rem">
                <template #body="slotProps">
                    <Button label="Éditer" icon="pi pi-pencil" outlined class="mr-2" @click="ouvrirModalDonnee(slotProps.data)" />
                    <Button label="Dupliquer" icon="pi pi-clone" outlined severity="contrast" class="mr-2" @click="confirmDuplicateDonnee(slotProps.data)"/>
                    <Button label="Supprimer" icon="pi pi-trash" outlined severity="danger" @click="confirmDeleteDonnee(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

