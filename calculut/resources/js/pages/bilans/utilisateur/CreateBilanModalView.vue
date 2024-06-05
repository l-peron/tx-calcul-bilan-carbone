<script setup>
    import InputText from "primevue/inputtext";
    import Button from "primevue/button";
    import {inject, ref} from "vue";
    import {useToast} from "primevue/usetoast";
    import { BilanService} from "../../../services/BilanService.ts";
    import {useRouter} from "vue-router";
    import Calendar from "primevue/calendar";

    const toast = useToast();
    const router = useRouter();
    const dialogRef = inject('dialogRef');

    const bilanService = new BilanService();

    const asso = router.currentRoute.value.path.split("/")[2]

    const bilan = ref({
        intitule: "",
        debut: "",
        fin: ""
    });

    const metriques = ref([
        "CO2"
    ]);

    async function confirm() {
        bilanService.createBilan(bilan.value.intitule, asso).then(bilan => {
            toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'Le bilan a bien été créée', life: 5000 });
            router.push(`/assos/${bilan.asso}/bilans/${bilan.id}/edit`);
        });
        dialogRef.value.close();
    }

    function cancel() {
        dialogRef.value.close();
    }
</script>

<template>
    <div class="flex flex-col gap-3 mb-3">
        <label for="intitule" class="font-semibold w-6rem">Titre du bilan</label>
        <InputText id="intitule" v-model="bilan.intitule" class="flex-auto"/>
    </div>
    <div class="flex flex-col gap-3 mb-3">
        <label for="dateDebut" class="font-bold block mb-2">Date de début</label>
        <Calendar v-model="bilan.debut" showIcon iconDisplay="input" inputId="dateDebut" />
    </div>
    <div class="flex flex-col gap-3 mb-3">
        <label for="dateDebut" class="font-bold block mb-2">Date de début</label>
        <Calendar v-model="bilan.debut" showIcon iconDisplay="input" inputId="dateDebut" />
    </div>

    <div class="flex justify-content-end gap-2">
        <Button type="button" label="Annuler" severity="danger" @click="cancel"></Button>
        <Button type="button" label="Créer" severity="success" @click="confirm"></Button>
    </div>
</template>

<style scoped>

</style>
