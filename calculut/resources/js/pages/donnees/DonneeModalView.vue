<script setup>
    import InputNumber from "primevue/inputnumber";
    import Textarea from "primevue/textarea";
    import InputText from "primevue/inputtext";
    import Dropdown from "primevue/dropdown";
    import Button from "primevue/button";
    import {inject, onMounted, ref} from "vue";
    import {useToast} from "primevue/usetoast";
    import {DonneeService} from "../../services/DonneeService.ts";
    import {useForm} from "vee-validate";
    import {number, object, string} from 'yup';

    const donneeService = new DonneeService();

    const toast = useToast();
    const dialogRef = inject('dialogRef');

    let editMode = false;

    const metriques = ref([
        "CO2"
    ]);

    const validationSchema = object({
        intitule: string().required(),
        description: string(),
        valeur: number().required().positive(),
        unite: string().required(),
        metrique: string().required(),
        source: string().required()
    });

    const initialValues = {
        intitule: "",
        description: "",
        valeur: 0,
        unite: "",
        metrique: "CO2",
        source: ""
    }

    const { meta, handleSubmit, defineField, errors, setValues } = useForm({
        validationSchema, initialValues
    });

    const [intitule, intituleAttrs] = defineField('intitule');
    const [description, descriptionAttrs] = defineField('description');
    const [valeur, valeurAttrs] = defineField('valeur');
    const [unite, uniteAttrs] = defineField('unite');
    const [metrique, metriqueAttrs] = defineField('metrique');
    const [source, sourceAttrs] = defineField('source');

    onMounted(() => {
        if(dialogRef.value.data.donnee.id !== undefined) {
            setValues(dialogRef.value.data.donnee);
            editMode = true;
        }
    });

    const onSubmit = handleSubmit(values => {
        if(editMode) {
            donneeService.updateDonnee(values).then(() => {
                toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'La donnée a bien été modifiée', life: 5000 });
            });

        } else {
            donneeService.createDonnee(values).then(() => {
                toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'La donnée a bien été créée', life: 5000 });
            });
        }

        dialogRef.value.close();
    });

    function cancel() {
        dialogRef.value.close();
    }
</script>

<template>
    <form @submit="onSubmit">
        <div class="flex flex-col gap-3 mb-3">
            <label for="intitule" class="font-semibold w-6rem">Intitulé</label>
            <InputText id="intitule" v-model="intitule" v-bind="intituleAttrs" :invalid="errors.intitule != null" class="flex-auto" placeholder="Titre de la donnée"/>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="description" class="font-semibold w-6rem">Description</label>
            <Textarea id="description" v-model="description" v-bind="descriptionAttrs" rows="3" cols="30" placeholder="Description de la donnée"/>
        </div>
        <div class="flex flex-row gap-3">
            <div class="flex flex-col gap-3 mb-5">
                <label for="valeur" class="font-semibold w-6rem">Valeur</label>
                <InputNumber id="valeur" v-model="valeur" v-bind="valeurAttrs" :invalid="errors.valeur != null" class="flex-auto" :min="0" :maxFractionDigits="3"/>
            </div>
            <div class="flex flex-col gap-3 mb-5">
                <label for="unite" class="font-semibold w-6rem">Unité</label>
                <InputText id="unite" v-model="unite" v-bind="uniteAttrs" :invalid="errors.unite != null" class="flex-auto" placeholder="Exemple: kgCO2/km/p"/>
            </div>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="metrique" class="font-semibold w-6rem">Métrique</label>
            <Dropdown id="metrique" v-model="metrique" v-bind="metriqueAttrs" :invalid="errors.metrique != null" :options="metriques" placeholder="Sélectionne une métrique" class="w-full md:w-14rem" />
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="source" class="font-semibold w-6rem">Source</label>
            <Textarea id="source" v-model="source" v-bind="sourceAttrs" :invalid="errors.source != null" rows="3" cols="30" placeholder="Référence des sources"/>
        </div>
        <div class="flex justify-content-end gap-2">
            <Button type="submit" label="Appliquer" severity="primary" :disabled="!meta.valid"/>
            <Button type="button" label="Annuler" severity="danger" outlined @click="cancel"/>
        </div>
    </form>
</template>
