<script setup>

import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import {inject, ref} from "vue";
import {FormulaireService, TypeFormulaire} from "../../services/FormulaireService.ts";
import {useToast} from "primevue/usetoast";
import {array, boolean, object, string} from "yup";
import {useForm} from "vee-validate";
import {map} from "lodash";
import {parse} from "equation-parser";
const dialogRef = inject('dialogRef');

const formulaireService = new FormulaireService();
const toast = useToast();

const validationSchema = object({
    intitule: string().required(),
    description: string(),
    secteur: string().required(),
});

const initialValues = {
    intitule: "",
    description: "",
    secteur: "energie",
}

const { meta, handleSubmit, defineField, errors } = useForm({
    validationSchema, initialValues
});

const [intitule, intituleAttrs] = defineField('intitule');
const [description, descriptionAttrs] = defineField('description');
const [secteur, secteurAttrs] = defineField('secteur');

const secteurs = map(TypeFormulaire, (label, key) => {
    return { key, label };
});

const onSubmit = handleSubmit(async values => {
    await formulaireService.createFormulaire(values).then(() => {
        toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'Le formulaire a bien été créée', life: 5000 });
    });
    dialogRef.value.close();
});

function cancel() {
    dialogRef.value.close();
}
</script>

<template>
    <form @submit="onSubmit">
        <div class="flex flex-col gap-3 mb-5">
            <label for="intitule" class="font-semibold w-6rem">Nom du formulaire</label>
            <InputText id="intitule" v-model="intitule" v-bind="intituleAttrs" :invalid="errors.intitule" placeholder="Titre du formulaire"/>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="description" class="font-semibold w-6rem">Description</label>
            <Textarea id="description" v-model="description" v-bind="descriptionAttrs" rows="3" cols="30" :invalid="errors.description" placeholder="Description du formulaire"/>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="secteur" class="font-semibold w-6rem">Secteur</label>
            <Dropdown id="secteur" v-model="secteur" v-bind="secteurAttrs" :invalid="errors.secteur" :options="secteurs" optionLabel="label" optionValue="key" placeholder="Sélectionner un secteur"/>
        </div>
        <div class="flex justify-content-end gap-2">
            <Button type="submit" label="Créer" severity="primary" :disabled="!meta.valid"/>
            <Button type="button" label="Annuler" severity="danger" @click="cancel" outlined/>
        </div>
    </form>
</template>
