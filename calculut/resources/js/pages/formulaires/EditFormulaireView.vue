<script setup>
    import {onMounted, ref} from "vue";
    import {useRoute} from "vue-router";

    import {useToast} from "primevue/usetoast";

    import InputText from "primevue/inputtext";
    import Dropdown from "primevue/dropdown";
    import Button from "primevue/button";
    import Chips from 'primevue/chips';
    import Textarea from "primevue/textarea";
    import Checkbox from "primevue/checkbox";
    import {useDialog} from "primevue/usedialog";
    const dialog = useDialog();

    import {FormulaireService, TypeFormulaire} from "../../services/FormulaireService.ts";

    import CardQuestionComponent from "../../components/questions/CardQuestionComponent.vue";
    import {array, boolean, object, string} from "yup";
    import {useForm} from "vee-validate";
    import {parse, stringify} from "equation-parser";
    import Card from "primevue/card";
    import QuestionModalView from "../questions/QuestionModalView.vue";
    import {map} from "lodash";

    const toast = useToast();
    const routes = useRoute();

    const formulaireService = new FormulaireService();
    const formulaireId = routes.params.id;

    const questions = ref([]);

    const validationSchema = object({
        intitule: string().required(),
        description: string(),
        secteur: string().required(),
        formule: array(),
        publie: boolean().required(),
    });

    const initialValues = {
        intitule: "",
        description: "",
        secteur: "energie",
        formule: [],
        publie: false,
    }

    const { meta, handleSubmit, defineField, errors, setValues, setFieldValue } = useForm({
        validationSchema, initialValues
    });

    const [intitule, intituleAttrs] = defineField('intitule');
    const [description, descriptionAttrs] = defineField('description');
    const [secteur, secteurAttrs] = defineField('secteur');
    const [formule, formuleAttrs] = defineField('formule');
    const [publie, publieAttrs] = defineField('publie');

    const secteurs = map(TypeFormulaire, (label, key) => {
        return { key, label };
    });

    const operateurs = ["*", "-", "+", "/", "(", ")"];

    const variables = ref([]);

    onMounted(async() => {
        await getFormulaire();
    });

    async function getFormulaire(){
        await formulaireService.getFormulaire(formulaireId).then(data => {
            data.formule = data.formule == null ? [] : stringify(data.formule).split(' ')

            questions.value = data.questions
            variables.value = data.questions.map(q => q.variable);

            setValues(data);
        });
    }

    function ouvrirModalQuestion(question = undefined){
        dialog.open(QuestionModalView, {
            props: { header: 'Créer une question', modal: true},
            data: { question },
            onClose: () => {
                getFormulaire();
            }
        });
    }

    async function addToFormule(operateur){
        formule.value.push(operateur);
    }

    const onSubmit = handleSubmit(async values => {
        if(values.formule.length === 0) {
            values.formule = null;
        } else {
            values.formule = parse(values.formule.join(''));
        }
        await formulaireService.updateFormulaire(formulaireId, values).then(() => {
            toast.add({ severity: 'success', summary: 'Formulaire sauvegardé !', detail: 'Le formulaire a bien été sauvegardé', life: 5000 });
            getFormulaire();
        })
    });

    async function deleteQuestion(questionId) {
        await formulaireService.deleteFormulaireQuestion(formulaireId, questionId).then(() => {
            getFormulaire();
            setFieldValue('formule', []);
        });
    }
</script>

<template>
    <div class="bg-slate-100 h-full flex flex-col overflow-y-scroll">
        <form class="m-4" @submit="onSubmit">
            <Card class="mb-4">
                <template #title>
                    <div class="flex flex-row items-center justify-between">
                        <h1 class="text-xl font-bold">Modifier un formulaire</h1>
                        <div class="flex flex-row gap-2">
                            <Button type="submit" label="Sauvegarder" severity="primary" :disabled="!meta.valid"/>
                            <Button label="Supprimer" severity="danger" outlined />
                        </div>
                    </div>
                </template>
                <template #content>
                    <div class="flex flex-row items-center gap-16">
                        <div class="flex flex-col gap-3 mb-3 w-2/5">
                            <label for="intitule" class="font-semibold w-6rem">Nom du formulaire</label>
                            <InputText id="intitule" v-model="intitule" v-bind="intituleAttrs" :invalid="errors.intitule"/>
                        </div>
                        <div class="flex flex-col gap-3 mb-5 w-1/5">
                            <label for="secteur" class="font-semibold w-6rem">Secteur</label>
                            <Dropdown id="secteur" v-model="secteur" v-bind="secteurAttrs" :invalid="errors.secteur" :options="secteurs" optionLabel="label" optionValue="key" placeholder="Sélectionner un secteur"/>
                        </div>
                        <div class="flex flex-col gap-3 mb-5">
                            <label for="secteur" class="font-semibold w-6rem">Publié</label>
                            <Checkbox id="publie" v-model="publie" v-bind="publieAttrs" :binary="true" :invalid="errors.publie"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 mb-5">
                        <label for="description" class="font-semibold w-6rem">Description</label>
                        <Textarea id="description" v-model="description" v-bind="descriptionAttrs" rows="3" cols="30" :invalid="errors.description"/>
                    </div>
                </template>
            </Card>
            <Card class="mb-4">
                <template #title>
                    <h1 class="text-xl font-bold my-2">La formule</h1>
                </template>
                <template #content>
                    <div class="flex flex-row gap-4 my-2">
                        <p>Opérateurs: </p>
                        <Button v-for="operateur in operateurs" :key="operateur" :label="operateur" severity="primary" outlined @click="addToFormule(operateur)"/>
                    </div>
                    <div class="flex flex-row gap-4 my-2">
                        <p>Variables: </p>
                        <Button v-for="variable in variables" :key="variable" :label="variable" severity="primary" outlined @click="addToFormule(variable)"/>
                    </div>
                    <Chips v-model="formule" v-bind="formuleAttrs" class="my-2" :invalid="errors.formule"/>
                </template>
            </Card>
            <Card class="mb-4">
                <template #title>
                    <h1 class="text-xl font-bold my-2">Les questions</h1>
                </template>
                <template #content>
                    <CardQuestionComponent v-for="question in questions" :key="question.id" :question="question" class="my-6" @removeQuestion="deleteQuestion"></CardQuestionComponent>
                </template>
                <template #footer>
                    <Button label="Ajouter une question" severity="primary" @click="ouvrirModalQuestion"/>
                </template>
            </Card>
        </form>
    </div>
</template>
