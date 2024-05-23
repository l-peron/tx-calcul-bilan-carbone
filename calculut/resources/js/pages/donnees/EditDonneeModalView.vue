<script setup>
    import InputNumber from "primevue/inputnumber";
    import Textarea from "primevue/textarea";
    import InputText from "primevue/inputtext";
    import Dropdown from "primevue/dropdown";
    import Button from "primevue/button";
    import { inject } from "vue";
    import {onMounted, ref} from "vue";
    import {DonneeService} from "../../services/DonneeService.ts";
    import {useToast} from "primevue/usetoast";

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

    onMounted(() => {
        donnee.value = { ...dialogRef.value.data.donnee };
    })

    const metriques = ref([
        "CO2"
    ]);

    async function confirm() {
        donneeService.updateDonnee(donnee.value).then(() => {
            toast.add({ severity: 'info', summary: 'Confirmation', detail: 'La donnée a été modifiée', life: 3000 });
        });
        dialogRef.value.close();
    }

    function cancel() {
        dialogRef.value.close();
    }

    // TODO: Ajouter la liste des questions ou des formulaires affectés par ce changement.
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
        <Button type="button" label="Modifier" severity="success" @click="confirm"></Button>
    </div>
</template>

<style scoped>

</style>
