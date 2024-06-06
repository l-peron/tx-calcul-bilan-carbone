<script setup>
    import Textarea from "primevue/textarea";
    import InputText from "primevue/inputtext";
    import Dropdown from "primevue/dropdown";
    import Button from "primevue/button";
    import {inject, onMounted, ref} from "vue";
    import {useToast} from "primevue/usetoast";
    import { DonneeService} from "../../services/DonneeService.ts";
    import {useForm} from "vee-validate";
    import {array, object, string} from 'yup';
    import {FormulaireService, TypeFormulaire, TypeQuestion} from "../../services/FormulaireService.ts";
    import {useRoute} from "vue-router";
    import MultiSelect from "primevue/multiselect";
    import {map} from "lodash";

    const formulaireService = new FormulaireService();
    const donneeService = new DonneeService();
    const toast = useToast();
    const routes = useRoute();

    const dialogRef = inject('dialogRef');

    const formulaireId = routes.params.id;
    let questionId;

    const donnees = ref([]);
    let editMode = false;

    const types = map(TypeQuestion, (label, key) => {
        return { key, label };
    });

    const validationSchema = object({
        intitule: string().required(),
        description: string(),
        variable: string().required(),
        type: string().required(),
        donneesIds: array(),
    });

    const initialValues = {
        intitule: "",
        description: "",
        variable: "",
        type: "",
        donneesIds: []
    }

    const { handleSubmit, defineField, errors, setValues } = useForm({
        validationSchema, initialValues
    });

    const [intitule, intituleAttrs] = defineField('intitule', {
        validateOnModelUpdate: false,
    });
    const [description, descriptionAttrs] = defineField('description', {
        validateOnModelUpdate: false,
    });
    const [variable, variableAttrs] = defineField('variable', {
        validateOnModelUpdate: false,
    });
    const [type, typeAttrs] = defineField('type', {
        validateOnModelUpdate: false,
    });
    const [donneesIds, donneesIdsAttrs] = defineField('donneesIds', {
        validateOnModelUpdate: false,
    });


    onMounted(async() => {
        await getDonnees();
        if(dialogRef.value.data.question.id !== undefined) {
            setValues({
                ...dialogRef.value.data.question,
                donneesIds: dialogRef.value.data.question.donnees.map(d => d.id)
            });
            questionId = dialogRef.value.data.question.id;
            editMode = true;
        }
    });

    async function getDonnees() {
        donneeService.getDonnees().then(data => {
            donnees.value = data;
        });
    }

    const onSubmit = handleSubmit(values => {
        if(editMode) {
            formulaireService.updateFormulaireQuestion(formulaireId, questionId, values).then(() => {
                toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'La question a bien été modifiée (Actualise)', life: 5000 });
            });
        } else {
            formulaireService.createFormulaireQuestion(formulaireId, values).then(() => {
                toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'La question a bien été créée', life: 5000 });
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
            <InputText id="intitule" v-model="intitule" v-bind="intituleAttrs" :invalid="errors.intitule != null" class="flex-auto" placeholder="Titre de la question"/>
        </div>
        <div class="flex flex-col gap-3 mb-5">
            <label for="description" class="font-semibold w-6rem">Description</label>
            <Textarea id="description" v-model="description" v-bind="descriptionAttrs" rows="3" cols="30" placeholder="Description de la question"/>
        </div>
        <div class="flex flex-row gap-3">
            <div class="flex flex-col gap-3 mb-5">
                <label for="valeur" class="font-semibold w-6rem">Variable</label>
                <InputText id="valeur" v-model="variable" v-bind="variableAttrs" :invalid="errors.valeur != null" placeholder="nomVariable"/>
            </div>
            <div class="flex flex-col gap-3 mb-5">
                <label for="unite" class="font-semibold w-6rem">Type</label>
                <Dropdown id="type" v-model="type" v-bind="typeAttrs" :options="types" optionLabel="label" optionValue="key" placeholder="Sélectionner un type de réponse"/>
            </div>
        </div>
        <div v-if="type === 'unique'" class="flex flex-col gap-3 mb-5">
            <label for="donnees" class="font-semibold w-6rem">Réponses possibles</label>
            <MultiSelect v-model="donneesIds" v-bind="donneesIdsAttrs" :options="donnees" filter optionLabel="intitule" optionValue="id" placeholder="Choisir des réponses possibles"/>
        </div>
        <div class="flex justify-content-end gap-2">
            <Button type="button" label="Annuler" severity="danger" @click="cancel" outlined/>
            <Button type="submit" label="Appliquer" severity="primary"/>
        </div>
    </form>
</template>
