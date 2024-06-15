<script setup>
    const props = defineProps(['formulaire']);
</script>

<template>
    <div class="m-4 p-4 bg-emerald-50 shadow-md border border-solid border-emerald-800 rounded-2xl">
        <h2 class="my-1 text-lg font-semibold text-center">{{ props.formulaire.intitule}} - {{ props.formulaire.secteur }}</h2>
        <h4 class="my-1 italic text-center font-normal">Résultat du formulaire: {{props.formulaire.evaluation}} kgCO2</h4>
        <div v-for="question of props.formulaire.questions" class="my-4 mx-12 flex flex-row items-end justify-between p-2 border border-solid border-emerald-800 rounded-xl bg-white gap-12">
            <div>
                <h3 class="my-1 text-base font-semibold">{{question.intitule}}</h3>
                <p class="my-1 ">{{question.description}}</p>
            </div>
            <span
                class="my-1 font-semibold"
                v-if="question.type === 'unique'"
                :set="donnee = question.donnees.find(d => d.valeur === question.reponse)"
            >
                {{ donnee.intitule + ' (' + donnee.valeur + ' ' + donnee.unite + ')' }}
            </span>
            <span v-else class="my-1 font-semibold">{{question.reponse}}</span>
        </div>

    </div>

</template>
