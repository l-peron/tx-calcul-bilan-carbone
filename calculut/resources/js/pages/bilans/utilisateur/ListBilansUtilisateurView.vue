<script setup>
    import Button from "primevue/button";
    import DataTable from "primevue/datatable";
    import Column from 'primevue/column';
    import InputText from 'primevue/inputtext';
    import IconField from "primevue/iconfield";
    import InputIcon from "primevue/inputicon";
    import { ref, onMounted } from 'vue';
    import {FilterMatchMode} from "primevue/api";
    import {useConfirm} from "primevue/useconfirm";
    import {useDialog} from "primevue/usedialog";
    import {BilanService} from "../../../services/BilanService.ts";
    import {useRouter} from "vue-router";
    import CreateBilanModalView from "./CreateBilanModalView.vue";

    const confirm = useConfirm();
    const dialog = useDialog();
    const router = useRouter();

    const bilanService = new BilanService();

    // Liste des données
    const bilans = ref();
    const filters = ref({
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    });

    const asso = router.currentRoute.value.path.split("/")[2]


    async function recupererBilans() {
        bilanService.getBilansByAsso(asso).then(data => {
            bilans.value = data;
        });
    }

    function ouvrirCreateBilan() {
        dialog.open(CreateBilanModalView, {
            props: { header: 'Créer un bilan', modal: true},
            onClose: () => {
                recupererBilans();
            }
        });
    }

    onMounted(async() => {
        await recupererBilans();
    });

    function confirmDuplicateBilan(bilanId) {
        confirm.require({
            message: 'Es-tu sûr de vouloir duppliquer le bilan ?',
            header: 'Dupliquer le bilan',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Dupliquer',
            accept: async function() {
                await bilanService.duplicateBilan(bilanId);
                await recupererBilans();
                toast.add({ severity: 'info', summary: 'Confirmation', detail: 'Le bilan a bien été dupliqué', life: 3000 });
            },
        });
    }

    function confirmDeleteBilan(bilanId) {
        confirm.require({
            message: 'Es-tu sûr de vouloir supprimer le bilan ?',
            header: 'Supprimer le bilan',
            icon: 'pi pi-exclamation-triangle',
            rejectLabel: 'Annuler',
            acceptLabel: 'Supprimer',
            accept: async function() {
                await bilanService.deleteBilan(bilanId);
                await recupererBilans();
                toast.add({ severity: 'info', summary: 'Confirmation', detail: 'Le bilan a bien été supprimé', life: 3000 });
            },
        });
    }

    function parseDate(timestamp) {
        const date = new Date(timestamp * 1000);
        return date.toLocaleString("fr").split(" ")[0]
    }
</script>

<template>
    <div class="m-8 p-4 border border-solid border-emerald-800 rounded-2xl h-full">
        <DataTable :value="bilans" :filters="filters" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows tableStyle="min-width: 50rem">
            <template #header>
                <div>
                    <h1 class="text-xl font-bold my-2">Liste des bilans</h1>
                    <div class="flex flex-row items-center justify-between">
                        <Button label="Créer un bilan" severity="primary" @click="ouvrirCreateBilan"/>
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
                <template #body="{ data }">
                    <router-link :to="'/assos/' + asso +'/bilans/'+ data.id + '/finalises'" target="_blank" rel="noopener" v-if="data.enregistrement_finalises.length">
                        <Button label="Consulter" icon="pi pi-eye" outlined class="mr-2" severity="secondary"/>
                    </router-link>
                    <router-link :to="'/assos/' + asso +'/bilans/'+ data.id + '/edit'" target="_blank" rel="noopener">
                        <Button label="Éditer" icon="pi pi-pencil" outlined class="mr-2"/>
                    </router-link>
                    <Button label="Dupliquer" icon="pi pi-clone" outlined severity="contrast" class="mr-2" @click="confirmDuplicateBilan(data.id)"/>
                    <Button label="Supprimer" icon="pi pi-trash" outlined severity="danger" @click="confirmDeleteBilan(data.id)"/>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

