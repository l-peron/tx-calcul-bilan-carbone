<script setup>
    import InputNumber from "primevue/inputnumber";
    import Textarea from "primevue/textarea";
    import InputText from "primevue/inputtext";
    import Dropdown from "primevue/dropdown";
    import Button from "primevue/button";
    import {inject, ref} from "vue";
    import {useToast} from "primevue/usetoast";
    import {DonneeService} from "../../services/DonneeService.ts";

    const toast = useToast();
    const dialogRef = inject('dialogRef');

    const donneeService = new DonneeService();

    const donnee = ref({
        intitule: "",
        description: "",
        valeur: 0,
        unite: "",
        metrique: "",
        source: ""
    });

    const metriques = ref([
        "CO2"
    ]);

    async function confirm() {
        donneeService.createDonnee(donnee.value).then(() => {
            toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'La donnée a bien été créée', life: 5000 });
        });
        dialogRef.value.close();
    }

    function cancel() {
        dialogRef.value.close();
    }
</script>

<template>
    <div class="flex flex-col gap-3 mb-3">
        <label for="intitule" class="font-semibold w-6rem">Intitulé</label>
        <InputText id="intitule" v-model="donnee.intitule" class="flex-auto"/>
    </div>
    <div class="flex flex-col gap-3 mb-5">
        <label for="description" class="font-semibold w-6rem">Description</label>
        <Textarea id="description" v-model="donnee.description" rows="3" cols="30" />
    </div>
    <div class="flex flex-row gap-3">
        <div class="flex flex-col gap-3 mb-5">
            <label for="valeur" class="font-semibold w-6rem">Valeur</label>
            <InputNumber id="valeur" v-model="donnee.valeur" class="flex-auto" :min="0" :maxFractionDigits="3"/>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="unite" class="font-semibold w-6rem">Unité</label>
            <InputText id="unite" v-model="donnee.unite" class="flex-auto" />
        </div>
    </div>
    <div class="flex flex-col gap-3 mb-5">
        <label for="metrique" class="font-semibold w-6rem">Métrique</label>
        <Dropdown id="metrique" v-model="donnee.metrique" :options="metriques" placeholder="Sélectionner une métrique" class="w-full md:w-14rem" />
    </div>
    <div class="flex flex-col gap-3 mb-5">
        <label for="source" class="font-semibold w-6rem">Source</label>
        <Textarea id="source" v-model="donnee.source" rows="3" cols="30"/>
    </div>
    <div class="flex justify-content-end gap-2">
        <Button type="button" label="Annuler" severity="danger" @click="cancel"></Button>
        <Button type="button" label="Créer" severity="success" @click="confirm"></Button>
    </div>
</template>

<style scoped>

</style>
