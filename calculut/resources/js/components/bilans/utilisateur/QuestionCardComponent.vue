<script setup>
    import RadioButton from "primevue/radiobutton";
    import InputText from "primevue/inputtext";

    const props = defineProps(['question'])
    const model = defineModel()
</script>

<template>
    <div>
        <h3 class="text-base font-semibold my-2">{{ question.intitule }}</h3>
        <InputText v-model="model" placeholder="Création d'un bilan, ex: SDF P24" id="titreBilan" class="w-96" v-if="question.type  === 'saisie'"/>
        <div v-else class="flex flex-row gap-6">
            <div v-for="donnee in question.donnees" :key="donnee.id" class="flex align-items-center">
                <RadioButton v-model="model" :inputId="donnee.id" name="dynamic" :value="donnee.valeur" />
                <label :for="donnee.key" class="ml-2">{{ donnee.intitule }}</label>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
