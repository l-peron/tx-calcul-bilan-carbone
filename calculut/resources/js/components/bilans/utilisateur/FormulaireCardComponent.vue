<script setup>
    import Card from "primevue/card";
    import Button from "primevue/button";
    import {onMounted, ref} from "vue";
    import QuestionCardComponent from "./QuestionCardComponent.vue";
    import {FormulaireService} from "../../../services/FormulaireService.ts";

    const props = defineProps(['formulaire']);

    const emit = defineEmits(['removeFormulaire', 'saveFormulaire']);

    const formulaireService = new FormulaireService();
    const updatable = ref(false);
    const formulaireDisplayed = ref(props.formulaire);
    const formulaireFetched = ref({});

    function generateRef() {
        const ref = {}
        for(const question of formulaireDisplayed.value.questions) {
            ref[question.id] = {
                ...question,
                reponse: question.reponse ? question.reponse : question.type === 'saisie' ? 0 : question.donnees[0].id
            }
        }
        return ref;
    }

    const editFormulaire = ref(true)
    const reponses = ref(generateRef())

    function removeFormulaire() {
        emit('removeFormulaire', props.formulaire.id)
    }

    function saveFormulaire() {
        editFormulaire.value = false
        emit('saveFormulaire', props.formulaire.id, reponses.value, formulaireFetched.value === formulaireDisplayed.value)
    }

    onMounted(async() => {
        await formulaireService.getFormulaire(props.formulaire.id).then(data => {
            if(props.formulaire.updated_at !== data.updated_at) {
                formulaireFetched.value = data;
                updatable.value = true;
            }
        })
    });

    function updateFormulaire() {
        formulaireDisplayed.value = formulaireFetched.value;
        reponses.value = generateRef()
        updatable.value = false;
    }
</script>

<template>
    <Card class="overflow-hidden">
        <template #header v-if="updatable">
            <div class="flex flex-row justify-between items-center px-8 py-4 bg-orange-50 border-b-orange-400 border-0 border-b border-solid">
                <div class="flex flex-row gap-2 items-center">
                    <i class="pi pi-exclamation-circle font-medium text-orange-400"/>
                    <p class="m-0 text-orange-400">Le formulaire a été mis à jour par le BDE, souhaitez-vous le mettre à jour ?</p>
                </div>
                <div class="flex flex-row">
                    <Button label="Mettre à jour" link class="text-slate-600" @click="updateFormulaire"/>
                    <Button label="Continuer" link class="text-slate-600" @click="updatable=false"/>
                </div>
            </div>
        </template>

        <template #title>
            <div class="flex flex-row items-center justify-between">
                <h2 class="text-lg font-semibold my-0 mb-1">{{ formulaireDisplayed.intitule }}</h2>
                <div>
                    <Button v-if="!editFormulaire" label="Éditer le formulaire" icon="pi pi-pencil" severity="warning" outlined @click="editFormulaire=true" class="mr-4"/>
                    <Button label="Retirer le formulaire" icon="pi pi-times" severity="danger" outlined @click="removeFormulaire"/>
                </div>
            </div>
        </template>
        <template #subtitle v-if="editFormulaire">
            <p class="m-0 mb-2">{{ formulaireDisplayed.description }}</p>
        </template>
        <template #content v-if="editFormulaire">
            <div class="flex flex-col gap-6">
                <QuestionCardComponent v-model="reponses[question.id].reponse" :question="question" v-for="question in formulaireDisplayed.questions" />
            </div>
        </template>
        <template #footer v-if="editFormulaire">
            <div class="flex flex-row items-center justify-between">
                <span class="text-sm italic">Pense à enregistrer ta réponse, sinon elle ne sera pas sauvegardée avec le bilan.</span>
                <Button label="Enregistrer la réponse au formulaire" icon="pi pi-check" severity="primary" outlined @click="saveFormulaire"/>
            </div>
        </template>
    </Card>
</template>
