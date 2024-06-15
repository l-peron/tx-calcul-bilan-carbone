<script setup>
import Card from 'primevue/card';
import Button from "primevue/button";
import QuestionModalView from "../../pages/questions/QuestionModalView.vue";
import {useDialog} from "primevue/usedialog";
import {FormulaireService} from "../../services/FormulaireService.ts";
import {useConfirm} from "primevue/useconfirm";

const props = defineProps(['question']);
const emit = defineEmits(['removeQuestion']);
const dialog = useDialog();

const formulaireService = new FormulaireService();
const confirm = useConfirm()

function ouvrirModalQuestion(question = undefined){
    dialog.open(QuestionModalView, {
        props: { header: 'Modifier une question', modal: true},
        data: { question: props.question },
        onClose: () => {
        }
    });
}

function confirmDeleteQuestion() {
    confirm.require({
        message: 'Es-tu sûr de vouloir supprimer la question ?',
        header: 'Supprimer la question',
        icon: 'pi pi-exclamation-triangle',
        rejectLabel: 'Annuler',
        acceptLabel: 'Supprimer',
        accept: function() {
            emit('removeQuestion', props.question.id)
        },
    });
}
</script>

<template>
    <Card class="border border-emerald-800 border-solid">
        <template #title>
            <div class="flex flex-row items-center justify-between">
                <h1 class="text-lg font-bold my-0">{{ question.intitule }}</h1>
                <div class="flex flex-row items-center gap-2">
                    <h2 class="text-base font-semibold my-0">Variable:</h2>
                    <p class="text-base font-normal my-0">{{ question.variable }}</p>
                </div>
            </div>
        </template>
        <template #content>
            <div class="mb-4 flex flex-row items-center gap-2 flex-shrink">
                <h2 class="text-base font-semibold my-1">Description:</h2>
                <p class="text-base font-normal m-0">{{ question.description }}</p>
            </div>
            <h2 class="text-base font-semibold my-1 w-16">Réponse</h2>
            <p v-if="question.type === 'saisie'">Saisie numérique</p>
            <div v-else class="flex flex-wrap gap-4">
                <div v-for="reponse in question.donnees" class="p-2 gap-1 rounded-lg border border-solid border-emerald-800 shadow flex flex-row">
                    <p class="my-2 font-semibold">{{ reponse.intitule }}</p>
                    <p class="my-2">({{ reponse.valeur }} {{ reponse.unite }})</p>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-content-end gap-2">
                <Button type="button" label="Modifier" severity="warning" outlined @click="ouvrirModalQuestion"/>
                <Button type="button" label="Supprimer" severity="danger" outlined @click="confirmDeleteQuestion"/>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
