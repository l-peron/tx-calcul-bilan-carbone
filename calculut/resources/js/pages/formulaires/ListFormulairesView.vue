<script setup>

    import { ref, onMounted } from 'vue';

    import DataTable from "primevue/datatable";
    import Column from 'primevue/column';
    import Button from "primevue/button";
    import Checkbox from 'primevue/checkbox';
    import {useDialog} from "primevue/usedialog";
    import {useConfirm} from "primevue/useconfirm";
    import {useToast} from "primevue/usetoast";

    import {FormulaireService, TypeFormulaire} from '../../services/FormulaireService.ts';

    import CreateFormulaireModalView from "./CreateFormulaireModalView.vue";
    import InputText from "primevue/inputtext";
    import IconField from "primevue/iconfield";
    import InputIcon from "primevue/inputicon";
    import {FilterMatchMode} from "primevue/api";

    const formulaireService = new FormulaireService();
    const dialog = useDialog();
    const confirm = useConfirm();
    const toast = useToast();

    const formulaires = ref([]);
    const filters = ref({
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    });

    onMounted(async() => {
        await getFormulaires();
    });

    async function getFormulaires() {
        formulaireService.getFormulaires().then(data => {
            formulaires.value = data;
        });
    }

    function openCreateFormulaire() {
        dialog.open(CreateFormulaireModalView, {
            props: { header: 'Créer un formulaire', modal: true},
            onClose: () => {
                getFormulaires();
            }
        });
    }

    function confirmDeleteFormulaire(formulaire) {
        confirm.require({
            message: 'Es-tu sûr de vouloir supprimer ce formulaire ?',
            header: 'Supprimer le formulaire',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Supprimer',
            accept: async function() {
                await formulaireService.deleteFormulaire(formulaire);
                await getFormulaires();
                toast.add({ severity: 'info', summary: 'Confirmation', detail: 'Le formulaire a été supprimé', life: 3000 });
            },
        });
    }

</script>

<template>
    <div class="m-8 p-4 border border-solid border-emerald-800 rounded-2xl h-full">
        <DataTable :value="formulaires" tableStyle="min-width: 50rem">
            <template #header>
                <div>
                    <h1 class="text-xl font-bold my-2">Liste des données</h1>
                    <div class="flex flex-row items-center justify-between">
                        <Button label="Créer un formulaire" severity="primary" @click="openCreateFormulaire"/>
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-search"> </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Rechercher un formulaire" id="search_formulaire" class="w-80"/>
                        </IconField>
                    </div>
                </div>
            </template>
            <Column field="intitule" header="Intitulé"></Column>
            <Column header="Secteur">
                <template #body="{ data }">
                    {{TypeFormulaire[data.secteur]}}
                </template>
            </Column>
            <Column field="created_at" header="Création">
                <template #body="{ data }">
                    <span>{{ new Date(data.created_at).toLocaleDateString() }}</span>
                </template>
            </Column>
            <Column field="updated_at" header="Dernière modification">
                <template #body="{ data }">
                    <span>{{ new Date(data.updated_at).toLocaleDateString() }}</span>
                </template>
            </Column>
            <Column header="Actif ?">
                <template #body="{ data }">
                    <span>{{ data.publie ? 'Oui' : 'Non' }}</span>
                </template>
            </Column>
            <Column header="Actions">
                <template #body="slotProps">
                    <router-link :to="'/admin/' +'formulaires/'+ slotProps.data.id + '/edit'" target="_blank" rel="noopener">
                        <Button label="Éditer" icon="pi pi-pencil" outlined class="mr-2"/>
                    </router-link>
                    <Button label="Supprimer" icon="pi pi-trash" outlined severity="danger" @click="confirmDeleteFormulaire(slotProps.data)"/>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<style scoped>

</style>
