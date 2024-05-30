<script setup>
    import InputText from "primevue/inputtext";
    import Card from "primevue/card";
    import RadioButton from "primevue/radiobutton";
    import { Formulaire }  from "../services/FormulaireService.ts";
    import Button from "primevue/button";
    import {onMounted, ref} from "vue";

    const props = defineProps({
        formulaire: Formulaire
    })

    const emit = defineEmits(['enleverFormulaire']);

    function generateRef() {
        const ref = {}
        for(const question of props.formulaire.questions) {
            ref[question.id] = {question, reponse: '0'}
        }
        return ref;
    }

    const reponses = ref(generateRef())

    function enleverFormulaire() {
        console.log(reponses.value)
        emit('enleverFormulaire', props.formulaire.id)
    }

</script>

<template>
    <Card>
        <template #title>
            <div class="flex flex-row items-center justify-between">
                <h2 class="text-lg font-semibold my-0 mb-1">{{ formulaire.intitule }}</h2>
                <Button label="Enlever le formulaire" icon="pi pi-times" severity="danger" outlined @click="enleverFormulaire"/>
            </div>
        </template>
        <template #subtitle>
            <p class="m-0 mb-2">{{ formulaire.description }}</p>
        </template>
        <template #content>
            <div class="flex flex-col gap-6">
                <div v-for="question in formulaire.questions">
                    <div>
                        <h3 class="text-base font-semibold my-2">{{ question.intitule }}</h3>
                        <InputText v-model="reponses[question.id].reponse" placeholder="Création d'un bilan, ex: SDF P24" id="titreBilan" class="w-96" v-if="question.type  === 'saisie'"/>
                        <div v-else class="flex flex-row gap-6">
                            <div v-for="donnee in question.donnees" :key="donnee.id" class="flex align-items-center">
                                <RadioButton v-model="reponses[question.id].reponse" :inputId="donnee.id" name="dynamic" :value="donnee.intitule" />
                                <label :for="donnee.key" class="ml-2">{{ donnee.intitule }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<style scoped>

</style>
