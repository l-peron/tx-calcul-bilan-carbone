<script setup>
    import Card from "primevue/card";
    import Button from "primevue/button";
    import {ref} from "vue";
    import QuestionCardComponent from "./QuestionCardComponent.vue";

    const props = defineProps(['formulaire'])

    const emit = defineEmits(['removeFormulaire', 'saveFormulaire']);

    function generateRef() {
        const ref = []
        for(const question of props.formulaire.questions) {
            ref.push({question, reponse: '0'})
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
        emit('saveFormulaire', props.formulaire.id, reponses.value)
    }

</script>

<template>
    <Card>
        <template #title>
            <div class="flex flex-row items-center justify-between">
                <h2 class="text-lg font-semibold my-0 mb-1">{{ formulaire.intitule }}</h2>
                <div>
                    <Button v-if="!editFormulaire" label="Éditer le formulaire" icon="pi pi-pencil" severity="warning" outlined @click="editFormulaire=true" class="mr-4"></Button>
                    <Button label="Retirer le formulaire" icon="pi pi-times" severity="danger" outlined @click="removeFormulaire"/>
                </div>

            </div>
        </template>
        <template #subtitle v-if="editFormulaire">
            <p class="m-0 mb-2">{{ formulaire.description }}</p>
        </template>
        <template #content v-if="editFormulaire">
            <div class="flex flex-col gap-6">
                <QuestionCardComponent v-model="reponses.find(r => r.question.id === question.id).reponse" :question="question" v-for="question in formulaire.questions" />
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

<style scoped>

</style>
